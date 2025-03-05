<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SupplierModel;

class SupplierController extends BaseController
{
    protected $supplierModel;

    public function __construct()
    {
        $this->supplierModel = new SupplierModel();
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
        
        // Get search term (if any)
        $search = $this->request->getGet('search');
        
        // Base query
        $query = $this->supplierModel->where('supplier_status', 'active');
        
        // Apply search filter if set
        if ($search) {
            $query = $query->groupStart()
                    ->like('supplier_name', $search)
                    ->orLike('supplier_phone', $search)
                    ->groupEnd();
        }
        
        // Get total count based on filters
        $totalSuppliers = $query->countAllResults(false);
        
        // Get paginated suppliers
        $suppliers = $query
                   ->limit($perPage, ($page - 1) * $perPage)
                   ->find();
        
        // Create pager links
        $pager->setPath('admin/suppliers');
        
        // Pass suppliers data and pager to the view
        return view('admin/suppliers/suppliers_index', [
            'suppliers' => $suppliers,
            'pager' => $pager,
            'currentPage' => $page,
            'perPage' => $perPage,
            'total' => $totalSuppliers,
            'search' => $search
        ]);
    }

    public function create()
    {
        if (!session()->get('logged_in') || session()->get('user_role') != 'admin') {
            return redirect()->to('login');
        }

        return view('admin/suppliers/suppliers_create');
    }

    public function store()
    {
        if (!session()->get('logged_in') || session()->get('user_role') != 'admin') {
            return redirect()->to('login');
        }

        // Define validation rules
        $rules = [
            'supplier_name' => 'required',
            'supplier_phone' => 'required|numeric|min_length[10]',
            'supplier_address' => 'required',
            'supplier_status' => 'required|in_list[active,inactive]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Check if the phone number  already exists for active suppliers
        $existingSupplier = $this->supplierModel
            ->where('supplier_phone', $this->request->getPost('supplier_phone'))
            ->where('supplier_status', 'active')
            ->first();

        if ($existingSupplier) {
            return redirect()->back()->withInput()->with('errors', ['supplier_phone' => 'Phone number is already in use by an active supplier.']);
        }

        // Generate supplier ID
        $lastSupplier = $this->supplierModel->orderBy('supplier_id', 'DESC')->first();
        $lastNumber = 0;

        if ($lastSupplier) {
            preg_match('/SUP(\d+)/', $lastSupplier['supplier_id'], $matches);
            if (isset($matches[1])) {
                $lastNumber = (int)$matches[1];
            }
        }

        $newNumber = $lastNumber + 1;
        $supplierId = 'SUP' . str_pad($newNumber, 6, '0', STR_PAD_LEFT);

        // Prepare data for insertion
        $data = [
            'supplier_id' => $supplierId,
            'supplier_name' => $this->request->getPost('supplier_name'),
            'supplier_phone' => $this->request->getPost('supplier_phone'),
            'supplier_address' => $this->request->getPost('supplier_address'),
            'supplier_status' => $this->request->getPost('supplier_status'),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $this->supplierModel->insert($data);
        session()->setFlashdata('success', 'Supplier berhasil ditambahkan');
        return redirect()->to('admin/suppliers');
    }

    public function edit($id)
    {
        if (!session()->get('logged_in') || session()->get('user_role') != 'admin') {
            return redirect()->to('login');
        }

        $data['supplier'] = $this->supplierModel->find($id);

        if (!$data['supplier']) {
            session()->setFlashdata('error', 'Supplier tidak ditemukan');
            return redirect()->to('admin/suppliers');
        }

        return view('admin/suppliers/suppliers_edit', $data);
    }

    public function update($id)
    {
        if (!session()->get('logged_in') || session()->get('user_role') != 'admin') {
            return redirect()->to('login');
        }

        $supplier = $this->supplierModel->find($id);

        if (!$supplier) {
            session()->setFlashdata('error', 'Supplier tidak ditemukan');
            return redirect()->to('admin/suppliers');
        }

        // Define validation rules
        $rules = [
            'supplier_name' => 'required',
            'supplier_phone' => 'required|numeric|min_length[10]',
            'supplier_address' => 'required',
            'supplier_status' => 'required|in_list[active,inactive]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Check if phone number exists for other active suppliers
        if ($this->request->getPost('supplier_phone') != $supplier['supplier_phone']) {
            $existingSupplier = $this->supplierModel
                ->where('supplier_phone', $this->request->getPost('supplier_phone'))
                ->where('supplier_status', 'active')
                ->first();

            if ($existingSupplier) {
                return redirect()->back()->withInput()->with('errors', ['supplier_phone' => 'Phone number is already in use by an active supplier.']);
            }
        }

        // Prepare data for update
        $data = [
            'supplier_name' => $this->request->getPost('supplier_name'),
            'supplier_phone' => $this->request->getPost('supplier_phone'),
            'supplier_address' => $this->request->getPost('supplier_address'),
            'supplier_status' => $this->request->getPost('supplier_status'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->supplierModel->update($id, $data);
        session()->setFlashdata('success', 'Supplier berhasil diperbarui');
        return redirect()->to('admin/suppliers');
    }

    public function delete($id)
    {
        if (!session()->get('logged_in') || session()->get('user_role') != 'admin') {
            return redirect()->to('login');
        }
    
        // Find supplier by ID
        $supplier = $this->supplierModel->find($id);
    
        if (!$supplier) {
            session()->setFlashdata('error', 'Supplier not found');
            return redirect()->to('admin/suppliers');
        }
    
        // Set the supplier status to inactive instead of deleting it
        $data = [
            'supplier_status' => 'inactive',
            'updated_at' => date('Y-m-d H:i:s'),
        ];
    
        $this->supplierModel->update($id, $data);
    
        session()->setFlashdata('success', 'Supplier successfully deactivated');
        return redirect()->to('admin/suppliers');
    }    
}