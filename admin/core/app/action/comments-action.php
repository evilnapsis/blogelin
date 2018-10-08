<?php

if(isset($_GET["opt"]) && $_GET["opt"]=="accept"){
		$category = CommentData::getById($_GET["id"]);
	$category->accept();
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="denied"){
	$category = CommentData::getById($_GET["id"]);
	$category->denied();
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$category = CommentData::getById($_GET["id"]);
	$category->del();
}
	Core::redir("./index.php?view=comments");

?>