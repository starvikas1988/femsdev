<style>
.form-group {
	margin-bottom:18px;
}
.timerClock{
	/*display:none;*/
}
.ui-datepicker{
	z-index:999999!important;
}

.flipswitch {
  position: relative;
  width: 120px;
}
.flipswitch input[type=checkbox] {
  display: none;
}
.flipswitch-label {
  display: block;
  overflow: hidden;
  cursor: pointer;
  border: 2px solid #999999;
  border-radius: 50px;
}
.flipswitch-inner {
  width: 200%;
  margin-left: -100%;
  transition: margin 0.3s ease-in 0s;
}
.flipswitch-inner:before, .flipswitch-inner:after {
  float: left;
  width: 50%;
  height: 24px;
  padding: 0;
  line-height: 24px;
  font-size: 14px;
  color: white;
  font-family: Trebuchet, Arial, sans-serif;
  font-weight: bold;
  box-sizing: border-box;
}
.flipswitch-inner:before {
  content: "EMAIL ON";
  padding-left: 12px;
  background-color: #256799;
  color: #FFFFFF;
}
.flipswitch-inner:after {
  content: "EMAIL OFF";
  padding-right: 12px;
  background-color: #EBEBEB;
  color: #888888;
  text-align: right;
}
.flipswitch-switch {
  width: 31px;
  margin: -3.5px;
  background: #FFFFFF;
  border: 2px solid #999999;
  border-radius: 50px;
  position: absolute;
  top: 0;
  bottom: 0;
  right: 99px;
  transition: all 0.3s ease-in 0s;
}
.flipswitch-cb:checked + .flipswitch-label .flipswitch-inner {
  margin-left: 0;
}
.flipswitch-cb:checked + .flipswitch-label .flipswitch-switch {
  right: 0;
}
</style>
<div class="wrap">
<section class="app-content">

<div class="widget">
<div class="widget-body">

  <h4><?php echo fdcrm_title(); ?>
  <p class="timerClock pull-right hide"><i class="fa fa-clock-o"></i> <span id="timeWatch"></span></p>
  </h4>
  <hr/>
 
  
<form id="crmForm" action="<?php echo fdcrm_url('submit_feedback_crm'); ?>" method="POST" autocomplete="off">

<div class="row" style="display:none">
<div class="col-md-12">
<div class="panel panel-default">	 
<div class="panel-body" id="buttonCallBody">    
	<div class="row">
	<div class="col-md-6">
		<button type="button" class="btn btn-success" id="startCallModalButton" data-toggle="modal" data-target="#startCallModal"><i class="fa fa-play"></i> Start</button>
		<button type="button" style="display:none" class="btn btn-warning" id="holdCallModalButton" data-toggle="modal" data-target="#holdCallModal"><i class="fa fa-pause"></i> Hold</button>
		<button type="button" style="display:none" class="btn btn-primary" id="unholdCallModalButton" data-toggle="modal" data-target="#unholdCallModal"><i class="fa fa-play"></i> Unhold</button>
		<button type="submit" style="display:none" onclick="return confirm('Do you want to end this call?')" id="endCallModalButton" class="btn btn-danger"><i class="fa fa-stop"></i> End</button>
		<!--<button type="submit" id="endCallSubmit" name="save" class="btn btn-success">SUBMIT</button>-->
	</div>

	<div class="col-md-6">
		<b> 
		<div style="font-size:16px" class="text-danger inWait">&nbsp;&nbsp; <i class="fa fa-spinner fa-spin"></i> Waiting for Action....</div>		
		<div style="display:none;font-size:20px" class="text-success inCall">In Call - &nbsp;&nbsp; <i class="fa fa-clock-o"></i> <span></span></div>		
		<div style="display:none;font-size:20px" class="text-warning inHold">In Hold - &nbsp;&nbsp; <i class="fa fa-clock-o"></i> <span></span></div>		
		</b>
		<input type="hidden" name="timer_start_status" id="timer_start_status" value="S">
		<input type="hidden" name="timer_hold_status" id="timer_hold_status" value="H">
		<br/>
		<input type="hidden" name="timer_start" id="timer_start">
		<input type="hidden" name="timer_hold" id="timer_hold">
		<div id="timeHolder"></div>
	</div>	
	</div>	
</div>
</div>
</div>
</div>

<div class="row" id="formInfoCrm" style="display:none">

