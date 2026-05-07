<?php

if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
	$user = new CategoryData();
	$user->name = Core::clean($_POST["name"]);
	$user->add();
	ob_clean();
	echo "success";
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="update"){
	$user = CategoryData::getById($_POST["id"]);
	$user->name = Core::clean($_POST["name"]);
	$user->update();
	ob_clean();
	echo "success";
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$category = CategoryData::getById($_GET["id"]);
	$category->del();
	Core::redir("./index.php?view=categories");
}

?>
