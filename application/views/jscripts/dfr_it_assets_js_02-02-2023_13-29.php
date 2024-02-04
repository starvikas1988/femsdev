
<script>
$(document).on('click','#dfr_can_it_details',function(){

	var dfr_id = $(this).attr('dfr_id');
	var request_url = "<?php echo base_url('dfr_it_assets/dfr_assets_candidate_details'); ?>";
	var datas = {'dfr_id': dfr_id};
	process_ajax(function(response)
	{
		var res = JSON.parse(response);
		if (res.stat == true) 
		{
			var list = "";
			var button_access = "";
			var count = 1;
			var status = '<span style="color: #846300">In-progress</span>';
			$.each(res.datas,function(index,element)
			{
				let total_assets_provided = Number(res.non_inv_assets_provide[element.user_id])+Math.max(Number(res.inv_assets_provide[element.user_id]),Number(res.inv_assets_his[element.user_id]));

				if (element.assets_approve==element.assets_provide || element.assets_approve==total_assets_provided) { status = '<span style="color: green">Done</span>'; }
				//if (element.assets_approve > element.assets_provide || element.assets_approve > res.inv_assets_his[element.user_id]) { status = '<span style="color: #846300">In-progress</span>'; }
				if (element.assets_provide=='0' && res.inv_assets_his[element.user_id]=='0') { status = '<span style="color: red">Pending</span>'; }

				if (res.bgv[element.user_id] == true) { button_access = '<?php if(it_assets_full_access()==true){ ?><button type="button" class="btn btn-primary btn-xs model_users_assets" dfr_id="'+dfr_id+'" user_id="'+element.user_id+'" user_name="'+element.can_name+' ('+element.fusion_id+')" ><i class="fas fa-edit"></i></button><?php } ?>'; }

				else { button_access = '<span style="color: red;">BGV Pending</span>'; } 

				list += '<tr> <td>'+count+'</td> <td>'+element.can_name+'</td> <td>'+element.fusion_id+'</td> <td>'+element.office_name+'</td> <td>'+element.department_name+'</td> <td>'+element.role_name+'</td> <td>'+element.doj+'</td> <td>'+status+'</td> <td> '+button_access+' </td> </tr>';
				count++;
			});

			$('#dfr_request_user_'+dfr_id).html(list);
		}
		else {
			$('.it_assets_reponse_'+dfr_id).html('<h5 style="text-align: center;font-weight: bold;">Onbording in process</h5>');
		}
						
	},request_url, datas, 'text');
    
});
</script>

<script>
$(document).on('click','.model_users_assets',function(){

	var user_id = $(this).attr('user_id');
	var dfr_id = $(this).attr('dfr_id');
	var user_name = $(this).attr('user_name');

	var request_url = "<?php echo base_url('dfr_it_assets/dfr_user_assets_details'); ?>";
	var datas = {'user_id': user_id, 'dfr_id': dfr_id};

	process_ajax(function(response)
	{
		var res = JSON.parse(response);
		if (res.stat == true) 
		{
			var list = '<h2 class="popup-title">Name: '+user_name+'</h5>';
			var count = 1;

			var section_1 = "";
			var section_2 = "";
			var section_2_asset_model = '';
			var section_3 = "";

			$.each(res.datas,function(index,element)
			{
				var assets_id = element.assets_id;

				section_2_asset_model = '<option value="">---Select Serial No.---</option>';

				if (res.datas2[assets_id] != null || res.datas5[assets_id] != null) {

					if(element.is_inv == 1) {
						if (res.datas2[assets_id] != null && res.datas2[assets_id][0].comments != null) {
							section_2 = '<div class="col-sm-3"><p><span class="form-label">Remarks:</span> '+res.datas2[assets_id][0].comments+'<p></div>';
						}
						else {
							section_2 = '<div class="col-sm-3"><p><span class="form-label">Remarks:</span><p></div>';
						}
						if (res.datas2[assets_id] != null) {
							section_1 = '<div class="col-sm-3"><p><span class="form-label">Status: <span style="color: green">Provided </span></span><p></div>';
							section_3 = '<div class="col-sm-3"><p><span class="form-label">Serial Number: <span style="color: green">'+res.datas2[assets_id][0].serial_number+'</span></span></p></div><div class="col-sm-3"></div> <div class="col-sm-3"> <p><span class="form-label">Reference ID: <span style="color: green">'+res.datas2[assets_id][0].reference_id+' </span></span><p></div> <div class="col-sm-3"> <p><span class="form-label">Brand Name: <span style="color: green">'+res.datas2[assets_id][0].brand_name+' </span></span><p></div> <div class="col-sm-3"> <p><span class="form-label">Configuration/Details: <span style="color: green">'+res.datas2[assets_id][0].configuration+' </span></span><p></div>';
						}
						else {
							section_1 = '<div class="col-sm-3"><p><span class="form-label">Status: <span style="color: green">Provided </span></span><p></div>';
							section_3 = '<div class="col-sm-3"><p><span class="form-label">Serial Number: <span style="color: green">'+res.datas5[assets_id][0].serial_number+'</span></span></p></div><div class="col-sm-3"></div> <div class="col-sm-3"> <p><span class="form-label">Reference ID: <span style="color: green">'+res.datas5[assets_id][0].reference_id+' </span></span><p></div> <div class="col-sm-3"> <p><span class="form-label">Brand Name: <span style="color: green">'+res.datas5[assets_id][0].brand_name+' </span></span><p></div> <div class="col-sm-3"> <p><span class="form-label">Configuration/Details: <span style="color: green">'+res.datas5[assets_id][0].configuration+' </span></span><p></div>';
						}
					}
					else {
						if (res.datas2[assets_id] != null && res.datas2[assets_id][0].comments != null) {
							section_2 = '<div class="col-sm-3"><p><span class="form-label">Details:</span> '+res.datas2[assets_id][0].comments+'<p></div>';
						}
						else {
							section_2 = '<div class="col-sm-3"><p><span class="form-label">Details:</span><p></div>';
						}
						section_1 = '<div class="col-sm-3"><p><span class="form-label">Status: <span style="color: green">Provided </span></span><p></div>';
						section_3 = '';
					}
				}
				else {
					if(element.is_inv == 1) {
						if (res.datas3[assets_id] >= element.assets_required) {
							section_1 = '<div class="col-sm-6"><p><span class="form-label">Status: <span style="color:red;">Required Asset is '+element.assets_required+' (Assets filled up)</span></span><p></div>';
							section_2 = "";
							section_3 = "";			
						}
						else {
							if (res.datas4[assets_id] != null) {
								section_1 = '<div class="col-sm-3"><div class="form-group"> <select autocomplete="off" class="form-control select_stat_assets" date-inf="'+element.assets_id+'" name="select_stat[]" required> <option value="">Select Option</option> <option value="1">Provided</option> <option value="">Not Provided</option></select> </div><span class="stock_details_serial'+assets_id+'"> </span></div>';

								$.each(res.datas4[assets_id],function(index3,element3)
								{
									section_2_asset_model += '<option value="'+element3.id+'">'+element3.serial_number+' ('+element3.reference_id+')</option>';
								});
								section_2 = '<div class="col-sm-3"><select autocomplete="off" date-inf="'+assets_id+'" style="margin-bottom: 10px;" id="select_model_assets_click" name="select_model[]" class="selectpicker form-control select_model-'+assets_id+'" data-show-subtext="true" data-live-search="true" disabled required>'+section_2_asset_model+'</select> <span class="stock_details_conf'+assets_id+'"> </span></div>';

								section_3 = '<div class="col-sm-3"><div class="form-group"><input autocomplete="off" type="text" class="form-control select_comment-'+assets_id+'" placeholder="Comments Here" name="input_comment[]" disabled></div> <span class="stock_details_type'+assets_id+'"> </span></div> <input type="hidden" value="'+assets_id+'" name="assets_id[]" required> <input type="hidden" value="Yes" name="is_inv_asset[]" required>';
							}
							else {
								section_1 = '<div class="col-sm-3"><p><span class="form-label">Status: <span style="color: red">Not in Stock</span></span><p></div>';
								section_2 = "";
								section_3 = "";
							}
						}
					}
					else {

						if (res.datas3[assets_id] >= element.assets_required) {
							section_1 = '<div class="col-sm-6"><p><span class="form-label">Status: <span style="color:red;">Required Asset is '+element.assets_required+' (Assets filled up)</span></span><p></div>';
							section_2 = "";
							section_3 = "";			
						}
						else {
							section_1 = '<div class="col-sm-3"><div class="form-group"> <select autocomplete="off" class="form-control select_stat_assets" date-inf="'+element.assets_id+'" name="select_stat[]" required> <option value="">Select Option</option> <option value="1">Provided</option> <option value="">Not Provided</option></select> </div><span class="stock_details_serial'+assets_id+'"> </span></div>';
							section_2 = '<div class="col-sm-3"><div class="form-group"><input autocomplete="off" type="text" class="form-control select_comment-'+assets_id+'" placeholder="Assets Details" name="input_comment[]" disabled required></div> <span class="stock_details_type'+assets_id+'"> </span></div> <input type="hidden" value="'+assets_id+'" name="assets_id[]" required> <input type="hidden" value="No" name="is_inv_asset[]" required>';
							section_3 = "";
						}
						
					}
				}

				list += '<div class="repeat-area"><div class="row"> <div class="col-sm-3"><p><span class="form-label">'+count+'. '+element.assets_name+'</span><p></div>'+section_1+section_2+section_3+'</div></div>';

				count++;
			});

			$('#model_users_assets .user_assets_result').html(list+'<input type="hidden" value="'+user_id+'" name="user_id"> <input type="hidden" value="'+dfr_id+'" name="dfr_id">');
		}
		else {
			alert('No Assets are Approve!');
			$('#model_users_assets .user_assets_result').html('');
		}
						
	},request_url, datas, 'text');

	$('#model_users_assets').modal('show');
    
});
</script>

