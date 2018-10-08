<?php

if(Core::g("opt","add")){
if(Crudadmin::valid(ProductData::$schema)){
	Core::$post["image"] = Form::upload("image","storage/images");
	Core::$post["category_id"]=Core::$post["category_id"]!=""?Core::$post["category_id"]:"NULL";
	Crudadmin::add(ProductData::$schema,new ProductData(), Core::$post);

	Core::addFlash("info","Nueva categoria agregado exitosamente!");
}
//Core::redir("./?view=products&opt=all");
}
else if(Core::g("opt","update")){
if(Crudadmin::valid(ProductData::$schema)){
	$user = ProductData::getById(Core::$post["id"]);
	Core::$post["image"] = Form::upload("image","storage/images");

	if(Core::$post["image"]==""){ Core::$post["image"]=$user->image;}

	Crudadmin::update(ProductData::$schema,$user, Core::$post);
	Core::addFlash("success","Categoria actualizada exitosamente!");
}
Core::redir("./?view=products&opt=all");
}
else if(Core::g("opt","del")){
	$u  = ProductData::getById($_GET["id"]);
	$u->del();
	Core::addFlash("danger","[#$u->id] Eliminada exitosamente!");
	Core::redir("./?view=products&opt=all");
}
?>