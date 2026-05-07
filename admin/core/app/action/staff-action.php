<?php
$opt = isset($_GET["opt"]) ? $_GET["opt"] : "";

if($opt == "add") {
    // 1. Crear Usuario
    $u = new UserData();
    $u->name = $_POST["name"];
    $u->lastname = $_POST["lastname"];
    $u->email = $_POST["email"];
    $u->username = $_POST["username"];
    $u->password = sha1(md5($_POST["password"]));
    $u->rol_id = 2; // 2 = Staff
    $u->is_active = 1;
    $user_id = $u->add();

    // 2. Crear Staff
    $s = new StaffData();
    $s->user_id = $user_id[1];
    $s->position = $_POST["position"];
    $s->add();

    Core::redir("./?view=staff&opt=all");
}

if($opt == "update") {
    // 1. Actualizar Usuario
    $u = UserData::getById($_POST["user_id"]);
    $u->name = $_POST["name"];
    $u->lastname = $_POST["lastname"];
    $u->email = $_POST["email"];
    $u->username = $_POST["username"];
    if($_POST["password"] != "") {
        $u->password = sha1(md5($_POST["password"]));
        $u->update_passwd();
    }
    $u->update();

    // 2. Actualizar Staff
    $s = StaffData::getById($_POST["id"]);
    $s->position = $_POST["position"];
    $s->update();

    Core::redir("./?view=staff&opt=all");
}

if($opt == "del") {
    $s = StaffData::getById($_GET["id"]);
    $user_id = $s->user_id;
    
    $s->del();
    UserData::getById($user_id)->del();

    Core::redir("./?view=staff&opt=all");
}
?>
