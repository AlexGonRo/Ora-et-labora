<?php 
$page_title = "Mercado";

$left_list_html = render_left_menu('market');

$content_html = render_content();

require_once '../masterPage.php';


function render_content(){
    ob_start();
    ?>
    
    <div class="row">
        Filtro<br>
    </div>

    <div class="row">
        <table id="" class="table table-bordered table-hover table-striped">
            <thead>
            <tr>
            <th class="centered_td" scope="col">Objeto</th>
            <th class="centered_td" scope="col">Cantidad</th>
            <th class="centered_td" scope="col">Región</th>
            <th class="centered_td" scope="col">Tiempo de viaje estimado</th>
            <th class="centered_td" scope="col">Seguridad media</th>
            <th class="centered_td" scope="col">Comprar</th>

            </tr>
            </thead>

            <tr>
            <td> ? </td>
            <td class="right_td"> Edificio 1 </td>
            <td class="centered_td">  1  </td>
            <tr>
        </table>  
    </div>


    <?php
    return ob_get_clean(); 
}