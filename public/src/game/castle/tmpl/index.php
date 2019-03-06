<?php 

$page_title = "Mi castillo";

$my_js_scripts = render_my_js_scripts();

$left_list_html = render_left_menu('castle');

$content_html = render_content();

require_once '../masterPage.php';

function render_my_js_scripts(){
    ob_start();
    return ob_get_clean();
}


    
function render_content(){ 
    ob_start();
    ?>

    <div class="row mb-3">

        <div class="col-md-6">
            <div class="row">
                <div class="col-12 pb-1">
                    <span class="small_header">Notificaciones <br></span>
                </div>
                <div class="col-12">
                    <div class="overview_table">
                        <table class='table table-hover'>
                            <tr><td colspan='2'>Ninguna notificación disponible.</td></tr>
                        </table>
                    </div>
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
    <div class="row pb-1">
        <div class="col-12">
            <span class="small_header">Producción</span><br>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 vertical_separator">
            <span class="slightly_smaller_header">Despensa</span><br>
            <span class="float-right"><b>Espacio disponible: 100/200</b></span><br>

            <div class="row">
                <div class="col-sm-6">
                    <table id="" class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                        <th class="centered_td" scope="col" colspan="3">Materias primas</th>
                        </tr>
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
                <div class="col-sm-6">
                    <table id="" class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                        <th class="centered_td" scope="col" colspan="3">Elaboraciones</th>
                        </tr>
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


        <div class="col-md-6 col-md-offset-2">
            <span class="slightly_smaller_header">Almacén</span><br>
            <span class="float-right"><b>Espacio disponible: 100/200</b></span><br>

            <div class="row">
                <div class="col-sm-6">
                    <table id="" class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                        <th class="centered_td" scope="col" colspan="3">Materias primas</th>
                        </tr>
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
                <div class="col-sm-6">
                    <table id="" class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                        <th class="centered_td" scope="col" colspan="3">Manufacturas</th>
                        </tr>
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

                



