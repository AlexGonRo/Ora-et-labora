<?php 

$page_title = "Ora et Labora - Sobre el proyecto";

$page_meta = render_metainfo();

$my_js_scripts = render_my_js_scripts();

$content_html = render_content();

require_once 'masterPage_front.php';


function render_metainfo(){
    ob_start();
    ?>
        <meta name="description" content="¿Quién está detrás de Ora et Labora? ¿Cuáles son las motivaciones para sacar adelante el juego? ¿Y nuestra política de trabajo?">
    <?php
    return ob_get_clean();
}

function render_my_js_scripts(){
    ob_start();
    ?>

    <?php
    return ob_get_clean();
}

function render_content(){
    ob_start();
    ?>
        
    <div class="container">
        
      <div class="py-5 text-center">    <!--py-* class for padding top and bottom -->
        <h2>Sobre el proyecto</h2>
        <p class="lead">Carta sobre la motivación, el espíritu y el estado de Ora et Labora</p>
      </div>


      <div class="row">

        <div class="p-5 front_text_body" >
          <h4 class="justify-content-between align-items-center mb-3">
            <span class="text-muted">El juego</span>
          </h4>
          <hr class="mb-4"> 
          <div class="indent_first_line py-1"><b><i>Ora et Labora</i></b> es un juego online gratuito, con ambientación medieval, y centrado en la gestión de recursos y la interacción social para salvaguardar peligros y crecer como jugador. Comencé a programarlo a mediados de septiembre de 2018, aunque la idea de desarrollar un juego de estas características data de más atrás, y se presentó una primera versión a principios del año siguiente. Primera versión que, pese al trabajo invertido, sigue siendo poco más que unas cuantas pantallas entre las que se puede intuir la idea de un juego pero que están lejos de serlo.<br></div>
          <div class="indent_first_line py-1">Este no es un proyecto que tenga ningún propósito comercial, sino que lo creé con la intención de compartirlo y, en el supuesto de que el juego llegase a terminarse, abrirlo al público para uso y disfrute de lo que sea que termine siendo. Es por esto que <b><i>Ora et Labora</i></b> se ofrece de manera gratuita y no existe, a día de hoy, ninguna intención de incluir ningún elemento que conlleve un rédito económico por mi parte.</div>
          <div class="indent_first_line py-1">No solo eso, todo el trabajo que he realizado, y espero seguir realizando en el futuro, se encuentra accesible para cualquiera que quiera verlo, mejorarlo o utilizarlo para otros fines (siempre de acuerdo a la licencia). No han sido pocos los recursos de acceso gratuito que he utilizado desde que empezara a programar, muchos de ellos creados y mantenidos de manera desinteresada. Incluso algunos de ellos han sido utilizados durante el desarrollo del juego. Es por ello que parece justo que deje este trabajo a disposición de cualquiera este interesado en él.</div>
          
          <h4 class="justify-content-between align-items-center my-3">
            <span class="text-muted">La motivación</span>
          </h4>
          <hr class="mb-4"> 
          <div class="indent_first_line py-1">La idea de crear un juego es algo que he tenido pendiente desde pequeño. Ya por aquel entonces perdía el tiempo ideando algún, a mis ojos, complicado juego de mesa o concibiendo  mundos de rol imaginarios al más puro estilo coordinador de una partida de D&D. Sin embargo, a medida que fui creciendo y aceptando responsabilidades esta pensamiento quedó relegado a un segundo plano a la espera de que, tal vez, en algún momento, tuviese el tiempo y las ganas necesarias para crear algo nuevo. Parte de lo que me ha impulsado a trabajar en este proyecto proviene de voluntad para, finalmente, sacar un juego adelante.</div>
          <div class="indent_first_line py-1">Por otra parte, la motivación concreta para desarrollar esta idea (la de un mundo medieval cuyos jugadores necesitan cooperar para progresar)  depende de varios factores. Por una parte están mis gustos personales y todo el tiempo que, años atrás, pasé jugando juegos online de navegador. Por la otra, dos juegos concretos: Abbatia, <a href="https://abbatianet.wordpress.com">ya desaparecido</a>, y <a href="http://edadmediaonline.com">Edad Media Online</a>, sucesor espiritual y todavía presente. Fue, sobretodo el primero, el que causó una fuerte impresión en mí de pequeño. Pero a ambos se le deben muchos conceptos que están, o planean estar, implementados en <b><i>Ora et Labora</i></b>.</div>
          <hr class="mb-4"> 
              
       
        </div>

    
    </div>    
        
    <?php
    return ob_get_clean(); 
}        

