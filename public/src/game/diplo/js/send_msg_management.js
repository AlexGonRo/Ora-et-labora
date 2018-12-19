// Validate submission-

 function validate_msg(){
     var msg_select = document.getElementById("msg_type")
     var msg_type = msg_select.options[msg_select.selectedIndex].value;
     // If submission is a message
     if (msg_type === 'message'){
         // Check that receiver has been filled
         var msg_ben = document.getElementById("msg_beneficiary").value
         if (msg_ben != ''){
             // We are good to go
             return true;
         } else {
             var alert_div = $(".my_alerts").eq(0);
             alert_div.append("<div class='alert alert-danger alert-dismissible fade show'>\n\
                     <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>\n\
                     <p>El nombre del destinatario no puede estar en blanco.</p>\n\
                   </div>");
             return false;
         }

     }
 }

// Let's listen for when the message type changes

$(document).ready(function() {  
    $('#msg_type').change(function(){
        var selected = $(this).find("option:selected").attr('value');     
        if (selected == 'message'){
            document.getElementById('msg_content').hidden = false;
            document.getElementById('treaty_content').hidden = true;
        } else if (selected == 'treaty'){
            document.getElementById('msg_content').hidden = true;
            document.getElementById('treaty_content').hidden = false;
        }
    });
});

            



