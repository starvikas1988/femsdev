 <style>

	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		vertical-align:middle;
		padding:4px;
		font-size:11px;
	}
	
	.table > thead > tr > th,.table > tfoot > tr > th{
			text-align:center;
	}
	.displaytable{
		table-layout: fixed;
		width: 100%;
	}

	.inputTable > tr > td{
		font-size:12px;
		padding:4px;
	}
	
	.hide{
	  disply:none;	  
	}
	
	.modal-dialog {
		width: 800px;
	}
	.modal
	{
		overflow:auto;
	}
	
	/*---------- MY CUSTOM CSS -----------*/
	.rounded {
	  -webkit-border-radius: 3px !important;
	  -moz-border-radius: 3px !important;
	  border-radius: 3px !important;
	}

	.mini-stat {
	  padding: 5px;
	  margin-bottom: 20px;
	}

	.mini-stat-icon {
	  width: 30px;
	  height: 30px;
	  display: inline-block;
	  line-height: 30px;
	  text-align: center;
	  font-size: 15px;
	  background: none repeat scroll 0% 0% #EEE;
	  border-radius: 100%;
	  float: left;
	  margin-right: 10px;
	  color: #FFF;
	}

	.mini-stat-info {
	  font-size: 12px;
	  padding-top: 2px;
	}

	span, p {
	  /*color: white;*/
	}

	.mini-stat-info span {
	  display: block;
	  font-size: 20px;
	  font-weight: 600;
	  margin-bottom: 5px;
	  margin-top: 7px;
	}

	/* ================ colors =====================*/
	.bg-facebook {
	  background-color: #3b5998 !important;
	  border: 1px solid #3b5998;
	  color: white;
	}

	.fg-facebook {
	  color: #3b5998 !important;
	}

	.bg-twitter {
	  background-color: #00a0d1 !important;
	  border: 1px solid #00a0d1;
	  color: white;
	}

	.fg-twitter {
	  color: #00a0d1 !important;
	}

	.bg-googleplus {
	  background-color: #db4a39 !important;
	  border: 1px solid #db4a39;
	  color: white;
	}

	.fg-googleplus {
	  color: #db4a39 !important;
	}

	.bg-bitbucket {
	  background-color: #205081 !important;
	  border: 1px solid #205081;
	  color: white;
	}

	.fg-bitbucket {
	  color: #205081 !important;
	}
	
		
	.highcharts-credits {
		display: none !important;
	}
	tbody td {
	  text-align: center;
	  border: 3px solid black;
	}
	thead td {
	  text-align: center;
	  font-size: 14px;
	  font-weight: bold;
	  border: 3px solid black;
	}

thead th, tfoot th, tfoot td {
  background: linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.5));
  border: 3px solid purple;
}
	
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
 <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
