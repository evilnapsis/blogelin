<?php
$person = PersonData::getById($_GET["id"]);
$appointments = AppointmentData::getAllByPersonId($person->id);
?>
<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center mb-4">
            <div>
                <a href="./?view=persons&opt=all" class="btn btn-light btn-sm rounded-circle me-3"><i class="bi bi-arrow-left"></i></a>
                <h1 class="h3 fw-bold mb-0">Ficha de <?php echo $person->kind==1 ? "Cliente" : "Proveedor"; ?></h1>
                <p class="text-muted mb-0">Información detallada e historial de actividades</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4 text-center">
                        <div class="avatar avatar-xl bg-indigo-100 text-indigo-700 rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-person fs-1"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-1"><?php echo $person->name." ".$person->lastname; ?></h4>
                        <p class="text-muted small mb-3"><?php echo $person->company ? $person->company : "Persona Natural"; ?></p>
                        
                        <div class="p-3 bg-light rounded-3 text-start mt-4">
                            <div class="mb-3">
                                <label class="small text-muted d-block fw-bold border-bottom pb-1 mb-1">Contacto</label>
                                <div class="small fw-600 text-indigo-900"><i class="bi bi-envelope me-2"></i> <?php echo $person->email ? $person->email : "Sin email"; ?></div>
                                <div class="small fw-600 text-indigo-900 mt-1"><i class="bi bi-phone me-2"></i> <?php echo $person->phone ? $person->phone : "Sin teléfono"; ?></div>
                            </div>
                            <div class="mb-0">
                                <label class="small text-muted d-block fw-bold border-bottom pb-1 mb-1">Dirección</label>
                                <div class="small text-muted"><?php echo $person->address ? $person->address : "Sin dirección registrada"; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <?php if($person->kind==1): ?>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Historial de Citas</h5>
                        <span class="badge bg-indigo-100 text-indigo-700"><?php echo count($appointments); ?> servicios</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light small text-muted">
                                    <tr>
                                        <th class="ps-4">Servicio</th>
                                        <th>Profesional</th>
                                        <th>Fecha / Hora</th>
                                        <th>Estado</th>
                                        <th class="pe-4 text-end">ID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($appointments as $a): 
                                        $svc = ProductData::getById($a->product_id);
                                        $pro = ProfessionalData::getById($a->professional_id);
                                        $u_pro = UserData::getById($pro->user_id);
                                    ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-indigo-900"><?php echo $svc ? $svc->name : "N/A"; ?></td>
                                        <td><?php echo $u_pro->name; ?></td>
                                        <td>
                                            <div class="small fw-bold"><?php echo $a->date; ?></div>
                                            <div class="small text-muted"><?php echo $a->time; ?></div>
                                        </td>
                                        <td>
                                            <?php 
                                            $st_class = "bg-warning";
                                            $st_text = $a->status;
                                            if($a->status=="pending") { $st_class="bg-warning text-dark"; $st_text="Pendiente"; }
                                            if($a->status=="En Servicio") { $st_class="bg-info text-white"; }
                                            if($a->status=="Finalizado") { $st_class="bg-success text-white"; }
                                            if($a->status=="cancelled") { $st_class="bg-danger text-white"; $st_text="Cancelado"; }
                                            ?>
                                            <span class="badge <?php echo $st_class; ?> rounded-pill"><?php echo $st_text; ?></span>
                                        </td>
                                        <td class="pe-4 text-end text-muted small">#<?php echo $a->id; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
