<?php 

$page_title = "Mi castillo";

$my_js_scripts = render_my_js_scripts();

$left_list_html = render_left_menu('castle');

$content_html = render_content();

require_once '../masterPage.php';

function render_my_js_scripts(){
    ob_start();
    return ob_get_clean();
}


    
function render_content(){ 
    ob_start();
    ?>

<?php
    return ob_get_clean();
}

                



