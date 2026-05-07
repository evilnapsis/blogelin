<?php
if(isset($_GET["opt"]) && $_GET["opt"] == "get"){
    $p = ProfessionalData::getById($_GET["id"]);
    $u = UserData::getById($p->user_id);
    header('Content-Type: application/json');
    echo json_encode(["prof"=>$p, "user"=>$u]);
    die();
}

if(isset($_GET["opt"]) && $_GET["opt"] == "add"){
    // Validation: Professional already exists for this user?
    $exists = ProfessionalData::getAllBy("user_id", $_POST["user_id"]);
    if(count($exists) > 0){
        echo "Error: Este usuario ya está vinculado a un perfil profesional.";
        die();
    }

	$p = new ProfessionalData();
	$p->user_id = $_POST["user_id"];
	$p->category_id = $_POST["category_id"];
	$p->license_number = $_POST["license_number"];
	$p->appointment_duration = $_POST["appointment_duration"];
	$p->biography = $_POST["biography"];

	if(isset($_FILES["image"]) && $_FILES["image"]["name"] != ""){
		$image = new Upload($_FILES["image"]);
		if($image->uploaded){
            $image->image_resize = true;
            $image->image_x = 400;
            $image->image_y = 400;
            $image->image_ratio_fill = true;
			$image->Process("storage/professionals/");
			if($image->processed){
				$p->image = $image->file_dst_name;
			}
		}
	}

	$res = $p->add();
	if($res[0]) echo "success";
	else echo "error";
}

if(isset($_GET["opt"]) && $_GET["opt"] == "update"){
	$p = ProfessionalData::getById($_POST["id"]);
	$p->category_id = $_POST["category_id"];
	$p->license_number = $_POST["license_number"];
	$p->appointment_duration = $_POST["appointment_duration"];
	$p->biography = $_POST["biography"];

	if(isset($_FILES["image"]) && $_FILES["image"]["name"] != ""){
		$image = new Upload($_FILES["image"]);
		if($image->uploaded){
            $image->image_resize = true;
            $image->image_x = 400;
            $image->image_y = 400;
            $image->image_ratio_fill = true;
			$image->Process("storage/professionals/");
			if($image->processed){
				$p->image = $image->file_dst_name;
			}
		}
	}

	$p->update();
	echo "success";
}

if(isset($_GET["opt"]) && $_GET["opt"] == "add_schedule"){
	$s = new ScheduleData();
	$s->professional_id = $_POST["professional_id"];
	$s->day_of_week = $_POST["day_of_week"];
	$s->start_time = $_POST["start_time"];
	$s->end_time = $_POST["end_time"];
	$res = $s->add();
	
	if($res[0]){
		echo "success";
	} else {
		echo "error";
	}
}

if(isset($_GET["opt"]) && $_GET["opt"] == "del_schedule"){
	$s = ScheduleData::getById($_GET["id"]);
	$s->del();
	echo "success";
}
?>
