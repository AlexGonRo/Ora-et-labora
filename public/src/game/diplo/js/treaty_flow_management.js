// Scripts that control the treaty proposal flow
function specify_deal(opt_id, side){
    $(document).ready(function() {

                var select_object = document.getElementById(side+'_type_'+opt_id)
                var selected = select_object.options[select_object.selectedIndex].value; 

                // Clear any content that the user could have generated during execution time
                var my_span = document.getElementById(side+'_container_2_'+opt_id);
                my_span.innerHTML = "";

                // If we are demanding something, let's take the username of the other player
                var msg_ben = '';
                if (side === 'demand'){
                    var msg_ben = document.getElementById("msg_beneficiary").value;
                }

                if (selected === 'item'){
                    $.ajax({
                        type: "POST",
                        data: {},
                        url: "php/ajax/load_item_names.php",
                        dataType: 'json',
                        success: function(msg){
                            var my_select = document.createElement("select");
                            my_span.appendChild(my_select);
                            for (var i = 0; i < msg.length; i++) {
                                var my_option = document.createElement("option");
                                my_option.value = msg[i].id;
                                my_option.text = msg[i].name;
                                my_select.appendChild(my_option);
                            }
                            var my_input = document.createElement("input");
                            my_input.type = "text";
                            my_span.appendChild(my_input);
                        }
                    });
                } else if (selected === 'town'){
                    $.ajax({
                        type: "POST",
                        data: {'msg_ben': msg_ben,
                            'side': side},
                        url: "php/ajax/load_towns.php",
                        dataType: 'json',
                        success: function(msg){
                            var my_select = document.createElement("select");
                            my_span.appendChild(my_select);
                            for (var i = 0; i < msg.length; i++) {
                                var my_option = document.createElement("option");
                                my_option.value = msg[i].id;
                                my_option.text = msg[i].name;
                                my_select.appendChild(my_option);
                            }
                        },
                        error: function (xhr, httpStatusMessage, customErrorMessage) {
                            var error_message = document.createElement("span");
                            error_message.innerHTML = customErrorMessage;
                            my_span.appendChild(error_message);
                        }
                    });

                } else if (selected === 'resource'){
                    $.ajax({
                        type: "POST",
                        data: {'msg_ben': msg_ben,
                            'side': side},
                        url: "php/ajax/load_res.php",
                        dataType: 'json',
                        success: function(msg){
                            var my_select = document.createElement("select");
                            my_span.appendChild(my_select);
                            for (var i = 0; i < msg.length; i++) {
                                var my_option = document.createElement("option");
                                my_option.value = msg[i].id;
                                my_option.text = msg[i].name;
                                my_select.appendChild(my_option);
                            }
                        },
                        error: function (xhr, httpStatusMessage, customErrorMessage) {
                            var error_message = document.createElement("span");
                            error_message.innerHTML = customErrorMessage;
                            my_span.appendChild(error_message);
                        }
                    });

                } else if (selected === 'other') {
                    var my_input = document.createElement("input");
                    my_input.type = "text";
                    my_span.appendChild(my_input);
                }
    });
}


function add_point(side){
    $(document).ready(function() {
        var n_previous_points = document.getElementsByClassName(side+"_container").length;
        var next_point = n_previous_points + 1;
        var my_div = document.getElementsByClassName(side+'_container')[n_previous_points-1];

        var my_container = document.createElement("div");
        my_container.classList.add(side+"_container");
        my_div.appendChild(my_container);

        var my_type = document.createElement("select");
        my_type.setAttribute("id", side+"_type_"+next_point);
        my_type.setAttribute("onchange", "specify_deal("+next_point+",'"+side+"')");

        var my_option = document.createElement("option");
        my_option.value = "no_option";
        my_option.text = "--";
        my_type.appendChild(my_option);
        var my_option = document.createElement("option");
        my_option.value = "item";
        my_option.text = "Materiales";
        my_type.appendChild(my_option);
        var my_option = document.createElement("option");
        my_option.value = "town";
        my_option.text = "Propiedad de villa o pueblo";
        my_type.appendChild(my_option);
        var my_option = document.createElement("option");
        my_option.value = "resource";
        my_option.text = "Propiedad de recurso";
        my_type.appendChild(my_option);
        var my_option = document.createElement("option");
        my_option.value = "other";
        my_option.text = "Otro";
        my_type.appendChild(my_option);


        my_container.appendChild(my_type);

        var my_span = document.createElement("span");
        my_span.setAttribute("id", side+"_container_2_"+next_point);
        my_container.appendChild(my_span);

    });
}