<script>
$(document).on('click','.edit_assets_add_assets',function(){

	var assets_id = $(this).attr('value');
	var assets_name = $(this).attr('assets_name');
	var url = "<?=base_url()?>dfr_it_assets/add_assets/change_name/"+assets_id+"";
	var url2 = "<?=base_url()?>dfr_it_assets/add_assets_brand/change_name/"+assets_id+"";
	var url3 = "<?=base_url()?>dfr_it_assets/add_ram/change_name/"+assets_id+"";
	var url4 = "<?=base_url()?>dfr_it_assets/add_storage/change_name/"+assets_id+"";
	var url5 = "<?=base_url()?>dfr_it_assets/add_phy_location/change_name/"+assets_id+"";
	var url6 = "<?=base_url()?>dfr_it_assets/add_assets_dept/change_name/"+assets_id+"";
	var url7 = "<?=base_url()?>dfr_it_assets/add_os/change_name/"+assets_id+"";
	var url8 = "<?=base_url()?>it_assets_support/add_sop_assets_category/change_name/"+assets_id+"";
	var url9 = "<?=base_url()?>dfr_it_assets/assets_user_assign_decline_mst/change_name/"+assets_id+"";
	var ur20 = "<?=base_url()?>dfr_it_assets/assets_company_brand_mst/change_name/"+assets_id+"";

	$('#update_assets_add_assets .rename').html(assets_name);
	$('#update_assets_add_assets #chnage_assets_add_assets').attr({action: url});
	$('#chnage_assets_add_assets_brand').attr({action: url2});
	$('#chnage_assets_add_assets_ram').attr({action: url3});
	$('#chnage_assets_add_assets_storage').attr({action: url4}); 
	$('#chnage_assets_add_assets_phy_location').attr({action: url5});
	$('#chnage_assets_add_assets_dpt').attr({action: url6});
	$('#chnage_assets_add_assets_os').attr({action: url7});
	$('#update_assets_category_sop').attr({action: url8});
	$('#chnage_assets_add_assets_user_declined').attr({action: url9});
	$('#chnage_assets_add_assets_master_com').attr({action: ur20});
	$('#update_assets_add_assets #assets_name').val(assets_name);

	$('#update_assets_add_assets').modal('show');
});
</script>

<script>
$(document).on('click','.dfr_assets_details_dashboard',function(){

	var dfr_id = $(this).attr('dfr_id'); 
	var ofc_location = $(this).attr('location'); 
	var Requisition_id = $(this).attr('req_id');
	var request_url = "<?=base_url()?>dfr_it_assets/dfr_assets_details_dashboard";
	var datas = {'dfr_id': dfr_id, 'location': ofc_location};

	process_ajax(function(response)
	{
		var res = JSON.parse(response);
		if (res.stat == true) 
		{
			var list = "";
			var count = 1;
			$.each(res.datas,function(index,element)
			{
				if(element.is_inv == 1) {
					var assets_req = element.assets_required;
					var in_stock_count = res.datas2[element.assets_id];
				}
				else {
					var assets_req = element.assets_required;
					var in_stock_count = "N/A";
				}

				list += '<tr><td scope="row">'+count+'</td><td>'+element.assets_name+'</td> <td>'+assets_req+'</td> <td>'+res.datas3[element.assets_id]+'</td> <td>'+in_stock_count+'</td>';
				count++;
				
			});

			$('#model_users_assets_details #dfr_assets_result').html(list);

			$('#model_users_assets_details .req_id_assets').text('Requisition ID: '+Requisition_id);
			$('#model_users_assets_details .total_can_assets').text('Total Candidate: '+res.datas4);
		}
		else {
			alert('No Assets are Approve!');
			$('#model_users_assets_details #dfr_assets_result').html('');
		}
						
	},request_url, datas, 'text');

	$('#model_users_assets_details').modal('show');

});
</script> 

