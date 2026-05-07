<?php
$logs = AuditData::getAll();
?>

<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-0">Bitácora de Auditoría</h1>
                <p class="text-muted mb-0">Registro inalterable de acciones y cambios en el sistema</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 datatable">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Usuario</th>
                                <th>Acción</th>
                                <th>Recurso</th>
                                <th>Detalles</th>
                                <th>IP</th>
                                <th class="pe-4 text-center">Fecha y Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($logs as $l): 
                                $u = $l->user_id ? UserData::getById($l->user_id) : null;
                            ?>
                            <tr>
                                <td class="ps-4">
                                    <?php if($u): ?>
                                        <div class="fw-bold text-primary"><?php echo $u->name." ".$u->lastname; ?></div>
                                        <div class="small text-muted">@<?php echo $u->username; ?></div>
                                    <?php else: ?>
                                        <span class="text-muted italic">Sistema / Público</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php 
                                        $badge = "bg-secondary";
                                        if($l->action=="add") $badge = "bg-success";
                                        if($l->action=="update") $badge = "bg-warning text-dark";
                                        if($l->action=="del") $badge = "bg-danger";
                                        if($l->action=="login") $badge = "bg-info text-white";
                                    ?>
                                    <span class="badge <?php echo $badge; ?> px-2 py-1"><?php echo strtoupper($l->action); ?></span>
                                </td>
                                <td>
                                    <code class="small"><?php echo $l->table_name; ?></code>
                                    <?php if($l->record_id): ?>
                                        <span class="text-muted small ms-1">(ID: <?php echo $l->record_id; ?>)</span>
                                    <?php endif; ?>
                                </td>
                                <td class="small"><?php echo $l->details; ?></td>
                                <td class="small text-muted font-monospace"><?php echo $l->ip_address; ?></td>
                                <td class="pe-4 text-center">
                                    <div class="small fw-bold"><?php echo date("d/m/Y", strtotime($l->created_at)); ?></div>
                                    <div class="small text-muted"><?php echo date("H:i:s", strtotime($l->created_at)); ?></div>
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
