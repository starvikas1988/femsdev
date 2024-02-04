<script>
baseURL = "<?php echo base_url(); ?>";

$('select[name="permanent_address_confirm"]').on('change', function(){
	curVal = $(this).val();
	if(curVal == 'No'){
		$('.permanentDiv').hide();
		$('.permanentDivUpdate').show();
	} else {
		$('.permanentDivUpdate').hide();		
		$('.permanentDiv').show();
	}
});

$('select[name="present_address_confirm"]').on('change', function(){
	curVal = $(this).val();
	if(curVal == 'No'){
		$('.presentDiv').hide();
		$('.presentDivUpdate').show();
	} else {
		$('.presentDivUpdate').hide();
		$('.presentDiv').show();
	}
});

$('select[name="phone_no_confirm"]').on('change', function(){
	curVal = $(this).val();
	if(curVal == 'No'){
		$('.phoneDiv').hide();
		$('.phoneDivUpdate').show();
	} else {
		$('.phoneDivUpdate').hide();
		$('.phoneDiv').show();
	}
});

$('select[name="my_phone_no_confirm"]').on('change', function(){
	curVal = $(this).val();
	if(curVal == 'No'){
		$('.myphoneDiv').hide();
		$('.myphoneDivUpdate').show();
	} else {
		$('.myphoneDivUpdate').hide();
		$('.myphoneDiv').show();
	}
});

$('select[name="email_id_confirm"]').on('change', function(){
	curVal = $(this).val();
	if(curVal == 'No'){
		$('.emailDiv').hide();
		$('.emailDivUpdate').show();
	} else {
		$('.emailDivUpdate').hide();
		$('.emailDiv').show();
	}
});



	$(document).on("change","#u_pre_country,#u_per_country",function(){
		
		var country = $("option:selected", this).attr("cid");
		var adrs  =	$(this).data("adrs");		
		jQuery.ajax({
			url: baseURL+"profile/stateList",
			type	: 	'POST',
			data	:	{country:country},
			dataType:	"json",
			success	:	function(response){
					if(response.error == false)
					{
						if(response.state_list == "")
						{
							if(adrs == "pre")
							{
								$("#u_pre_state").empty();
								$("#u_pre_city").empty();
								$("#u_pre_state").append($('<option></option>').val('').html('--select--'));
								$("#u_pre_city").append($('<option></option>').val('').html('--select--'));
							}
							else
							{
								$("#u_per_state").empty();
								$("#u_per_city").empty();
								$("#u_per_state").append($('<option></option>').val('').html('--select--'));
								$("#u_per_city").append($('<option></option>').val('').html('--select--'));
							}
						}
						else
						{
							if(adrs == "pre")
							{
								$("#u_pre_state").empty();
								$("#u_pre_city").empty();
								$("#u_pre_state").append($('<option></option>').val('').html('--select--'));
								for (var i in response.state_list) 
								{
									$('#u_pre_state').append($('<option sid="'+response.state_list[i].id+'"></option>').val(response.state_list[i].name).html(response.state_list[i].name));
								}
								$("#u_pre_city").append($('<option></option>').val('').html('--select--'));
							}
							else
							{
								$("#u_per_state").empty();
								$("#u_per_city").empty();
								$("#u_per_state").append($('<option></option>').val('').html('--select--'));
								for (var i in response.state_list) 
								{
									$('#u_per_state').append($('<option sid="'+response.state_list[i].id+'" ></option>').val(response.state_list[i].name).html(response.state_list[i].name));
								}
								$("#u_per_city").append($('<option></option>').val('').html('--select--'));
								
								if($("#u_same_addr").is(':checked') == true)
								{
									$("#u_per_state").val($("option:selected", $("#u_pre_state")).val()).change();
								}
							}
						}
					}
			}
		});
		
		
	});
	
	$(document).on("change","#u_pre_state,#u_per_state",function(){
		//var state		=	$(this).val();
		
		var state = $("option:selected", this).attr("sid");
		//alert(state);
		
		var adrs		=	$(this).data("adrs");
		jQuery.ajax({
			url: baseURL+"profile/cityList",
			type	: 	'POST',
			data	:	{state:state},
			dataType:	"json",
			success	:	function(response){
					if(response.error == false)
					{
						$("#u_pre_city").attr("disabled",false);
						$("#u_per_city").attr("disabled",false);
						$("#u_pre_city_other").attr("disabled",true);
						$("#u_per_city_other").attr("disabled",true);
						if(response.city_list == "")
						{
							if(adrs == "pre")
							{
								$("#u_pre_city").empty();
								$("#u_pre_city").append($('<option></option>').val('').html('--select--'));
								$("#u_pre_city").append($('<option></option>').val('other').html('Other'));
							}
							else
							{
								$("#u_per_city").empty();
								$("#u_per_city").append($('<option></option>').val('').html('--select--'));
								$("#u_per_city").append($('<option></option>').val('other').html('Other'));
							}
						}
						else
						{
							if(adrs == "pre")
							{
								$("#u_pre_city").empty();
								$("#u_pre_city").append($('<option></option>').val('').html('--select--'));
								for (var i in response.city_list) 
								{
									$('#u_pre_city').append($('<option></option>').val(response.city_list[i].name).html(response.city_list[i].name));
								}
								$("#u_pre_city").append($('<option></option>').val('other').html('Other'));
							}
							else
							{
								$("#u_per_city").empty();
								$("#u_per_city").append($('<option></option>').val('').html('--select--'));
								for (var i in response.city_list) 
								{
									$('#u_per_city').append($('<option></option>').val(response.city_list[i].name).html(response.city_list[i].name));
								}
								$("#u_per_city").append($('<option></option>').val('other').html('Other'));
								if($("#u_same_addr").is(':checked') == true)
								{
									$("#u_per_city").val($("#pre_city").val()).change();
								}
							}
						}
					}
			}
		});
	});
	
	
	$(document).on("change","#u_pre_city,#u_per_city",function(){
		var adrs =	$(this).data("adrs");	
		if(adrs =="pre")
		{
			$("#u_pre_city_other").val("");
			if($(this).val()=="other")
			{
				$(this).attr("disabled",true);
				$("#u_pre_city_other").attr("disabled",false).attr("required",true);
			}
			else
			{
				$("#u_pre_city_other").attr("disabled",true).removeAttr("required");
			}
		}
		else
		{
			$("#u_per_city_other").val("");
			if($(this).val()=="other")
			{
				$(this).attr("disabled",true);
				$("#u_per_city_other").attr("disabled",false).attr("required",true);
			}
			else
			{
				$("#u_per_city_other").attr("disabled",true).removeAttr("required");
			}
		}
		if($('#u_same_addr').is(':checked') == true && $('#pre_city').val() == "other")
		{
			$('#u_pre_city').attr("disabled",true);
			$("#u_pre_city_other").attr("disabled",false);
		}
	});


</script>