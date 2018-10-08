<?php
if(Core::g("opt","all")):
?>
<div class="container">
<div class="row">
<div class="col-md-12">
<h1>CATEGORIAS</h1>
<?=Bs::a("Nuevo","./?view=cats&opt=new");?>
<br><br>
<?php Core::getFlashes(); 
$fields = Crudadmin::prepareFields(CategoryData::$schema,"view");
$labels = Crudadmin::prepareLabels(CategoryData::$schema,"view");
$users = CategoryData::getAll();
$tablearray = array();
$labels[] = "";
$tablearray["header"]=$labels;
$data = array();
foreach($users as $u){
	$d = array();
	foreach($fields as $f){
		// hacemos una comparacion cuando vallamos a mostrar imagenes, para cambiar la forma en que se van a mostrar
		$d[] = $u->{$f}; 
	}
	$d[] = Bs::a("Editar","./?view=cats&opt=edit&id=".$u->id,"warning","xs")." ".Bs::a("Eliminar","./?action=cats&opt=del&id=".$u->id,"danger","xs");
	$data[]=$d;
}
$tablearray["body"]=$data;

?>
<div class="panel panel-default">
<div class="panel-heading">Categorias</div>

<?=Table::render($tablearray);?>
</div>

</div>
</div>
</div>
<?php elseif(Core::g("opt","new")):?>
<div class="container">
<div class="row">
<div class="col-md-12">
<h1>CATEGORIAS</h1>
<h3>Nueva Categoria</h3>
<div class="panel panel-default">
<div class="panel-heading">Nuevo</div>
<div class="panel-body">

<form method="post" action="./?action=cats&opt=add" enctype="multipart/form-data">
	<?php 
	Bs::render_new(CategoryData::$schema); 
	?>
	<?=Bs::button('Agregar','submit'); ?>
</form>

</div>
</div>


</div>
</div>
</div>
<?php elseif(Core::g("opt","edit")):?>
<div class="container">
<div class="row">
<div class="col-md-12">
<h1>USUARIOS</h1>
<h3>Editar Usuario</h3>
<div class="panel panel-default">
<div class="panel-heading">Editar</div>
<div class="panel-body">

<form method="post" action="./?action=cats&opt=update" enctype="multipart/form-data">
	<?php 
	$user = CategoryData::getById($_GET["id"]);
	Bs::render_edit(CategoryData::$schema,$user); ?>
	<?=Bs::button('Actualizar','submit',"success"); 
	?>
</form>

</div>
</div>


</div>
</div>
</div>
<?php endif; ?>