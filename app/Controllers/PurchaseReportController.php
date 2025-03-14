<?php

namespace App\Controllers;

use App\Models\PurchaseModel;
use App\Models\PurchaseDetailModel;
use App\Models\ProductModel;
use App\Models\SupplierModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

require_once APPPATH . 'ThirdParty/fpdf/fpdf.php';

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
            $this->Cell(0, 10, 'PURCHASE TRANSACTION REPORT', 0, 1, 'C');
            $this->SetFont('Arial', '', 12);
            $this->Cell(0, 10, $this->periodTitle, 0, 1, 'C');
            $this->Ln(5);
        }
        
        // Header tabel (on all pages)
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(200, 220, 255);
        $this->Cell(35, 10, 'Date', 1, 0, 'C', true);
        $this->Cell(35, 10, 'Buyer', 1, 0, 'C', true);
        $this->Cell(35, 10, 'Supplier', 1, 0, 'C', true);
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
    function MultiLineCell($w, $h, $txt, $border=0, $align='J', $fill=false) {
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

class PurchaseReportController extends Controller
{
    public function index()
    {
        return view('admin/reports/purchases_report');
    }
    
    public function generateReport()
    {
        // Get date parameters
        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');
        
        // Inisialisasi model
        $purchaseModel = new PurchaseModel();
        $userModel = new UserModel();
        $supplierModel = new SupplierModel();
        $purchaseDetailModel = new PurchaseDetailModel();
        $productModel = new ProductModel();
        
        // Filter berdasarkan rentang tanggal and completed status
        $purchaseQuery = $purchaseModel->where('updated_at >=', $startDate . ' 00:00:00')
                                       ->where('updated_at <=', $endDate . ' 23:59:59')
                                       ->where('order_status', 'completed') // Filter for completed orders only
                                       ->orderBy('updated_at', 'ASC'); // Order by date from oldest to newest
        
        // Set period title
        $periodTitle = 'Period: ' . date('d M Y', strtotime($startDate)) . ' - ' . date('d M Y', strtotime($endDate));
        
        // Dapatkan data pembelian sesuai filter
        $purchases = $purchaseQuery->findAll();
        
        // Persiapkan data untuk view
        $data['purchases'] = [];
        $data['periodTitle'] = $periodTitle;
        
        // Jika tidak ada data, kembalikan dengan pesan error
        if (empty($purchases)) {
            return redirect()->to('/admin/reports/purchases')->with('error', 'No completed purchase data found for the selected period.');
        }
        
        // Lengkapi data untuk setiap pembelian
        $totalAmount = 0;
        $totalItems = 0;
        $supplierStats = [];
        
        foreach ($purchases as $purchase) {
            $purchase_info = [
                'purchase_id' => $purchase['purchase_id'],
                'updated_at' => $purchase['updated_at'],
                'purchase_amount' => $purchase['purchase_amount'],
                'user_id' => $purchase['user_id'],
                'supplier_id' => $purchase['supplier_id']
            ];
            
            // Add to total amount
            $totalAmount += $purchase['purchase_amount'];
            
            // Ambil nama user berdasarkan user_id
            $user = $userModel->find($purchase['user_id']);
            $purchase_info['user_fullname'] = $user ? $user['user_fullname'] : 'Unknown';
            
            // Ambil nama supplier berdasarkan supplier_id
            $supplier = $supplierModel->find($purchase['supplier_id']);
            $purchase_info['supplier_name'] = $supplier ? $supplier['supplier_name'] : 'Unknown';
            
            // Track supplier statistics
            if (!isset($supplierStats[$purchase['supplier_id']])) {
                $supplierStats[$purchase['supplier_id']] = [
                    'name' => $purchase_info['supplier_name'],
                    'amount' => 0,
                    'count' => 0
                ];
            }
            $supplierStats[$purchase['supplier_id']]['amount'] += $purchase['purchase_amount'];
            $supplierStats[$purchase['supplier_id']]['count']++;
            
            // Ambil detail produk yang dibeli
            $purchase_details = $purchaseDetailModel->where('purchase_id', $purchase['purchase_id'])->findAll();
            $purchase_info['products'] = [];
            
            foreach ($purchase_details as $detail) {
                $product = $productModel->find($detail['product_id']);
                if ($product) {
                    // Use the new column structure
                    $quantity = $detail['quantity_bought'];
                    $productAmount = $detail['purchase_price'];
                    
                    $purchase_info['products'][] = [
                        'product_name' => $product['product_name'],
                        'quantity' => $quantity,
                        'amount' => $productAmount
                    ];
                    
                    // Add to total items
                    $totalItems += $quantity;
                }
            }
            
            $data['purchases'][] = $purchase_info;
        }
        
        $data['start_date'] = $startDate;
        $data['end_date'] = $endDate;
        $data['totalAmount'] = $totalAmount;
        $data['totalItems'] = $totalItems;
        $data['supplierStats'] = $supplierStats;
        
        // Tampilkan hasil report
        return view('admin/reports/purchases_report_result', $data);
    }
    
    public function exportPdf()
    {
        // Get date parameters
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');
        
        // Inisialisasi model
        $purchaseModel = new PurchaseModel();
        $userModel = new UserModel();
        $supplierModel = new SupplierModel();
        $purchaseDetailModel = new PurchaseDetailModel();
        $productModel = new ProductModel();
        
        // Filter berdasarkan rentang tanggal and completed status
        $purchaseQuery = $purchaseModel->where('updated_at >=', $startDate . ' 00:00:00')
                                      ->where('updated_at <=', $endDate . ' 23:59:59')
                                      ->where('order_status', 'completed') // Filter for completed orders only
                                      ->orderBy('updated_at', 'ASC'); // Order by date from oldest to newest
        
        // Set period title
        $periodTitle = 'Period: ' . date('d M Y', strtotime($startDate)) . ' - ' . date('d M Y', strtotime($endDate));
        
        // Dapatkan data pembelian sesuai filter
        $purchases = $purchaseQuery->findAll();
        
        // Generate PDF
        $pdf = new PDF('L', 'mm', 'A4');
        $pdf->periodTitle = $periodTitle;
        $pdf->AliasNbPages(); // Untuk nomor halaman total
        $pdf->SetAutoPageBreak(true, 15);
        $pdf->AddPage();
        
        // Data tabel
        $pdf->SetFont('Arial', '', 9);
        $totalAmount = 0;
        $totalItems = 0;
        
        foreach ($purchases as $index => $purchase) {
            // Tambahkan ke total
            $totalAmount += $purchase['purchase_amount'];
            
            // Ambil nama user berdasarkan user_id
            $user = $userModel->find($purchase['user_id']);
            $userFullname = $user ? $user['user_fullname'] : 'Unknown';
            
            // Ambil nama supplier berdasarkan supplier_id
            $supplier = $supplierModel->find($purchase['supplier_id']);
            $supplierName = $supplier ? $supplier['supplier_name'] : 'Unknown';
            
            // Ambil detail produk yang dibeli
            $purchase_details = $purchaseDetailModel->where('purchase_id', $purchase['purchase_id'])->findAll();
            
            // Jika tidak ada produk, tampilkan baris kosong
            if (empty($purchase_details)) {
                $rowData = [
                    date('d/m/Y H:i', strtotime($purchase['updated_at'])),
                    $userFullname,
                    $supplierName,
                    'No products',
                    '0',
                    number_format($purchase['purchase_amount'], 0, ',', '.') . " IDR"
                ];
                $pdf->RowMultiLine($rowData);
            } 
            else {
                // Loop untuk setiap produk
                foreach ($purchase_details as $detailIndex => $detail) {
                    $product = $productModel->find($detail['product_id']);
                    if ($product) {
                        // Use the new column structure
                        $quantity = $detail['quantity_bought'];
                        $productAmount = $detail['purchase_price'];
                        
                        // Add to total items
                        $totalItems += $quantity;
                        
                        // Tampilkan semua informasi untuk setiap produk
                        $rowData = [
                            date('d/m/Y H:i', strtotime($purchase['updated_at'])),
                            $userFullname,
                            $supplierName,
                            $product['product_name'],
                            $quantity,
                            number_format($productAmount, 0, ',', '.') . " IDR"
                        ];
                        
                        $pdf->RowMultiLine($rowData);
                    }
                }
            }
        }
        
        // Tampilkan total
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(190, 10, 'TOTAL', 1, 0, 'R');
        $pdf->Cell(35, 10, $totalItems, 1, 0, 'R');
        $pdf->Cell(35, 10, number_format($totalAmount, 0, ',', '.') . " IDR", 1, 1, 'R');
        
        // Output PDF
        $pdf->Output('Purchase_Report_' . date('YmdHis') . '.pdf', 'D');
        exit;
    }
}