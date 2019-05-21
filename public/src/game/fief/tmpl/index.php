<?php 
$page_title = "Mi feudo";

$left_list_html = render_left_menu('fief');

$content_html = render_content($alerts, $vassals, $villages, $land_res);

require_once '../masterPage.php';

function render_content($alerts){ 
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
                    <span class="small_header">Mis vasallos<br></span>
                </div>
                <div class="col-12 mb-3">
                    Nada que reportar
                </div>
            </div>
        </div>
    </div>

    <!--Second row -->
    <div class="row pb-1">
        <div class="col-12">
            <span class="small_header">Mis posesiones</span><br>
        </div>
    </div>
    
    <!--My villages-->
    <div class="row">
        <div class="col-md-6 vertical_separator">
            
            <div class="row mb-4">
                <div class="col-12">
                    <span class="slightly_smaller_header">Mis pueblos y villas</span>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <table id="" class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                        <th class="centered_td" scope="col" colspan="4">Pueblos y villas</th>
                        </tr>
                        <tr>
                        <th></th>
                        <th class="centered_td" scope="col">Nombre</th>
                        <th class="centered_td" scope="col">Población</th>
                        <th class="centered_td" scope="col">Ingresos</th>
                        </tr>
                        </thead>

                        
                    </table>  
                </div>
            </div>
        </div>
        
        <!--My lands-->
        <div class="col-md-6">
            <div class="row mb-4">
                <div class="col-12">
                    <span class="slightly_smaller_header">Mis tierras</span>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    
                    <table id="" class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                        <th class="centered_td" scope="col" colspan="4">Tierras</th>
                        </tr>
                        <tr>
                        <th></th>
                        <th class="centered_td" scope="col">Nombre</th>
                        <th class="centered_td" scope="col">Ocupación</th>
                        <th class="centered_td" scope="col">Producción</th>
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