<script>
$(document).on('click','#myModal-add-stock .total-stock-add',function(){

var add_total = $('#myModal-add-stock #stock_total').val();
var html = "";
if(add_total > 0) {
	var request_url = "<?php echo base_url('dfr_it_assets/get_master_data'); ?>";
	var datas = {'request': 'master_data'};
	process_ajax(function(response)
	{
		var res = JSON.parse(response);
		if (res.stat == true) 
		{
			var vnd_name_uppr;
			var list = '<option selected disable value="">Select an option</option>';
			var list2 = '<option selected disable value="">Select an option</option>';
			var list3 = '<option selected disable value="">Select an option</option>';
			var list4 = '<option selected disable value="">Select an option</option>';
			var list5 = '<option selected disable value="">Select an option</option>';
			var list6 = '<option selected disable value="">Select an option</option>';
			var list7 = '<option selected disable value="">Select an option</option>';
			$.each(res.datas_ram,function(index,element) { list += '<option value="'+element.id+'">'+element.size+'GB</option>'; });
			$.each(res.datas_storage_device,function(index,element) { list2 += '<option value="'+element.id+'">'+element.size+'</option>'; });
			$.each(res.datas_vendor,function(index,element) { vnd_name_uppr = element.vnd_name; list3 += '<option value="'+element.id+'">'+vnd_name_uppr.toUpperCase()+'</option>'; });
			$.each(res.datas_os,function(index,element) { list4 += '<option value="'+element.id+'">'+element.os_name+'</option>'; });
			$.each(res.datas_phy_location,function(index,element) { list5 += '<option value="'+element.id+'">'+element.location_name+'</option>'; });			
			$.each(res.datas_ast_department,function(index,element) { list6 += '<option value="'+element.id+'">'+element.assets_dpt_name+'</option>'; });
			$.each(res.datas_company_brand,function(index,element) { list7 += '<option value="'+element.id+'">'+element.name+'</option>'; });

			$('.ram_add_stock').html(list);
			$('.storage_device_add_stock').html(list2);
			$('.vendor_name_add_stock').html(list3);
			$('.os_add_stock').html(list4);
			$('.phy_location_add_stock').html(list5);
			$('.ast_department_add_stock').html(list6);
			$('.assest_company_brand_mst').html(list7);
		}
		else {
			alert('Something is wrong!');
		}
	},request_url, datas, 'text');


	for(var i = 1; i <= add_total; i++)
	{
		html += '<div class="modal-card" id="section_add_stock-'+i+'"><div class="row"><div class="col-sm-6"><div class="mb-1"><h5 class="card-number">No. '+i+'</h5></div></div><div class="col-sm-6"><div class="mb-1"><button class="btn btn-danger remove-btn add-stock-remove" value="'+i+'"><i class="fas fa-trash"></i></button></div></div></div><div class="row"><div class="col-sm-4"><div class="mb-1"><label for="exampleInputEmail1" class="form-label">Model Number: </label><input type="text" class="form-control" name="model_no[]" maxlength="150" placeholder="Enter Model Number"></div></div><div class="col-sm-4"><div class="mb-1"><label for="exampleInputEmail1" class="form-label">Serial Number: <span style="color: red;">*</span></label><input type="text" class="form-control" name="serial_no[]" id="add_stock_serial_number" required maxlength="150" placeholder="Enter Serial Number"></div></div><div class="col-sm-4"><div class="mb-1"> <label for="exampleInputEmail1" class="form-label">Assets Details/Configuration:</label><input type="text" class="form-control" name="config[]" maxlength="150" placeholder="Enter Asset Details"></div></div><div class="col-sm-4"> <div class="mb-1"><label for="exampleInputEmail1" class="form-label">PO Number: <span style="color: red;">*</span></label><input type="text" class="form-control" name="po_number[]" maxlength="150" placeholder="Enter PO Number" required> </div></div><div class="col-sm-4"><div class="mb-1"><label for="exampleInputEmail1" class="form-label">Purchase Type: <span style="color: red;">*</span></label><select class="form-control" name="purchase_type[]" required><option value="" selected disable>Select an option</option> <option value="1">OpEx</option> <option value="2">CapEx</option> </select> </div> </div><div class="col-sm-4"><div class="mb-1"><label for="exampleInputEmail1" class="form-label">Processor: </label><select class="form-control ast_department_add_stock" name="ast_department[]"></select></div></div><div class="col-sm-4"><div class="mb-1"><label for="exampleInputEmail1" class="form-label">Ram: </label><select class="form-control ram_add_stock" name="ram_ids[]"> </select></div></div><div class="col-sm-4"><div class="mb-1"><label for="exampleInputEmail1" class="form-label">Storage Device Type: </label><select class="form-control" name="purchase_dev_type[]"><option value="" selected disable>Select an option</option><option value="1">SSD</option> <option value="2">HDD</option></select></div></div><div class="col-sm-4"><div class="mb-1"><label for="exampleInputEmail1" class="form-label">Storage Device: </label><select class="form-control storage_device_add_stock" name="storage_device[]"> </select></div></div><div class="col-sm-4"><div class="mb-1"><label for="exampleInputEmail1" class="form-label">Own/Rental/Client: <span style="color: red;">*</span></label><select class="form-control" name="own_rental[]" required><option value="" selected disable>Select an option</option><option value="1">Own</option><option value="2">Rental</option><option value="3">Client</option></select></div> </div><div class="col-sm-4"><div class="mb-1"> <label for="exampleInputEmail1" class="form-label">Date Purchase : <span style="color: red;">*</span></label><input type="date" class="form-control" name="date_purcahse[]" required></div></div><div class="col-sm-4"><div class="mb-1"><label for="exampleInputEmail1" class="form-label">Vendor Name: <span style="color: red;">*</span></label> <select class="form-control vendor_name_add_stock" name="vendor_name[]" required></select></div> </div><div class="col-sm-4"><div class="mb-1"><label for="exampleInputEmail1" class="form-label">Under Validity/Warranty: <span style="color: red;">*</span></label><select class="form-control under_validity_add_stock" name="under_validity[]" required><option value="" selected disable>Select an option</option> <option value="1">Yes</option> <option value="2">No</option> </select></div></div><div class="col-sm-4"><div class="mb-1"><label for="exampleInputEmail1" class="form-label">Valid Thru :</label><input type="date" class="form-control add_stock_valid_thru" name="under_validity_date[]"></div></div><div class="col-sm-4"><div class="mb-1"> <label for="exampleInputEmail1" class="form-label">Select OS: </label><select class="form-control os_add_stock" name="os_ids[]"></select></div></div><div class="col-sm-4"><div class="mb-1"> <label for="exampleInputEmail1" class="form-label">Conditions: </label> <input type="text" class="form-control" name="conditions[]" maxlength="150" placeholder="Enter Condition"></div></div><div class="col-sm-4"><div class="mb-1"><label for="exampleInputEmail1" class="form-label">Physical Locations: </label><select class="form-control phy_location_add_stock" name="phy_location[]"></select></div></div><div class="col-sm-4"> <div class="mb-1"><label for="exampleInputEmail1" class="form-label">Company Brand: </label><select class="form-control assest_company_brand_mst" name="campaign_name[]"></select></div></div><div class="col-sm-12"><div class="mb-1"><label for="exampleInputEmail1" class="form-label">Remarks:</label><input type="text" class="form-control" name="remarks[]" maxlength="200" placeholder="Enter Comment"></div></div></div></div>';
	}

	$('#myModal-add-stock .add-stock-details-section').html(html);
	$("#myModal-add-stock .add-stock_submit").attr('disabled',false);	
}
else {
	alert('Please Enter Stock Total');
	$("#myModal-add-stock .add-stock_submit").attr('disabled',true);
	$('#myModal-add-stock .add-stock-details-section').html(html);
}
	return false;
});	
</script>

<script>
$(document).on('change','.under_validity_add_stock',function(){
	var chek_validity = $(this).val();
	if (chek_validity == 1) { $(".add_stock_valid_thru").attr("required", true); }
	else { $(".add_stock_valid_thru").attr("required", false); }
});
</script>

<script>
$(document).on('click','#myModal-add-stock .add-stock-remove',function(){

var section_value = $(this).attr('value');
var total_stock = $('#myModal-add-stock #stock_total').val();
$('#myModal-add-stock #section_add_stock-'+section_value+'').remove();

var current_stock = total_stock-1;

$('#myModal-add-stock #stock_total').val(current_stock);

if(current_stock > 0) {
	$("#myModal-add-stock .add-stock_submit").attr('disabled',false);
}
else {
	$("#myModal-add-stock .add-stock_submit").attr('disabled',true);
}

	return false;

});	
</script>

