<script>
$(".employee_assets").click(function(){
	var c_id=$(this).attr("c_id");
	var datas = {c_id:c_id};
	var request_url = "<?php echo base_url('Dfr_can_assets/dfr_assets_view'); ?>";
	process_ajax(function(response)
	{
		var res = JSON.parse(response);
		if (res.stat == true) 
		{
			if (res.datas[0].email_id_hr == 1) {
				var email_id_hr = '<span style="color: green">Yes</span>';
				if (res.datas[0].email_id_it_team == null) { var email_id_it_team = ' | Status: <span style="color: red">Not Provided</span>'; }
					else { var email_id_it_team = ' | Status: <span style="color: green">Provided</span> ('+res.datas[0].email_id_it_team+')' ; }
			}
			else { var email_id_hr = '<span style="color: red">No</span>'; var email_id_it_team = ""; }
			///////
			if (res.datas[0].assets_details_hr == "Not Required") {
				var assets_details_hr = '<span style="color: red">Not Required</span>';
				var assets_details_it_team = "";
			}
			else {
				var assets_details_hr = '<span style="color: green">'+res.datas[0].assets_details_hr+'</span>';
				if (res.datas[0].assets_details_it_team == 1) { var assets_details_it_team = ' | Status: <span style="color: green">Provided</span>'; }
				else { var assets_details_it_team = ' | Status: <span style="color: red">Not Provided</span>'; }
			}
			//////////
			if (res.datas[0].domain_id_hr == 1) {
				var domain_id_hr = '<span style="color: green">Yes</span>';
				if (res.datas[0].domain_id_it_team == null) { var domain_id_it_team = ' | Status: <span style="color: red">Not Provided</span>'; }
					else { var domain_id_it_team = ' | Status:<span style="color: green">Provided</span> ('+res.datas[0].domain_id_it_team+')'; }
			}
			else { var domain_id_hr = '<span style="color: red">No</span>'; var domain_id_it_team = ""; }
			////////
			if (res.datas[0].mouse_hr == 1) {
				var mouse_hr = '<span style="color: green">Yes</span>';
				if (res.datas[0].mouse_it_team == 0) { var mouse_it_team = ' | Status: <span style="color: red">Not Provided</span>'; }
					else { var mouse_it_team = ' | Status: <span style="color: green">Provided</span>'; }
			}
			else { var mouse_hr = '<span style="color: red">No</span>'; var mouse_it_team = ""; }
			////////			
			if (res.datas[0].keyboard_hr == 1) {
				var keyboard_hr = '<span style="color: green">Yes</span>';
				if (res.datas[0].keyboard_it_team == 0) { var keyboard_it_team = ' | Status: <span style="color: red">Not Provided</span>'; }
					else { var keyboard_it_team = ' | Status: <span style="color: green">Provided</span>'; }
			}
			else { var keyboard_hr = '<span style="color: red">No</span>'; var keyboard_it_team = ""; }
			////////
			if (res.datas[0].headset_hr == 1) {
				var headset_hr = '<span style="color: green">Yes</span>';
				if (res.datas[0].headset_it_team == 0) { var headset_it_team = ' | Status: <span style="color: red">Not Provided</span>'; }
					else { var headset_it_team = ' | Status: <span style="color: green">Provided</span>'; }
			}
			else { var headset_hr = '<span style="color: red">No</span>'; var headset_it_team = ""; }


			var remarks = (res.datas[0].remarks == null) ? "" : res.datas[0].remarks;

			 //$('.section_employee_assets_status').html('<h4>Email ID Required: '+email_id_hr+''+email_id_it_team+'</h4> <h4>Domain ID Required: '+domain_id_hr+''+domain_id_it_team+'</h4> <h4>Assets: '+assets_details_hr+''+assets_details_it_team+'</h4> <h4>Mouse Required: '+mouse_hr+''+mouse_it_team+'</h4> <h4>Keyboard Required: '+keyboard_hr+''+keyboard_it_team+'</h4> <h4>Headset Required: '+headset_hr+''+headset_it_team+'</h4> <hr> <p>Remarks: '+remarks+'</p>');

			$('.section_employee_assets_status').html('<table class="table table-striped table-responsive"><thead><tr><th>Email ID Required</th><th>Domain ID Required</th><th>Assets</th><th>Mouse Required</th><th>Keyboard Required</th><th>Headset Required</th></tr></thead><tbody><tr><td>'+email_id_hr+''+email_id_it_team+'</td><td>'+domain_id_hr+''+domain_id_it_team+'</td><td>'+assets_details_hr+''+assets_details_it_team+'</td><td>'+mouse_hr+''+mouse_it_team+'</td><td>'+keyboard_hr+''+keyboard_it_team+'</td><td>'+headset_hr+''+headset_it_team+'</td></tr></tbody></table><hr> <p>Remarks: '+remarks+'</p>');	
					

			$('.section_employee_assets_form').attr({style: "display: none"});
		 	$('.section_employee_assets_status').attr({style: "display: block"});
		 	$('#employee_assets_model #verify_submit_btn').attr({type: "hidden"});

		 	
		}
		else {
		 	$('.section_employee_assets_form').attr({style: "display: block"});
		 	$('.section_employee_assets_status').attr({style: "display: none"});
		 	$('#employee_assets_model #verify_submit_btn').attr({type: "submit"});
		 	$('.section_employee_assets_form_submit #c_id').val(c_id);
		}
				
	},request_url, datas, 'text');	

	$('#employee_assets_model').modal('show');
	
});	
</script>

