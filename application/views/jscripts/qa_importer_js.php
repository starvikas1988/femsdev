<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<script>	
	 $(document).ready(function () {
		 //alert("Hi");
      /* $('.select-box').selectize({
          sortField: 'text'
      }); */
	  
	  /* 23-05-23 */
	  $(document).on('click', '.computeAgainModal', function(){
		bid = $(this).attr('bid');
		cid = $(this).attr('cid');
		pid = $(this).attr('pid');
		bUrl = '<?php echo base_url(); ?>Impoter_xls/get_compute_details';
		$.ajax({
			type: 'POST',
			url: bUrl,
			data:{bid:bid,
				cid:cid,
				pid:pid},
			success: function(response) {
				$('#computeAgainModal .modal-body').html(response);
				$('#computeAgainModal').modal('show');			
			},
		});
		});
	  /* 23-05-23 */
	  
	  /* 23-05-23 */
	  $(document).on('click', '.computeDetailsModal', function(){
		 
		bid = $(this).attr('bid');
		cid = $(this).attr('cid');
		pid = $(this).attr('pid');
		
		bUrl = '<?php echo base_url(); ?>Impoter_xls/compute_details_condition';
		$.ajax({
			type: 'GET',
			url: bUrl,
			data:{bid:bid,
				cid:cid,
				pid:pid},
			success: function(response) {
				//console.log(response);
				$('#computeDetailsModal .modal-body').html(response);
				$('#computeDetailsModal').modal('show');			
			},
		});
		});
	  /* 23-05-23 */
	  
	  /*******************Load Process as per client*******************/
	  $("#client_id").on('change', function(){
		
		cid = $("#client_id").val();
		//alert(cid);
		var isAll = '';
		bUrl = '<?php echo base_url(); ?>Impoter_xls/processList';
		$.ajax({
			type: 'POST',
			url: bUrl,
			data:{
					cid:cid
				},
			success: function(pList) {
				console.log(pList);
				var json_obj = $.parseJSON(pList);
				console.log(json_obj);
							$('#pro_id').empty();
							$('#pro_id').append($('#pro_id').val(''));
							if (json_obj == "") {
								
							} else {
								 $('#pro_id').append($('<option></option>').val('').html(
									'-- Select --'));

								for (var i in json_obj) {
									$('#pro_id').append($('<option></option>').val(json_obj[i]
										.id).html(json_obj[i].name));
								}
								//$('#sktPleaseWait').modal('hide');
							}

								
			}
		});
		});
	  /*******************Load Process as per client*******************/
	  /////////////////////////////
	  
	  $(document).on('click', '.nonAuditableModal', function(){
    randID = $(this).attr('randID');
	cid = $(this).attr('cid');
	pid = $(this).attr('pid');
	disDate = $(this).attr('disDate');
	lob = $(this).attr('lob');
	
	bUrl = '<?php echo base_url(); ?>Impoter_xls/update_non_auditable';
	$.ajax({
		type: 'GET',
		url: bUrl,
		data:{
			randID :randID,
			cid: cid,
			pid: pid,
			disDate : disDate,
			lob:lob
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
		
		
		/////////////////////

	$(document).on('change','#upl_file',function(){
        var fileName = document.getElementById("upl_file").value;
        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile=="xlsx" || extFile=="xls"){
            //TO DO
        }else{
            alert("Only .xlsx files are allowed!");
			$('#upl_file').val("");
        }   
    });
		
	});
	
	
</script>


