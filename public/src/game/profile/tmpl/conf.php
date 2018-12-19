<?php 

$page_title = "Configuración";

$my_js_scripts = render_my_js_scripts();

$alerts_html = render_alerts($is_post, $username_errors, $email_errors, $pass_errors, $match_old_pass);

$left_list_html = render_left_menu('profile');

$content_html = render_content($username, $email);

require_once '../masterPage.php';

function render_my_js_scripts(){
    ob_start();
    ?>
        <script src="js/delete_account.js"></script>
        <script src="js/go_on_vacation.js"></script>
    <?php
    return ob_get_clean();
}

function render_alerts($is_post, $username_errors, $email_errors, $pass_errors, $match_old_pass){
    ob_start();
    
    if (!$is_post){  # If this wasn't a POST call it won't have any alerts on screen
        return;
    }
    
    if (empty($username_errors) && empty($email_errors) && empty($pass_errors) &&
            $match_old_pass) {    
        # No errors? Everything went perfectly!
        ?>
        <div class="alert alert-success alert-dismissible fade show">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <p>La información de ha modificado con éxito.</p>
         </div> 
        <?php
    }
    if (!empty($username_errors)){
        ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php
                foreach($username_errors as $error){
                    echo $error;
                }
            ?>
        </div> 
        <?php
    }
    
    if (!empty($email_errors)){
        ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php
                foreach($email_errors as $error){
                    echo $error;
                }
            ?>
        </div> 
        <?php
    }
    
    if (!empty($pass_errors)){
        ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php
                foreach($pass_errors as $error){
                    echo $error;
                }
            ?>
        </div> 
        <?php
    }
    if (!$match_old_pass){ # Input password does not match the one we have stored
        ?> 
                <div class="alert alert-danger alert-dismissible fade show">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <p>Tu antigua contraseña no coincide con la proporcionada. No se realizaron cambios</p>
                 </div>    

        <?php
    }

    return ob_get_clean(); 
}


function render_content($username, $email){
    ob_start();
    ?>
        <form action="conf.php" method="post">
            <div class="first_content_block">
                    <span class="descriptive_text">
                    Modifica cualquiera de los parámetros de tu cuenta y pulsa "Actualizar información":<br />
                    </span>
                    <div class="indent_block form-group row">
                        <label class="col-md-3" for="username">&#10014; Nombre de la familia: </label><input type="text" name="username" class="form-control form-control-sm col-md-3" id="username" placeholder="<?php echo $username; ?>" /><br />
                    </div>
                    <div class="indent_block form-group row">
                        <label class="col-md-3" for="email">&#10014; Email: </label><input type="email" name="email" class="form-control form-control-sm col-md-3" id="email" placeholder="<?php echo $email; ?>" /><br />
                    </div>
                    <div class="indent_block form-group row">
                        <label class="col-md-3" for="password">&#10014; Nueva contraseña: </span></label><input type="password" name="password" class="form-control form-control-sm col-md-3" id="password" placeholder='******' /><br />
                    </div>
                    <div class="indent_block form-group row">
                        <label class="col-md-3" for="passverif">&#10014; Repita nueva contraseña: </label><input type="password" name="passverif" class="form-control form-control-sm col-md-3" id="passverif" placeholder='******' /><br />
                    </div>
            </div>
            <div class="content_block">
                <span class="descriptive_text">
                    Para hacer efectivo cualquier cambio, por favor, repite tu antigua (o actual) contraseña: <br />
                </span>
                <div class="indent_block form-group row">
                    <label class="col-md-3" for="old_pass">&#10014; Antigua contraseña: </label><input type="password" name="old_pass" class="form-control form-control-sm col-md-3" id="old_pass" placeholder='******' /><br />
                </div>
            </div>
            <div class="content_block center">
                <input type="submit" value="Actualizar información" />
            </div>
        </form>

        <div class="content_block">
            <span class="descriptive_text">
                    También puedes recurrir a alguna de las siguientes opciones (necesitarás introducir tu contraseña): <br />
            </span>
            <div class="center">
                <input type="submit" onclick="delete_account()" value="Quiero borrar mi cuenta" />
                <input type="submit" onclick="go_on_vacation()" value="Quiero unas vacaciones" />
            </div>
        </div>
    <?php
    return ob_get_clean(); 
}


            
