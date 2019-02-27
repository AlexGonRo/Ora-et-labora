<?php 

$page_title = "Ora et Labora - Tu juego online gratuito";

$page_meta = render_metainfo();

$my_js_scripts = render_my_js_scripts();

$content_html = render_content();

require_once 'masterPage_front.php';

function render_metainfo(){
    ob_start();
    ?>
        <meta name="description" content="Ora et Labora es un juego online, de navegador, social y gratuito ambientado en la península ibérica de la Edad Media. ¡Conviértete en administrador de tu propio castillo o monasterio y hazlo crecer hasta convertirte en dueño y señor de tu propio reino!">
    <?php
    return ob_get_clean();
}

function render_my_js_scripts(){
    ob_start();
    ?>
        <script src="js/login_validation.js"></script>
    <?php
    return ob_get_clean();
}

function render_content(){
    ob_start();
    ?>
    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div id="login_first_div">
      <div class="container">
        <img id="login_oel_logo" class="mb-1 mb-md-3" src="../../img/public/oel_logo/logo_full_size.png" class="img-fluid" alt="Ora et Labora logo">
        <h5 class="normal_text_for_sm"><p><b><i>Ora et Labora</i></b> es un juego online, de navegador y gratuito ambientado en la Edad Media. ¡Conviértete en administrador de tu propio castillo o monasterio y hazlo crecer hasta convertirte en dueño y señor de tu propio reino!</p></h5>
        <p><button onclick="location.href='register.php'" class="btn login_btn"><b>¡Registrarse!</b></button></p>
      </div>
    </div>
    
    <div id="login_second_div">
      <div class="container">
        <!-- Example row of columns -->
        <div class="row">
          <div class="col-md-4">
            <h2>¡Versión 0.1 disponible!</h2>
            <p>Después de varios meses de trabajo y cientos de horas invertidas en el proyecto, por fin puedo presentar la primera versión de <b><i>Ora et Labora</i></b>. Ni se puede jugar ni es estable pero ahí la tenemos :)</p>

          </div>
          <div class="col-md-4">
            <h2>Código del proyecto</h2>
            <p><b><i>Ora et Labora</i></b> es un proyecto <i>Open Source</i> distribuido bajo la licencia MIT. Puedes consultar el código de la aplicación, copiarlo, modificarlo o publicarlo con tus propios cambios. ¡También podrías ayudarnos a mejorar el juego!</p>
            <p><a class="btn btn-secondary" href="https://github.com/AlexGonRo/Ora-et-labora/tree/master" target="_blank" role="button">Visitar el código &raquo;</a></p>
          </div>
          <div class="col-md-4">
            <h2>¡Aviso para navegantes!</h2>
            <p>El proyecto se encuentra en una fase inicial y no se garantiza que cambios futuros modifiquen drásticamente la dirección del mismo. Ten en cuenta que <b> esta aplicación NO se encuentra en un estado funcional </b> y puede que nunca llegue a estarlo. Si quieres unirte a un juego de similares características, te recomendamos <a href="http://edadmediaonline.com">Edad Media Online</a>.</p>
            
          </div>
        </div>

        <hr>

      </div> <!-- /container -->
    </div> <!-- Second login div -->
    <?php
    return ob_get_clean(); 
}


    
