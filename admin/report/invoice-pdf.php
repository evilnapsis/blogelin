<?php
/**
* report/invoice-pdf.php
* Genera la factura en PDF usando FPDF
*/
include "../core/autoload.php";
include "../core/app/autoload.php";
require('../fpdf/fpdf.php');

$inv = InvoiceData::getById($_GET["id"]);
if(!$inv) { die("Factura no encontrada."); }

$patient = PatientData::getById($inv->patient_id);
$items = InvoiceItemData::getAllByInvoice($inv->id);
$payments = PaymentData::getAllByInvoice($inv->id);
$balance = $inv->getBalance();

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial','B',15);
        $this->Cell(80);
        $this->Cell(30,10,'FULLMEDIK PRO',0,0,'C');
        $this->Ln(10);
        $this->SetFont('Arial','I',10);
        $this->Cell(190,10,utf8_decode('Sistema de Gestión Médica Profesional'),0,0,'C');
        $this->Ln(20);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);

// Datos de la Factura
$pdf->Cell(100, 10, utf8_decode("Factura #: ").$inv->id, 0, 0);
$pdf->Cell(90, 10, "Fecha: ".$inv->created_at, 0, 1, 'R');
$pdf->Ln(5);

// Datos del Paciente
$pdf->SetFillColor(230,230,230);
$pdf->Cell(190, 7, "DATOS DEL PACIENTE", 1, 1, 'L', true);
$pdf->SetFont('Arial','',10);
$pdf->Cell(190, 7, utf8_decode("Nombre: ").utf8_decode($patient->name." ".$patient->lastname), 1, 1);
$pdf->Cell(95, 7, utf8_decode("Teléfono: ").$patient->phone, 1, 0);
$pdf->Cell(95, 7, "Email: ".$patient->email, 1, 1);
$pdf->Ln(10);

// Tabla de Items
$pdf->SetFont('Arial','B',10);
$pdf->Cell(100, 7, "SERVICIO / CONCEPTO", 1, 0, 'C', true);
$pdf->Cell(20, 7, "CANT", 1, 0, 'C', true);
$pdf->Cell(35, 7, "PRECIO U.", 1, 0, 'C', true);
$pdf->Cell(35, 7, "SUBTOTAL", 1, 1, 'C', true);

$pdf->SetFont('Arial','',10);
foreach($items as $it) {
    $srv = ServiceData::getById($it->service_id);
    $pdf->Cell(100, 7, utf8_decode($srv->name), 1, 0);
    $pdf->Cell(20, 7, $it->quantity, 1, 0, 'C');
    $pdf->Cell(35, 7, "$".number_format($it->price, 2), 1, 0, 'R');
    $pdf->Cell(35, 7, "$".number_format($it->quantity * $it->price, 2), 1, 1, 'R');
}

// Totales
$pdf->SetFont('Arial','B',10);
$pdf->Cell(120, 7, "", 0, 0);
$pdf->Cell(35, 7, "TOTAL:", 1, 0, 'R', true);
$pdf->Cell(35, 7, "$".number_format($inv->total, 2), 1, 1, 'R');

$pdf->Ln(10);

// Historial de Pagos
$pdf->Cell(190, 7, "HISTORIAL DE ABONOS", 1, 1, 'L', true);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(60, 6, "FECHA", 1, 0, 'C');
$pdf->Cell(70, 6, "METODO", 1, 0, 'C');
$pdf->Cell(60, 6, "MONTO", 1, 1, 'C');

$pdf->SetFont('Arial','',9);
foreach($payments as $p) {
    $pdf->Cell(60, 6, $p->created_at, 1, 0, 'C');
    $pdf->Cell(70, 6, $p->payment_method, 1, 0, 'C');
    $pdf->Cell(60, 6, "$".number_format($p->amount, 2), 1, 1, 'R');
}

$pdf->SetFont('Arial','B',11);
$pdf->Cell(120, 10, "", 0, 0);
$pdf->Cell(35, 10, "SALDO:", 0, 0, 'R');
$pdf->Cell(35, 10, "$".number_format($balance, 2), 0, 1, 'R');

$pdf->Output();
?>
