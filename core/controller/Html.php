<?php

/**
@author: evilnapsis
@brief: Clase con funciones para minimizar el codigo HTML
**/

class Html{

	/* funcion para el tutilo de la pagina*/
	public static function title($title){
		return "<title>".$title."</title>";
	}
	/* funcion para agregar los links css*/
	public static function link($link){
		return "<link href=\"".$link."\" rel='stylesheet'>";
	}
	/* funcion para agregar los scripts js*/
	public static function script($script){
		return "<script src=\"".$script."\"></script>";
	}
}




?>