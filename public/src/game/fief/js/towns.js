function load_town(){
   $(document).ready(function(){
          var e = document.getElementById("town_list");
          var new_town_id = e.options[e.selectedIndex].value;
          $.ajax({
              type: 'POST',
              url: 'php/load_town.php',
              data:  {
                  'town_id': new_town_id,
              },
              success: function(data) {
                  document.getElementById("town_info").innerHTML = data;
              }
          });
  });
}

function change_taxes(town_id){
   $(document).ready(function(){
       var new_taxes = document.getElementById("new_taxes").value;
       $.ajax({
           type: 'POST',
           url: 'php/ajax/change_taxes.php',
           data:  {
               'town_id': town_id,
               'new_taxes': new_taxes
           },
           success: function(data) {
               document.getElementById("new_taxes").value = "";
               // If the function does not succeed
               if (!data){
                   var alert_div = $(".my_alerts").eq(0);
                   alert_div.append("<div \n\
                       class='alert alert-danger alert-dismissible fade show'>\n\
                       <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>\n\
                       <p>Algo ha impedido modificar los impuestos.</p>\n\
                       </div>");

               } else {
                   var alert_div = $(".my_alerts").eq(0);
                   alert_div.append("<div class='alert alert-success alert-dismissible fade show'>\n\
                           <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>\n\
                           <p>Se han cambiado los impuestos.</p>\n\
                         </div>");

                   // Change the html data about the taxes
                   // (color red for number that could never be paid, i.e above 100% taxes)
                   document.getElementById("local_font").innerHTML = data;
                   if (Number(data)>100){
                       document.getElementById("local_font").style.color = "red";
                   } else {
                       document.getElementById("local_font").style.color = "black";
                   }
                   duchy_tax = document.getElementById("duchy_font").innerHTML;
                   if (Number(data) + Number(duchy_tax) > 100){
                       document.getElementById("duchy_font").style.color = "red";
                   } else {
                       document.getElementById("duchy_font").style.color = "black";
                   }
                   royal_tax = document.getElementById("royal_font").innerHTML;
                   if (Number(data) + Number(duchy_tax) + Number(royal_tax) >100){
                       document.getElementById("royal_font").style.color = "red";
                   } else {
                       document.getElementById("royal_font").style.color = "black";
                   }

               }

           }
       });
   });
}

function lvlup_building(town_id, town_building_id){
   $(document).ready(function(){
       $.ajax({
           type: 'POST',
           url: 'php/ajax/lvlup_building.php',
           data:  {
               'town_id': town_id,
               'town_building_id': town_building_id,
           },
           success: function(data) {
               // If the function does not succeed
               if (!data){
                   var alert_div = $(".my_alerts").eq(0);
                   alert_div.append("<div \n\
                       class='alert alert-danger alert-dismissible fade show'>\n\
                       <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>\n\
                       <p>No se ha podido realizar la ampliación.</p>\n\
                       </div>");

               } else {
                   var alert_div = $(".my_alerts").eq(0);
                   alert_div.append("<div class='alert alert-success alert-dismissible fade show'>\n\
                           <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>\n\
                           <p>Hemos empezado la ampliación.</p>\n\
                         </div>");

                   document.getElementById("upgrade_"+town_building_id).disabled = true;
                   document.getElementById("lvl_cell_"+town_building_id).textContent = 'Ampliandose';
               }
           }
       });
   });
}
