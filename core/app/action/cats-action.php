<?php

if(Core::g("opt","add")){
if(Crudadmin::valid(CategoryData::$schema)){
	Crudadmin::add(CategoryData::$schema,new CategoryData(), Core::$post);

	Core::addFlash("info","Nueva categoria agregado exitosamente!");
}
Core::redir("./?view=cats&opt=all");
}
else if(Core::g("opt","update")){
if(Crudadmin::valid(CategoryData::$schema)){
	$user = CategoryData::getById(Core::$post["id"]);
	Crudadmin::update(CategoryData::$schema,$user, Core::$post);
	Core::addFlash("success","Categoria actualizada exitosamente!");
}
Core::redir("./?view=cats&opt=all");
}
else if(Core::g("opt","del")){
	$u  = CategoryData::getById($_GET["id"]);
	$u->del();
	Core::addFlash("danger","[#$u->id] Eliminada exitosamente!");
	Core::redir("./?view=cats&opt=all");
}
?>