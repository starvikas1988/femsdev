<script>
$(document).ready(function() {
	baseURL = "<?php echo base_url(); ?>";

	$(document).on('submit','.mst_edit_add_investment',function(event){
		event.preventDefault();
		let form_data = $(this).serializeArray();
		var current_action = "";
		$.each(form_data, function (i, field) {
			if(field.name=="type") { current_action = field.value; }
		});

		if(current_action=="add") {
			var min_value = $('#addInvestmentMaster .mst_edit_add_investment input[name="from_amount"]').val();
			var max_value = $('#addInvestmentMaster .mst_edit_add_investment input[name="to_amount"]').val();
			var url = baseURL+"proc_vendor/master_entry_add/investment_master";
		}
		else if(current_action=="edit") {
			var min_value = $('#EditInvestmentMasterMODEL .mst_edit_add_investment input[name="from_amount"]').val();
			var max_value = $('#EditInvestmentMasterMODEL .mst_edit_add_investment input[name="to_amount"]').val();
			var url = baseURL+"proc_vendor/master_entry_edit/investment_master";
		}
		else { var url = false; }

		if (url!=false) {
			if ((parseInt(min_value) >= parseInt(max_value)) || (parseInt(min_value) <= 0 || parseInt(max_value) <= 0)) { alert("Min value can't be grater than or equal to Max value"); }
			else { submit_form_data(form_data,url); }
		}
		else { alert("Something is wrong!"); }
	});

	$(document).on('focusout','.mwp_id_chek_investmentMST',function()
	{
	    var mwp_id = $(this).val();
	   	if (mwp_id != "") {
		    var datas = {'mwp_id':mwp_id};
		    chk_user_id(datas);
	    }
	    else { alert("Enter MWP ID!"); }
	});

	$(document).on('click','#EditInvestmentMaster',function()
	{
		var params=$(this).attr("params");	
		var arrPrams = params.split("~#~");
		let data_currency = '<?php foreach(get_currency_details() as $key => $value){ echo $key.","; } ?>';
		let arrCurrency = data_currency.split(",");
		let curr_option = '<option value="">Select</option>';
		let selected = "";
		for (let step = 0; step < arrCurrency.length; step++) {
			if(arrPrams[0]==arrCurrency[step]) { selected = "selected"; }
			else { selected = ""; }
			curr_option += `<option value="${arrCurrency[step]}" ${selected}>${arrCurrency[step]}</option>`;
		}

		$("#EditInvestmentMasterMODEL #htmlEditInvetment").html(`<div class="row wrapper">
        		<div class="col-sm-12">
        			<input type="hidden" name="type" value="edit">
        			<input type="hidden" name="tab_id" value="${arrPrams[5]}">
        			 <div class="mb-3">
            	<label for="recipient-name" class="col-form-label">Enter Currency & Amount Range <span style="color: red;">*</span></label>
              <div class="price-input">
                <div class="field one-field">
                  <select class="form-control" name="currency_code" required>
                    ${curr_option}
                  </select>
                </div>
               	
              <div class="field">
                <span>Min</span>
                <input type="number" class="input-min form-control" name="from_amount" value="${arrPrams[1]}" required>
              </div>
              <div class="separator">-</div>
              <div class="field">
                <span>Max</span>
                <input type="number" class="input-max form-control" name="to_amount" value="${arrPrams[2]}" required>
              </div>
      		</div>
        		</div>
        	</div>
        
        <div class="col-sm-3">		
          <div class="mb-3">
        	<label for="recipient-name" class="col-form-label">MWP ID <span style="color: red;">*</span></label>
        			<input type="text" id="mwp_id" placeholder="Enter MWP ID" class="form-control mwp_id_chek_investmentMST" name="user_ids" value="${arrPrams[3]}" required>
        	</div>
        	 </div>
          	<div class="col-sm-9">
	            <label for="message-text" class="col-form-label">Comment</label>
	           	<textarea class="form-control" name="comments">${arrPrams[4]}</textarea>
          	</div>
        	</div>`);

		$("#EditInvestmentMasterMODEL").modal("show");
	});








	function chk_user_id(datas)
	{
		var request_url = baseURL+"proc_vendor/check_user_mwp_id";
	    process_ajax(function(response)
	    {
			var res = JSON.parse(response);
			if (res.stat==false){ alert(res.errmsg); }
	    },request_url, datas, 'text');
	}
	function submit_form_data(datas,request_url)
	{
		process_ajax(function(response)
		{
			var res = JSON.parse(response);
			if (res.stat==true){ alert("Submit Success"); location.reload(); }
			else { alert(res.errmsg); }
		},request_url, datas, 'text');
	}
});
</script>