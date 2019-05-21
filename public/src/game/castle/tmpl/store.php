<?php 

$page_title = "Almacenes";

$my_js_scripts = render_my_js_scripts();

$left_list_html = render_left_menu('castle');

$content_html = render_content($pantry_occupied, $pantry_max_cap, 
        $pantry_space_bar_type, $pantry_items, $ware_occupied, $ware_max_cap, 
        $ware_space_bar_type, $ware_items, $open_pantry, $open_ware);

require_once '../masterPage.php';

function render_my_js_scripts(){
    ob_start();
    ?>
        <script src="../../utils/js/tab_management.js"></script>
    <?php
    return ob_get_clean();
}


function render_content($pantry_occupied, $pantry_max_cap,
        $pantry_space_bar_type, $pantry_items, $ware_occupied, $ware_max_cap, 
        $ware_space_bar_type, $ware_items, $open_pantry, $open_ware){ 
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
            
            <div class="row mb-2 mt-1">
                <div class="col-6 col-md-9" style="text-align:right">
                    <b>Capacidad: </b>
                </div>
                <div class="col-6 col-md-3 my-auto">
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
          
            
            <div class="row mb-2 mt-1">
                <?php foreach($pantry_items as $title => $items){ ?>
                <div class="col-12 col-md-6">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th class="centered_td" colspan="3" align="center"><?php echo $title?></th>
                        </tr>
                        <tr>
                            <th class="centered_td" scope="col"></th>
                            <th class="centered_td" scope="col">Objeto</th>
                            <th class="centered_td" scope="col">Cantidad</th>
                        </tr>
                        </thead>
                        </tbody>
                        <?php if(empty($items)) {?>
                            <tr>
                            <td colspan="3" align="center">¡Ningún objeto de este tipo!</td>
                            </tr>
                        <?php } else { 
                            foreach($items as $item_name => $item_info){ ?>
                                <tr>
                                <td class="centered_td"><img style="vertical-align:top;" src="../../../<?php echo $item_info['img']?>" alt="" 
                                    height="16px" width=16px"></td>
                                <td><?php echo $item_name?></td>
                                <td class="right_td"><?php echo $item_info['quantity']?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php } ?>
            </div>
            
        </div>
        
        <!--Warehouse tab-->
        <div id="Almacen" class="tabcontent">
            <div class="row mb-2 mt-1">
                <div class="col-6 col-md-9" style="text-align:right">
                    <b>Capacidad: </b>
                </div>
                <div class="col-6 col-md-3 my-auto">
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
            
            
                <div class="row mb-2 mt-1">
                <?php foreach($ware_items as $title => $items){ ?>
                <div class="col-12 col-md-6">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th class="centered_td" colspan="3" align="center"><?php echo $title?></th>
                        </tr>
                        <tr>
                            <th class="centered_td" scope="col"></th>
                            <th class="centered_td" scope="col">Objeto</th>
                            <th class="centered_td" scope="col">Cantidad</th>
                        </tr>
                        </thead>
                        </tbody>
                        <?php if(empty($items)) {?>
                            <tr>
                            <td colspan="3" align="center">¡Ningún objeto de este tipo!</td>
                            </tr>
                        <?php } else { 
                            foreach($items as $item_name => $item_info){ ?>
                                <tr>
                                <td class="centered_td"><img style="vertical-align:top;" src="../../../<?php echo $item_info['img']?>" alt="" 
                                    height="16px" width=16px"></td>
                                <td><?php echo $item_name?></td>
                                <td class="right_td"><?php echo $item_info['quantity']?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php } ?>
            </div>

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

      

