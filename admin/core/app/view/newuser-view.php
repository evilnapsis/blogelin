<section class="content">
<div class="row">
	<div class="col-md-12">
	<h1>Agregar Usuario
  <small>
  <?php 
  if(isset($_GET["kind"])){ 
    if($_GET["kind"]==4){echo "Gerente";}
    else if($_GET["kind"]==5){echo "Sub director";}
    else if($_GET["kind"]==6){echo "ASM";}
    else if($_GET["kind"]==7){echo "Lider de proyecto";}
    else if($_GET["kind"]==8){echo "CLO";}
  }

  ?>
</small>

  </h1>
	<br>
		<form class="form-horizontal" method="post" id="addproduct" action="index.php?view=adduser" role="form">
<input type="hidden" name="kind" value="<?php echo $_GET["kind"];?>">

  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
    <div class="col-md-6">
      <input type="text" name="name" class="form-control" id="name" placeholder="Nombre">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Apellido*</label>
    <div class="col-md-6">
      <input type="text" name="lastname" required class="form-control" id="lastname" placeholder="Apellido">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Nombre de usuario*</label>
    <div class="col-md-6">
      <input type="text" name="username" class="form-control" required id="username" placeholder="Nombre de usuario">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Email*</label>
    <div class="col-md-6">
      <input type="text" name="email" class="form-control" id="email" placeholder="Email">
    </div>
  </div>

  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Contrase&ntilde;a</label>
    <div class="col-md-6">
      <input type="password" name="password" class="form-control" id="inputEmail1" placeholder="Contrase&ntilde;a">
    </div>
  </div>

<?php if(isset($_GET["kind"]) && $_GET["kind"]==4):?>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Razon social </label>
    <div class="col-md-6">
    <select name="razonsocial_id" class="form-control" required>
    <option value="">-- SELECCIONAR --</option>
      <?php foreach(RazonsocialData::getAll() as $g):?>
        <option value="<?php echo $g->id;  ?>"><?php echo $g->name; ?></option>
      <?php endforeach; ?>
    </select>
    </div>
  </div>
<?php endif; ?>
<?php if(isset($_GET["kind"]) && $_GET["kind"]==5):?>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Subdireccion </label>
    <div class="col-md-6">
    <select name="subdireccion_id" class="form-control" required>
    <option value="">-- SELECCIONAR --</option>
      <?php foreach(SubdireccionData::getAll() as $g):?>
        <option value="<?php echo $g->id;  ?>"><?php echo $g->name; ?></option>
      <?php endforeach; ?>
    </select>
    </div>
  </div><?php endif; ?>
<?php if(isset($_GET["kind"]) && $_GET["kind"]==6):?>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Gerencia </label>
    <div class="col-md-6">
    <select name="gerencia_id" class="form-control" required>
    <option value="">-- SELECCIONAR --</option>
      <?php foreach(GerenciaData::getAll() as $g):?>
        <option value="<?php echo $g->id;  ?>"><?php echo $g->name; ?></option>
      <?php endforeach; ?>
    </select>
    </div>
  </div> 
<?php endif; ?>
<?php if(isset($_GET["kind"]) && $_GET["kind"]==7):?>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Razon social </label>
    <div class="col-md-6">
    <select name="razonsocial_id" class="form-control" required>
    <option value="">-- SELECCIONAR --</option>
      <?php foreach(RazonsocialData::getAll() as $g):?>
        <option value="<?php echo $g->id;  ?>"><?php echo $g->name; ?></option>
      <?php endforeach; ?>
    </select>
    </div>
  </div>
<?php endif; ?>

<?php if(isset($_GET["kind"]) && $_GET["kind"]==8):?>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Razon social </label>
    <div class="col-md-6">
    <select name="razonsocial_id" class="form-control" required>
    <option value="">-- SELECCIONAR --</option>
      <?php foreach(RazonsocialData::getAll() as $g):?>
        <option value="<?php echo $g->id;  ?>"><?php echo $g->name; ?></option>
      <?php endforeach; ?>
    </select>
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">CLO </label>
    <div class="col-md-6">
    <select name="clo_id" class="form-control" required>
    <option value="">-- SELECCIONAR --</option>
      <?php foreach(CloData::getAll() as $g):?>
        <option value="<?php echo $g->id;  ?>"><?php echo $g->name; ?></option>
      <?php endforeach; ?>
    </select>
    </div>
  </div>

<?php endif; ?>

  <p class="alert alert-info">* Campos obligatorios</p>

  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <button type="submit" class="btn btn-primary">Agregar Usuario</button>
    </div>
  </div>
</form>
	</div>
</div>
</section>