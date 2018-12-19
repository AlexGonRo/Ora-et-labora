<?php 

$page_title = "Mensajes recibidos";

$my_js_scripts = render_my_js_scripts();

$alerts_html = render_alerts($sent_message, $msg_error);

$left_list_html = render_left_menu('diplo');

$content_html = render_content($messages);

require_once '../masterPage.php';


function render_my_js_scripts(){
    ob_start();
    ?>
        <script src="js/index_msg_management.js"></script>
    <?php
    return ob_get_clean();
}

function render_alerts($sent_message, $msg_error){
    ob_start();
    ?>
        <?php if ($sent_message){   # If we just sent a message
            if ($msg_error){ ?>
            <div class="alert alert-Danger alert-dismissible fade show">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <p>Hubo un error al enviar el mensaje. Por favor, intentalo de nuevo.</p>
            </div>
        <?php } else { ?>
            <div class="alert alert-success alert-dismissible fade show">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <p>Mensaje enviado con éxito. </p>
            </div>
        <?php
            }
        }
        ?>
    <?php
    return ob_get_clean();
}
        
function render_content($messages){ 
    ob_start();
    ?>
        <h3>Mensajes</h3>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="title_cell">Título</th>
                    <th>De</th>
                    <th>Fecha del mensaje</th>
                    <th></th>
                </tr>
            </thead>
            <?php if (empty($messages)) { ?>
                <tr>
                    <td colspan="4" class='centered_td'>¡Tu bandeja de entrada está vacía!</td>
                </tr>
            <?php } else { 
                foreach ($messages as $msg){?>
                
                    <?php if (!$msg['is_read']){ ?>
                        <tr id='<?php echo $msg['id']."_row" ?>' class='bold_row'>
                    <?php } else { ?>
                        <tr id='<?php echo $msg['id']."_row" ?>'>
                    <?php } ?>
                    <td class='left'><a href='read_pm.php?id=<?php echo $msg['id']; ?>'><?php echo $msg['title']; ?></a></td>
                    <td> <?php echo $msg['sender_name'];?> </td>
                    <td> <?php echo $msg['timestamp'];?></td>
                    <td><input type='checkbox' name=<?php echo $msg['id'];?> value='<?php echo $msg['id']; ?>'></td>
                    </tr>
            
                <?php }?>
            <?php }?>

        </table>
        
        <div class="buttons_bar">
            <button type="button" onclick="window.location='write_pm.php';">Nuevo mensaje</button> 
            <button type="button" onclick='mark_as_read()'>Marcar como leido</button>
            <button type="button" onclick='mark_as_unread()'>Marcar como no leido</button>
            <button type="button" onclick='rm_msg()'>Borrar</button>
            <br />
        </div>
        
    <?php
    return ob_get_clean();
}

                        

