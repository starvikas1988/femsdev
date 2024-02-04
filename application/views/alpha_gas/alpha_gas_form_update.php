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

  <h4>Alpha Gas CRM
  <a href="javascript:window.close();" style="cursor:pointer" class="pull-right btn btn primary"><i class="fa fa-arrow-left"></i> Go Back</a>
  <p class="timerClock pull-right hide"><i class="fa fa-clock-o"></i> <span id="timeWatch"></span></p>
  </h4>
  <hr/>
 
  
<form id="crmForm" action="<?php echo base_url(); ?>alphagas/submit_alpha_gas" method="POST" autocomplete="off">


<div class="row" id="formInfoCrm">

<div class="col-md-6">  
 <div class="panel panel-default">
  <div class="panel-heading">Call Information</div>
  <div class="panel-body"> 
	<br/>
	
	
	<div class="row">	
	<div class="col-md-6">
		<div class="form-group">
		 <label for="case">Firstname</label>
		 <input type="text" class="form-control" id="c_firstname" placeholder="" value="<?php echo $crm_details['c_fname']; ?>" name="c_firstname">
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
		 <label for="case">Lastname</label>
		 <input type="text" class="form-control" id="c_lastname" placeholder="" value="<?php echo $crm_details['c_lname']; ?>" name="c_lastname">
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-6">
		<div class="form-group">
		 <label for="case">Language</label>
		 <select class="form-control" name="c_language" id="c_language" required>
		  <option value=''>-- Select Option --</option>
		  <option value='English' <?php echo $crm_details['c_language'] == 'English' ? 'selected' : ''; ?>>English</option>
		  <option value='Spanish' <?php echo $crm_details['c_language'] == 'Spanish' ? 'selected' : ''; ?>>Spanish</option>
		  </select>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
		 <label for="case">Phone No</label>
		 <input type="text" class="form-control" id="c_phone_no" placeholder="" value="<?php echo $crm_details['c_phone_no']; ?>" name="c_phone_no">
		</div>
	</div>
	</div>
	
	<div class="row">
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Address</label>
		  <textarea class="form-control" name="c_address" id="c_address"><?php echo $crm_details['c_address']; ?></textarea>
		</div>
	</div>
	</div>
	
	<hr/>
	
	<div class="row">
	<div class="col-md-6">		
		<div class="form-group">
		  <label for="case">Utility Electric</label>
		  <input type="text" class="form-control" id="c_utility_electric" placeholder="" value="<?php echo $crm_details['c_utility_electric']; ?>" name="c_utility_electric">
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
		 <label for="case">Account Number - Electric</label>
		 <input type="text" class="form-control" id="c_electric_account" placeholder="" value="<?php echo $crm_details['c_electric_account']; ?>" name="c_electric_account">
		</div>
	</div>
	</div>
	
	<div class="row">	
	<div class="col-md-6">
		<div class="form-group">
		 <label for="case">Utility Gas</label>
		 <input type="text" class="form-control" id="c_utility_gas" placeholder="" value="<?php echo $crm_details['c_utility_gas']; ?>" name="c_utility_gas">
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
		 <label for="case">Account Number - GAS</label>
		 <input type="text" class="form-control" id="c_gas_account" placeholder="" value="<?php echo $crm_details['c_gas_account']; ?>" name="c_gas_account">
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
	
	<div class="row">
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
	
	<div class="col-md-12">
		<div class="form-group">
		  <label for="case">Cancellation Reason : </label>
		  <select class="form-control" name="c_cancellation" id="c_cancellation">
			<option value=''>--- Select Call Type ---</option>
			<?php foreach($cancellationArray as $token){ ?>
			<option value="<?php echo $token; ?>" <?php echo $crm_details['c_cancellation'] == $token ? 'selected' : ''; ?>><?php echo $token; ?></option>
			<?php } ?>
		  </select>
		</div>
	</div>
	</div>
	
	
	<div class="row">
	<div class="col-md-12">		
		<div class="form-group">
		  <label for="case">Comments (Optional)</label>
		  <textarea class="form-control" name="cl_comments" id="cl_comments"><?php echo $crm_details['c_comments']; ?></textarea>
		</div>
	</div>	
	</div>
	
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