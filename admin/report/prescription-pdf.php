<?php
/**
* prescription-pdf.php
*/
include "../core/autoload.php";
include "../core/app/model/PrescriptionData.php";
include "../core/app/model/PrescriptionItemData.php";
include "../core/app/model/DrugData.php";
include "../core/app/model/AppointmentData.php";
include "../core/app/model/PatientData.php";
include "../core/app/model/DoctorData.php";
include "../core/app/model/UserData.php";
include "../core/app/model/SpecialtyData.php";
include "../core/app/model/SettingData.php";
include "../fpdf/fpdf.php";

$prescription = PrescriptionData::getById($_GET["id"]);
$app = AppointmentData::getById($prescription->appointment_id);
$patient = PatientData::getById($prescription->patient_id);
$doctor = DoctorData::getById($prescription->doctor_id);
$user_doc = UserData::getById($doctor->user_id);
$spec = SpecialtyData::getById($doctor->specialty_id);
$items = PrescriptionItemData::getAllByPrescription($prescription->id);

$pdf = new FPDF('P','mm','A5'); // Half page format for prescriptions
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);

// Header: Clinic Info
$pdf->Cell(0,10,utf8_decode("FULLMEDIK PRO - RECETA MÉDICA"),0,1,'C');
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,5,utf8_decode("CENTRO CLÍNICO PROFESIONAL"),0,1,'C');
$pdf->Ln(5);

// Doctor Info
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,5,utf8_decode("MÉDICO: ".strtoupper($user_doc->name." ".$user_doc->lastname)),0,1,'L');
$pdf->SetFont('Arial','I',9);
$pdf->Cell(0,5,utf8_decode("Especialidad: ".$spec->name),0,1,'L');
$pdf->Cell(0,5,utf8_decode("Cédula Prof: ".$doctor->license_number),0,1,'L');
$pdf->Ln(5);

$pdf->Line(10, $pdf->GetY(), 138, $pdf->GetY());
$pdf->Ln(2);

// Patient Info
$pdf->SetFont('Arial','B',9);
$pdf->Cell(20,5,"PACIENTE: ",0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(70,5,utf8_decode($patient->name." ".$patient->lastname),0,0);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(15,5,"FECHA: ",0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(0,5,$app->date,0,1);
$pdf->Ln(5);

// Prescription Items
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,7,"RP/",0,1,'L');
$pdf->SetFont('Arial','',9);

foreach($items as $i) {
    $dr = DrugData::getById($i->drug_id);
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(0,5,utf8_decode($dr->name." (".$dr->generic_name.") - ".$dr->dosage),0,1,'L');
    $pdf->SetFont('Arial','I',8);
    $pdf->MultiCell(0,4,utf8_decode("Indicaciones: ".$i->instruction),0,'L');
    $pdf->Ln(2);
}

// Footer: Signature area
$pdf->SetY(-30);
$pdf->Line(40, $pdf->GetY(), 110, $pdf->GetY());
$pdf->SetFont('Arial','',8);
$pdf->Cell(0,5,utf8_decode("Firma y Sello del Médico"),0,1,'C');

$pdf->Output('I', "Receta-".$app->id.".pdf");
?>
