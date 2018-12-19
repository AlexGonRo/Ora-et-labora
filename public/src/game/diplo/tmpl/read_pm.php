<?php 
$page_title = "Mensaje ".$msg_title;

$left_list_html = render_left_menu('diplo');

$alerts_html = render_alerts($my_error);

$content_html = render_content($msg_id, $msg_title, $msg_sender_id, $msg_sender_name, $msg_text, $my_error);

require_once '../masterPage.php';

function render_alerts($my_error){
    ob_start();
    ?>
        <?php if ($my_error){ ?>
            <div class="alert alert-Danger alert-dismissible fade show">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <p>No pudimos mostrar el mensaje.</p>
            </div>
        <?php } ?>

    <?php
    return ob_get_clean();
}

function render_content($msg_id, $msg_title, $msg_sender_id, $msg_sender_name, $msg_text, $my_error){ 
    ob_start();
    ?>
        <?php if(!$my_error){?>
        <div class="content_block"> 
            <h4><b>Título:</b> <?php echo $msg_title; ?></h4>
            <b>De:</b> <?php echo $msg_sender_name; ?> <br>
        </div>

        <div id='msg_text_div'>
            <?php echo $msg_text; ?>
        </div>
            <br>

            <?php if ($msg_sender_id == $_SESSION['user_id']){ ?>
                <div class="buttons_bar">
                    <button type="button" disabled>Responder</button> 
                </div>
            <?php
            } else {
            ?>
                <div class="buttons_bar">
                    <button type="button" onclick="window.location='write_pm.php?id=<?php echo  $msg_id?>';">Responder</button> 
                </div>
            <?php } ?>
        <?php } ?>

    <?php
    return ob_get_clean();
}

