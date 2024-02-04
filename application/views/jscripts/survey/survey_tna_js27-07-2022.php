<script>
$('.optionCircle').click(function(){
  vals = $(this).attr('val');
  updater = $(this).attr('update');
  $(this).closest('div.row').find('.optionCircle').removeClass('optionCircleActive');
  $('#'+updater).val(vals);
  $(this).addClass('optionCircleActive');
});
</script>