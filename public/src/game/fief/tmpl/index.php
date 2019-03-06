<?php 
$page_title = "Mi feudo";

$left_list_html = render_left_menu('fief');

$content_html = render_content();

require_once '../masterPage.php';

function render_content(){ 
    ob_start();
    ?>

    <div class="row mb-3">

        <div class="col-md-6">
            <div class="row">
                <div class="col-12 pb-1">
                    <span class="small_header">Mis vasallos <br></span>
                </div>
                <div class="col-12">
                    
                </div>
            </div>
        </div>  

        <div class="col-md-6">
            <div class="row">
                <div class="col-12 pb-1">
                    <span class="small_header">Edificios<br></span>
                </div>
                <div class="col-12 mb-3">
                    <span class="slightly_smaller_header">Huerta</span> <br>
                    Este edificio no existe <br>
                    <span class="slightly_smaller_header">Granja</span> <br>
                    Este edificio no existe <br>
                </div>
                <div class="col-12 pb-1">
                    <span class="small_header">Trabajadores</span> <br>
                </div>
                <div class="col-12">
                    Todo correcto <br>
                </div>
            </div>
        </div>
    </div>

    <!--Second row -->
    
    <div class="row">
        <div class="col-md-6 vertical_separator">
            <span class="small_header">Mis tierras</span><br>

            <div class="row">
                <div class="col-12">
                    <table id="" class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                        <th></th>
                        <th class="centered_td" scope="col">Nombre</th>
                        <th class="centered_td" scope="col">#</th>
                        </tr>
                        </thead>

                        <tr>
                        <td> ? </td>
                        <td class="right_td"> Edificio 1 </td>
                        <td class="centered_td">  1  </td>
                        <tr>
                    </table>  
                </div>
            </div>
        </div>
        
        <div class="col-md-6 vertical_separator">
            <span class="small_header">Mis tierras</span><br>

            <div class="row">
                <div class="col-12">
                    <table id="" class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                        <th></th>
                        <th class="centered_td" scope="col">Nombre</th>
                        <th class="centered_td" scope="col">#</th>
                        </tr>
                        </thead>

                        <tr>
                        <td> ? </td>
                        <td class="right_td"> Edificio 1 </td>
                        <td class="centered_td">  1  </td>
                        <tr>
                    </table>  
                </div>
            </div>
        </div>


    </div>

    <?php
    return ob_get_clean();
}