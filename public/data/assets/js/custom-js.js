$(document).ready(function() {
  $('.film td').hide();
  $('th').click(function() {
    $(this).parents('table').find('td').toggle();
  });
});