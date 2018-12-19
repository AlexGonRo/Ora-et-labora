function go_on_vacation(){
    var r = confirm("¿Necesitas unas vacaciones?\nTu cuenta permanecerá en pausa por un periodo de 30 días.");
    if (r === true) {
        $(document).ready(function(){
            // Run the AJAX query
            $.ajax({
                type: "POST",
                url: 'php/ajax/start_vacation.php',
                data:{
                    'pass': document.getElementById("old_pass").value
                },
                success: function(data){
                    if(data === 'success'){
                        window.location.replace("../../front/logout.php");
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    var alert_div = $(".my_alerts").eq(0);
                    alert_div.append("<div class='alert alert-danger alert-dismissible fade show'>\n\
                            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>\n\
                            <p>La contraseña introducida no es correcta.</p>\n\
                          </div>");
                }
            });
        });
    }
}

