

function next_tutorial(){
    $(document).ready(function(){
        // Run the AJAX query
        $.ajax({
            url: 'php/ajax/next_tutorial.php',
            success: function(response) {
                
            }
        });
    });
}
