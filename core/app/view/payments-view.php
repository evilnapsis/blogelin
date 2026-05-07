<?php
$payments = PaymentData::getAll();
?>
<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-0">Historial de Pagos y Abonos</h1>
                <p class="text-muted mb-0">Seguimiento financiero de ventas y citas</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 datatable">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th class="ps-4">Fecha</th>
                                <th>Referencia</th>
                                <th>Método</th>
                                <th>Monto</th>
                                <th class="pe-4 text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($payments as $p): 
                                $method = PaymentMethodData::getById($p->payment_method_id);
                                $ref = "";
                                if($p->appointment_id) { 
                                    $app = AppointmentData::getById($p->appointment_id);
                                    $client = PersonData::getById($app->person_id);
                                    $ref = '<span class="badge bg-emerald-100 text-emerald-700">Cita: '.$client->name.'</span>'; 
                                }
                            ?>
                            <tr>
                                <td class="ps-4 small"><?php echo $p->created_at; ?></td>
                                <td><?php echo $ref; ?></td>
                                <td><span class="small fw-bold text-indigo-900"><?php echo $method ? $method->name : "Desconocido"; ?></span></td>
                                <td class="fw-bold">$<?php echo number_format($p->amount, 2); ?></td>
                                <td class="pe-4 text-end">
                                    <button class="btn btn-light btn-sm"><i class="bi bi-eye"></i></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