<div class="col-md-12">  
 <div class="panel panel-default">
  <div class="panel-heading">VOC Feedback Mail</div>
  <div class="panel-body"> 
	<br/>	
	
	
	<div class="row">
	<div class="col-md-4">
		<div class="form-group">
		 <label for="case">Client</label>
		 <select class="form-control" name="f_client" id="f_client" placeholder="" required>
			<?php 
			$_dropdown_client = fdcrm_dropdown_source();
			echo fdcrm_dropdown_options($_dropdown_client); 
			?>				
		  </select>		 
		</div>
	</div>
	
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case">Client/Brand Name</label>
		  <div class="input-group">
			<span class="input-group-addon"><i class="fa fa-tag"></i></span>
			<input class="form-control" name="f_brand" id="f_brand">
		 </div>		  
		</div>
	</div>
	
	<div class="col-md-4">		
		<div class="form-group">
		  <label for="case">Email Body</label>
		  <select class="form-control" name="f_body" id="f_body" required>
			<option value=''>--- Select Type ---</option>
			<option value="default" selected>Default</option>
			<option value="custom">Custom</option>
		  </select>		  
		</div>
	</div>
	
	</div>
 </div>
</div>
</div>



<div class="col-md-12 customEmailBody" style="display:none">  
 <div class="panel panel-default">
  <div class="panel-heading">Custom Email</div>
  <div class="panel-body"> 
	<br/>
	<div class="row">
	<div class="col-md-12">
		<div class="form-group">
		 <label for="case">Email Body</label>
		 <textarea class="form-control" id="f_email_body" name="f_email_body" required></textarea> 
		</div>
	</div>
	
	</div>
 </div>
</div>
</div>



<div class="col-md-6">  
 <div class="panel panel-default">
  <div class="panel-heading">Call Information</div>
  <div class="panel-body"> 
	<br/>	
	
	<div class="row">	
	</div>
	
	<div class="row">
	<div class="col-md-12">
		<div class="form-group">
		 <label for="case">Email ID **</label>
		 <div class="input-group">
			<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
			<input type="email" class="form-control" id="c_email" placeholder="" value="" name="c_email" required>
		 </div>		 
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
		 <label for="case">Phone No (Optional)</label>
		 <div class="input-group">
			<span class="input-group-addon"><i class="fa fa-phone"></i></span>
			<input type="text" class="form-control" id="c_phone_no" placeholder="" value="" name="c_phone_no">
		 </div>		 
		</div>
	</div>
	</div>
		
	<div class="row">	
	<div class="col-md-6">
		<div class="form-group">
		 <label for="case">Client Firstname **</label>
		 <div class="input-group">
			<span class="input-group-addon"><i class="fa fa-user"></i></span>
			<input type="text" class="form-control" id="c_firstname" placeholder="" value="" name="c_firstname" required>
		 </div>	
		 
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
		 <label for="case">Client Lastname</label>
		 <div class="input-group">
			<span class="input-group-addon"><i class="fa fa-user"></i></span>
			<input type="text" class="form-control" id="c_lastname" placeholder="" value="" name="c_lastname">
		 </div>		 
		</div>
	</div>
	</div>
		
	<hr/>
	
	<div class="row">
	<div class="col-md-12">
		<div class="form-group">
		<button type="submit" onclick="return confirm('Do you want to submit this entry?')" class="btn btn-danger"><i class="fa fa-sign-in"></i> Submit</button>
	</div>
	</div>
	</div>
	
 </div>
</div>
</div>

