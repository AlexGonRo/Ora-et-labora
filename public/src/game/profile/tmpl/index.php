<?php

$page_title = "Inicio";

$my_js_scripts = render_my_js_scripts();

$alerts_html = render_alerts($welcome, $need_tutorial, $still_in_France, $days_left);

$left_list_html = render_left_menu('profile');

$content_html = render_content($news, $alerts, $active_actions);

require_once '../masterPage.php';

function render_my_js_scripts(){
    ob_start();
    ?>
        <script src="js/move_player.js"></script>
    <?php
    return ob_get_clean();
}

function render_alerts($welcome, $need_tutorial, $still_in_France, $days_left){
    ob_start();
    # Do we welcome the user?
    if($welcome){
        ?>
        <div class="alert alert-success alert-dismissible fade show">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <p>Bienvenido <strong><?php echo $_SESSION['username']; ?></strong></p>
        </div>
        <?php 
    }

    # Do we need to show the tutorial?
    if ($need_tutorial){
        ?>
        <!--LOAD MODAL -->
        <script type="text/javascript">
            $(window).on('load',function(){
                $('#tutorial_modal').modal('show');
            });
        </script>
        <!-- MODAL -->

        <div class="modal fade" id="tutorial_modal" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">TUTORIAL</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <p>¡¡BIENVENIDO AL TUTORIAL!!.</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
        </div>
        <?php
    }
    
    # Do we need to move away from France but we still have time to decide?
    if ($still_in_France && $days_left > 0 && $days_left < 999) {
        # Create the modal that allows the user to move to other town
        ?>
            <div class="modal fade" id="move_modal" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Selecciona tu próximo destino</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      <div class="modal-body">
                        <p>Selecciona a dónde quieres transladarse: </p>
                        <select id="town_selection_select">
                        </select> 
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-default" onclick="move_player(<?php echo $_SESSION['user_id']; ?>)">Transladarme</button>
                      </div>
                    </div>

                </div>
            </div>
            <!--End modal-->
            
            <!--Show an alert to inform the user how much time he has left -->
            <div class="alert alert-warning alert-dismissible fade show">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <div>
                    <p>Quedan <?php echo $days_left ?> días hasta que tengamos que movernos obligatoriamente a la península.</p>
                    <button class="btn" type="button" onclick="open_moving_option()">Transladarme a la península</button>
                </div>
            </div>
        <?php
    } else {
                # Open selection of new region pop-up inmediatly
                # TODO
    }
    
    return ob_get_clean(); 
}

function render_content($news, $alerts, $active_actions){
    ob_start();
    ?>
        <div id="horizontal_container">
            <span class="small_header">Últimas noticias<br></span>
            <div id="news" class="overview_table">
                <table class='table table-hover'>
                <?php if (empty($news)){ ?>
                    <tr><td colspan='2'>No hay noticias frescas... de momento.</td></tr>
                <?php } 
                foreach ($news as $new){ ?>
                    <tr>
                    <td width='10%'><?php echo $new['day']."-".$new['month']."-".$new['year']?></td>
                    <td width='90%'><?php echo $new['msg']?></td>
                    </tr>
                <?php } ?>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-12 col-sm-12">
                <span class="small_header">Alertas </br></span>
                <div id="alerts" class="overview_table">
                    <table class='table table-hover'>
                    <?php if (empty($alerts)){ ?>
                        <tr><td colspan='2'>No parece haber alertas pendientes.</td></tr>
                    <?php } 
                    foreach ($alerts as $alert){ ?>
                        <tr>
                        <td width='90%'><?php echo $alert['msg']?></td>
                        </tr>
                    <?php } ?>
                    </table>
                </div>
            </div>
            
            <div class="col-md-6 col-12 col-sm-12">
                <span class="small_header">Acciones activas <br></span>
                <div id="active_actions" class="overview_table">
                    <table class='table table-hover'>
                        <?php if (empty($active_actions)){ ?>
                            <tr><td colspan='2'>No hay noticias frescas... de momento.</td></tr>
                        <?php } 
                        foreach ($active_actions as $active_action){ ?>
                            <tr>
                            <td width='90%'><?php echo $active_action['msg']?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>

    <?php
    return ob_get_clean(); 
}