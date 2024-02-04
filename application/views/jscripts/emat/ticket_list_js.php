<script src="<?php echo base_url() ."assets/emat/js/popper.min.js"; ?>"></script>
<script src="<?php echo base_url() ."assets/emat/js/jquery.overlayScrollbars.js"; ?>"></script>
<script src="<?php echo base_url() ."assets/emat/js/wow.js"; ?>"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/daterangepicker/daterangepicker.js"></script>

<?php if(!empty($show_editor) && $show_editor == 1){ ?>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<?php } ?>

<?php if(!empty($show_table) && $show_table == 1){ ?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap.min.js"></script>
<?php } ?>

<script>
$('.oldDatePick').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('.newDatePick').datepicker({ dateFormat: 'mm/dd/yy' });
$('.timeFormat').timepicker({ timeFormat: 'HH:mm:ss', });
$('.box').overlayScrollbars({
	className: "os-theme-round-dark",
	resize: "both",
	sizeAutoCapable : true,
	paddingAbsolute : true
}); 


<?php if(!empty($show_editor) && $show_editor == 1){ ?>

my_toolBar = [
	{
	  "name": "basicstyles",
	  "groups": ["basicstyles"]
	},
	{
	  "name": "links",
	  "groups": ["links"]
	},
	{
	  "name": "paragraph",
	  "groups": ["list", "blocks"]
	},
	/*{
	  "name": "document",
	  "groups": ["mode"]
	},*/
	{
	  "name": "insert",
	  "groups": ["insert"]
	},
	{
	  "name": "styles",
	  "groups": ["styles"]
	},
];
	
CKEDITOR.replace('moreInfoEditor', {
	toolbarGroups: my_toolBar,
	removePlugins: 'about',
	removeButtons: 'Strike,Subscript,Superscript,Anchor,Specialchar',
	enterMode : CKEDITOR.ENTER_BR,
	height  : '300px',
	disableNativeSpellChecker : false,
	//customConfig: '<?php echo base_url(); ?>assets/ckeditor/configCustom.js',
	on: {
		instanceReady: function (evt) {
		evt.editor.document.getBody().setStyles({color: 'black', 'font-size': '11px', 'font-family': 'cambria'})
		}
	}
});
CKEDITOR.replace('moreInfoEditor2', {
	toolbarGroups: my_toolBar,
	removePlugins: 'about',
	removeButtons: 'Strike,Subscript,Superscript,Anchor,Specialchar',
	enterMode : CKEDITOR.ENTER_BR,
	disableNativeSpellChecker : false,
	height  : '300px',
	//customConfig: '<?php echo base_url(); ?>assets/ckeditor/configCustom.js',
	on: {
		instanceReady: function (evt) {
		evt.editor.document.getBody().setStyles({color: 'black', 'font-size': '11px', 'font-family': 'cambria'})
		}
	}
});
CKEDITOR.replace('moreInfoEditorEdit', {
	toolbarGroups: my_toolBar,
	removePlugins: 'about',
	removeButtons: 'Strike,Subscript,Superscript,Anchor,Specialchar',
	enterMode : CKEDITOR.ENTER_BR,
	disableNativeSpellChecker : false,
	height  : '300px',
	on: {
		instanceReady: function (evt) {
		evt.editor.document.getBody().setStyles({color: 'black', 'font-size': '11px', 'font-family': 'cambria'})
		}
	}
});
<?php } ?>

$('.masterEmailRow').on('keyup', 'input[name="email_id"]', function(){
	curVal = $(this).closest('.masterEmailRow').find('input[name="email_id"]').val();
	authType = $(this).closest('.masterEmailRow').find('select[name="auth_type"]').val();
	$(this).closest('.masterEmailRow').find('input[name="auth_email"]').val(curVal);
	$(this).closest('.masterEmailRow').find('input[name="auth_email"]').attr('readonly', 'readonly');
	if(authType == "shared"){
		$(this).closest('.masterEmailRow').find('input[name="auth_email"]').removeAttr('readonly', 'readonly');
	}
});

$('.masterEmailRow').on('change', 'select[name="auth_type"]', function(){
	curVal = $(this).closest('.masterEmailRow').find('input[name="email_id"]').val();
	authType = $(this).closest('.masterEmailRow').find('select[name="auth_type"]').val();
	$(this).closest('.masterEmailRow').find('input[name="auth_email"]').val(curVal);
	$(this).closest('.masterEmailRow').find('input[name="auth_email"]').attr('readonly', 'readonly');
	if(authType == "shared"){
		$(this).closest('.masterEmailRow').find('input[name="auth_email"]').val('');
		$(this).closest('.masterEmailRow').find('input[name="auth_email"]').removeAttr('readonly', 'readonly');
	}
});


