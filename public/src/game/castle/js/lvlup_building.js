function lvlup_building(user_building_id, building_id, level){
   $(document).ready(function(){
       $.ajax({
           type: 'POST',
           url: 'php/ajax/lvlup_building.php',
           data: {
               'user_building_id': user_building_id,
               'building_id': building_id,
               'level':level
           },
           success: function(data) {
               var alert_div = $(".my_alerts").eq(0);
               alert_div.append("<div class='alert alert-success alert-dismissible fade show'>\n\
                       <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>\n\
                       <p>Hemos comenzado la ampliación.</p>\n\
                     </div>");
               $("#p_"+user_building_id).text("Ampliandose");
               $("#button_"+user_building_id).remove();
           }
       });
   });
};