<div class="wrap">
<section class="app-content">
<!-----------------------------------------day wise report------------------------------>
<?php /* ?>
<div class="widget">
<div class="widget-body">
  <div class="row">
  <div class="col-md-6">
  <h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i> diy Schedule</h4>
  </div>
  <div class="col-md-6">
	<div class="row pull-right">
	<form id="form_new_user"  method="GET" action="" autocomplete="off">
		<?php if(get_role() != 'teacher'){?>
		<div class="col-md-5">
			<div class="form-group">
				<select name="course_id" id="course_id" class="form-control">
					<option value="">--Select Course--</option>
					<?php foreach($courseList as $k=>$cl){?>
						<option value="<?php echo $cl['id'];?>" <?php echo ($cl['id']==$course_ids)?"selected='selected'":'';?>><?php echo $cl['name'];?></option>
					<?php } ?>
				</select>		
			</div>
		</div>
		<?php }?>	
		<div class="col-md-5">
			<div class="form-group">
				<input type="text" id="search_from_date1" name="start1" value="<?php if(!empty($from_date1)){ echo date('m/d/Y', strtotime($from_date1)); } ?>" class="form-control" readonly required>
			</div>
		</div>
									
		<div class="col-md-2">
			<button class="btn btn-success waves-effect" type="submit" value="View"><i class="fa fa-search"></i></button>
		</div>		
	</form>
	</div>
  </div>
  </div>
  <hr style="margin-top: 10px;">
  
<div class="row">
<div class="col-md-12">
<div class="panel panel-default">	 
<div class="panel-body">    
	<div class="row">		
		<div class="col-md-3 col-sm-6 col-xs-12">
            <div class="mini-stat clearfix  bg-googleplus rounded">
                <span class="mini-stat-icon"><i class="fa fa-bar-chart fg-googleplus"></i></span>
                <div class="mini-stat-info">
                    <span><?php echo $todays_records1; ?></span>
                    Current Schedule
                </div>
            </div>
        </div>
		
		<?php if(get_role() != 'teacher'){ ?>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="mini-stat bg-facebook clearfix rounded">
                <span class="mini-stat-icon"><i class="fa fa-tasks fg-facebook"></i></span>
                <div class="mini-stat-info">
                    <span><?php echo $total_records1; ?></span>
                    Total Teachers
                </div>
            </div>
        </div>
		<?php } ?>
	</div>
</div>
</div>


<div class="panel panel-default">
  <div class="panel-heading"><b>diy Availability - <i class="fa fa-calendar"></i> <?php echo  date('d M Y', strtotime($from_date1)); ?></b></div>
  <div class="panel-body">	
	<div class="row">
	<div class="col-md-4 col-sm-4 col-xs-12">
	<?php if(!empty($course_data1)){ ?>
		<div style="width:100%;height:300px; padding:50px 10px">
			<canvas id="qa_2dpie_graph_container1"></canvas>
		</div>
	<?php } else { ?>
		<span class="text-danger"><b>-- No Records Availabale --</b></span>
	<?php } ?>
	</div>
	
	<?php if(get_role() != 'teacher'){ ?>
	<div class="col-md-8 col-sm-8 col-xs-12">
	<h4 class="text-center"><i class="fa fa-user"></i> Teacher Availability</h4>
	<hr/>
		<?php foreach($allUsers1 as $uid){ ?>
			<?php
			$total_check = $month1[$currMonth1]['user'][$uid];
			$percent_check = sprintf('%02d', round(($total_check / $allTotal1) * 100));
			$colorClass = "bg-primary";
			if($total_check >= 80){ $colorClass = "bg-success"; }
			if($total_check >= 50 && $total_check < 80){ $colorClass = "bg-primary"; }
			if($total_check >= 30 && $total_check < 50){ $colorClass = "bg-warning"; }
			if($total_check < 30){ $colorClass = "bg-danger"; }
			?>
			
			  <div class="row">
				<div class="col-md-4" style="text-align:right"><b><?php echo ucwords(strtolower($monthly1['userinfo'][$uid]['name'])); ?></b></div>
				<div class="col-md-6">
				<div class="progress">
				  <div class="progress-bar progress-bar-striped <?php echo $colorClass; ?>" role="progressbar" style="width: <?php echo $percent_check; ?>%" aria-valuenow="<?php echo $percent_check; ?>" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
				</div>
				<div class="col-md-2" style="text-align:left"><b><?php echo $percent_check; ?>% (<?php echo $total_check; ?>)</b></div>
			  </div>	  
		<?php } ?>
	</div>
	<?php } ?>
	
	</div>	
</div>
</div>




<div class="panel panel-default">
  <div class="panel-heading"><b>diy - Current Date Availability - <i class="fa fa-calendar"></i> <?php echo date('F Y', strtotime($currYear1 ."-".$currMonth1."-01")); ?></b></div>
  <div class="panel-body">
  <?php if(get_role() == 'teacher'){?>	
	<div class="row">	
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div style="width:100%;height:300px; padding:50px 10px">
			<!--<canvas id="qa_2dbar_graph_container1"></canvas>-->
			<?php if(!empty($teacher_avail_data)){ 
				
				?>
				<table class="displaytable">
				<thead>
					<tr>
						<td>Teacher Name</td>
						<td>Time Slots</td>
						<td>Availability</td>
						<td>Scheduled</td>
					</tr>
				</thead>
					<?php
					 foreach($teacher_avail_data as $k=>$kt){
					?>
					<tbody>
						<tr>
							<td><?php echo $kt['teacher_name'];?></td>
							<td><?php echo $kt['avail_start_time'].'-'.$kt['avail_end_time'];?></td>
							<td>Yes</td>
							<td><?php echo ($kt['schedule_id']>0)?'Yes':'No';?></td>
						</tr>	
					</tbody>
					<?php 
					}
					?>
				</table>
			<?php }else {?>
				<span class="text-danger"><b>-- No Records Availabale --</b></span>
			<?php }?>	
		</div>
	</div>	
	</div>
<? } else {?>
	<div class="row">
 <div class="col-md-12">

	<div id="myViewCourseCalendar" class="cal"></div>
</div>		
</div>
<?php } ?>
</div>
</div>


</div>
</div>


</div>
</div><?php */?>  

<!--------------------------------------------------------------------------------------->	

