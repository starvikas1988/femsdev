<style>
.btn-sm{
	padding: 2px 5px;
}

.scrollheightdiv{
	max-height:600px;
	overflow-y:scroll;
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
  content: "ON";
  padding-left: 12px;
  background-color: #256799;
  color: #FFFFFF;
}
.flipswitch-inner:after {
  content: "OFF";
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

<div class="row">
<div class="col-md-12">
<?php if(!empty($this->input->get('elog')) && $this->input->get('elog') == "error"){ ?>
<div class="alert alert-danger" role="alert">
  <i class="fa fa-warning"></i> Email Prefix/Email ID  Already Exist!
</div>
<?php } ?>
</div>
</div>

<div class="row">

<div class="col-md-8">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title"><i class="fa fa-envelope"></i> Master Mail Box</h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">
<form autocomplete="off" method="POST" action="<?php echo base_url('emat/add_master_email'); ?>" enctype="multipart/form-data">				
	<div class="row masterEmailRow">
	
	<div class="col-md-6">
	<div class="form-group">
		<label>Name</label>
		<input class="form-control" name="email_name" required>
	</div>
	</div>
	
	<div class="col-md-6">
	<div class="form-group">
		<label for="process_id">Email Type</label>
		<select class="form-control" name="email_type" required>
			<option value="outlook">Outlook</option>
		</select>
	</div>
	</div>
	
	<div class="col-md-6">
	<div class="form-group">
		<label for="process_id">Mailbox Email</label>
		<input type="email" class="form-control" name="email_id" required>
	</div>
	</div>
	
	<div class="col-md-6">
	<div class="form-group">
		<label for="process_id">Authentication Type</label>
		<select class="form-control" name="auth_type" required>
			<option value="default">Default</option>
			<option value="shared">Shared</option>
		</select>
	</div>
	</div>
	
	<div class="col-md-6">
	<div class="form-group">
		<label for="process_id">Auth Email ID</label>
		<input type="email" class="form-control" name="auth_email" required>
	</div>
	</div>
	
	<div class="col-md-6">
	<div class="form-group">
		<label for="process_id">Auth Password</label>
		<input type="password" class="form-control" name="email_password" required>
	</div>
	</div>
	
	<div class="col-md-6">
	<div class="form-group">
		<label for="process_id">SLA (in Hours)</label>
		<input type="text" class="form-control" name="email_sla" value="0" required>
	</div>
	</div>
	
	<div class="col-md-3">
	<div class="form-group">
		<label for="process_id">Ticket Prefix</label>
		<input type="text" class="form-control text-uppercase" name="email_prefix" onkeypress="return event.charCode != 32" required>
	</div>
	</div>
	
	<div class="col-md-3">
	<div class="form-group">
		<label for="process_id">Ticket Sequence</label>
		<select class="form-control" name="email_ticket" required>
			<option value="">-- Select --</option>
			<option value="individual">Individual</option>
			<option value="continuous">Continuous</option>
		</select>
	</div>
	</div>
		
			
	</div>
	
	<div class="row">
	<div class="col-md-3">
		<label>Show Send Mail</label>
		<div class="flipswitch" style="margin-top:5px">			
			<input type="hidden" class="form-control inputBlock" name="c_show_send" id="c_show_send" value="0">
			<input type="checkbox" name="flipswitch" class="flipswitch-cb" id="flipper">
			<label class="flipswitch-label" for="fs">
				<div class="flipswitch-inner"></div>
				<div class="flipswitch-switch"></div>
			</label>
		</div>
	</div>
	
	<div class="col-md-3">
		<label>Show Auto Complete</label>
		<div class="flipswitch" style="margin-top:5px">			
			<input type="hidden" class="form-control inputBlock" name="c_show_auto" id="c_show_auto" value="0">
			<input type="checkbox" name="flipswitch" class="flipswitch-cb" id="flipper">
			<label class="flipswitch-label" for="fs">
				<div class="flipswitch-inner"></div>
				<div class="flipswitch-switch"></div>
			</label>
		</div>
	</div>
	
	<div class="col-md-3">
		<label>Show Complete Outlook</label>
		<div class="flipswitch" style="margin-top:5px">			
			<input type="hidden" class="form-control inputBlock" name="c_show_outlook" id="c_show_outlook" value="0">
			<input type="checkbox" name="flipswitch" class="flipswitch-cb" id="flipper">
			<label class="flipswitch-label" for="fs">
				<div class="flipswitch-inner"></div>
				<div class="flipswitch-switch"></div>
			</label>
		</div>
	</div>
	
	<div class="col-md-3">
		<label>Show Forward</label>
		<div class="flipswitch" style="margin-top:5px">			
			<input type="hidden" class="form-control inputBlock" name="c_show_forward" id="c_show_forward" value="0">
			<input type="checkbox" name="flipswitch" class="flipswitch-cb" id="flipper">
			<label class="flipswitch-label" for="fs">
				<div class="flipswitch-inner"></div>
				<div class="flipswitch-switch"></div>
			</label>
		</div>
	</div>
	</div>
	
	<hr/><br/>
	
	<div class="row">
	<div class="col-md-12">
	<div class="form-group">
		<button type="submit" class="btn btn-primary">Submit</button>
	</div>
	</div>
	</div>
</form>
</div>
</div>
</div>


<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title"><i class="fa fa-envelope"></i> Mail Box List</h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">					
<div class="table-responsive">
	
  <table id="default-datatable" class="table table-bordered mb-0 table table-striped skt-table" data-plugin="DataTable">  
    <thead>
      <tr class="bg-primary text-white">
	    <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col" class="text-center">SLA</th>
		<th scope="col" class="text-center">Prefix</th>
		<th scope="col" class="text-center">Sequence</th>
		<th scope="col" class="text-center">Authentication</th>
		<th scope="col" class="text-center">Verfication</th>
		<th scope="col" class="text-center">Status</th>
		<th scope="col" class="text-center">Action</th>
      </tr>
    </thead>
	
    <tbody>	
	<?php
	$countc = 0;
	foreach($category_list as $token){ 
		$countc++;
	?>	
      <tr>
        <td scope="row" class="text-center"><?php echo $countc; ?></td>
        <td scope="row"><b><?php echo $token['email_name']; ?></b></td>
        <td scope="row"><b><?php echo $token['email_id']; ?></b></td>     
        <td scope="row" class="text-center"><b><?php echo $token['ticket_sla']; ?>h</b></td>
		<td scope="row" class="text-center"><b><?php echo $token['ticket_prefix']; ?></b></td>
		<td scope="row" class="text-center"><b><?php echo $token['ticket_serial']; ?></b></td>
		<td scope="row" class="text-center"><b><?php echo ucwords($token['auth_type']); ?> <?php if($token['auth_type'] == "shared"){ echo "<br/>" .$token['auth_email']; } ?></b></td>
		<td scope="row" class="text-center">
		<b><?php echo !empty($token['is_verified']) ? "<span class='text-success'><i class='fa fa-check'></i> Verified</span>" : "<span class='text-danger'><i class='fa fa-times'></i>  Pending</span>"; ?></b>
		</td>
		<td scope="row" class="text-center">
		<b><?php echo !empty($token['is_active']) ? "<span class='text-success'>Active</span>" : "<span class='text-danger'>Inactive</span>"; ?></b>
		</td>
		<td scope="row" class="text-center">
		
		<a eid="<?php echo $token['id']; ?>" title="Update Settings" class="btn btn-primary btn-sm editMasterMailSettings"><i class="fa fa-gear"></i></a>
		<a eid="<?php echo $token['id']; ?>" title="Update Folder" class="btn btn-<?php if(!empty($token['folder_complete'])){ echo "success"; } else { echo "warning"; } ?> btn-sm editMasterMailFolder"><i class="fa fa-folder"></i></a>
		<?php /*if($token['ticket_prefix']=='LR'){ ?>
		<a bURL="<?php echo base_url()?>emat_move_completed/cron_update_move_mails/<?php echo bin2hex($token['email_id']); ?>/" class="btn btn-success btn-sm moveEmail"><i class="fa fa-share"></i>Move Mail</a>
		<?php } */?>
		
		<?php if(get_global_access() && !empty($token['is_active'])){ ?>
		<?php if(!empty($token['is_verified'])){ ?>
		<a bURL="<?php echo base_url()?>emat/cron_update_tickets/<?php echo bin2hex($token['email_id']); ?>/" class="btn btn-success btn-sm updateEmailMessages"><i class="fa fa-envelope-o"></i> Update Tickets</a>
		<?php } ?>
		
		<?php if(empty($token['is_verified'])){ ?>
		<a onclick="return confirm('Do you really want to verify?')" eid="<?php echo $token['id']; ?>" class="activateEmailVerify btn btn-warning btn-sm"><i class="fa fa-lock"></i> Verify & Activate</a>
		<?php } ?>
		
		<a eid="<?php echo $token['id']; ?>" class="btn btn-primary btn-sm editMasterMail"><i class="fa fa-edit"></i></a>
		<a onclick="return confirm('Do you really want to delete?')" href="<?php echo base_url() ."emat/delete_master_email?did=" .$token['id']; ?>" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></a>
		<?php } ?>
		</td>
      </tr>
	<?php } ?>	
    </tbody>
  </table>
		
		
</div>
</div>
</div>
</div>

</div>

<br/><br/><br/><br/><br/><br/><br/>

</section>
</div>





<div class="modal fade" id="modalUpdateEmail" tabindex="-1" role="dialog" aria-labelledby="modalUpdateEmail" aria-hidden="true">
  <div class="modal-dialog">  
    <div class="modal-content">
		
	<form class="frmUpdateEmail" id="frmUpdateEmail" action="<?php echo base_url(); ?>emat/add_master_email" method='POST' enctype="multipart/form-data">			
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="updateEmail">Mail Box Config Update</h4>
		</div>
		
		<div class="modal-body">				
			<input type="hidden" id='edit_id' name='edit_id' required>		
			<div class="row masterEmailRow">
				
				<div class="col-md-6">
				<div class="form-group">
					<label>Name</label>
					<input class="form-control" name="email_name" required>
				</div>
				</div>
				
				<div class="col-md-6">
				<div class="form-group">
					<label for="process_id">Email Type</label>
					<select class="form-control" name="email_type" required>
						<option value="outlook">Outlook</option>
					</select>
				</div>
				</div>
				
				<div class="col-md-6">
				<div class="form-group">
					<label for="process_id">Email ID</label>
					<input type="email" class="form-control" name="email_id" readonly required>
				</div>
				</div>
				
				<div class="col-md-6">
				<div class="form-group">
					<label for="process_id">Authentication Type</label>
					<select class="form-control" name="auth_type" required>
						<option value="default">Default</option>
						<option value="shared">Shared</option>
					</select>
				</div>
				</div>
				
				<div class="col-md-6">
				<div class="form-group">
					<label for="process_id">Auth Email ID</label>
					<input type="email" class="form-control" name="auth_email" required>
				</div>
				</div>
				
				<div class="col-md-6">
				<div class="form-group">
					<label for="process_id">Auth Password</label>
					<input type="text" class="form-control" name="email_password" required>
				</div>
				</div>
				
				<div class="col-md-6">
				<div class="form-group">
					<label for="process_id">SLA (in Hours)</label>
					<input type="text" class="form-control" name="email_sla" required>
				</div>
				</div>
				
				<div class="col-md-3">
				<div class="form-group">
					<label for="process_id">Ticket Prefix</label>
					<input type="text" class="form-control" name="email_prefix" readonly required>
				</div>
				</div>
				
				<div class="col-md-3">
				<div class="form-group">
					<label for="process_id">Ticket Serial</label>
					<select class="form-control" name="email_ticket" required>
						<option value="individual">Individual</option>
						<option value="continuous">Continuous</option>
					</select>
				</div>
				</div>
					
						
			</div>														
		</div>
			
	
	  <div class="modal-footer">			
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='btnUpdateEmail' class="btn btn-primary">Update</button>			
	  </div>		  
	</form>
		
	</div>
</div>
</div>




<div class="modal fade" id="modalUpdateEmailSettings" tabindex="-1" role="dialog" aria-labelledby="modalUpdateEmailSettings" aria-hidden="true">
  <div class="modal-dialog">  
    <div class="modal-content">
		
	<form class="frmUpdateEmailSettings" id="frmUpdateEmailSettings" action="<?php echo base_url(); ?>emat/update_master_email" method='POST' enctype="multipart/form-data">			
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="updateEmail">Mail Box Config Update</h4>
		</div>
		
		<div class="modal-body">				
			<input type="hidden" id='edit_id' name='edit_id' required>		
			<div class="row masterEmailRow">
				
				<div class="col-md-6">
				<div class="form-group">
					<label>Name</label>
					<input class="form-control" name="email_name" required readonly>
				</div>
				</div>
				
				<div class="col-md-6">
				<div class="form-group">
					<label for="process_id">Email ID</label>
					<input type="email" class="form-control" name="email_id" readonly required>
				</div>
				</div>
				
				<div class="col-md-12">
				<div class="form-group">
					<label for="process_id">SLA (in Hours)</label>
					<input type="text" class="form-control" name="email_sla" required>
				</div>
				</div>
				
				<div class="col-md-4">
				<div class="form-group">
					<label for="process_id">Show Send Mail</label>
					<select class="form-control" name="is_show_send" required>
						<option value="1">Yes</option>
						<option value="0">No</option>
					</select>
				</div>
				</div>
				
				<div class="col-md-4">
				<div class="form-group">
					<label for="process_id">Show Auto Complete</label>
					<select class="form-control" name="is_show_autocomplete" required>
						<option value="1">Yes</option>
						<option value="0">No</option>
					</select>
				</div>
				</div>
				
				<div class="col-md-4">
				<div class="form-group">
					<label for="process_id">Show Outlook Complete</label>
					<select class="form-control" name="is_show_outlook" required>
						<option value="1">Yes</option>
						<option value="0">No</option>
					</select>
				</div>
				</div>
				
				<div class="col-md-4">
				<div class="form-group">
					<label for="process_id">Show Forward</label>
					<select class="form-control" name="is_show_forward" required>
						<option value="1">Yes</option>
						<option value="0">No</option>
					</select>
				</div>
				</div>
				
				<div class="col-md-4">
				<div class="form-group">
					<label for="process_id">Status</label>
					<select class="form-control" name="is_emat_active" required>
						<option value="1">Active</option>
						<option value="0">Inactive</option>
					</select>
				</div>
				</div>
					
						
			</div>														
		</div>
			
	
	  <div class="modal-footer">			
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='btnUpdateEmailSettings' class="btn btn-primary">Update</button>			
	  </div>		  
	</form>
		
	</div>
</div>
</div>



<div class="modal fade" id="modalVerifyEmail" tabindex="-1" role="dialog" aria-labelledby="modalVerifyEmail" aria-hidden="true">
  <div class="modal-dialog">  
    <div class="modal-content">				
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="modalBodyEMATHead">Verify Mail</h4>
		</div>		
		<div class="modal-body">	
			<div class="row">				
				<div class="col-md-12 modalBodyEMATDesc">
				</div>
			</div>														
		</div>		
	  <div class="modal-footer">			
		<button type="button" onclick="javascript:window.location.reload();" class="btn btn-default">Close</button>		
	  </div>		
	</div>
</div>
</div>


<div class="modal fade" id="modalEmailDetails" tabindex="-1" role="dialog" aria-labelledby="modalEmailDetails" aria-hidden="true">
  <div class="modal-dialog">  
    <div class="modal-content">				
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title">EMAT Info</h4>
		</div>		
		<div class="modal-body">														
		</div>		
	  <div class="modal-footer">			
		<button type="button" onclick="javascript:window.location.reload();" class="btn btn-default">Close</button>		
	  </div>		
	</div>
</div>
</div>


<div class="modal fade" id="modalCronEmailMessage" tabindex="-1" role="dialog" aria-labelledby="modalCronEmailMessage" aria-hidden="true">
  <div class="modal-dialog">  
    <div class="modal-content">					
		<div class="modal-header">
		<h4 class="modal-title">Mail Log</h4>
		</div>		
		<div class="modal-body">	
			<div class="row">				
				<div class="col-md-12 modalBodyCronMessage">
				</div>
			</div>														
		</div>		
	  <div class="modal-footer">			
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>		
	  </div>		
	</div>
</div>
</div>