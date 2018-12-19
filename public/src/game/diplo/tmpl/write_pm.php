<?php 

$page_title = "Escribir mensaje";

$my_js_scripts = render_my_js_scripts();

$left_list_html = render_left_menu('diplo');

$content_html = render_content($is_reply, $msg_sender, $list_usernames, $msg_title, $msg_body);

require_once '../masterPage.php';


function render_my_js_scripts(){
    ob_start();
    ?>
        <script src="js/dropdown_list.js"></script>
        <script src="js/treaty_flow_management.js"></script>
        <script src="js/send_msg_management.js"></script>
    <?php
    return ob_get_clean();
}

        
function render_content($is_reply, $msg_sender, $list_usernames, $msg_title, $msg_body){ 
    ob_start();
    ?>

        
        
        <div class="content_block">
            <div class="form-group form-inline">
                <!--Type of message-->
                <label class="mr-2" for="msg_type"><b> Tipo de mensaje: </b></label>
                <?php if($is_reply){ ?>
                    <select class="custom-select" id='msg_type' name='msg_type' readonly='readonly'>
                <?php } else{ ?>
                    <select class="custom-select" id='msg_type' name='msg_type'>
                <?php } ?>
                        <option value="message" selected="selected">Mensaje</option>
                        <option value="treaty">Acuerdo</option>
                    </select> <br>
            </div>


            <form action="index.php" onsubmit="return validate_msg()" method="post">
                <div class="form-group form-inline">
                    <!-- Receiver -->
                    <label class="mr-2" for="msg_beneficiary"> <b> Destinatario: </b></label>
                    <?php if ($is_reply && $msg_sender!=$_SESSION['username']){ ?>
                        <input class="custom-select" type='text' id='orm-msg_beneficiary' name='msg_beneficiary' list='users_datalist' value='$msg_sender'>
                    <?php } else { ?>
                        <input class="custom-select" type='text' id='msg_beneficiary' name='msg_beneficiary' id='msg_type' list='users_datalist'>
                    <?php } ?>

                    <datalist id="users_datalist">
                            <?php
                            foreach ($list_usernames as $my_username){ ?>
                                <option value='<?php echo $my_username; ?>'><?php echo $my_username; ?>
                            <?php } ?>
                    </datalist>
                </div>

        </div>
        <!-- Message content div -->
        <div class="content_block" id="msg_content" >
            
            <div class="form-group form-inline">
                <!--Type of message-->
                <label class="mr-2" for="msg_type"><b> Título: </b></label>
                <input class="form-control" type='text' id='msg_title' name='msg_title' value='<?php echo $msg_title; ?>'>
            </div>
            <div class="form-group">
                <label class="mr-2" for="msg_type"><b> Contenido: </b></label>
                <textarea class="form-control" id='msg_body' name='msg_body' rows='4' cols='50'><?php echo $msg_body; ?></textarea>
            </div>
        </div>
        
        <!-- Treaty content div -->
        <div class="content_block" id="treaty_content" hidden>
            <div id="I_offer">
                <h4> Ofrezco: </h4>
                <div class="offer_container">
                    <select id='offer_type_1' onchange="specify_deal('1', 'offer')">
                        <option value="no_option" selected="selected">--</option>
                       <option value="item">Materiales</option>
                       <option value="town">Propiedad de villa o pueblo</option>
                       <option value="resource">Propiedad de recurso</option>
                       <option value="other">Otro</option>
                    </select>
                    <span id="offer_container_2_1" >                                                                
                    </span>
                    <br>
                </div>

                <button type="button" id="I_offer_add_button" onclick="add_point('offer')">&#x2b;</button> <!--\u002B-->
            </div>

            <div id="I_demand">
                <h4> Demando: </h4> 
                <div class="demand_container" onchange="specify_deal('1', 'demand')">
                    <select id='demand_type_1'>
                       <option value="no_option" selected="selected">--</option>
                       <option value="item">Materiales</option>
                       <option value="town">Propiedad de villa o pueblo</option>
                       <option value="resource">Propiedad de recurso</option>
                       <option value="other">Otro</option>
                    </select>

                    <span id="demand_container_2_1" >
                    </span>
            
                </div>

                <button type="button" id="I_demand_add_button" onclick="add_point('demand')">&#x2b;</button>
            </div>
        </div>
        
        
        <div class="buttons_bar">
            <input type="Submit" id="send_button" value="Enviar">
        </div>
        
        </form>
            
            
    <?php
    return ob_get_clean();
}

