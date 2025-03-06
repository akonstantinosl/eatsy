<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\ProductCategoryModel;
use App\Models\SupplierModel;

class ProductController extends BaseController
{
    protected $productModel;
    protected $categoryModel;
    protected $supplierModel;

    public function __construct()
    {
        // Initialize models
        $this->productModel = new ProductModel();
        $this->categoryModel = new ProductCategoryModel();
        $this->supplierModel = new SupplierModel();
    }

    public function index()
    {
        // Set pagination configuration
        $pager = \Config\Services::pager();
        
        // Get current page from the request, default to 1 if not set
        $page = $this->request->getGet('page') ?? 1;
        
        // Get entries per page (default to 10 if not set)
        // Cast to integer to avoid type errors in the limit() method
        $perPage = (int)($this->request->getGet('entries') ?? 10);
        
        // Get category filter (if any)
        $categoryFilter = $this->request->getGet('category');
        
        // Get search term (if any)
        $search = $this->request->getGet('search');
        
        // Get sort field and direction
        $sortField = $this->request->getGet('sort') ?? 'created_at';
        $sortDir = $this->request->getGet('dir') ?? 'desc';
        
        // Validate sort field to prevent SQL injection
        $validSortFields = [
            'product_name',
            'product_category_name',
            'supplier_name',
            'product_stock',
            'buying_price',
            'selling_price',
            'created_at',
            'updated_at'
        ];
        
        if (!in_array($sortField, $validSortFields)) {
            $sortField = 'created_at';
        }
        
        // Validate sort direction
        if (!in_array($sortDir, ['asc', 'desc'])) {
            $sortDir = 'desc';
        }
        
        // Base query with joins
        $query = $this->productModel
                ->select('products.product_id, products.product_name, products.buying_price, products.selling_price, 
                        products.product_stock, products.created_at, products.updated_at, 
                        product_categories.product_category_name, product_categories.product_category_id, 
                        suppliers.supplier_name, suppliers.supplier_id')
                ->join('product_categories', 'product_categories.product_category_id = products.product_category_id')
                ->join('suppliers', 'suppliers.supplier_id = products.supplier_id')
                ->where('product_status', 'active');
        
        // Apply category filter if set
        if ($categoryFilter) {
            $query = $query->where('products.product_category_id', $categoryFilter);
        }
        
        // Apply search filter if set
        if ($search) {
            $query = $query->groupStart()
                    ->like('products.product_name', $search)
                    ->orLike('product_categories.product_category_name', $search)
                    ->orLike('suppliers.supplier_name', $search)
                    ->groupEnd();
        }
        
        // Get total count based on filters
        $totalProducts = $query->countAllResults(false);
        
        // Handle sorting based on table columns
        if ($sortField === 'product_name') {
            $query = $query->orderBy('products.product_name', $sortDir);
        } elseif ($sortField === 'product_category_name') {
            $query = $query->orderBy('product_categories.product_category_name', $sortDir);
        } elseif ($sortField === 'supplier_name') {
            $query = $query->orderBy('suppliers.supplier_name', $sortDir);
        } elseif ($sortField === 'product_stock') {
            $query = $query->orderBy('products.product_stock', $sortDir);
        } elseif ($sortField === 'buying_price') {
            $query = $query->orderBy('products.buying_price', $sortDir);
        } elseif ($sortField === 'selling_price') {
            $query = $query->orderBy('products.selling_price', $sortDir);
        } elseif ($sortField === 'created_at') {
            $query = $query->orderBy('products.created_at', $sortDir);
        } else {
            $query = $query->orderBy('products.updated_at', $sortDir);
        }
        
        // Get paginated products based on filters
        $products = $query
                ->limit($perPage, ($page - 1) * $perPage)
                ->find();
        
        // Get all product categories for the filter dropdown
        $categories = $this->categoryModel->findAll();
        
        // Create pager links
        $pager->setPath('/products');
        
        // Get newly created or updated product IDs from flash data
        $newProductId = session()->getFlashdata('new_product_id');
        $updatedProductId = session()->getFlashdata('updated_product_id');
        
        // Pass products data and pager to the view
        return view('/products/products_index', [
            'products' => $products,
            'categories' => $categories,
            'pager' => $pager,
            'currentPage' => $page,
            'perPage' => $perPage,
            'total' => $totalProducts,
            'categoryFilter' => $categoryFilter,
            'search' => $search,
            'sortField' => $sortField,
            'sortDir' => $sortDir,
            'newProductId' => $newProductId,
            'updatedProductId' => $updatedProductId
        ]);
    }

    public function create()
    {
        // Get all product categories
        $categories = $this->categoryModel->findAll();

        // Get only active suppliers
        $suppliers = $this->supplierModel->where('supplier_status', 'active')->findAll();

        // Pass categories and suppliers to the view
        return view('/products/products_create', [
            'categories' => $categories,
            'suppliers' => $suppliers
        ]);
    }

    public function store()
    {
        // Get the submitted data from the form
        $productName = $this->request->getPost('product_name');
        $productCategoryId = $this->request->getPost('product_category_id');
        $supplierId = $this->request->getPost('supplier_id');

        // Validate if the required fields are not empty
        if (empty($productName)) {
            return redirect()->back()->with('error', 'Product name is required.');
        }

        // Generate product_id
        $lastProduct = $this->productModel->orderBy('product_id', 'DESC')->first();
        $lastNumber = 0;
        if ($lastProduct) {
            preg_match('/PDT(\d+)/', $lastProduct['product_id'], $matches);
            if (isset($matches[1])) {
                $lastNumber = (int)$matches[1];
            }
        }

        $newNumber = $lastNumber + 1;
        $productId = 'PDT' . str_pad($newNumber, 6, '0', STR_PAD_LEFT);

        // Prepare data for insertion
        $data = [
            'product_id' => $productId,
            'product_name' => $productName,
            'product_category_id' => $productCategoryId,
            'supplier_id' => $supplierId,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'product_status' => 'active', // Default status as active
            'product_stock' => 0, // Default stock to 0
        ];

        // Insert the new product into the database
        $this->productModel->insert($data);

        // Set flash data to highlight the new product
        session()->setFlashdata('success', 'Product added successfully.');
        session()->setFlashdata('new_product_id', $productId);

        // Redirect back to the product list with success message
        return redirect()->to('/products');
    }

    public function edit($productId)
    {
        // Get product data by product_id
        $product = $this->productModel->find($productId);

        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Product not found');
        }

        // Get the list of categories
        $categories = $this->categoryModel->findAll();

        // Get only active suppliers
        $suppliers = $this->supplierModel->where('supplier_status', 'active')->findAll();

        // Pass product data and category/supplier list to the view
        return view('/products/products_edit', [
            'product' => $product,
            'categories' => $categories,
            'suppliers' => $suppliers
        ]);
    }

