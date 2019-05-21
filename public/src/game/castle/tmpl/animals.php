<?php 

$page_title = "Animales";

$left_list_html = render_left_menu('castle');

$my_js_scripts = render_my_js_scripts();

# $content_html = '';
$content_html = render_content($user_stable_id, $animal_food, $animal_food_img, $animals, $unassigned_space);

require_once '../masterPage.php';

function render_my_js_scripts(){
    ob_start();
    ?>
    <!--Script to -->    
    <script src="js/stable_ranges.js"></script>
    <script src="js/update_stable.js"></script>
    
    <?php
    return ob_get_clean();
}

function render_content($user_stable_id, $animal_food, $animal_food_img, $animals, $unassigned_space){
    ob_start();
    ?>

    
    <div class="row">
        <div class="col-md-9 vertical_separator">

            <div>
                <h3>Estado actual de la granja:</h3>
                <span class="float-right"><b>Comida disponible: </b> 
                    <?php echo $animal_food; ?> 
                    <img src="../../../<?php echo $animal_food_img;?>" alt="Materiales" title="Materiales" 
                        height="16px" width=16px">
                </span>
                <br>
                <br>
                <div class="progress">
                    <div class="progress-bar bg_chicken" role="progressbar" 
                         style="width: <?php echo $animals[CHICKEN_ID]['cur_perc']; ?>%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                    <div class="progress-bar bg_goose" role="progressbar" 
                         style="width: <?php echo $animals[GOOSE_ID]['cur_perc']; ?>%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                    <div class="progress-bar bg_sheep" role="progressbar" 
                         style="width: <?php echo $animals[SHEEP_ID]['cur_perc']; ?>%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                    <div class="progress-bar bg_pig" role="progressbar" 
                         style="width: <?php echo $animals[PIG_ID]['cur_perc']; ?>%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                    <div class="progress-bar bg_cow" role="progressbar" 
                         style="width: <?php echo $animals[COW_ID]['cur_perc']; ?>%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                    <div class="progress-bar bg_horse" role="progressbar" 
                         style="width: <?php echo $animals[HORSE_ID]['cur_perc']; ?>%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <br>
                <div class="d-flex justify-content-around">
                    
                    <span>
                        <span class="square bg_chicken"></span>
                        <img src="../../../img/icons/animals/chicken.png" style="vertical-align: top;" alt="Materiales" title="Materiales" height="24px" width=24px">
                    </span>
                    
                    <span>
                        <span class="square bg_goose"></span>
                        <img src="../../../img/icons/animals/duck.png" style="vertical-align: top;" alt="Materiales" title="Materiales" height="24px" width=24px">
                    </span>
                    
                    <span>
                        <span class="square bg_sheep"></span>
                        <img src="../../../img/icons/animals/sheep.png" style="vertical-align: top;" alt="Materiales" title="Materiales" height="24px" width=24px">
                    </span>
                    
                    <span>
                        <span class="square bg_pig"></span>
                        <img src="../../../img/icons/animals/pig.png" style="vertical-align: top;" alt="Materiales" title="Materiales" height="24px" width=24px">
                    </span>
                    
                    <span>
                        <span class="square bg_cow"></span>
                        <img src="../../../img/icons/animals/cow.png" style="vertical-align: top;" alt="Materiales" title="Materiales" height="24px" width=24px">
                    </span>
                    
                    <span>
                        <span class="square bg_horse"></span>
                        <img src="../../../img/icons/animals/horse.png" style="vertical-align: top;" alt="Materiales" title="Materiales" height="24px" width=24px">
                    </span>
                </div>
                

                
                <!--Chicken-->
                <br>
                <h3>Porcentaje deseado de animales</h3>
                <!-- TODO - I CAN PROBABLY PUT THIS INSIDE A LOOP-->
                <div>
                Gallinas <img src="../../../img/icons/animals/chicken.png" style="vertical-align: baseline;" alt="Materiales" title="Materiales" height="24px" width=24px">
                    <div class="row m-3">
                        <div class="col-9 col-md-9 col-lg-10 col-xl-10">
                            <input type="range" class="custom-range w-100 align-middle" min="0" max="100" step="1" id="chicken_range" value="<?php echo $animals[CHICKEN_ID]['max_perc']?>" onchange="update_on_range('chicken_range','chicken_input')">
                        </div>

                        <div class="col-3 col-md-3 col-lg-2 col-xl-2">
                            <input id="chicken_input" type="text" class="form-control" value="<?php echo $animals[CHICKEN_ID]['max_perc']?>%" onchange="update_input('chicken_range','chicken_input')">
                        </div>
                    </div>
                </div>
                <!-- Goose -->
                <div>
                    Gansos <img src="../../../img/icons/animals/duck.png" style="vertical-align: baseline;" alt="Materiales" title="Materiales" height="24px" width=24px">
                    <div class="row m-3">
                        <div class="col-9 col-md-9 col-lg-10 col-xl-10">
                            <input type="range" class="custom-range w-100 align-middle" min="0" max="100" step="1" id="goose_range" value="<?php echo $animals[GOOSE_ID]['max_perc']?>" onchange="update_on_range('goose_range','goose_input')">
                        </div>

                        <div class="col-3 col-md-3 col-lg-2 col-xl-2">
                            <input id="goose_input" type="text" class="form-control" value="<?php echo $animals[GOOSE_ID]['max_perc']?>%" onchange="update_input('goose_range','goose_input')">
                        </div>
                    </div>
                </div>
                <!-- Sheep -->
                <div>
                    Ovejas <img src="../../../img/icons/animals/sheep.png" style="vertical-align: baseline;" alt="Materiales" title="Materiales" height="24px" width=24px">
                    <div class="row m-3">
                        <div class="col-9 col-md-9 col-lg-10 col-xl-10">
                            <input type="range" class="custom-range w-100 align-middle" min="0" max="100" step="1" id="sheep_range" value="<?php echo $animals[SHEEP_ID]['max_perc']?>" onchange="update_on_range('sheep_range','sheep_input')">
                        </div>

                        <div class="col-3 col-md-3 col-lg-2 col-xl-2">
                            <input id="sheep_input" type="text" class="form-control" value="<?php echo $animals[SHEEP_ID]['max_perc']?>%" onchange="update_input('sheep_range','sheep_input')">
                        </div>
                    </div>
                </div>
                <!--Pig -->
                <div>
                    Cerdos <img src="../../../img/icons/animals/pig.png" style="vertical-align: baseline;" alt="Materiales" title="Materiales" height="24px" width=24px">
                    <div class="row m-3">
                        <div class="col-9 col-md-9 col-lg-10 col-xl-10">
                            <input type="range" class="custom-range w-100 align-middle" min="0" max="100" step="1" id="pig_range" value="<?php echo $animals[PIG_ID]['max_perc']?>" onchange="update_on_range('pig_range','pig_input')">
                        </div>

                        <div class="col-3 col-md-3 col-lg-2 col-xl-2">
                            <input id="pig_input" type="text" class="form-control" value="<?php echo $animals[PIG_ID]['max_perc']?>%" onchange="update_input('pig_range','pig_input')">
                        </div>
                    </div>
                </div>
                <!--Cow -->
                <div>
                    Vacas <img src="../../../img/icons/animals/cow.png" style="vertical-align: baseline;" alt="Materiales" title="Materiales" height="24px" width=24px">
                    <div class="row m-3">
                        <div class="col-9 col-md-9 col-lg-10 col-xl-10">
                            <input type="range" class="custom-range w-100 align-middle" min="0" max="100" step="1" id="cow_range" value="<?php echo $animals[COW_ID]['max_perc']?>" onchange="update_on_range('cow_range','cow_input')">
                        </div>

                        <div class="col-3 col-md-3 col-lg-2 col-xl-2">
                            <input id="cow_input" type="text" class="form-control" value="<?php echo $animals[COW_ID]['max_perc']?>%" onchange="update_input('cow_range','cow_input')">
                        </div>
                    </div>
                </div>
                <!--Horse -->
                <div>
                    Caballos <img src="../../../img/icons/animals/horse.png" style="vertical-align: baseline;" alt="Materiales" title="Materiales" height="24px" width=24px">
                    <div class="row m-3">
                        <div class="col-9 col-md-9 col-lg-10 col-xl-10">
                            <input type="range" class="custom-range w-100 align-middle" min="0" max="100" step="1" id="horse_range" value="<?php echo $animals[HORSE_ID]['max_perc']?>" onchange="update_on_range('horse_range','horse_input')">
                        </div>

                        <div class="col-3 col-md-3 col-lg-2 col-xl-2">
                            <input id="horse_input" type="text" class="form-control" value="<?php echo $animals[HORSE_ID]['max_perc']?>%" onchange="update_input('horse_range','horse_input')">
                        </div>
                    </div>
                </div>
                <!--Unoccupied space -->
                Espacio sin asignar: <span id="unassigned_space"><?php echo $unassigned_space;?></span>%
                
            </div>

            <div class="text-right">
                <button type="button" onclick="update_stable(<?php echo $user_stable_id;?>)" class="btn btn-primary">Actualizar proporción</button>
            </div>
        </div>


        <div class="col-md-3 col-md-offset-2">
            <span class="small_header">Producción en el último ciclo</span><br>

            <div class="row mt-3">
                <div class="col-12">
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
                        <td class="right_td">  </td>
                        <td class="centered_td">  </td>
                        <tr>
                    </table>  
                </div>
                
            </div>

        </div>
    
    <?php
    return ob_get_clean(); 
}        

