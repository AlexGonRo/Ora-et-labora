<?php 

$page_title = "Almacenes";

$my_js_scripts = render_my_js_scripts();

$left_list_html = render_left_menu('castle');

$content_html = render_content($pantry_occupied, $pantry_max_cap, $pantry_items, 
        $ware_occupied, $ware_max_cap, $ware_items, $open_pantry, $open_ware);

require_once '../masterPage.php';

function render_my_js_scripts(){
    ob_start();
    ?>
        <script src="../../utils/js/tab_management.js"></script>
    <?php
    return ob_get_clean();
}


function render_content($pantry_occupied, $pantry_max_cap, $pantry_items, 
        $ware_occupied, $ware_max_cap, $ware_items, $open_pantry, $open_ware){ 
    ob_start();
    ?>
        <div class="tab">
            <button id="despensa_button" class="tablinks active" onclick="openTab(event, 'Despensa')">Despensa</button>
            <button id="almacen_button" class="tablinks" onclick="openTab(event, 'Almacen')">Almacén</button>
            <script>
                $(document).ready(function(){
                    document.getElementById('Despensa').style.display = "block";
                    document.getElementById('Despensa').class += " active";
                });
            </script>
        </div>
        
        <!--Pantry tab-->
        <div id="Despensa" class="tabcontent">
            
            <div class="float-right mb-3 slightly_bigger_text">
                <b> Capacidad: </b> <?php echo "$pantry_occupied/$pantry_max_cap"; ?> <br>
            </div>
            
            <table class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <th class="centered_td" scope="col">Objeto</td>
                    <th class="centered_td" scope="col">Cantidad</td>
                </tr>
                </thead>
                </tbody>
                <?php if(empty($pantry_items)) {?>
                    <tr>
                    <td colspan="2" align="center">¡Este edificio está completamente vacio!</td>
                    </tr>
                <?php } else { 
                    foreach($pantry_items as $item_name => $quantity){ ?>
                        <tr>
                        <td><?php echo $item_name?></td>
                        <td class="right_td"><?php echo $quantity?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
                </tbody>
            </table>
        </div>
        
        <!--Warehouse tab-->
        <div id="Almacen" class="tabcontent">
            <div class="float-right mb-3 slightly_bigger_text">
                <b>Capacidad:</b> <?php echo "$ware_occupied/$ware_max_cap"; ?> <br>
            </div>
            <table class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                <th class="centered_td" scope="col">Objeto</td>
                <th class="centered_td" scope="col">Cantidad</td>
                </tr>
                </thead>
              
                <?php if(empty($ware_items)) {?>
                    <tr>
                    <td colspan="2" align="center">¡Este edificio está completamente vacio!</td>
                    </tr>
                <?php } else { 
                    foreach($ware_items as $item_name => $quantity){ ?>
                        <tr>
                        <td><?php echo $item_name?></td>
                        <td class="right_td"><?php echo $quantity?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </table>

        </div>
        
        
        <!--In case we have some GET information about which tab should be opened first-->
        <?php if($open_pantry) { ?>
            <script>
                $(document).ready(function(){
                    document.getElementById('despensa_button').click();
                });
            </script>
        <?php } else if($open_ware){ ?>
            <script>
                $(document).ready(function(){
                    document.getElementById('almacen_button').click();
                });
            </script>
        <?php } ?>
    
    
    <?php
    return ob_get_clean();
}

      

