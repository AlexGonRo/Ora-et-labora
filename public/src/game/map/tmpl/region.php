<?php 
$page_title = "Región: ".$region_name;

$left_list_html = render_left_menu('map');

$content_html = render_content($region_name, $region_owner_id, $region_owner_name, 
        $region_kingdom_id, $region_kingdom_name, $region_terrain, $users, 
        $towns, $resources);

require_once '../masterPage.php';

function render_content($region_name, $region_owner_id, $region_owner_name, 
        $region_kingdom_id, $region_kingdom_name, $region_terrain, $users, 
        $towns, $resources){
    ob_start();
    ?>
    <div class="content_block">
        <h2>Información general</h2>
        <div class="row">
            <div class="col-md-5 center">
                <img src="https://via.placeholder.com/256" alt="Something should go here..."> 
            </div>
            <div class="col-md-7">
                <p><b>Región:</b> <?php echo $region_name; ?></a></p>
                <p><b>Dueño y señor:</b> <a href="../profile/profile.php?username=<?php echo $region_owner_name; ?>"><?php echo $region_owner_name; ?></a></p>
                <p><b>Terreno:</b> <?php echo $region_terrain; ?></a></p>
                <p><b>Reino:</b> <a href="kingdom.php?id=<?php echo $region_kingdom_id; ?>"><?php echo $region_kingdom_name ?></a></p>
                <p><b>Otros personajes asentados aquí:</b></p>
                <div class="indent_block">
                    <?php
                    foreach($users as $user_info){ ?>
                        <a href="../profile/profile.php?username=<?php echo $user_info['username'] ?>"> &#10014; <?php echo $user_info['username']; ?></a> (Tiene <?php echo $user_info['num_props'];?> propiedades)<br>
                    <?php }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="content_block">
        <h2>Villas</h2>
        <div class="indent_block">
            <?php
            foreach($towns as $town_info){ ?>
                <a href="../fief/towns.php?id=<?php echo $town_info['id']; ?>"> &#10014; <?php echo $town_info['name']; ?></a> (Población <?php echo $town_info['pop'];?>)<br>
            <?php }
            ?>
        </div>
    </div>

    <div class="content_block">
        <h2>Recursos</h2>
        <div class="indent_block">
            <?php
            foreach($resources as $res_info){ ?>
                <a href="../fief/towns.php?id=<?php echo $res_info['id']; ?>"> &#10014; <?php echo $res_info['name']; ?></a><br>
            <?php }
            ?>
        </div>
    </div>

    <?php
    return ob_get_clean(); 
}

