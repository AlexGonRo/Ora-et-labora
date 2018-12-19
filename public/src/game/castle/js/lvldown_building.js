function lvldown_building(building_name, building_id, user_building_id, level, lvldown_perc, lvldown_resources){
    $(document).ready(function(){
        var r = confirm("¿Estás seguro de que quieres demoler este edificio("+building_name+")?\nSolo recibirás el "+(lvldown_perc*100)+"% de los recursos que empleaste en ampliarlo. ("+lvldown_resources+")");
        if (r === true) {
            $.ajax({
                type: 'POST',
                url: 'php/ajax/rm_lvl_building.php',
                data: {
                    'user_building_id': user_building_id,
                    'building_id': building_id,
                    'level': level
                },
                success: function(data) {
                    var alert_div = $(".my_alerts").eq(0);
                    alert_div.append("<div class='alert alert-success alert-dismissible fade show'>\n\
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>\n\
                            <p>El nivel del edificio ha sido reducido (o el edificio entero demolido). La página se recargará en breve.</p>\n\
                          </div>");
                    setTimeout(function(){
                        location.reload(); 
                    }, 5000);
                     
                },
                error: function(request, status, error){
                    var alert_div = $(".my_alerts").eq(0);
                    alert_div.append("<div class='alert alert-danger alert-dismissible fade show'>\n\
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>\n\
                            <p>No pudo realizarse la demolición. ¿Tendrá el edificio suficiente espacio libre cuando sea demolido?</p>\n\
                          </div>");

                }
            });
        }
    });
};

