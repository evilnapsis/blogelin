<?php
/**
* report/sell-ticket.php
* Genera ticket de venta en formato 80mm
*/
include "../core/autoload.php";
include "../core/app/autoload.php";
require('../fpdf/fpdf.php');

$sell = SellData::getById($_GET["id"]);
if(!$sell) { die("Venta no encontrada."); }

$client = PersonData::getById($sell->person_id);
$operations = OperationData::getAllBySellId($sell->id);
$pm = PaymentMethodData::getById($sell->payment_method_id);

// Configuración de ticket de 80mm
$width = 80;
$margin = 5;

// Clase PDF personalizada
class PDF extends FPDF {
    function RoundedRect($x, $y, $w, $h, $r, $style = '') {
        $k = $this->k;
        $hp = $this->h;
        if($style=='F') $op='f';
        elseif($style=='FD' || $style=='DF') $op='B';
        else $op='S';
        $MyArc = 4/3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2F %.2F m',($x+$r)*$k,($hp-$y)*$k));
        $xc = $x+$w-$r ;
        $yc = $y+$r;
        $this->_out(sprintf('%.2F %.2F l', $xc*$k,($hp-$y)*$k));
        $this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
        $xc = $x+$w-$r ;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-$yc)*$k));
        $this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
        $xc = $x+$r ;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2F %.2F l',$xc*$k,($hp-($y+$h))*$k));
        $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
        $xc = $x+$r ;
        $yc = $y+$r;
        $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$yc)*$k));
        $this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }
    function _Arc($x1, $y1, $x2, $y2, $x3, $y3) {
        $h = $this->h;
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1*$this->k, ($h-$y1)*$this->k, $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
    }
}

// Altura dinámica: Cabecera (~50) + Items (7/item) + Totales (~40)
$dynamic_height = 100 + (count($operations) * 7);
$pdf = new PDF('P', 'mm', array($width, $dynamic_height));
$pdf->SetMargins($margin, 5, $margin);
$pdf->AddPage();

// Brand
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(70, 8, 'BOOKSTYLE PRO', 0, 1, 'C');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(70, 4, utf8_decode(SettingData::getValue("clinic_name")), 0, 1, 'C');
$pdf->Cell(70, 4, utf8_decode("Tel: ".SettingData::getValue("clinic_phone")), 0, 1, 'C');
$pdf->Ln(2);
$pdf->Cell(70, 0, '', 'T', 1);
$pdf->Ln(2);

// Sell Info
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(70, 5, utf8_decode("TICKET DE VENTA #").$sell->id, 0, 1, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(70, 5, "Fecha: ".$sell->created_at, 0, 1, 'L');
$pdf->Cell(70, 5, utf8_decode("Cliente: ").utf8_decode($client ? $client->name." ".$client->lastname : "Publico General"), 0, 1, 'L');

$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(35, 6, "PRODUCTO/SERV", 'B', 0, 'L');
$pdf->Cell(10, 6, "CANT", 'B', 0, 'C');
$pdf->Cell(12, 6, "PRECIO", 'B', 0, 'R');
$pdf->Cell(13, 6, "TOTAL", 'B', 1, 'R');

$pdf->SetFont('Arial', '', 7);
foreach($operations as $op) {
    $p = ProductData::getById($op->product_id);
    $pdf->Cell(35, 6, substr(utf8_decode($p->name),0,22), 0, 0, 'L');
    $pdf->Cell(10, 6, $op->quantity, 0, 0, 'C');
    $pdf->Cell(12, 6, number_format($op->price, 2), 0, 0, 'R');
    $pdf->Cell(13, 6, number_format($op->quantity * $op->price, 2), 0, 1, 'R');
}

$pdf->Ln(2);
$pdf->Cell(70, 0, '', 'T', 1);
$pdf->Ln(2);

// Totals
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(45, 6, "SUBTOTAL:", 0, 0, 'R');
$pdf->Cell(25, 6, "$".number_format($sell->total + $sell->discount, 2), 0, 1, 'R');

if($sell->discount > 0){
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(45, 5, "DESCUENTO:", 0, 0, 'R');
    $pdf->Cell(25, 5, "-$".number_format($sell->discount, 2), 0, 1, 'R');
}

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(45, 8, "TOTAL:", 0, 0, 'R');
$pdf->Cell(25, 8, "$".number_format($sell->total, 2), 0, 1, 'R');

$pdf->Ln(2);
$pdf->SetFont('Arial', 'I', 7);
$pdf->Cell(70, 5, utf8_decode("Metodo de Pago: ").utf8_decode($pm ? $pm->name : "N/A"), 0, 1, 'C');
$pdf->Ln(4);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(70, 5, "GRACIAS POR SU PREFERENCIA", 0, 1, 'C');

$pdf->Output();
?>
