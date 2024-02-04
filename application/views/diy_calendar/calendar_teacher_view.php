 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
 <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
<style>
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

<div class="col-md-8">
<form method="GET">
<div class="row" <?php if(get_role() == 'teacher'){ echo 'style="display:none"'; } ?>>
<input type="hidden" id="gm_time_slots" name="gm_time_slots" value="">	
<div class="col-md-5">	
	<select name="teacher_id" class="form-control">
	<?php if(get_role() != "teacher"){ ?>
	<option value="ALL">ALL</option>
	<?php } ?>
	<?php foreach($teachersList as $token){			
	$selection = "";
	if($teacher_id == $token['id']){ $selection = "selected"; }
	?>
	<option value="<?php echo $token['id']; ?>" <?php echo $selection; ?>><?php echo $token['fname'] ." " .$token['lname']; ?></option>
	<?php } ?>
	</select>
</div>


<div class="col-md-5">	
	<select name="gmt_time_id" id="gmt_time_id" class="form-control" onchange="set_gmt_val();">
	<?php foreach($gmtList as $token){			
	$selection = "";
	if($gmt_time_id == $token['id']){ $selection = "selected"; }
	?>
	<option value="<?php echo $token['GMT_offset']; ?>" sltid="<?php echo $token['id']; ?>" <?php echo $selection; ?>><?php echo $token['gmtCountryName']; ?></option>
	<?php } ?>
	</select>
</div>

<div class="col-md-2">	
	<button class="btn btn-danger" type="submit">View</button>
</div>
</div>
</form>
<br/><br/>
</div>



<div class="col-md-4">

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

<!--<div class="col-md-5" style="display:flex; gap:8px; align-items:center;">
	<span data-toggle="tooltip" title="Unavailable" style="height: 10px; width: 30px; background-color: #c9c78b; cursor:pointer;"></span>
	<span>Unavailable</span>
</div>

<div class="col-md-5" style="display:flex; gap:8px; align-items:center;">
	<span data-toggle="tooltip" title="In Leave" style="height: 10px; cursor:pointer; width: 30px; background-color: #f94848; "></span>
	<span>Leave</span>
</div>
<div class="col-md-5" style="display:flex; gap:8px; align-items:center;">
	<span data-toggle="tooltip" title="Partial Leave" style="height: 10px; cursor:pointer; width: 30px; background-color: #4D0000; "></span>
	<span>Partial Leave</span>
</div>-->


</div>

</div>


<div class="row">
<div class="col-md-12">
	Current Timezone : <b><?php echo $display_my_gmt; ?></b>
	<br/><br/>
</div>		
</div>

<hr/>

<?php if(!empty($teacher_id)){ ?>
<div class="row">
<div class="col-md-12">
	<div id="course_view_calendar" class="cal"></div>
</div>		
</div>
<?php } ?>



		
</div> 

<br/><br/>
  
	
</div>
</section>
</div>

<div class="modal fade" id="availabilitySlotModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="successTicketsModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width:80%">
    <div class="modal-content">
      <div class="modal-header slotModalHeader">       
		<button type="button" class="close" data-dismiss="modal" data-toggle="validator" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
	$get_default_selecton_date = $this->uri->segment(4);
	$got_selection_date = "";
	if(!empty($get_default_selecton_date)){
		$got_selection_date = date('Y-m-d', strtotime($get_default_selecton_date));
	}
	
	if(!empty($teacher_id)){ 
	?>
     var events = <?php echo json_encode($calendar_view_result); ?>;  
     $('#course_view_calendar').fullCalendar({
      header    : {
        left  : 'prev,next today',
        center: 'title',
        //right : 'month,agendaWeek,agendaDay'
        right:'month'
      },
      buttonText: {
        today: 'today',
        month: 'month',
        week : 'week',
        day  : 'day'
      },
      events: events,
	  meridiem : 'short',
	  displayEventTime: false,
	  allDayDefault: false,
	  <?php if(!empty($got_selection_date)){ ?>
	  defaultDate: "<?php echo date('Y-m-d', strtotime($got_selection_date)); ?>",
	  <?php } ?>
	  timeFormat: 'ha',
	  eventRender : function(event, element) {
		   element[0].title = event.description;
	  },
	  views: {
		agendaWeek: {
			displayEventTime: false,
		},
		agendaDay: {
			displayEventTime: false,
		}
	  },
	  eventClick: function(event) {
		  $("#sktPleaseWait").modal('show');
		  $.ajax({
			url: event.url,
			type: "GET",
			//data: { cl_teacher : cl_teacher, cl_date : cl_date, cl_type : 'new' },
			dataType: "text",
			success : function(jsonData){
				$("#sktPleaseWait").modal('hide');
				$('#availabilitySlotModal .modal-body').html(jsonData);
				$('#availabilitySlotModal').modal("show");
				//get_slots_selected();
			},
			error : function(jsonData){
				$("#sktPleaseWait").modal('hide');
				alert('Something Went Wrong!');
			}
		});	
		 // window.open(event.url, 'gcalevent', 'width=800,height=500,toolbar=0,menubar=0,location=0');
		  return false;
	  },
     });
	<?php } ?>
	function set_gmt_val(id){

		 var element = $('#gmt_time_id').find('option:selected'); 
        var slot_id = element.attr("sltid");
		$('#gm_time_slots').val(slot_id);
	}
</script>
