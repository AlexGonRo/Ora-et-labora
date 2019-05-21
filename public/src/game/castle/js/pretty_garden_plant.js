$(document).ready(function(){
    $( "select" ).each(function( index ) {
        $(this).select2({
         templateResult: formatOptions,
         templateSelection: formatOptions
         //width: '100%'
        });
    });

});
 
function formatOptions (state) {
  if (!state.id) { return state.text; }
   var $state = $(
   "<span ><img src='../../../" + state.element.attributes['data-rich'].value +"' style='vertical-align: text-top;' height='16px' width='16px' /> " + state.text + "</span>"
  );
  return $state;
}