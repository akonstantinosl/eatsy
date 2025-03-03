<?php

namespace App\Controllers;

use App\Models\SaleModel;
use App\Models\SaleDetailModel;
use App\Models\PurchaseModel;
use App\Models\PurchaseDetailModel;
use App\Models\ProductModel;
use App\Models\CustomerModel;
use App\Models\UserModel;
use App\Models\SupplierModel;
use CodeIgniter\Controller;

require_once APPPATH . 'ThirdParty/fpdf/fpdf.php';

class PDF extends \FPDF
{
    public $periodTitle;
    
    // Page header
    function Header()
    {
        // Logo
        $this->Image(FCPATH . 'assets/image/logo.png', 10, 10, 30);
        
        // Title
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'EATSY', 0, 1, 'C');
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 10, 'Address: Eat Easy Street No. 7 Bekasi', 0, 1, 'C');
        $this->Cell(0, 10, 'Phone: +1234567890 | Email: info@eateasy.com', 0, 1, 'C');
        $this->Line(10, $this->GetY(), 287, $this->GetY());
        $this->Ln(10);
    }
    
    // Page footer
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'C');
        $this->Cell(0, 10, 'Generated on: ' . date('Y-m-d H:i:s'), 0, 0, 'R');
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


class ProfitReportController extends Controller
{
    public function index()
    {
        return view('admin/reports/profit_report');
    }
    
    public function generateReport()
    {
        // Get date parameters
        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');
        
        // Initialize models
        $saleModel = new SaleModel();
        $saleDetailModel = new SaleDetailModel();
        $purchaseModel = new PurchaseModel();
        $purchaseDetailModel = new PurchaseDetailModel();
        $productModel = new ProductModel();
        
        // Set period title
        $periodTitle = 'Period: ' . date('d M Y', strtotime($startDate)) . ' - ' . date('d M Y', strtotime($endDate));
        
        // Get sales data based on filter
        $sales = $saleModel->where('created_at >=', $startDate . ' 00:00:00')
                           ->where('created_at <=', $endDate . ' 23:59:59')
                           ->findAll();
        
        // Get purchases data based on filter
        $purchases = $purchaseModel->where('created_at >=', $startDate . ' 00:00:00')
                                  ->where('created_at <=', $endDate . ' 23:59:59')
                                  ->findAll();
        
        // If no data, return with error message
        if (empty($sales) && empty($purchases)) {
            return redirect()->to('/admin/reports/profit')->with('error', 'No transaction data found for the selected period.');
        }
        
        // Prepare data structure for profit calculation
        $profitData = [];
        $totalSales = 0;
        $totalPurchases = 0;
        $totalProfit = 0;
        
        // Process sales data - group by product
        foreach ($sales as $sale) {
            $saleDetails = $saleDetailModel->where('sale_id', $sale['sale_id'])->findAll();
            
            foreach ($saleDetails as $detail) {
                $productId = $detail['product_id'];
                $product = $productModel->find($productId);
                
                if (!isset($profitData[$productId])) {
                    $profitData[$productId] = [
                        'product_id' => $productId,
                        'product_name' => $product ? $product['product_name'] : 'Unknown Product',
                        'sales_quantity' => 0,
                        'sales_amount' => 0,
                        'purchase_quantity' => 0,
                        'purchase_amount' => 0,
                        'profit' => 0
                    ];
                }
                
                // Using the correct field name: price_per_unit
                $saleAmount = $detail['price_per_unit'] * $detail['quantity_sold'];
                $profitData[$productId]['sales_quantity'] += $detail['quantity_sold'];
                $profitData[$productId]['sales_amount'] += $saleAmount;
                
                $totalSales += $saleAmount;
            }
        }
        
        // Process purchase data - group by product
        foreach ($purchases as $purchase) {
            $purchaseDetails = $purchaseDetailModel->where('purchase_id', $purchase['purchase_id'])->findAll();
            
            foreach ($purchaseDetails as $detail) {
                $productId = $detail['product_id'];
                $product = $productModel->find($productId);
                
                if (!isset($profitData[$productId])) {
                    $profitData[$productId] = [
                        'product_id' => $productId,
                        'product_name' => $product ? $product['product_name'] : 'Unknown Product',
                        'sales_quantity' => 0,
                        'sales_amount' => 0,
                        'purchase_quantity' => 0,
                        'purchase_amount' => 0,
                        'profit' => 0
                    ];
                }
                
                // Using the correct field names from purchase_details table
                // Calculate total units purchased (box_bought * unit_per_box)
                $totalUnitsPurchased = $detail['box_bought'] * $detail['unit_per_box'];
                
                // Calculate purchase amount (price_per_box * box_bought)
                $purchaseAmount = $detail['price_per_box'] * $detail['box_bought'];
                
                $profitData[$productId]['purchase_quantity'] += $totalUnitsPurchased;
                $profitData[$productId]['purchase_amount'] += $purchaseAmount;
                
                $totalPurchases += $purchaseAmount;
            }
        }
        
        // Calculate profit for each product
        foreach ($profitData as &$item) {
            $item['profit'] = $item['sales_amount'] - $item['purchase_amount'];
            $totalProfit += $item['profit'];
        }
        
        // Prepare data for view
        $data = [
            'profitData' => $profitData,
            'periodTitle' => $periodTitle,
            'totalSales' => $totalSales,
            'totalPurchases' => $totalPurchases,
            'totalProfit' => $totalProfit,
            'start_date' => $startDate,
            'end_date' => $endDate
        ];
        
        // Display report result
        return view('admin/reports/profit_report_result', $data);
    }
    