<div class="widget">
<div class="widget-body">
  <div class="row">
  <div class="col-md-6">
  <h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i> DIY Schedule</h4>
  </div>
  <div class="col-md-6">
	<div class="row pull-right">
	<form id="form_new_user"  method="GET" action="" autocomplete="off">
		<div class="col-md-3">
			<div class="form-group">
				<input type="text" id="search_from_date" name="start" value="<?php if(!empty($from_date)){ echo date('m/d/Y', strtotime($from_date)); } ?>" class="form-control" readonly required>
			</div>
		</div>
		<div class="col-md-3"> 
			<div class="form-group">
				<input type="text" id="search_to_date" name="end" value="<?php if(!empty($to_date)){ echo date('m/d/Y', strtotime($to_date)); } ?>" class="form-control" required readonly>
			</div> 
		</div>
		<div class="col-md-4">
			<div class="form-group">
					<select class="form-control" name="TimeZone" id="TimeZone" <?php echo $req; ?>>
						<option value="">-Select-</option>
					<?php foreach($GMT_timezone as $client){ ?>
						<?php 
							if($client['id']==$timezone_id)
								{ 
									$sel="selected";
								}else{
									$sel="";
								} 
						?>
						<option value="<?php echo $client['GMT_offset']."#".$client['id'] ?>" <?php echo $sel ?> ><?php echo $client['gmtCountryName'] ?></option>
					<?php } ?>
				</select>
			</div>
		</div>							
		<div class="col-md-2">
			<button class="btn btn-success waves-effect" type="submit" value="View"><i class="fa fa-search"></i></button>
		</div>		
	</form>
	</div>
  </div>
  </div>
  <hr style="margin-top: 10px;">
  
<div class="row">
<div class="col-md-12">
<div class="panel panel-default">	 
<div class="panel-body">    
	<div class="row">		
		<div class="col-md-3 col-sm-6 col-xs-12">
            <div class="mini-stat clearfix  bg-googleplus rounded">
                <span class="mini-stat-icon"><i class="fa fa-bar-chart fg-googleplus"></i></span>
                <div class="mini-stat-info">
                    <span><?php echo $todays_records; ?></span>
                    Current Schedule
                </div>
            </div>
        </div>
		
		<?php if(get_role() != 'teacher'){ ?>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="mini-stat bg-facebook clearfix rounded">
                <span class="mini-stat-icon"><i class="fa fa-tasks fg-facebook"></i></span>
                <div class="mini-stat-info">
                    <span><?php echo $total_records; ?></span>
                    Total Teachers
                </div>
            </div>
        </div>
		<?php } ?>
	</div>
</div>
</div>
<!-------------------schedule teacher table----------------------->
<?php if(!empty($teacher_avail_data)){ $divheight='650px';}else{$divheight='200px';}?>
<div class="panel panel-default" style="overflow-y: scroll;height: <?php echo $divheight;?>';">
  <div class="panel-heading"><b>DIY -  Date Wise Availability and Schedule - <i class="fa fa-calendar"></i> <?php echo date('F Y', strtotime($currYear1 ."-".$currMonth1."-01")); ?></b></div>
  <div class="panel-body">
  <?php if(get_role() == 'teacher'){?>	
	<div class="row">	
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div style="width:100%;height:300px; padding:50px 10px">
			<!--<canvas id="qa_2dbar_graph_container1"></canvas>-->
			<?php if(!empty($teacher_avail_data)){ 
				
				?>
				<table class="displaytable">
				<thead>
					<tr>
						<td>Teacher Name</td>
						<td>Date and Time Slots</td>
						<td>Availability</td>
						<td>Scheduled</td>
					</tr>
				</thead>
					<?php
					 foreach($teacher_avail_data as $k=>$kt){
					?>
					<tbody>
						<tr>
							<td><?php echo $kt['teacher_name'];?></td>
							<td><?php echo $kt['avail_date'];?> <?php echo $kt['avail_start_time'].'-'.$kt['avail_end_time'];?></td>
							<td>Yes</td>
							<td><?php echo ($kt['schedule_id']>0)?'Yes':'No';?></td>
						</tr>	
					</tbody>
					<?php 
					}
					?>
				</table>
			<?php }else {?>
				<span class="text-danger"><b>-- No Records Availabale --</b></span>
			<?php }?>	
		</div>
	</div>	
	</div>
<? } else {?>
	<div class="row">
 <div class="col-md-12">

	<div id="myViewCourseCalendar" class="cal"></div>
</div>		
</div>
<?php } ?>
</div>
</div>

<!-----------------------end of teacher schedole ------------------>
<br>
<div style="width:100%;height:300px; padding:50px 10px;display: none;">
			<canvas id="qa_2dpie_graph_container"></canvas>
		</div>
<div class="panel panel-default" >
  <div class="panel-heading"><b>DIY - Daywise Availability - <i class="fa fa-calendar"></i> <?php echo date('F Y', strtotime($currYear ."-".$currMonth."-01")); ?></b></div>
  <div class="panel-body">	
	<div class="row">	
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div style="width:100%;height:300px; padding:50px 10px">
			<canvas id="qa_2dbar_graph_container"></canvas>
		</div>
	</div>	
	</div>	
</div>
</div>


</div>
</div>


</div>
</div>  
<section>
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
     
	<?php //if(!empty($course_id)){ ?>
     //var events = [{"title":"first event","start":"2021-02-18","end":"2021-02-20","backgroundColor":"#00a65a"}];  
     var events = <?php echo json_encode($calendar_view_result); ?>;  
     $('#myViewCourseCalendar').fullCalendar({
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

	<?php //} ?>
</script>
