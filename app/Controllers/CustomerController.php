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
        if (!session()->get('logged_in')) {
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
        
        // Get sort field and direction
        $sortField = $this->request->getGet('sort') ?? 'updated_at';
        $sortDir = $this->request->getGet('dir') ?? 'desc';
        
        // Validate sort field to prevent SQL injection
        $validSortFields = [
            'customer_name', 
            'customer_phone', 
            'customer_address', 
            'customer_status',
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
        
        // Base query
        $query = $this->customerModel->where('customer_status', 'active');
        
        // Apply search filter if set
        if ($search) {
            $query = $query->groupStart()
                    ->like('customer_name', $search)
                    ->orLike('customer_phone', $search)
                    ->orLike('customer_address', $search)
                    ->groupEnd();
        }
        
        // Get total count based on filters
        $totalCustomers = $query->countAllResults(false);
        
        // Add sorting
        $query = $query->orderBy($sortField, $sortDir);
        
        // Get paginated customers
        $customers = $query
                   ->limit($perPage, ($page - 1) * $perPage)
                   ->find();
        
        // Create pager links
        $pager->setPath('customers');
        
        // Get newly created or updated customer IDs from flash data
        $newCustomerId = session()->getFlashdata('new_customer_id');
        $updatedCustomerId = session()->getFlashdata('updated_customer_id');
        
        // Pass customers data and pager to the view
        return view('customers/customers_index', [
            'customers' => $customers,
            'pager' => $pager,
            'currentPage' => $page,
            'perPage' => $perPage,
            'total' => $totalCustomers,
            'search' => $search,
            'sortField' => $sortField,
            'sortDir' => $sortDir,
            'newCustomerId' => $newCustomerId,
            'updatedCustomerId' => $updatedCustomerId
        ]);
    }

    public function create()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }

        return view('customers/customers_create');
    }

    public function store()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }

        // Define validation rules
        $rules = [
            'customer_name' => 'required',
            'customer_phone' => 'required|numeric|min_length[10]',
            'customer_address' => 'required',
            'customer_status' => 'required|in_list[active,inactive]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Check if the phone number already exists for active customers
        $existingCustomer = $this->customerModel
            ->where('customer_phone', $this->request->getPost('customer_phone'))
            ->where('customer_status', 'active')
            ->first();

        if ($existingCustomer) {
            return redirect()->back()->withInput()->with('errors', ['customer_phone' => 'Phone number is already in use by an active customer.']);
        }

        // Generate customer ID
        $lastcustomer = $this->customerModel->orderBy('customer_id', 'DESC')->first();
        $lastNumber = 0;

        if ($lastcustomer) {
            preg_match('/CUS(\d+)/', $lastcustomer['customer_id'], $matches);
            if (isset($matches[1])) {
                $lastNumber = (int)$matches[1];
            }
        }

        $newNumber = $lastNumber + 1;
        $customerId = 'CUS' . str_pad($newNumber, 6, '0', STR_PAD_LEFT);

        // Prepare data for insertion
        $data = [
            'customer_id' => $customerId,
            'customer_name' => $this->request->getPost('customer_name'),
            'customer_phone' => $this->request->getPost('customer_phone'),
            'customer_address' => $this->request->getPost('customer_address'),
            'customer_status' => $this->request->getPost('customer_status'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->customerModel->insert($data);
        session()->setFlashdata('success', 'Customer successfully added');
        session()->setFlashdata('new_customer_id', $customerId);
        return redirect()->to('/customers');
    }

    public function edit($id)
    {
        if (!session()->get('logged_in') || session()->get('user_role') != 'admin') {
            return redirect()->to('login');
        }

        $data['customer'] = $this->customerModel->find($id);

        if (!$data['customer']) {
            session()->setFlashdata('error', 'Customer not found');
            return redirect()->to('/customers');
        }

        return view('customers/customers_edit', $data);
    }

    public function update($id)
    {
        if (!session()->get('logged_in') || session()->get('user_role') != 'admin') {
            return redirect()->to('login');
        }

        $customer = $this->customerModel->find($id);

        if (!$customer) {
            session()->setFlashdata('error', 'Customer not found');
            return redirect()->to('/customers');
        }

        // Define validation rules
        $rules = [
            'customer_name' => 'required',
            'customer_phone' => 'required|numeric|min_length[10]',
            'customer_address' => 'required',
            'customer_status' => 'required|in_list[active,inactive]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Check if phone number exists for other active customers
        if ($this->request->getPost('customer_phone') != $customer['customer_phone']) {
            $existingcustomer = $this->customerModel
                ->where('customer_phone', $this->request->getPost('customer_phone'))
                ->where('customer_status', 'active')
                ->first();

            if ($existingcustomer) {
                return redirect()->back()->withInput()->with('errors', ['customer_phone' => 'Phone number is already in use by an active customer.']);
            }
        }

        // Prepare data for update
        $data = [
            'customer_name' => $this->request->getPost('customer_name'),
            'customer_phone' => $this->request->getPost('customer_phone'),
            'customer_address' => $this->request->getPost('customer_address'),
            'customer_status' => $this->request->getPost('customer_status'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->customerModel->update($id, $data);
        session()->setFlashdata('success', 'Customer successfully updated');
        session()->setFlashdata('updated_customer_id', $id);
        return redirect()->to('/customers');
    }

    public function delete($id)
    {
        if (!session()->get('logged_in') || session()->get('user_role') != 'admin') {
            return redirect()->to('login');
        }
    
        // Find customer by ID
        $customer = $this->customerModel->find($id);
    
        if (!$customer) {
            session()->setFlashdata('error', 'Customer not found');
            return redirect()->to('/customers');
        }
    
        // Set the customer status to inactive instead of deleting it
        $data = [
            'customer_status' => 'inactive',
            'updated_at' => date('Y-m-d H:i:s'),
        ];
    
        $this->customerModel->update($id, $data);
    
        session()->setFlashdata('success', 'Customer successfully deactivated');
        return redirect()->to('/customers');
    }    
}