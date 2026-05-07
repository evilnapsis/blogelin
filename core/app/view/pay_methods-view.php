<?php
$methods = PaymentMethodData::getAll();
?>
<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-0">Métodos de Pago</h1>
                <p class="text-muted mb-0">Gestión de pasarelas y opciones de cobro</p>
            </div>
            <div class="ms-auto">
                <button class="btn btn-indigo shadow-sm fw-bold text-white px-4" style="background:#6366f1" data-coreui-toggle="modal" data-coreui-target="#newMethodModal">
                    <i class="bi bi-plus-lg me-1"></i> Nuevo Método
                </button>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th class="ps-4">Nombre</th>
                                <th>Short / Slug</th>
                                <th>Visible Web</th>
                                <th>Estado</th>
                                <th class="pe-4 text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($methods as $m): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-indigo-900"><?php echo $m->name; ?></td>
                                <td><code><?php echo $m->short; ?></code></td>
                                <td>
                                    <?php if($m->is_web): ?>
                                        <span class="badge bg-success-100 text-success">SÍ</span>
                                    <?php else: ?>
                                        <span class="badge bg-light text-muted">NO</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($m->is_active): ?>
                                        <span class="badge bg-emerald-100 text-emerald-700">Activo</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger-100 text-danger">Inactivo</span>
                                    <?php endif; ?>
                                </td>
                                <td class="pe-4 text-end">
                                    <button class="btn btn-light btn-sm" onclick="editMethod(<?php echo $m->id; ?>)"><i class="bi bi-pencil"></i></button>
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

<!-- Modal: New Method -->
<div class="modal fade" id="newMethodModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Nuevo Método de Pago</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add-method-form">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold">Nombre *</label>
                            <input type="text" name="name" class="form-control" required placeholder="Ej: Clip, Mercado Pago">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Short / Slug (opcional)</label>
                            <input type="text" name="short" class="form-control" placeholder="ej: clip_gateway">
                        </div>
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_web" value="1" id="isWebCheck">
                                <label class="form-check-label fw-bold small" for="isWebCheck">¿Mostrar en Reservas Web?</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light fw-bold" data-coreui-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-indigo text-white fw-bold px-4">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('add-method-form').onsubmit = function(e){
    e.preventDefault();
    fetch('index.php?action=pay_methods&opt=add', {
        method: 'POST',
        body: new FormData(this)
    }).then(() => window.location.reload());
}

function editMethod(id) {
    // Implement edit logic if needed, or stick to Add for now
    Swal.fire('Info', 'Funcionalidad de edición en desarrollo', 'info');
}
</script>
