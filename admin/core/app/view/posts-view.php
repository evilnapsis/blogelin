<?php
$categories = CategoryData::getAll();

if(isset($_GET["opt"]) && $_GET["opt"]=="edit"):
    $p = PostData::getById($_GET["id"]);
?>
<!-- View: Edit Post -->
<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-0">Editar Artículo</h1>
                <p class="text-muted mb-0">Actualiza la información de tu publicación</p>
            </div>
            <div class="ms-auto">
                <a href="./?view=posts" class="btn btn-light shadow-sm fw-bold px-4">
                    <i class="bi bi-arrow-left me-1"></i> Regresar
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form id="edit-post-form" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $p->id; ?>">
                    <div class="row g-4">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Título del Artículo *</label>
                                <input type="text" name="title" class="form-control form-control-lg" required value="<?php echo $p->title; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Descripción Breve *</label>
                                <textarea name="brief" class="form-control" rows="3" required><?php echo $p->brief; ?></textarea>
                            </div>
                            <div class="mb-0">
                                <label class="form-label small fw-bold">Contenido *</label>
                                <textarea name="content" class="form-control" rows="15" required><?php echo $p->content; ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light border-0 p-3 mb-4">
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Categoría (Opcional)</label>
                                    <select name="category_id" class="form-select">
                                        <option value="">-- Sin Categoría --</option>
                                        <?php foreach($categories as $c): ?>
                                            <option value="<?php echo $c->id; ?>" <?php if($p->category_id==$c->id) echo "selected"; ?>><?php echo $c->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Imagen Destacada</label>
                                    <?php if($p->image!=""): ?>
                                        <div class="mb-2">
                                            <img src="uploads/<?php echo $p->image; ?>" class="img-fluid rounded border shadow-sm">
                                        </div>
                                    <?php endif; ?>
                                    <input type="file" name="image" class="form-control">
                                    <div class="form-text small">Dejar vacío para mantener la imagen actual.</div>
                                </div>
                                <div class="mb-0">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="status" id="edit_status" value="1" <?php if($p->status==1) echo "checked"; ?>>
                                        <label class="form-check-label fw-bold small" for="edit_status">Artículo Activo</label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-indigo btn-lg text-white fw-bold py-3 shadow-sm">
                                    <i class="bi bi-check-lg me-1"></i> Guardar Cambios
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('edit-post-form').onsubmit = function(e){
    e.preventDefault();
    const formData = new FormData(this);
    
    fetch('index.php?action=posts&opt=update', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(res => {
        if(res.trim() === "success"){
            Swal.fire({
                icon: 'success',
                title: '¡Actualizado!',
                text: 'El artículo ha sido actualizado correctamente.',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                window.location.href = './?view=posts';
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo actualizar el artículo: ' + res
            });
        }
    });
}
</script>

<?php else: 
$posts = PostData::getAll();
?>
<!-- View: List Posts -->
<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-0">Artículos</h1>
                <p class="text-muted mb-0">Gestión de publicaciones del blog</p>
            </div>
            <div class="ms-auto">
                <button class="btn btn-indigo shadow-sm fw-bold text-white px-4" style="background:#6366f1" data-coreui-toggle="modal" data-coreui-target="#newPostModal">
                    <i class="bi bi-plus-lg me-1"></i> Nuevo Artículo
                </button>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 datatable">
                        <thead class="bg-light text-muted small text-uppercase">
                            <tr>
                                <th class="ps-4">Título</th>
                                <th>Categoría</th>
                                <th class="text-center">Estado</th>
                                <th>Fecha</th>
                                <th class="pe-4 text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($posts as $p): ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <?php if($p->image!=""): ?>
                                            <img src="uploads/<?php echo $p->image; ?>" class="rounded me-3" style="width: 40px; height: 40px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div class="fw-bold text-indigo-900"><?php echo $p->title; ?></div>
                                    </div>
                                </td>
                                <td>
                                    <?php if($p->category_id!=null): ?>
                                        <span class="badge bg-indigo-100 text-indigo-700 rounded-pill">
                                            <?php echo CategoryData::getById($p->category_id)->name; ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-light text-muted rounded-pill small">Sin Categoría</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if($p->status == 1): ?>
                                        <span class="badge bg-emerald-100 text-emerald-700 rounded-pill"><i class="bi bi-check-circle me-1"></i> Activo</span>
                                    <?php else: ?>
                                        <span class="badge bg-light text-muted rounded-pill">Inactivo</span>
                                    <?php endif; ?>
                                </td>
                                <td class="small text-muted"><?php echo $p->created_at; ?></td>
                                <td class="pe-4 text-end">
                                    <a href="../?view=post&id=<?php echo $p->id; ?>" target="_blank" class="btn btn-light btn-sm text-indigo-400 me-2" title="Ver publicación"><i class="bi bi-eye"></i></a>
                                    <a href="./?view=posts&opt=edit&id=<?php echo $p->id; ?>" class="btn btn-light btn-sm text-indigo-600 me-2"><i class="bi bi-pencil"></i></a>
                                    <a href="index.php?action=posts&opt=del&id=<?php echo $p->id; ?>" class="btn btn-light btn-sm text-danger"><i class="bi bi-trash"></i></a>
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

<!-- Modal: New Post -->
<div class="modal fade" id="newPostModal" tabindex="-1" aria-labelledby="newPostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="newPostModalLabel">Nuevo Artículo</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add-post-form" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label small fw-bold">Título *</label>
                            <input type="text" name="title" class="form-control" required placeholder="Título del artículo">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Categoría (Opcional)</label>
                            <select name="category_id" class="form-select">
                                <option value="">-- Seleccionar --</option>
                                <?php foreach($categories as $c): ?>
                                    <option value="<?php echo $c->id; ?>"><?php echo $c->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Imagen Destacada</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Descripción Breve *</label>
                            <textarea name="brief" class="form-control" rows="2" required placeholder="Resumen del artículo"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Contenido *</label>
                            <textarea name="content" class="form-control" rows="6" required placeholder="Contenido completo del artículo"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light fw-bold" data-coreui-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-indigo text-white fw-bold px-4">Publicar Artículo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('add-post-form').onsubmit = function(e){
    e.preventDefault();
    const formData = new FormData(this);
    
    fetch('index.php?action=posts&opt=add', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(res => {
        if(res.trim() === "success"){
            Swal.fire({
                icon: 'success',
                title: '¡Publicado!',
                text: 'El artículo ha sido creado correctamente.',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                window.location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo crear el artículo: ' + res
            });
        }
    });
}
</script>
<?php endif; ?>
