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
<h4 class="widget-title">Teacher Schedule <?php echo $scheduleDate;?></h4>
</header>

<hr class="widget-separator"/>

<div class="widget-body clearfix">
<form method="GET">
<div class="row">
<input type="hidden" id="gm_time_slots" name="gm_time_slots" value="">	
<?php  $display=($current_role=='teacher')?"display:none":""; ?>	
<div class="col-md-3" style="<?php echo $display;?>">	
	<select name="teacher_id" class="form-control">
	<?php 
	foreach($teachersList as $token){			
	$selection = "";
	if($teacher_id == $token['id']){ $selection = "selected"; }
	?>
	<option value="<?php echo $token['id']; ?>" <?php echo $selection; ?>><?php echo $token['fname'].' '.$token['lname']; ?></option>
	<?php } ?>
	</select>
</div>
<div class="col-md-3" style="<?php echo $display;?>">	
	<?php $my_gmt_timezoneval=($my_gmt_timezone=='+5:30')?'GMT+05:30':$my_gmt_timezone;

	?>
	<select name="gmt_time_id" id="gmt_time_id" class="form-control" onchange="set_gmt_val();">
	<?php 
	foreach($gmtlist as $token){			
	$selection = "";
	if($gmt_time_id == $token['id']){ $selection = "selected"; }
	?>
	<option value="<?php echo $token['GMT_offset']; ?>" sltid="<?php echo $token['id']; ?>" <?php echo $selection; ?>><?php echo $token['gmtCountryName']; ?></option>
	<?php } ?>
	</select>
</div>

<div class="col-md-2" style="<?php echo $display;?>">	
	<button class="btn btn-danger" type="submit">View</button>
</div>

</form>
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
</div>
</div>
<br/><br/>
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
	<?php if(!empty($teacher_id)){ ?>
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
				get_slots_selected();
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
    <?php if($scheduleDate!=''){ ?>
     $('#course_view_calendar').fullCalendar('gotoDate', '<?php echo $scheduleDate;?>');
    <?php }
				} 
		?>
	function set_gmt_val(id){

		 var element = $('#gmt_time_id').find('option:selected'); 
        var slot_id = element.attr("sltid");
		$('#gm_time_slots').val(slot_id);
	}
</script>
