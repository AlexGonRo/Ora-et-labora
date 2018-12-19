<?php 

if($is_get){
  $page_title = $res_complete_name;
} else {
  $page_title = "Mis tierras";
  $my_js_scripts = render_my_js_scripts();
}

$left_list_html = render_left_menu('fief');

if($is_get){
    $content_html = render_content($is_get, $res_complete_name);
} else {
    $content_html = render_content($is_get, "", $res_complete_names);
}
require_once '../masterPage.php';

function render_my_js_scripts(){
    ob_start();
    ?>
    <script src="js/land.js"></script>
    <?php
    return ob_get_clean();
}

function render_content($is_get, $res_complete_name="", $res_complete_names=""){ 
    ob_start();
    ?>
        <?php if(!$is_get){ ?>
        <div class="form-inline">
            <label class="mr-2 slightly_bigger_text" for="resource_list">Recurso:</label>
            <select class="custom-select" id="resource_list">
            <?php foreach($res_complete_names as $res_id => $res_name) { ?>
                <option value="<?= $res_id ?>"><?php echo $res_name ?></option>
            <?php } ?>
            </select>
            <input type="button" class="btn ml-2" id="load_new_resource" value="Cargar" onclick="load_resource()" />
            <br>
        </div>
        <?php } else { ?>
            <h4><?php echo $res_complete_name;?></h4>
        <?php }?>
        
        
        <div id="resource_info">
            <?php if($is_get){ 
                require 'php/load_resource.php';
            } else { ?>
                <script>
                    load_resource();
                </script>
            <?php } ?>
        </div>
    
    <?php
    return ob_get_clean();
}



    