    public function update($productId)
    {
        // Get the submitted data from the form
        $productName = $this->request->getPost('product_name');
        $productCategoryId = $this->request->getPost('product_category_id');
        $supplierId = $this->request->getPost('supplier_id');
        $sellingPrice = $this->request->getPost('selling_price');

        if (empty($productName) || $sellingPrice === null || $sellingPrice < 0) {
            return redirect()->back()->with('error', 'Product name is required and selling price cannot be negative.');
        }

        // Prepare data for update
        $data = [
            'product_name' => $productName,
            'product_category_id' => $productCategoryId,
            'supplier_id' => $supplierId,
            'selling_price' => $sellingPrice,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Update the product
        $this->productModel->update($productId, $data);

        // Set flash data to highlight the updated product
        session()->setFlashdata('success', 'Product updated successfully.');
        session()->setFlashdata('updated_product_id', $productId);

        // Redirect back to the product list
        return redirect()->to('/products');
    }

    // Delete function to set the product status as inactive instead of deleting it
    public function delete($productId)
    {
        // Find product by ID
        $product = $this->productModel->find($productId);

        if (!$product) {
            return redirect()->to('/products')->with('error', 'Product not found');
        }

        // Set the product status to inactive instead of deleting it
        $data = [
            'product_status' => 'inactive',
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->productModel->update($productId, $data);

        session()->setFlashdata('success', 'Product successfully Inactivated');
        return redirect()->to('/products');
    }
}