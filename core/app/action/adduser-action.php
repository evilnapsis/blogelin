<?php

if(Crudadmin::valid(schema::$table_user)){
	$_POST["password"] = sha1(md5($_POST["password"]));
	Crudadmin::add(schema::$table_user,new UserData(), $_POST);
}
Core::addFlash("info","Nuevo usuario agregado exitosamente!");
Core::addFlash("warning","Este es un flash message de advertencia de ejemplo!");
Core::addFlash("danger","Este es un flash message de error de ejemplo!");
Core::redir("./?view=crud&sb=all");
?>