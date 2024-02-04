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
<h4 class="widget-title">Course Schedule</h4>
</header>

<hr class="widget-separator"/>

<div class="widget-body clearfix">
<form method="GET">
<div class="row">
<div class="col-md-8">	
	<select name="course_id" class="form-control">
	<option value="">Select Course</option>
	<?php foreach($courseList as $token){			
	$selection = "";
	if($course_id == $token['id']){ $selection = "selected"; }
	?>
	<option value="<?php echo $token['id']; ?>" <?php echo $selection; ?>><?php echo $token['name']; ?></option>
	<?php } ?>
	</select>
</div>

<div class="col-md-2">	
	<button class="btn btn-danger" type="submit">View</button>
</div>
</div>

<br/><br/>
<?php if(!empty($course_id)){ ?>
<div class="row">
<div class="col-md-12">
	<div id="myViewCourseCalendar" class="cal"></div>
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
     
	<?php if(!empty($course_id)){ ?>
     //var events = [{"title":"first event","start":"2021-02-18","end":"2021-02-20","backgroundColor":"#00a65a"}];  
     var events = <?php echo json_encode($calendar_result); ?>;  
     $('#myViewCourseCalendar').fullCalendar({
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
	  meridiem : 'short',
	  //displayEventTime: false,
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
	  /*eventClick: function(event) {
		window.open(event.url, 'gcalevent', 'width=700,height=600');
		return false;
	  },*/
     });
	<?php } ?>
	
	
</script>