<script>
$(".section_employee_assets_form_submit").submit(function(e) {
    e.preventDefault();

    var email_id = $(".section_employee_assets_form_submit #email_id").val();
    var domain_id = $(".section_employee_assets_form_submit #domain_id").val();
    var assests = $(".section_employee_assets_form_submit #assests").val();
    var mouse = $(".section_employee_assets_form_submit #mouse").val();
    var Keyboard = $(".section_employee_assets_form_submit #Keyboard").val();
    var headset = $(".section_employee_assets_form_submit #headset").val();
    var c_id = $(".section_employee_assets_form_submit #c_id").val();

    if (email_id=="" || domain_id=="" || assests=="" || c_id=="" || mouse=="" || headset=="" || Keyboard=="" ) { alert("Please select mandetory fileds"); }
    else {
		var datas = {email_id:email_id, domain_id:domain_id, assests:assests, c_id:c_id , mouse:mouse, headset:headset, Keyboard:Keyboard};
		var request_url = "<?php echo base_url('Dfr_can_assets/dfr_candidate_assets_submit'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if (res.stat == true) 
			{
				$('#employee_assets_model').modal('hide');
				$('.section_employee_assets_form_submit')[0].reset();

			}
			else {
				alert("Please try later!");
			}
					
		},request_url, datas, 'text');	
    }
    
});	
</script>

