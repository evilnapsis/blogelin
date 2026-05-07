<?php
$products = ProductData::getAll();
$categories = CategoryData::getAll();
?>
<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-0">Productos y Servicios</h1>
                <p class="text-muted mb-0">Gestión de catálogo para barbería</p>
            </div>
            <div class="ms-auto">
                <button class="btn btn-indigo shadow-sm fw-bold text-white px-4" style="background:#6366f1" data-coreui-toggle="modal" data-coreui-target="#newProductModal">
                    <i class="bi bi-plus-lg me-1"></i> Nuevo Producto/Servicio
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
                                <th>Tipo</th>
                                <th>Categoría</th>
                                <th>Precio</th>
                                <th>Stock / Duración</th>
                                <th class="pe-4 text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($products as $p): 
                                $cat = CategoryData::getById($p->category_id);
                            ?>
                            <tr>
                                <td class="ps-4 fw-bold"><?php echo $p->name; ?></td>
                                <td>
                                    <?php if($p->kind==1): ?>
                                        <span class="badge bg-blue-100 text-blue-700">Producto</span>
                                    <?php else: ?>
                                        <span class="badge bg-indigo-100 text-indigo-700">Servicio</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $cat ? $cat->name : "N/A"; ?></td>
                                <td class="fw-bold text-indigo-600">$<?php echo number_format($p->price_out, 2); ?></td>
                                <td>
                                    <?php if($p->kind==1): ?>
                                        <span class="text-muted small">Stock: <?php echo $p->stock; ?></span>
                                    <?php else: ?>
                                        <span class="text-muted small">Duración: <?php echo $p->duration; ?> min</span>
                                    <?php endif; ?>
                                </td>
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

<!-- Modal: New Product -->
<div class="modal fade" id="newProductModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Nuevo Producto o Servicio</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal"></button>
            </div>
            <form id="add-product-form">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold">Nombre *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Tipo *</label>
                            <select name="kind" class="form-select" required>
                                <option value="1">Producto (Stockable)</option>
                                <option value="2">Servicio (No stockable)</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Categoría *</label>
                            <select name="category_id" class="form-select" required>
                                <?php foreach($categories as $c): ?>
                                    <option value="<?php echo $c->id; ?>"><?php echo $c->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Precio de Venta *</label>
                            <input type="number" step="0.01" name="price_out" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Duración (min) / Stock</label>
                            <input type="number" name="value" class="form-control">
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
