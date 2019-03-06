<?php 

$page_title = "Edificios";

$my_js_scripts = render_my_js_scripts();

$left_list_html = render_left_menu('castle');

$content_html = render_content($occupied, $total_space, $buildings, $total_maintenance);

require_once '../masterPage.php';

function render_my_js_scripts(){
    ob_start();
    ?>
        <script src="js/lvlup_building.js"></script>
        <script src="js/lvldown_building.js"></script>
    <?php
    return ob_get_clean();
}


    
function render_content($occupied, $total_space, $buildings, $total_maintenance){ 
    ob_start();
    ?>
    <div style="overflow: hidden "> <!-- We need this extra div to align right the last element without it getting out of the main content div -->
        <div class="float-right mb-3 slightly_bigger_text">
            <b>Espacio para edificios:</b> <?php echo $occupied."/".$total_space;?> <br>
        </div>
        
        <table class="table table-bordered table-hover table-striped">
            <thead>
            <tr>
                <th scope="col">Edificio</td>
                <th class="centered_td" scope="col">Nivel</td>
                <th class="centered_td" scope="col">Coste mantenimiento</td>
                <th class="centered_td" scope="col">% Conservación</td>
                <th class="centered_td" scope="col">Siguiente nivel:</td>
                <th class="centered_td" scope="col">Reducir nivel:</td>
                <th class="centered_td" scope="col"></td>
                </tr>
            <thead>
            <tbody>
            <?php foreach ($buildings as $building){ ?>
            <tr>
                <!--Name-->
                <td><?php echo $building['name']?></td>
                <!--Level-->
                <?php if ($building['under_construction']){ ?>
                    <td class="centered_td"><?php echo $building['level']; ?><br>(Ampliandose)</td>
                <?php } else {?>
                    <td class="centered_td"><?php echo $building['level']; ?><br></td>
                <?php } ?>
                <!--Maintenance cost-->
                <td class="centered_td">
                <?php foreach ($building['maint_array'] as $name => $info){ ?>
                    
                    <img src="../../../<?php echo ucfirst($info['icon']); ?>" alt="<?php echo ucfirst($name); ?>" title="<?php echo ucfirst($name); ?>" 
                         height="16px" width=16px">: <?php echo $info['quantity']; ?>
                    
                <?php } ?>
                </td>
                <!--Preservation value-->
                <td class="centered_td">
                    <div class="progress">
                        <?php if($building['preservation'] >= 75) { ?>
                            <div class="progress-bar bg-success" role="progressbar" aria-valuenow="<?php echo $building['preservation']?>"
                            aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $building['preservation']?>%">
                              <?php echo $building['preservation']?>
                            </div>
                        <?php } else if($building['preservation'] >= 25) { ?>
                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="<?php echo $building['preservation']?>"
                            aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $building['preservation']?>%">
                              <?php echo $building['preservation']?>
                            </div>
                        <?php } else { ?>
                            <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="<?php echo $building['preservation']?>"
                            aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $building['preservation']?>%">
                              <?php echo $building['preservation']?>
                            </div>
                         <?php }?>
                        
                      </div>
                </td>
                <!--Level up cost and option-->
                <td class="centered_td">
                <?php if($building['under_construction']){ ?>
                    Ampliandose
                <?php } else {?>
                    <p id='<?php echo "p_".$building['id'];?>' >
                    <?php foreach ($building['lvlup_array'] as $name => $info){ ?>
                        
                        <img src="../../../<?php echo ucfirst($info['icon']); ?>" alt="<?php echo ucfirst($name); ?>" title="<?php echo ucfirst($name); ?>" 
                         height="16px" width=16px">: <?php echo $info['quantity']; ?>
                        
                    <?php } ?>
                    </p>
                    
                    <?php if ($building['can_lvlup']){ ?>  
                        <button id='<?php echo "button_".$building['id']; ?>' type='button' onclick='lvlup_building(<?php echo $building['id'].",".$building['type'].",".$building['level']; ?>)'>Mejorar</button>
                    <?php } else {?>
                        <button id='<?php echo "button_".$building['id']; ?>' type='button' value='".$building_id."' disabled>Mejorar</button>
                    <?php } ?>
                <?php } ?>
                </td>
                <!--Option to level down a building-->
                <?php if ($building['can_lvldown']){ ?>  
                    <td class="centered_td"><button id='<?php echo "button_rm_".$building['id']; ?>' type='button' 
                                onclick='lvldown_building(<?php echo "\"".$building['name']."\", ".$building['type'].", ".$building['id'].", ".$building['level'].", ".PERC_DEMOLISH.", \"".$building['lvldown_str']."\" "; ?> )'>Reducir</button></td>
                <?php } else {?>
                    <td class="centered_td"><button id='<?php echo "button_rm_".$building['id']; ?>' type='button' disabled>Reducir</button></td>
                <?php } ?>
                    
                <!-- Direct access to the building -->
                <?php if ($building["direct_access"] != '') {?>
                    <td class="centered_td"><a href='<?php echo $building["direct_access"];?>'>Acceder</a></td>
                <?php } else { ?>
                    <td></td>
                <?php } ?>
                
            </tr>
            <?php 
            } ?>
            </tbody>
        </table>
                

        <div class="float-right mt-3 slightly_bigger_text">
            <b>Total coste de mantenimiento:</b>
            <?php foreach ($total_maintenance as $name => $info){ ?>
            <img src="../../../<?php echo ucfirst($info['icon']); ?>" alt="<?php echo ucfirst($name); ?>" title="<?php echo ucfirst($name); ?>" 
                 height="16px" width=16px">: <?php echo $info['quantity']; ?>
            <?php } ?>
        </div>
    </div>

    
<?php
    return ob_get_clean();
}

                



