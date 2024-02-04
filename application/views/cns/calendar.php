
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
	.modal .close {
    color: #fff;
    text-shadow: none;
    opacity: 1;
    position: absolute;
    top: -15px;
    right: -14px;
    width: 35px;
    height: 35px;
    background: #0c6bb5;
    border-radius: 50%;
    transition: all 0.5s ease-in-out 0s;
}
.new-btn{
width: 100px;
padding: 10px;
color: #fff;
font-size: 13px;
letter-spacing: 0.5px;
transition: all 0.5s ease-in-out 0s;
border: none;
border-radius: 5px;
}
.loc{
margin-bottom: 5px;
}
</style>
<div class="wrap">
	<section class="app-content">
	<div class="widget">
		<header class="widget-header">
			<h4 class="widget-title loc">Location</h4>
			<form method="GET">
				<div class="row techer_selection_row">
					<div class="col-md-5">	
						<select name="location_id" id="location_id" class="form-control" required>
							<option value="">Select location</option>
							<?php foreach($location_list as $key=>$row){ ?>
							<option value="<?php echo $row['name'];?>" <?php echo ($row['name']==$location_id)?'Selected="selected"':'';?>><?php echo $row['name'];?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-md-2">	
					<button class="btn btn-danger new-btn" type="submit">View</button>
					</div>
				</div>
			</form>		
		</header>
		<?php if($this->session->flashdata('success')!=''){ ?>
		<div class="alert alert-success">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <strong><?php echo $this->session->flashdata('success'); ?></strong>
			<?php unset($_SESSION['success']);?>
        </div>
		<?php } ?>
		<hr class="widget-separator"/>
		<?php //if($location_id!=''){ ?>
		<div class="widget-body clearfix">
			<div class="row">
				<div class="col-md-12 col-md">
					<div id="myViewcalendar" class="cal"></div>
				</div>		
			</div>
		</div>
		<?php //} ?> 
	<br/><br/> 
	
	</div>
	</section>
</div>

<div class="modal fade" id="availabilitySlotModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="successTicketsModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width:80%">
    <div class="modal-content">
      <div class="modal-header slotModalHeader">       
		<button type="button" class="close" data-dismiss="modal" data-toggle="validator" aria-label="Close"><span class="text-white" aria-hidden="true">&times;</span></button>
		<h4 class="modal-title"><i class="fa fa-calendar"></i> Set Date</h4>
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
//if(!empty($teacher_id)){ 
$_j_currentDate = GetLocalDateByOffice('KOL');
?>

 //var events = [{"title":"Test event","start":"2022-04-26","end":"2022-04-26","backgroundColor":"#00a65a"}];  
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
	    cl_date = event.cl_date;
		comments=event.Comment;
		type =event.type;
		emails=event.emails;
		notification_days=event.notification_days;
		emails1=event.emails1;
		notification_days1=event.notification_days1;
		cns_date=event.cns_date;
		id=event.ids;
		
		today_date = "<?php echo date('Y-m-d', strtotime($_j_currentDate)); ?>";
		//type_name = "<?php echo $location_id;?> ";
		j_d1 = new Date(cl_date);
		j_d2 = new Date(today_date);
		if(j_d1 < j_d2){ 
			$("#sktPleaseWait").modal('hide');
			return false; 
		} else {
			$("#sktPleaseWait").modal('show');
		}
		cl_location = $('.techer_selection_row select[name="location_id"]').val();
		cl_gmt = $('.techer_selection_row select[name="timezone_id"]').val();
		$.ajax({
			url: "<?php echo base_url('cns/calendar_setinfo_details'); ?>",
			type: "GET",
			data: { cl_location : cl_location, cl_date : cl_date, cl_gmt : cl_gmt, cl_type : 'edit' , location : cl_location,type :type,emails:emails,notification_days:notification_days,Comment:comments,cns_date:cns_date,id:id,emails1:emails1,notification_days1:notification_days1,Comment:comments,cns_date:cns_date},
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
		
		comments="";
		type ="";
		emails="";
		notification_days="";
		emails1="";
		notification_days1="";
		cns_date="";
		id="";
		if(j_d1 < j_d2){ 
			$("#sktPleaseWait").modal('hide');
			return false; 
		} else {
			$("#sktPleaseWait").modal('show');
		}
		cl_location = $('.techer_selection_row select[name="location_id"]').val();
		cl_gmt = $('.techer_selection_row select[name="timezone_id"]').val();
		$.ajax({
			url: "<?php echo base_url('cns/calendar_setinfo_details'); ?>",
			type: "GET",
			data: { cl_location : cl_location, cl_date : cl_date, cl_gmt : cl_gmt, cl_type : 'new', location : cl_location,type :type,emails:emails,notification_days:notification_days,Comment:comments,cns_date:cl_date,id:id,emails1:emails1,notification_days1:notification_days1 },
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
<?php //} ?>



$('#availabilitySlotModal').on('click', '.slotButton', function(){
	if(!$(this).hasClass("disabled")){

	if($(this).hasClass("in")){
		//$(this).();
	} else {removeClass('in');
		get_slots_selected();
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
