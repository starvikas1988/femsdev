<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
 <script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
</script>
<style>
.slotModalHeader{
	background-color: #115fa2!important;
    color: #fff!important;
}
</style>

<div class="wrap">
<section class="app-content">
<div class="widget">

<header class="widget-header">
<h4 class="widget-title">Teacher Availability</h4>
</header>
<hr class="widget-separator"/>

<div class="widget-body clearfix">

<div class="row">

<div class="col-md-7">
<form method="GET">
<div class="row techer_selection_row" <?php if(get_role() == 'teacher'){ echo 'style="display:none"'; } ?>>
	<div class="col-md-5">	
		<select name="teacher_id" class="form-control" required>
			<option value="">Select Teacher</option>
			<?php 
			foreach($teachersList as $token){
			$selection = $teacher_id == $token['id'] ?  "selected" : "";
			?>
			<option value="<?php echo $token['id']; ?>" <?php echo $selection; ?>><?php echo $token['fname']. " " .$token['lname']; ?></option>
			<?php } ?>
		</select>
	</div>
	<div class="col-md-5">	
		<select name="timezone_id" class="form-control" required>
		<?php foreach($gmtList as $token){			
		$selection = "";
		if($timezone_id == $token['id']){ $selection = "selected"; }
		?>
		<option value="<?php echo $token['GMT_offset']."#".$token['id']; ?>" <?php echo $selection; ?>><?php echo $token['gmtCountryName']; ?></option>
		<?php } ?>
		</select>
	</div>
	<div class="col-md-2">	
		<button class="btn btn-danger" type="submit">View</button>
	</div>
</div>
</form>
<br/><hr/>
</div>

<div class="col-md-5">

<div class="col-md-5" style="display:flex; gap:8px; align-items:center;">
	<span data-toggle="tooltip" title="Available" style="height: 10px; cursor:pointer; width: 30px; background-color: #c9c78b; "></span>
	<span>Pending Approval</span>
</div>

<div class="col-md-5" style="display:flex; gap:8px; align-items:center;">
	<span data-toggle="tooltip" title="Available" style="height: 10px; cursor:pointer; width: 30px; background-color: #00a65a; "></span>
	<span>Available</span>
</div>

<div class="col-md-5" style="display:flex; gap:8px; align-items:center;">
	<span data-toggle="tooltip" title="Scheduled" style="height: 10px; cursor:pointer; width: 30px; background-color: #0084e7; "></span>
	<span>Scheduled</span>
</div>

</div>

</div>

<div class="row">
<div class="col-md-12">
	Current Timezone : <b><?php echo $display_my_gmt; ?></b>
	<br/><br/>
</div>		
</div>


<div class="row">
<div class="col-md-12 col-md-offset-2-disable">
	<div id="myViewcalendar" class="cal"></div>
</div>		
</div>


		
</div> 

<br/><br/> 
	
</div>
</section>
</div>



<div class="modal fade" id="availabilitySlotModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="successTicketsModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width:80%">
    <div class="modal-content">
      <div class="modal-header slotModalHeader">       
		<button type="button" class="close" data-dismiss="modal" data-toggle="validator" aria-label="Close"><span class="text-white" aria-hidden="true">&times;</span></button>
		<h4 class="modal-title"><i class="fa fa-calendar"></i> Availability Slot</h4>
      </div>
      <div class="modal-body">	  
	  </div>	  
      <div class="modal-footer slotModalHeader">			
			<button type="button" style="color:#000" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

   
<script type="text/javascript">
     
<?php 

