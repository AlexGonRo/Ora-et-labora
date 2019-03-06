<?php 
$page_title = "Mercado - Visión general";

$left_list_html = render_left_menu('market');

$content_html = render_content();

require_once '../masterPage.php';

function render_content(){
    ob_start();
    ?>
    
    <!--Comerciantes en camino -->
    <div class="row">
        
    </div>
    
    <div class="row">
    <!--Ventas activas -->
    
    <!--Rutas comerciales activas
    
    </div>

    <?php
    return ob_get_clean(); 
}