<script type="text/javascript">
$(document).on('click','.edit_stock_entry',function(){
	var params=$(this).attr("params");	
	var arrPrams = params.split("~#~");

	let reference_id = arrPrams[0];
	let Serial_number = arrPrams[1];
	let stock_status = arrPrams[2];
	let stock_id = arrPrams[3];
	let model_number = arrPrams[4];
	let configuration = arrPrams[5];
	let brand_id = arrPrams[6];
	let po_number = arrPrams[7];
	let purchase_type = arrPrams[8];
	let ram_id = arrPrams[9];
	let storage_device_type = arrPrams[10];
	let storage_device_id = arrPrams[11];
	let own_rental = arrPrams[12];
	let data_purchase = arrPrams[13];
	let vendor_id = arrPrams[14];
	let under_validity = arrPrams[15];
	let valid_thru = arrPrams[16];
	let os_id = arrPrams[17];
	let conditions = arrPrams[18];
	let ast_department_id = arrPrams[19];
	let phy_location_id = arrPrams[20];
	let campaign_name = arrPrams[21];
	let type = arrPrams[22];

	$("#edit-stock-details #update-stock-details-submit #stock_id").val(stock_id);
	$("#edit-stock-details #update-stock-details-submit #stok_head").text("Serial Number: "+Serial_number+" | Reference ID: "+reference_id);
	$("#edit-stock-details #update-stock-details-submit #model_number").val(model_number);
	$("#edit-stock-details #update-stock-details-submit #configuration").val(configuration);
	$("#edit-stock-details #update-stock-details-submit #po_number").val(po_number);
	$("#edit-stock-details #update-stock-details-submit #date_of_purchase").val(data_purchase);
	$("#edit-stock-details #update-stock-details-submit #conditions").val(conditions);
	$("#edit-stock-details #update-stock-details-submit #valid_thru").val(valid_thru);

	let pp_opex=pp_capex="";
	if(purchase_type==1) pp_opex="selected";
	else pp_capex="selected";
	$("#edit-stock-details #update-stock-details-submit #purchase_type").html('<option value="1" '+pp_opex+'>opex</option><option value="2" '+pp_capex+'>capex</option>');

	let ssd_size=hdd_size="";
	if(storage_device_type==1) ssd_size="selected";
	else if(storage_device_type==2) hdd_size="selected";
	$("#edit-stock-details #update-stock-details-submit #storage_device_type").html('<option value="">Select an Option</option><option value="1" '+ssd_size+'>SSD</option><option value="2" '+hdd_size+'>HDD</option>');

	let own_assets=rental_assets=client_assets="";
	if(own_rental==1) own_assets="selected";
	else if(own_rental==2) rental_assets="selected";
	else if(own_rental==3) client_assets="selected";
	$("#edit-stock-details #update-stock-details-submit #own_rental").html('<option value="1" '+own_assets+'>Own</option><option value="2" '+rental_assets+'>Rental</option><option value="3" '+client_assets+'>Client</option>');

	let under_validity_yes=under_validity_no="";
	if(under_validity==1) {
		under_validity_yes="selected";
		$("#edit-stock-details #update-stock-details-submit #valid_thru").attr('required',true);
		$("#edit-stock-details #update-stock-details-submit #valid_thru_required").text('*');
	} 
	else if(under_validity==2) {
		under_validity_no="selected";
		$("#edit-stock-details #update-stock-details-submit #valid_thru").attr('required',false);
		$("#edit-stock-details #update-stock-details-submit #valid_thru_required").text('');
	}
	$("#edit-stock-details #update-stock-details-submit #under_validity").html('<option value="1" '+under_validity_yes+'>Yes</option><option value="2" '+under_validity_no+'>No</option>');


	var datas = {"stock_status": stock_status};
	var request_url = "<?php echo base_url('dfr_it_assets/get_master_data'); ?>";
	process_ajax(function(response)
	{
		var res = JSON.parse(response);
		if (res.stat==true) {
			var options_vendor=options_brand=sel='';
			var options_ram=options_storage_device=options_phy_location=options_ast_department=options_com_brand=options_os='<option value="">Select an option</option>';

            $.each(res.datas_brand,function(index,element) {
                if(brand_id == element.id) { sel = "selected"; }
                else { sel = ""; }
                options_brand += '<option value="'+element.id+'" '+sel+'>'+element.name+'</option>';
            });
            $.each(res.datas_vendor,function(index,element) {
                if(vendor_id == element.id) { sel = "selected"; }
                else { sel = ""; }
                options_vendor += '<option value="'+element.id+'" '+sel+'>'+element.vnd_name+'</option>';
            });
            $.each(res.datas_ram,function(index,element) {
                if(ram_id == element.id) { sel = "selected"; }
                else { sel = ""; }
                options_ram += '<option value="'+element.id+'" '+sel+'>'+element.size+' GB</option>';
            });
            $.each(res.datas_storage_device,function(index,element) {
                if(storage_device_id == element.id) { sel = "selected"; }
                else { sel = ""; }
                options_storage_device += '<option value="'+element.id+'" '+sel+'>'+element.size+'</option>';
            });
            $.each(res.datas_phy_location,function(index,element) {
                if(phy_location_id == element.id) { sel = "selected"; }
                else { sel = ""; }
                options_phy_location += '<option value="'+element.id+'" '+sel+'>'+element.location_name+'</option>';
            });
            $.each(res.datas_ast_department,function(index,element) {
                if(ast_department_id == element.id) { sel = "selected"; }
                else { sel = ""; }
                options_ast_department += '<option value="'+element.id+'" '+sel+'>'+element.assets_dpt_name+'</option>';
            });
            $.each(res.datas_os,function(index,element) {
                if(os_id == element.id) { sel = "selected"; }
                else { sel = ""; }
                options_os += '<option value="'+element.id+'" '+sel+'>'+element.os_name+'</option>';
            });
            $.each(res.datas_company_brand,function(index,element) {
                if(campaign_name == element.id) { sel = "selected"; }
                else { sel = ""; }
                options_com_brand += '<option value="'+element.id+'" '+sel+'>'+element.name+'</option>';
            });

            $("#edit-stock-details #update-stock-details-submit #brand_id").html(options_brand);
            $("#edit-stock-details #update-stock-details-submit #ram-id").html(options_ram);
            $("#edit-stock-details #update-stock-details-submit #storage_device_size").html(options_storage_device);
            $("#edit-stock-details #update-stock-details-submit #vendor_id").html(options_vendor);
            $("#edit-stock-details #update-stock-details-submit #os_id").html(options_os);
            $("#edit-stock-details #update-stock-details-submit #ast_department").html(options_ast_department);
            $("#edit-stock-details #update-stock-details-submit #phy_location").html(options_phy_location);
			$("#edit-stock-details #update-stock-details-submit #campaign_name").html(options_com_brand);
		}
		else { alert("Something is wrong!"); }

		$('.selectpicker').selectpicker('refresh');
	},request_url, datas, 'text');

	$('#edit-stock-details').modal('show');
});

</script>	

<script>
$('#assset_stock_search .search_stock_id').change(function () {

	var datas = $('#assset_stock_search').serializeArray();
	var request_url = "<?php echo base_url('dfr_it_assets/stock_reference_id_result'); ?>";

	process_ajax(function(response)
	{
		var res = JSON.parse(response);
		$('#stock-reference-id-search').html();
		var option = '<option value="">--Select Reference ID---</option>';
		var option_ser = '<option value="">--Select Serial Number---</option>';
		$.each(res.reference_id,function(index,element)
		{
			option += '<option value="'+element.reference_id+'" >'+element.reference_id+'</option>';
			option_ser += '<option value="'+element.serial_number+'" >'+element.serial_number+'</option>';
		});
		$('#stock-reference-id-search').html(option);
		$('#stock-serial-number-search').html(option_ser);

		// var option_user = '<option value="">--Select Assigned_user---</option>';
		// $.each(res.assigned_user,function(index,element)
		// {
		// 	option_user += '<option value="'+element.user_id+'" >'+element.user_name+'('+element.fusion_id+')</option>';
		// });
		// $('#assigned_user_search').html(option_user);
		
		$('.selectpicker').selectpicker('refresh');
	},request_url, datas, 'text');
})

	var datas = $('#assset_stock_search').serializeArray();
	var request_url = "<?php echo base_url('dfr_it_assets/stock_reference_id_result'); ?>";

	process_ajax(function(response)
	{

		var ref_idd = '<?php echo $reference_id_search; ?>';
		var serial_idd = '<?php echo $serial_number; ?>';
		var res = JSON.parse(response);
		$('#stock-reference-id-search').html();
		var option = '<option value="">--Select Reference ID---</option>';
		var option_ser = '<option value="">--Select Serial Number---</option>';
		$.each(res.reference_id,function(index,element)
		{
			option += '<option value="'+element.reference_id+'" >'+element.reference_id+'</option>';
			option_ser += '<option value="'+element.serial_number+'" >'+element.serial_number+'</option>';
		});
		$('#stock-reference-id-search').html(option);
		$('#stock-serial-number-search').html(option_ser);

		// var option_user = '<option value="">--Select Assigned User---</option>';
		// $.each(res.assigned_user,function(index,element)
		// {
		// 	option_user += '<option value="'+element.user_id+'" >'+element.user_name+'('+element.fusion_id+')</option>';
		// });
		// $('#assigned_user_search').html(option_user);
		
		if(serial_idd != "")$('#stock-serial-number-search').val(serial_idd);
		else if(ref_idd != "" && serial_idd == "")$('#stock-reference-id-search').val(ref_idd);

		$('.selectpicker').selectpicker('refresh');
	},request_url, datas, 'text');

