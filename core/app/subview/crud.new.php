<div class="container">
<div class="row">
<div class="col-md-12">
<h1>USUARIOS</h1>
<h3>Nuevo Usuario</h3>
<div class="panel panel-default">
<div class="panel-heading">Nuevo</div>
<div class="panel-body">

<form method="post" action="./?action=users&sa=add" enctype="multipart/form-data">
	<?php 
	Bs::render_new(UserData::$schema); 
	?>
	<?=Bs::button('Guardar','submit','primary'); ?>
</form>

</div>
</div>


</div>
</div>
</div>