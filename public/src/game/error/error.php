<?php 
session_start(); 
require '../../private/db_connect.php';
require '../../utils/php/other/verify_user.php';

$page_title = "¡Ups! Hemos fallado en algo";

$content_html = render_content();

require_once '../masterPage.php';


function render_content(){
    ob_start();
    ?>

        <div class="row">
            <div class="col-md-6 center">
                <img class="img-fluid" src="../../../img/public/error_image.jpg" alt="Error image"> 
            </div>

            <div class="col-md-6 center">
                <h1>¿Qué se ha roto esta vez?</h1>

                Si estás aquí es que ha habido un fallo en el servidor o la página que has pedido no existe o no está disponible. No es estraño y probablemente no tengas tú la culpa. El juego se encuentra en desarrollo y estas cosas son más comunes de lo que deberían.
                <br>
                Prueba de nuevo o informa del error en cualquiera de los canales disponibles o enviando un mensaje a <a href='mailto:administrador@orabora.net' target='_top'>administrador@orabora.net</a>.
            </div>
         </div>
    <?php
    return ob_get_clean(); 
}
