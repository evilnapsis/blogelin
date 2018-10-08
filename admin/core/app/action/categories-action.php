<?php

if(isset($_GET["opt"]) && $_GET["opt"]=="add"){

	$user = new CategoryData();
	$user->name = $_POST["name"];
	$user->add();
	Core::redir("./?view=categories");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="update"){
	$user = CategoryData::getById($_POST["user_id"]);
	$user->name = $_POST["name"];
	$user->update();
	Core::redir("./?view=categories");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$category = CategoryData::getById($_GET["id"]);
	$category->del();
	Core::redir("./index.php?view=categories");
}

?>