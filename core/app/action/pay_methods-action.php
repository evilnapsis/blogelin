<?php
if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
    $m = new PaymentMethodData();
    $m->name = $_POST["name"];
    $m->short = $_POST["short"];
    $m->is_web = isset($_POST["is_web"]) ? 1 : 0;
    $m->is_active = 1;
    $m->add();
    echo "success";
}

if(isset($_GET["opt"]) && $_GET["opt"]=="update"){
    $m = PaymentMethodData::getById($_POST["id"]);
    $m->name = $_POST["name"];
    $m->short = $_POST["short"];
    $m->is_web = isset($_POST["is_web"]) ? 1 : 0;
    $m->is_active = $_POST["is_active"];
    $m->update();
    echo "success";
}
?>
