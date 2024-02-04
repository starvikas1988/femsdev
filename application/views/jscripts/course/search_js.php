
<script type="text/javascript">

$(document).ready(function(){
    
	var baseURL="<?php echo base_url();?>";
	
	$("#dept_id").change(function(){
		var dept_id=$('#dept_id').val();
		populate_sub_dept_combo(dept_id,'','sub_dept_id','Y');
	});

	
	
	
	$('.check_all').click(function () {
            if (this.checked) {

                $('.check_row').each(function () {
                    this.checked = true;
                });
            }

             else {
                $('.check_row').each(function () {
                    this.checked = false;
                }); 
             }  
        })
	
	


	$("#fclient_id").change(function(){
		
		var client_id=$(this).val();
		
		var rid=$.cookie('role_id'); 
		var dept_folder = $.cookie('dept_folder'); 
		
		if(rid<=1 || rid==6 || dept_folder=="hr"){
		
			if(client_id=="1"){
				$("#foffice_div").hide();
				$("#fsite_div").show();
				$("#foffice_id").val('ALL');
				
			}else{
				$("#fsite_div").hide();
				$("#foffice_div").show();
				$("#fsite_id").val('ALL');
			}
		}
		
		populate_process_combo(client_id,'','fprocess_id','Y');
		
	});
	
	$("#fprocess_id").change(function(){
				
		var pid=$(this).val();
		populate_sub_process_combo(pid,'','fsub_process_id','Y');
		
	});
	
});

	
// JAVASCRIPT (jQuery)
/* 
// Trigger action when the contexmenu is about to be shown
$(document).bind("contextmenu", function (event) {
    
    // Avoid the real one
    event.preventDefault();
    
	alert($('.imageid2').attr('data-id'));
    // Show contextmenu
    $(".custom-menu").finish().toggle(100).
    
    // In the right position (the mouse)
    css({
        top: event.pageY + "px",
        left: event.pageX + "px"
    });
}); */

/* 
// If the document is clicked somewhere
$(document).bind("mousedown", function (e) {
    
    // If the clicked element is not the menu
    if (!$(e.target).parents(".custom-menu").length > 0) {
        
        // Hide it
        $(".custom-menu").hide(100);
    }
});


// If the menu element is clicked
$(".custom-menu li").click(function(){
    
    // This is the triggered action name
    switch($(this).attr("data-action")) {
        
        // A case for each action. Your actions here
        case "first": alert("first"); break;
        case "second": alert("second"); break;
        case "third": alert("third"); break;
    }
  
    // Hide it AFTER the action was triggered
    $(".custom-menu").hide(100);
  });	 */
</script>

