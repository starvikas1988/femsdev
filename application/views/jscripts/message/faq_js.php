<script>
var coll = document.getElementsByClassName("collapsible");
var i; 

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.maxHeight){
      content.style.maxHeight = null;
    } else {
      content.style.maxHeight = (content.scrollHeight + 10) + "px";
    } 
  });
}

Math.min($('.textarea').scrollHeight) + "px";
 
function myFunction(id) {
  var copyText = document.getElementById(id);
  copyText.select();
  document.execCommand("copy");
}

$('.text_area').click(function()
{
	
  $(this).select();
  document.execCommand("copy");
});

document.addEventListener("DOMContentLoaded", function(event) {
    var tas = document.getElementsByTagName('textarea');
    for (var i=0; i < tas.length; i++) {
        tas[i].style.height = (tas[i].scrollHeight+3) + 'px';
    }
});

</script>