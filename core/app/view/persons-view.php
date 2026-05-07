<?php
$persons = PersonData::getAll();
?>
<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-0">Clientes y Proveedores</h1>
                <p class="text-muted mb-0">Gestión unificada de entidades comerciales</p>
            </div>
            <div class="ms-auto">
                <button class="btn btn-indigo shadow-sm fw-bold text-white px-4" style="background:#6366f1" data-coreui-toggle="modal" data-coreui-target="#newPersonModal">
                    <i class="bi bi-person-plus me-1"></i> Nueva Persona
                </button>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 datatable">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th class="ps-4">Nombre / Empresa</th>
                                <th>Tipo</th>
                                <th>Contacto</th>
                                <th>Registro</th>
                                <th class="pe-4 text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($persons as $p): ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark"><?php echo $p->name." ".$p->lastname; ?></div>
                                    <div class="small text-muted"><?php echo $p->company; ?></div>
                                </td>
                                <td>
                                    <?php if($p->kind==1): ?>
                                        <span class="badge bg-indigo-100 text-indigo-700">Cliente</span>
                                    <?php else: ?>
                                        <span class="badge bg-amber-100 text-amber-700">Proveedor</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="small"><i class="bi bi-envelope me-1"></i> <?php echo $p->email; ?></div>
                                    <div class="small"><i class="bi bi-phone me-1"></i> <?php echo $p->phone; ?></div>
                                </td>
                                <td class="small text-muted"><?php echo $p->created_at; ?></td>
                                <td class="pe-4 text-end">
                                    <a href="./?view=oneperson&id=<?php echo $p->id; ?>" class="btn btn-light btn-sm"><i class="bi bi-eye"></i></a>
                                    <button class="btn btn-light btn-sm ms-1" onclick="editPerson(<?php echo $p->id; ?>)"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-danger btn-sm ms-1"><i class="bi bi-trash"></i></button>
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

<!-- Modal: Edit Person -->
<div class="modal fade" id="editPersonModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Editar Persona</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit-person-form">
                <input type="hidden" name="id" id="edit_person_id">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nombre *</label>
                            <input type="text" name="name" id="edit_person_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Apellido *</label>
                            <input type="text" name="lastname" id="edit_person_lastname" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Empresa</label>
                            <input type="text" name="company" id="edit_person_company" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Tipo *</label>
                            <select name="kind" id="edit_person_kind" class="form-select" required>
                                <option value="1">Cliente</option>
                                <option value="2">Proveedor</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Email</label>
                            <input type="email" name="email" id="edit_person_email" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Teléfono</label>
                            <input type="tel" name="phone" id="edit_person_phone" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Dirección</label>
                            <textarea name="address" id="edit_person_address" class="form-control" rows="2"></textarea>
                        </div>
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

<!-- Modal: New Person -->
<div class="modal fade" id="newPersonModal" tabindex="-1" aria-labelledby="newPersonModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="newPersonModalLabel">Nueva Persona</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add-person-form">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nombre *</label>
                            <input type="text" name="name" class="form-control" required placeholder="Ej: Juan">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Apellido *</label>
                            <input type="text" name="lastname" class="form-control" required placeholder="Ej: Pérez">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Empresa (Opcional)</label>
                            <input type="text" name="company" class="form-control" placeholder="Nombre de empresa">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Tipo *</label>
                            <select name="kind" class="form-select" required>
                                <option value="1">Cliente</option>
                                <option value="2">Proveedor</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="correo@ejemplo.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Teléfono</label>
                            <input type="tel" name="phone" class="form-control" placeholder="999 999 999">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Dirección</label>
                            <textarea name="address" class="form-control" rows="2" placeholder="Calle, Número, Ciudad..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light fw-bold" data-coreui-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-indigo text-white fw-bold px-4">Guardar Persona</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('add-person-form').onsubmit = function(e){
    e.preventDefault();
    const formData = new FormData(this);
    
    fetch('index.php?action=persons&opt=add', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(res => {
        if(res.trim() === "success"){
            Swal.fire({
                icon: 'success',
                title: '¡Guardado!',
                text: 'La persona ha sido registrada correctamente.',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                window.location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo guardar: ' + res
            });
        }
    });
}

function editPerson(id) {
    fetch('index.php?action=persons&opt=get&id=' + id)
        .then(res => res.json())
        .then(p => {
            document.getElementById('edit_person_id').value = p.id;
            document.getElementById('edit_person_name').value = p.name;
            document.getElementById('edit_person_lastname').value = p.lastname;
            document.getElementById('edit_person_company').value = p.company;
            document.getElementById('edit_person_kind').value = p.kind;
            document.getElementById('edit_person_email').value = p.email;
            document.getElementById('edit_person_phone').value = p.phone;
            document.getElementById('edit_person_address').value = p.address;
            
            const modal = new coreui.Modal(document.getElementById('editPersonModal'));
            modal.show();
        });
}

document.getElementById('edit-person-form').onsubmit = function(e){
    e.preventDefault();
    const formData = new FormData(this);
    
    fetch('index.php?action=persons&opt=update', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(res => {
        if(res.trim() === "success"){
            Swal.fire({
                icon: 'success',
                title: '¡Actualizado!',
                text: 'La información ha sido guardada.',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                window.location.reload();
            });
        }
    });
}
</script>
