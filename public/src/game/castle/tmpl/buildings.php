<?php 

$page_title = "Edificios";

$my_js_scripts = render_my_js_scripts();

$left_list_html = render_left_menu('castle');

$content_html = render_content($occupied, $total_space, $buildings, $possible_buildings, $total_maintenance);

require_once '../masterPage.php';

function render_my_js_scripts(){
    ob_start();
    ?>
        <script src="js/lvlup_building.js"></script>
        <script src="js/lvldown_building.js"></script>
        <script src="js/build_building.js"></script>
    <?php
    return ob_get_clean();
}

    
function render_content($occupied, $total_space, $buildings, $possible_buildings, $total_maintenance){ 
    ob_start();
    ?>
    <div style="overflow: hidden "> <!-- We need this extra div to align right the last element without it getting out of the main content div -->
        <div class="float-right mb-3 slightly_bigger_text">
            <b>Espacio para edificios:</b> <?php echo $occupied."/".$total_space;?> <br>
        </div>
        
        <table class="table table-bordered table-hover table-striped">
            <thead>
            <tr>
                <th class="centered_td" scope="col">Edificio</td>
                <th class="centered_td" scope="col">Nivel</th>
                <th class="centered_td" scope="col">% Conservación</th>
                <th class="centered_td" scope="col">Siguiente nivel:</th>
                <th class="centered_td" scope="col">Reducir nivel:</th>
                <th class="centered_td" scope="col"></th>
                </tr>
            <thead>
            <tbody>
            <?php foreach ($buildings as $building){ ?>
            <tr>
                <!--Name-->
                <td class="centered_td"><?php echo $building['name']?></td>
                <!--Level-->
                <?php if ($building['under_construction']){ ?>
                    <td class="centered_td"><?php echo $building['level']; ?><br>(Ampliandose)</td>
                <?php } else {?>
                    <td class="centered_td"><?php echo $building['level']; ?><br></td>
                <?php } ?>

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
                <?php } else if($building['max_level']){?>
                    ¡Nivel máximo!
                <?php } else {?>
                    <!-- Lvlup resources -->
                    <span id='<?php echo "p_".$building['id'];?>' >
                    <?php foreach ($building['lvlup_array'] as $name => $info){ ?>
                        
                        <img src="../../../<?php echo ucfirst($info['icon']); ?>" alt="<?php echo ucfirst($name); ?>" title="<?php echo ucfirst($name); ?>" 
                         height="16px" width=16px">: <?php echo $info['quantity']; ?>
                        
                    <?php } ?>
                    </span>
                    <br>                    
                                        
                    <!--Lvlup button -->
                    <?php if ($building['can_lvlup']){ ?>  
                        <button class="btn flatten_btn" id='<?php echo "button_".$building['id']; ?>' type='button' onclick='lvlup_building(<?php echo $building['id'].",".$building['type'].",".$building['level']; ?>)'>&#8679; Mejorar</button>
                    <?php } else {?>
                        <button class="btn flatten_btn" id='<?php echo "button_".$building['id']; ?>' type='button' value='".$building_id."' disabled>&#8679; Mejorar</button>
                    <?php } ?>
                    

                    
                <?php } ?>
                </td>
                <!--Option to level down a building-->
                <?php if ($building['can_lvldown']){ ?>  
                    <td class="centered_td"><button class="btn login_btn" id='<?php echo "button_rm_".$building['id']; ?>' type='button' 
                                onclick='lvldown_building(<?php echo "\"".$building['name']."\", ".$building['type'].", ".$building['id'].", ".$building['level'].", ".PERC_DEMOLISH.", \"".$building['lvldown_str']."\" "; ?> )'>&#8681; Reducir</button></td>
                <?php } else {?>
                    <td class="centered_td"><button class="btn login_btn" id='<?php echo "button_rm_".$building['id']; ?>' type='button' disabled>&#8681; Reducir</button></td>
                <?php } ?>
                    
                <!-- Direct access to the building -->
                <?php if ($building["direct_access"] != '') {?>
                    <td class="centered_td">
                        
                        <button class="btn login_btn" id='<?php echo "button_rm_".$building['id']; ?>' type='button' onclick="window.location.href = '<?php echo $building["direct_access"];?>';">Acceder &#8680;</button>
                        
                <?php } else { ?>
                    <td></td>
                <?php } ?>
                
            </tr>
            <?php 
            } ?>
            </tbody>
        </table>
                

        <div class="row">
            <div class="col-3 col-md-8"></div>
            <div class="col-9 col-md-4 float-right slightly_bigger_text">
                <b>Total coste de mantenimiento:</b>
                <?php if(!empty($total_maintenance)){
                    foreach ($total_maintenance as $name => $info){ ?>
                        <img src="../../../<?php echo ucfirst($info['icon']); ?>" alt="<?php echo ucfirst($name); ?>" title="<?php echo ucfirst($name); ?>" 
                            height="16px" width=16px">: <?php echo $info['quantity']; ?>
                    <?php } 
                } else { ?>
                        Ninguno
                <?php } ?>
            </div>
        </div>
        
        
        <div class="content_block">
            <h2>Edificios sin construir</h2>

                    <table class="table table-bordered table-hover table-striped">
            <thead>
            <tr>
                <th class="centered_td" scope="col">Edificio</th>
                <th class="centered_td" scope="col">Conste de construcción:</th>
                <th class="centered_td" scope="col"></th>
                </tr>
            <thead>
            <tbody>
            <?php foreach ($possible_buildings as $building){ ?>
            <tr>
                <!--Name-->
                <td class="centered_td"><?php echo $building['name']?></td>
                <!-- Building cost-->
                <td class="centered_td">

                    <p id='<?php echo "p_".$building['type'];?>' >
                    <?php foreach ($building['lvlup_array'] as $name => $info){ ?>
                      
                        <img src="../../../<?php echo ucfirst($info['icon']); ?>" alt="<?php echo ucfirst($name); ?>" title="<?php echo ucfirst($name); ?>" 
                         height="16px" width=16px">: <?php echo $info['quantity']; ?>
                    <?php } ?>
                    </p>
                </td>
                    
                <!-- Building button -->
                <td class="centered_td">
                <?php if ($building['can_lvlup']){ ?>  
                    <button class="btn flatten_btn" id='<?php echo "button_".$building['type']; ?>' type='button' onclick='build_building(<?php echo $building['type']; ?>)'>&#8679; Construir</button>
                <?php } else {?>
                    <button class="btn flatten_btn" id='<?php echo "button_".$building['type']; ?>' type='button' value='".$building_id."' disabled>&#8679; Construir</button>
                <?php } ?>
                </td>
            </tr>
            <?php 
            } ?>
            </tbody>

        </div>
        
        
        
    </div>

    
<?php
    return ob_get_clean();
}

                



