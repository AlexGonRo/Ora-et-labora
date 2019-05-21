<?php 

$page_title = "Ora et Labora - Registro";

$page_meta = render_metainfo();

$my_js_scripts = render_my_js_scripts();

$content_html = render_content($registration_errors, $default_char_name, 
        $default_family_name, $default_role, $default_property_name, $default_email);

require_once 'masterPage_front.php';

function render_metainfo(){
    ob_start();
    ?>
        <meta name="description" content="Ya estás un paso más cerca de tener una cuenta en Ora et Labora, el juego de navegador gratuito. ¡Personaliza tu dinastía y preparate para juegar!">
    <?php
    return ob_get_clean();
}

function render_my_js_scripts(){
    ob_start();
    ?>
        <script src="js/mail_prot.js"></script>
        <script src="js/register_validation.js"></script>
        <script src="js/display_info.js"></script>
    <?php
    return ob_get_clean();
}

function render_content($registration_errors, $default_char_name, 
        $default_family_name, $default_role, $default_property_name, $default_email){
    ob_start();
    ?>
        
    <div class="container">
        
      <div class="py-5 text-center">    <!--py-* class for padding top and bottom -->
        <h2>Formulario de registro</h2>
        <p class="lead">Antes de comenzar a jugar necesitas rellenar un pequeño 
        formulario acerca de tu personaje.</p>
      </div>

        <!-- Error panel for invalid submissions-->
        <?php if(isset($registration_errors) && $registration_errors!=""){ ?>
        <div class="row">
            <div id="error_message" class="col-md-12 bg-warning mb-2 p-2">
                <?php echo $registration_errors; ?>
            </div>
        </div>
        <?php } ?>
      <div class="row p-4 my_box_shadow" id="main_register_div">
        <!--Lateral helping panel-->
        <div class="col-md-5 order-md-2 mb-4 ">
            <div class="m-md-5 p-md-4 p-2 my_box_shadow" id="register_helping_box">
              <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Descripción</span>
              </h4>
              <hr class="mb-4"> 
              <span id="descriptive_text">
                  Pulsa el botón <a class="info_button" href="#">&nbsp;?&nbsp;</a> para ver aquí más información.
              </span>
              
              
           </div>
        </div>
        <!--End lateral helping panel-->
        
        <!-- Main form -->
        <div class="col-md-7 order-md-1">
          <h4 class="mb-4">Información del tu personaje</h4>
          <form class="needs-validation" id="registration_form" method="post" action="register.php" novalidate>
              
            <div class="row">
            
                <div class="col-md-6 mb-3 align-self-center text-center">
                    <label for="family_name"><b>Apellido familiar (Nombre de usuario) <a class="info_button" href="#" onClick="javascript:display_info(event, 1)">&nbsp;?&nbsp;</a></b></label>
                    <input type="text" class="form-control" id="family_name" name="family_name" value="<?php echo $default_family_name;?>" required>
                    <div class="invalid-feedback">
                      Necesitas usar un apellido válido.
                    </div>
                </div>

                <div class="col-md-6 mb-3 align-self-center">
                    <label for="char_name"><b>Nombre del personaje <a class="info_button" href="#" onClick="javascript:display_info(event, 2)">&nbsp;?&nbsp;</a></b></label>
                  <input type="text" class="form-control" id="char_name" name="char_name" value="<?php echo $default_char_name;?>" required>
                  <div class="invalid-feedback">
                    Necesitas usar un nombre válido.
                  </div>
                </div>
            
            </div>
              


              <div class="row">
                <div class="col-md-6 d-block my-3">
                  <label for="rol"><b>Función <a class="info_button" href="#" onClick="javascript:display_info(event, 3)">&nbsp;?&nbsp;</a></b></label>
                  <div class="custom-control custom-radio mx-4">
                    <input id="credit" name="role" type="radio" class="custom-control-input" value="0" <?php if($default_role=='0') {echo 'checked';}?> required>
                    <label class="custom-control-label" for="credit">Civil</label>
                  </div>
                  <div class="custom-control custom-radio mx-4">
                    <input id="debit" name="role" type="radio" class="custom-control-input" value="1" <?php if($default_role=='1') {echo 'checked';}?> required>
                    <label class="custom-control-label" for="debit">Religioso</label>
                  </div>
                </div>

                <div class="col-md-6 mb-3 my-3">
                    <label for="property_name"><b>Nombre de tu castillo/monasterio <a class="info_button" href="#" onClick="javascript:display_info(event, 4)">&nbsp;?&nbsp;</a></b></label>
                    <input type="text" class="form-control" id="property_name" name="property_name" value="<?php echo $default_property_name;?>" required>
                    <div class="invalid-feedback">
                      Necesitas insertar un nombre válido.
                    </div>
                </div>
              </div>
              
            <hr class="mb-4">  
            <h4 class="mb-4">Información personal</h4>
            <div class="mb-3">
              <label for="email"><b>Correo electrónico</b></label>
              <input type="email" class="form-control" id="email" name="email" value="<?php echo $default_email;?>"required>
              <div class="invalid-feedback">
                Necesitas una dirección de correo válida.
              </div>
            </div>
            
            
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="password_1"><b>Contraseña <a class="info_button" href="#" onClick="javascript:display_info(event, 5)">&nbsp;?&nbsp;</a></b></label>
                <input type="password" class="form-control" id="password_1" name="password_1" required>
                <div class="invalid-feedback">
                  Necesitas introducir una contraseña válida.
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="password_2"><b>Repite la contraseña</b></label>
                <input type="password" class="form-control" id="password_2" name="password_2" required>
                <div class="invalid-feedback">
                  Necesitas introducir una contraseña válida.
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-12 mb-3">
                <input class="form-check-input" style="margin-left: 0em;" type="checkbox" id="terms_checkbox" name="terms_checkbox" value="checked" required>
                <label class="form-check-label" style="margin-left: 1.25em;" for="terms_checkbox">He leido y acepto los <a href="terms.php" target="_blank">Términos y condiciones</a>. <b><a class="info_button" href="#" onClick="javascript:display_info(event, 6)">&nbsp;?&nbsp;</a></b></label>
                <div class="invalid-feedback">
                  Este campo es obligatorio.
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 mb-3">
                <input class="form-check-input" style="margin-left: 0em;" type="checkbox" id="14_checkbox" name="14_checkbox" value="checked" required>
                <label class="form-check-label" style="margin-left: 1.25em;" for="14_checkbox">Soy mayor de 14 años o tengo el consentimiento de mis padres/tutores para efectuar el registro.</label>
                <div class="invalid-feedback">
                  Este campo es obligatorio.
                </div>
              </div>
            </div>

            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" type="submit">Registrar</button>
          </form>
        </div>
        <!-- End main form -->
      </div>

    
    </div>    
        
    <?php
    return ob_get_clean(); 
}        

