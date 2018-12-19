<?php 

$page_title = "Mensajes recibidos";

$my_js_scripts = render_my_js_scripts();

$left_list_html = render_left_menu('diplo');

$content_html = render_content($messages);

require_once '../masterPage.php';


function render_my_js_scripts(){
    ob_start();
    ?>
        <script src="js/sent_msg_management.js"></script>
    <?php
    return ob_get_clean();
}

function render_content($messages){ 
    ob_start();
    ?>
        <h3>Mensajes enviados</h3>
        <table class="table table-hover">
            <tr>
                <th class="title_cell">Título</th>
                <th>Receptor</th>
                <th>Fecha del mensaje</th>
                <th></th>
            </tr>
            
            <?php if (empty($messages)) { ?>
                <tr>
                <td colspan='4' class='center'>¡Tu bandeja de salida está vacía!</td>
                </tr>
            <?php } else { 
                foreach ($messages as $msg){?>
                
                    <tr id='<?php echo $msg['id']."_row" ?>'>
                    <td class='left'><a href='read_pm.php?id=<?php echo $msg['id']; ?>'><?php echo $msg['title']; ?></a></td>
                    <td> <?php echo $msg['receiver_name'];?> </td>
                    <td> <?php echo $msg['timestamp'];?></td>
                    <td><input type='checkbox' name=<?php echo $msg['id'];?> value='<?php echo $msg['id']; ?>'></td>
                    </tr>
            
                <?php }?>
            <?php }?>
   
        </table>
        
        <div class="buttons_bar">
            <button type="button" onclick="window.location='write_pm.php';">Nuevo mensaje</button> 
            <button type="button" onclick='rm_msg()'>Borrar</button>
            <br />
        </div>
        
    <?php
    return ob_get_clean();
}        
          