$('#modalEmailDetails').on('click', '.editMasterMailFolder', function(){
	baseURL = "<?php echo base_url(); ?>";
	eidVal = $(this).attr('eid');
	curVal = $(this).attr('folder');
	$('#sktPleaseWait').modal('show');
	$.ajax({
		url: "<?php echo base_url('emat/move_master_email_folder'); ?>",
		type: "GET",
		data: { eid : eidVal, folder : curVal },
		dataType: "text",
		success : function(token){
			$('#sktPleaseWait').modal('hide');
			alert('Complete Folder Updated Successfully!');
			$('#modalEmailDetails').modal('hide');
			//window.location.reload();
		},
		error : function(token){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});

notReply = 0;

//======= MASTER EMAIL ==============//
$('.editMasterMail').click(function(){
	baseURL = "<?php echo base_url(); ?>";
	eidVal = $(this).attr('eid');
	$('#sktPleaseWait').modal('show');
	$.ajax({
		url: "<?php echo base_url('emat/master_email_ajax'); ?>",
		type: "GET",
		data: { eid : eidVal },
		dataType: "json",
		success : function(token){
			$('#sktPleaseWait').modal('hide');
			$('#frmUpdateEmail input[name="edit_id"]').val(token.id);
			$('#frmUpdateEmail input[name="email_name"]').val(token.email_name);
			$('#frmUpdateEmail input[name="email_id"]').val(token.email_id);
			$('#frmUpdateEmail select[name="email_type"]').val(token.type);
			$('#frmUpdateEmail select[name="auth_type"]').val(token.auth_type);
			$('#frmUpdateEmail input[name="auth_email"]').val(token.auth_email);
			$('#frmUpdateEmail input[name="email_password"]').val(token.password);
			$('#frmUpdateEmail input[name="email_sla"]').val(token.ticket_sla);			
			$('#frmUpdateEmail input[name="email_prefix"]').val(token.ticket_prefix);			
			$('#frmUpdateEmail select[name="email_ticket"]').val(token.ticket_serial);			
			$('#modalUpdateEmail').modal('show');
		},
		error : function(token){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});

$('.editMasterMailSettings').click(function(){
	baseURL = "<?php echo base_url(); ?>";
	eidVal = $(this).attr('eid');
	$('#sktPleaseWait').modal('show');
	$.ajax({
		url: "<?php echo base_url('emat/master_email_ajax'); ?>",
		type: "GET",
		data: { eid : eidVal },
		dataType: "json",
		success : function(token){
			$('#sktPleaseWait').modal('hide');
			$('#frmUpdateEmailSettings input[name="edit_id"]').val(token.id);
			$('#frmUpdateEmailSettings input[name="email_name"]').val(token.email_name);
			$('#frmUpdateEmailSettings input[name="email_id"]').val(token.email_id);			
			$('#frmUpdateEmailSettings input[name="email_sla"]').val(token.ticket_sla);			
			$('#frmUpdateEmailSettings select[name="is_show_send"]').val(token.is_show_send);			
			$('#frmUpdateEmailSettings select[name="is_show_autocomplete"]').val(token.is_show_autocomplete);			
			$('#frmUpdateEmailSettings select[name="is_show_outlook"]').val(token.is_show_outlook);			
			$('#frmUpdateEmailSettings select[name="is_show_forward"]').val(token.is_show_forward);			
			$('#frmUpdateEmailSettings select[name="is_emat_active"]').val(token.is_active);			
			$('#modalUpdateEmailSettings').modal('show');
		},
		error : function(token){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});


$('.editMasterMailFolder').click(function(){
	baseURL = "<?php echo base_url(); ?>";
	eidVal = $(this).attr('eid');
	$('#sktPleaseWait').modal('show');
	$('#modalEmailDetails .modal-title').html('Set Maibox Complete Folder');
	$('#modalEmailDetails .modal-body').html('');
	$.ajax({
		url: "<?php echo base_url('emat/master_email_folder_ajax'); ?>",
		type: "GET",
		data: { eid : eidVal },
		dataType: "text",
		success : function(token){
			$('#sktPleaseWait').modal('hide');		
			$('#modalEmailDetails .modal-body').html(token);
			$('#modalEmailDetails').modal('show');
		},
		error : function(token){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});

$('.activateEmailVerify').click(function(){
	baseURL = "<?php echo base_url(); ?>";
	eidVal = $(this).attr('eid');
	$('#sktPleaseWait').modal('show');
	$.ajax({
		url: "<?php echo base_url('emat/verify_email_login'); ?>",
		type: "GET",
		data: { eid : eidVal },
		dataType: "text",
		success : function(token){
			$('#sktPleaseWait').modal('hide');		
			$('#modalVerifyEmail .modalBodyEMATDesc').html(token);
			$('#modalVerifyEmail').modal('show');
		},
		error : function(token){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});

$('.updateEmailMessages').click(function(){
	baseURL = "<?php echo base_url(); ?>";
	eidVal = $(this).attr('bURL');
	$('#sktPleaseWait').modal('show');
	$.ajax({
		url: eidVal,
		type: "GET",
		//data: { eid : eidVal },
		dataType: "text",
		success : function(token){
			$('#sktPleaseWait').modal('hide');		
			$('#modalCronEmailMessage .modalBodyCronMessage').html(token);
			$('#modalCronEmailMessage').modal('show');
		},
		error : function(token){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});


//======= MASTER CATEGORY ==============//
$('.courseCatEdit').click(function(){
	baseURL = "<?php echo base_url(); ?>";
	eidVal = $(this).attr('eid');
	$('#sktPleaseWait').modal('show');
	$.ajax({
		url: "<?php echo base_url('emat/ticket_category_info_ajax'); ?>",
		type: "GET",
		data: { eid : eidVal },
		dataType: "json",
		success : function(token){
			$('#sktPleaseWait').modal('hide');
			$('#frmUpdateEmatCategory input[name="edit_id"]').val(token.id);
			$('#frmUpdateEmatCategory select[name="email_id"]').val(token.emat_id);
			$('#frmUpdateEmatCategory input[name="category_code"]').val(token.category_code);
			$('#frmUpdateEmatCategory input[name="category_name"]').val(token.category_name);
			$('#frmUpdateEmatCategory input[name="category_sla"]').val(token.category_sla);
			$('#modalUpdateEmatCategory').modal('show');
		},
		error : function(token){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});

$('.catInfoCheck').click(function(){
	baseURL = "<?php echo base_url(); ?>";
	eidVal = $(this).attr('eid');
	$('#sktPleaseWait').modal('show');
	$('#modalEmailDetailsCat .modal-title').html('Categroy Info');
	$('#modalEmailDetailsCat .modal-body').html('');
	$.ajax({
		url: "<?php echo base_url('emat/ticket_category_info_details'); ?>",
		type: "GET",
		data: { eid : eidVal },
		dataType: "text",
		success : function(token){
			$('#sktPleaseWait').modal('hide');
			$('#modalEmailDetailsCat .modal-body').html(token);
			$('#modalEmailDetailsCat').modal('show');
		},
		error : function(token){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});

$('.courseCatEditInfo').click(function(){
	baseURL = "<?php echo base_url(); ?>";
	eidVal = $(this).attr('eid');
	$('#sktPleaseWait').modal('show');
	$.ajax({
		url: "<?php echo base_url('emat/ticket_category_info_ajax'); ?>",
		type: "GET",
		data: { eid : eidVal },
		dataType: "json",
		success : function(token){
			$('#sktPleaseWait').modal('hide');
			$('#frmUpdateEmatCategoryInfo input[name="edit_id"]').val(token.id);
			$('#frmUpdateEmatCategoryInfo select[name="email_id"]').val(token.emat_id);
			CKEDITOR.instances['moreInfoEditor'].setData(token.category_info);
			$('#modalUpdateEmatCategoryInfo').modal('show');
		},
		error : function(token){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});

//======= CANNED MESSAGE ==============//
$('.cannedEdit').click(function(){
	baseURL = "<?php echo base_url(); ?>";
	eidVal = $(this).attr('eid');
	$('#sktPleaseWait').modal('show');
	$.ajax({
		url: "<?php echo base_url('emat/master_canned_message_ajax'); ?>",
		type: "GET",
		data: { eid : eidVal },
		dataType: "json",
		success : function(token){
			$('#sktPleaseWait').modal('hide');
			$('#frmUpdateEmailCanned input[name="edit_id"]').val(token.id);
			$('#frmUpdateEmailCanned input[name="message_name"]').val(token.canned_name);
			//$('#frmUpdateEmailCanned textarea[name="message_body"]').html(token.canned_message);
			$('#frmUpdateEmailCanned select[name="mail_box[]"]').val(token.mail_box.split(','));
			CKEDITOR.instances['moreInfoEditorEdit'].setData(token.canned_message);
			$('.agentWidget select[name="mail_box[]"]').select2();
			$('#modalUpdateEmailCanned').modal('show');
		},
		error : function(token){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});

<?php if(!e_rta_access()){ ?>

//==== TICKET INFO DIV ==========//	
$('.ticketListDiv').on('click', '.ticketInfoDiv', function(){
	baseURL = "<?php echo base_url(); ?>";
	ticketNo = $(this).attr('ticket');
	$('#sktPleaseWait').modal('show');
	$('.ticketInfoDetails').html('');
	$.ajax({
		url: "<?php echo base_url('emat/ticket_details_ajax'); ?>",
		type: "GET",
		data: { ticket_no : ticketNo },
		dataType: "text",
		success : function(result){
			$('#sktPleaseWait').modal('hide');			
			$('.ticketListDiv #t'+ticketNo).html(result);
			$('.ticketListDiv #arrival_date').datepicker({ dateFormat: 'mm/dd/yy' });
			$('.box').overlayScrollbars({
				className: "os-theme-round-dark",
				resize: "both",
				sizeAutoCapable : true,
				paddingAbsolute : true
			}); 
		},
		error : function(result){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});

//==== TICKET INFO DIV ==========//	
$('.ticketListDiv').on('click', '.arrivalDIVInfoTrigger', function(){
	$('.ticketListDiv .arrivalDIVInfo').show();
});

$('.ticketListDiv').on('click', '.arrivalDIVInfoUpdater', function(){
	arrival_ticket_no = $(this).closest('.arrivalDIVInfo').find('input[name="arrival_ticket_no"]').val();
	arrival_date = $(this).closest('.arrivalDIVInfo').find('input[name="arrival_date"]').val();
	if(arrival_date != "" && arrival_ticket_no != ""){
		$('#sktPleaseWait').modal('show');
		$.ajax({
			url: "<?php echo base_url('emat/ticket_arrival_date_update'); ?>",
			type: "GET",
			data: { arrival_date : arrival_date, ticket_no : arrival_ticket_no },
			dataType: "text",
			success : function(result){
				$('#sktPleaseWait').modal('hide');
				window.location.reload();
			},
			error : function(result){
				$('#sktPleaseWait').modal('hide');
				alert('Something Went Wrong!');
			}
		});
	} else {
		alert('Please Select Appropriate Date!');
	}
});

$('.arrivalBlock').on('click', '.arrivalDIVInfoUpdater', function(){
	arrival_ticket_no = $(this).closest('.arrivalDIVInfo').find('input[name="arrival_ticket_no"]').val();
	arrival_date = $(this).closest('.arrivalDIVInfo').find('input[name="arrival_date"]').val();
	if(arrival_date != "" && arrival_ticket_no != ""){
		$('#sktPleaseWait').modal('show');
		$.ajax({
			url: "<?php echo base_url('emat/ticket_arrival_date_update'); ?>",
			type: "GET",
			data: { arrival_date : arrival_date, ticket_no : arrival_ticket_no },
			dataType: "text",
			success : function(result){
				$('#sktPleaseWait').modal('hide');
				alert('Arrival Date has been updated!');
			},
			error : function(result){
				$('#sktPleaseWait').modal('hide');
				alert('Something Went Wrong!');
			}
		});
	} else {
		alert('Please Select Appropriate Date!');
	}
});


//==== TICKET DUPLICATE INFO DIV ==========//	
$('.ticketListDiv').on('click', '.ticketInfoDivDuplicate', function(){
	baseURL = "<?php echo base_url(); ?>";
	ticketNo = $(this).attr('ticket');
	dticketNo = $(this).attr('dticket');
	$('#sktPleaseWait').modal('show');
	$('.ticketListDiv .ticketInfoDetailsDuplicate').html('');
	$.ajax({
		url: "<?php echo base_url('emat/ticket_details_ajax'); ?>",
		type: "GET",
		data: { ticket_no : ticketNo, finder: 1 },
		dataType: "text",
		success : function(result){
			$('#sktPleaseWait').modal('hide');			
			$('.ticketListDiv #dt_'+dticketNo +'_'+ticketNo).html(result);
			$('.box').overlayScrollbars({
				className: "os-theme-round-dark",
				resize: "both",
				sizeAutoCapable : true,
				paddingAbsolute : true
			}); 
		},
		error : function(result){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});

<?php } ?>

<?php if(!empty($showtimer)){ ?>
// STOPWATCH TIMER
startDateTimer = new Date();
startTimer();
function startTimer(){
	var total_seconds = (new Date() - startDateTimer) / 1000;   
	var newTime = new Date(null);
	newTime.setSeconds(total_seconds);
	var result = newTime.toISOString().substr(11, 8);
	$("#timeWatch").html(result);
	$("#time_interval").val(result);
	$("#time_interval_notes").val(result);
	$("#time_interval_update").val(result);
	setTimeout(function(){startTimer()}, 1000);
}

startDateTimerNew = new Date();
startTimerNew();
function startTimerNew(){
	var total_seconds = (new Date() - startDateTimerNew) / 1000;   
	var newTime = new Date(null);
	newTime.setSeconds(total_seconds);
	var result = newTime.toISOString().substr(11, 8);
	$("#timeWatchNew").html(result);
	setTimeout(function(){startTimerNew()}, 1000);
}

function startHoldNew(startDate){
	var total_seconds = (new Date() - startDate) / 1000;   
	var newTime = new Date(null);
	newTime.setSeconds(total_seconds);
	var result = newTime.toISOString().substr(11, 8);
	$("#timer_hold").val(result);
	//$('.inHold span').html(result);	
	timerHoldStatus = $("#timer_hold_status").val();
	if(timerHoldStatus == 'H'){
		//$('.inHold').show();
		//$('.inCall, .inWait').hide();
		$("#timer_start_status").val('H');
		timeOutVar = setTimeout(function(){startHoldNew(startDate)}, 1000);
		console.log('hi');
	} else {
		clearTimeout(timeOutVar);
		$("#timer_hold").val('');
		$("#timer_hold_status").val('H');	
		console.log('byee');
	}
}

function startHoldEnd(){
	holded = $("#timer_hold").val();
	holdedNo = $('#hold_reason_count').val();
	//$("#timeHolder").append('Hold ' + holdedNo + ' - ' + holded + '<br/>');
	pastHold = getSeconds($('#hold_interval').val());
	currentHold = getSeconds(holded);
	var newTime = new Date(null);
	newTime.setSeconds(Number(pastHold) + Number(currentHold));
	var result = newTime.toISOString().substr(11, 8);
	$('#hold_interval').val(result);
	$('#hold_interval_notes').val(result);
	$('#hold_reason_count').val(Number(holdedNo) + 1);
	$('#hold_reason_count_notes').val(Number(holdedNo) + 1);
	$("#timer_hold_status").val('U');
	$('#modal_hold_reason').val('');
}

function getSeconds(time)
{
    var ts = time.split(':');
    return Date.UTC(1970, 0, 1, ts[0], ts[1], ts[2]) / 1000;
}


function callActionButton(current){
	callType = $(current).attr('btype');	
	if(callType == 'hold'){
		reasonHold = $('#modal_hold_reason').val();
		reasonOption = $('#modal_hold_option').val();
		if(reasonHold != ""){
			startHoldNew(new Date());
			$('#holdCallModal').modal('hide');
			$('#unholdCallModal').modal('show');
		} else {
			alert('Please Enter the Reason!');
		}
	}
	if(callType == 'unhold'){ 
		startHoldEnd(); 
		$('#unholdCallModal').modal('hide');
		$('#holdCallModal').modal('hide');
	}
}

<?php } ?>


$('.categoryFolderRow').on('change', 'select[name="email_id"]', function(){
	eid = $('.categoryFolderRow select[name="email_id"]').val();	
	$('#sktPleaseWait').modal('show');			
	$.ajax({
		url: "<?php echo base_url('emat/maste_emat_folder_ajax'); ?>",
		type: "GET",
		data: { eid : eid },
		dataType: "json",
		success : function(json_obj){
					
			var html = '';
			for (var i in json_obj){
				html += '<tr><td><input type="checkbox" name="folderCheckBox[]" value="'+json_obj[i].values+'"></td><td>'+json_obj[i].folder +'</td><td>'+json_obj[i].name+'</td><td>'+json_obj[i].code+'</td></tr>';
			}
			//datatable_refresh('.agentWidget #default-datatable', 1);
			$('.categoryFolderRow #allCategoryTableList').html(html);
			//datatable_refresh('.agentWidget #default-datatable');
			$('#sktPleaseWait').modal('hide');	
		},
		error : function(json_obj){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});


$('.agentWidget').on('change', 'select[name="office_id"],select[name="client_id"],select[name="process_id"],select[name="role_type"]', function(){
	pid = $('.agentWidget select[name="process_id"]').val();
	cid = $('.agentWidget select[name="client_id"]').val();
	oid = $('.agentWidget select[name="office_id"]').val();
	tid = $('.agentWidget select[name="role_type"]').val();
	if(pid == "" || cid == "" || oid == "" || tid == ""){
		
	} else {
	
	$('#sktPleaseWait').modal('show');			
	$.ajax({
		url: "<?php echo base_url('emat/master_agent_ajax'); ?>",
		type: "GET",
		data: { cid : cid, pid : pid, oid : oid, tid: tid },
		dataType: "json",
		success : function(json_obj){
					
			var html = '';
			for (var i in json_obj){
				html += '<tr><td><input type="checkbox" name="userCheckBox[]" value="'+json_obj[i].id+'"></td><td>'+json_obj[i].full_name +'</td><td>'+json_obj[i].fusion_id+'</td><td>'+json_obj[i].department+'</td><td>'+json_obj[i].designation+'</td></tr>';
			}
			//datatable_refresh('.agentWidget #default-datatable', 1);
			$('.agentWidget #allUserCheckTableList').html(html);
			//datatable_refresh('.agentWidget #default-datatable');
			$('#sktPleaseWait').modal('hide');	
		},
		error : function(json_obj){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
	}
});

$('.agentWidget').on('change', 'select[name="client_id"]', function(){
	cid = $('.agentWidget select[name="client_id"]').val();			
	$.ajax({
		url: "<?php echo base_url('emat/master_process_ajax'); ?>",
		type: "GET",
		data: { cid : cid },
		dataType: "json",
		success : function(json_obj){	
			var html = '<option value="">-- Select Process --</option>';
			for (var i in json_obj){
				html += '<option value="'+json_obj[i].id+'">'+json_obj[i].name +'</option>';
			}
			$('.agentWidget select[name="process_id"]').html(html);
		},
		error : function(json_obj){
			alert('Something Went Wrong!');
		}
	});
});

$(document).on('click','.selectAllUserCheckBox',function()
{
	if($(this).is(':checked'))
	{
		$('[name="userCheckBox[]"]').prop('checked',true);
	}
	else
	{
		$('[name="userCheckBox[]"]').prop('checked',false);
	}
});

<?php if(!empty($show_table) && $show_table == 1){ ?>
function datatable_refresh(id, type="")
{
	if(type!=''){
	$(id).dataTable().fnClearTable();
	$(id).dataTable().fnDestroy();
	}
	if(type==''){
	$(id).DataTable({
		paginate:false,
		bInfo:false
	});
	}
}

$('#default-datatable-list').DataTable({
	bInfo:false,
	pageLength:25
});
<?php } ?>

$('.agentWidget select[name="mail_box[]"]').select2();
$('.agentWidget select[name="category_id[]"]').select2();

$('.flipswitch-inner').click(function(){
	myval = $(this).closest('.flipswitch').find('.inputBlock').val();
	if(myval == '1')
	{
		$(this).closest('.flipswitch').find('.flipswitch-cb').prop('checked', false);
		$(this).closest('.flipswitch').find('.inputBlock').val('0');
	} else {
		$(this).closest('.flipswitch').find('.flipswitch-cb').prop('checked', true);
		$(this).closest('.flipswitch').find('.inputBlock').val('1');
	}
});


//==== DROPDOWN TOGGLE LIST ==========//	
$('.dropdownCapture').on('change', 'select[name="ticket_list_dropdown"]', function(){
	pageType = $(this).val();
	emailID = "<?php echo !empty($email_id) ? bin2hex($email_id) : 'view'; ?>";
	finalPage = "ticket_list";	
	if(pageType == 'pending'){
		finalPage = "ticket_unassigned";
	} else if(pageType == 'assigned'){
		finalPage = "ticket_pending";
	} else if(pageType == 'passed'){
		finalPage = "ticket_passed";
	} else if(pageType == 'completed'){
		finalPage = "ticket_completed";
	} else if(pageType == 'all'){
		finalPage = "ticket_list";
	} else {
		finalPage = "ticket_list";
	}	
	url = "<?php echo base_url(); ?>emat/" + finalPage + "/" + emailID;
	window.location.href = url;
});

$('.dropdownCapture').on('change', 'select[name="sort_list_dropdown"]', function(){
	sortSelection = $(this).val();
	sortemailID = "<?php echo !empty($email_id) ? $email_id : ''; ?>";
	if(sortemailID != "" && sortSelection != "")
	{
		$.ajax({
			url: "<?php echo base_url('emat/ticket_sort_list_update_ajax'); ?>",
			type: "GET",
			data: { sort_type : sortSelection, email_id : sortemailID,  },
			dataType: "text",
			success : function(token){
				window.location.reload();
			},
			error : function(token){
				//alert('Something Went Wrong!');
			}
		});		
	}	
});

<?php if(!empty($show_editor) && $show_editor == 1){ ?>

//======= CANNED MESSAGE ==============//
$('.cannedMaster').change(function(){
	baseURL = "<?php echo base_url(); ?>";
	eidVal = $(this).val();
	if(eidVal != ""){
	$('#sktPleaseWait').modal('show');
	$.ajax({
		url: "<?php echo base_url('emat/master_canned_message_ajax'); ?>",
		type: "GET",
		data: { eid : eidVal },
		dataType: "json",
		success : function(token){
			$('#sktPleaseWait').modal('hide');
			textData = CKEDITOR.instances['moreInfoEditor'].getData();
			finalData = textData + '<br/>' + token.canned_message;
			CKEDITOR.instances['moreInfoEditor'].setData(finalData);
		},
		error : function(token){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
	} else {
		
	}
});

<?php } ?>

//======= MASTER EMAIL ==============//
$('.notesSubmission').click(function(){
	baseURL = "<?php echo base_url(); ?>";
	ticket_no = $('.notesBlock input[name="ticket_no"]').val();
	time_interval_notes = $('.notesBlock input[name="time_interval_notes"]').val();
	ticket_notes = $('.notesBlock textarea[name="ticket_notes"]').val();
	hold_interval_notes = $('.notesBlock input[name="hold_interval_notes"]').val();
	hold_reason_count_notes = $('.notesBlock input[name="hold_reason_count_notes"]').val();
	hold_reason_notes = $('.notesBlock input[name="hold_reason_notes"]').val();
	$('#sktPleaseWait').modal('show');
	$.ajax({
		url: "<?php echo base_url('emat/ticket_add_notes'); ?>",
		type: "POST",
		data: { ticket_no : ticket_no, time_interval_notes : time_interval_notes, ticket_notes : ticket_notes, hold_interval_notes : hold_interval_notes, hold_reason_count_notes : hold_reason_count_notes, hold_reason_notes : hold_reason_notes  },
		dataType: "text",
		success : function(token){
			startDateTimer = new Date();
			startTimer();
			$('#sktPleaseWait').modal('hide');
			$('.notesBlock textarea[name="ticket_notes"]').val('');
			$("#hold_interval").val('00:00:00');
			$("#hold_reason_count").val('0');
			$("#hold_reason").val('');
			
			$("#hold_interval_notes").val('00:00:00');
			$("#hold_reason_count_notes").val('0');
			$("#hold_reason_notes").val('');
			$('.notesSectionShow').append(token);
		},
		error : function(token){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});

<?php if(!empty($show_editor) && $show_editor == 1){ ?>

$('.replySubmission').click(function(){
	baseURL = "<?php echo base_url(); ?>";
	ticket_no = $('.ticketFormReply input[name="ticket_no"]').val();
	mailing_to = $('.ticketFormReply input[name="mailing_to"]').val();
	mailing_cc = $('.ticketFormReply input[name="mailing_cc"]').val();
	mailing_subject = $('.ticketFormReply input[name="mailing_subject"]').val();
	time_interval_notes = $('.ticketFormReply input[name="time_interval"]').val();
	ticket_notes = CKEDITOR.instances['moreInfoEditor'].getData();
	ticket_last = CKEDITOR.instances['moreInfoEditor2'].getData();
	hold_interval_notes = $('.ticketFormReply input[name="hold_interval"]').val();
	hold_reason_count_notes = $('.ticketFormReply input[name="hold_reason_count"]').val();
	hold_reason_notes = $('.ticketFormReply input[name="hold_reason"]').val();
	$('#sktPleaseWait').modal('show');
	$.ajax({
		url: "<?php echo base_url('emat/ticket_close_reply'); ?>",
		type: "POST",
		data: { ticket_no : ticket_no, time_interval : time_interval_notes, message_body : ticket_notes, hold_interval : hold_interval_notes, hold_reason_count : hold_reason_count_notes, hold_reason : hold_reason_notes,
			message_body_trail :  ticket_last, mailing_to : mailing_to, mailing_cc : mailing_cc, mailing_subject : mailing_subject
		},
		dataType: "text",
		success : function(token){
			/*startDateTimer = new Date();
			startTimer();
			$('#sktPleaseWait').modal('hide');
			$('.notesBlock textarea[name="ticket_notes"]').val('');
			$("#hold_interval").val('00:00:00');
			$("#hold_reason_count").val('0');
			$("#hold_reason").val('');
			
			$("#hold_interval_notes").val('00:00:00');
			$("#hold_reason_count_notes").val('0');
			$("#hold_reason_notes").val('');
			$('.notesSectionShow').append(token);*/
			notReply = 1;
			$('#sktPleaseWait').modal('hide');
			window.location.reload();
		},
		error : function(token){
			notReply = 1;
			$('#sktPleaseWait').modal('hide');
			window.location.reload();
			//$('#sktPleaseWait').modal('hide');
			//alert('Something Went Wrong!');
		}
	});
});


$('.replySubmissionOutlook').click(function(){
	baseURL = "<?php echo base_url(); ?>";
	ticket_no = $('.ticketFormReply input[name="ticket_no"]').val();
	time_interval_notes = $('.ticketFormReply input[name="time_interval"]').val();
	ticket_notes = "";
	hold_interval_notes = $('.ticketFormReply input[name="hold_interval"]').val();
	hold_reason_count_notes = $('.ticketFormReply input[name="hold_reason_count"]').val();
	hold_reason_notes = $('.ticketFormReply input[name="hold_reason"]').val();
	$('#sktPleaseWait').modal('show');
	$.ajax({
		url: "<?php echo base_url('emat/ticket_auto_close_reply'); ?>",
		type: "POST",
		data: { ticket_no : ticket_no, time_interval : time_interval_notes, message_body : ticket_notes, hold_interval : hold_interval_notes, hold_reason_count : hold_reason_count_notes, hold_reason : hold_reason_notes  },
		dataType: "text",
		success : function(token){
			/*startDateTimer = new Date();
			startTimer();
			$('#sktPleaseWait').modal('hide');
			$('.notesBlock textarea[name="ticket_notes"]').val('');
			$("#hold_interval").val('00:00:00');
			$("#hold_reason_count").val('0');
			$("#hold_reason").val('');
			
			$("#hold_interval_notes").val('00:00:00');
			$("#hold_reason_count_notes").val('0');
			$("#hold_reason_notes").val('');
			$('.notesSectionShow').append(token);*/
			notReply = 1;
			$('#sktPleaseWait').modal('hide');
			window.location.reload();
		},
		error : function(token){
			notReply = 1;
			$('#sktPleaseWait').modal('hide');
			window.location.reload();
			//$('#sktPleaseWait').modal('hide');
			//alert('Something Went Wrong!');
		}
	});
});


$('.replySubmissionMove').click(function(){
	baseURL = "<?php echo base_url(); ?>";
	ticket_no = $('.ticketFormReply input[name="ticket_no"]').val();
	time_interval_notes = $('.ticketFormReply input[name="time_interval"]').val();
	ticket_notes = "";
	hold_interval_notes = $('.ticketFormReply input[name="hold_interval"]').val();
	hold_reason_count_notes = $('.ticketFormReply input[name="hold_reason_count"]').val();
	hold_reason_notes = $('.ticketFormReply input[name="hold_reason"]').val();
	$('#sktPleaseWait').modal('show');
	$.ajax({
		url: "<?php echo base_url('emat/ticket_mark_close_reply'); ?>",
		type: "POST",
		data: { ticket_no : ticket_no, time_interval : time_interval_notes, message_body : ticket_notes, hold_interval : hold_interval_notes, hold_reason_count : hold_reason_count_notes, hold_reason : hold_reason_notes  },
		dataType: "text",
		success : function(token){
			/*startDateTimer = new Date();
			startTimer();
			$('#sktPleaseWait').modal('hide');
			$('.notesBlock textarea[name="ticket_notes"]').val('');
			$("#hold_interval").val('00:00:00');
			$("#hold_reason_count").val('0');
			$("#hold_reason").val('');
			
			$("#hold_interval_notes").val('00:00:00');
			$("#hold_reason_count_notes").val('0');
			$("#hold_reason_notes").val('');
			$('.notesSectionShow').append(token);*/
			notReply = 1;
			$('#sktPleaseWait').modal('hide');
			window.location.reload();
		},
		error : function(token){
			notReply = 1;
			$('#sktPleaseWait').modal('hide');
			window.location.reload();
			//$('#sktPleaseWait').modal('hide');
			//alert('Something Went Wrong!');
		}
	});
});


$('.forwardSubmission').click(function(){
	$('#modalForwardEmail').modal('show');
});

$('.mailForwardSubmission').click(function(){
	baseURL = "<?php echo base_url(); ?>";
	ticket_no = $('.ticketFormReply input[name="ticket_no"]').val();
	forward_to = $('#modalForwardEmail input[name="forward_email_id"]').val();
	mailing_to = $('.ticketFormReply input[name="mailing_to"]').val();
	mailing_cc = $('.ticketFormReply input[name="mailing_cc"]').val();
	mailing_subject = $('.ticketFormReply input[name="mailing_subject"]').val();
	time_interval_notes = $('.ticketFormReply input[name="time_interval"]').val();
	ticket_notes = CKEDITOR.instances['moreInfoEditor'].getData();
	ticket_last = CKEDITOR.instances['moreInfoEditor2'].getData();
	hold_interval_notes = $('.ticketFormReply input[name="hold_interval"]').val();
	hold_reason_count_notes = $('.ticketFormReply input[name="hold_reason_count"]').val();
	hold_reason_notes = $('.ticketFormReply input[name="hold_reason"]').val();
	if(forward_to != ""){
		$('#sktPleaseWait').modal('show');
		$.ajax({
			url: "<?php echo base_url('emat/ticket_forward_reply'); ?>",
			type: "POST",
			data: { ticket_no : ticket_no, time_interval : time_interval_notes, message_body : ticket_notes, hold_interval : hold_interval_notes, hold_reason_count : hold_reason_count_notes, hold_reason : hold_reason_notes,
				message_body_trail :  ticket_last, mailing_to : mailing_to, mailing_cc : mailing_cc, mailing_subject : mailing_subject, forward_to : forward_to
			},
			dataType: "text",
			success : function(token){
				/*startDateTimer = new Date();
				startTimer();
				$('#sktPleaseWait').modal('hide');
				$('.notesBlock textarea[name="ticket_notes"]').val('');
				$("#hold_interval").val('00:00:00');
				$("#hold_reason_count").val('0');
				$("#hold_reason").val('');
				
				$("#hold_interval_notes").val('00:00:00');
				$("#hold_reason_count_notes").val('0');
				$("#hold_reason_notes").val('');
				$('.notesSectionShow').append(token);*/
				notReply = 1;
				$('#sktPleaseWait').modal('hide');
				window.location.reload();
			},
			error : function(token){
				notReply = 1;
				$('#sktPleaseWait').modal('hide');
				window.location.reload();
				//$('#sktPleaseWait').modal('hide');
				//alert('Something Went Wrong!');
			}
		});
	} else {
		alert('Please Fill Up All Details!');
	}
});

<?php } ?>

<?php if(!empty($show_close_confirm)){ ?>
<?php if(get_user_id() != 1 && get_user_id() != '8347'){ ?>
$(document).ready(function()
{
    $(window).bind("beforeunload", function() { 
        currentTicket = $('.ticketFormReply input[name="ticket_no"]').val();
        currentTime = $('.ticketFormReply #time_interval').val();
        currentHold = $('.ticketFormReply #hold_interval').val();
		if(notReply == 0){
		$.ajax({
			url: "<?php echo base_url('emat/ticket_add_auto_close_logs'); ?>",
			type: "POST",
			data: { ticket_no : currentTicket, time_interval : currentTime, ticket_hold : currentHold },
			dataType: "text",
			success : function(token){
				startDateTimer = new Date();
				startTimer();
			},
			error : function(token){
			}
		});
		return ('Are you sure you want to close ?');
		}
    });
});
<?php } ?>
<?php } ?>

$('#start_date').datepicker({ dateFormat:'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '2021:' + new Date().getFullYear().toString() });
$('#end_date').datepicker({ dateFormat:'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '2021:' + new Date().getFullYear().toString() });
function check_all(){
	if($("#check_all").prop('checked') == true){
    	$(".check_ticket").each(function() {
		  $( this ).prop( "checked", true );
		  $('.div_ticketAssignUpdate').css('display','block');
		});
	}else{
		$(".check_ticket").each(function() {
		  $( this ).prop( "checked", false );
		 $('.div_ticketAssignUpdate').css('display','none');
		});
	}
}

function boxchk(){
	var chk=0;
	$(".check_ticket").each(function() {
		if($(this).prop('checked') == true){
			chk=1;
		}
	});
	if(chk==1){
		 $('.div_ticketAssignUpdate').css('display','block');
	}else{
			 $('.div_ticketAssignUpdate').css('display','none');
	}
}

$('.moveEmail').click(function(){
	baseURL = "<?php echo base_url(); ?>";
	eidVal = $(this).attr('bURL');
	$('#sktPleaseWait').modal('show');
	$.ajax({
		url: eidVal,
		type: "GET",
		//data: { eid : eidVal },
		dataType: "text",
		success : function(token){
			$('#sktPleaseWait').modal('hide');		
			$('#modalCronEmailMessage .modalBodyCronMessage').html('Email Move Successfully');
			$('#modalCronEmailMessage').modal('show');
		},
		error : function(token){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
});

</script>