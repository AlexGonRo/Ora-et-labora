function build_building(user_building_id, building_id, level){
   $(document).ready(function(){
       $.ajax({
           type: 'POST',
           url: 'php/ajax/build_building.php',
           data: {
               'building_id': building_id
           },
           success: function(data) {
               var alert_div = $(".my_alerts").eq(0);
               alert_div.append("<div class='alert alert-success alert-dismissible fade show'>\n\
                       <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>\n\
                       <p>¡Hemos comenzado la construcción de un nuevo edificio!.</p>\n\
                     </div>");
               $("#p_"+user_building_id).text("Ampliandose");
               $("#button_"+user_building_id).remove();
           }
       });
   });
};