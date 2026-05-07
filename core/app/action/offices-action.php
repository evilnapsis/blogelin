<?php
$opt = isset($_GET["opt"]) ? $_GET["opt"] : "";

if($opt == "add") {
    $o = new OfficeData();
    $o->name = $_POST["name"];
    $o->location = $_POST["location"];
    $o->add();
    Core::redir("./?view=offices&opt=all");
}

if($opt == "update") {
    $o = OfficeData::getById($_POST["id"]);
    $o->name = $_POST["name"];
    $o->location = $_POST["location"];
    $o->update();
    Core::redir("./?view=offices&opt=all");
}

if($opt == "del") {
    $o = OfficeData::getById($_GET["id"]);
    $o->del();
    Core::redir("./?view=offices&opt=all");
}
?>
