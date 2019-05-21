$(document).ready(function(){
 $("#dropdown_kitchen").select2({
  templateResult: formatOptions,
  templateSelection: formatOptions,
  width: '100%'
 });

});
 
function formatOptions (state) {
  if (!state.id) { return state.text; }
   var $state = $(
   '<span>' + state.element.attributes['data-rich'].value + '</span>'
  );
  return $state;
}