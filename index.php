<?php
require_once('./app/config/Conecct.php');
$connect = new Conecct();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="description" content="">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

  <!-- Title -->
  <title>One Music - Modern Music HTML5 Template</title>

  <!-- Favicon -->
  <link rel="icon" href="./recursos/recursos/recursos_portal/img/core-img/favicon.ico">

  <!-- Stylesheet -->
  <link rel="stylesheet" href="./recursos/recursos_portal/style.css">

</head>

<body>
  <!-- Preloader -->
  <div class="preloader d-flex align-items-center justify-content-center">
    <div class="lds-ellipsis">
      <div></div>
      <div></div>
      <div></div>
      <div></div>
    </div>
  </div>

  <!-- ##### Header Area Start ##### -->
  <header class="header-area">
    <div class="oneMusic-main-menu">
      <div class="classy-nav-container breakpoint-off">
        <div class="container">
          <!-- Menu -->
          <nav class="classy-navbar justify-content-between" id="oneMusicNav">

            <!-- Nav brand -->
            <a href="./app/views/portal/index.php" class="nav-brand"><img
                src="./recursos/recursos_portal/img/core-img/logo.png" alt=""></a>

            <!-- Navbar Toggler -->
            <div class="classy-navbar-toggler">
              <span class="navbarToggler"><span></span><span></span><span></span></span>
            </div>

            <!-- Menu -->
            <div class="classy-menu">

              <!-- Close Button -->
              <div class="classycloseIcon">
                <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
              </div>

              <!-- Nav Start -->
              <div class="classynav">
                <ul>
                  <li><a href="./app/views/portal/index.php">Inicio</a></li>
                  <li><a href="./app/views/portal/event.php">Eventos</a></li>
                  <li><a href="./app/views/portal/albums-store.php">Generos</a></li>
                  <li><a href="./app/views/portal/artistas.php">Artistas</a></li>
                  <li><a href="./app/views/portal/votar.php">Votar</a></li>
                </ul>

                <!-- Login/Register & Cart Button -->
                <div class="login-register-cart-button d-flex align-items-center">
                  <!-- Login/Register -->
                  <div class="login-register-btn mr-50">
                    <?php if (isset($_SESSION["nickname"])): ?>
                      <div class="dropdown">
                        <a href="#" class="dropdown-toggle" id="userDropdown" data-toggle="dropdown" aria-haspopup="true"
                          aria-expanded="false">
                          <?= htmlspecialchars($_SESSION["nickname"]) ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="userDropdown">
                          <a class="dropdown-item text-dark" href="./app/views/portal/miPerfil.php">Mi perfil</a>
                          <a class="dropdown-item text-dark" href="./backend/panel/liberate_user.php">Cerrar
                            sesión</a>
                        </div>
                      </div>
                    <?php else: ?>
                      <a href="./index.php">Iniciar sesión</a>
                    <?php endif; ?>
                  </div>

                  <!-- Cart Button -->
                </div>

              </div>
              <!-- Nav End -->

            </div>
          </nav>
        </div>
      </div>
    </div>
    <!-- Navbar Area -->
    <div class="oneMusic-main-menu">
      <div class="classy-nav-container breakpoint-off">
        <div class="container">
          <!-- Menu -->
        </div>
      </div>
    </div>
  </header>
  <!-- ##### Header Area End ##### -->

  <!-- ##### Breadcumb Area Start ##### -->
  <section class="breadcumb-area bg-img bg-overlay"
    style="background-image: url(./recursos/recursos_portal/img/bg-img/breadcumb3.jpg);">
    <div class="bradcumbContent">
      <h2>Iniciar Sesión</h2>
    </div>
  </section>
  <!-- ##### Breadcumb Area End ##### -->

  <!-- ##### Login Area Start ##### -->
  <section class="login-area section-padding-100">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
          <div class="login-content">
            <?php
            if (isset($_GET['error']) && isset($_GET['type'])) {
              echo '<div class="alert alert-' . $_GET['type'] . '" role="alert">
                            ' . $_GET['error'] . '
                            </div>';
            }
            ?>

            <h3>bienvenido de nuevo</h3>
            <!-- Login Form -->
            <div class="login-form">
              <form action="./app/backend/panel/validate_user.php" method="post">
                <div class="form-group">
                  <label for="exampleInputEmail1">Correo Electrónico</label>
                  <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                    aria-describedby="emailHelp" placeholder="Ingresa tu correo electrónico">
                  <small id="emailHelp" class="form-text text-muted"><i class="fa fa-lock mr-2"></i>
                    Nunca compartiremos su correo electrónico con nadie más.</small>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Contraseña</label>
                  <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                    placeholder="Ingresa tu contraseña">
                </div>
                <button type="submit" class="btn oneMusic-btn mt-30">Login</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ##### Login Area End ##### -->

  <!-- ##### Footer Area Start ##### -->
  <footer class="footer-area">
    <div class="container">
      <div class="row d-flex flex-wrap align-items-center">
        <div class="col-12 col-md-6">
          <a href="./index.php"><img src="./recursos/recursos_portal/img/core-img/logo.png" alt=""></a>
          <p class="copywrite-text"><a
              href="#"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
              Copyright &copy;
              <script>document.write(new Date().getFullYear());</script> All rights reserved | This
              template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="#"
                target="_blank">Colorlib</a>
              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
        </div>

        <div class="col-12 col-md-6">
          <div class="footer-nav">
            <ul>
              <li><a href="./app/views/portal/index.php">Inicio</a></li>
              <li><a href="./app/views/portal/event.php">Eventos</a></li>
              <li><a href="./app/views/portal/albums-store.php">Generos</a></li>
              <li><a href="./app/views/portal/artistas.php">Artistas</a></li>
              <li><a href="./app/views/portal/votar.php">Votar</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- ##### Footer Area Start ##### -->

  <!-- ##### All Javascript Script ##### -->
  <!-- jQuery-2.2.4 js -->
  <script src="./recursos/recursos_portal/js/jquery/jquery-2.2.4.min.js"></script>
  <!-- Popper js -->
  <script src="./recursos/recursos_portal/js/bootstrap/popper.min.js"></script>
  <!-- Bootstrap js -->
  <script src="./recursos/recursos_portal/js/bootstrap/bootstrap.min.js"></script>
  <!-- All Plugins js -->
  <script src="./recursos/recursos_portal/js/plugins/plugins.js"></script>
  <!-- Active js -->
  <script src="./recursos/recursos_portal/js/active.js"></script>
</body>

</html>