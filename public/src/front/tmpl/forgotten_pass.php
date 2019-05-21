<?php 

$page_title = "Ora et Labora - Contraseña olvidada";

$my_js_scripts = render_my_js_scripts();

$content_html = render_content($alert_msg, $alert_type);

require_once 'masterPage_front.php';

function render_my_js_scripts(){
    ob_start();
    ?>
    <script>
        $(document).ready(function() {
          $('#send_button').on('click', function() {
            var $this = $(this);
            var loadingText = '<div class="spinner-border text-light" role="status"><span class="sr-only">Cargando...</span></div>';
            if ($(this).html() !== loadingText) {
              $this.data('original-text', $(this).html());
              $this.html(loadingText);
            }
          });
        })
    </script>
    <?php
    return ob_get_clean();
}

function render_content($alert_msg, $alert_type){
    ob_start();
    ?>
    <div class="container">
        
      <div class="py-5 text-center">    <!--py-* class for padding top and bottom -->
        <h2>¿Olvidaste tu contraseña?</h2>
        <p class="lead">No pasa nada, solo necesitamos el correo electrónico que utilizaste durante el registro y te mandaremos un mensaje con una nueva contraseña.</p>
      </div>


      <div class="row">
          
        
        <div class="p-5 front_text_body col-12 my_box_shadow" >
            <div id="alerts">
                <?php if($alert_msg != ''){ ?>
                    <div class="alert alert-<?php echo $alert_type;?>" role="alert">
                        <?php echo $alert_msg;?>
                      </div>

                <?php } ?>
            </div>
            <!--Reglas-->
            <form class="center" action="forgotten_pass.php" method="post">
                <label class="form-group"> Introduce aquí tu correo.</label>
                <div class="form-group form-inline">
                    <div class="input-group-prepend">
                      <div class="input-group-text">@</div>
                    </div>
                    <input type="text" class="form-control" name="email" id="email" value="" placeholder="Correo electrónico">
                </div>

                <button type="submit" class="btn" id="send_button">Enviar</button>


            </form>
            
        </div>
      </div>
    </div>
    


    <?php
    return ob_get_clean(); 
}        

