function update_stable(stable_id){
   $(document).ready(function(){
      
       $.ajax({
           type: 'POST',
           url: 'php/ajax/update_stable.php',
           data: {
               'stable_id': stable_id,
               'chicken_range': parseInt(document.getElementById('chicken_range').value),
               'goose_range': parseInt(document.getElementById('goose_range').value),
               'sheep_range': parseInt(document.getElementById('sheep_range').value),
               'pig_range': parseInt(document.getElementById('pig_range').value),
               'cow_range': parseInt(document.getElementById('cow_range').value),
               'horse_range': parseInt(document.getElementById('horse_range').value),
           },
           dataType:"json",
           success: function(data) {
               var alert_div = $(".my_alerts").eq(0);
               alert_div.append("<div class='alert alert-success alert-dismissible fade show'>\n\
                       <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>\n\
                       <p>Establo actualizado.</p>\n\
                     </div>");
               
               // Modify values overview
               // TODO
               // Modify values ranges
               // TODO
           },
           error: function (xhr, httpStatusMessage, customErrorMessage) {
               var alert_div = $(".my_alerts").eq(0);
                alert_div.append("<div class='alert alert-danger alert-dismissible fade show'>\n\
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>\n\
                        <p>No se pudo completar la acción. ¿Tienes espacio suficiente en el almacén y/o la despensa?.</p>\n\
                      </div>");
            }
       });
   });
};