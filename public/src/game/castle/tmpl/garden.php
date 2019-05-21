<?php 

$page_title = "Huerta";

$left_list_html = render_left_menu('castle');

$my_js_scripts = render_my_js_scripts();

# $content_html = '';
$content_html = render_content($gardens, $seeds);

require_once '../masterPage.php';

function render_my_js_scripts(){
    ob_start();
    ?>
        <!--Select2 script for select option with images -->
        <link href='../../select2-4.0.7/dist/css/select2.min.css' rel='stylesheet' type='text/css'>
        <script src='../../select2-4.0.7/dist/js/select2.min.js'></script>
        <script src='js/pretty_garden_plant.js'></script>
    
    <?php
    return ob_get_clean();
}

function render_content($gardens, $seeds){
    ob_start();
    ?>


        <div>

            <div class="row">
                <div class="col-12">
                    <table id="" class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                        <th class="centered_td" scope="col" colspan="6">Campos de cultivo</th>
                        </tr>
                        <tr>
                        <th></th>
                        <th class="centered_td" scope="col">Cultivo</th>
                        <th class="centered_td" scope="col">Estado</th>
                        <th class="centered_td" scope="col">Eficacia</th>
                        <th class="centered_td" scope="col">Fecha de recogida</th>
                        <th class="centered_td" scope="col">Recogido</th>
                        </tr>
                        </thead>

                        <?php foreach($gardens as $garden_id => $garden_info){?>
                        <tr>
                        <!-- Currently growing -->
                        <td class="centered_td"><?php echo $garden_info['img'] ?></td>
                        <!-- Select new seed -->
                        <td class="centered_td">
                            <select class="custom-select" id="garden_list">
                                <?php foreach($seeds as $seed_id => $seed_info){?>
                                <option  value="<?php echo $seed_id ?>" data-rich="<?php echo $seed_info['img'] ?>"><?php echo $seed_info['name'] ?> </option>
                                <?php } ?>
                            </select>
                            <br>
                            <button class="btn flatten_btn" id='<?php echo $garden_id ?>' type='button' onclick='plant_garden()'>Plantar</button>
                        </td>
                        <!-- Current mode -->
                        <td class="centered_td"> 
                            <?php echo $garden_info['mode'] ?>
                        </td>
                        <!-- Efficiency -->
                        <td class="centered_td">
                            <div class="progress">
                                
                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="<?php echo $garden_info['eff'] ?>"
                                    aria-valuemin="0" aria-valuemax="100" 
                                    style="width:<?php echo $garden_info['eff'] ?>%; display:inline-block">
                                    <?php echo $garden_info['eff']?>
                                </div>
                            </div>
                        
                        </td>
                        
                        <!-- Starting date -->
                        <td class="centered_td">
                            <?php if($garden_info['is_harvest_time']){ ?>
                                <p class="text-success">Recogiendo hasta <?php echo $garden_info['end'] ?></p>
                            <?php } else {?>
                                <p>La cosecha comienza el <?php echo $garden_info['start'] ?></p>
                            <?php } ?>
                        </td>
                        
                        <!-- Currently picked up -->
                        <td class="centered_td">
                            
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="20"
                                    aria-valuemin="0" aria-valuemax="100" 
                                    style="width:20%; display:inline-block">
                                    <?php echo "20%"?>
                                </div>
                            </div>
                        </td>
                        <tr>
                        <?php } ?>
                    </table>  
                </div>
                
            </div>

        </div>
    
    <?php
    return ob_get_clean(); 
}        

