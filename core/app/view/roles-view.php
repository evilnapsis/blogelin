<?php
$roles = RolData::getAll();
$views = [
    "specialties" => "Especialidades",
    "offices" => "Consultorios",
    "doctors" => "Médicos",
    "patients" => "Pacientes",
    "appointments" => "Citas",
    "services" => "Servicios",
    "invoices" => "Facturación",
    "finances" => "Finanzas",
    "catalogs" => "Catálogos Médicos",
    "settings" => "Configuración",
    "audit" => "Auditoría"
];
?>

<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-0">Roles y Permisos</h1>
                <p class="text-muted mb-0">Matriz de acceso granular por perfil de usuario</p>
            </div>
        </div>

        <?php foreach($roles as $r): ?>
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white p-4 border-0 d-flex align-items-center">
                    <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-shield-check me-2"></i> Perfil: <?php echo $r->name; ?></h5>
                </div>
                <div class="card-body p-0">
                    <form method="post" action="./?action=roles&opt=save_permissions">
                        <input type="hidden" name="rol_id" value="<?php echo $r->id; ?>">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light small text-uppercase fw-bold">
                                    <tr>
                                        <th class="ps-4">Módulo / Vista</th>
                                        <th class="text-center">Ver</th>
                                        <th class="text-center">Agregar</th>
                                        <th class="text-center">Editar</th>
                                        <th class="text-center">Borrar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($views as $v_key => $v_name): 
                                        $p = PermissionData::getPermission($r->id, $v_key);
                                    ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark"><?php echo $v_name; ?></td>
                                        <td class="text-center">
                                            <input type="checkbox" name="perm[<?php echo $v_key; ?>][view]" value="1" <?php echo ($p && $p->can_view)?"checked":""; ?> class="form-check-input">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" name="perm[<?php echo $v_key; ?>][add]" value="1" <?php echo ($p && $p->can_add)?"checked":""; ?> class="form-check-input">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" name="perm[<?php echo $v_key; ?>][edit]" value="1" <?php echo ($p && $p->can_edit)?"checked":""; ?> class="form-check-input">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" name="perm[<?php echo $v_key; ?>][delete]" value="1" <?php echo ($p && $p->can_delete)?"checked":""; ?> class="form-check-input">
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="p-4 bg-light border-top text-end">
                            <button type="submit" class="btn btn-primary fw-bold shadow-sm">Aplicar Permisos para <?php echo $r->name; ?></button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
