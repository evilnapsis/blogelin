<?php
// autoload.php
// [created] 10 octubre del 2014
// [rebuilded] 9 abril del 2016
// esta funcion elimina el hecho de estar agregando los modelos manualmente
// by evilnapsis

function __autoload($modelname){
	if(Model::exists($modelname)){
		include Model::getFullPath($modelname);
	} 
}



?>