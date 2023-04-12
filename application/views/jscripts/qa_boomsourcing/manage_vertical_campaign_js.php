<script src="<?php echo base_url('libs/bower/jquery-validate/jquery.validate.min.js');?>"></script>
<script src="<?php echo base_url('libs/bower/jquery-validate/additional-methods.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('libs/bower/jquery-toast-plugin/js/jquery.toast.js');?>"></script>

<script type="text/javascript">
$(function(){

	const show_toast_notification = (params) =>{

        const { text,heading,icon,position } = params;

        $.toast({
            text: text, // Text that is to be shown in the toast
            heading: heading, // Optional heading to be shown on the toast
            icon: icon, // Type of toast icon
            showHideTransition: 'fade', // fade, slide or plain
            allowToastClose: true, // Boolean value true or false
            hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
            stack: 1, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
            position: position, // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
            textAlign: 'left',  // Text alignment i.e. left, right or center
            loader: true,  // Whether to show loader or not. True by default
            loaderBg: '#9EC600',  // Background color of the toast loader
            beforeShow: function () {}, // will be triggered before the toast is shown
            afterShown: function () {}, // will be triggered after the toat has been shown
            beforeHide: function () {}, // will be triggered before the toast gets hidden
            afterHidden: function () {}  // will be triggered after the toast has been hidden
        });
    }

    /*For vertical*/

    const load_vertical_list = () => {

		$.ajax({
            url:"<?php echo base_url('Qa_boomsourcing_vertical_campaign/get_vertical_list');?>",
            type:'GET',
            dataType:"json",
            beforeSend: function(){
               $("#vertical-table-data").html(`<tr><td colspan="3" class="text-center text-bold" style="text-align: center !important;"><i class="fas fa-spinner fa-spin"></i>&nbsp;Please Wait..</td></tr>`);
            },
            success:function(response){

            	const {data} = response;
            	let html = '';

            	if (data.length != 0) {
	            	for (const [key, item] of Object.entries(data)) {
	               		 
	               		 html += `<tr class="text-center">
                                    <td>${parseInt(key) + 1}</td>
                                    <td>${item.vertical}</td>
                                    <td>
                                    	<button class="btn btn-sm btn-${item.is_active == 1 ? 'success make-inactive-vertical' : 'danger make-active-vertical'}" style="width: 79px;" vertical-id="${item.id}">
                                    	${item.is_active == 1 ? '<i class="fas fa-check"></i>&nbsp;Active' : '<i class="fas fa-ban"></i>&nbsp;Inactive'}
                                    	</button>&nbsp;
                                    	<button class="btn btn-warning btn-sm  edit-vertical" vertical-id="${item.id}"  data-toggle="modal" data-target="#add-edit-vertical-modal"><i class="fas fa-edit"></i>&nbsp;Edit</button>
                                    </td>
                                </tr>`;

	            	}
	            }else {

                    html = `<tr>
                              <td colspan="3" class="text-center text-bold" style="text-align: center !important;">No Data Available</td>
                            </tr>`;
                }

                $("#vertical-table-data").html(html);
            }
        })
	}

	load_vertical_list();

	$.validator.setDefaults({errorClass:"invalid-feedback",highlight:function(i){$(i),$(i).addClass("is-invalid").removeClass("is-valid")},unhighlight:function(i){$(i),$(i).addClass("is-valid").removeClass("is-invalid")},errorPlacement:function(i,e){"checkbox"===e.prop("type")?i.insertAfter(e.parent()):i.insertAfter(e)}});

	/*Add Edit vertical*/
	$(document).on('click','.add-vertical-btn',function(){

		$('#add-edit-vertical-modal-label').text('Add Vertical');
		$('#verticalSubmitType').val('add');
		$('#verticalEditId').val('');
		e = document.forms["add-edit-vertical-modal-form"].querySelectorAll('input,select,textarea');
		for (var i = 0; i < e.length; i++) {
			$('#add-edit-vertical-modal-form input,select,textarea').removeClass('is-valid');
		}

		$("#add-edit-vertical-modal-form")[0].reset();
	});

	$(document).on('click','.edit-vertical',function(){

		$('#add-edit-vertical-modal-label').text('Edit Vertical');
		$('#verticalSubmitType').val('edit');
		$('#add-edit-vertical-save-btn').prop('disabled',true);
		$('#verticalName').prop('disabled',true);

		e = document.forms["add-edit-vertical-modal-form"].querySelectorAll('input,select,textarea');
		for (var i = 0; i < e.length; i++) {
			$('#add-edit-vertical-modal-form input,select,textarea').removeClass('is-invalid');
			$('#add-edit-vertical-modal-form input,select,textarea').removeClass('is-valid');
		}
		$('#verticalName-error').remove();

		let verticalId = $(this).attr('vertical-id');

		$.ajax({
            url:"<?php echo base_url('Qa_boomsourcing_vertical_campaign/get_vertical_by_id');?>",
            type:'POST',
            data:{verticalId},
            dataType:"json",
            success:function(response){
                
               $('#verticalEditId').val(response.verticalId);
               $('#verticalName').val(response.verticalName);
               $('#add-edit-vertical-save-btn').prop('disabled',false);
               $('#verticalName').prop('disabled',false);
            }
        })
	});

	$("#add-edit-vertical-modal-form").validate({
	    rules: {
	        addNewVerticalName: {
	            normalizer: function (value) {
	                return $.trim(value);
	            },
	            required: true,
	            minlength: 3
	        }
	    },
	    submitHandler: function (form) {

	    	const verticalSubmitType = $('#verticalSubmitType').val();

	    	if(verticalSubmitType == 'add'){

	    		$.ajax({
	                url:"<?php echo base_url('Qa_boomsourcing_vertical_campaign/add_new_vertical');?>",
	                type:form.method,
	                data:$(form).serialize(),
	                dataType:"json",
	                beforeSend: function() {
                        $('#add-edit-vertical-save-btn').html('<i class="fas fa-spinner fa-spin"></i>&nbsp;Please Wait..');
                    },
	                success:function(response){
	                    
	                    if(response.success){
	                    	show_toast_notification({text:response.msg,heading:'Success',icon:'success',position:'bottom-right'});

	                    	$('#add-edit-vertical-save-btn').text('Save');

	                    	$('#add-edit-vertical-modal').modal('toggle');

	                    	e = document.forms["add-edit-vertical-modal-form"].querySelectorAll('input,select,textarea');
							for (var i = 0; i < e.length; i++) {
								$('#add-edit-vertical-modal-form input,select,textarea').removeClass('is-valid');
							}

							$("#add-edit-vertical-modal-form")[0].reset();

	                    	load_vertical_list();
	                    }
	                    else
	                    {
	                    	show_toast_notification({text:response.msg,heading:'Error',icon:'error',position:'bottom-right'});
	                    }
	                }
	            })
	    	}
	    	else if(verticalSubmitType == 'edit'){

	    		$.ajax({
	                url:"<?php echo base_url('Qa_boomsourcing_vertical_campaign/update_vertical');?>",
	                type:form.method,
	                data:$(form).serialize(),
	                dataType:"json",
	                beforeSend: function() {
                        $('#add-edit-vertical-save-btn').html('<i class="fas fa-spinner fa-spin"></i>&nbsp;Please Wait..');
                    },
	                success:function(response){
	                    
	                    if(response.success){

	                    	show_toast_notification({text:response.msg,heading:'Success',icon:'success',position:'bottom-right'});

	                    	$('#add-edit-vertical-save-btn').text('Save');

	                    	$('#add-edit-vertical-modal').modal('toggle');

	                    	e = document.forms["add-edit-vertical-modal-form"].querySelectorAll('input,select,textarea');
							for (var i = 0; i < e.length; i++) {
								$('#add-edit-vertical-modal-form input,select,textarea').removeClass('is-valid');
							}

							$("#add-edit-vertical-modal-form")[0].reset();

	                    	load_vertical_list();
	                    }
	                    else
	                    {
	                    	show_toast_notification({text:response.msg,heading:'Error',icon:'error',position:'bottom-right'});
	                    }
	                }
	            })
	    	}
	    }
	});

	$(document).on('click','.make-inactive-vertical',function(){

        let verticalId = $(this).attr('vertical-id');
        $(this).html(`<i class="fas fa-spinner fa-spin"></i>&nbsp;Wait..`)
        change_vertical_active_in_active_status({verticalId,status:0});
    });

	$(document).on('click','.make-active-vertical',function(){

        let verticalId = $(this).attr('vertical-id');
        $(this).html(`<i class="fas fa-spinner fa-spin"></i>&nbsp;Wait..`)
        change_vertical_active_in_active_status({verticalId,status:1});
    });

    const change_vertical_active_in_active_status = (params) =>{

        const {verticalId,status} = params;

        $.ajax({
            url:"<?php echo base_url('Qa_boomsourcing_vertical_campaign/change_vertical_active_in_active_status');?>",
            type:"POST",
            data:{ verticalId,status },
            dataType:"json",
            success:function(response){

                if(response.success){

                    show_toast_notification({text:response.msg,heading:'Success',icon:'success',position:'bottom-right'});    
                }
                else
                {
                    show_toast_notification({text:response.msg,heading:'Error',icon:'error',position:'bottom-right'});
                }

                load_vertical_list();
            }
        })
    }
	
	/*Form campaign*/


    const load_campaign_list = () => {

		$.ajax({
            url:"<?php echo base_url('Qa_boomsourcing_vertical_campaign/get_campaign_list');?>",
            type:'GET',
            dataType:"json",
            beforeSend: function(){
               $("#campaign-table-data").html(`<tr><td colspan="3" class="text-center text-bold" style="text-align: center !important;"><i class="fas fa-spinner fa-spin"></i>&nbsp;Please Wait..</td></tr>`);
            },
            success:function(response){

            	const {data} = response;
            	let html = '';

            	if (data.length != 0) {
	            	for (const [key, item] of Object.entries(data)) {
	               		 
	               		 html += `<tr class="text-center">
                                    <td>${parseInt(key) + 1}</td>
                                    <td>${item.campaign}</td>
                                    <td>
                                    	<button class="btn btn-sm btn-${item.is_active == 1 ? 'success make-inactive-campaign' : 'danger make-active-campaign'}" style="width: 79px;" campaign-id="${item.id}">
                                    	${item.is_active == 1 ? '<i class="fas fa-check"></i>&nbsp;Active' : '<i class="fas fa-ban"></i>&nbsp;Inactive'}
                                    	</button>&nbsp;
                                    	<button class="btn btn-warning btn-sm  edit-campaign" campaign-id="${item.id}"  data-toggle="modal" data-target="#add-edit-campaign-modal"><i class="fas fa-edit"></i>&nbsp;Edit</button>
                                    </td>
                                </tr>`;

	            	}
	            }else {

                    html = `<tr>
                              <td colspan="3" class="text-center text-bold" style="text-align: center !important;">No Data Available</td>
                            </tr>`;
                }

                $("#campaign-table-data").html(html);
            }
        })
	}

	load_campaign_list();

	/*Add Edit campaign*/
	$(document).on('click','.add-campaign-btn',function(){

		$('#add-edit-campaign-modal-label').text('Add Campaign');
		$('#campaignSubmitType').val('add');
		$('#campaignEditId').val('');
		e = document.forms["add-edit-campaign-modal-form"].querySelectorAll('input,select,textarea');
		for (var i = 0; i < e.length; i++) {
			$('#add-edit-campaign-modal-form input,select,textarea').removeClass('is-valid');
		}

		$("#add-edit-campaign-modal-form")[0].reset();
	});

	$(document).on('click','.edit-campaign',function(){

		$('#add-edit-campaign-modal-label').text('Edit Campaign');
		$('#campaignSubmitType').val('edit');
		$('#add-edit-campaign-save-btn').prop('disabled',true);
		$('#campaignName').prop('disabled',true);

		e = document.forms["add-edit-campaign-modal-form"].querySelectorAll('input,select,textarea');
		for (var i = 0; i < e.length; i++) {
			$('#add-edit-campaign-modal-form input,select,textarea').removeClass('is-invalid');
			$('#add-edit-campaign-modal-form input,select,textarea').removeClass('is-valid');
		}
		$('#campaignName-error').remove();

		let campaignId = $(this).attr('campaign-id');

		$.ajax({
            url:"<?php echo base_url('Qa_boomsourcing_vertical_campaign/get_campaign_by_id');?>",
            type:'POST',
            data:{campaignId},
            dataType:"json",
            success:function(response){
                
               $('#campaignEditId').val(response.campaignId);
               $('#campaignName').val(response.campaignName);
               $('#add-edit-campaign-save-btn').prop('disabled',false);
               $('#campaignName').prop('disabled',false);
            }
        })
	});

	$("#add-edit-campaign-modal-form").validate({
	    rules: {
	        addNewCampaignName: {
	            normalizer: function (value) {
	                return $.trim(value);
	            },
	            required: true,
	            minlength: 3
	        }
	    },
	    submitHandler: function (form) {

	    	const campaignSubmitType = $('#campaignSubmitType').val();

	    	if(campaignSubmitType == 'add'){

	    		$.ajax({
	                url:"<?php echo base_url('Qa_boomsourcing_vertical_campaign/add_new_campaign');?>",
	                type:form.method,
	                data:$(form).serialize(),
	                dataType:"json",
	                beforeSend: function() {
                        $('#add-edit-campaign-save-btn').html('<i class="fas fa-spinner fa-spin"></i>&nbsp;Please Wait..');
                    },
	                success:function(response){
	                    
	                    if(response.success){
	                    	show_toast_notification({text:response.msg,heading:'Success',icon:'success',position:'bottom-right'});

	                    	$('#add-edit-campaign-save-btn').text('Save');

	                    	$('#add-edit-campaign-modal').modal('toggle');

	                    	e = document.forms["add-edit-campaign-modal-form"].querySelectorAll('input,select,textarea');
							for (var i = 0; i < e.length; i++) {
								$('#add-edit-campaign-modal-form input,select,textarea').removeClass('is-valid');
							}

							$("#add-edit-campaign-modal-form")[0].reset();

	                    	load_campaign_list();
	                    }
	                    else
	                    {
	                    	show_toast_notification({text:response.msg,heading:'Error',icon:'error',position:'bottom-right'});
	                    }
	                }
	            })
	    	}
	    	else if(campaignSubmitType == 'edit'){

	    		$.ajax({
	                url:"<?php echo base_url('Qa_boomsourcing_vertical_campaign/update_campaign');?>",
	                type:form.method,
	                data:$(form).serialize(),
	                dataType:"json",
	                beforeSend: function() {
                        $('#add-edit-campaign-save-btn').html('<i class="fas fa-spinner fa-spin"></i>&nbsp;Please Wait..');
                    },
	                success:function(response){
	                    
	                    if(response.success){

	                    	show_toast_notification({text:response.msg,heading:'Success',icon:'success',position:'bottom-right'});

	                    	$('#add-edit-campaign-save-btn').text('Save');

	                    	$('#add-edit-campaign-modal').modal('toggle');

	                    	e = document.forms["add-edit-campaign-modal-form"].querySelectorAll('input,select,textarea');
							for (var i = 0; i < e.length; i++) {
								$('#add-edit-campaign-modal-form input,select,textarea').removeClass('is-valid');
							}

							$("#add-edit-campaign-modal-form")[0].reset();

	                    	load_campaign_list();
	                    }
	                    else
	                    {
	                    	show_toast_notification({text:response.msg,heading:'Error',icon:'error',position:'bottom-right'});
	                    }
	                }
	            })
	    	}
	    }
	});

	$(document).on('click','.make-inactive-campaign',function(){

        let campaignId = $(this).attr('campaign-id');
        $(this).html(`<i class="fas fa-spinner fa-spin"></i>&nbsp;Wait..`)
        change_campaign_active_in_active_status({campaignId,status:0});
    });

	$(document).on('click','.make-active-campaign',function(){

        let campaignId = $(this).attr('campaign-id');
        $(this).html(`<i class="fas fa-spinner fa-spin"></i>&nbsp;Wait..`)
        change_campaign_active_in_active_status({campaignId,status:1});
    });

    const change_campaign_active_in_active_status = (params) =>{

        const {campaignId,status} = params;

        $.ajax({
            url:"<?php echo base_url('Qa_boomsourcing_vertical_campaign/change_campaign_active_in_active_status');?>",
            type:"POST",
            data:{ campaignId,status },
            dataType:"json",
            success:function(response){

                if(response.success){

                    show_toast_notification({text:response.msg,heading:'Success',icon:'success',position:'bottom-right'});    
                }
                else
                {
                    show_toast_notification({text:response.msg,heading:'Error',icon:'error',position:'bottom-right'});
                }

                load_campaign_list();
            }
        })
    }
});
</script>