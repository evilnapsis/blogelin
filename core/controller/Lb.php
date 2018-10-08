<?php


// 14 de Octubre del 2014
// Lb.php
// @brief el objeto legobox
// estoy inspirado : 14/oct/2014 - 0:55am - viendo : un millon de formas de morir en el oeste por 2da vez el dia de hoy
class Lb {

	public function Lb(){
	}

	public function start(){
		if(isset($_GET)){
			foreach($_GET as $k=>$v){
				Core::$get[$k]=$v;
			}
		}
		if(isset($_POST)){
			foreach($_POST as $k=>$v){
				Core::$post[$k]=$v;
			}
		}
		include "core/app/autoload.php";
		include "core/app/init.php";
	}

}

?>