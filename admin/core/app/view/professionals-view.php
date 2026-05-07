<?php
$professionals = ProfessionalData::getAll();
$categories = CategoryData::getAll();
?>
<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-0">Staff Profesional</h1>
                <p class="text-muted mb-0">Gestión de especialistas y disponibilidad</p>
            </div>
            <div class="ms-auto">
                <button class="btn btn-indigo shadow-sm fw-bold text-white px-4" style="background:#6366f1" data-coreui-toggle="modal" data-coreui-target="#newProfessionalModal">
                    <i class="bi bi-person-plus me-1"></i> Nuevo Profesional
                </button>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 datatable">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th class="ps-4">Profesional</th>
                                <th>Categoría</th>
                                <th>Licencia / ID</th>
                                <th>Duración Cita</th>
                                <th class="pe-4 text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($professionals as $p): 
                                $u = UserData::getById($p->user_id);
                                $cat = CategoryData::getById($p->category_id);
                            ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-md bg-indigo-100 text-indigo-600 rounded-circle d-flex align-items-center justify-content-center fw-bold me-3 overflow-hidden shadow-sm">
                                            <?php if($p->image != ""): ?>
                                                <img src="storage/professionals/<?php echo $p->image; ?>" class="w-100 h-100 object-fit-cover">
                                            <?php else: ?>
                                                <?php echo substr((string)$u->name,0,1).substr((string)$u->lastname,0,1); ?>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark"><?php echo $u->name." ".$u->lastname; ?></div>
                                            <div class="small text-muted"><?php echo $u->email; ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge" style="background-color:<?php echo $cat->color; ?>; color:#fff"><?php echo $cat->name; ?></span></td>
                                <td><code class="text-dark"><?php echo $p->license_number; ?></code></td>
                                <td class="fw-bold"><?php echo $p->appointment_duration; ?> min</td>
                                <td class="pe-4 text-end">
                                    <a href="./?view=professionals_schedule&id=<?php echo $p->id; ?>" class="btn btn-light btn-sm text-indigo-600 shadow-sm"><i class="bi bi-calendar-range"></i></a>
                                    <button class="btn btn-light btn-sm ms-1" onclick="editProfessional(<?php echo $p->id; ?>)"><i class="bi bi-pencil"></i></button>
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

<!-- Modal: New Professional -->
<div class="modal fade" id="newProfessionalModal" tabindex="-1" aria-labelledby="newProfessionalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="newProfessionalModalLabel">Nuevo Profesional</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add-professional-form" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Vincular a Usuario *</label>
                            <select name="user_id" class="form-select" required>
                                <option value="">-- Seleccionar Usuario --</option>
                                <?php foreach(UserData::getAll() as $u): ?>
                                    <option value="<?php echo $u->id; ?>"><?php echo $u->name." ".$u->lastname; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="small text-muted mt-1">El profesional debe tener una cuenta de usuario previa.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Especialidad (Categoría) *</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">-- Seleccionar --</option>
                                <?php foreach(CategoryData::getAll() as $c): ?>
                                    <option value="<?php echo $c->id; ?>"><?php echo $c->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Número de Licencia</label>
                            <input type="text" name="license_number" class="form-control" placeholder="Ej: LIC-2024-001">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Duración de Cita (min) *</label>
                            <input type="number" name="appointment_duration" class="form-control" value="30" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold">Foto del Profesional</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Biografía / Perfil Profesional</label>
                            <textarea name="biography" class="form-control" rows="3" placeholder="Resumen de experiencia..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light fw-bold" data-coreui-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-indigo text-white fw-bold px-4">Dar de Alta</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Edit Professional -->
<div class="modal fade" id="editProfessionalModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Editar Profesional</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit-professional-form" enctype="multipart/form-data">
                <input type="hidden" name="id" id="edit_prof_id">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Usuario Asociado</label>
                            <input type="text" id="edit_prof_user_name" class="form-control" readonly disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Especialidad (Categoría) *</label>
                            <select name="category_id" id="edit_prof_category_id" class="form-select" required>
                                <?php foreach($categories as $c): ?>
                                    <option value="<?php echo $c->id; ?>"><?php echo $c->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Número de Licencia</label>
                            <input type="text" name="license_number" id="edit_prof_license_number" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Duración de Cita (min) *</label>
                            <input type="number" name="appointment_duration" id="edit_prof_appointment_duration" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold">Cambiar Foto</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Biografía / Perfil Profesional</label>
                            <textarea name="biography" id="edit_prof_biography" class="form-control" rows="3"></textarea>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add Professional
    const addForm = document.getElementById('add-professional-form');
    if (addForm) {
        addForm.onsubmit = function(e) {
            e.preventDefault();
            fetch('index.php?action=professionals&opt=add', { method: 'POST', body: new FormData(this) })
            .then(res => res.text()).then(res => {
                if(res.trim() === "success") window.location.reload();
                else Swal.fire('Error', res, 'error');
            });
        }
    }

    // Edit Professional (Data Fetch)
    window.editProfessional = function(id) {
        fetch('index.php?action=professionals&opt=get&id=' + id)
        .then(res => res.json()).then(p => {
            document.getElementById('edit_prof_id').value = p.prof.id;
            document.getElementById('edit_prof_user_name').value = p.user.name + " " + p.user.lastname;
            document.getElementById('edit_prof_category_id').value = p.prof.category_id;
            document.getElementById('edit_prof_license_number').value = p.prof.license_number;
            document.getElementById('edit_prof_appointment_duration').value = p.prof.appointment_duration;
            document.getElementById('edit_prof_biography').value = p.prof.biography;
            
            new coreui.Modal(document.getElementById('editProfessionalModal')).show();
        });
    }

    // Update Professional
    const editForm = document.getElementById('edit-professional-form');
    if (editForm) {
        editForm.onsubmit = function(e) {
            e.preventDefault();
            fetch('index.php?action=professionals&opt=update', { method: 'POST', body: new FormData(this) })
            .then(res => res.text()).then(res => {
                if(res.trim() === "success") window.location.reload();
                else Swal.fire('Error', res, 'error');
            });
        }
    }
});
</script>
