<?php
$categories = CategoryData::getAll();
?>
<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-0">Categorías</h1>
                <p class="text-muted mb-0">Clasificación de profesionales y áreas</p>
            </div>
            <div class="ms-auto">
                <button class="btn btn-indigo shadow-sm fw-bold text-white px-4" style="background:#6366f1" data-coreui-toggle="modal" data-coreui-target="#newCategoryModal">
                    <i class="bi bi-tag me-1"></i> Nueva Categoría
                </button>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 datatable">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th class="ps-4">Nombre</th>
                                <th class="text-center">Color Identificador</th>
                                <th>Fecha Registro</th>
                                <th class="pe-4 text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($categories as $c): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-indigo-900"><?php echo $c->name; ?></td>
                                <td class="text-center">
                                    <span class="badge rounded-pill px-3 py-2" style="background-color:<?php echo $c->color; ?>; color:#fff">
                                        <?php echo $c->color; ?>
                                    </span>
                                </td>
                                <td><?php echo $c->created_at; ?></td>
                                <td class="pe-4 text-end">
                                    <button class="btn btn-light btn-sm"><i class="bi bi-pencil"></i></button>
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

<!-- Modal: New Category -->
<div class="modal fade" id="newCategoryModal" tabindex="-1" aria-labelledby="newCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="newCategoryModalLabel">Nueva Categoría</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add-category-form">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold">Nombre de la Categoría *</label>
                            <input type="text" name="name" class="form-control" required placeholder="Ej: Barbería, Estética...">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Color Identificador</label>
                            <input type="color" name="color" class="form-control form-control-color w-100" value="#6366f1" title="Elige un color">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light fw-bold" data-coreui-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-indigo text-white fw-bold px-4">Guardar Categoría</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('add-category-form').onsubmit = function(e){
    e.preventDefault();
    const formData = new FormData(this);
    
    fetch('index.php?action=categories&opt=add', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(res => {
        if(res.trim() === "success"){
            Swal.fire({
                icon: 'success',
                title: '¡Guardado!',
                text: 'La categoría ha sido creada correctamente.',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                window.location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo guardar la categoría.'
            });
        }
    });
}
</script>
