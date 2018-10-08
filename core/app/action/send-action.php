<?php

if(isset($_POST["accept"])){

			$person  = new CommentData();
			$person->name = $_POST["name"];
			$person->email = $_POST["email"];
			$person->comment = $_POST["comment"];
			$person->post_id = $_POST["post_id"];
			$person->add();
			Core::alert("Informacion enviada exitosamente!");
				
}
Core::redir("./?view=post&id=$_POST[post_id]");
?>