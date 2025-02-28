<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    
    public function index()
    {
        return view('landing_page');
    }
    
    public function loginPage()
    {
        if (session()->get('logged_in')) {
            return redirect()->to(base_url(session()->get('user_role') == 'admin' ? 'admin/dashboard' : 'staff/dashboard'));
        }
        return view('auth/login');
    }
    
    public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        $user = $this->userModel->where('user_name', $username)->first();
        
        if ($user && password_verify($password, $user['user_password'])) {
            $sessionData = [
                'user_id' => $user['user_id'],
                'user_name' => $user['user_name'],
                'user_role' => $user['user_role'],
                'logged_in' => TRUE
            ];
            
            session()->set($sessionData);
            
            if ($user['user_role'] == 'admin') {
                return redirect()->to(base_url('admin/dashboard'));
            } else {
                return redirect()->to(base_url('staff/dashboard'));
            }
        } else {
            session()->setFlashdata('error', 'Username atau Password salah');
            return redirect()->to(base_url('login'));
        }
    }
    
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}