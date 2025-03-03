<?php

namespace App\Controllers;

use App\Models\SaleModel;
use App\Models\SaleDetailModel;
use App\Models\ProductModel;
use App\Models\CustomerModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

require_once APPPATH . 'ThirdParty/fpdf/fpdf.php';

// Define the PDF class outside of the controller class
class PDF extends \FPDF {
    public $periodTitle;
    
    // Footer halaman
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'C');
        $this->Cell(0, 10, 'Generated on: ' . date('d/m/Y H:i:s'), 0, 0, 'R');
    }
    
    // Calculate height needed for a MultiCell
    function GetMultiCellHeight($w, $h, $txt) {
        // Store starting position
        $startX = $this->GetX();
        $startY = $this->GetY();
        
        // Output the text to calculate height
        $this->MultiCell($w, $h, $txt);
        
        // Get the height
        $height = $this->GetY() - $startY;
        
        // Reset position
        $this->SetXY($startX, $startY);
        
        return $height;
    }
    
   // Fungsi untuk menampilkan baris data dengan multiline
    function RowMultiLine($data, $heights = []) {
        // Lebar kolom
        $widths = [35, 35, 35, 85, 35, 35];
        
        // Simpan posisi Y awal
        $startY = $this->GetY();
        
        // Hitung tinggi maksimum yang dibutuhkan untuk semua cell
        $maxHeight = 0;
        
        // First, calculate the maximum height needed
        for ($i = 0; $i < count($data); $i++) {
            // Use a temporary PDF object to calculate height without drawing
            $tempPDF = new PDF('L', 'mm', 'A4');
            $tempPDF->AddPage();
            $tempPDF->SetFont($this->FontFamily, $this->FontStyle, $this->FontSizePt);
            
            // Calculate how much height this content would need
            $startTempY = $tempPDF->GetY();
            $tempPDF->MultiCell($widths[$i], isset($heights[$i]) ? $heights[$i] : 5, $data[$i], 0);
            $cellHeight = $tempPDF->GetY() - $startTempY;
            
            // Track the maximum height
            $maxHeight = max($maxHeight, $cellHeight);
        }
        
        // Add a little padding
        $maxHeight += 2;
        
        // Check if we need a page break
        if ($startY + $maxHeight > $this->PageBreakTrigger) {
            $this->AddPage('L');
            $startY = $this->GetY();
        }
        
        // Now draw all cells with the same height
        $currX = $this->lMargin;
        
        for ($i = 0; $i < count($data); $i++) {
            // Position at the beginning of the cell
            $this->SetXY($currX, $startY);
            
            // Draw a cell with the calculated maximum height
            $this->Cell($widths[$i], $maxHeight, '', 1, 0);
            
            // Position for the text (add a small margin)
            $this->SetXY($currX + 1, $startY + 1);
            
            // Print the content
            $this->MultiCell($widths[$i] - 2, isset($heights[$i]) ? $heights[$i] : 5, $data[$i], 0);
            
            // Move to the next cell position
            $currX += $widths[$i];
        }
        
        // Move to the next row
        $this->SetY($startY + $maxHeight);
    }
}

class SalesReportController extends Controller
{
    public function index()
    {
        return view('admin/reports/sales_report');
    }
    
    public function generateReport()
    {
        // Get date parameters
        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');
        
        // Initialize models
        $saleModel = new SaleModel();
        $userModel = new UserModel();
        $customerModel = new CustomerModel();
        $saleDetailModel = new SaleDetailModel();
        $productModel = new ProductModel();
        
        // Filter by date range
        $saleQuery = $saleModel->where('created_at >=', $startDate . ' 00:00:00')
                               ->where('created_at <=', $endDate . ' 23:59:59');
        
        // Set period title
        $periodTitle = 'Period: ' . date('d M Y', strtotime($startDate)) . ' - ' . date('d M Y', strtotime($endDate));
        
        // Get sales data based on filter
        $sales = $saleQuery->findAll();
        
        // Prepare data for view
        $data['sales'] = [];
        $data['periodTitle'] = $periodTitle;
        
        // If no data, return with error message
        if (empty($sales)) {
            return redirect()->to('/admin/reports/sales')->with('error', 'No sales data found for the selected period.');
        }
        
        // Complete data for each sale
        foreach ($sales as $sale) {
            $sale_info = [
                'sale_id' => $sale['sale_id'],
                'created_at' => $sale['created_at'],
                'sale_amount' => $sale['sale_amount'],
                'user_id' => $sale['user_id'],
                'customer_id' => $sale['customer_id'],
                'payment_method' => $sale['payment_method'],
                'transaction_status' => $sale['transaction_status']
            ];
            
            // Get user name based on user_id
            $user = $userModel->find($sale['user_id']);
            $sale_info['user_fullname'] = $user ? $user['user_fullname'] : 'Unknown';
            
            // Get customer name based on customer_id
            $customer = $customerModel->find($sale['customer_id']);
            $sale_info['customer_name'] = $customer ? $customer['customer_name'] : 'Unknown';
            
            // Get product details
            $sale_details = $saleDetailModel->where('sale_id', $sale['sale_id'])->findAll();
            $sale_info['products'] = [];
            
            foreach ($sale_details as $detail) {
                $product = $productModel->find($detail['product_id']);
                if ($product) {
                    $productAmount = $detail['price_per_unit'] * $detail['quantity_sold'];
                    $sale_info['products'][] = [
                        'product_name' => $product['product_name'],
                        'quantity' => $detail['quantity_sold'],
                        'amount' => $productAmount
                    ];
                }
            }
            
            $data['sales'][] = $sale_info;
        }
        
        $data['start_date'] = $startDate;
        $data['end_date'] = $endDate;
        
        // Display report result
        return view('admin/reports/sales_report_result', $data);
    }
    