<div class="col-md-6">	
<div class="panel panel-default">
  <div class="panel-heading">Call Status</div>
  <div class="panel-body">
	<br/>
	
	
	<div class="row">
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">CRM ID</label>
		  <input type="text" class="form-control" id="crm_id" placeholder="" value="<?php echo $crmid; ?>" name="crm_id" required readonly>
		  <input type="hidden" class="form-control" id="time_interval" placeholder="" value="" name="time_interval" readonly>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">Date (m/d/Y)</label>
		  <input type="text" class="form-control" id="c_date" placeholder="" value="<?php echo date('m/d/Y', strtotime($currentDate)); ?>" name="c_date" readonly>
		</div>
	</div>
	</div>
	
	<div class="row" style="display:none">
	<div class="col-md-12">
		<div class="form-group">
		  <label for="case">Status : **</label>
		  <select class="form-control" name="cl_disposition" id="cl_disposition" required>
			<option value=''>--- Select Call Type ---</option>
			<option value="saved" selected>Saved</option>
			<option value="cancelled">Cancelled</option>
		  </select>
		</div>
	</div>
	</div>
	
	
	<div class="row">
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Feedback Type</label>
		  <select class="form-control" name="f_quarter" id="f_quarter" required>
			<option value=''>--- Select Type ---</option>
			<option value="1">1st Quarter (Jan - Mar)</option>
			<option value="2">2nd Quarter (Apr - Jun)</option>
			<option value="3">3rd Quarter (Jul - Sep)</option>
			<option value="4">4th Quarter (Oct - Dec)</option>
		  </select>		  
		</div>
	</div>
	
	<div class="col-md-12">		
		<div class="form-group">
		  <label for="case">Notes (Optional)</label>
		  <textarea class="form-control" name="cl_comments" id="cl_comments"></textarea>
		</div>
	</div>	
	</div>
	
		
	<div class="row">
	<div class="col-md-12">
		<div class="flipswitch">
			<input type="hidden" class="form-control" name="c_email_auto" id="c_email_auto" value="1">
			<input type="checkbox" name="flipswitch" class="flipswitch-cb" id="flipper" checked>
			<label class="flipswitch-label" for="fs">
				<div class="flipswitch-inner"></div>
				<div class="flipswitch-switch"></div>
			</label>
		</div>
	</div>
	</div>
	
	
	<div class="row" style="display:none">
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">No. Of Hold : **</label>
		  <div class="input-group">
            <div class="input-group-addon">
               <span class="input-group-text"><i class="fa fa-tag"></i></span>
            </div>
			<input type="number" class="form-control" id="c_hold" placeholder="" name="c_hold" value="0" readonly required>
		   </div>		  
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">Hold Time</label>
		  <div class="input-group">
            <div class="input-group-addon">
               <span class="input-group-text"><i class="fa fa-clock-o"></i></span>
            </div>
			<input type="text" class="form-control" id="c_holdtime" placeholder="" value="00:00:00" name="c_holdtime" required readonly>
		   </div>		  
		</div>
	</div>
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Reason for Hold</label>
		  <textarea class="form-control" name="c_hold_reason" id="c_hold_reason" readonly></textarea>
		</div>
	</div>
	<!--<div class="col-md-6">
		<div class="form-group">
		  <label for="case">Call AHT</label>
		  <input type="text" class="form-control" id="c_call" placeholder="" value="" name="c_call" readonly>
		</div>
	</div>-->
	</div>	
	
	
 </div>  
</div>
</div>

<div class="col-md-12">  
 <div class="panel panel-default">
  <div class="panel-body">
	  <div class="row">	
	<div class="col-md-6">
		
	</div>
	</div>	
  </div>
  </div>
</div>

</div>
</form>


<div class="modal fade" id="startCallModal" tabindex="-1" role="dialog" aria-labelledby="startCallModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="startCallModalLabel"><i class="fa fa-play"></i> Start Call</h4>
      </div>
      <div class="modal-body">
		<p class="text-success"><b>Do you want to start new call ?</b></p>	
      </div>	  
      <div class="modal-footer">
	    <button type="button" btype="start" onclick="callActionButton(this)" class="btn btn-success">Yes, Start</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="holdCallModal" tabindex="-1" role="dialog" aria-labelledby="holdCallModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="holdCallModalLabel"><i class="fa fa-pause"></i> Hold Call</h4>
      </div>
      <div class="modal-body">
		<p class="text-warning"><b>Do you want to hold this call ?</b></p>		
		<div class="form-group">
		  <label for="case">Reason for Hold **</label>
		  <textarea class="form-control" name="modal_hold_reason" id="modal_hold_reason" required></textarea>
		</div>
      </div>	  
      <div class="modal-footer">
	    <button type="button" btype="hold" onclick="callActionButton(this)" class="btn btn-warning">Yes, Hold</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="unholdCallModal" tabindex="-1" role="dialog" aria-labelledby="unholdCallModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="unholdCallModalLabel"><i class="fa fa-play"></i> Unhold Call</h4>
      </div>
      <div class="modal-body">
		<p class="text-primary"><b>Do you want to unhold this call ?</b></p>	
      </div>	  
      <div class="modal-footer">
	    <button type="button" btype="unhold" onclick="callActionButton(this)"  class="btn btn-primary">Yes, Unhold</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="endCallModal" tabindex="-1" role="dialog" aria-labelledby="endCallModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="endCallModalLabel"><i class="fa fa-stop"></i> End Call</h4>
      </div>
      <div class="modal-body">
		<p class="text-danger"><b>Do you want to end this call ?</b></p>	
      </div>	  
      <div class="modal-footer">
	    <button type="button" btype="end" onclick="callActionButton(this)" class="btn btn-danger">Yes, End</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>





</div>
</div>  
<section>
</div>