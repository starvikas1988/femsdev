<style>
.btn-sm{
	padding: 2px 5px;
}

.scrollheightdiv{
	max-height:600px;
	overflow-y:scroll;
}
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

<div class="col-md-8 agentWidget">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title"><i class="fa fa-users"></i> Master Config</h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">
<form autocomplete="off" method="POST" action="<?php echo base_url('emat/add_master_config'); ?>" enctype="multipart/form-data">
	
	<div class="row">	
	<div class="col-md-6">
	<div class="form-group">
		<label>Mail Box</label>
		<select class="form-control" name="mail_box[]" multiple required>
			<?php foreach($category_list as $token){ ?>
				<option value="<?php echo $token['id']; ?>"><?php echo $token['email_name']; ?></option>
			<?php } ?>
		</select>
	</div>
	</div>
	
	<div class="col-md-6">
	<div class="form-group">
		<label for="process_id">Category</label>
		<select class="form-control" name="category_id[]" multiple>
			<?php foreach($category_list_all as $token){ ?>
				<option value="<?php echo $token['category_code']; ?>"><?php echo $token['category_name']; ?></option>
			<?php } ?>
		</select>
	</div>
	</div>
	</div>
	
	
	<div class="row">
	<div class="col-md-6">
		<label>Agent Pick</label>
		<div class="flipswitch" style="margin-top:5px">			
			<input type="hidden" class="form-control inputBlock" name="c_agent_pick" id="c_agent_pick" value="0">
			<input type="checkbox" name="flipswitch" class="flipswitch-cb" id="flipper">
			<label class="flipswitch-label" for="fs">
				<div class="flipswitch-inner"></div>
				<div class="flipswitch-switch"></div>
			</label>
		</div>
	</div>
	
	<div class="col-md-6">
		<label>Agent Pass</label>
		<div class="flipswitch" style="margin-top:5px">			
			<input type="hidden" class="form-control inputBlock" name="c_agent_pass" id="c_agent_pass" value="0">
			<input type="checkbox" name="flipswitch" class="flipswitch-cb" id="flipper">
			<label class="flipswitch-label" for="fs">
				<div class="flipswitch-inner"></div>
				<div class="flipswitch-switch"></div>
			</label>
		</div>
	</div>
	</div>
	
	<br/><hr/>
	
	<div class="row">
	<div class="col-md-12">
	<div class="form-group">
		<button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Submit</button>
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
<h4 class="widget-title"><i class="fa fa-users"></i> Agents Skillset</h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">					
<div class="table-responsive">
	
  <table id="default-datatable-list" class="table table-bordered mb-0 table table-striped skt-table" data-plugin="DataTable">  
    <thead>
      <tr class="bg-primary text-white">
	    <th scope="col">#</th>        
        <th scope="col">Fusion ID</th>
		<th scope="col">Name</th>
        <th scope="col">Office</th>
        <th scope="col">Mail Box</th>
		<th scope="col">Category</th>
		<th scope="col">Action</th>
      </tr>
    </thead>
	
    <tbody>	
	<?php
	$countc = 0;
	foreach($agent_list as $token){ 
		$countc++;
		$currID = $token['id'];
		$skill_emails = !empty($skillsArray[$currID]['mail']) ? implode(', ', array_column($skillsArray[$currID]['mail'], 'email_name')) : "-";
		$skill_category = !empty($skillsArray[$currID]['cat']) ? implode(', ', array_column($skillsArray[$currID]['cat'], 'category_name')) : "-";
	?>	
      <tr>
        <td scope="row" class="text-center"><?php echo $countc; ?></td>       
        <td scope="row"><b><?php echo $token['fusion_id']; ?></b></td>
		 <td scope="row"><b><?php echo $token['full_name']; ?></b></td>
        <td scope="row"><b><?php echo $token['office_id']; ?></b></td>        
        <td scope="row"><b><?php echo $skill_emails; ?></b></td>
		<td scope="row"><b><?php echo $skill_category; ?></b></td>
		<td scope="row" class="text-center">
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
			<div class="row">
				
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
					<input type="email" class="form-control" name="email_id" required>
				</div>
				</div>
				
				<div class="col-md-6">
				<div class="form-group">
					<label for="process_id">Password</label>
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
					<input type="text" class="form-control" name="email_prefix" required>
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
