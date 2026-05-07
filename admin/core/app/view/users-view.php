<?php
$users = UserData::getAll();
?>
<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-0">Gestión de Usuarios</h1>
                <p class="text-muted mb-0">Administra cuentas de acceso al panel de control</p>
            </div>
            <div class="ms-auto">
                <button class="btn btn-indigo shadow-sm fw-bold text-white px-4" style="background:#6366f1" data-coreui-toggle="modal" data-coreui-target="#newUserModal">
                    <i class="bi bi-person-plus me-1"></i> Nuevo Usuario
                </button>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 datatable">
                        <thead class="bg-light text-muted small text-uppercase">
                            <tr>
                                <th class="ps-4">Usuario</th>
                                <th>Email</th>
                                <th>Tipo</th>
                                <th>Estado</th>
                                <th class="pe-4 text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($users as $u): ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-md bg-indigo-100 text-indigo-600 rounded-circle d-flex align-items-center justify-content-center fw-bold me-3 shadow-sm">
                                            <?php echo substr((string)$u->name,0,1).substr((string)$u->lastname,0,1); ?>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark"><?php echo $u->name." ".$u->lastname; ?></div>
                                            <div class="small text-muted">@<?php echo $u->username; ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo $u->email; ?></td>
                                <td>
                                    <?php if($u->kind == 1): ?>
                                        <span class="badge bg-indigo-100 text-indigo-700 rounded-pill px-3">Administrador</span>
                                    <?php else: ?>
                                        <span class="badge bg-light text-muted rounded-pill px-3">Editor</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($u->status == 1): ?>
                                        <span class="badge bg-emerald-100 text-emerald-700 rounded-pill px-3">Activo</span>
                                    <?php else: ?>
                                        <span class="badge bg-light text-muted rounded-pill px-3">Inactivo</span>
                                    <?php endif; ?>
                                </td>
                                <td class="pe-4 text-end">
                                    <button class="btn btn-light btn-sm" onclick="editUser(<?php echo htmlspecialchars(json_encode($u)); ?>)"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-light text-danger btn-sm ms-1" onclick="deleteUser(<?php echo $u->id; ?>)"><i class="bi bi-trash"></i></button>
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

<!-- Modal: New User -->
<div class="modal fade" id="newUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add-user-form">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nombre *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Apellidos *</label>
                            <input type="text" name="lastname" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nombre de Usuario *</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Email *</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold">Contraseña *</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold">Tipo *</label>
                            <select name="kind" class="form-select" required>
                                <option value="1">Administrador</option>
                                <option value="2">Editor</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light fw-bold" data-coreui-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-indigo text-white fw-bold px-4">Crear Usuario</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Edit User -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Editar Usuario</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit-user-form">
                <input type="hidden" name="id" id="edit_user_id">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nombre *</label>
                            <input type="text" name="name" id="edit_user_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Apellidos *</label>
                            <input type="text" name="lastname" id="edit_user_lastname" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nombre de Usuario *</label>
                            <input type="text" name="username" id="edit_user_username" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Email *</label>
                            <input type="email" name="email" id="edit_user_email" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold">Contraseña (Dejar vacío para mantener)</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold">Tipo *</label>
                            <select name="kind" id="edit_user_kind" class="form-select" required>
                                <option value="1">Administrador</option>
                                <option value="2">Editor</option>
                            </select>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="status" id="edit_user_status" value="1">
                                <label class="form-check-label small fw-bold">Usuario Activo</label>
                            </div>
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
    // Add User
    document.getElementById('add-user-form').onsubmit = function(e) {
        e.preventDefault();
        fetch('index.php?action=users&opt=add', { method: 'POST', body: new FormData(this) })
        .then(res => res.text()).then(res => {
            if(res.trim() === "success") window.location.reload();
            else Swal.fire('Error', res, 'error');
        });
    };

    // Edit User
    window.editUser = function(u) {
        document.getElementById('edit_user_id').value = u.id;
        document.getElementById('edit_user_name').value = u.name;
        document.getElementById('edit_user_lastname').value = u.lastname;
        document.getElementById('edit_user_username').value = u.username;
        document.getElementById('edit_user_email').value = u.email;
        document.getElementById('edit_user_kind').value = u.kind;
        document.getElementById('edit_user_status').checked = u.status == 1;
        new coreui.Modal(document.getElementById('editUserModal')).show();
    };

    document.getElementById('edit-user-form').onsubmit = function(e) {
        e.preventDefault();
        fetch('index.php?action=users&opt=update', { method: 'POST', body: new FormData(this) })
        .then(res => res.text()).then(res => {
            if(res.trim() === "success") window.location.reload();
            else Swal.fire('Error', res, 'error');
        });
    };

    // Delete User
    window.deleteUser = function(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Se eliminará el acceso de este usuario.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#6366f1',
            confirmButtonText: 'Sí, eliminar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('index.php?action=users&opt=del&id=' + id)
                .then(res => res.text()).then(res => {
                    if(res.trim() === "success") window.location.reload();
                });
            }
        });
    };
});
</script>
