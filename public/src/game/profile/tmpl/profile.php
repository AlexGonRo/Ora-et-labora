<?php 

$page_title = "Configuración";

$my_js_scripts = render_my_js_scripts();

$left_list_html = render_left_menu('profile');

$content_html = render_content($my_username, $char_name, $char_location, $char_location_id, 
        $not_me, $my_id, $my_role, $my_fame, $my_kingdom_name, $my_kingdom_id, $towns, 
        $resources);

require_once '../masterPage.php';


function render_my_js_scripts(){
    ob_start();
    ?>
        <script>
            function redirect_to_message(id){
                window.location.replace("../diplo/new_pm.php?id="+id);
            }    
        </script>
    <?php
    return ob_get_clean();
}

function render_content($my_username, $char_name, $char_location, $char_location_id,  
        $not_me, $my_id, $my_role, $my_fame, $my_kingdom_name, $my_kingdom_id, $towns, 
        $resources){
    ob_start();
    ?>
     
    <div class="content_block">
        <h2>Información general</h2>

        <b>Apellido familiar:</b> <?php echo $my_username;?><br />
        <b>Miembro principal:</b> <?php echo $char_name;?><br />
        <b>Ubicación actual:</b> <?php if($not_me) {?>
            Desconocida
        <?php } else { ?>
            <a href="<?php echo BASE_URL; ?>src/game/map/region.php?id=<?php echo $char_location_id;?>">
                <?php echo $char_location;?>
            </a><br />
        <?php }?>
        <b>Rol:</b> <?php if($my_role=='0'){echo "Civil";} else {echo "Religioso";}?><br />
        <b>Fama:</b> <?php echo $my_fame;?><br />
        <b>Reino:</b>
        <a href="<?php echo BASE_URL; ?>src/game/map/kingdom.php?id=<?php echo $my_kingdom_id;?>">
                <?php echo $my_kingdom_name;?>
            </a><br />

        <?php
        if ($not_me){
            ?>
            <button type='button' class="btn" onclick='redirect_to_message(<?php echo $my_id; ?>)'>Enviar mensaje</button>
            <?php
        }
        ?>
    </div>
    <div class="content_block">
            <h2>Posesiones</h2>
                <b>Villas y aldeas:</b><br />
                <div class="indent_block">
                <?php
                foreach ($towns as $town){
                    if($town['type']==0){ ?>
                        <a href="<?php echo BASE_URL; ?>src/game/fief/towns.php?id=<?php echo $town['id'];?>">
                            &#10014; Pueblo de <?php echo $town['name'];?>, 
                            en <?php echo $town['region_name'];?>
                            (Población: <?php echo $town['pop'];?>)</a><br />
                    <?php } else { ?>
                        <a href="<?php echo BASE_URL; ?>src/game/fief/towns.php?id=<?php echo $town['id'];?>">
                            &#10014; Villa de <?php echo $town['name'];?>, 
                            en <?php echo $town['region_name'];?>
                            (Población: <?php echo $town['pop'];?>)</a><br />
                    <?php }
                } ?>
                </div>
                <b>Recursos:</b> <br />
                
                <div class="indent_block">
                <?php
                foreach ($resources as $resource){
                ?>
                    <a href="<?php echo BASE_URL; ?>src/game/fief/land.php?id=<?php echo $resource['resource_id'];?>">
                        &#10014; <?php echo $resource['resource_name'];?> 
                    en <?php echo $resource['region_name'];?> </a><br />
                <?php } ?>
                </div>
                
        </div>
        <div class="content_block">
            <h2>Relaciones de Vasallaje</h2>
            Sirve a: <br />
            Vasallos directos: <br />    
        </div>
    <?php
    return ob_get_clean(); 
}


           