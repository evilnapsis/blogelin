<?php
$opt = isset($_GET["opt"]) ? $_GET["opt"] : "all";
$offices = OfficeData::getAll();
?>
<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-0">Salas y Consultorios</h1>
                <p class="text-muted mb-0">Espacios asignados para la atención de servicios</p>
            </div>
            <div class="ms-auto">
                <button class="btn btn-indigo shadow-sm fw-bold text-white px-4" style="background:#6366f1" data-coreui-toggle="modal" data-coreui-target="#newOfficeModal">
                    <i class="bi bi-plus-lg me-1"></i> Nueva Sala
                </button>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 datatable">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th class="ps-4">Nombre de la Sala</th>
                                <th>Ubicación</th>
                                <th class="text-center">Registro</th>
                                <th class="pe-4 text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($offices as $o): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-indigo-900"><?php echo $o->name; ?></td>
                                <td><?php echo $o->location; ?></td>
                                <td class="text-center small text-muted"><?php echo $o->created_at; ?></td>
                                <td class="pe-4 text-end">
                                    <button class="btn btn-light btn-sm" onclick="editOffice(<?php echo $o->id; ?>, '<?php echo addslashes($o->name); ?>', '<?php echo addslashes($o->location); ?>')"><i class="bi bi-pencil"></i></button>
                                    <a href="./?action=offices&opt=del&id=<?php echo $o->id; ?>" class="btn btn-danger btn-sm shadow-sm ms-1" onclick="return confirm('¿Eliminar sala?')"><i class="bi bi-trash"></i></a>
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

<!-- Modal: New Office -->
<div class="modal fade" id="newOfficeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Nueva Sala / Consultorio</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="./?action=offices&opt=add" method="POST">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nombre *</label>
                        <input type="text" name="name" class="form-control" required placeholder="Ej: Consultorio A1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Ubicación</label>
                        <input type="text" name="location" class="form-control" placeholder="Ej: Planta Alta, Pasillo Izq.">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light fw-bold" data-coreui-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-indigo text-white fw-bold px-4">Guardar Sala</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Edit Office -->
<div class="modal fade" id="editOfficeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Editar Sala</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="./?action=offices&opt=update" method="POST">
                <input type="hidden" name="id" id="edit_office_id">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nombre *</label>
                        <input type="text" name="name" id="edit_office_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Ubicación</label>
                        <input type="text" name="location" id="edit_office_location" class="form-control">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light fw-bold" data-coreui-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-indigo text-white fw-bold px-4">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editOffice(id, name, location) {
    document.getElementById('edit_office_id').value = id;
    document.getElementById('edit_office_name').value = name;
    document.getElementById('edit_office_location').value = location;
    const modal = new coreui.Modal(document.getElementById('editOfficeModal'));
    modal.show();
}
</script>
