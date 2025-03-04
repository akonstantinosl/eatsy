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
    
    // Page header
    function Header() {
        // Logo
        $this->Image(FCPATH . 'assets/image/logo.png', 10, 10, 30);
        
        // Title
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'EATSY', 0, 1, 'C');
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 10, 'Eat Easy Street No. 7 Bekasi', 0, 1, 'C');
        $this->Cell(0, 10, '+1234567890 | info@eateasy.com', 0, 1, 'C');
        $this->Line(10, $this->GetY(), 287, $this->GetY());
        $this->Ln(10);
        
        // Report Title and period - ONLY on the first page
        if ($this->PageNo() == 1) {
            $this->SetFont('Arial', 'B', 16);
            $this->Cell(0, 10, 'SALES TRANSACTION REPORT', 0, 1, 'C');
            $this->SetFont('Arial', '', 12);
            $this->Cell(0, 10, $this->periodTitle, 0, 1, 'C');
            $this->Ln(5);
        }
        
        // Header tabel (on all pages)
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(200, 220, 255);
        $this->Cell(35, 10, 'Date', 1, 0, 'C', true);
        $this->Cell(35, 10, 'Seller', 1, 0, 'C', true);
        $this->Cell(35, 10, 'Customer', 1, 0, 'C', true);
        $this->Cell(85, 10, 'Product', 1, 0, 'C', true);
        $this->Cell(35, 10, 'Quantity', 1, 0, 'C', true);
        $this->Cell(35, 10, 'Amount', 1, 1, 'C', true);
    }
    
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
    
    // Better table function for multi-line cells
    function MultiLineCell($w, $h, $txt, $border=0, $align='J', $fill=false)
    {
        $cw = $this->CurrentFont['cw'];
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
        $s = str_replace("\r",'',$txt);
        $nb = strlen($s);
        if($nb>0 && $s[$nb-1]=="\n")
            $nb--;
        $b = 0;
        if($border)
        {
            if($border==1)
            {
                $border = 'LTRB';
                $b = 'LRT';
                $b2 = 'LR';
            }
            else
            {
                $b2 = '';
                if(strpos($border,'L')!==false)
                    $b2 .= 'L';
                if(strpos($border,'R')!==false)
                    $b2 .= 'R';
                $b = $b2;
                if(strpos($border,'T')!==false)
                    $b .= 'T';
            }
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $ns = 0;
        $nl = 1;
        while($i<$nb)
        {
            $c = $s[$i];
            if($c=="\n")
            {
                if($this->ws>0)
                {
                    $this->ws = 0;
                    $this->_out('0 Tw');
                }
                $this->Cell($w,$h/2,substr($s,$j,$i-$j),$b,$ln=2,$align,$fill);
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $ns = 0;
                $nl++;
                if($border && $nl==2)
                    $b = $b2;
                continue;
            }
            if($c==' ')
            {
                $sep = $i;
                $ls = $l;
                $ns++;
            }
            $l += $cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                    if($this->ws>0)
                    {
                        $this->ws = 0;
                        $this->_out('0 Tw');
                    }
                    $this->Cell($w,$h/2,substr($s,$j,$i-$j),$b,$ln=2,$align,$fill);
                }
                else
                {
                    if($align=='J')
                    {
                        $this->ws = ($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
                        $this->_out(sprintf('%.3F Tw',$this->ws*$this->k));
                    }
                    $this->Cell($w,$h/2,substr($s,$j,$sep-$j),$b,$ln=2,$align,$fill);
                    $i = $sep+1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $ns = 0;
                $nl++;
                if($border && $nl==2)
                    $b = $b2;
            }
            else
                $i++;
        }
        if($this->ws>0)
        {
            $this->ws = 0;
            $this->_out('0 Tw');
        }
        if($border && strpos($border,'B')!==false)
            $b .= 'B';
        $this->Cell($w,$h/2,substr($s,$j,$i-$j),$b,2,$align,$fill);
        $this->x = $this->lMargin;
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
        
        // Filter by date range and completed status
        $saleQuery = $saleModel->where('created_at >=', $startDate . ' 00:00:00')
                              ->where('created_at <=', $endDate . ' 23:59:59')
                              ->where('transaction_status', 'completed'); // Filter for completed sales only
        
        // Set period title
        $periodTitle = 'Period: ' . date('d M Y', strtotime($startDate)) . ' - ' . date('d M Y', strtotime($endDate));
        
        // Get sales data based on filter
        $sales = $saleQuery->findAll();
        
        // Prepare data for view
        $data['sales'] = [];
        $data['periodTitle'] = $periodTitle;
        
        // If no data, return with error message
        if (empty($sales)) {
            return redirect()->to('/admin/reports/sales')->with('error', 'No completed sales data found for the selected period.');
        }
        
        // Complete data for each sale
        $totalAmount = 0;
        $totalItems = 0;
        $customerStats = [];
        
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
            
            // Add to total amount
            $totalAmount += $sale['sale_amount'];
            
            // Get user name based on user_id
            $user = $userModel->find($sale['user_id']);
            $sale_info['user_fullname'] = $user ? $user['user_fullname'] : 'Unknown';
            
            // Get customer name based on customer_id
            $customer = $customerModel->find($sale['customer_id']);
            $sale_info['customer_name'] = $customer ? $customer['customer_name'] : 'Unknown';
            
            // Track customer statistics
            if (!isset($customerStats[$sale['customer_id']])) {
                $customerStats[$sale['customer_id']] = [
                    'name' => $sale_info['customer_name'],
                    'amount' => 0,
                    'count' => 0
                ];
            }
            $customerStats[$sale['customer_id']]['amount'] += $sale['sale_amount'];
            $customerStats[$sale['customer_id']]['count']++;
            
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
                    
                    // Add to total items
                    $totalItems += $detail['quantity_sold'];
                }
            }
            
            $data['sales'][] = $sale_info;
        }
        
        $data['start_date'] = $startDate;
        $data['end_date'] = $endDate;
        $data['totalAmount'] = $totalAmount;
        $data['totalItems'] = $totalItems;
        $data['customerStats'] = $customerStats;
        
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
        
        // Filter by date range and completed status
        $saleQuery = $saleModel->where('created_at >=', $startDate . ' 00:00:00')
                              ->where('created_at <=', $endDate . ' 23:59:59')
                              ->where('transaction_status', 'completed'); // Filter for completed sales only
        
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
        
        // Table data
        $pdf->SetFont('Arial', '', 9);
        $totalAmount = 0;
        $totalItems = 0;
        
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
                        
                        // Add to total items
                        $totalItems += $detail['quantity_sold'];
                        
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
        $pdf->Cell(190, 10, 'TOTAL', 1, 0, 'R');
        $pdf->Cell(35, 10, $totalItems, 1, 0, 'R');
        $pdf->Cell(35, 10, number_format($totalAmount, 0, ',', '.') . " IDR", 1, 1, 'R');
        
        // Output PDF
        $pdf->Output('Sales_Report_' . date('YmdHis') . '.pdf', 'D');
        exit;
    }
}