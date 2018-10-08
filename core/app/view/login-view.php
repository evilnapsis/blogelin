<div class="container">
<div class="row">
<h1 class="text-center">EVILNAPSIS</h1>
<div class="col-md-12">
<div class="row">
<div class="col-md-4 col-md-offset-4">
<div class="panel panel-default">
<div class="panel-heading text-center">Login</div>
<div class="panel-body">

<form method="post" action="./?action=access&o=login">
  <div class="form-group">
    <label for="exampleInputEmail1">Nombre de usuario</label>
    <input type="text" required name="username" class="form-control" id="exampleInputEmail1" placeholder="Nombre de usuario">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" required name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
  </div>
  <button type="submit" class="btn btn-default">Acceder</button>
</form>

</div>
</div>
</div>


</div>
<?php
//$user = UserData::getBy("id",2);
//$user->del();
//print_r($user);
?>

</div>
</div>
</div>