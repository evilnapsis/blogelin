<?php
/**
* appointments-action.php - BookStyle Pro
*/

// Endpoint: Search Clients
if(isset($_GET["opt"]) && $_GET["opt"]=="search_clients"){
    $q = $_GET["q"];
    $clients = PersonData::getLike($q);
    $data = [];
    foreach($clients as $c){
        $data[] = ["id" => $c->id, "text" => $c->name." ".$c->lastname." (".$c->phone.")"];
    }
    header('Content-Type: application/json');
    echo json_encode($data);
    die();
}

// Endpoint: Get Professionals by Service (V2 - Grid with Availability)
if(isset($_GET["opt"]) && $_GET["opt"]=="get_staff_grid"){
    $service_id = $_GET["service_id"];
    $date = $_GET["date"];
    $service = ProductData::getById($service_id);
    $professionals = ProfessionalData::getAllByCategory($service->category_id);
    $day_of_week = date("N", strtotime($date));
    
    $html = '<div class="row g-3">';
    foreach($professionals as $p){
        $u = UserData::getById($p->user_id);
        
        // Availability Logic
        $schedules = ScheduleData::getAllByProfessionalAndDay($p->id, $day_of_week);
        $total_slots = 0;
        $free_slots = 0;
        
        if(count($schedules) > 0){
            foreach($schedules as $s){
                $start = strtotime($s->start_time);
                $end = strtotime($s->end_time);
                $duration = $p->appointment_duration * 60;
                for($i = $start; $i < $end; $i += $duration){
                    $total_slots++;
                    $time = date("H:i", $i);
                    // Check if occupied
                    $sql = "select * from appointment where professional_id=$p->id and date=\"$date\" and time=\"$time\" and status!=\"cancelled\"";
                    $occ = Executor::doit($sql);
                    if($occ[0]->num_rows == 0) $free_slots++;
                }
            }
        }

        $is_available = ($free_slots > 0);
        $opacity = $is_available ? '1' : '0.5';
        $grayscale = $is_available ? '' : 'filter: grayscale(100%);';
        $click = $is_available ? 'onclick="selectProfessional('.$p->id.', \''.$u->name.'\')"' : 'style="cursor:not-allowed"';
        
        $html .= '
        <div class="col-md-4">
            <div class="card h-100 border-2 staff-card '.($is_available ? 'active shadow-sm' : 'unavailable bg-light').'" '.$click.' style="opacity:'.$opacity.'; '.$grayscale.' transition: 0.3s; border-radius: 15px;">
                <div class="card-body p-3 text-center">
                    <div class="avatar-container mb-2">
                        '.($p->image ? '<img src="storage/professionals/'.$p->image.'" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">' : '<div class="bg-indigo-100 text-indigo-700 rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;"><i class="bi bi-person fs-3"></i></div>').'
                    </div>
                    <h6 class="fw-bold mb-1">'.$u->name.'</h6>
                    <p class="small text-muted mb-2">'.($is_available ? '<span class="badge bg-emerald-100 text-emerald-700">'.$free_slots.' disponibles</span>' : '<span class="badge bg-secondary">Sin espacio</span>').'</p>
                </div>
            </div>
        </div>';
    }
    $html .= '</div>';
    echo $html;
    die();
}

// Endpoint: Get Professionals by Service

// Endpoint: Get Slots
if(isset($_GET["opt"]) && $_GET["opt"]=="get_slots"){
    $date = $_GET["date"];
    $professional_id = $_GET["professional_id"];
    $professional = ProfessionalData::getById($professional_id);
    $day_of_week = date("N", strtotime($date));
    $schedules = ScheduleData::getAllByProfessionalAndDay($professional_id, $day_of_week);
    
    $html = "";
    if(count($schedules) > 0){
        foreach($schedules as $s){
            $start = strtotime($s->start_time);
            $end = strtotime($s->end_time);
            $duration = $professional->appointment_duration * 60;
            for($i = $start; $i < $end; $i += $duration){
                $time = date("H:i", $i);
                $html .= '<button type="button" class="btn btn-outline-indigo m-1 fw-bold slot-btn" onclick="selectSlot(\''.$time.'\')">'.$time.'</button>';
            }
        }
    } else {
        $html = '<div class="text-danger small py-2 fw-bold">No hay disponibilidad.</div>';
    }
    echo $html;
    die();
}

if(isset($_GET["opt"]) && $_GET["opt"]=="checkin"){
    $a = AppointmentData::getById($_POST["appointment_id"]);
    $a->office_id = $_POST["office_id"];
    $a->status = "En Servicio";
    $a->checkin();
    echo "success";
    die();
}

if(isset($_GET["opt"]) && $_GET["opt"]=="finish"){
    $a = AppointmentData::getById($_GET["id"]);
    $a->finish();
    echo "success";
    die();
}

if(isset($_GET["opt"]) && $_GET["opt"]=="add_payment"){
    $p = new PaymentData();
    $p->appointment_id = $_POST["appointment_id"];
    $p->amount = $_POST["amount"];
    $p->payment_method_id = $_POST["payment_method_id"];
    $p->add();
    echo "success";
    die();
}

// Main Action: Add Appointment
if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
    
    $a = new AppointmentData();
    // If new person, create it first
    if($_POST["person_id"]=="new" || $_POST["person_id"]==""){
        $p = new PersonData();
        $p->name = $_POST["client_name"];
        $p->lastname = $_POST["client_lastname"];
        $p->email = $_POST["client_email"];
        $p->phone = $_POST["client_phone"];
        $p->kind = 1; // Client
        $res_p = $p->add();
        $a->person_id = $res_p[1];
    } else {
        $a->person_id = $_POST["person_id"];
    }

    $a->professional_id = (isset($_POST["professional_id"]) && $_POST["professional_id"]!="") ? $_POST["professional_id"] : 0;
    $a->product_id = (isset($_POST["product_id"]) && $_POST["product_id"]!="") ? $_POST["product_id"] : 0;
    $a->office_id = (isset($_POST["office_id"]) && $_POST["office_id"]!="") ? $_POST["office_id"] : 1;
    $a->date = $_POST["date"];
    $a->time = $_POST["time"];
    $a->reason = $_POST["reason"];
    $a->status = "pending";
    $a->payment_method_id = (isset($_POST["payment_method_id"]) && $_POST["payment_method_id"]!="") ? $_POST["payment_method_id"] : "NULL";
    $a->kind = 1; // Internal
    
    // Safety check for SQL
    if($a->person_id == 0 || $a->professional_id == 0 || $a->product_id == 0){
        echo "Error: Faltan datos obligatorios (Cliente, Profesional o Servicio).";
        die();
    }

    $res = $a->add();

    if($res[0]){ echo "success"; } else { echo "error"; }
}

else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
    $a = AppointmentData::getById($_GET["id"]);
    $a->del();
    Core::redir("./?view=appointments&opt=list");
}
?>
