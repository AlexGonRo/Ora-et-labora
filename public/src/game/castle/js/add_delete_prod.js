function add_prod(building_id, textbox_id, dropdown_id){
    $(document).ready(function(){
        // Run the AJAX query
        var e = document.getElementById(dropdown_id);
        $.ajax({
            type: 'POST',
            url: 'php/ajax/add_production.php',
            data: {
                'item_name': e.options[e.selectedIndex].value,
                'quantity': document.getElementById(textbox_id).value,
                'building_id': building_id
            },
            dataType: 'json',
            success: function(data) {
                // Inform that the query was correctly executed
                var alert_div = $(".my_alerts").eq(0);
                alert_div.append("<div class='alert alert-success alert-dismissible fade show'>\n\
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>\n\
                    <p>Hemos añadido a cola la producción. </p>\n\
                  </div>");

                // Find a <table> element
                var table = document.getElementById(building_id+"_table");

                // Create an empty <tr> element and add it
                var row = table.insertRow(-1);

                // Insert new cells
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);

                // Add some text to the new cells:
                cell1.innerHTML = e.options[e.selectedIndex].value;
                cell2.innerHTML = document.getElementById(textbox_id).value;
                cell3.innerHTML = "<button id="+data.prod_id+" onclick='delete_prod("+data.prod_id+")'>Cancel</button>";
                
                // Add some style
                cell2.classList.add("right_td");
                cell3.classList.add("centered_td");
            }
        });
    });
};

function delete_prod(prod_id){
    $(document).ready(function(){
        // Run the AJAX query
        $.ajax({
            type: 'POST',
            url: 'php/ajax/cancel_prod.php',
            data: {
                'prod_id': prod_id,
            },
            success: function(data) {
                if (data === "success"){
                    var row = document.getElementById('row_'+prod_id);
                    row.parentNode.removeChild(row);
                }
            }
        });
    });
};


