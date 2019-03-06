<?php 

$page_title = "Ora et Labora - ¡Ups!";

$my_js_scripts = render_my_js_scripts();

$content_html = render_content();

require_once 'masterPage_front.php';

function render_my_js_scripts(){
    ob_start();
    ?>
        <script src="js/mail_prot.js"></script>
    <?php
    return ob_get_clean();
}

function render_content(){
    ob_start();
    ?>

        <div class="row">
            <div class="col-md-6 center">
                <img class="img-fluid" src="../../img/error_image.jpg" alt="Error image"> 
            </div>

            <div class="col-md-6 center">
                <h1>¿Qué se ha roto esta vez?</h1>

                Si estás aquí es que ha habido un fallo en el servidor o la página que has pedido no existe o no está disponible. No es estraño y probablemente no tengas tú la culpa. El juego se encuentra en desarrollo y estas cosas son más comunes de lo que deberían.
                <br>
                Prueba de nuevo o informa del error en cualquiera de los canales disponibles o enviando un mensaje al <a id="email" href="click:the.address.will.be.decrypted.by.javascript" onclick='decipher_mail(this, event);'>administrador del juego</a>.
            </div>
         </div>
    <?php
    return ob_get_clean(); 
}