if(!empty($teacher_id)){ 
$_j_currentDate = GetLocalDateByOffice('KOL');
?>

 //var events = [{"title":"Test event","start":"2021-08-02","end":"2021-08-02","backgroundColor":"#00a65a"}];  
 var events = <?php echo json_encode($availability_records); ?>;  
 $('#myViewcalendar').fullCalendar({
  header    : {
	left  : 'prev,next today',
	center: 'title',
	//right : 'month,agendaWeek,agendaDay'
	right : 'month'
  },
  buttonText: {
	today: 'today',
	month: 'month',
	week : 'week',
	day  : 'day'
  },
  events: events,
  displayEventTime: false,
  allDayDefault: false,
  eventClick: function(event) {
		//$("#sktPleaseWait").modal('show');
	    cl_date = event.date;
		today_date = "<?php echo date('Y-m-d', strtotime($_j_currentDate)); ?>";
		j_d1 = new Date(cl_date);
		j_d2 = new Date(today_date);
		if(j_d1 < j_d2){ 
			$("#sktPleaseWait").modal('hide');
			return false; 
		} else {
			$("#sktPleaseWait").modal('show');
		}
		cl_teacher = $('.techer_selection_row select[name="teacher_id"]').val();
		cl_gmt = $('.techer_selection_row select[name="timezone_id"]').val();
		$.ajax({
			url: "<?php echo base_url('diy_calendar/calendar_availability_slot'); ?>",
			type: "GET",
			data: { cl_teacher : cl_teacher, cl_date : cl_date, cl_gmt : cl_gmt, cl_type : 'edit' },
			dataType: "text",
			success : function(jsonData){
				$("#sktPleaseWait").modal('hide');
				$('#availabilitySlotModal .modal-body').html(jsonData);
				$('#availabilitySlotModal').modal("show");
				get_slots_selected();
			},
			error : function(jsonData){
				$("#sktPleaseWait").modal('hide');
				alert('Something Went Wrong!');
			}
		});	
  },
  dayClick: function(date, jsEvent, view) {
	    //$("#sktPleaseWait").modal('show');
	    cl_date = date.format();
		today_date = "<?php echo date('Y-m-d', strtotime($_j_currentDate)); ?>";
		j_d1 = new Date(cl_date);
		j_d2 = new Date(today_date);
		if(j_d1 < j_d2){ 
			$("#sktPleaseWait").modal('hide');
			return false; 
		} else {
			$("#sktPleaseWait").modal('show');
		}
		cl_teacher = $('.techer_selection_row select[name="teacher_id"]').val();
		cl_gmt = $('.techer_selection_row select[name="timezone_id"]').val();
		$.ajax({
			url: "<?php echo base_url('diy_calendar/calendar_availability_slot'); ?>",
			type: "GET",
			data: { cl_teacher : cl_teacher, cl_date : cl_date, cl_gmt : cl_gmt, cl_type : 'new' },
			dataType: "text",
			success : function(jsonData){
				$("#sktPleaseWait").modal('hide');
				$('#availabilitySlotModal .modal-body').html(jsonData);
				$('#availabilitySlotModal').modal("show");
				get_slots_selected();
			},
			error : function(jsonData){
				$("#sktPleaseWait").modal('hide');
				alert('Something Went Wrong!');
			}
		});	
  },
 });
<?php } ?>



$('#availabilitySlotModal').on('click', '.slotButton', function(){
	if(!$(this).hasClass("disabled")){

	if($(this).hasClass("in")){
		$(this).removeClass('in');
		get_slots_selected();
	} else {
		$(this).addClass('in');
		get_slots_selected();
	}
	
	}
});

$('#availabilitySlotModal').on('change', 'select[name="slot_from_time"],select[name="slot_to_time"]', function(){
	fromSlotVal = $('select[name="slot_from_time"]').val();
	toSlotVal = $('select[name="slot_to_time"]').val();	
	if(fromSlotVal != "" && toSlotVal != ""){
		fromSlot = $('select[name="slot_from_time"] option:selected').attr('stime');
		toSlot = $('select[name="slot_to_time"] option:selected').attr('stime');
		//console.log(fromSlot);
		//console.log(toSlot);
		if(toSlot >= fromSlot){
			get_slots_selected_range(fromSlot, toSlot);
		} else {
			alert("Please Enter Valid Selection!");
		}
	}
});

function get_slots_selected_range(fromSlot, toSlot){
	$('#availabilitySlotModal .slotButton').each(function(){
		slotName = $(this).text();
		slotID = $(this).attr('eid');
		slotTimeCheck = $(this).attr('stime');
		if(!$(this).hasClass("disabled")){
		if(slotTimeCheck >= fromSlot && slotTimeCheck <= toSlot)
		{
			$(this).addClass('in');
		} else {
		if(!$(this).hasClass("approved_check")){
			$(this).removeClass('in');
		}
		}
		}
	});
	get_slots_selected();
}

function get_slots_selected(){
	$('#availabilitySlotModal button[name="slot_submission"]').addClass('disabled');
	slectionButtons = ""; var slectionIDs = new Array(); counter = 0;
	$('#availabilitySlotModal .slotButton').each(function(){
		slotName = $(this).text();
		slotID = $(this).attr('eid');
		if($(this).hasClass('in')){			
			slectionButtons += '<button type="button" eid="'+slotID+'" class="btn btn-success slotShowButton" style="width:30%">'+slotName+'</button>';
			slectionIDs[counter] = slotID;
			counter++;
		}
	});
	if(slectionButtons == ""){ 
	    slectionButtons = '<span class="text-danger">-- No Slots Slected --</span><br/>'; 
	} else {
		$('#availabilitySlotModal button[name="slot_submission"]').removeClass('disabled');
	}
	allSlotIds = slectionIDs.join('#');
	$('#availabilitySlotModal #slots_selected').html(slectionButtons);
	$('#availabilitySlotModal input[name="cl_slot_ids"]').val(allSlotIds);
	
}
	
</script>
