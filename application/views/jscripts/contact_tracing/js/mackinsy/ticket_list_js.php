<script>
	function delete_case(id){

		if (confirm('Are you sure ?')) {
        	$.ajax({
			  url: "<?php echo base_url() ?>/mck/delete",
			  type:'GET',
			  cache: false,
			  data:"case_id="+id,
			  success: function(res){
			    alert('Data Deleted Successfully');
			    location.reload(true); 
			  }
			});
		}else
		{
		   alert('cancel')
		}
		/**/
	}
	function close_case(id){
		if (confirm('Are you sure ?')) {
			$.ajax({
			url: "<?php echo base_url() ?>/mck/close_case",
			type:'GET',
			cache: false,
			data:"case_id="+id,
			success: function(res){
				alert('Case Close Successfully');
				location.reload(true); 
				}
			});
		}else
		{
		//alert('cancel')
		}
		/**/
	}
	function open_edit_form(){
		$('#edit_frm input,select,textarea').prop("disabled","");
		$('#clon_client_function').css('display','block');
		$('#clon_coll_function').css('display','block');
		$('#update_btn').css('display','block');
	}
	
</script>