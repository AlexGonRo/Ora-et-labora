<?php 

$page_title = "Ora et Labora - Términos y condiciones";

$page_meta = render_metainfo();

$my_js_scripts = render_my_js_scripts();

$content_html = render_content();

require_once 'masterPage_front.php';


function render_metainfo(){
    ob_start();
    ?>
        <meta name="description" content="Reglas del juego, términos y condiciones de uso e información sobre el tratamiento de datos personales. Todo lo que necesitas saber antes de empezar.">
    <?php
    return ob_get_clean();
}

function render_my_js_scripts(){
    ob_start();
    ?>
        <script src="js/mail_prot.js"></script>
    <?php
    return ob_get_clean();
}

function render_content(){
    ob_start();
    ?>
    <div class="container">
        
      <div class="py-5 text-center">    <!--py-* class for padding top and bottom -->
        <h2>Términos y condiciones de uso</h2>
        <p class="lead">Información sobre las reglas del juego, el uso y tratamiento de los datos personales y los derechos y deberes de los usuarios.</p>
      </div>


      <div class="row">
          
        
        <div class="p-5 front_text_body" >
            <!--Reglas-->
            <h4 class="justify-content-between align-items-center mb-3">
              <span class="text-muted">Reglas</span>
            </h4>
            <hr class="mb-4">
            <ul>
                <li class="py-1">El usuario acepta estos Términos y Condiciones de uso al registrarse en la plataforma.</li>
                <li class="py-1">La propiedad de la cuenta es única e intrasferible.</li>
                <li class="py-1">Solo se permite registrar una cuenta por usuario. En el caso de que, por cualquier motivo, dos personas quieran jugar con cuentas diferentes desde un mismo terminal o conexión a internet deben ponerse en contacto con la <a id="email" href="click:the.address.will.be.decrypted.by.javascript" onclick='decipher_mail(this, event);'> adminsitración del juego</a>. <br />
                    En el caso de que dicha administración permita la existencia de ambos jugadores, esta se reserva el derecho a establecer condiciones que limiten la posibilidad de interacción entre ambas cuentas.</li>
                <li class="py-1">El uso de errores o "bugs" para beneficio propio será sancionado de acuerdo a la gravedad de la infracción.</li>
                <li class="py-1">El uso de cualquier servicio de mensajería incluido en el juego no deberá usarse para enviar o hacer referencia a datos de caracter personal. El usuario es responsable de mantener esta información en secreto y la aplicación no garantiza el correcto tratamiento y almacenamiento de mensajes que puedan contener información sensible. Asi mismo, preguntar por cualquier dato de caracter personal puede ser sancionado por la administración del juego.</li>
                <li class="py-1">El idioma del juego es el español o castellano. El uso de cualquier otra lengua en cualquier servicio de mensajería interna puede ser sancionado por ser considerado excluyente.</li>
                <li class="py-1">El uso del sistema de mensajería del juego para proferir insultos o amenazas hacia otros jugadores no está permitido. Es igualmente sancionable cualquier tipo de mensaje que implique contenidos pornográficos, racistas, violentos o que puedan ser considerados como spam.</li>
                <li class="py-1">El intento de acceso o acceso a cuentas de otros usuarios, la usurpación de identidad real o ficticia dentro del juego y/o foro, así como las acciones de hackeo, suponen el borrado del usuario infractor así como su bloqueo y veto permanente, además de las acciones legales que puedan ejercerse en su contra.</li>   <!--Cogido de Edad Media Online (http://edadmediaonline.com/Edad%20Media.php?mod=cgs) -->
                <li class="py-1">No se permite el uso de programas diseñados para obtener un beneficio adicional al que tendrían el resto de jugadores. </li>
                <li class="py-1">La gravedad de una sanción será decidida por el equipo administrador del juego. Dicho equipo tendrá en cuenta la posible existencia de infracciones pasadas, siendo este un factor agravante a la hora de elegir un castigo. La penalización puede implicar la modificación de cualquier elemento de la cuenta o el bloqueo, parcial o permanente, de dicha cuenta. </li>
            </ul>

                                                                        
            <!--Protección de datos-->
            <h4 class="justify-content-between align-items-center my-3">
              <span class="text-muted">Protección y tratamiento de datos</span>
            </h4>
            <hr class="mb-4"> 
            
            <div class="indent_first_line py-1">El usuario es responsable de la veracidad de los datos suministrados. Así mismo declara ser mayor de edad o de disponer de autorización de sus padres/tutores para tratar sus datos personales.</div>
            <div class="indent_first_line py-1">Tratamos la información que nos facilita con el fin de prestar el servicio solicitado. Los datos proporcionados se conservarán mientras el jugador permanezca registrado o durante los años necesarios para cumplir con las obligaciones legales. Los datos no se cederán a terceros salvo en los casos en que exista una obligación legal.</div>
            <div class="indent_first_line py-1">Asi mismo también podremos utilizar dicha información para ofrecerle noticias o avances relacionados con el juego. </div>
            <div class="indent_first_line py-1">Tiene derecho a obtener confirmación sobre si en <b><i>Ora et Labora</i></b> estamos tratando sus datos personales, asi como derecho a acceder a ellos, rectificar los datos inexactos o solicitar su supresión cuando los datos ya no sean necesarios. Puede hacer todo esto desde la interfaz de la aplicación o poniendose en contacto con el <a id="email" href="click:the.address.will.be.decrypted.by.javascript" onclick='decipher_mail(this, event);'>administrador</a>.</div>
            <div class="indent_first_line py-1">Responsable del tratamiento de datos: Alejandro González Rogel </div>
            <div class="indent_first_line py-1">Datos tratados: Correo electrónico, suministrado durante el registro o modificado a posteriori desde la aplicación. </div>
            <div class="indent_first_line py-1"><a id="email" href="click:the.address.will.be.decrypted.by.javascript" onclick='decipher_mail(this, event);'>Contacto</a> </div>
            
            
            <!--Condiciones-->
            <h4 class="justify-content-between align-items-center my-3">
              <span class="text-muted">Condiciones generales de uso</span>
            </h4>
            <hr class="mb-4"> 
                
            <div class="indent_first_line py-1">El administrador puede interrumpir el normal funcionamiento del juego sin previo aviso si esto se debe a trabajos de mantenimiento o actualización.</div>
            <div class="indent_first_line py-1">Depende del usuario mantener en secreto sus datos de acceso (correo electrónico y contraseña). De igual manera, es el usuario el que debe encargarse de que su contraseña proporcione un nivel de seguridad adecuado.</div>

            
        </div>
      </div>
    </div>
    <?php
    return ob_get_clean(); 
}        

