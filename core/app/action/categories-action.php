<?php
if(isset($_GET["opt"]) && $_GET["opt"] == "add"){
	$cat = new CategoryData();
	$cat->name = $_POST["name"];
	$cat->color = $_POST["color"];
	$res = $cat->add();
	
	if($res[0]){
		echo "success";
	} else {
		echo "error";
	}
}
?>
