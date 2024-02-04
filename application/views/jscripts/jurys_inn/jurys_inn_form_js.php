<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/dataTables.bootstrap.min.js"></script>
<script>
$('.number-only').keyup(function(e) {
	if(this.value!='-')
	  while(isNaN(this.value))
		this.value = this.value.split('').reverse().join('').replace(/[\D]/i,'')
							   .split('').reverse().join('');
})
.on("cut copy paste",function(e){
	e.preventDefault();
});

$(".singleSelect").select2();



//==================== JURYS INN FORM UPDATE ====================================================================//

<?php if($content_template == "jurys_inn/jurys_inn_form_update.php"){ ?>
<?php if(!empty($crm_details)) { ?>
$(document).ready(function(){
	
$('#c_lob').val('<?php echo $crm_details['c_lob']; ?>').change();

updaterupdate();

function updaterupdate(){

get_jurys_sub_type_inn('<?php echo $crm_details['c_disposition']; ?>');

cid = $('option:selected','#c_lob').attr('lid');
get_jurys_lob(cid);
lid = $('option:selected','#c_transaction').val();
get_jurys_lob_transaction(lid);
get_jurys_call_type(cid);

$('#crm_id').val('<?php echo $crm_details['crm_id']; ?>');
$('#c_date').val('<?php echo !empty($crm_details['c_date']) ? date('m/d/Y', strtotime($crm_details['c_date'])) : ''; ?>');
$('#c_fname').val('<?php echo $crm_details['c_fname']; ?>');
$('#c_phone_no').val('<?php echo $crm_details['c_phone_no']; ?>');
$('#c_reservation_no').val('<?php echo $crm_details['c_reservation_no']; ?>');
$('#c_call_queue').val('<?php echo $crm_details['c_call_queue']; ?>');


$('#c_transaction').val('<?php echo $crm_details['c_transaction']; ?>');
$('#c_sub_transaction').val('<?php echo $crm_details['c_sub_transaction']; ?>');
$('#c_what_customer').val('<?php echo $crm_details['c_what_customer']; ?>');
$('#c_customer_comments').val('<?php echo $crm_details['c_customer_comments']; ?>');
$('#c_access_mindfaq').val('<?php echo $crm_details['c_access_mindfaq']; ?>');
$('#c_call_complexity').val('<?php echo $crm_details['c_call_complexity']; ?>');
$('#c_arrival').val('<?php echo !empty($crm_details['c_arrival']) ? date('m/d/Y', strtotime($crm_details['c_arrival'])) : ''; ?>');
$('#c_departure').val('<?php echo !empty($crm_details['c_departure']) ? date('m/d/Y', strtotime($crm_details['c_departure'])) : ''; ?>');

$('#c_outbound').val('<?php echo $crm_details['c_outbound']; ?>');
$('#c_outbound_reason').val('<?php echo $crm_details['c_outbound_reason']; ?>');
$('#c_call').val('<?php echo $crm_details['c_call_aht']; ?>');
$('#c_hold').val('<?php echo $crm_details['c_hold']; ?>');
$('#c_hold_reason').val('<?php echo $crm_details['c_hold_reason']; ?>');
$('#c_issue').val('<?php echo $crm_details['c_issue']; ?>');
$('#c_issue_resolution').val('<?php echo $crm_details['c_issue_resolution']; ?>');

$('#cl_disposition').val('<?php echo $crm_details['c_disposition']; ?>');
$('#cl_disposition_sub').val('<?php echo $crm_details['c_disposition_sub']; ?>');

}



});
<?php } ?>
<?php } ?>


//==================== JURYS INN FORM DEFAULT ====================================================================//

