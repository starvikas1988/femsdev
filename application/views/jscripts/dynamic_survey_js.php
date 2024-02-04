<script>

$(document).ready(function(){
    
	var baseURL="<?php echo base_url();?>";
	
	$("#fclient_id").change(function(){
		var client_id=$(this).val();
		populate_process_combo(client_id,'','fprocess_id','Y');	
	});
	
	
///////////////////	
});

</script>


<script>
	 $(document).ready(function () {
      $('.select-box').selectize({
          sortField: 'text'
      });
  });
  
</script>

<script>
$(function() {
var allowedRange = 1;
  $(".repeat").on('click', function(e) {
	const final = 11; 

	if(allowedRange < final){
		// console.log(allowedRange);
        if(allowedRange == 1 ){
			$('#submit_survey').prop("disabled", false).removeClass("disabled"); 
		}
		var c = $('.base-group').clone();
		var b = c.addClass("child-group");
		b.removeClass('base-group');
		b.css('display','block');
		b.find("input[type='text']").attr("name", "q"+ allowedRange).attr("id", "i"+ allowedRange).prop('required',true);
		// b.find("input[type='text']").prop('required',true);
		b.find("input[type='checkbox']").attr("name", "c"+ allowedRange);

		$("#main-form").append(c);
		allowedRange += 1;

	}
	
  });
});	
</script>


<script type="text/javascript">
	document.querySelector("#req_no_position").addEventListener("keypress", function (evt) {
    if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)
    {
        evt.preventDefault();
    }
});
</script>

<script>

	 $(document).ready(function () {
		var baseURL ="<?php echo base_url(); ?>";

		$(".edit-btn").click(function(){
			var title = $(this).data('title');
			$('#modal_title').text(title);
			var sid = $(this).data('sid');
			$('#sid').val(sid);
		});

		$("#client").select2();
        $("#process").select2();
        $("#department").select2();
        $("#location").select2();
		$("#client").change(function(){
       		 var clients = $('#client').val(); 
			$.ajax({
				type: 'GET',    
				url:baseURL+'master/get_process_by_clients',
				data:'clients='+ clients,
				success: function(data){
					var res;
					var i=0;
					var a = JSON.parse(data); 
					
					var b = $("#process").val();
					$("#process option").remove();
				
					if(b != null){ 
						var res =  b.toString().split(',');
						var leng = res.length;
					}
					$.each(a, function(index,jsonObject){
						
						if( i < leng){
							if(jsonObject.id == res[i]){
									$("#process").append('<option value="'+jsonObject.id+'" selected="selected">' + jsonObject.name + '</option>');
									i++;
							}else{
								$("#process").append('<option value="'+jsonObject.id+'">' + jsonObject.name + '</option>');
							}
						}else{
							$("#process").append('<option value="'+jsonObject.id+'">' + jsonObject.name + '</option>');
						}
					});	
				}
			});
		});
      $('.select-box').selectize({
          sortField: 'text'
      });
  });
  
</script>