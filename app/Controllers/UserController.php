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
        
        // Set pagination configuration
        $pager = \Config\Services::pager();
        
        // Get current page from the request, default to 1 if not set
        $page = $this->request->getGet('page') ?? 1;
        
        // Get entries per page (default to 10 if not set)
        // Cast to integer to avoid type errors in the limit() method
        $perPage = (int)($this->request->getGet('entries') ?? 10);
        
        // Get role filter (if any)
        $roleFilter = $this->request->getGet('role');
        
        // Get search term (if any)
        $search = $this->request->getGet('search');
        
        // Get sort field and direction
        $sortField = $this->request->getGet('sort') ?? 'updated_at';
        $sortDir = $this->request->getGet('dir') ?? 'desc';
        
        // Validate sort field to prevent SQL injection
        $validSortFields = [
            'user_name', 
            'user_fullname', 
            'user_phone', 
            'updated_at',
            'created_at'
        ];
        
        if (!in_array($sortField, $validSortFields)) {
            $sortField = 'updated_at';
        }
        
        // Validate sort direction
        if (!in_array($sortDir, ['asc', 'desc'])) {
            $sortDir = 'desc';
        }
        
        // Get current user ID
        $currentUserId = session()->get('user_id');
        
        // Base query - exclude the current user from the results
        $query = $this->userModel
            ->where('user_status', 'active')
            ->where('user_id !=', $currentUserId);
        
        // Apply role filter if set
        if ($roleFilter && in_array($roleFilter, ['admin', 'staff'])) {
            $query = $query->where('user_role', $roleFilter);
        }
        
        // Apply search filter if set
        if ($search) {
            $query = $query->groupStart()
                    ->like('user_name', $search)
                    ->orLike('user_fullname', $search)
                    ->orLike('user_phone', $search)
                    ->groupEnd();
        }
        
        // Get total count based on filters
        $totalUsers = $query->countAllResults(false);
        
        // Add sorting
        $query = $query->orderBy($sortField, $sortDir);
        
        // Get paginated users based on filters
        $users = $query
                ->limit($perPage, ($page - 1) * $perPage)
                ->find();
        
        // Create pager links
        $pager->setPath('admin/users');
        
        // Get newly created or updated user IDs from flash data
        $newUserId = session()->getFlashdata('new_user_id');
        $updatedUserId = session()->getFlashdata('updated_user_id');
        
        // Pass users data and pager to the view
        return view('admin/users/users_index', [
            'users' => $users,
            'pager' => $pager,
            'currentPage' => $page,
            'perPage' => $perPage,
            'total' => $totalUsers,
            'roleFilter' => $roleFilter,
            'search' => $search,
            'sortField' => $sortField,
            'sortDir' => $sortDir,
            'newUserId' => $newUserId,
            'updatedUserId' => $updatedUserId
        ]);
    }
    
    // The rest of the controller methods remain unchanged
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

        // Periksa apakah username sudah ada (untuk user yang aktif)
        $existingUsername = $this->userModel->where('user_name', $this->request->getPost('username'))
                                           ->where('user_status', 'active')
                                           ->first();
                                        
        if ($existingUsername) {
            return redirect()->back()->withInput()->with('errors', ['username' => 'Username is already in use by an active user.']);
        }

        // Periksa apakah nomor telepon sudah ada (untuk user yang aktif)
        $phone = $this->request->getPost('phone');
        if (!empty($phone)) {
            $existingPhone = $this->userModel->where('user_phone', $phone)
                                           ->where('user_status', 'active')
                                           ->first();
                                        
            if ($existingPhone) {
                return redirect()->back()->withInput()->with('errors', ['phone' => 'Phone number is already in use by an active user.']);
            }
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
        
        // Set default photo name based on user role
        $role = $this->request->getPost('role');
        $photoName = ($role === 'admin') ? 'default_admin.png' : 'default_staff.png';

        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            // Generate a random string for the filename to avoid conflicts
            $randomStr = bin2hex(random_bytes(8)); // 16 character random string
            $newName = $userId . '_' . $randomStr . '.' . $photo->getExtension();
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
            'user_role' => $role,
            'user_status' => 'active', // Automatically set status to active
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->userModel->insert($data);
        session()->setFlashdata('success', 'User successfully added');
        session()->setFlashdata('new_user_id', $userId);
        return redirect()->to('admin/users');
    }

    public function edit($id)
    {
        if (!session()->get('logged_in') || session()->get('user_role') != 'admin') {
            return redirect()->to('login');
        }
        
        $data['user'] = $this->userModel->find($id);
        
        if (!$data['user']) {
            session()->setFlashdata('error', 'User not found');
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
            session()->setFlashdata('error', 'User not found');
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

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Periksa apakah username sudah ada (untuk user lain yang aktif)
        if ($this->request->getPost('username') !== $user['user_name']) {
            $existingUsername = $this->userModel->where('user_name', $this->request->getPost('username'))
                                               ->where('user_status', 'active')
                                               ->where('user_id !=', $id)
                                               ->first();
                                            
            if ($existingUsername) {
                return redirect()->back()->withInput()->with('errors', ['username' => 'Username is already in use by another active user.']);
            }
        }

        // Periksa apakah nomor telepon sudah ada (untuk user lain yang aktif)
        $phone = $this->request->getPost('phone');
        if (!empty($phone) && $phone !== $user['user_phone']) {
            $existingPhone = $this->userModel->where('user_phone', $phone)
                                           ->where('user_status', 'active')
                                           ->where('user_id !=', $id)
                                           ->first();
                                        
            if ($existingPhone) {
                return redirect()->back()->withInput()->with('errors', ['phone' => 'Phone number is already in use by another active user.']);
            }
        }

        $role = $this->request->getPost('role');
        
        $data = [
            'user_name' => $this->request->getPost('username'),
            'user_fullname' => $this->request->getPost('fullname'),
            'user_phone' => $this->request->getPost('phone'),
            'user_role' => $role,
            'user_status' => $this->request->getPost('status'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Upload photo if available
        $photo = $this->request->getFile('photo');
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            // Generate a random string for the filename to avoid conflicts
            $randomStr = bin2hex(random_bytes(8)); // 16 character random string
            $newName = $user['user_id'] . '_' . $randomStr . '.' . $photo->getExtension();
            
            $photo->move(ROOTPATH . 'public/uploads/users', $newName);
            $data['user_photo'] = $newName;
            
            // Delete old photo if not default
            if ($user['user_photo'] != 'default_admin.png' && $user['user_photo'] != 'default_staff.png' && 
                file_exists(ROOTPATH . 'public/uploads/users/' . $user['user_photo'])) {
                unlink(ROOTPATH . 'public/uploads/users/' . $user['user_photo']);
            }
        } else if ($user['user_role'] != $role) {
            // If role changed and no new photo uploaded, update to appropriate default photo
            $data['user_photo'] = ($role === 'admin') ? 'default_admin.png' : 'default_staff.png';
        }

        // Update password if needed
        if ($this->request->getPost('password') != '') {
            $data['user_password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $data);
        session()->setFlashdata('success', 'User successfully updated');
        session()->setFlashdata('updated_user_id', $id);
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
            session()->setFlashdata('error', 'User not found');
            return redirect()->to('admin/users');
        }

        // Don't allow deletion of the currently logged-in user
        if ($user['user_id'] == session()->get('user_id')) {
            session()->setFlashdata('error', 'Cannot inactivate the account currently in use');
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
        session()->setFlashdata('success', 'User successfully inactivated');
        return redirect()->to('admin/users');
    }
}