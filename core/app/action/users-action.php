<?php

if(Core::g("sa","add")){
if(Crudadmin::valid(UserData::$schema)){
	Core::$post["password"] = sha1(md5(Core::$post["password"]));
	Core::$post["image"] = Form::upload("image","storage/images");

	Crudadmin::add(UserData::$schema,new UserData(), Core::$post);

	Core::addFlash("info","Nuevo usuario agregado exitosamente!");
	Core::addFlash("warning","Este es un flash message de advertencia de ejemplo!");
	Core::addFlash("danger","Este es un flash message de error de ejemplo!");
}
Core::redir("./?view=crud&sb=all");
}
else if(Core::g("sa","update")){
if(Crudadmin::valid(UserData::$schema)){
	$user = UserData::getById(Core::$post["id"]);
	if(Core::$post["password"]!=""){ 	Core::$post["password"] = sha1(md5(Core::$post["password"])); }
	Core::$post["image"] = Form::upload("image","storage/images");
	// en caso de que no se suba ninguna image, seguimos conservando la que ya tenemos
	if(Core::$post["image"]==""){ Core::$post["image"]=$user->image;}
	Crudadmin::update(UserData::$schema,$user, Core::$post);
	Core::addFlash("success","Usuario actualizado exitosamente!");
}
Core::redir("./?view=crud&sb=all");
}
else if(Core::g("sa","del")){
	$u  = UserData::getById($_GET["id"]);
	$u->del();
	Core::addFlash("danger","[#$u->id] Eliminado exitosamente!");
	Core::redir("./?view=crud&sb=all");
}
?>