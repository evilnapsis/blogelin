<div class="container">
<div class="row">
<div class="col-md-12">
<h1>EVILNAPSIS</h1>
<?=Bs::a("Nuevo","./?view=crud&sb=new");?>
<br><br>
<?php Core::getFlashes(); 
$fields = Crudadmin::prepareFields(UserData::$schema,"view");
$labels = Crudadmin::prepareLabels(UserData::$schema,"view");
$users = UserData::getAll();
$tablearray = array();
$labels[] = "";
$tablearray["header"]=$labels;
$data = array();
foreach($users as $u){
	$d = array();
	foreach($fields as $f){
		// hacemos una comparacion cuando vallamos a mostrar imagenes, para cambiar la forma en que se van a mostrar
		if($f=="image"){
			if($u->{$f}!=""){
				$d[]= "<img src='storage/images/".$u->{$f}."' style='width: 48px; height:48px;'>";
			}else{
				$d[]="";
			}
		}else{
			$d[] = $u->{$f}; 
		}

	}
	$d[] = Bs::a("Editar","./?view=crud&sb=edit&id=".$u->id,"warning","xs")." ".Bs::a("Eliminar","./?action=users&sa=del&id=".$u->id,"danger","xs");
	$data[]=$d;
}
$tablearray["body"]=$data;

?>


<div class="panel panel-default">
<div class="panel-heading">Usuarios</div>

<?=Table::render($tablearray);?>


</div>


</div>
</div>
</div>