<script>
$(".assets_update_it_team").click(function(){
	var c_id=$(this).attr("c_id");
	var datas = {c_id:c_id};
	var request_url = "<?php echo base_url('Dfr_can_assets/dfr_assets_view'); ?>";
	process_ajax(function(response)
	{
		var res = JSON.parse(response);
		if (res.stat == true) 
		{
			var assets_it_config = "";

			if (res.datas[0].email_id_hr == 1) {
				var email_id_hr = '<span style="color: green">Yes</span>';
				if (res.datas[0].email_id_it_team == null) {
					var email_id_it_team = '<input pattern="[^ @]*@[^ @]*" type="email" placeholder="Enter Email ID" name="email_id_it_team" id="email_id_it_team" class="form-control">';
				}
				else { var email_id_it_team = '<h5>Status: <span style="color: green">Provided ('+res.datas[0].email_id_it_team+')</span></h5>'; }

			}
			else { var email_id_hr = '<span style="color: red">No</span>'; var email_id_it_team = ''; }
			////////
			if (res.datas[0].domain_id_hr == 1) {
				var domain_id_hr = '<span style="color: green">Yes</span>';
				if (res.datas[0].domain_id_it_team == null) {
					var domain_id_it_team = '<input maxlength="150" type="text" placeholder="Enter Domain ID" name="domain_id_it_team" id="domain_id_it_team" class="form-control">';
				}
				else { var domain_id_it_team = '<h5>Status: <span style="color: green">Provided ('+res.datas[0].domain_id_it_team+')</span></h5>'; }

			}
			else { var domain_id_hr = '<span style="color: red">No</span>'; var domain_id_it_team = ''; }
			///////
			if (res.datas[0].assets_details_hr == "Not Required") {
				var assets_details_hr = '<span style="color: red">Not Required</span>';
				var assets_details_it_team = '';
			}
			else {
				var assets_details_hr = '<span style="color: green">'+res.datas[0].assets_details_hr+'</span>';
				if (res.datas[0].assets_details_it_team == 1) {
					var assets_details_it_team = '<h5>Status: <span style="color: green">Provided</span></h5>';
					if (res.datas[0].assets_it_config != null) { assets_it_config += '<h5>Assets Configuartion: '+res.datas[0].assets_it_config+'</h5>' }
				}
				else { var assets_details_it_team = '<select class="form-control" name="assets_details_it_team" id="assets_details_it_team"><option value="" selected>--Select Option--</option><option value="1">Provided</option><option value="0">Not Provided</option></select> <input maxlength="150" style="margin-top: 10px;" type="text" placeholder="Enter Assets Configuartion" name="assets_it_config" id="assets_it_config" class="form-control">'; }
			}
			////////
			if (res.datas[0].mouse_hr == 1) {
				var mouse_hr = '<span style="color: green">Yes</span>';
				if (res.datas[0].mouse_it_team == 1) {
					var mouse_it_team = '<h5>Status: <span style="color: green">Provided</span></h5>';
				if (res.datas[0].mouse_it_config != null) { assets_it_config += '<h5>Mouse Details: '+res.datas[0].mouse_it_config+'</h5>' }					
				}
				else { var mouse_it_team = '<select class="form-control" name="mouse_it_team" id="mouse_it_team"><option value="" selected>--Select Option--</option><option value="1">Provided</option><option value="0">Not Provided</option></select> <input maxlength="150" style="margin-top: 10px;" type="text" placeholder="Enter Mouse Configuartion" name="mouse_it_config" id="mouse_it_config" class="form-control">'; }
			}
			else { var mouse_hr = '<span style="color: red">No</span>'; var mouse_it_team = ''; }
			/////////
			if (res.datas[0].keyboard_hr == 1) {
				var keyboard_hr = '<span style="color: green">Yes</span>';
				if (res.datas[0].keyboard_it_team == 1) {
					var keyboard_it_team = '<h5>Status: <span style="color: green">Provided</span></h5>';
				if (res.datas[0].keyboard_it_config != null) { assets_it_config += '<h5>Keyboard Details: '+res.datas[0].keyboard_it_config+'</h5>' }					
				}
				else { var keyboard_it_team = '<select class="form-control" name="keyboard_it_team" id="keyboard_it_team"><option value="" selected>--Select Option--</option><option value="1">Provided</option><option value="0">Not Provided</option></select> <input maxlength="150" style="margin-top: 10px;" type="text" placeholder="Enter Keyboard Configuartion" name="keyboard_it_config" id="keyboard_it_config" class="form-control">'; }
			}
			else { var keyboard_hr = '<span style="color: red">No</span>'; var keyboard_it_team = ''; }
			/////////
			if (res.datas[0].headset_hr == 1) {
				var headset_hr = '<span style="color: green">Yes</span>';
				if (res.datas[0].headset_it_team == 1) {
					var headset_it_team = '<h5>Status: <span style="color: green">Provided</span></h5>';
				if (res.datas[0].headset_it_config != null) { assets_it_config += '<h5>Headset Details: '+res.datas[0].headset_it_config+'</h5>' }					
				}
				else { var headset_it_team = '<select class="form-control" name="headset_it_team" id="headset_it_team"><option value="" selected>--Select Option--</option><option value="1">Provided</option><option value="0">Not Provided</option></select> <input maxlength="150" style="margin-top: 10px;" type="text" placeholder="Enter Headset Configuartion" name="headset_it_config" id="headset_it_config" class="form-control">'; }
			}
			else { var headset_hr = '<span style="color: red">No</span>'; var headset_it_team = ''; }			

			var remarks = (res.datas[0].remarks == null) ? "<div class='col-md-7'><h5 style='font-weight: 600;''>Remarks:</h5><textarea maxlength='300' placeholder='Enter Remarks' id='remarks' name='remarks' class='form-control'></textarea></div>" : "<div class='col-md-7'><h5 style='font-weight: 600;''>7. Remarks:</h5><textarea maxlength='300' placeholder='Enter Remarks' id='remarks' name='remarks' class='form-control'>"+res.datas[0].remarks+"</textarea></div>";

			$('.section_assests_update_it_team').html('<div class="col-md-6"><h5 style="font-weight: 600;">1. Email ID Required: '+email_id_hr+'</h5>'+email_id_it_team+'</div> <div class="col-md-6"><h5 class="style_custom" style="font-weight: 600;">2. Domain ID Required: '+domain_id_hr+'</h5>'+domain_id_it_team+'</div> <div class="col-md-6"><h5 style="font-weight: 600;">3. Assets Required: '+assets_details_hr+'</h5>'+assets_details_it_team+'</div> <div class="col-md-6"><h5 style="font-weight: 600;">4. Mouse Required: '+mouse_hr+'</h5>'+mouse_it_team+'</div> <div class="col-md-6"><h5 style="font-weight: 600;">5. Keyboard Required: '+keyboard_hr+'</h5>'+keyboard_it_team+'</div> <div class="col-md-6"><h5 style="font-weight: 600;">6. Headset Required: '+headset_hr+'</h5>'+headset_it_team+'</div> <hr> '+remarks+' <hr> <div class="col-md-12"> '+assets_it_config+'</div>');

			$('.it_team_assets_form_submit #c_id').val(c_id);

		}
		else { alert('Please try later!'); }
	},request_url, datas, 'text');	

	$('#assets_update_it_team_model').modal('show');			
	
});	
</script>

<script>
$(".it_team_assets_form_submit").submit(function(e) {
    e.preventDefault();

	var datas = $(this).serializeArray();
	var request_url = "<?php echo base_url('Dfr_can_assets/dfr_candidate_assets_update_it_team'); ?>";

	pattern = /\S+@\S+\.\S+/;
	var email = $("#email_id_it_team").val();

	var email_test = pattern.test(email);

	if (email_test == true || email == null || email == "") { 
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if (res.stat == true) 
			{
				$('#assets_update_it_team_model').modal('hide');
				$('.it_team_assets_form_submit')[0].reset();
				window.location.reload();

			}
			else {
				alert("Nothing Update!");
			}
						
		},request_url, datas, 'text');	
	}
	else { alert('Enter Valid Email ID'); }	
    
});	
</script>