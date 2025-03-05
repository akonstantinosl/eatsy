<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class ProfileController extends BaseController
{
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    
    public function edit()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }
        
        $userId = session()->get('user_id');
        $data['user'] = $this->userModel->find($userId);
        
        if (!$data['user']) {
            session()->setFlashdata('error', 'User profile not found');
            
            // Redirect based on user role
            if (session()->get('user_role') == 'admin') {
                return redirect()->to('admin/dashboard');
            } else {
                return redirect()->to('staff/dashboard');
            }
        }
        
        // Determine which layout to use based on user role
        if (session()->get('user_role') == 'admin') {
            return view('admin/profile/profile_edit', $data);
        } else {
            return view('staff/profile/profile_edit', $data);
        }
    }
    
    public function update()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }

        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            session()->setFlashdata('error', 'User profile not found');
            
            // Redirect based on user role
            if (session()->get('user_role') == 'admin') {
                return redirect()->to('admin/dashboard');
            } else {
                return redirect()->to('staff/dashboard');
            }
        }

        // Define validation rules
        $rules = [
            'username' => 'required|min_length[3]',
            'fullname' => 'required',
            'phone' => 'permit_empty|numeric|min_length[10]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Check if username already exists for another active user
        if ($this->request->getPost('username') !== $user['user_name']) {
            $existingUsername = $this->userModel->where('user_name', $this->request->getPost('username'))
                                              ->where('user_status', 'active')
                                              ->where('user_id !=', $userId)
                                              ->first();
                                          
            if ($existingUsername) {
                return redirect()->back()->withInput()->with('errors', ['username' => 'Username is already in use by another active user.']);
            }
        }

        // Check if phone number already exists for another active user
        $phone = $this->request->getPost('phone');
        if (!empty($phone) && $phone !== $user['user_phone']) {
            $existingPhone = $this->userModel->where('user_phone', $phone)
                                          ->where('user_status', 'active')
                                          ->where('user_id !=', $userId)
                                          ->first();
                                      
            if ($existingPhone) {
                return redirect()->back()->withInput()->with('errors', ['phone' => 'Phone number is already in use by another active user.']);
            }
        }
        
        $data = [
            'user_name' => $this->request->getPost('username'),
            'user_fullname' => $this->request->getPost('fullname'),
            'user_phone' => $this->request->getPost('phone'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Upload photo if available
        $photo = $this->request->getFile('photo');
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            $randomStr = bin2hex(random_bytes(8)); // 16 character random string
            $newName = $user['user_id'] . '_' . $randomStr . '.' . $photo->getExtension();
            $photo->move(ROOTPATH . 'public/uploads/users', $newName);
            $data['user_photo'] = $newName;
            
            // Delete old photo if not default
            if ($user['user_photo'] != 'default_admin.png' && $user['user_photo'] != 'default_staff.png' && 
                file_exists(ROOTPATH . 'public/uploads/users/' . $user['user_photo'])) {
                unlink(ROOTPATH . 'public/uploads/users/' . $user['user_photo']);
            }
        }

        // Update password if provided
        if ($this->request->getPost('password') != '') {
            $data['user_password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->userModel->update($userId, $data);
        
        // Update session data
        session()->set('user_name', $data['user_name']);
        session()->set('user_fullname', $data['user_fullname']);
        if (isset($data['user_photo'])) {
            session()->set('user_photo', $data['user_photo']);
        }
        
        session()->setFlashdata('success', 'Your profile has been successfully updated');
        
        // Redirect based on user role
        if (session()->get('user_role') == 'admin') {
            return redirect()->to('admin/dashboard');
        } else {
            return redirect()->to('staff/dashboard');
        }
    }
}