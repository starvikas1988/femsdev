<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<script>	
	 $(document).ready(function () {
      $('.select-box').selectize({
          sortField: 'text'
      });
	  
	  /* 07-03-22 */
	  $(document).on('click', '.computeAgainModal', function(){
		bid = $(this).attr('bid');
		bUrl = '<?php echo base_url(); ?>Qa_randamiser/sx_get_compute_details';
		$.ajax({
			type: 'POST',
			url: bUrl,
			data:{bid:bid},
			success: function(response) {
				$('#computeAgainModal .modal-body').html(response);
				$('#computeAgainModal').modal('show');			
			},
		});
		});
	  /* 07-02-22 */
	  
	  /* 16-12-22 */
	  $(document).on('click', '.computeDetailsModal', function(){
		bid = $(this).attr('bid');
		cid = $(this).attr('cid');
		pid = $(this).attr('pid');
		bUrl = '<?php echo base_url(); ?>Qa_randamiser/compute_details_condition';
		$.ajax({
			type: 'POST',
			url: bUrl,
			data:{bid:bid,
				cid:cid,
				pid:pid},
			success: function(response) {
				$('#computeDetailsModal .modal-body').html(response);
				$('#computeDetailsModal').modal('show');			
			},
		});
		});
	  /* 16-12-22 */
	  
	  /////////////////////////////
	  
	  $(document).on('click', '.nonAuditableModal', function(){
    randID = $(this).attr('randID');
	cid = $(this).attr('cid');
	pid = $(this).attr('pid');
	disDate = $(this).attr('disDate');
  //alert(disDate);
	bUrl = '<?php echo base_url(); ?>qa_randamiser/update_non_auditable';
	$.ajax({
		type: 'GET',
		url: bUrl,
		//data: 'bid=' + bid + '&cid='+ cid +'&pid='+pid,
		data:{
			randID :randID,
			cid: cid,
			pid: pid,
			disDate : disDate
			},
		success: function(response) {
			$('#nonAuditableModal .modal-body').html(response);
			$('#nonAuditableModal').modal('show');			
		},
	});
	});
	  
	  /////////////////////////////
  });
</script>
<script>
$(function() {  
 $('#multiselect').multiselect();

 $('.multiple-select').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        }); 
});
</script>

<script>
	$('.upload input[type="file"]').on('change', function() {
  
  $('.upload-path').val(this.value.replace('C:\\fakepath\\', ''));

});
</script>

<script>	
	$(document).ready(function(){
		$("#compute_btn").click(function(){
			$(".loader-bg").show();
		});
		setTimeout(function() {
        $(".loader-bg").hide('blind', {}, 500)
    }, 5000);
	});
</script>


<script>	
	$(document).ready(function(){
		/* $("#uploadDate").change(function(){
			alert('abc xyz');
		}); */
		
		
		/* $("#uploadsubmitdata").click(function(){
			var file_name=$('#upl_file').val();
			alert(file_name);
			if(file_name!=""){
				$('#uploadsubmitdata').prop('disabled',true);
			}
		}); */
		
		/* $("#form_upload_data").submit(function (e) {
			alert();
			//$('#uploadsubmitdata').prop('disabled',true);
		}); */
		
		/* var URL='<?php echo base_url();?>Qa_sop_library/data_distribute_freshdesk';
		var win = window.open(URL, "foobar");
		win.location.reload(); */
		
		//alert();
		
		//window.location.reload();
		
	});
</script>


