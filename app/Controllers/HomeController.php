<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        return view('landing_page');
    }
    
    public function adminDashboard()
    {
        if (!session()->get('logged_in') || session()->get('user_role') != 'admin') {
            return redirect()->to('login');
        }
        
        return view('admin/admin_dashboard');
    }
    
    public function staffDashboard()
    {
        if (!session()->get('logged_in') || session()->get('user_role') != 'staff') {
            return redirect()->to('login');
        }
        
        return view('staff/staff_dashboard');
    }
}