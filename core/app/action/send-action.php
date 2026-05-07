<?php

if(isset($_POST["accept"])){

			$person  = new CommentData();
			$person->name = Core::clean($_POST["name"]);
			$person->email = Core::clean($_POST["email"]);
			$person->comment = Core::clean($_POST["comment"]);
			$person->post_id = $_POST["post_id"];
			$person->add();
			Core::alert("Informacion enviada exitosamente!");
				
}
Core::redir("./?view=post&id=$_POST[post_id]");
?>