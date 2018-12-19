<?php 

if($is_get){
  $page_title = $town_name;
} else {
  $page_title = "Mis villas y aldeas";
  $my_js_scripts = render_my_js_scripts();
}

$left_list_html = render_left_menu('fief');

if($is_get){
    $content_html = render_content($is_get, $town_name);
} else {
    $content_html = render_content($is_get, "", $towns_complete_names);
}

require_once '../masterPage.php';

function render_my_js_scripts(){
    ob_start();
    ?>
        <script src="js/towns.js"></script>

    <?php
    return ob_get_clean();
}

function render_content($is_get, $town_name="", $towns_complete_names=""){ 
    ob_start();
    
    if($is_get){ ?>
         <h4><?php echo $town_name; ?></h4>
    <?php } else { ?>
         
        <div class="form-inline">
            <label class="mr-2 slightly_bigger_text" for="resource_list">Población:</label>
            <select class="custom-select" id="town_list">
            <?php foreach($towns_complete_names as $town_id => $town_name) { ?>
                <option value="<?= $town_id ?>"><?php echo $town_name ?></option>
            <?php } ?>
            </select>
            <input type="button" class="btn ml-2" id="load_new_town" value="Cargar" onclick="load_town()" />
            <br>
        </div>
    <?php } ?>
         
    <div id="town_info">
        <?php if($is_get){ 
            require 'php/load_town.php';
        } else { ?>
            <script>
                load_town();
            </script>
        <?php } ?>
    </div>

         
         

    <?php
    return ob_get_clean();
}

