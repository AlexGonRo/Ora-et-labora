  <nav class="navbar navbar-expand-md fixed-top my_front_navbar my_lighter_box_shadow">
    
    <button class="navbar-toggler navbar-toggler-left" type="button" data-toggle="collapse" 
            data-target="#my_front_navbar">
      &#9776;
    </button>
      
    <!--Ora et Labora logo -->
    <a class="navbar-brand d-flex flex-fill" href="login.php">
        <!-- <img class="img-rounded" src="../../img/oel_icon/oel_icon32x32.png"> -->
        <img id="img_logo_in_navbar" src="../../img/oel_logo/logo_sixth_size.png" class="" alt="Ora et Labora logo">
    </a>

    <div class="collapse navbar-collapse sidenav" id="my_front_navbar">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item px-2 my_title_navbar_item">
          <a class="nav-link" disabled href="http://orabora.net/forum/">Foro</a>
        </li>
        
        <li class="nav-item px-2 my_title_navbar_item">
          <a class="nav-link" disabled href="http://orabora.net/dev_blog/">Blog de desarrollo</a>
        </li>
        
        <li class="nav-item px-2 my_title_navbar_item">
            <a class="nav-link" href="https://twitter.com/Ora_et_Labora_g"><img src="../../img/social_net_logos/Twitter/Twitter_SocialIcon_RoundedSquare/Twitter_Social_Icon_Rounded_Square_Color.svg" class="img-fluid" alt="Responsive image" > Twitter</a>
        </li>
        
        <li class="nav-item px-2 my_title_navbar_item">
            <a class="nav-link" href="https://discord.gg/zcZ5H3"><img src="../../img/social_net_logos/Discord/Discord-Logo-Black.svg" class="img-fluid" alt="Responsive image" > Discord</a>
        </li>
        
      </ul>
    </div>
    
    
        <div>
          <ul class="navbar-nav list-inline" id="my_login_navbar">
          <li class="nav-item list-inline-item"><button onclick="location.href='register.php'" class="btn login_btn"><b>¡Registrarse!</b></button>
          <li class="nav-item list-inline-item">
              <button href="#" class="btn login_btn" data-toggle="collapse" data-target="#login-dp"><b>Entrar</b></button>
                
          </li>
          </ul>
        </div>
  </nav>

  <div class="navbar_padding">    <!-- We need this padding because we have a menu on top --> 
  </div>

<div id="login-dp" class="col-md-2 collapse navbar-collapse login_sidenav my_box_shadow">
    <div id="login-dp-padding">
        <div class="row">
          <div class="col-md-12">
            <?php if(isset($login_errors) && $login_errors!=""){ ?>
            <div id="error_message" class="bg-warning mb-2 p-2"><?php echo $login_errors; ?></div>
            <?php } ?>
            <form class="form needs-validation" role="form" method="post" action="login.php" accept-charset="UTF-8" id="login-nav" novalidate>
              <div class="form-group">
                <label class="sr-only" for="username">Usuario</label>
                <input type="text" class="form-control" name="username" id="username" placeholder="Usuario" required>
                <div class="invalid-feedback">
                  Necesitas introducir el usuario.
                </div>
              </div>
              <div class="form-group">
                <label class="sr-only" for="pass">Contraseña</label>
                <input type="password" class="form-control" name="pass" id="pass" placeholder="Contraseña" required>
                <div class="invalid-feedback">
                  Necesitas introducir una contraseña
                </div>
                <div class="help-block text-right"><a href="forgotten_pass.php">¿Olvidaste tu contraseña?</a></div>
              </div>
              <div class="form-group">
                <button type="submit" formaction="login.php" class="btn btn-block">Entrar</button>
              </div>
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="remember_me" id="remember_me"> Recordar contraseña
                </label>
              </div>
            </form>
          </div>
        </div>
    </div>
</div>