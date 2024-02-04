<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	
	$("#from_date").datepicker();
	$("#assign_qa").select2();
	
	$('#docu_upl').change(function () {
		var ext = this.value.match(/\.(.+)$/)[1];switch (ext) {
			case 'xlsx':
				$('#uploadButton').attr('disabled', false);
				break;
			default:
				alert('This is not an allowed file type.');
				this.value = '';
		}
	});
	
// open the bucket in a popup with data
	$(document).on('click', '.bucketEdit', function(){
    bid = $(this).attr('bid');
	cid = $(this).attr('cid');
	pid = $(this).attr('pid');
  
	bUrl = '<?php echo base_url(); ?>qa_agent_categorisation/get_bucket_details';
	$.ajax({
		type: 'GET',
		url: bUrl,
		//data: 'bid=' + bid + '&cid='+ cid +'&pid='+pid,
		data:{
			bid :bid,
			cid: cid,
			pid: pid
			},
		success: function(response) {
			$('#editBucketModal .modal-body').html(response);
			$('#editBucketModal').modal('show');			
		},
	});
	});
	
	// open the bucket in a popup with data for SX
	$(document).on('click', '.sxBucketEdit', function(){
    bid = $(this).attr('bid');
  
	bUrl = '<?php echo base_url(); ?>qa_agent_categorisation/sx_get_bucket_details';
	$.ajax({
		type: 'GET',
		url: bUrl,
		data: 'bid=' + bid,
		success: function(response) {
			$('#sxEditBucketModal .modal-body').html(response);
			$('#sxEditBucketModal').modal('show');			
		},
	});
	});
	
	// Update score Js script
	$('#update_score').click(function(){
	 
	  var checkboxes = document.getElementsByTagName('input');
	  var checkboxCount=0;
	  for (var i = 0; i < checkboxes.length; i++) {
		  
             if (checkboxes[i].type == 'checkbox') {
				 if(checkboxes[i].checked ==true){
					checkboxCount++;
				 }
             }
         }
		 checkboxCount = checkboxCount-1;
		 if(checkboxCount>0){
			$('#form_category_list').submit(); 
		 }else{
			 alert("Please select at least one from the list.");
		 }
		
	});
	
	// SX Update score Js script
	$('#sx_update_score').click(function(){
	 
	  var checkboxes = document.getElementsByTagName('input');
	  var checkboxCount=0;
	  for (var i = 0; i < checkboxes.length; i++) {
		  
             if (checkboxes[i].type == 'checkbox') {
				 if(checkboxes[i].checked ==true){
					checkboxCount++;
				 }
             }
         }
		 //console.log(checkboxCount);
		 //checkboxCount = checkboxCount-1;
		 if(checkboxCount>0){
			$('#form_sx_category_list').submit(); 
		 }else{
			 alert("Please select at least one from the list.");
		 }
		
	});

	// Assign QA to Agent
	$('#set_qa').click(function(){
	 
	 var checkboxes = document.getElementsByTagName('input');
	 var checkboxCount=0;
	 for (var i = 0; i < checkboxes.length; i++) {
		 
			if (checkboxes[i].type == 'checkbox') {
				if(checkboxes[i].checked ==true){
				   checkboxCount++;
				}
			}
		}
		//console.log(checkboxCount);
		//checkboxCount = checkboxCount-1;
		if(checkboxCount>0){
			 var qa_id = document.getElementById('assign_qa').value;
			//alert(qa_id);
			$('#qa_id').val(qa_id);
		   $('#form_sx_category_list').submit(); 
		}else{
			alert("Please select at least one from the list.");
		}
	   
   });

	// assign as per bucket
	$('#bucket_dr').on('change',function(){
		var bucket = $('#bucket_dr').val();
		if (bucket!='') {
			$("#set_with_cq").prop("disabled", true);
		}else{
			$("#set_with_cq").prop("disabled", false);
		}
		$('#selected_bucket').val(bucket);
	   
   });
	
	$('#set_new_agent_target').click(function(){
	 
	  var checkboxes = document.getElementsByTagName('input');
	  var checkboxCount=0;
	  for (var i = 0; i < checkboxes.length; i++) {
		  
             if (checkboxes[i].type == 'checkbox') {
				 if(checkboxes[i].checked ==true){
					checkboxCount++;
				 }
             }
         }
		 checkboxCount = checkboxCount-1;
		 if(checkboxCount>0){
			$('#form_new_agent_list').submit(); 
		 }else{
			 alert("Please select at least one from the list.");
		 }
		
	});
	
});

function checkAll(ele) {
	
     var checkboxes = document.getElementsByTagName('input');
     if (ele.checked) {
         for (var i = 0; i < checkboxes.length; i++) {
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = true;
             }
         }
     } else {
         for (var i = 0; i < checkboxes.length; i++) {
             //console.log(i)
             if (checkboxes[i].type == 'checkbox') {
                 checkboxes[i].checked = false;
             }
         }
     }
 }
 
 function getTarget(val,field_id){
	// alert(val);
	 var bucketID = val;
	 var i = field_id;
	 var URL = '<?php echo base_url();?>qa_agent_categorisation/getTarget';
	  $.ajax({
            type: 'POST',
            url: URL,
		    data: {
				bucketID: bucketID				
			},
            success: function(target) {
				var result = $.parseJSON(target);
				$('#bucket_name_'+field_id).val(result.bucket_name);
				document.getElementById(`bucket_target_${field_id}`).setAttribute("value",result.bucket_target);
            },
            error: function() {
                alert('Fail!');
            }
        });
 }
 function getTargetOJT(val,field_id,tenure){
	// alert(val);
	 var bucketID = val;
	 var i = field_id;
	 var URL = '<?php echo base_url();?>qa_agent_categorisation/getTargetOJT';
	  $.ajax({
            type: 'POST',
            url: URL,
		    data: {
				bucketID: bucketID,
				tenure: tenure
			},
            success: function(target) {
				var result = $.parseJSON(target);
				$('#bucket_name_'+field_id).val(result.bucket_name);
				document.getElementById(`bucket_target_${field_id}`).setAttribute("value",result.calTarget)
            },
            error: function() {
                alert('Fail!');
            }
        });
 }
</script>


<script>
	$('.upload input[type="file"]').on('change', function() {
		$('.upload-path').val(this.value.replace('C:\\fakepath\\', ''));
	});
</script>


<script>	
	$(document).ready(function(){
		$("#uploadsubmitdata").click(function(){
			$(".loader-bg").show();
		});
		setTimeout(function() {
			$(".loader-bg").hide('blind', {}, 500)
		}, 5000);
		
	//////////
		
		$(".btnClickLoader").click(function(){
			$(".loader-bg").show();
		});
		setTimeout(function() {
			$(".loader-bg").hide('blind', {}, 500)
		}, 5000);
		
	});
</script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.js"></script>
<script>
	$(function()
	{
		$("#form_create_bucket").validate(
		{
		rules: 
			{
		bucket_name : {
		required: true
		},
		target_per_month : {
		required: true
		}
			}
		}
		);	
	});
</script>
<script>
	function deletefunc(id,cid,pid){
	if (confirm('Are you sure?')) {
	var id = id;
	var cid= cid;
	var pid= pid;
	var URL = '<?php echo base_url();?>Qa_agent_categorisation/delete_record';
	  $.ajax({
            type: 'POST',
            url: URL,
		    data: {
				id: id,		
				cid: cid,
				pid: pid
			},
			success:function(){
				alert('Bucket deleted successfully!');
				location.reload();
			},
			error: function() {
                alert('Fail!');
            }
		});
	} else {
		return false;
	}
	}
</script>