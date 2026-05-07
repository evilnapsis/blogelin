<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Blogelin - Modern Blog Management System">
    <meta name="author" content="Evilnapsis">
    <title>Blogelin - Dashboard</title>
    <!-- Vendors styles-->
    <link rel="stylesheet" href="vendors/simplebar/css/simplebar.css">
    <link rel="stylesheet" href="css/vendors/simplebar.css">
    <!-- Main styles for this application-->
    <link href="css/style.css" rel="stylesheet">
    <script src="js/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="vendors/datatables/datatables.min.css">
    <script type="text/javascript" src="vendors/sweetalert/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
      body { font-family: 'Outfit', sans-serif; background-color: #f8fafc; }
      .sidebar { background: #2f3640 !important; }
      .sidebar-nav .nav-link:hover { background: rgba(255, 255, 255, 0.05); color: #fff; }
      .sidebar-nav .nav-link.active { background: rgba(255, 255, 255, 0.1) !important; color: #fff !important; font-weight: 600; }
      .nav-title { color: rgba(255,255,255,0.4) !important; font-weight: 700; letter-spacing: 1px; }
      .header { background: rgba(255, 255, 255, 0.8) !important; backdrop-filter: blur(10px); border-bottom: 1px solid rgba(0,0,0,0.05) !important; }
      .card { border-radius: 20px; border: none; transition: transform 0.2s; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
      .btn-primary { background: #6366f1; border: none; border-radius: 10px; padding: 10px 20px; }
      .btn-primary:hover { background: #4f46e5; }
      .text-indigo-400 { color: #818cf8 !important; }
      .text-indigo-600 { color: #4f46e5 !important; }
      .text-indigo-700 { color: #4338ca !important; }
      .text-indigo-900 { color: #1e1b4b !important; }
      .bg-indigo-50 { background-color: #f5f3ff !important; }
      .bg-indigo-100 { background-color: #e0e7ff !important; }
      .text-emerald-700 { color: #047857 !important; }
      .bg-emerald-100 { background-color: #d1fae5 !important; }
      .text-amber-700 { color: #b45309 !important; }
      .bg-amber-100 { background-color: #fef3c7 !important; }
      .btn-indigo { background-color: #6366f1 !important; color: white !important; }
      .btn-indigo:hover { background-color: #4f46e5 !important; }
    </style>
  </head>
  <body>
    <?php if(isset($_SESSION["user_id"])):
      $curr_user = UserData::getById($_SESSION["user_id"]);
      Core::$user = $curr_user;
    ?>
    <div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
      <div class="sidebar-header border-bottom border-white border-opacity-10">
        <div class="sidebar-brand">
          <span class="sidebar-brand-full" style="font-size:20px; font-weight: 700;"><i class="bi bi-rocket-takeoff me-2 text-indigo-400"></i>BLOGELIN</span>
          <span class="sidebar-brand-narrow">BL</span>
        </div>
        <button class="btn-close d-lg-none" type="button" data-coreui-dismiss="offcanvas" data-coreui-theme="dark" aria-label="Close" onclick="coreui.Sidebar.getInstance(document.querySelector(&quot;#sidebar&quot;)).toggle()"></button>
      </div>
      <ul class="sidebar-nav" data-coreui-navigation" data-simplebar="">
        <li class="nav-item">
          <a class="nav-link" href="./">
            <i class="nav-icon bi bi-grid-1x2"></i> Inicio
          </a>
        </li>

        <li class="nav-title text-uppercase small">Contenido</li>
        <li class="nav-item">
          <a class="nav-link" href="./?view=posts">
            <i class="nav-icon bi bi-journal-text"></i> Artículos
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./?view=categories">
            <i class="nav-icon bi bi-tags"></i> Categorías
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./?view=comments">
            <i class="nav-icon bi bi-chat-left-text"></i> Comentarios
          </a>
        </li>

        <li class="nav-title text-uppercase small">Sistema</li>
        <li class="nav-item">
          <a class="nav-link" href="./?view=users">
            <i class="nav-icon bi bi-people"></i> Usuarios
          </a>
        </li>

      </ul>
      <div class="sidebar-footer border-top border-white border-opacity-10 d-none d-md-flex">
        <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
      </div>
    </div>
    <div class="wrapper d-flex flex-column min-vh-100 bg-light bg-opacity-50">
      <header class="header header-sticky p-0 mb-4 shadow-sm">
        <div class="container-fluid px-4 h-100 d-flex align-items-center">
          <button class="header-toggler border-0 bg-transparent" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()" style="margin-inline-start: -14px;">
            <i class="bi bi-list fs-3 text-secondary"></i>
          </button>
          
          <ul class="header-nav ms-auto">
          </ul>
          <ul class="header-nav">
            <li class="nav-item dropdown"><a class="nav-link py-0 pe-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <div class="d-flex align-items-center">
                    <div class="text-end me-3 d-none d-md-block">
                        <div class="fw-bold small"><?php echo $curr_user->name; ?></div>
                        <div class="text-muted small" style="font-size: 10px;">En Línea</div>
                    </div>
                    <div class="avatar avatar-md text-white d-flex align-items-center justify-content-center rounded-circle fw-bold shadow-sm" style="background:#6366f1">
                      <?php echo substr($curr_user->name,0,1).substr($curr_user->lastname ?? '',0,1); ?>
                    </div>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-end pt-0 shadow-lg border-0 overflow-hidden" style="border-radius: 12px; min-width: 200px;">
                <div class="dropdown-header bg-light text-body-secondary fw-semibold mb-2">Cuenta</div>
                <a class="dropdown-item py-2" href="./?action=access&opt=logout">
                  <i class="bi bi-box-arrow-right me-3 text-danger"></i> Salir del Sistema
                </a>
              </div>
            </li>
          </ul>
        </div>
      </header>
      <div class="body flex-grow-1 pb-4">
        <div class="container-fluid px-4">
          <?php View::load("index"); ?>
        </div>
      </div>
      <footer class="footer px-4 border-top-0 bg-transparent text-muted small pb-4">
        <div>Blogelin v2.0</div>
        <div class="ms-auto">Built with <i class="bi bi-heart-fill text-danger mx-1"></i> by Evilnapsis</div>
      </footer>
    </div>
    <?php else:?>
    <div class="min-vh-100 d-flex flex-row align-items-center" style="background: radial-gradient(circle at top right, #4f46e5, #1e1b4b);">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-5">
            <div class="card shadow-lg border-0 overflow-hidden" style="border-radius: 24px; background: rgba(255,255,255,0.9); backdrop-filter: blur(20px);">
              <div class="card-body p-5">
                <div class="text-center mb-5">
                  <div class="avatar avatar-xl bg-indigo-100 text-indigo-600 mb-3 mx-auto d-flex align-items-center justify-content-center rounded-circle" style="width: 80px; height: 80px; background: #e0e7ff;">
                    <i class="bi bi-rocket-takeoff fs-1"></i>
                  </div>
                  <h1 class="h3 fw-bold text-indigo-900">BLOGELIN</h1>
                  <p class="text-indigo-400 small text-uppercase fw-bold tracking-widest">Admin Access</p>
                </div>
                <form method="post" action="./?action=access&opt=login">
                  <div class="mb-4">
                    <label class="form-label fw-600 small text-indigo-900">Usuario</label>
                    <div class="input-group input-group-lg">
                      <span class="input-group-text bg-white border-end-0 text-indigo-300"><i class="bi bi-person"></i></span>
                      <input class="form-control border-start-0 ps-0" name="username" required type="text" placeholder="nombre.usuario">
                    </div>
                  </div>
                  <div class="mb-5">
                    <label class="form-label fw-600 small text-indigo-900">Contraseña</label>
                    <div class="input-group input-group-lg">
                      <span class="input-group-text bg-white border-end-0 text-indigo-300"><i class="bi bi-lock"></i></span>
                      <input class="form-control border-start-0 ps-0" name="password" required type="password" placeholder="••••••••">
                    </div>
                  </div>
                  <div class="d-grid shadow-indigo-200">
                    <button class="btn btn-indigo btn-lg shadow-sm fw-bold py-3 text-white" type="submit" style="background: #6366f1; border:none; border-radius: 12px;">Entrar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>
    <!-- CoreUI and necessary plugins-->
    <script src="vendors/@coreui/coreui/js/coreui.bundle.min.js"></script>
    <script src="vendors/simplebar/js/simplebar.min.js"></script>
    <script src="vendors/datatables/datatables.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $(".datatable").each(function(){
          if ( ! $.fn.DataTable.isDataTable( this ) ) {
            $(this).DataTable({
              "retrieve": true,
              "responsive": true,
              "language": {
                "url": "./vendors/datatables/esmx.json"
              }
            });
          }
        });
        $(".nav-group-toggle").click(function(e){
          e.preventDefault();
          $(this).parent().toggleClass("show");
        });
      });
    </script>
  </body>
</html>
