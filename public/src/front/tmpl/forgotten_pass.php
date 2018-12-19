<?php 

$page_title = "Ora et Labora - Contraseña olvidada";

$my_js_scripts = render_my_js_scripts();

$content_html = render_content();

require_once 'masterPage_front.php';

function render_my_js_scripts(){
    ob_start();
    ?>

    <?php
    return ob_get_clean();
}

function render_content(){
    ob_start();
    ?>
    Servicio no funcional.
    <?php
    return ob_get_clean(); 
}        