    public function exportPdf()
    {
        // Get date parameters
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');
        
        // Initialize models
        $saleModel = new SaleModel();
        $userModel = new UserModel();
        $customerModel = new CustomerModel();
        $saleDetailModel = new SaleDetailModel();
        $productModel = new ProductModel();
        
        // Filter by date range
        $saleQuery = $saleModel->where('created_at >=', $startDate . ' 00:00:00')
                              ->where('created_at <=', $endDate . ' 23:59:59');
        
        // Set period title
        $periodTitle = 'Period: ' . date('d M Y', strtotime($startDate)) . ' - ' . date('d M Y', strtotime($endDate));
        
        // Get sales data based on filter
        $sales = $saleQuery->findAll();
        
        // Generate PDF
        $pdf = new PDF('L', 'mm', 'A4');
        $pdf->periodTitle = $periodTitle;
        $pdf->AliasNbPages(); // For total page numbers
        $pdf->SetAutoPageBreak(true, 15);
        $pdf->AddPage();
        
        // Override header for sales report
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'SALES TRANSACTION REPORT', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, $pdf->periodTitle, 0, 1, 'C');
        $pdf->Ln(5);
        
        // Table header
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(200, 220, 255);
        $pdf->Cell(35, 10, 'Date', 1, 0, 'C', true);
        $pdf->Cell(35, 10, 'Seller', 1, 0, 'C', true);
        $pdf->Cell(35, 10, 'Customer', 1, 0, 'C', true);
        $pdf->Cell(85, 10, 'Product', 1, 0, 'C', true);
        $pdf->Cell(35, 10, 'Quantity', 1, 0, 'C', true);
        $pdf->Cell(35, 10, 'Amount', 1, 1, 'C', true);
        
        // Table data
        $pdf->SetFont('Arial', '', 9);
        $totalAmount = 0;
        
        foreach ($sales as $sale) {
            // Add to total
            $totalAmount += $sale['sale_amount'];
            
            // Get user name based on user_id
            $user = $userModel->find($sale['user_id']);
            $userFullname = $user ? $user['user_fullname'] : 'Unknown';
            
            // Get customer name based on customer_id
            $customer = $customerModel->find($sale['customer_id']);
            $customerName = $customer ? $customer['customer_name'] : 'Unknown';
            
            // Get product details
            $sale_details = $saleDetailModel->where('sale_id', $sale['sale_id'])->findAll();
            
            // If no products, display empty row
            if (empty($sale_details)) {
                $rowData = [
                    date('d/m/Y H:i', strtotime($sale['created_at'])),
                    $userFullname,
                    $customerName,
                    'No products',
                    '0',
                    number_format($sale['sale_amount'], 0, ',', '.') . " IDR"
                ];
                $pdf->RowMultiLine($rowData);
            } 
            else {
                // Loop through each product
                foreach ($sale_details as $detail) {
                    $product = $productModel->find($detail['product_id']);
                    if ($product) {
                        $productAmount = $detail['price_per_unit'] * $detail['quantity_sold'];
                        
                        // Display all information for each product
                        $rowData = [
                            date('d/m/Y H:i', strtotime($sale['created_at'])),
                            $userFullname,
                            $customerName,
                            $product['product_name'],
                            $detail['quantity_sold'],
                            number_format($productAmount, 0, ',', '.') . " IDR"
                        ];
                        
                        $pdf->RowMultiLine($rowData);
                    }
                }
            }
        }
        
        // Display total
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(225, 10, 'Total Amount', 1, 0, 'R');
        $pdf->Cell(35, 10, number_format($totalAmount, 0, ',', '.') . " IDR", 1, 1, 'R');
        
        // Output PDF
        $pdf->Output('Sales_Report_' . date('YmdHis') . '.pdf', 'D');
        exit;
    }
}
