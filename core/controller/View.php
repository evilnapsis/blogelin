<?php


// 13 de Abril del 2014
// View.php
// @brief Una vista corresponde a cada componente visual dentro de un modulo.

class View {
	/**
	* @function load
	* @brief la funcion load carga una vista correspondiente a un modulo
	**/	
	public static function load($view){
		// Module::$module;
		if(!isset($_GET['view'])){
			include "core/app/view/".$view."-view.php";
		}else{


			if(View::isValid()){
				include "core/app/view/".$_GET['view']."-view.php";				
			}else{
				View::Error("<b>404 NOT FOUND</b> View <b>".$_GET['view']."</b> folder !! - <a href='http://evilnapsis.com/legobox/help/' target='_blank'>Help</a>");
			}
		}
	}

	public static function load_subview(){
		// Module::$module;
		if(isset($_GET['view'])!="" && isset($_GET["sb"])!=""){
			if(View::isValid()){
				$sb_src = "core/app/subview/".$_GET["view"].".".$_GET["sb"].".php";
				if(file_exists($sb_src)){
					include $sb_src;
				}else{
					View::Error("<p class='alert alert-warning'>File not found <i>".$sb_src."</i></p>");
				}
			}
		}
	}


	/**
	* @function isValid
	* @brief valida la existencia de una vista
	**/	
	public static function isValid(){
		$valid=false;
		if(isset($_GET["view"])){
			if(file_exists($file = "core/app/view/".$_GET['view']."-view.php")){
				$valid = true;
			}
		}
		return $valid;
	}

	public static function Error($message){
		print $message;
	}

}



?>