</script>

<!-- <script>
$('#assset_stock_search #stock-reference-id-search').change(function () {

	var reference_id  = $('#stock-reference-id-search').val();
	var datas = { 'reference_id': reference_id }
	var request_url = "<?php echo base_url('dfr_it_assets/stock_assigned_uesr_result'); ?>";

	process_ajax(function(response)
	{
		var res = JSON.parse(response);
		if (res.stat == true) {
			var option = '<option value="">--Select Reference ID---</option>';
			var option_user = '<option value="">--Select Assigned_user---</option>';
			$.each(res.assigned_user,function(index,element)
			{
				option_user += '<option value="'+element.user_id+'" >'+element.user_name+'('+element.fusion_id+')</option>';
			});
		}
		$('#assigned_user_search').html(option_user);
		$('.selectpicker').selectpicker('refresh');
	},request_url, datas, 'text');
})	
</script>	 -->

<script>
	$(document).on('click','.view_stock_details',function()
    {
		var params=$(this).attr("params");	
		var arrPrams = params.split("#"); 
		var strock_id = arrPrams[3];

		var datas = { 'strock_id': strock_id };
		var request_url = "<?php echo base_url('dfr_it_assets/stock_assign_user_history'); ?>";
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			var option_user = '<h4 style="margin-left: 7px;">ASSIGNMENT DETAILS: </h4>';
			var stock_return_date = "";
			var stock_return_by = "";
			if (res.stat == true) {
				var count = 1;
				$.each(res.assigned_user,function(index,element)
				{
					if(element.return_date == null){
						var stat_assign = '<div class="col-sm-12"><h5><span style="font-weight: bold;">Status: </span><label class="label label-primary">Active</label></h5></div>';
						stock_return_date = ""; stock_return_by = "";
					}
					else {
						var stat_assign = '<div class="col-sm-4"><h5><span style="font-weight: bold;">Status: </span><label class="label label-danger">Return</label></h5></div>';

						stock_return_date = '<div class="col-sm-4"><h5><span style="font-weight: bold;">Return Date: </span>'+element.return_date+'</h5></div>';

						if (element.is_user_acknowledge==2) {
							stock_return_by = '<div class="col-sm-12"><h5><span style="font-weight: bold;">Return By: </span><span style="color:red">(Assets Assignment Declined By User)</span></h5></div>';
						}
						else {
							stock_return_by = '<div class="col-sm-12"><h5><span style="font-weight: bold;">Return By: </span>'+element.return_by_name+'</h5></div>';
						}
					}

					if (element.is_user_acknowledge == 1) { var user_ack = "<span style='color:green'>Done</span>"; }
					else if (element.is_user_acknowledge == 2) { var user_ack = "<span style='color:red'>Declined</span>"; }
					else { var user_ack = "<span style='color:red'>Pending</span>"; }

					if (element.acknowledge_date == null) { var user_ack_date = ''; }
					else { var user_ack_date = '<div class="col-sm-4"><h5><span style="font-weight: bold;">Acknowledgement Date: </span>'+element.acknowledge_date+'</h5></div>'; }

					option_user += '<div class="row" style="border-bottom: 5px solid #e5e5e5;padding: 10px;"><div class="col-sm-4"><h5><span style="font-weight: bold;">'+count+'. Name: </span>'+element.user_name+' ('+element.fusion_id+')</h5></div> <div class="col-sm-4"><h5><span style="font-weight: bold;">Assign Date: </span>'+element.raised_date+'</h5></div> <div class="col-sm-4"><h5><span style="font-weight: bold;">Assign By: </span>'+element.assign_by+'</h5></div><div class="col-sm-4"><h5><span style="font-weight: bold;">User Location: </span>'+element.office_name+'</h5></div><div class="col-sm-4"><h5><span style="font-weight: bold;">Department: </span>'+element.department_name+'</h5></div><div class="col-sm-4"><h5><span style="font-weight: bold;">Assignment Type: </span>'+element.assignment_type+'</h5></div> <div class="col-sm-4"><h5><span style="font-weight: bold;">Comments: </span>'+element.comments+'</h5></div> <div class="col-sm-4"><h5><span style="font-weight: bold;">Assignment ID: </span>'+res.assignment_id[element.id]+'</h5></div><div class="col-sm-4"><h5><span style="font-weight: bold;">Acknowledgement Status: </span>'+user_ack+'</h5></div>'+user_ack_date+stat_assign+stock_return_date+stock_return_by+'</div>';
					count++;
				});

				$('#stock_details .stock_assign_details_result').html(option_user);
			}
			else {
				$('#stock_details .stock_assign_details_result').html(option_user+'<h5 style="margin-left: 7px;">No assign history found!</h5>');
			}

			if(res.stock_details[0].purchase_type == 1) var purchase_type = 'OPEX';
			else var purchase_type = 'CAPEX';
			if(res.stock_details[0].storage_device_type == 1) var storage_device_type = 'SSD';
			else if(res.stock_details[0].storage_device_type == 2) var storage_device_type = 'HDD';
			else var storage_device_type = null;
			if(res.stock_details[0].own_rental == 1) var own_rental = 'OWN';
			else if(res.stock_details[0].own_rental == 2) var own_rental = 'RENTAL';
			else var own_rental = 'CLIENT';
			if(res.stock_details[0].under_validity == 1) var under_validity = 'Yes';
			else var under_validity = 'No';	
			if(res.stock_details[0].type == 1) var type = 'New';
			else var type = 'Existing';

			if(res.stock_details[0].ram_name!= null) var ram_size = res.stock_details[0].ram_name+'GB';
			else var ram_size = null;								

			$('#stock_details .stock_details_result').html('<div class="col-sm-6"> <h5><span style="font-weight: bold;">REFERENCE ID:</span> '+res.stock_details[0].reference_id+'</h5> </div> <div class="col-sm-6"> <h5><span style="font-weight: bold;">SERIAL NUMBER:</span> '+res.stock_details[0].serial_number+'</h5> </div> <div class="col-sm-6"> <h5><span style="font-weight: bold;">MODEL NUMBER:</span> '+res.stock_details[0].model_number+'</h5> </div> <div class="col-sm-6"> <h5><span style="font-weight: bold;">ASSETS DETAILS:</span> '+res.stock_details[0].configuration+'</h5> </div> <div class="col-sm-6"> <h5><span style="font-weight: bold;">BRAND NAME:</span> '+res.stock_details[0].brand_name+'</h5> </div> <div class="col-sm-6"> <h5><span style="font-weight: bold;">PO NUMBER:</span> '+res.stock_details[0].po_number+'</h5> </div> <div class="col-sm-6"> <h5><span style="font-weight: bold;">PURCHASE TYPE:</span> '+purchase_type+'</h5> </div> <div class="col-sm-6"> <h5><span style="font-weight: bold;">PROCESSOR:</span> '+res.stock_details[0].dpt_name+'</h5> </div> <div class="col-sm-6"> <h5><span style="font-weight: bold;">RAM SIZE:</span> '+ram_size+'</h5> </div> <div class="col-sm-6"> <h5><span style="font-weight: bold;">STORAGE DEVICE TYPE:</span> '+storage_device_type+'</h5> </div> <div class="col-sm-6"> <h5><span style="font-weight: bold;">STORAGE DEVICE SIZE:</span> '+res.stock_details[0].strg_name+'</h5> </div> <div class="col-sm-6"> <h5><span style="font-weight: bold;">OWN/RENTAL/CLIENT:</span> '+own_rental+'</h5> </div> <div class="col-sm-6"> <h5><span style="font-weight: bold;">DATE PURCHASE:</span> '+res.stock_details[0].data_purchase+'</h5> </div> <div class="col-sm-6"> <h5><span style="font-weight: bold;">VENDOR NAME:</span> '+res.stock_details[0].vendor_name+'</h5> </div> <div class="col-sm-6"> <h5><span style="font-weight: bold;">UNDER VALIDITY:</span> '+under_validity+'</h5> </div> <div class="col-sm-6"> <h5><span style="font-weight: bold;">VALID THRU:</span> '+res.stock_details[0].valid_thru+'</h5> </div> <div class="col-sm-6"> <h5><span style="font-weight: bold;">OS NAME:</span> '+res.stock_details[0].os_name+'</h5> </div> <div class="col-sm-6"> <h5><span style="font-weight: bold;">CONDITIONS:</span> '+res.stock_details[0].conditions+'</h5> </div> <div class="col-sm-6"> <h5><span style="font-weight: bold;">PHYSICAL LOCATIONS:</span> '+res.stock_details[0].phy_location+'</h5> </div> <div class="col-sm-6"> <h5><span style="font-weight: bold;">COMPANY BRAND:</span> '+res.stock_details[0].company_brand_assets+'</h5> </div> <div class="col-sm-6"> <h5><span style="font-weight: bold;">REMARKS:</span> '+res.stock_details[0].reamrks+'</h5> </div> <div class="col-sm-6"> <h5><span style="font-weight: bold;">STATUS COMMENTS:</span> '+res.stock_details[0].comments_status+'</h5> </div> <div class="col-sm-6"> <h5><span style="font-weight: bold;">TYPE:</span> '+type+'</h5> </div> <div class="col-sm-6"> <h5><span style="font-weight: bold;">RAISED BY:</span> '+res.stock_details[0].raised_by_name+'</h5> </div>');

		},request_url, datas, 'text');

		$('#stock_details').modal('show');
	});