    public function exportPdf()
    {
        // Get date parameters
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');
        
        // Initialize models
        $saleModel = new SaleModel();
        $saleDetailModel = new SaleDetailModel();
        $purchaseModel = new PurchaseModel();
        $purchaseDetailModel = new PurchaseDetailModel();
        $productModel = new ProductModel();
        
        // Set period title
        $periodTitle = 'Period: ' . date('d M Y', strtotime($startDate)) . ' - ' . date('d M Y', strtotime($endDate));
        
        // Get sales data based on filter
        $sales = $saleModel->where('created_at >=', $startDate . ' 00:00:00')
                           ->where('created_at <=', $endDate . ' 23:59:59')
                           ->findAll();
        
        // Get purchases data based on filter
        $purchases = $purchaseModel->where('created_at >=', $startDate . ' 00:00:00')
                                  ->where('created_at <=', $endDate . ' 23:59:59')
                                  ->findAll();
        
        // Prepare data structure for profit calculation
        $profitData = [];
        $totalSales = 0;
        $totalPurchases = 0;
        $totalProfit = 0;
        
        // Process sales data - group by product
        foreach ($sales as $sale) {
            $saleDetails = $saleDetailModel->where('sale_id', $sale['sale_id'])->findAll();
            
            foreach ($saleDetails as $detail) {
                $productId = $detail['product_id'];
                $product = $productModel->find($productId);
                
                if (!isset($profitData[$productId])) {
                    $profitData[$productId] = [
                        'product_id' => $productId,
                        'product_name' => $product ? $product['product_name'] : 'Unknown Product',
                        'sales_quantity' => 0,
                        'sales_amount' => 0,
                        'purchase_quantity' => 0,
                        'purchase_amount' => 0,
                        'profit' => 0
                    ];
                }
                
                // Using the correct field name: price_per_unit
                $saleAmount = $detail['price_per_unit'] * $detail['quantity_sold'];
                $profitData[$productId]['sales_quantity'] += $detail['quantity_sold'];
                $profitData[$productId]['sales_amount'] += $saleAmount;
                
                $totalSales += $saleAmount;
            }
        }
        
        // Process purchase data - group by product
        foreach ($purchases as $purchase) {
            $purchaseDetails = $purchaseDetailModel->where('purchase_id', $purchase['purchase_id'])->findAll();
            
            foreach ($purchaseDetails as $detail) {
                $productId = $detail['product_id'];
                $product = $productModel->find($productId);
                
                if (!isset($profitData[$productId])) {
                    $profitData[$productId] = [
                        'product_id' => $productId,
                        'product_name' => $product ? $product['product_name'] : 'Unknown Product',
                        'sales_quantity' => 0,
                        'sales_amount' => 0,
                        'purchase_quantity' => 0,
                        'purchase_amount' => 0,
                        'profit' => 0
                    ];
                }
                
                // Using the correct field names from purchase_details table
                // Calculate total units purchased (box_bought * unit_per_box)
                $totalUnitsPurchased = $detail['box_bought'] * $detail['unit_per_box'];
                
                // Calculate purchase amount (price_per_box * box_bought)
                $purchaseAmount = $detail['price_per_box'] * $detail['box_bought'];
                
                $profitData[$productId]['purchase_quantity'] += $totalUnitsPurchased;
                $profitData[$productId]['purchase_amount'] += $purchaseAmount;
                
                $totalPurchases += $purchaseAmount;
            }
        }
        
        // Calculate profit for each product
        foreach ($profitData as &$item) {
            $item['profit'] = $item['sales_amount'] - $item['purchase_amount'];
            $totalProfit += $item['profit'];
        }
        
        // Generate PDF
        $pdf = new PDF('L', 'mm', 'A4');
        $pdf->periodTitle = $periodTitle;
        $pdf->AliasNbPages(); // For total page numbers
        $pdf->SetAutoPageBreak(true, 15);
        $pdf->AddPage();
        
        // Override header for profit report
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'PROFIT REPORT', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, $pdf->periodTitle, 0, 1, 'C');
        $pdf->Ln(5);
        
