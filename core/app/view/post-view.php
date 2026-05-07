<?php
$jb  = PostData::getById($_GET["id"]);
$recent_posts = PostData::getLatestActive(10);
?>

<div class="container">
  <div class="row">
    <div class="col-lg-8">
      <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="./" class="text-decoration-none">Inicio</a></li>
          <li class="breadcrumb-item"><a href="./?view=blog" class="text-decoration-none">Blog</a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo $jb->title; ?></li>
        </ol>
      </nav>

      <article class="mb-5 bg-white p-4 p-lg-5 shadow-sm rounded-4">
        <header class="mb-5">
          <div class="mb-3 d-flex align-items-center">
            <span class="badge bg-primary rounded-pill px-3">
              <?php if($jb->category_id!=null): ?>
                <?php echo CategoryData::getById($jb->category_id)->name; ?>
              <?php else: ?>
                General
              <?php endif; ?>
            </span>
            <span class="text-muted small ms-3"><i class="bi bi-calendar3 me-1"></i> <?php echo date("d M, Y", strtotime($jb->created_at)); ?></span>
          </div>
          <h1 class="display-4 fw-bold mb-3"><?php echo $jb->title; ?></h1>
          <p class="lead text-muted fst-italic"><?php echo $jb->brief; ?></p>
        </header>

        <?php if($jb->image!=""):?>
          <div class="mb-5 rounded-4 overflow-hidden shadow-sm">
            <img src="admin/uploads/<?php echo $jb->image; ?>" class="img-fluid w-100" alt="<?php echo $jb->title; ?>">
          </div>
        <?php endif; ?>

        <div class="content fs-5 lh-lg mb-5 text-dark">
          <?php echo nl2br($jb->content); ?>
        </div>
      </article>

      <!-- Comment Section -->
      <section id="comments" class="mb-5">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-4 p-lg-5">
                <h3 class="fw-bold mb-4">Conversación</h3>
                <div class="row g-5">
                    <div class="col-md-5">
                        <h5 class="fw-bold mb-3">Deja un comentario</h5>
                        <form method="post" action="./?action=send" enctype="multipart/form-data">
                            <input type="hidden" name="post_id" value="<?php echo $jb->id; ?>">
                            <div class="mb-3">
                                <input type="text" name="name" class="form-control rounded-pill px-3" placeholder="Tu nombre" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" name="email" required class="form-control rounded-pill px-3" placeholder="Correo electrónico">
                            </div>
                            <div class="mb-3">
                                <textarea name="comment" class="form-control rounded-4 px-3 py-3" placeholder="¿Qué piensas?" required rows="4"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold">
                                <i class="bi bi-send me-2"></i>Enviar
                            </button>
                        </form>
                    </div>

                    <div class="col-md-7">
                        <?php
                        $comments  = CommentData::getPublicByPost($jb->id);
                        ?>
                        <h5 class="fw-bold mb-4">Comentarios (<?php echo count($comments); ?>)</h5>
                        
                        <?php if(count($comments) > 0): ?>
                        <div class="comment-list" style="max-height: 500px; overflow-y: auto;">
                            <?php foreach($comments as $com):?>
                            <div class="card border-0 bg-light rounded-4 mb-3 p-3">
                                <div class="d-flex align-items-start">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; min-width: 40px;">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1 small"><?php echo $com->name; ?></h6>
                                    <p class="text-muted mb-0 small"><?php echo $com->comment; ?></p>
                                </div>
                                </div>
                            </div>
                            <?php endforeach ; ?>
                        </div>
                        <?php else: ?>
                        <div class="text-center py-4 bg-light rounded-4 border border-dashed">
                            <i class="bi bi-chat-dots text-muted fs-2"></i>
                            <p class="text-muted mt-2 small">Sé el primero en comentar.</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
      </section>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
      <div class="sticky-top" style="top: 2rem;">
        <!-- Search Widget -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
          <div class="card-body p-4">
            <h5 class="fw-bold mb-3">Buscar</h5>
            <form action="./" method="get">
              <input type="hidden" name="view" value="blog">
              <div class="input-group">
                <input type="text" name="q" class="form-control border-end-0 rounded-start-pill ps-3" placeholder="Buscar artículos...">
                <button class="btn btn-primary rounded-end-pill px-3" type="submit"><i class="bi bi-search"></i></button>
              </div>
            </form>
          </div>
        </div>

        <!-- Recent Posts Widget -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
          <div class="card-body p-4">
            <h5 class="fw-bold mb-4">Artículos Recientes</h5>
            <div class="recent-posts">
              <?php foreach($recent_posts as $rp): ?>
                <div class="d-flex align-items-center mb-3">
                  <?php if($rp->image != ""): ?>
                    <img src="admin/uploads/<?php echo $rp->image; ?>" class="rounded-3 me-3" style="width: 60px; height: 60px; object-fit: cover;">
                  <?php else: ?>
                    <div class="bg-light rounded-3 me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; min-width: 60px;">
                      <i class="bi bi-image text-muted"></i>
                    </div>
                  <?php endif; ?>
                  <div>
                    <a href="./?view=post&id=<?php echo $rp->id; ?>" class="text-decoration-none text-dark fw-bold small d-block mb-1 lh-sm"><?php echo $rp->title; ?></a>
                    <span class="text-muted" style="font-size: 11px;"><?php echo date("d M, Y", strtotime($rp->created_at)); ?></span>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>