</script>

<script>
	$(document).on('click','.stock_status_update',function()
    {
		var params=$(this).attr("params");	
		var arrPrams = params.split("#");
		var reference_id = arrPrams[0];
		var serial_number = arrPrams[1];
		var s_status = arrPrams[2];
		var stock_id = arrPrams[3];

		if(s_status == 1) { $(".stock_status_update_stat option:contains('Un-Assigned/Released')").hide(); }
		else { $(".stock_status_update_stat option:contains('Un-Assigned/Released')").show(); }
		if(s_status == 3) { $(".stock_status_update_stat option:contains('Scrap')").hide(); }
		else { $(".stock_status_update_stat option:contains('Scrap')").show(); }
		if(s_status == 4) { $(".stock_status_update_stat option:contains('Defect')").hide(); }
		else { $(".stock_status_update_stat option:contains('Defect')").show(); }
		if(s_status == 6) { $(".stock_status_update_stat option:contains('Stock')").hide(); }
		else { $(".stock_status_update_stat option:contains('Stock')").show(); }
		if(s_status == 7) { $(".stock_status_update_stat option:contains('Misplaced/Lost')").hide(); }
		else { $(".stock_status_update_stat option:contains('Misplaced/Lost')").show(); }
		if(s_status == 8) { $(".stock_status_update_stat option:contains('Live')").hide(); }
		else { $(".stock_status_update_stat option:contains('Live')").show(); }
	
		$('#stock_status_update #stock_reference_id').text(reference_id);
		$('#stock_status_update #stock_serial_num').text(serial_number);
		$('#stock_status_update #stock_id').val(stock_id);
		$('#stock_status_update .stock_status_update_stat').val('');
		$('#stock_status_update #comments_stat').val('');
		$('#stock_status_update').modal('show');
	});

	$(document).on('change','#stock_status_update .stock_status_update_stat',function()
    {
    	if ($(this).val()==4) { $('#stock_status_update #comments_req').text('*'); $('#stock_status_update #comments_stat').prop('required',true); }
    	else { $('#stock_status_update #comments_req').text(' '); $('#stock_status_update #comments_stat').removeAttr('required'); }
	});

</script>

<script>
	$(document).on('change','#model_users_assets #select_model_assets_click',function(){

		var stock_id = $(this).val();
		var request_url = "<?php echo base_url('dfr_it_assets/get_stock_id_details'); ?>";
		var datas = { 'stock_id': stock_id };
		var result_data = "";
		var inf_id = $(this).attr('date-inf');
		process_ajax(function(response)
		{
			var res = JSON.parse(response);

			if (res.stat == true) {

				if (res.datas[0].type == 1) { var stock_type = "NEW"; }
				else { var stock_type = "Existing"; }

				$('#model_users_assets .stock_details_serial'+inf_id).html('<span style="font-weight: bold;">Brand Name: </span>'+res.datas[0].brand_name); 
				$('#model_users_assets .stock_details_conf'+inf_id).html('<span style="font-weight: bold;">Configuration/Details: </span>'+res.datas[0].configuration);
				$('#model_users_assets .stock_details_type'+inf_id).html('<span style="font-weight: bold;">Type: </span>'+stock_type);
			}
		},request_url, datas, 'text');
	});	
	
</script>

<script>
	// $(document).on('click','.stock_assign_user',function()
    // {
	// 	var params=$(this).attr("params");	
	// 	var arrPrams = params.split("#"); 
	// 	var stock_status = arrPrams[1];
	// 	var reference_id = arrPrams[0];
	// 	var stock_id = arrPrams[2];
	// 	var assets_name = arrPrams[3];
	// 	var assets_id = arrPrams[4];
	// 	var location_name = arrPrams[5];
	// 	var location_abbr = arrPrams[6];

	// 	$('#stock_assign_user .stock_reference_id').text(reference_id);
	// 	$('#stock_assign_user .stock_asset').text(assets_name);
	// 	$('#stock_assign_user #stock_id').val(stock_id);
	// 	$('#stock_assign_user #assets_id').val(assets_id);

	// 	$('#location_id_assign').html('<option value="">Select a location </option><option value="'+location_abbr+'">'+location_name+'</option>');
		
	// 	$('#stock_assign_user').modal('show');
	// });
</script>

<script>
// $(document).on('change','#stock_assign_user #location_id_assign',function()
// {
//     var location_id = $(this).val();
// 	var assets_id = $('#stock_assign_user #assets_id').val();
// 	var datas = { 'location': location_id, 'assets_id': assets_id}
// 	var request_url = "<?php echo base_url('dfr_it_assets/get_return_user_list'); ?>";

// 	process_ajax(function(response)
// 	{
// 		var res = JSON.parse(response);
// 		var option_user = '<option value="">--Select a user name---</option>';
// 		if (res.stat == true) {
// 			$.each(res.user_list,function(index,element)
// 			{
// 				option_user += '<option value="'+element.user_id+'" >'+element.user_name+'</option>';
// 			});
// 		}
// 		else {
// 			alert('No user found!');
// 		}
// 		$('#stock_assign_user #get_user_return_list').html(option_user);
// 		$("#stock_assign_user .stock-assign-from-entry").attr('disabled',true);
// 		$('.selectpicker').selectpicker('refresh');
// 	},request_url, datas, 'text');
		
// });
</script>

