<?php

namespace App\Models;

use CodeIgniter\Model;

class SaleModel extends Model
{
    protected $table            = 'sales';
    protected $primaryKey       = 'sale_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'sale_id',
        'customer_id',
        'user_id',
        'sale_amount',
        'payment_method',
        'transaction_status',
        'sale_status',
        'sale_notes', 
        'created_at',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'sale_id' => 'required|alpha_numeric|min_length[3]|max_length[20]',
        'customer_id' => 'required|alpha_numeric|min_length[3]|max_length[20]',
        'user_id' => 'required|alpha_numeric|min_length[3]|max_length[20]',
        'sale_amount' => 'permit_empty|numeric',
        'payment_method' => 'required|in_list[cash,credit_card,debit_card,e-wallet]',
        'transaction_status' => 'required|in_list[pending,processing,completed,cancelled]',
        'sale_status' => 'required|in_list[continue,cancel]',
    ];

    protected $validationMessages = [
        'sale_id' => [
            'required' => 'Sale ID is required',
            'alpha_numeric' => 'Sale ID can only contain alphanumeric characters',
            'min_length' => 'Sale ID must be at least {param} characters long',
            'max_length' => 'Sale ID cannot exceed {param} characters in length',
        ],
        'customer_id' => [
            'required' => 'Customer ID is required',
        ],
        'user_id' => [
            'required' => 'User ID is required',
        ],
        'payment_method' => [
            'required' => 'Payment method is required',
            'in_list' => 'Payment method must be one of: cash, credit card, debit card, e-wallet',
        ],
        'transaction_status' => [
            'required' => 'Transaction status is required',
            'in_list' => 'Transaction status must be one of: pending, processing, completed, cancelled',
        ],
        'sale_status' => [
            'required' => 'Sale status is required',
            'in_list' => 'Sale status must be one of: continue, cancel',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
