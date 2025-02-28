<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CustomerModel;

class CustomerController extends BaseController
{
    protected $customerModel;

    public function __construct()
    {
        $this->customerModel = new CustomerModel();
    }

    public function index()
    {
        $data['customers'] = $this->customerModel->findAll();
        return view('admin/customers/index', $data);
    }

    public function create()
    {
        return view('admin/customers/create');
    }

    public function store()
    {
        $rules = [
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'phone' => 'required|numeric|min_length[10]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone')
        ];

        $this->customerModel->insert($data);
        session()->setFlashdata('success', 'Customer added successfully');
        return redirect()->to('/admin/customers');
    }

    public function edit($id)
    {
        $data['customer'] = $this->customerModel->find($id);
        return view('admin/customers/edit', $data);
    }

    public function update($id)
    {
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone')
        ];

        $this->customerModel->update($id, $data);
        session()->setFlashdata('success', 'Customer updated successfully');
        return redirect()->to('/admin/customers');
    }

    public function delete($id)
    {
        $this->customerModel->delete($id);
        session()->setFlashdata('success', 'Customer deleted successfully');
        return redirect()->to('/admin/customers');
    }
}
