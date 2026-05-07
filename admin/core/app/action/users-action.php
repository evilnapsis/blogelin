<?php
/**
* users-action.php - Blogelin
*/

if(isset($_GET["opt"]) && $_GET["opt"] == "add"){
	$u = new UserData();
	$u->name = Core::clean($_POST["name"]);
	$u->lastname = Core::clean($_POST["lastname"]);
	$u->username = Core::clean($_POST["username"]);
	$u->email = Core::clean($_POST["email"]);
	$u->password = sha1(md5($_POST["password"]));
	$u->kind = $_POST["kind"];
	$u->status = 1;
	$u->add();
	ob_clean();
	echo "success";
}

if(isset($_GET["opt"]) && $_GET["opt"] == "get"){
    $u = UserData::getById($_GET["id"]);
    header('Content-Type: application/json');
    echo json_encode($u);
    die();
}

if(isset($_GET["opt"]) && $_GET["opt"] == "update"){
	$u = UserData::getById($_POST["id"]);
	$u->name = Core::clean($_POST["name"]);
	$u->lastname = Core::clean($_POST["lastname"]);
	$u->username = Core::clean($_POST["username"]);
	$u->email = Core::clean($_POST["email"]);
	$u->kind = $_POST["kind"];
	$u->status = isset($_POST["status"]) ? 1 : 0;
	$u->update();

    if($_POST["password"] != ""){
        $u->password = sha1(md5($_POST["password"]));
        $u->update_passwd();
    }
	ob_clean();
	echo "success";
}

if(isset($_GET["opt"]) && $_GET["opt"] == "del"){
	$u = UserData::getById($_GET["id"]);
	$u->del();
	ob_clean();
	echo "success";
}
?>
