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
</style>
<div class="wrap">
<section class="app-content">

<div class="widget">
<div class="widget-body">

  <h4><?php echo fdcrm_title(); ?>
  <a href="javascript:window.close();" style="cursor:pointer" class="pull-right btn btn primary"><i class="fa fa-arrow-left"></i> Go Back</a>
  <p class="timerClock pull-right hide"><i class="fa fa-clock-o"></i> <span id="timeWatch"></span></p>
  </h4>
  <hr/>
 
  
<form id="crmForm" action="<?php echo fdcrm_url('submit_feedback_crm'); ?>" method="POST" autocomplete="off">


<div class="row" id="formInfoCrm">

<div class="col-md-6">  
 <div class="panel panel-default">
  <div class="panel-heading">Call Information</div>
  <div class="panel-body"> 
	<br/>
	
	
	<div class="row">
	<div class="col-md-12">
		<div class="form-group">
		 <label for="case">Email ID **</label>
		 <div class="input-group">
			<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
			<input type="text" class="form-control" id="c_email" placeholder="" value="<?php echo $crm_details['c_email']; ?>" name="c_email" required>
		 </div>		 
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
		 <label for="case">Phone No</label>
		 <div class="input-group">
			<span class="input-group-addon"><i class="fa fa-phone"></i></span>
			<input type="text" class="form-control" id="c_phone_no" placeholder="" value="<?php echo $crm_details['c_phone_no']; ?>" name="c_phone_no">
		 </div>		 
		</div>
	</div>
	</div>
		
	<div class="row">	
	<div class="col-md-6">
		<div class="form-group">
		 <label for="case">Firstname</label>
		 <div class="input-group">
			<span class="input-group-addon"><i class="fa fa-user"></i></span>
			<input type="text" class="form-control" id="c_firstname" placeholder="" value="<?php echo $crm_details['c_fname']; ?>" name="c_firstname">
		 </div>	
		 
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
		 <label for="case">Lastname</label>
		 <div class="input-group">
			<span class="input-group-addon"><i class="fa fa-user"></i></span>
			<input type="text" class="form-control" id="c_lastname" placeholder="" value="<?php echo $crm_details['c_lname']; ?>" name="c_lastname">
		 </div>		 
		</div>
	</div>
	</div>
		
	<hr/>
	
	
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
		  <input type="text" class="form-control" id="crm_id" placeholder="" value="<?php echo $crm_details['crm_id']; ?>" name="crm_id" required readonly>
		  <input type="hidden" class="form-control" id="time_interval" placeholder="" value="" name="time_interval" readonly>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
		  <label for="case">Date (m/d/Y)</label>
		  <input type="text" class="form-control" id="c_date" placeholder="" value="<?php echo date('m/d/Y', strtotime($crm_details['date_added'])); ?>" name="c_date" readonly>
		</div>
	</div>
	</div>
	
	<div class="row" style="display:none">
	<div class="col-md-12">
		<div class="form-group">
		  <label for="case">Status : **</label>
		  <select class="form-control" name="cl_disposition" id="cl_disposition" required>
			<option value=''>--- Select Call Type ---</option>
			<option value="saved" <?php echo $crm_details['c_status'] == 'saved' ? 'selected' : ''; ?>>Saved</option>
			<option value="cancelled" <?php echo $crm_details['c_status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
		  </select>
		</div>
	</div>
	</div>
	
	
	<div class="row">
	<div class="col-md-12">		
		<div class="form-group">
		  <label for="case">Customer Ref ID (Optional)</label>
		  <div class="input-group">
			<span class="input-group-addon"><i class="fa fa-tag"></i></span>
			<input class="form-control" name="c_reference" id="c_reference" value="<?php echo $crm_details['c_call_ref']; ?>" >
		 </div>		  
		</div>
	</div>
	<div class="col-md-12">		
		<div class="form-group">
		  <label for="case">Comments</label>
		  <textarea class="form-control" name="cl_comments" id="cl_comments"><?php echo $crm_details['c_comments']; ?></textarea>
		</div>
	</div>	
	</div>
	</div>
	
	<div class="row" style="display:none">
	<div class="col-md-12">
		<div class="form-group">
		  <label for="case">Hold Time</label>
		  <div class="input-group">
            <div class="input-group-addon">
               <span class="input-group-text"><i class="fa fa-clock-o"></i></span>
            </div>
			<input type="text" class="form-control" id="c_holdtime" placeholder="" value="<?php echo $crm_details['c_hold_time']; ?>" name="c_holdtime" readonly>
		   </div>		  
		</div>
	</div>
	<div class="col-md-12">		
		<div class="form-group">
		  <label for="case">Reason for Hold</label>
		  <textarea class="form-control" name="c_hold_reason" id="c_hold_reason" readonly><?php echo $crm_details['c_hold_reason']; ?></textarea>
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

<div class="col-md-12">  
 <div class="panel panel-default">
  <div class="panel-body">
	  <div class="row">	
	<div class="col-md-6">
		<button type="submit" onclick="return confirm('Do you want to update this data?')" class="btn btn-success"><i class="fa fa-sign-in"></i> Update</button>
	</div>
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