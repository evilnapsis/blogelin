<!--
Este es el layout principal, a partir de este layout o plantilla se muestran el resto de "vistas"
-->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?=Html::title('Blogelin - Evilnapsis');?>
    <?=Html::link('assets/bootstrap/css/bootstrap.min.css'); ?>
    <?=Html::link('assets/bootstrap-icons/bootstrap-icons.css'); ?>
    <?=Html::script('assets/js/jquery.min.js'); ?>
    <style>
      body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
      .navbar { box-shadow: 0 2px 4px rgba(0,0,0,.1); }
      .navbar-brand { font-weight: 800; letter-spacing: -1px; }
      .footer { background-color: #ffffff; border-top: 1px solid #dee2e6; padding: 2rem 0; margin-top: 4rem; }
    </style>
  </head>

  <body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="./">
      <i class="bi bi-rocket-takeoff-fill me-2 text-primary"></i>BLOGELIN
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" href="./"><i class="bi bi-house-door me-1"></i> INICIO</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./?view=blog"><i class="bi bi-journal-text me-1"></i> BLOG</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<main class="py-5">
<?php 
  View::load("index");
?>
</main>

<footer class="footer mt-auto">
  <div class="container text-center">
    <p class="text-muted mb-0">Powered by <a href="http://evilnapsis.com/" target="_blank" class="text-decoration-none fw-bold text-primary">Evilnapsis</a> &copy; 2026</p>
    <div class="mt-2">
      <a href="#" class="text-muted me-3"><i class="bi bi-facebook"></i></a>
      <a href="#" class="text-muted me-3"><i class="bi bi-twitter-x"></i></a>
      <a href="#" class="text-muted"><i class="bi bi-github"></i></a>
    </div>
  </div>
</footer>

<?= Html::script('assets/bootstrap/js/bootstrap.bundle.min.js'); ?>
  </body>
</html>
