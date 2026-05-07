<?php
/**
* catalogs-action.php
*/
$opt = isset($_GET["opt"]) ? $_GET["opt"] : "";

if($opt == "add_diagnosis") {
    $d = new DiagnosisData();
    $d->code = $_POST["code"];
    $d->name = $_POST["name"];
    $d->add();
    Core::redir("./?view=catalogs&opt=diagnoses");
}

if($opt == "del_diagnosis") {
    $d = DiagnosisData::getById($_GET["id"]);
    $d->del();
    Core::redir("./?view=catalogs&opt=diagnoses");
}

if($opt == "add_drug") {
    $d = new DrugData();
    $d->name = $_POST["name"];
    $d->generic_name = $_POST["generic_name"];
    $d->dosage = $_POST["dosage"];
    $d->add();
    Core::redir("./?view=catalogs&opt=drugs");
}

if($opt == "del_drug") {
    $d = DrugData::getById($_GET["id"]);
    $d->del();
    Core::redir("./?view=catalogs&opt=drugs");
}

if($opt == "import_csv") {
    $type = $_POST["type"];
    if(isset($_FILES["csv"]) && $_FILES["csv"]["size"] > 0) {
        $file = fopen($_FILES["csv"]["tmp_name"], "r");
        while(($data = fgetcsv($file, 1000, ",")) !== FALSE) {
            if($type == "diagnoses") {
                $d = new DiagnosisData();
                $d->code = $data[0];
                $d->name = $data[1];
                $d->add();
            } else {
                $d = new DrugData();
                $d->name = $data[0];
                $d->generic_name = $data[1];
                $d->dosage = $data[2];
                $d->add();
            }
        }
        fclose($file);
    }
    Core::redir("./?view=catalogs&opt=".$type);
}
?>
