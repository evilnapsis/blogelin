<?php
$opt = isset($_GET["opt"]) ? $_GET["opt"] : "all";
?>

<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-0">Personal (Staff)</h1>
                <p class="text-muted mb-0">Gestión del personal administrativo y de apoyo</p>
            </div>
            <?php if($opt=="all"): ?>
            <div class="ms-auto">
                <a href="./?view=staff&opt=new" class="btn btn-primary shadow-sm fw-bold">
                    <i class="bi bi-plus-lg me-1"></i> Nuevo Personal
                </a>
            </div>
            <?php endif; ?>
        </div>

        <?php if($opt == "all"): ?>
        <?php $staffs = StaffData::getAll(); ?>
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 datatable">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Nombre</th>
                                <th>Cargo / Posición</th>
                                <th>Email</th>
                                <th class="text-center">Estado</th>
                                <th class="pe-4 text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($staffs as $s): 
                                $u = UserData::getById($s->user_id);
                            ?>
                            <tr>
                                <td class="ps-4 fw-bold text-primary"><?php echo $u->name." ".$u->lastname; ?></td>
                                <td><?php echo $s->position; ?></td>
                                <td><?php echo $u->email; ?></td>
                                <td class="text-center">
                                    <?php if($u->is_active): ?>
                                        <span class="badge bg-success">Activo</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Inactivo</span>
                                    <?php endif; ?>
                                </td>
                                <td class="pe-4 text-end">
                                    <a href="./?view=staff&opt=edit&id=<?php echo $s->id; ?>" class="btn btn-warning btn-sm shadow-sm" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="./?action=staff&opt=del&id=<?php echo $s->id; ?>" class="btn btn-danger btn-sm shadow-sm ms-1" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar este registro?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php elseif($opt == "new"): ?>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white p-4 border-0">
                        <h5 class="fw-bold mb-0">Registrar Personal</h5>
                    </div>
                    <div class="card-body p-4 pt-0">
                        <form method="post" action="./?action=staff&opt=add">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nombre</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Apellidos</label>
                                <input type="text" name="lastname" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Cargo / Posición</label>
                                <input type="text" name="position" class="form-control" required placeholder="Ej. Recepcionista, Enfermero...">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nombre de Usuario</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold">Contraseña</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="d-flex justify-content-end">
                                <a href="./?view=staff&opt=all" class="btn btn-light fw-bold me-2">Cancelar</a>
                                <button type="submit" class="btn btn-primary fw-bold shadow-sm">Guardar Registro</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php elseif($opt == "edit"): ?>
        <?php 
            $s = StaffData::getById($_GET["id"]); 
            $u = UserData::getById($s->user_id);
        ?>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white p-4 border-0">
                        <h5 class="fw-bold mb-0">Editar Personal</h5>
                    </div>
                    <div class="card-body p-4 pt-0">
                        <form method="post" action="./?action=staff&opt=update">
                            <input type="hidden" name="id" value="<?php echo $s->id; ?>">
                            <input type="hidden" name="user_id" value="<?php echo $u->id; ?>">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nombre</label>
                                <input type="text" name="name" class="form-control" value="<?php echo $u->name; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Apellidos</label>
                                <input type="text" name="lastname" class="form-control" value="<?php echo $u->lastname; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Cargo / Posición</label>
                                <input type="text" name="position" class="form-control" value="<?php echo $s->position; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" name="email" class="form-control" value="<?php echo $u->email; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nombre de Usuario</label>
                                <input type="text" name="username" class="form-control" value="<?php echo $u->username; ?>" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold">Contraseña (Vacío para no cambiar)</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="d-flex justify-content-end">
                                <a href="./?view=staff&opt=all" class="btn btn-light fw-bold me-2">Cancelar</a>
                                <button type="submit" class="btn btn-success text-white fw-bold shadow-sm">Actualizar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
