<?php
$posts_count = PostData::count();
$categories_count = CategoryData::count();
$comments_count = CommentData::count();
$latest_posts = PostData::getLatest(5);
?>

<!-- Header Section -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 24px; background: #2f3640;">
            <div class="card-body p-0">
                <div class="row g-0">
                    <div class="col-md-8 p-4 p-lg-5 text-white">
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge bg-white bg-opacity-10 text-white px-3 py-2 rounded-pill small fw-bold mb-0">BLOGELIN CMS</span>
                            <span class="ms-3 text-white opacity-50 small"><i class="bi bi-calendar3 me-1"></i> <?php echo date("d M, Y"); ?></span>
                        </div>
                        <h1 class="display-6 fw-bold mb-3">¡Hola, <?php echo Core::$user->name; ?>!</h1>
                        <p class="lead opacity-75 mb-4">Tu blog está creciendo. Tienes <?php echo $posts_count; ?> artículos publicados y <?php echo $comments_count; ?> comentarios para revisar.</p>
                        <div class="d-flex gap-2">
                            <button class="btn btn-light fw-bold px-4 py-2 rounded-pill" data-coreui-toggle="modal" data-coreui-target="#newPostModal">
                                <i class="bi bi-plus-lg me-1"></i> Nuevo Artículo
                            </button>
                            <a href="../" target="_blank" class="btn btn-outline-light fw-bold px-4 py-2 rounded-pill">
                                <i class="bi bi-eye me-1"></i> Ver Blog
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 d-none d-md-flex align-items-center justify-content-center bg-white bg-opacity-10" style="backdrop-filter: blur(10px);">
                        <i class="bi bi-rocket-takeoff text-white opacity-25" style="font-size: 120px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Grid -->
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: 20px;">
            <div class="d-flex align-items-center">
                <div class="avatar avatar-lg bg-indigo-50 text-indigo-600 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: #f0f4ff;">
                    <i class="bi bi-journal-text fs-3"></i>
                </div>
                <div class="ms-3">
                    <div class="h3 fw-bold mb-0"><?php echo $posts_count; ?></div>
                    <div class="text-muted small fw-bold text-uppercase">Artículos</div>
                </div>
                <div class="ms-auto text-emerald-500 fw-bold small">
                    <i class="bi bi-arrow-up-right"></i> +2
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: 20px;">
            <div class="d-flex align-items-center">
                <div class="avatar avatar-lg bg-emerald-50 text-emerald-600 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: #ecfdf5;">
                    <i class="bi bi-tags fs-3" style="color: #059669;"></i>
                </div>
                <div class="ms-3">
                    <div class="h3 fw-bold mb-0"><?php echo $categories_count; ?></div>
                    <div class="text-muted small fw-bold text-uppercase">Categorías</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: 20px;">
            <div class="d-flex align-items-center">
                <div class="avatar avatar-lg bg-amber-50 text-amber-600 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: #fffbeb;">
                    <i class="bi bi-chat-left-dots fs-3" style="color: #d97706;"></i>
                </div>
                <div class="ms-3">
                    <div class="h3 fw-bold mb-0"><?php echo $comments_count; ?></div>
                    <div class="text-muted small fw-bold text-uppercase">Comentarios</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Posts -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm" style="border-radius: 20px;">
            <div class="card-header bg-white border-bottom-0 p-4 d-flex align-items-center">
                <h5 class="fw-bold mb-0">Publicaciones Recientes</h5>
                <a href="./?view=posts" class="ms-auto text-decoration-none small fw-bold">Gestionar todos <i class="bi bi-arrow-right ms-1"></i></a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small text-uppercase">
                            <tr>
                                <th class="ps-4">Artículo</th>
                                <th>Estado</th>
                                <th class="pe-4">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($latest_posts as $post): ?>
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="fw-bold text-dark"><?php echo $post->title; ?></div>
                                    </div>
                                </td>
                                <td>
                                    <?php if($post->status == 1): ?>
                                        <span class="badge bg-emerald-100 text-emerald-700 rounded-pill small">Publicado</span>
                                    <?php else: ?>
                                        <span class="badge bg-light text-muted rounded-pill small">Borrador</span>
                                    <?php endif; ?>
                                </td>
                                <td class="pe-4 small text-muted"><?php echo date("d/m/Y", strtotime($post->created_at)); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Tips / Sidebar -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
            <div class="card-body p-4 text-center">
                <div class="mb-3 text-indigo-500">
                    <i class="bi bi-lightning-charge-fill fs-1"></i>
                </div>
                <h6 class="fw-bold">Acción Rápida</h6>
                <p class="text-muted small mb-4">¿Tienes una idea nueva? Publícala ahora mismo para tus lectores.</p>
                <button class="btn btn-dark w-100 rounded-pill fw-bold" data-coreui-toggle="modal" data-coreui-target="#newPostModal">Redactar Post</button>
            </div>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius: 20px;">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="bi bi-info-circle me-2"></i>Estado del Sistema</h6>
                <div class="d-flex align-items-center mb-3">
                    <div class="small fw-bold">PHP Version</div>
                    <div class="ms-auto small text-muted"><?php echo phpversion(); ?></div>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <div class="small fw-bold">Base de Datos</div>
                    <div class="ms-auto small text-muted text-emerald-600">Conectado</div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="small fw-bold">Modo</div>
                    <div class="ms-auto small"><span class="badge bg-indigo-100 text-indigo-700">Administrador</span></div>
                </div>
            </div>
        </div>
    </div>
</div>