        // Table header
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(200, 220, 255);
        $pdf->Cell(70, 10, 'Product', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'Sales Qty', 1, 0, 'C', true);
        $pdf->Cell(45, 10, 'Sales Amount', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'Purchase Qty', 1, 0, 'C', true);
        $pdf->Cell(45, 10, 'Purchase Amount', 1, 0, 'C', true);
        $pdf->Cell(45, 10, 'Profit', 1, 1, 'C', true);
        
        // Table data
        $pdf->SetFont('Arial', '', 9);
        
        foreach ($profitData as $item) {
            $rowData = [
                $item['product_name'],
                $item['sales_quantity'],
                number_format($item['sales_amount'], 0, ',', '.') . " IDR",
                $item['purchase_quantity'],
                number_format($item['purchase_amount'], 0, ',', '.') . " IDR",
                number_format($item['profit'], 0, ',', '.') . " IDR"
            ];
            
            $pdf->Cell(70, 10, $rowData[0], 1, 0, 'L');
            $pdf->Cell(30, 10, $rowData[1], 1, 0, 'C');
            $pdf->Cell(45, 10, $rowData[2], 1, 0, 'R');
            $pdf->Cell(30, 10, $rowData[3], 1, 0, 'C');
            $pdf->Cell(45, 10, $rowData[4], 1, 0, 'R');
            $pdf->Cell(45, 10, $rowData[5], 1, 1, 'R');
        }
        
        // Display totals
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(70, 10, 'TOTAL', 1, 0, 'L');
        $pdf->Cell(30, 10, '', 1, 0, 'C');
        $pdf->Cell(45, 10, number_format($totalSales, 0, ',', '.') . " IDR", 1, 0, 'R');
        $pdf->Cell(30, 10, '', 1, 0, 'C');
        $pdf->Cell(45, 10, number_format($totalPurchases, 0, ',', '.') . " IDR", 1, 0, 'R');
        $pdf->Cell(45, 10, number_format($totalProfit, 0, ',', '.') . " IDR", 1, 1, 'R');
        
        // Output PDF
        $pdf->Output('Profit_Report_' . date('YmdHis') . '.pdf', 'D');
        exit;
    }
}
