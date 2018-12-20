function display_info(event, id_text) {
    var element = document.getElementById('descriptive_text');
    if (id_text === 1) {    // Family name
        element.innerHTML = "Tu <b>nombre de usuario</b> y apellido de tu dinastía. <br />\n\
<ul>\n\
<li> Tiene que contener de 4 hasta 16 caracteres.</li>\n\
<li> Solo se permiten caracteres alfanuméricos, espacios, spuntos, comas y '-' o '_'.</li>\n\
</ul>";
    } else if(id_text === 2){  // Name
        element.innerHTML = "Nombre de tu personaje. Ten en cuenta que tu personaje puede morir, por lo que no es un nombre definitivo. <br />\n\
<ul>\n\
<li> Tiene que contener de 3 hasta 16 caracteres.</li>\n\
<li> Solo se permiten caracteres alfanuméricos, espacios, puntos, comas y '-' o '_'.</li>\n\
</ul>";
    } else if(id_text === 3){ // Role
        element.innerHTML = "Puedes elegir entre jugar como un noble o un abad. Cada rol tiene unas características diferentes pero necesitarás del otro para progresar.<br />\n\
<ul>\n\
<li> <b>Ambos roles: </b>Pueden controlar recursos geográficos, villas y hasta regiones enteras. Pueden fabricar productos básicos y dedicarse al comercio sin restricciones. </li>\n\
<li> <b>Civil: </b> Encargados de mantener la seguiridad de villas y aldeas. Pueden, además, especializarse en la creación de armas, materiales de construcción u orfebrería. Figura fundamental en caso de guerra.</li>\n\
<li> <b>Religioso: </b>Deben mantener el fervor religioso de sus súbditos y llevar a cabo tareas como la de atención a enfermos, la copia de libros o la creación de caros tapices. Su poder aumenta extendiendo su control sobre el pueblo.</li>\n\
</ul>";
    } else if(id_text === 4){ // Castle/monastery name
        element.innerHTML = "Nombre de tu castillo o monasterio, sin funcionalidad práctica. <br />\n\
<ul>\n\
<li> Tiene que contener de 3 hasta 16 caracteres.</li>\n\
<li> Solo se permiten caracteres alfanuméricos, espacios, puntos, comas y '-' o '_'.</li>\n\
</ul>";
    } else if(id_text === 5){ // Password
        element.innerHTML = "<br />\n\
<ul>\n\
<li> Tiene que contener de 8 hasta 16 caracteres.</li>\n\
<li> Se permiten caracteres alfanuméricos, espacios, signos de puntuación y matemáticos y '-', '_', '/', '\\'. No admite signos de interrogación o exclamación ni comillas.</li>\n\
</ul>";
    } else if(id_text === 6){ // RGPD info
        element.innerHTML = "<b>Información básica sobre protección de datos</b> <br /> \n\
<b>- Responsable: </b> Alejandro González Rogel <br /> \n\
<b>- Correo electrónico: </b> <a id='email' href='click:the.address.will.be.decrypted.by.javascript' onclick='decipher_mail(this, event);'>Pincha aquí para ver el correo</a><br />\n\
<b>- Información recabada:</b> Correo electrónico <br />\n\
<b>- Finalidad: </b> Recuperación de contraseña, evitar duplicidad de cuentas, contacto.<br />\n\
<b>- Derechos: </b>Posibilidad de acceder, rectificar y eliminar datos personales.<br />\n\
<b>- Legitimización: </b> Aceptación de los <a href='terms.php' target='_blank'>Términos y condiciones</a>. <br />";
    }
    event.preventDefault();
    
}
