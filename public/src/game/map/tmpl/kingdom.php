<?php 
$page_title = "Reinos: ".$kingdom_name;

$left_list_html = render_left_menu('map');

$content_html = render_content($kingdom_name, $regions);

require_once '../masterPage.php';

function render_content($kingdom_name, $regions){
    ob_start();
    ?>
    <div class="content_block">
        <h2>Información general</h2>
        <div class="row">
            <div class="col-md-5 center">
                <img src="https://via.placeholder.com/256" alt="Something should go here..."> 
            </div>
            <div class="col-md-7">
                <p><b>Reino</b>: <?php echo $kingdom_name ?></p>
                <p><b>Rey</b>: TODO </p>
            </div>
        </div>
    </div>
        
    <div class="content_block">
        <h2>Dominios</h2>
        <b>Regiones:</b><br />
        <div class="indent_block">
            <?php
            foreach($regions as $region){ ?>
                <a href="region.php?id=<?php echo $region['id']; ?>">&#10014; <?php echo $region['name']; ?></a><br>
            <?php } ?>
        </div>
        <b>Otras villas o aldead:</b><br />
        <div class="indent_block"></div>
    </div>


    <?php
    return ob_get_clean(); 
}
