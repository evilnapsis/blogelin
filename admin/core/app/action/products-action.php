<?php
if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
	$p = new ProductData();
	$p->name = $_POST["name"];
	$p->kind = $_POST["kind"];
	$p->category_id = $_POST["category_id"];
	$p->price_out = $_POST["price_out"];
	
	if($p->kind == 1){
		$p->stock = $_POST["value"];
	} else {
		$p->duration = $_POST["value"];
	}
	
	$p->add();
	print "success";
}
?>