$('#c_date').datepicker({ dateFormat:'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '2020:' + new Date().getFullYear().toString() });
$('#c_arrival').datepicker({ dateFormat:'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '2000:' + new Date().getFullYear().toString() });
$('#c_departure').datepicker({ dateFormat:'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '2000:' + new Date().getFullYear().toString() });

//DISPOSITION SUBTYPE AJAX
function get_jurys_sub_type_inn(cid)
{
	sUrl = '<?php echo base_url(); ?>' + 'jurys_inn/disposition_Sub_Category/' + cid + '/json' ;
	if(cid != "")
	{
		$.ajax({
			url: sUrl,
			dataType: 'json',
			success: function(data) {
				htmlOptions = '';
				htmlOptions += '<option value="">--- Select Sub Category -----</option>';
				counterCheck = 0;
				$.each(data, function(i, token) {
				counterCheck++;
				   htmlOptions += '<option value="' + i +'">' + token + '</option>';
				});
				if(counterCheck > 1){ 
					$('#cl_disposition_sub').html(htmlOptions);
					//$('#cl_disposition_sub').select2();
					$("#cl_disposition_sub").attr('required', 'required');					
					$('#subDivCheck').show();
				} else {
					$('#cl_disposition_sub').val('');
					$("#cl_disposition_sub").removeAttr('required');					
					$('#subDivCheck').hide();
				}
				//console.log(htmlOptions);
			}
		});
	} else {
		$("#cl_disposition_sub").removeAttr('required');
		$('#subDivCheck').hide();
	}
}


//DISPOSITION LOB AJAX
function get_jurys_lob(cid)
{
	sUrl = '<?php echo base_url(); ?>' + 'jurys_inn/dropdown_lob_subcat/' + cid + '/json' ;
	if(cid != "")
	{
		$.ajax({
			url: sUrl,
			dataType: 'json',
			success: function(data) {
				htmlOptions = '';
				htmlOptions += '<option value="">--- Select Transaction -----</option>';
				counterCheck = 0;
				$.each(data, function(i, token) {
				counterCheck++;
				   htmlOptions += '<option value="' + i +'">' + token + '</option>';
				});
				if(counterCheck > 1){ 
					$('#c_transaction').html(htmlOptions);
					$("#c_transaction").attr('required', 'required');
				} else {
					$('#c_transaction').val('');
					$("#c_transaction").removeAttr('required');	
				}
			}
		});
	} else {
		$("#c_transaction").removeAttr('required');
	}
}


//DISPOSITION LOB TRANSACTION AJAX
function get_jurys_lob_transaction(cid)
{
	sUrl = '<?php echo base_url(); ?>' + 'jurys_inn/dropdown_lob_subcat_sub/' + cid + '/json' ;
	if(cid != "")
	{
		$.ajax({
			url: sUrl,
			dataType: 'json',
			success: function(data) {
				htmlOptions = '';
				htmlOptions += '<option value="">--- Select Sub Transaction -----</option>';
				counterCheck = 0;
				$.each(data, function(i, token) {
				counterCheck++;
				   htmlOptions += '<option value="' + i +'">' + token + '</option>';
				});
				if(counterCheck > 1){ 
					$('#c_sub_transaction').html(htmlOptions);
					//$('#cl_disposition_sub').select2();
					$("#c_sub_transaction").attr('required', 'required');					
					$('#subLobDivCheck').show();
				} else {
					$('#c_sub_transaction').val('');
					$("#c_sub_transaction").removeAttr('required');					
					$('#subLobDivCheck').hide();
				}
				//console.log(htmlOptions);
			}
		});
	} else {
		$("#c_sub_transaction").removeAttr('required');
		$('#subLobDivCheck').hide();
	}
}


//DISPOSITION CALL TYPE AJAX
function get_jurys_call_type(cid)
{
	if(cid == 'PRE'){
		sUrl = '<?php echo base_url(); ?>' + 'jurys_inn/disposition_call_type/json';
	} else {
		sUrl = '<?php echo base_url(); ?>' + 'jurys_inn/disposition_Main_Category/json';
	}
	if(cid != "")
	{
		if(cid == 'GDS'){
			
			htmlOptions = '<option value="GDS" selected>GDS</option>';
			$('#cl_disposition').val('');
			$('#cl_disposition').html(htmlOptions);			
			$("#cl_disposition").attr('required', 'required');
			//$(".singleSelect").select2();
			$('#cl_disposition').val('GDS').trigger('change');
			$('.callTypeDiv').hide();
			
			$('#cl_disposition_sub').val('');
			$("#cl_disposition_sub").removeAttr('required');					
			$('#subDivCheck').hide();		
			
		} else {
			
			$.ajax({
				url: sUrl,
				dataType: 'json',
				success: function(data) {
					htmlOptions = '';
					htmlOptions += '<option value="">--- Select Call Type -----</option>';
					counterCheck = 0;
					$.each(data, function(i, token) {
					counterCheck++;
					   htmlOptions += '<option value="' + i +'">' + token + '</option>';
					});
					if(counterCheck > 1){ 
						$('#cl_disposition').val('');
						$('#cl_disposition').html(htmlOptions);
						$("#cl_disposition").attr('required', 'required');
						
						$('#cl_disposition_sub').val('');
						$("#cl_disposition_sub").removeAttr('required');					
						$('#subDivCheck').hide();
					}
					//console.log(htmlOptions);
				}
			});
		
		}
	}
}



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
	setTimeout(function(){startTimer()}, 1000);
}

// DISPOSITION FILTER
$(document).on('change', '#cl_disposition', function(){
    cid = $('option:selected',this).val();
	get_jurys_sub_type_inn(cid);
});

// SUB TRANSACTION FILTER
$(document).on('change', '#c_transaction', function(){
    cid = $('option:selected',this).val();
	get_jurys_lob_transaction(cid);
	if(cid == 'Email'){
		$('.reservationRow').find('input,select,textarea').val('');
		$('.reservationRow').hide();
		
		$('.outboundRow').find('input,select,textarea').val('');
		$('.outboundRow').hide();
		
		$('.outboundReasonrow').find('input,select,textarea').val('');
		$('.outboundReasonrow').hide();
		
		$('.emailRow').find('input,select,textarea').val('');
		$('.emailRow').show();
		
		$('.arrivalCol').find('input,select,textarea').val('');
		$('.arrivalCol').hide();
		
		$('.departureCol').find('input,select,textarea').val('');
		$('.departureCol').hide();
		
		$('.customCol_1,.customCol_2,.overviewDiv_1,.overviewDiv_2,.commentsDiv').find('input,select,textarea').val('');
		$('.customCol_1,.customCol_2,.overviewDiv_1,.overviewDiv_2,.commentsDiv').hide();
		
		$('.callTypeDiv').find('input,select,textarea').val('');
		$('#cl_disposition').val('EMAIL').trigger('change');
		$('.callTypeDiv').find('label').html('Call Type');
		$('.callTypeDiv').show();
		
		$('.callQueueDiv').find('input,select,textarea').val('');
		$('.callQueueDiv').find('label').html('Call Queue');
		$('#c_call_queue').val('OTHERS').trigger('change');
		$('.callQueueDiv').hide();
		
		$('.outboundRow').find('input,select,textarea').removeAttr('required');
		$('.overviewDiv_1').find('input,select,textarea').removeAttr('required');
		$('.overviewDiv_2').find('input,select,textarea').removeAttr('required');
		
	} else {
		$('.emailRow').hide();
		if(cid == 'Call'){			
			$('.reservationRow').find('input,select,textarea').val('');
			$('.reservationRow').show();
			
			$('.outboundRow').find('input,select,textarea').val('');
			$('.outboundRow').show();
			
			$('.outboundReasonrow').find('input,select,textarea').val('');
			$('.outboundReasonrow').show();
			
			$('.emailRow').find('input,select,textarea').val('');
			$('.emailRow').show();
			
			$('.arrivalCol').find('input,select,textarea').val('');
			$('.arrivalCol').show();
			
			$('.departureCol').find('input,select,textarea').val('');
			$('.departureCol').show();
			
			$('.customCol_1,.customCol_2,.overviewDiv_1,.overviewDiv_2,.commentsDiv').find('input,select,textarea').val('');
			$('.customCol_1,.customCol_2,.overviewDiv_1,.overviewDiv_2,.commentsDiv').show();
			
			$('.callTypeDiv').find('input,select,textarea').val('');
			$('#cl_disposition').val('').trigger('change');
			$('.callTypeDiv').find('label').html('Call Type');
			$('.callTypeDiv').show();
			
			$('.callQueueDiv').find('input,select,textarea').val('');
			$('.callQueueDiv').find('label').html('Call Queue');
			$('#c_call_queue').val('').trigger('change');
			$('.c_call_queue').show();
			
			$('.outboundRow').find('input,select,textarea').attr('required','required');
			$('.overviewDiv_1').find('input,select,textarea').attr('required','required');
			$('.overviewDiv_2').find('input,select,textarea').attr('required','required');
			
		
		}
	}
});

// TRANSACTION FILTER
$(document).on('change', '#c_lob', function(){
    cid = $('option:selected',this).attr('lid');
	get_jurys_lob(cid);
	lid = $('option:selected','#c_transaction').val();
	get_jurys_lob_transaction(lid);
	get_jurys_call_type(cid);
	
	if(cid=='PRE'){
		$('.reservationRow').find('input,select,textarea').val('');
		$('.reservationRow').find('label').html('Confirmation No');
		
		$('.outboundRow').find('input,select,textarea').val('');		
		$('.outboundRow').hide();
		
		$('.outboundReasonrow').find('input,select,textarea').val('');
		$('.outboundReasonrow').hide();
		
		$('.arrivalCol').find('input,select,textarea').val('');
		$('.arrivalCol').find('label').html('Check Date');
		$('.arrivalCol').show();
		
		$('.departureCol').find('input,select,textarea').val('');
		$('.departureCol').hide();
		
		$('.callQueueDiv').find('input,select,textarea').val('');
		$('.callQueueDiv').find('label').html('Properties');
		$('.callQueueDiv').show();
		
		$('.callTypeDiv').find('input,select,textarea').val('');
		$('.callTypeDiv').find('label').html('Arrival Check Progress');
		$('.callTypeDiv').show();
		
		$('.departureCol,.customCol_1,.customCol_2,.overviewDiv_1,.overviewDiv_2,.commentsDiv').find('input,select,textarea').val('');
		$('.departureCol,.customCol_1,.customCol_2,.overviewDiv_1,.overviewDiv_2,.commentsDiv').hide();
		
		$('.outboundRow').find('input,select,textarea').removeAttr('required');
		$('.overviewDiv_1').find('input,select,textarea').removeAttr('required');
		$('.overviewDiv_2').find('input,select,textarea').removeAttr('required');
	}
	
	if(cid=='GDS'){
		$('.reservationRow').find('input,select,textarea').val('');
		$('.reservationRow').find('label').html('Confirmation No');
		
		$('.outboundRow').find('input,select,textarea').val('');
		$('.outboundRow').hide();
		
		$('.outboundReasonrow').find('input,select,textarea').val('');
		$('.outboundReasonrow').hide();
		
		$('.arrivalCol').find('input,select,textarea').val('');
		$('.arrivalCol').find('label').html('Arrival Date');
		$('.arrivalCol').show();
		
		$('.departureCol').find('input,select,textarea').val('');
		$('.departureCol').hide();
		
		$('.callQueueDiv').find('input,select,textarea').val('');
		$('.callQueueDiv').find('label').html('Properties');
		$('.callQueueDiv').show();
		
		$('.callTypeDiv').find('input,select,textarea').val('');
		$('#cl_disposition').val('GDS').trigger('change');
		$('.callTypeDiv').find('label').html('Call Type');
		$('.callTypeDiv').show();
		
		$('.departureCol,.customCol_1,.customCol_2,.overviewDiv_1,.overviewDiv_2,.commentsDiv').find('input,select,textarea').val('');
		$('.departureCol,.customCol_1,.customCol_2,.overviewDiv_1,.overviewDiv_2,.commentsDiv').hide();
		
		$('.outboundRow').find('input,select,textarea').removeAttr('required');
		$('.overviewDiv_1').find('input,select,textarea').removeAttr('required');
		$('.overviewDiv_2').find('input,select,textarea').removeAttr('required');
	}
	
	if(cid=='Res'){
		$('.reservationRow').find('input,select,textarea').val('');
		$('.reservationRow').find('label').html('Reservation No');
		
		$('.outboundRow').find('input,select,textarea').val('');
		$('.outboundRow').show();
		
		$('.outboundReasonrow').find('input,select,textarea').val('');
		$('.outboundReasonrow').show();
		
		$('.arrivalCol').find('input,select,textarea').val('');
		$('.arrivalCol').find('label').html('Arrival Date');
		$('.arrivalCol').show();
		
		$('.departureCol').find('input,select,textarea').val('');
		$('.departureCol').show();
		
		$('.callQueueDiv').find('input,select,textarea').val('');
		$('.callQueueDiv').find('label').html('Call Queue');
		$('.callQueueDiv').show();
		
		$('.callTypeDiv').find('input,select,textarea').val('');
		$('.callTypeDiv').find('label').html('Call Type');
		$('.callTypeDiv').show();
		
		$('.departureCol,.customCol_1,.customCol_2,.overviewDiv_1,.overviewDiv_2,.commentsDiv').find('input,select,textarea').val('');
		$('.departureCol,.customCol_1,.customCol_2,.overviewDiv_1,.overviewDiv_2,.commentsDiv').show();
		
		$('.outboundRow').find('input,select,textarea').attr('required','required');
		$('.overviewDiv_1').find('input,select,textarea').attr('required','required');
		$('.overviewDiv_2').find('input,select,textarea').attr('required','required');
	}
});

<?php if($content_template == "jurys_inn/jurys_inn_form.php"){ ?>

// HOLD REASON SELECTION
$('#holdCallModal').on('change', '#modal_hold_option', function(){
	$('#modal_hold_reason').html('');
	holdOption = $(this).val();
	$('#modal_hold_reason').val(holdOption);
});

function callActionButton(current){
	callType = $(current).attr('btype');
	if(callType == 'start'){ 
		startTimerNew(new Date());
		$('#formInfoJurysInn').show();
		$('#startCallModalButton').hide();
		$('#holdCallModalButton').show();
		$('#unholdCallModalButton').hide();
		$('#endCallModalButton').show();
		$(current).closest('.modal').modal('hide');
	}
	if(callType == 'hold'){
		reasonHold = $('#modal_hold_reason').val();
		reasonOption = $('#modal_hold_option').val();
		if(reasonHold != ""){
			startHoldNew(new Date());
			$('#startCallModalButton').hide();
			$('#holdCallModalButton').hide();
			$('#unholdCallModalButton').show();
			$('#endCallModalButton').hide();
			extraAdd = "";
			extraAddOption = "";
			reasonSet = $('#c_hold_reason').val();
			reasonSelect = $('#c_reasons').val();
			if(reasonSet != ""){ extraAdd = " || "; }
			if(reasonSelect != ""){ extraAddOption = " || "; }
			$('#c_hold_reason').val(reasonSet + extraAdd + reasonHold);
			$('#c_reasons').val(reasonSelect + extraAdd + reasonOption);
			holdCount = $('#c_hold').val();
			$('#c_hold').val(Number(holdCount) + 1);
			$(current).closest('.modal').modal('hide');
		} else {
			alert('Please Enter the Reason!');
		}
	}
	if(callType == 'unhold'){ 
		startHoldEnd(); 
		$('#modal_hold_reason').val('');
		$('#startCallModalButton').hide();
		$('#holdCallModalButton').show();
		$('#unholdCallModalButton').hide();
		$('#endCallModalButton').show();
		$(current).closest('.modal').modal('hide');
	}	
	if(callType == 'end'){ 
		$('#endCallSubmit').click(); 
		$(current).closest('.modal').modal('hide');
	}	
}
function startTimerNew(startDate){
	var total_seconds = (new Date() - startDate) / 1000;   
	var newTime = new Date(null);
	newTime.setSeconds(total_seconds);
	var result = newTime.toISOString().substr(11, 8);
	$("#timer_start").val(result);
	$('.inCall span').html(result);	
	timerStatus = $("#timer_start_status").val();
	if(timerStatus == 'S'){
		$('.inCall').show();
		$('.inHold, .inWait').hide();
		setTimeout(function(){startTimerNew(startDate)}, 1000);
	} else {
		$('.inCall').hide();
		setTimeout(function(){startTimerNew(startDate)}, 1000);
	}
}

function startHoldNew(startDate){
	var total_seconds = (new Date() - startDate) / 1000;   
	var newTime = new Date(null);
	newTime.setSeconds(total_seconds);
	var result = newTime.toISOString().substr(11, 8);
	$("#timer_hold").val(result);
	$('.inHold span').html(result);	
	timerHoldStatus = $("#timer_hold_status").val();
	if(timerHoldStatus == 'H'){
		$('.inHold').show();
		$('.inCall, .inWait').hide();
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
	holdedNo = $('#c_hold').val();
	$("#timeHolder").append('Hold ' + holdedNo + ' - ' + holded + '<br/>');
	pastHold = getSeconds($('#c_holdtime').val());
	currentHold = getSeconds(holded);
	var newTime = new Date(null);
	newTime.setSeconds(Number(pastHold) + Number(currentHold));
	var result = newTime.toISOString().substr(11, 8);
	$('#c_holdtime').val(result);	
	$("#timer_hold_status").val('U');
	$("#timer_start_status").val('S');
	$('.inCall').show();
	$('.inHold, .inWait').hide();
}

function getSeconds(time)
{
    var ts = time.split(':');
    return Date.UTC(1970, 0, 1, ts[0], ts[1], ts[2]) / 1000;
}



<?php } ?>

//==================== JURYS INN FORM LIST ====================================================================//

<?php if(($content_template == "jurys_inn/jurys_inn_form_list.php") || ($content_template == "jurys_inn/jurys_inn_form_search.php") || ($content_template == "jurys_inn/jurys_inn_dashboard.php")){ ?>

$('#search_from_date').datepicker({ dateFormat:'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '2020:' + new Date().getFullYear().toString() });
$('#search_to_date').datepicker({ dateFormat:'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '2020:' + new Date().getFullYear().toString() });

<?php if(!empty($call_type)) { ?>$('#search_call_type').val('<?php echo $call_type; ?>');<?php } ?>

$('#default-datatable').DataTable({
	"pageLength":50
});

$(document).on('click', '#viewJurysInnLogs', function(){
    cname = $(this).attr('cname');
    cid = $(this).attr('cid');
	$('#jurysInnLogsModal .modal-title').html('Disposition Logs : ' + cid + ' (' + cname + ')');
	$('#jurysInnLogsModal .modal-body').html('No Records Found');
	$('#sktPleaseWait').modal('show');
	bUrl = '<?php echo base_url(); ?>jurys_inn/jurys_logs_list/'+cid;
	$.ajax({
		type: 'POST',
		url: bUrl,
		data: 'cid=' + cid,
		success: function(response) {
			$('#sktPleaseWait').modal('hide');
			$('#jurysInnLogsModal .modal-body').html(response);
			$('#jurysInnLogsModal').modal('show');
			/*$('#default-datatable-logs').DataTable({
				searching: false,
				info:false,
				pageLength:50
			});*/
		}
	});
});

<?php } ?>


//==================== JURYS INN FORM REPORTS  ====================================================================//

<?php if($content_template == "jurys_inn/jurys_inn_form_reports.php"){ ?>
$('#search_from_date').datepicker({ dateFormat:'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#search_to_date').datepicker({ dateFormat:'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
<?php } ?>
</script>

<?php if($content_template == "jurys_inn/jurys_inn_dashboard.php"){ ?>
<script src="<?php echo base_url(); ?>assets/chartjs/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/chartjs-plugin-datalabels.js"></script>
<script>
//==================== JURYS INN FORM DASHBOARD ====================================================================//
var ctxPIE  = document.getElementById("qa_2dpie_graph_container");
var myLineChart = new Chart(ctxPIE, {
  type: 'pie',
  data: {
    labels: [
	<?php //echo "'".implode("','", array_column($dispoisition_records, 'c_disposition'))."'"; ?>
	<?php $ij=0; foreach($dispoisition_records as $token){ $ij++; echo  "'" .$main_category[$token['c_disposition']] ." (".$token['counter'].")"; echo $ij< count($dispoisition_records)?"'," : "'"; } ?>
	],
    datasets: [
	 { 
        data: [
		<?php echo implode(',', array_column($dispoisition_records, 'counter')); ?>
		],
        label: "Jurys Inn Customer Records",
        backgroundColor: [<?php $ij=0; shuffle($randomColors); foreach($dispoisition_records as $token){ echo  "'" .$randomColors[$ij]; $ij++; echo $ij< count($dispoisition_records)?"'," : "'"; } ?>],
     }
    ]
  },
  options: {
    legend: { display: true,position: 'right', },
    title: {
      display: false,
      text: "Jurys Inn Customer Record Counts"
    },
	tooltips: {
		callbacks: {
        label: function(tooltipItem, data) { 
            var indice = tooltipItem.index;                 
            return  data.labels[indice];
			//+': '+data.datasets[0].data[indice] + ' %';
        }
		}
	 },
	  maintainAspectRatio: false,
	  responsive: true,
	  plugins: {
	  datalabels: {
		  color: '#ffffff',
		//anchor: 'end',
		//align: 'top',
		/*formatter: (value, ctx) => {
			if(value == 0){
			return "";
			} else {
			return value + '%';
			}
		},*/
		font: {
		  weight: 'bold'
		}
	  }
	  }	
  }
});

</script>
<?php } ?>

<script type="text/javascript">

	$('#audit_type').each(function(){
		$valdet=$(this).val();
		if($valdet=="Calibration"){
			$('.auType_epi').show();
		}else{
			$('.auType_epi').hide();
		}
	});

	$('#audit_type').on('change', function(){
		if($(this).val()=='Calibration'){
			$('.auType_epi').show();
			$('#auditor_type').attr('required',true);
			$('#auditor_type').prop('disabled',false);
		}else{
			$('.auType_epi').hide();
			$('#auditor_type').attr('required',false);
			$('#auditor_type').prop('disabled',true);
		}
	});	

	$("#form_audit_user").submit(function (e) {
		$('#qaformsubmit').prop('disabled',true);
	});
	
	$("#form_agent_user").submit(function(e){
		$('#btnagentSave').prop('disabled',true);
	});
	
	$("#form_mgnt_user").submit(function(e){
		$('#btnmgntSave').prop('disabled',true);
	});

	function docusign_calc(){
		var score = 0;
		var cust_score = 0;
		var busi_score = 0;
		var comp_score = 0;
		var scoreable = 0;
		var cust_scoreable = 0;
		var busi_scoreable = 0;
		var comp_scoreable = 0;
		var quality_score_percent = 0;
		var score1 = 0;
		var scoreable1 = 0;
		var quality_score_percent1 = 0;
		
		$('.points_epi').each(function(index,element){
			var score_type = $(element).val();
			
			if(score_type == 'Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
				score = score + weightage;
				scoreable = scoreable + weightage;
			}else if(score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
				scoreable = scoreable + weightage;
			}else if(score_type == 'N/A'){
				// var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
				// score = score + weightage;
				// scoreable = scoreable + weightage;
			}
		});

		$('.points_pa').each(function(index1,element1){
			var score_type1 = $(element1).val();
			
			if(score_type1 == 'Yes'){
				var weightage1 = parseFloat($(element1).children("option:selected").attr('ds_val'));
				score1 = score1 + weightage1;
				scoreable1 = scoreable1 + weightage1;
			}else if(score_type1 == 'No'){
				var weightage1 = parseFloat($(element1).children("option:selected").attr('ds_val'));
				scoreable1 = scoreable1 + weightage1;
			}else if(score_type1 == 'N/A'){
				// var weightage1 = parseFloat($(element1).children("option:selected").attr('ds_val'));
				// score1 = score1 + weightage1;
				// scoreable1 = scoreable1 + weightage1;
			}
		});

		$('.cust_score').each(function(index,element){
			var cust_score_type = $(element).val();
			
			if(cust_score_type == 'Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
				cust_score = cust_score + weightage;
				cust_scoreable = cust_scoreable + weightage;
			}else if(cust_score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
				cust_scoreable = cust_scoreable + weightage;
			}else if(cust_score_type == 'N/A'){
				// var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
				// cust_score = cust_score + weightage;
				// cust_scoreable = cust_scoreable + weightage;
			}
		});

		$('.busi_score').each(function(index,element){
			var busi_score_type = $(element).val();
			
			if(busi_score_type == 'Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
				busi_score = busi_score + weightage;
				busi_scoreable = busi_scoreable + weightage;
			}else if(busi_score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
				busi_scoreable = busi_scoreable + weightage;
			}else if(busi_score_type == 'N/A'){
				// var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
				// busi_score = busi_score + weightage;
				// busi_scoreable = scoreable + weightage;
			}
		});

		$('.comp_score').each(function(index,element){
			var comp_score_type = $(element).val();
			
			if(comp_score_type == 'Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
				comp_score = comp_score + weightage;
				comp_scoreable = comp_scoreable + weightage;
			}else if(comp_score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
				comp_scoreable = comp_scoreable + weightage;
			}else if(comp_score_type == 'N/A'){
				// var weightage = parseFloat($(element).children("option:selected").attr('ds_val'));
				// comp_score = comp_score + weightage;
				// comp_scoreable = comp_scoreable + weightage;
			}
		});

		$(".fatal_epi").each(function(){
			valNum=$(this).val();
			if(valNum == "Yes"){
				score=0;
			}	
		});

		quality_score_percent = parseFloat(score)+parseFloat(score1);
		quality_score_percent1 = parseFloat(scoreable)+parseFloat(scoreable1);
		
		var quality_score_percent2=((quality_score_percent*100)/quality_score_percent1).toFixed(2);
		var cust_quality_score_percent = ((cust_score*100)/cust_scoreable).toFixed(2);
		var busi_quality_score_percent = ((busi_score*100)/busi_scoreable).toFixed(2);
		var comp_quality_score_percent = ((comp_score*100)/comp_scoreable).toFixed(2);

		$('#earnedScore').val(score+score1);
		$('#possibleScore').val(scoreable+scoreable1);
		
		if(!isNaN(quality_score_percent2)){
			$('#overallScore').val(quality_score_percent2+'%');
		}	
		if(!isNaN(cust_quality_score_percent)){
			$('#custScore').val(cust_quality_score_percent+'%');
		}

		if(!isNaN(busi_quality_score_percent)){
			$('#busiScore').val(busi_quality_score_percent+'%');
		}

		if(!isNaN(comp_quality_score_percent)){
			$('#compScore').val(comp_quality_score_percent+'%');
		}			
	
	}
	
	$(".points_epi").on("change",function(){
		docusign_calc();
	});

	$(".points_pa").on("change",function(){
		docusign_calc();
	});
	docusign_calc();

</script>