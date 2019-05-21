<?php 

$page_title = "Mi castillo";

$my_js_scripts = render_my_js_scripts();

$left_list_html = render_left_menu('castle');

$content_html = render_content($alerts, $pantry_occupied, $pantry_max_cap, $pantry_space_bar_type, 
        $ware_occupied, $ware_max_cap, $ware_space_bar_type);

require_once '../masterPage.php';

function render_my_js_scripts(){
    ob_start();
    return ob_get_clean();
}


    
function render_content($alerts, $pantry_occupied, $pantry_max_cap, $pantry_space_bar_type, 
        $ware_occupied, $ware_max_cap, $ware_space_bar_type){
    
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
                            <?php if (empty($alerts)){ ?>
                                <tr><td>No parece haber alertas pendientes.</td></tr>
                            <?php } 
                            foreach ($alerts as $alert){ ?>
                                <tr>
                                    <td><img style="vertical-align:central;" src="<?php echo $alert['img']?>" alt="Alerta" height="16px" width=16px"></td>
                                    <td><a class="no_color_link" href="<?php echo $alert['url']?>"><?php echo $alert['msg']?></a></td>
                                </tr>
                            <?php } ?>
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
            <span class="small_header">Balance de los últimos 4 ciclos</span><br>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 vertical_separator">
            
            <div class="row mb-4">
                <div class="col-6 col-md-8">
                    <span class="slightly_smaller_header">Despensa</span><br>
                </div>
                <div class="col-6 col-md-4 my-auto">
                    <div class="progress">
                        <div class="progress-bar <?php echo $pantry_space_bar_type?>" role="progressbar" aria-valuenow="<?php echo $pantry_occupied?>"
                            aria-valuemin="0" aria-valuemax="<?php echo $pantry_max_cap?>" 
                            style="width:<?php echo $pantry_occupied/$pantry_max_cap*100; ?>%; display:inline-block">
                            <?php echo "$pantry_occupied/$pantry_max_cap"?>
                            &nbsp;
                            <img style="vertical-align:top;" src="../../../img/icons/items/items.png" alt="Materiales" title="Materiales" 
                            height="16px" width=16px">
                        </div>
                    </div>
                </div>
            </div>
            
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

                        

                    </table>
                </div>
            </div>
        </div>


        <div class="col-md-6 col-md-offset-2">
            
            <div class="row mb-4">
                <div class="col-6 col-md-8">
                    <span class="slightly_smaller_header">Almacén</span><br>
                </div>
                <div class="col-6 col-md-4 my-auto">
                    <div class="progress">
                        <div class="progress-bar <?php echo $ware_space_bar_type?>" role="progressbar" aria-valuenow="<?php echo $ware_occupied?>"
                            aria-valuemin="0" aria-valuemax="<?php echo $ware_max_cap?>" 
                            style="width:<?php echo $ware_occupied/$ware_max_cap*100; ?>%; display:inline-block">
                            <?php echo "$ware_occupied/$ware_max_cap"?>
                            &nbsp;
                            <img style="vertical-align:top;" src="../../../img/icons/items/items.png" alt="Materiales" title="Materiales" 
                            height="16px" width=16px">
                        </div>
                    </div>
                </div>
            </div>

            
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

                        

                    </table>
                </div>
            </div>

        </div>


    </div>

    <?php
    return ob_get_clean();
}

                



