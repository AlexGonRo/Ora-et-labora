
function load_resource(){
    $(document).ready(function(){
           var e = document.getElementById("resource_list");
           var new_resource_id = e.options[e.selectedIndex].value;
           $.ajax({
               type: 'POST',
               url: 'php/load_resource.php',
               data:  {
                   'id': new_resource_id,
               },
               success: function(data) {
                   document.getElementById("resource_info").innerHTML = data;
               }
           });
    });
}

function change_limit(resource_id){
   $(document).ready(function(){
       var new_limit = document.getElementById("new_limit").value;
       $.ajax({
           type: 'POST',
           url: 'php/ajax/change_manual_limit.php',
           data:  {
               'resource_id': resource_id,
               'new_limit': new_limit
           },
           success: function(data) {
               document.getElementById("new_limit").value = "";
               // If the function does not succeed
               if (!data){
                   var alert_div = $(".my_alerts").eq(0);
                   alert_div.append("<div \n\
                       class='alert alert-danger alert-dismissible fade show'>\n\
                       <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>\n\
                       <p>No se ha podido cambiar el límite de trabajadores...</p>\n\
                       </div>");
               } else {
                   var alert_div = $(".my_alerts").eq(0);
                   alert_div.append("<div class='alert alert-success alert-dismissible fade show'>\n\
                           <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>\n\
                           <p>Se ha cambiado el límite de trabajadores</p>\n\
                         </div>");
                   if (data=="NULL"){
                        document.getElementById("limit_info").innerHTML = "";
                   } else {
                       document.getElementById("limit_info").innerHTML = "(Límite puesto "+data+" en personas)";
                   }
               }

           }
       });
   });
}

function change_production(resource_id){
   $(document).ready(function(){
       var e = document.getElementById("field_production");
       $.ajax({
           type: 'POST',
           url: 'php/ajax/change_field_production.php',
           data:  {
               'resource_id': resource_id,
               'new_production': e.options[e.selectedIndex].value
           },
           success: function(data) {
               // If the function does not succeed
               if (!data){
                   var alert_div = $(".my_alerts").eq(0);
                   alert_div.append("<div \n\
                       class='alert alert-danger alert-dismissible fade show'>\n\
                       <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>\n\
                       <p>No se ha podido cambiar la producción</p>\n\
                       </div>");
               } else {
                   var alert_div = $(".my_alerts").eq(0);
                   alert_div.append("<div class='alert alert-success alert-dismissible fade show'>\n\
                           <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>\n\
                           <p>Se ha cambiado la producción</p>\n\
                         </div>");
                   tmp = data.split(",");
                   if (tmp[0]==='1'){
                       document.getElementById("field_production_text").innerHTML = "Ganado";
                       document.getElementById("production_time_info").innerHTML = "¡Estamos produciendo hasta <span id='month'></span>!(Quedan <span id='turns_left'></span> ciclos)</span><br>";
                       document.getElementById("month").innerHTML = tmp[1];
                       document.getElementById("turns_left").innerHTML = tmp[2];
                   } else if(tmp[0]==='2'){
                       document.getElementById("field_production_text").innerHTML = "Grano";
                       document.getElementById("production_time_info").innerHTML = "<span id='production_time_info'>La producción comenzará en <span id='month'></span>(Quedan <span id='turns_left'></span> ciclos)</span><br>";
                       document.getElementById("month").innerHTML = tmp[1];
                       document.getElementById("turns_left").innerHTML = tmp[2];
                   } else if(tmp[0]==='3'){
                       document.getElementById("field_production_text").innerHTML = "Uva";
                       document.getElementById("production_time_info").innerHTML = "<span id='production_time_info'>La producción comenzará en <span id='month'></span>(Quedan <span id='turns_left'></span> ciclos)</span><br>";
                       document.getElementById("month").innerHTML = tmp[1];
                       document.getElementById("turns_left").innerHTML = tmp[2]; 
                   }            

               }

           }
       });
   });
}

function lvlup_resource(resource_id){
   $(document).ready(function(){
       $.ajax({
           type: 'POST',
           url: 'php/ajax/lvlup_resource.php',
           data:  {
               'resource_id': resource_id
           },
           success: function(data) {
               // If the function does not succeed
               if (!data){
                   var alert_div = $(".my_alerts").eq(0);
                   alert_div.append("<div \n\
                       class='alert alert-danger alert-dismissible fade show'>\n\
                       <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>\n\
                       <p>No se ha podido mejorar el edificio.</p>\n\
                       </div>");
               } else {
                   var alert_div = $(".my_alerts").eq(0);
                   alert_div.append("<div class='alert alert-success alert-dismissible fade show'>\n\
                           <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>\n\
                           <p>Ha comenzado la construcción</p>\n\
                         </div>");
                   document.getElementById("lvlup_button").disabled = true;     

               }

           }
       });
   });
}
