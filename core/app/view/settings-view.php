<?php
$settings = [
    "clinic_name" => SettingData::getValue("clinic_name"),
    "clinic_email" => SettingData::getValue("clinic_email"),
    "clinic_phone" => SettingData::getValue("clinic_phone"),
    "currency" => SettingData::getValue("currency"),
];
?>

<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-0">Configuración del Sistema</h1>
                <p class="text-muted mb-0">Personaliza la identidad y parámetros globales de la clínica</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm overflow-hidden mb-4">
                    <div class="list-group list-group-flush" id="settings-tabs" role="tablist">
                        <a class="list-group-item list-group-item-action active p-3 fw-bold border-0" id="list-general-list" data-coreui-toggle="list" href="#list-general" role="tab">
                            <i class="bi bi-gear me-2"></i> Ajustes Generales
                        </a>
                        <a class="list-group-item list-group-item-action p-3 fw-bold border-0" id="list-branding-list" data-coreui-toggle="list" href="#list-branding" role="tab">
                            <i class="bi bi-palette me-2"></i> Identidad Visual
                        </a>
                        <a class="list-group-item list-group-item-action p-3 fw-bold border-0" id="list-notifications-list" data-coreui-toggle="list" href="#list-notifications" role="tab">
                            <i class="bi bi-envelope me-2"></i> Notificaciones (SMTP)
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="tab-content" id="nav-tabContent">
                    <!-- General Settings -->
                    <div class="tab-pane fade show active" id="list-general" role="tabpanel">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-4 text-primary">Información de la Clínica</h5>
                                <form method="post" action="./?action=settings&opt=update">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold small">Nombre de la Clínica</label>
                                        <input type="text" name="clinic_name" class="form-control" value="<?php echo $settings['clinic_name']; ?>" required>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small">Email de Contacto</label>
                                            <input type="email" name="clinic_email" class="form-control" value="<?php echo $settings['clinic_email']; ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small">Teléfono</label>
                                            <input type="text" name="clinic_phone" class="form-control" value="<?php echo $settings['clinic_phone']; ?>">
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label fw-bold small">Moneda (Símbolo)</label>
                                        <input type="text" name="currency" class="form-control" style="width: 100px;" value="<?php echo $settings['currency']; ?>" placeholder="$">
                                    </div>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary fw-bold px-4 shadow-sm">
                                            <i class="bi bi-save me-1"></i> Guardar Cambios
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Branding Settings -->
                    <div class="tab-pane fade" id="list-branding" role="tabpanel">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-4 text-primary">Personalización de Marca</h5>
                                <form method="post" action="./?action=settings&opt=update_branding" enctype="multipart/form-data">
                                    <div class="mb-4 text-center p-4 bg-light rounded-3 border">
                                        <p class="small text-muted mb-3">Vista Previa de Logo Actual</p>
                                        <img src="storage/logo.png" class="img-fluid" style="max-height: 80px;" onerror="this.src='res/logo_placeholder.png'">
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label fw-bold small">Subir Nuevo Logo (Recomendado PNG transparente)</label>
                                        <input type="file" name="logo" class="form-control">
                                    </div>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary fw-bold shadow-sm">Actualizar Marca</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- SMTP Settings -->
                    <div class="tab-pane fade" id="list-notifications" role="tabpanel">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-4 text-primary">Configuración de Correo Entrante/Saliente</h5>
                                <div class="alert alert-info py-2 small mb-4">
                                    <i class="bi bi-info-circle me-1"></i> Estos ajustes permiten al sistema enviar recordatorios de citas automáticamente.
                                </div>
                                <form method="post" action="./?action=settings&opt=update_smtp">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold small">Servidor SMTP</label>
                                        <input type="text" name="smtp_host" class="form-control" value="<?php echo SettingData::getValue('smtp_host'); ?>">
                                    </div>
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small">Puerto</label>
                                            <input type="text" name="smtp_port" class="form-control" value="<?php echo SettingData::getValue('smtp_port'); ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold small">Seguridad</label>
                                            <select name="smtp_secure" class="form-select">
                                                <option value="ssl">SSL</option>
                                                <option value="tls">TLS</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary fw-bold shadow-sm">Guardar SMTP</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