<script>
$(document).on('change','#stock_assign_user #get_user_return_list',function()
{
    var user_id = $(this).val();
    var stock_id = $('#stock_assign_user #stock_id').val();
    var assets_id = $('#stock_assign_user #assets_id').val();
	var datas = { 'user_id': user_id, 'stock_id': stock_id, 'assets_id': assets_id }
	var request_url = "<?php echo base_url('dfr_it_assets/get_user_assign_status'); ?>";
	if (user_id == '') {
		alert('Select a User!');
		$("#stock_assign_user .stock-assign-from-entry").attr('disabled',true);
	}
	else {
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if (res.stat == true) {
				var assign_history = '';
				$.each(res.datas,function(index,element)
				{
					assign_history = '<div class="row" style="margin-bottom: 5px;"> <div class="col-sm-4"> <strong>Category Name: </strong>'+element.assets_name+'</div> <div class="col-sm-4"> <strong>Configuration: </strong>'+element.configuration+'</div> <div class="col-sm-4"> <strong>Model Number: </strong>'+element.model_number+'</div> <div class="col-sm-4"> <strong>Reference Number: </strong>'+element.reference_id+'</div> <div class="col-sm-4"> <strong>Return Date: </strong>'+element.return_date+'</div> <div class="col-sm-4"> <strong>Serial Number: </strong>'+element.serial_number+'</div> <div class="col-sm-4"> <strong>Remarks: </strong>'+element.reamrks+'</div> <div class="col-sm-8"> <strong>Status Comments: </strong>'+element.comments_status+'</div> <div>';
				});
				$('#stock_assign_user #stock_id_old').val(res.datas2[0].assets_details);
			}
			$("#stock_assign_user .stock-assign-from-entry").attr('disabled',false);
			$('#stock_assign_user .User_details_history').html(assign_history);
		},request_url, datas, 'text');
	}	
});
</script>

<script>
$(document).on('change','#myModal-assets-req-generate #client_id_hod',function()
{
	var client_id = $(this).val();
	var datas = {'cid': client_id};
	var request_url = "<?php echo base_url('user/getProcessList'); ?>";
	process_ajax(function(response)
	{
		var res = JSON.parse(response);
		console.log(res);
		var list = '<option value="" selected>--- Select a Process ---</option>';
		$.each(res,function(index,element)
		{
			list += '<option value="'+element.id+'">'+element.name+'</option>';
		});
		$('#myModal-assets-req-generate #process_id_hod').html(list);
		$('.selectpicker').selectpicker('refresh');
	},request_url, datas, 'text');
});
</script>

<script>
$(document).on('click','#reject_assets_request_hod',function()
{
	var req_id=$(this).attr("value");
	var req_number=$(this).attr("r_id");
	var req_assets=$(this).attr("assets_name");
	var req_total=$(this).attr("request_total");
	var assets_id=$(this).attr("assets_id");
	$('#modal_assets_request_reject #req_id_hod').text(req_number);
	$('#modal_assets_request_reject .assets_name_hod').text(req_assets); 
	$('#modal_assets_request_reject .req_total_assets').text(req_total);
	$('#modal_assets_request_reject #req_id_reject').val(req_id);
	var datas = {'assets_id': assets_id};
	var request_url = "<?php echo base_url('dfr_it_assets/get_present_stock_total'); ?>";
	process_ajax(function(response)
	{
		var res = JSON.parse(response);
		if (Number(res.get_total) >= Number(req_total)) var spn_color = "green";
		else var spn_color = "red";
		$('#modal_assets_request_reject .in_stock_present_assets').html('<span style="color:'+spn_color+'">'+res.get_total+'</span>');
	
	},request_url, datas, 'text');
	$('#modal_assets_request_reject').modal('show');
});
</script>

<script>
$(document).on('click','#approve_assets_request_hod',function()
{
	var req_id=$(this).attr("value");
	var req_number=$(this).attr("r_id");
	var req_assets=$(this).attr("assets_name");
	var req_total=$(this).attr("request_total");
	var assets_id=$(this).attr("assets_id");
	$('#model_assets_request_approve #req_id_hod').text(req_number);
	$('#model_assets_request_approve .assets_name_hod').text(req_assets); 
	$('#model_assets_request_approve .req_total_assets').text(req_total);
	$('#model_assets_request_approve #req_id_approve').val(req_id);
	var datas = {'assets_id': assets_id};
	var request_url = "<?php echo base_url('dfr_it_assets/get_present_stock_total'); ?>";
	process_ajax(function(response)
	{
		var res = JSON.parse(response);
		if (Number(res.get_total) >= Number(req_total)) var spn_color = "green";
		else var spn_color = "red";
		$('#model_assets_request_approve .in_stock_present_assets').html('<span style="color:'+spn_color+'">'+res.get_total+'</span>');
	
	},request_url, datas, 'text');
	$('#model_assets_request_approve').modal('show');
});
</script>

<script>
$(document).on('click','#assest_move_req',function()
{
	var req_id=$(this).attr("value");
	var req_number=$(this).attr("r_id");
	var req_assets=$(this).attr("assets_name");
	var req_total=$(this).attr("request_total");
	var assets_id=$(this).attr("assets_id");
	var location_name=$(this).attr("location_name");
	$('#myModal_assets_movement_req #req_location').text(location_name);
	$('#myModal_assets_movement_req .assets_name_hod').text(req_assets);
	$('#myModal_assets_movement_req #req_id_hod').text(req_number);
	$('#myModal_assets_movement_req #req_number').val(req_number);
	$('#myModal_assets_movement_req #req_total').val(req_total);
	$('#myModal_assets_movement_req #req_id').val(req_id);
	var datas = {'assets_id': assets_id};
	var request_url = "<?php echo base_url('dfr_it_assets/get_assets_stock_details'); ?>";
	process_ajax(function(response)
	{
		var res = JSON.parse(response);
		if (Number(res.assets_total) < Number(req_total)){
			alert('Not enough stock!');
			$("#myModal_assets_movement_req .assets_move_submit").attr('disabled',true);
			$("#myModal_assets_movement_req #assets_mov_details").html('');
		}
		else{
			var inputs = '';
			var c = 1;
			const stock_arr = []; localStorage.setItem("stock_contents", stock_arr);
			for (let i = 0; i < Number(req_total); i++) {
				var serial_ids = '<option value="" selected>--Select a option--</option>';
				$.each(res.assets_stock,function(index,element)
				{
					serial_ids += '<option value="'+element.id+'">'+element.serial_number+'</option>';
				});
				inputs += `<div class="col-sm-12"><div class="mb-1"><h5 class="card-number">No. ${c}</h5></div><div class="col-sm-6"><div class="form-group search-select"><label for="full_form">Serial Number: <span style="color: red">*</span></label><select target_id="${c}" class="selectpicker stock_id_assets_move stock_sel_${c}" name="stock_id[]" data-show-subtext="true" data-live-search="true" required>${serial_ids}</select></div></div> <div class="col-sm-6" id="stock_id_details_${c}"><div class="col-sm-12"><label for="full_form">Seleted Item Details: </label></div></div></div> </div>`
				c++;
			}
			$('#myModal_assets_movement_req #assets_mov_details').html(inputs);
			$("#myModal_assets_movement_req .assets_move_submit").attr('disabled',false);
			$('.selectpicker').selectpicker('refresh');
		}
	
	},request_url, datas, 'text');
	$('#myModal_assets_movement_req').modal('show');
});
</script>

