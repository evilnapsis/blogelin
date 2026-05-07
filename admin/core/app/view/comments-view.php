<?php
$comments = CommentData::getAll();
?>
<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-0">Comentarios</h1>
                <p class="text-muted mb-0">Moderación de comentarios de los lectores</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 datatable">
                        <thead class="bg-light text-muted small text-uppercase">
                            <tr>
                                <th class="ps-4">Autor</th>
                                <th>Comentario</th>
                                <th>Artículo</th>
                                <th class="text-center">Estado</th>
                                <th>Fecha</th>
                                <th class="pe-4 text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($comments as $c): ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-indigo-900"><?php echo $c->name; ?></div>
                                    <div class="small text-muted"><?php echo $c->email; ?></div>
                                </td>
                                <td class="small" style="max-width: 300px;">
                                    <div class="text-truncate" title="<?php echo $c->comment; ?>">
                                        <?php echo $c->comment; ?>
                                    </div>
                                </td>
                                <td>
                                    <?php $p = PostData::getById($c->post_id); ?>
                                    <a href="../?view=post&id=<?php echo $p->id; ?>" target="_blank" class="text-decoration-none small fw-bold">
                                        <?php echo $p->title; ?> <i class="bi bi-box-arrow-up-right ms-1"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <?php if($c->status == 1): ?>
                                        <span class="badge bg-amber-100 text-amber-700 rounded-pill"><i class="bi bi-clock me-1"></i> Pendiente</span>
                                    <?php elseif($c->status == 2): ?>
                                        <span class="badge bg-emerald-100 text-emerald-700 rounded-pill"><i class="bi bi-check-circle me-1"></i> Aceptado</span>
                                    <?php else: ?>
                                        <span class="badge bg-light text-muted rounded-pill">Rechazado</span>
                                    <?php endif; ?>
                                </td>
                                <td class="small text-muted"><?php echo $c->created_at; ?></td>
                                <td class="pe-4 text-end">
                                    <?php if($c->status == 1): ?>
                                        <a href="index.php?action=comments&opt=accept&id=<?php echo $c->id; ?>" class="btn btn-light btn-sm text-success me-1" title="Aceptar"><i class="bi bi-check-lg"></i></a>
                                        <a href="index.php?action=comments&opt=denied&id=<?php echo $c->id; ?>" class="btn btn-light btn-sm text-warning me-1" title="Rechazar"><i class="bi bi-x-lg"></i></a>
                                    <?php endif; ?>
                                    <a href="index.php?action=comments&opt=del&id=<?php echo $c->id; ?>" class="btn btn-light btn-sm text-danger" title="Eliminar"><i class="bi bi-trash"></i></a>
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
