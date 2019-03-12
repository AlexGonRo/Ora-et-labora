$(document).ready(function(){

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var my_form = document.getElementById('registration_form');

    // Loop over them and prevent submission if necessary
    my_form.addEventListener('submit', function(event) {
      if (my_form.checkValidity() === false) {
        event.preventDefault();
        event.stopPropagation();
      }
      my_form.classList.add('was-validated');
    }, false);

});