

function open_moving_option(){
    $(document).ready(function(){
        // Run the AJAX query
        $.ajax({
            url: 'php/ajax/available_towns.php',
            dataType: 'json',
            success: function(response) {
                var len = response.length;
                var my_select =  document.getElementById("town_selection_select");
                for(var i=0; i<len; i++){
                    a =  response[i];
                    var town_id = response[i].town_id;
                    var town_name = response[i].town_name;
                    var region_name = response[i].region_name;
                    var my_option_text = town_name + " en " + region_name;
                    my_select.options.add( new Option(my_option_text,town_id) );
                }
                $('#move_modal').modal('show');
            }
        });
    });
}

function move_player(user_id){
    $(document).ready(function(){
        var e = document.getElementById('town_selection_select');
        // Run the AJAX query
        $.ajax({
            type: 'POST',
            url: 'php/ajax/move_user.php',
            data: {
                'user_id':user_id,
                'town_id':e.options[e.selectedIndex].value
            },
            success: function(data) {
                alert(data);
                window.location.replace(".");
            }
        });
    });
}