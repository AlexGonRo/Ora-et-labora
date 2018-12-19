function rm_msg(){
    $(document).ready(function(){
        var checkboxes = document.getElementsByTagName('input');
         var checked = [];
          for(var i = 0; i < checkboxes.length; i++) {
              if(checkboxes[i].checked === true) {
                  checked.push(checkboxes[i].value);
              }
          }

          $.ajax({
              type: "POST",
              data: {'checked_msgs': checked},
              url: "php/ajax/rm_msg_sent.php",
              success: function(msg){
                  for(var i = 0; i < checked.length; i++) {
                      var row = document.getElementById(checked[i]+'_row');
                      row.parentNode.removeChild(row);
                  }
              }
          });
    });

}
