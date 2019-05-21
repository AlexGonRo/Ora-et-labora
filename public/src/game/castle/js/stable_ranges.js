// Scripts that control the behaviour of the range elements in the stable

function update_on_range(range_id, input_id){
    $(document).ready(function() {

            var e = $('#'+range_id);
            var current_value = parseInt(e.val());
            var old_value = parseInt(document.getElementById(input_id).value);
            var diff = current_value - old_value;

            // Update
            document.getElementById(input_id).value = current_value + "%";
            document.getElementById("unassigned_space").innerHTML = 
                    (parseInt(document.getElementById("unassigned_space").innerHTML) - diff) ;
            $(input_id).change();
            $('#unassigned_space').change();


    })
}

function update_input(range_id, input_id){
    $(document).ready(function() {
        var current_value = parseInt(document.getElementById(input_id).value);
        // Take old value from the range_bar
        var old_value = parseInt($('#'+range_id).val());
        var diff = current_value - old_value;

        //Update
        document.getElementById(range_id).value= current_value;
        document.getElementById("unassigned_space").innerHTML = 
                (parseInt(document.getElementById("unassigned_space").innerHTML) - diff) ;

        $('#unassigned_space').change();
    })
}
