<?php
/**
* events-action.php - BookStyle Pro
*/

$appointments = [];
if(isset($_GET["professional_id"]) && $_GET["professional_id"] != ""){
    $appointments = AppointmentData::getAllByProfessional($_GET["professional_id"]);
} else {
    $appointments = AppointmentData::getAll();
}

$events = [];
foreach($appointments as $app){
    $person = PersonData::getById($app->person_id);
    $professional = ProfessionalData::getById($app->professional_id);
    $user_pro = UserData::getById($professional->user_id);
    $service = ProductData::getById($app->product_id);
    $category = CategoryData::getById($service->category_id);

    $events[] = [
        "id" => $app->id,
        "title" => ($person ? $person->name : "Público")." | " . ($service ? $service->name : "Servicio"),
        "start" => $app->date."T".$app->time,
        "backgroundColor" => ($category && $category->color) ? $category->color : "#6366f1",
        "borderColor" => ($category && $category->color) ? $category->color : "#6366f1",
        "extendedProps" => [
            "status" => $app->status,
            "person" => $person ? ($person->name." ".$person->lastname) : "Público General",
            "professional" => $user_pro->name." ".$user_pro->lastname,
            "service" => $service ? $service->name : "N/A"
        ]
    ];
}

header('Content-Type: application/json');
echo json_encode($events);
?>
