<?php
session_start();
// ---
// la tarea de este archivo es eliminar todo rastro de cookie
$is_pacient = false;
if(isset($_SESSION["pacient_id"])){ $is_pacient=true; }

	unset($_SESSION['user_id']);
	unset($_SESSION['pacient_id']);

session_destroy();
// v0 29 jul 2013
//estemos donde estemos nos redirije al index
if($is_pacient){
print "<script>window.location='./?view=pacientlogin';</script>";	
}
print "<script>window.location='./';</script>";
?>