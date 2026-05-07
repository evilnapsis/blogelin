<?php
/**
* consultation-action.php
*/
$opt = isset($_GET["opt"]) ? $_GET["opt"] : "";

if($opt == "add_prescription_item") {
    $appointment_id = $_POST["appointment_id"];
    $patient_id = $_POST["patient_id"];
    $doctor_id = $_POST["doctor_id"];
    
    // 1. Verificar si ya existe una receta para esta cita
    $p = PrescriptionData::getByAppointment($appointment_id);
    if(!$p) {
        $p = new PrescriptionData();
        $p->appointment_id = $appointment_id;
        $p->patient_id = $patient_id;
        $p->doctor_id = $doctor_id;
        $res = $p->add();
        $p->id = $res[1];
    }

    // 2. Agregar el item (medicamento)
    $item = new PrescriptionItemData();
    $item->prescription_id = $p->id;
    $item->drug_id = $_POST["drug_id"];
    $item->instruction = $_POST["instruction"];
    $item->add();

    Core::redir("./?view=consultation&id=".$appointment_id);
}

if($opt == "del_prescription_item") {
    $item = new PrescriptionItemData();
    $item->id = $_GET["id"];
    $item->del(); // Asumiendo que del() está en Extra o se implementó en PrescriptionItemData
    Core::redir("./?view=consultation&id=".$_GET["appointment_id"]);
}

if($opt == "add_rating") {
    $r = new DoctorRatingData();
    $r->doctor_id = $_POST["doctor_id"];
    $r->patient_id = $_POST["patient_id"];
    $r->stars = $_POST["stars"];
    $r->comment = $_POST["comment"];
    $r->add();
    
    Core::redir("./?view=consultation&id=".$_POST["appointment_id"]);
}
?>
