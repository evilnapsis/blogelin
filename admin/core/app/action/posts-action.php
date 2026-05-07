<?php

if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
	$user = new PostData();
	$user->title = Core::clean($_POST["title"]);
	$user->brief = Core::clean($_POST["brief"]);
	$user->content = Core::clean($_POST["content"]);

	$image = "";
	if(isset($_FILES["image"]) && $_FILES["image"]["name"]!=""){
		$img = new Upload($_FILES["image"]);
		if($img->uploaded){
			$img->Process("uploads/");
			if($img->processed){
				$image = $img->file_dst_name;
			}
		}
	}
	$user->image = $image;
	$user->category_id = $_POST["category_id"];
	$user->add();
	ob_clean();
	echo "success";
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="update"){
	$user = PostData::getById($_POST["id"]);
	$user->title = Core::clean($_POST["title"]);
	$user->brief = Core::clean($_POST["brief"]);
	$user->content = Core::clean($_POST["content"]);

	$image = $user->image;
	if(isset($_FILES["image"]) && $_FILES["image"]["name"]!=""){
		$img = new Upload($_FILES["image"]);
		if($img->uploaded){
			$img->Process("uploads/");
			if($img->processed){
				$image = $img->file_dst_name;
			}
		}
	}
	$user->image = $image;

	$user->category_id = $_POST["category_id"];
	$user->status = isset($_POST["status"])?1:0;

	$user->update();
	ob_clean();
	echo "success";
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$category = PostData::getById($_GET["id"]);
	$category->del();
	Core::redir("./index.php?view=posts");
}

?>
