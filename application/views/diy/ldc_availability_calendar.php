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
</style>
<div class="wrap">
<section class="app-content">
	
<div class="widget">

<header class="widget-header">
<h4 class="widget-title">Teacher Availability</h4>
</header>

<hr class="widget-separator"/>

<div class="widget-body clearfix">
<form method="GET">
<div class="row">
<?php if(get_role() != 'teacher'){ ?>
<div class="col-md-6">	
	<select name="teacher_id" class="form-control">
	<option value="">Select Teacher</option>
	<?php foreach($teachersList as $token){			
	$selection = "";
	if($teacher_id == $token['id']){ $selection = "selected"; }
	?>
	<option value="<?php echo $token['id']; ?>" <?php echo $selection; ?>><?php echo $token['fname']. " " .$token['lname']; ?></option>
	<?php } ?>
	</select>
</div>

<div class="col-md-1">	
	<button class="btn btn-danger" type="submit">View</button>
</div>

<?php } ?>
<?php if(!empty($teacher_id)){ ?>
	<div class="col-md-5" style="padding-bottom: 15px; ">	
	<div class="col-md-4" style="display:flex; gap:8px; align-items:center;">
		<span data-toggle="tooltip" title="Demo" style="height: 10px; width: 30px; background-color: red; cursor:pointer;"></span>
		<span>Demo</span>
	</div>
	<div class="col-md-4" style="display:flex; gap:8px; align-items:center;">
		<span data-toggle="tooltip" title="Beginner" style="height: 10px; cursor:pointer; width: 30px; background-color: yellow; "></span>
		<span>Beginner</span>
	</div>
	<div class="col-md-4" style="display:flex; gap:8px; align-items:center;">
		<span data-toggle="tooltip" title="Intermediate" style="height: 10px; cursor:pointer; width: 30px; background-color: orange; "></span>
		<span>Intermediate</span>
	</div>
	<div class="col-md-4" style="display:flex; gap:8px; align-items:center;">
		<span data-toggle="tooltip" title="Advanced" style="height: 10px; cursor:pointer; width: 30px; background-color: blue; "></span>
		<span>Advanced</span>
	</div>
	<div class="col-md-4" style="display:flex; gap:8px; align-items:center;">
		<span data-toggle="tooltip" title="Available" style="height: 10px; cursor:pointer; width: 30px; background-color: #00a65a; "></span>
		<span>Available</span>
	</div>
	<div class="col-md-4" style="display:flex; gap:8px; align-items:center;">
		<span data-toggle="tooltip" title="Off" style="height: 10px; cursor:pointer; width: 30px; background-color: #c9c78b; "></span>
		<span>Off</span>
	</div>
	<div class="col-md-4" style="display:flex; gap:8px; align-items:center;">
		<span data-toggle="tooltip" title="Leave" style="height: 10px; cursor:pointer; width: 30px; background-color: #fc03e3; "></span>
		<span> Leave</span>
	</div>
	<div class="col-md-4" style="display:flex; gap:8px; align-items:center;">
		<span data-toggle="tooltip" title="Partial Leave" style="height: 10px; cursor:pointer; width: 30px; background-color: #4D0000; "></span>
		<span>Partial Leave</span>
	</div>
	</div>
<?php } ?>
</div>

<br/><br/>
<?php if(!empty($teacher_id)){ ?>
<!-- <div style="display:flex; justify-content:space-around; align-items:center; margin: 15px 0px;">
	<div style="display:flex; justify-content:center; gap:8px; align-items:center; width: 10%;">
		<span style="height: 15px; width: 15px; background-color: red; border-radius: 50%; "></span>
		<span>Demo session</span>
	</div>
	<div style="display:flex; justify-content:center; gap:8px; align-items:center; width: 10%;">
		<span style="height: 15px; width: 15px; background-color: yellow; border-radius: 50%;"></span>
		<span>Beginner</span>
	</div>
	<div style="display:flex; justify-content:center; gap:8px; align-items:center; width: 10%;">
		<span style="height: 15px; width: 15px; background-color: orange; border-radius: 50%;"></span>
		<span>Intermediate</span>
	</div>
	<div style="display:flex; justify-content:center; gap:8px; align-items:center; width: 10%;">
		<span style="height: 15px; width: 15px; background-color: blue; border-radius: 50%;"></span>
		<span>Advance</span>
	</div>
</div> -->
<div class="row">
<div class="col-md-12">
	<div id="myViewcalendar" class="cal"></div>
</div>		
</div>
<?php } ?>


</form>
		
</div> 

<br/><br/>
  
	
</div>
</section>
</div>
   
<script type="text/javascript">
     
	<?php if(!empty($teacher_id)){ ?>
     //var events = [{"title":"first event","start":"2021-02-18","end":"2021-02-20","backgroundColor":"#00a65a"}];  
     var events = <?php echo json_encode($calendar_result); ?>;  
     $('#myViewcalendar').fullCalendar({
      header    : {
        left  : 'prev,next today',
        center: 'title',
        right : 'month,agendaWeek,agendaDay'
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
		window.open(event.url, 'gcalevent', 'width=700,height=500');
		return false;
	  },
     });
	<?php } ?>
</script>
