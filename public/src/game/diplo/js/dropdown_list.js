
$(document).ready(function(){
     // From https://www.hongkiat.com/blog/search-select-using-datalist/
     button = document.getElementById('datalist_button');
     datalist = document.getElementById('users_datalist');
     select = document.getElementById('select_username');
     options = select.options;

     button.addEventListener('click', toggle_ddl);

     function toggle_ddl(){
         /* if DDL is hidden */
         if(datalist.style.display === ''){
             /* show DDL */
             datalist.style.display = 'block';
             this.textContent="\u25B2";
             var val  = input.value;
             for(var i=0; i<options.length; i++) {
                 if ( options[i].text === val ) {
                     select.selectedIndex = i;
                     break;
                 }
             }
         }
         else {
             hide_select()
         };
     }

     /* when user selects an option from DDL, write it to text field */
     select.addEventListener('change',fill_input);
     function fill_input(){
         input.value = options[this.selectedIndex].value;
         hide_select();
     }

     /* when the user wants to type into text field, hide DDL */
     input = document.querySelector('input');
     input.addEventListener('focus', hide_select);
     function hide_select(){
         /* hide DDL */
         datalist.style.display = '';
         button.textContent="\u25BC";
     }


})
