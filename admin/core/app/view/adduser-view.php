<?php

if(count($_POST)>0){
	$is_admin=0;
	if(isset($_POST["is_admin"])){$is_admin=1;}
	$user = new UserData();
	$user->name = $_POST["name"];
	$user->lastname = $_POST["lastname"];
	$user->username = $_POST["username"];
	$user->email = $_POST["email"];

	$user->kind = $_POST["kind"];

	$user->clo_id = isset($_POST["clo_id"])?$_POST["clo_id"]:"NULL";
	$user->razonsocial_id = isset($_POST["razonsocial_id"])?$_POST["razonsocial_id"]:"NULL";
	$user->gerencia_id = isset($_POST["gerencia_id"])?$_POST["gerencia_id"]:"NULL";
	$user->subdireccion_id = isset($_POST["subdireccion_id"])?$_POST["subdireccion_id"]:"NULL";

	$user->password = sha1(md5($_POST["password"]));
	$user->add();

print "<script>window.location='index.php?view=users';</script>";


}


?>