<section class="content">
<div class="row">
	<div class="col-md-12">
		<h1>Comentarios</h1>

<br>
		<?php

		$users = CommentData::getAll();
		if(count($users)>0){
			// si hay usuarios
			?>
<div class="box box-primary">
<div class="box-body">
			<table class="table table-bordered table-hover datatable">
			<thead>
			<th>Nombre completo</th>
      <th>Email</th>
      <th>Comentario</th>
      <th>Articulo</th>
      <th>Status</th>
     <th>Creacion</th>
 			<th></th>
			</thead>
			<?php
			foreach($users as $user){
        $job = PostData::getById($user->post_id);
				?>
				<tr>
 		<td><?php echo $user->name." ".$user->lastname; ?></td>
        <td><?php echo $user->email; ?></td>
        <td><?php echo $user->comment; ?></td>
        <td><?php echo $job->title; ?></td>
       <td><?php
       switch ($user->status) {
         case 1: echo "Pendiente"; break;
         case 2: echo "Aceptado"; break;
         case 0: echo "Rechazado"; break;
         
         default:break;
       }
       ?></td>
        <td><?php echo $user->created_at; ?></td>
				<td style="width:180px;">
<a href="index.php?action=comments&opt=accept&id=<?php echo $user->id;?>" class="btn btn-info btn-xs">Aceptar</a>
<a href="index.php?action=comments&opt=denied&id=<?php echo $user->id;?>" class="btn btn-danger btn-xs">Rechazar</a>

<a href="index.php?action=comments&opt=del&id=<?php echo $user->id;?>" class="btn btn-danger btn-xs">Eliminar</a></td>
				</tr>
				<?php

			}

				?>
				</table>
				</div>
				</div>
				<?php


		}else{
			echo "<p class='alert alert-danger'>No hay Comentarios</p>";
		}


		?>


	</div>
</div>

</section>