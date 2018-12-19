function hire_worker(){
   $(document).ready(function(){
       $.ajax({
           type: 'POST',
           url: 'php/ajax/hire_worker.php',
           data: {
           },
           dataType: "text",
           success: function(name) {
               var alert_div = $(".my_alerts").eq(0);
               alert_div.append("<div class='alert alert-success alert-dismissible fade show'>\n\
                       <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>\n\
                       <p><b>"+name+"</b> se ha unido a nosotros. En breve se recargará la página.</p>\n\
                     </div>");
               setTimeout(function(){window.location.replace("./workers.php");}, 5000);            

           }
       });
   });
};