<script>
$(document).on('change','#myModal_assets_movement_req .stock_id_assets_move',function()
{
	var stock_id=$(this).val();
	var target_id=$(this).attr("target_id");
	var stock_content = $(".stock_sel_"+target_id+" option:selected").text();
	var datas = {'stock_id': stock_id};
	var request_url = "<?php echo base_url('dfr_it_assets/get_stock_id_details'); ?>";
	process_ajax(function(response)
	{
		var res = JSON.parse(response);
		var s_details =`<div class="col-sm-12"><label for="full_form">Seleted Item Details: </label></div><div class="col-sm-6">Reference ID: ${res.datas[0].reference_id}</div><div class="col-sm-6">Serial Number: ${res.datas[0].serial_number}</div><div class="col-sm-6">Brand Name: ${res.datas[0].brand_name}</div><div class="col-sm-6">Model Number: ${res.datas[0].model_number}</div><div class="col-sm-6">Configuration: ${res.datas[0].configuration}</div>`
		$('#myModal_assets_movement_req #stock_id_details_'+target_id).html(s_details);

		var req_total = $('#myModal_assets_movement_req #req_total').val();
		var stock_arr_local = localStorage.getItem("stock_contents");
		var stock_arr = stock_arr_local.split(",");

		for (let i = 1; i <= Number(req_total); i++) {
			if (Number(target_id) == Number(i)) {
				if (stock_arr.indexOf(stock_content) !== -1) {
					alert('Duplicate item selected!');
					$("#myModal_assets_movement_req .stock_sel_"+i).val('');
				}
			}
		}
		stock_arr = [];
		for (let i = 1; i <= Number(req_total); i++) {
			var selected_items = $("#myModal_assets_movement_req .stock_sel_"+i+" option:selected").text();
			stock_arr.push(selected_items);
			localStorage.setItem("stock_contents", stock_arr);
		}

		$('.selectpicker').selectpicker('refresh');
	},request_url, datas, 'text');
	$('#myModal_assets_movement_req').modal('show');
});
</script>

<script>
$(document).on('click','#assest_move_view',function()
{
	var req_id=$(this).attr("value");
	var req_number=$(this).attr("r_id");
	var req_assets=$(this).attr("assets_name");
	var req_total=$(this).attr("request_total");
	var assets_id=$(this).attr("assets_id");
	var location_name=$(this).attr("location_name");
	$('#myModal_assets_movement_history_details #req_location').text(location_name);
	$('#myModal_assets_movement_history_details .assets_name_hod').text(req_assets);
	$('#myModal_assets_movement_history_details #req_id_hod').text(req_number);
	var datas = {'req_id': req_id};
	var request_url = "<?php echo base_url('dfr_it_assets/get_assets_movement_history'); ?>";
	process_ajax(function(response)
	{
		var res = JSON.parse(response);
		if (res.stat == true) {
			var tr_details = ''; var c=1;
			$.each(res.datas,function(index,element)
			{
				tr_details += '<tr><td>'+c+'</td><td>'+element.serial_number+'</td><td>'+element.reference_id+'</td><td>'+element.brand_name+'</td><td>'+element.configuration+'</td><td>'+element.model_number+'</td><td>'+element.raised_date+'</td></tr>';
				c++;
			});
			$('#myModal_assets_movement_history_details #move_assets_history_tr').html(tr_details);
		}
		else {
			alert('Something is wrong');
		}
	},request_url, datas, 'text');
	$('#myModal_assets_movement_history_details').modal('show');
});
</script>

<script>
$(document).on('click','.assets_upload_doc_agreement',function()
{
	var params=$(this).attr("params");	
	var arrPrams = params.split("#");
    $("#assets_agreement_doc_upload #stock_reference_id").text(arrPrams[0]);
    $("#assets_agreement_doc_upload #stock_serial_num").text(arrPrams[1]);

	var datas = {'stock_id': arrPrams[3]};
	var request_url = "<?php echo base_url('dfr_it_assets/get_user_assets_doc_details'); ?>";
	process_ajax(function(response)
	{
		var res = JSON.parse(response);
		if (res.stat == true) {
			var user_ast_details = `<tr><td>${res.data_user[0].user_name}</td> <td>${res.data_user[0].fusion_id}</td><td>${res.data_user[0].assets_name}</td><td>${res.data_user[0].raised_date}</td><td>${res.data_user[0].assign_by}</td><td>${res.data_user[0].office_id}</td><td>${res.data_user[0].user_department}</td><td>${res.data_user[0].acknowledge_date}</td><td>${res.data_user[0].comments}</td></tr>`;
			$('#assets_agreement_doc_upload #user_assign_assets_details').html(user_ast_details);

			if (res.data_user[0].ack_doc!=null) {

				var user_document_details = `<div class="modal-card new-tab"><div class="row">
                                <div class="col-md-4">
                                <div> <label  class=" font-look righT">View Document</label> :<label class="font-look lefT"><a href="<?=base_url()?>it_assets_import/ack_doc/${res.data_user[0].ack_doc}" target="_blank">View File <i class="fa fa-file" aria-hidden="true"></i></a></label></div>
                                </div>
                                 <div class="col-md-4">
                                <div> <label  class=" font-look righT">Upload By</label> :<label class="font-look lefT">${res.data_user[0].doc_upload_by}</label></div>
                                </div>

                                 <div class="col-md-4">
                                <div> <label  class=" font-look righT">Upload Date</label> :<label class="font-look lefT">${res.data_user[0].doc_upload_date}</label></div>
                                </div> 
                            </div>
                    </div>`

				$('#assets_agreement_doc_upload #user_document_details').html(user_document_details);
			}
			else {
				var user_document_upload_form = `<form method="post" id="it_assets_doc_upload_submit" enctype="multipart/form-data"><div class="modal-card">
                         <div class="row new-section">
                             <div class="col-sm-5">
                                    <div class="mb-1">
                                    <input type="hidden" name="tab_id" value="${res.data_user[0].id}">
                                        <label for="exampleInputEmail1" class="form-label">Document Upload <span style="color:red">*(Only PDF File allowed, Max Size 5MB)</span></label>
                                        <input type="file" class="form-control" name="ast_user_file" id="ast_user_file" required>
                                    </div>
                                </div>
                                 <div class="col-sm-5">
                                    <div class="mb-1">
                                        <label for="exampleInputEmail1" class="form-label">Date <span style="color:red">*</span></label>
                                        <input type="date" class="form-control" value="<?=date('Y-m-d')?>" name="upload_date" id="upload_date" required>
                                    </div>
                                </div>
                                 <div class="col-sm-2">
                                   <button class="btn btn-submit" type="submit">Upload</button>
                                </div>
                        </div>
                    </div></form>`;

				$('#assets_agreement_doc_upload #user_document_details').html(user_document_upload_form);
			}
		}
		else {
			alert(res.errmsg);
		}
	},request_url, datas, 'text');



	$('#assets_agreement_doc_upload').modal('show');
	
});


$(document).on('submit','#assets_agreement_doc_upload #it_assets_doc_upload_submit',function(event){
    event.preventDefault();

    $('#sktPleaseWait').modal('show');
                      
    $.ajax({
        url: '<?php echo base_url("dfr_it_assets/user_assets_doc_upload"); ?>',
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        data: new FormData(this),                         
        type: 'post',
        success: function(response){
        	var res = JSON.parse(response);
            if (res.stat == true) {
            	location.reload();
            }
            else {
            	alert(res.errmsg);
            }

            //$('#sktPleaseWait').modal('hide');
        }
     });
});
	$(document).on('change','#assets_agreement_doc_upload #ast_user_file',function(){
            //var ext = this.value.match(/\.(.+)$/)[1];
            var fileName = $(this).val();
            const fileSize = this.files[0].size / 1024 / 1024; // in MiB
            if (fileSize > 5) {
                alert('File size exceeds 5 MB');
                this.value = '';
            }
              else {
                var ext = fileName.substring(fileName.lastIndexOf(".") + 1, fileName.length);
                ext = ext.toLowerCase();
                switch (ext) {
                    case 'pdf':
                        break;
                    default:
                        alert('This is not an allowed file type.');
                        this.value = '';
                }
            }
        });
</script>
