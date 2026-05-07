<?php
$limit = 10;
$page = isset($_GET["page"]) ? $_GET["page"] : 1;
$offset = ($page - 1) * $limit;

$q = isset($_GET["q"]) ? $_GET["q"] : "";

if($q == ""){
    $posts = PostData::getAllActivePaged($offset, $limit);
    $total_posts = PostData::countActive();
} else {
    $posts = PostData::getLike($q);
    $total_posts = count($posts); // Limited to 10 in getLike
}

$recent_posts = PostData::getLatestActive(10);
$total_pages = ceil($total_posts / $limit);
?>

<div class="container">
  <div class="row mb-5">
    <div class="col-md-12">
      <?php if($q == ""): ?>
        <h1 class="display-5 fw-bold mb-2 text-dark"><i class="bi bi-journals me-2 text-primary"></i>Nuestro Blog</h1>
        <p class="text-muted lead">Explora nuestras últimas publicaciones y mantente informado.</p>
      <?php else: ?>
        <h1 class="display-5 fw-bold mb-2 text-dark"><i class="bi bi-search me-2 text-primary"></i>Resultados para: "<?php echo $q; ?>"</h1>
        <p class="text-muted lead">Se encontraron <?php echo $total_posts; ?> coincidencias.</p>
      <?php endif; ?>
    </div>
  </div>

  <div class="row">
    <!-- Main Content -->
    <div class="col-lg-8">
      <?php if(count($posts)>0):?>
        <div class="row g-4">
          <?php foreach($posts as $jb):?>
            <div class="col-12">
              <div class="card border-0 shadow-sm hover-shadow transition-all rounded-4 overflow-hidden mb-4">
                <div class="row g-0">
                  <?php if($jb->image!=""):?>
                    <div class="col-md-4">
                      <div class="h-100">
                        <img src="admin/uploads/<?php echo $jb->image; ?>" class="img-fluid h-100 object-fit-cover" alt="<?php echo $jb->title; ?>" style="min-height: 200px; width: 100%;">
                      </div>
                    </div>
                  <?php endif; ?>
                  <div class="<?php echo ($jb->image!="") ? 'col-md-8' : 'col-12'; ?>">
                    <div class="card-body p-4">
                      <div class="mb-3">
                        <span class="badge bg-primary rounded-pill px-3">
                          <?php if($jb->category_id!=null): ?>
                            <?php echo CategoryData::getById($jb->category_id)->name; ?>
                          <?php else: ?>
                            General
                          <?php endif; ?>
                        </span>
                        <span class="text-muted small ms-2"><i class="bi bi-calendar3 me-1"></i> <?php echo date("d M, Y", strtotime($jb->created_at)); ?></span>
                      </div>
                      <h3 class="card-title fw-bold mb-3"><?php echo $jb->title; ?></h3>
                      <p class="card-text text-muted mb-4"><?php echo $jb->brief; ?></p>
                      <a href="./?view=post&id=<?php echo $jb->id; ?>" class="btn btn-primary rounded-pill px-4">
                        Leer más <i class="bi bi-arrow-right ms-1"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if($q == "" && $total_pages > 1): ?>
          <nav aria-label="Page navigation" class="mt-5">
            <ul class="pagination pagination-lg justify-content-center">
              <?php if($page > 1): ?>
                <li class="page-item"><a class="page-link border-0 shadow-sm rounded-circle me-2" href="./?view=blog&page=<?php echo $page-1; ?>"><i class="bi bi-chevron-left"></i></a></li>
              <?php endif; ?>
              
              <?php for($i=1; $i<=$total_pages; $i++): ?>
                <li class="page-item <?php echo ($i==$page)?'active':''; ?>"><a class="page-link border-0 shadow-sm rounded-circle me-2" href="./?view=blog&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
              <?php endfor; ?>

              <?php if($page < $total_pages): ?>
                <li class="page-item"><a class="page-link border-0 shadow-sm rounded-circle" href="./?view=blog&page=<?php echo $page+1; ?>"><i class="bi bi-chevron-right"></i></a></li>
              <?php endif; ?>
            </ul>
          </nav>
        <?php endif; ?>

      <?php else:?>
        <div class="text-center py-5 bg-white shadow-sm rounded-4">
          <i class="bi bi-emoji-frown fs-1 text-muted mb-3"></i>
          <p class="alert alert-warning border-0 mx-4">No se encontraron artículos publicados.</p>
          <a href="./?view=blog" class="btn btn-outline-primary rounded-pill px-4">Ver todos los artículos</a>
        </div>
      <?php endif; ?>
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
                <input type="text" name="q" class="form-control border-end-0 rounded-start-pill ps-3" placeholder="Buscar artículos..." value="<?php echo $q; ?>">
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

        <!-- Categories Widget (Optional but good) -->
        <div class="card border-0 shadow-sm rounded-4 bg-primary text-white overflow-hidden">
          <div class="card-body p-4 position-relative">
            <div style="z-index: 1; position: relative;">
                <h5 class="fw-bold mb-2">¿Quieres escribir?</h5>
                <p class="small opacity-75 mb-3">Únete a nuestra comunidad y comparte tus ideas con el mundo.</p>
                <a href="admin/" class="btn btn-light btn-sm fw-bold rounded-pill px-4">Acceso Admin</a>
            </div>
            <i class="bi bi-lightning-fill position-absolute end-0 bottom-0 opacity-25" style="font-size: 80px; transform: translate(10%, 20%);"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .hover-shadow:hover {
    transform: translateY(-5px);
    box-shadow: 0 1rem 3rem rgba(0,0,0,.1) !important;
  }
  .transition-all {
    transition: all 0.3s ease;
  }
  .page-link { color: #6c757d; }
  .page-item.active .page-link { background-color: #0d6efd; border-color: #0d6efd; }
  .page-link:hover { background-color: #f8f9fa; }
</style>