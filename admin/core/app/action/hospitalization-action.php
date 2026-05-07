<?php
$opt = isset($_GET["opt"]) ? $_GET["opt"] : "";

if($opt == "admit") {
    if(!isset($_POST["bed_id"]) || $_POST["bed_id"] == "") {
        Core::alert("Error: Debe seleccionar una cama disponible.");
        Core::redir("./?view=hospitalization");
        exit;
    }

    $h = new HospitalizationData();
    $h->patient_id = $_POST["patient_id"];
    $h->doctor_id = $_POST["doctor_id"];
    $h->bed_id = $_POST["bed_id"];
    $h->initial_diagnosis = $_POST["initial_diagnosis"];
    $h->status = "active";
    $h->add();

    // Cambiar estado de la cama
    $bed = BedData::getById($h->bed_id);
    if($bed) {
        $old_status = $bed->status;
        $bed->status = "occupied";
        $sql = "update bed set status='occupied' where id=$bed->id";
        Executor::doit($sql);
        // Log
        BedLogData::log($bed->id, $old_status, "occupied", $_SESSION["user_id"]);
    }

    Core::redir("./?view=hospitalization");
}

if($opt == "discharge") {
    $h = HospitalizationData::getById($_POST["id"]);
    $h->status = "discharged";
    $h->end_date = date("Y-m-d H:i:s");
    $h->update();

    // Liberar cama (pasándola a limpieza)
    $bed = BedData::getById($h->bed_id);
    if($bed) {
        $old_status = $bed->status;
        $bed->status = "cleaning";
        $sql = "update bed set status='cleaning' where id=$bed->id";
        Executor::doit($sql);
        // Log
        BedLogData::log($bed->id, $old_status, "cleaning", $_SESSION["user_id"]);
    }

    Core::redir("./?view=hospitalization");
}

if($opt == "clean_bed") {
    $bed = BedData::getById($_GET["id"]);
    $old_status = $bed->status;
    $bed->status = "available";
    $sql = "update bed set status='available' where id=$bed->id";
    Executor::doit($sql);
    // Log
    BedLogData::log($bed->id, $old_status, "available", $_SESSION["user_id"]);
    Core::redir("./?view=hospitalization");
}

if($opt == "transfer_patient") {
    $h = HospitalizationData::getById($_POST["id"]);
    $old_bed_id = $h->bed_id;
    $new_bed_id = $_POST["new_bed_id"];

    // 1. Liberar cama anterior (limpieza)
    $old_bed = BedData::getById($old_bed_id);
    $old_bed_status = $old_bed->status;
    $sql1 = "update bed set status='cleaning' where id=$old_bed_id";
    Executor::doit($sql1);
    BedLogData::log($old_bed_id, $old_bed_status, "cleaning", $_SESSION["user_id"]);

    // 2. Ocupar nueva cama
    $new_bed = BedData::getById($new_bed_id);
    $new_bed_status = $new_bed->status;
    $sql2 = "update bed set status='occupied' where id=$new_bed_id";
    Executor::doit($sql2);
    BedLogData::log($new_bed_id, $new_bed_status, "occupied", $_SESSION["user_id"]);

    // 3. Actualizar hospitalización
    $h->bed_id = $new_bed_id;
    $h->update();

    Core::redir("./?view=hospital_detail&id=".$h->id);
}

if($opt == "add_vital") {
    $v = new NursingVitalData();
    $v->hospitalization_id = $_POST["hospitalization_id"];
    $v->user_id = $_SESSION["user_id"];
    $v->heart_rate = $_POST["heart_rate"];
    $v->temperature = $_POST["temperature"];
    $v->systolic_bp = $_POST["systolic_bp"];
    $v->diastolic_bp = $_POST["diastolic_bp"];
    $v->respiratory_rate = $_POST["respiratory_rate"];
    $v->spo2 = $_POST["spo2"];
    $v->weight = $_POST["weight"];
    $v->add();
    Core::redir("./?view=hospital_detail&id=".$v->hospitalization_id."&tab=nursing");
}

if($opt == "add_soap") {
    $n = new EvolutionNoteData();
    $n->patient_id = $_POST["patient_id"];
    $n->hospitalization_id = $_POST["hospitalization_id"] != "" ? $_POST["hospitalization_id"] : null;
    $n->doctor_id = $_SESSION["user_id"]; // Or doctor assigned
    $n->s_text = $_POST["s_text"];
    $n->o_text = $_POST["o_text"];
    $n->a_text = $_POST["a_text"];
    $n->p_text = $_POST["p_text"];
    $n->add();
    
    if($n->hospitalization_id) {
        Core::redir("./?view=hospital_detail&id=".$n->hospitalization_id."&tab=evolution");
    } else {
        Core::redir("./?view=patient_detail&id=".$n->patient_id);
    }
}

// Catálogos
if($opt == "addroom") {
    $r = new RoomData();
    $r->name = $_POST["name"];
    $r->category = $_POST["category"];
    $r->status = 1;
    $r->add();
    Core::redir("./?view=hospitalization&opt=rooms");
}

if($opt == "addbed") {
    $b = new BedData();
    $b->name = $_POST["name"];
    $b->room_id = $_POST["room_id"];
    $b->status = "available";
    $b->add();
    Core::redir("./?view=hospitalization&opt=beds");
}

if($opt == "addfluidcat") {
    $f = new FluidCategoryData();
    $f->name = $_POST["name"];
    $f->type = $_POST["type"];
    $f->add();
    Core::redir("./?view=hospitalization&opt=fluid_categories");
}
?>
