<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    
    public function index()
    {
        if (!session()->get('logged_in') || session()->get('user_role') != 'admin') {
            return redirect()->to('login');
        }
        
        // Get only active users
        $data['users'] = $this->userModel->where('user_status', 'active')->findAll();
        
        return view('admin/users/users_index', $data);
    }
    
    
    public function create()
    {
        if (!session()->get('logged_in') || session()->get('user_role') != 'admin') {
            return redirect()->to('login');
        }
        
        return view('admin/users/users_create');
    }

    public function store()
    {
        if (!session()->get('logged_in') || session()->get('user_role') != 'admin') {
            return redirect()->to('login');
        }
        
        // Define validation rules
        $rules = [
            'username' => 'required|min_length[3]',
            'password' => 'required|min_length[6]',
            'fullname' => 'required',
            'phone' => 'permit_empty|numeric|min_length[10]',
            'role' => 'required|in_list[admin,staff]',
            'status' => 'required|in_list[active,inactive]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Check if phone number exists for active users (ignoring inactive ones)
        $existingUser = $this->userModel->where('user_phone', $this->request->getPost('phone'))
                                        ->where('user_status', 'active')
                                        ->first();

        if ($existingUser) {
            return redirect()->back()->withInput()->with('errors', ['phone' => 'Phone number is already in use by an active user.']);
        }

        // Generate user ID
        $lastUser = $this->userModel->orderBy('user_id', 'DESC')->first();
        $lastNumber = 0;

        if ($lastUser) {
            preg_match('/USR(\d+)/', $lastUser['user_id'], $matches);
            if (isset($matches[1])) {
                $lastNumber = (int)$matches[1];
            }
        }

        $newNumber = $lastNumber + 1;
        $userId = 'USR' . str_pad($newNumber, 6, '0', STR_PAD_LEFT);

        // Upload photo if available
        $photo = $this->request->getFile('photo');
        $photoName = 'default.png';

        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            $newName = $userId . '.' . $photo->getExtension();
            $photo->move(ROOTPATH . 'public/uploads/users', $newName);
            $photoName = $newName;
        }

        $data = [
            'user_id' => $userId,
            'user_name' => $this->request->getPost('username'),
            'user_password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'user_fullname' => $this->request->getPost('fullname'),
            'user_phone' => $this->request->getPost('phone'),
            'user_photo' => $photoName,
            'user_role' => $this->request->getPost('role'),
            'user_status' => $this->request->getPost('status'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->userModel->insert($data);
        session()->setFlashdata('success', 'User berhasil ditambahkan');
        return redirect()->to('admin/users');
    }


    public function edit($id)
    {
        if (!session()->get('logged_in') || session()->get('user_role') != 'admin') {
            return redirect()->to('login');
        }
        
        $data['user'] = $this->userModel->find($id);
        
        if (!$data['user']) {
            session()->setFlashdata('error', 'User tidak ditemukan');
            return redirect()->to('admin/users');
        }
        
        return view('admin/users/users_edit', $data);
    }
    
    public function update($id)
    {
        if (!session()->get('logged_in') || session()->get('user_role') != 'admin') {
            return redirect()->to('login');
        }

        $user = $this->userModel->find($id);

        if (!$user) {
            session()->setFlashdata('error', 'User tidak ditemukan');
            return redirect()->to('admin/users');
        }

        // Define validation rules
        $rules = [
            'username' => 'required|min_length[3]',
            'fullname' => 'required',
            'phone' => 'permit_empty|numeric|min_length[10]',
            'role' => 'required|in_list[admin,staff]',
            'status' => 'required|in_list[active,inactive]'
        ];

        // Check if phone number exists for active users (ignoring inactive ones)
        if ($this->request->getPost('phone') != $user['user_phone']) {
            $existingUser = $this->userModel->where('user_phone', $this->request->getPost('phone'))
                                            ->where('user_status', 'active')
                                            ->first();

            if ($existingUser) {
                return redirect()->back()->withInput()->with('errors', ['phone' => 'Phone number is already in use by an active user.']);
            }
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'user_name' => $this->request->getPost('username'),
            'user_fullname' => $this->request->getPost('fullname'),
            'user_phone' => $this->request->getPost('phone'),
            'user_role' => $this->request->getPost('role'),
            'user_status' => $this->request->getPost('status'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Upload photo if available
        $photo = $this->request->getFile('photo');
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            $newName = $user['user_id'] . '.' . $photo->getExtension();
            $photo->move(ROOTPATH . 'public/uploads/users', $newName);
            $data['user_photo'] = $newName;
            
            // Delete old photo if not default
            if ($user['user_photo'] != 'default.png' && file_exists(ROOTPATH . 'public/uploads/users/' . $user['user_photo'])) {
                unlink(ROOTPATH . 'public/uploads/users/' . $user['user_photo']);
            }
        }

        // Update password if needed
        if ($this->request->getPost('password') != '') {
            $data['user_password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $data);
        session()->setFlashdata('success', 'User berhasil diperbarui');
        return redirect()->to('admin/users');
    }
    
    public function delete($id)
{
    if (!session()->get('logged_in') || session()->get('user_role') != 'admin') {
        return redirect()->to('login');
    }

    // Find the user by their ID
    $user = $this->userModel->find($id);

    if (!$user) {
        session()->setFlashdata('error', 'User tidak ditemukan');
        return redirect()->to('admin/users');
    }

    // Don't allow deletion of the currently logged-in user
    if ($user['user_id'] == session()->get('user_id')) {
        session()->setFlashdata('error', 'Tidak dapat menghapus akun yang sedang digunakan');
        return redirect()->to('admin/users');
    }

    // Set the user status to inactive instead of deleting the user
    $data = [
        'user_status' => 'inactive',
        'updated_at' => date('Y-m-d H:i:s')
    ];

    // Update the user's status to inactive
    $this->userModel->update($id, $data);

    // Set a success message
    session()->setFlashdata('success', 'User berhasil dinonaktifkan');
    return redirect()->to('admin/users');
}

}