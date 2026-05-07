<?php
if(isset($_GET["opt"]) && $_GET["opt"] == "get"){
    $p = PersonData::getById($_GET["id"]);
    header('Content-Type: application/json');
    echo json_encode($p);
    die();
}

if(isset($_GET["opt"]) && $_GET["opt"] == "add"){
	$person = new PersonData();
	$person->name = $_POST["name"];
	$person->lastname = $_POST["lastname"];
	$person->company = $_POST["company"];
	$person->email = $_POST["email"];
	$person->phone = $_POST["phone"];
	$person->address = $_POST["address"];
	$person->kind = $_POST["kind"];
	$res = $person->add();
	if($res[0]){ echo "success"; } else { echo "error"; }
}

if(isset($_GET["opt"]) && $_GET["opt"] == "update"){
	$person = PersonData::getById($_POST["id"]);
	$person->name = $_POST["name"];
	$person->lastname = $_POST["lastname"];
	$person->company = $_POST["company"];
	$person->email = $_POST["email"];
	$person->phone = $_POST["phone"];
	$person->address = $_POST["address"];
	$person->kind = $_POST["kind"];
	$person->update();
	echo "success";
}

if(isset($_GET["opt"]) && $_GET["opt"] == "del"){
    $p = PersonData::getById($_GET["id"]);
    $p->del();
    Core::redir("./?view=persons&opt=all");
}
?>
