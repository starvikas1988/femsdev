<script>
function displayteam(a, id)
{
	var baseURL = "<?php echo base_url(); ?>";
	var parentid  = $(a).attr("parentid");
	var parentname = $(a).attr("parentname");
	$(a).closest('tr').addClass("highlightedtr");
	$(a).hide();
	var rURL = baseURL+'hierarchy/getallteam';
	$('#sktPleaseWait').modal('show');
	$.ajax({
	   type: 'GET',    
	   url:rURL,
	   data:'uid='+id +'&pid='+parentid,
	   success: function(response){
			$(a).closest('tr').after(response);
			$('#sktPleaseWait').modal('hide');
		},
		error: function(){	
			alert('Fail!');
			$('#sktPleaseWait').modal('hide');
		}
	  });
	
	$("tr").removeClass("blurremovenow");
    $("tr").addClass("bluritnow");	
	$('#view'+parentid).removeClass("bluritnow");
	$('#view'+parentid).addClass("blurremovenow");
	  
}

function closeteam(a,hider, shower)
{
	$("[id='"+hider+"']").hide();
	$('#'+shower).show();
	$('#'+shower).closest('tr').removeClass("highlightedtr");
	$('#'+shower).closest('tr').addClass("initialtrmore");
	$("tr").removeClass("bluritnow");
	$("tr").removeClass("blurremovenow");
}

function closeteami(a,hider, shower)
{
	$("[id='"+hider+"']").hide();
	$('#'+shower).show();
	$('#'+shower).closest('tr').removeClass("highlightedtr");
	$('#'+shower).closest('tr').addClass("finaltr");
	$("tr").removeClass("bluritnow");
	$("tr").removeClass("blurremovenow");
}




// OPEN VIEW MODAL
$(".viewmodalclick").click(function(){
    baseURL = "<?php echo base_url(); ?>";
	var clickid =$(this).attr("sourceid");
	$('#modaldocview').modal('show');
	$('.docbodymodal').html('');
	//alert(params);
	$.ajax({
	   type: 'GET',    
	   url: baseURL+'hierarchy/getdownline',
	   data:'uid='+ clickid,
	   success: function(data){
			$('.docbodymodal').html(data);
		},
		error: function(){
			alert('Fail!');
		}
	});
	
});


// INITIALIZE SCROLL
intscroll();
function intscroll()
{
	var devid = 2;
	var scroll = $('.hv-container')[1].scrollWidth;
	var width = $('.hv-container').width();
	if(scroll >= 3000){ devid = 2.5; width = scroll; }
	var mywidth = width/devid;
	$('.hv-container').scrollLeft(mywidth);
}



</script>