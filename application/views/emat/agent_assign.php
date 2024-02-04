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
<h4 class="widget-title"><i class="fa fa-users"></i> Add Agents Skillset</h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">
<form autocomplete="off" method="POST" action="<?php echo base_url('emat/add_master_agent_assign'); ?>" enctype="multipart/form-data">
		
	<div class="row">	
	<div class="col-md-12 table-responsive" style="max-height:300px;">
			
		  <table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
			<thead>
				<tr class='bg-primary'>
					<th><input type="checkbox" name="selectAllUserCheckBox" class="selectAllUserCheckBox" value="1"></th>
					<th>Name</th>
					<th>Fusion ID</th>
					<th>Department</th>
					<th>Designation</th>
				</tr>
			</thead>
			<tbody id="allUserCheckTableList">
			<?php foreach($agent_list as $token){ ?>
				<tr>
					<td><input type="checkbox" name="userCheckBox[]" value="<?php echo $token['id']; ?>"></th>
					<td><?php echo $token['full_name']; ?></td>
					<td><?php echo $token['fusion_id']; ?></td>
					<td><?php echo $token['department']; ?></td>
					<td><?php echo $token['designation']; ?></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>		
	</div>
	</div>
	
	<hr/>
	
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
		<input type="hidden" name="skill_type" value="1">
		<button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Submit</button>
	</div>
	</div>
	</div>
	
</form>
</div>
</div>
</div>


<div class="col-md-4 ">
<div class="row">

<div class="col-md-12 agentWidget">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title"><i class="fa fa-users"></i> Auto Assign Settings</h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">
<form autocomplete="off" method="POST" action="<?php echo base_url('emat/add_master_auto_assign'); ?>" enctype="multipart/form-data">
			
	<div class="row">	
	<div class="col-md-6">
	<div class="form-group">
		<label>Auto Assign Threshold (in Minutes)</label>
		<input class="form-control" name="auto_assign_threshhold" value="<?php echo !empty($agent_config) ? $agent_config[0]['auto_assign_threshold'] : '0'; ?>" required>
	</div>
	</div>
	
	<div class="col-md-6">
	<div class="form-group">
		<label>Auto Transfer Threshold (in Minutes)</label>
		<input class="form-control" name="auto_transfer_threshhold" value="<?php echo !empty($agent_config) ? $agent_config[0]['auto_transfer_threshold'] : '60'; ?>" required>
	</div>
	</div>
	</div>
	
	
	<div class="row">
	<div class="col-md-6">
		<label>Auto Assign</label>
		<div class="flipswitch" style="margin-top:5px">			
			<input type="hidden" class="form-control inputBlock" name="c_auto_assign" id="c_auto_assign" value="<?php echo !empty($agent_config) ? $agent_config[0]['is_auto_assign'] : 0; ?>">
			<input type="checkbox" name="flipswitch" class="flipswitch-cb" id="flipper"  <?php echo !empty($agent_config[0]['is_auto_assign']) ? 'checked' : ''; ?>>
			<label class="flipswitch-label" for="fs">
				<div class="flipswitch-inner"></div>
				<div class="flipswitch-switch"></div>
			</label>
		</div>
	</div>
	
	<div class="col-md-6">
		<label>Auto Transfer</label>
		<div class="flipswitch" style="margin-top:5px">			
			<input type="hidden" class="form-control inputBlock" name="c_auto_transfer" id="c_auto_transfer" value="<?php echo !empty($agent_config) ? $agent_config[0]['is_auto_transfer'] : 0; ?>">
			<input type="checkbox" name="flipswitch" class="flipswitch-cb" id="flipper" <?php echo !empty($agent_config[0]['is_auto_transfer']) ? 'checked' : ''; ?>>
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
		<button type="submit" class="btn btn-success"><i class="fa fa-paper-plane"></i> Update</button>
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
<h4 class="widget-title"><i class="fa fa-users"></i> Agent Skillset Uploader</h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">
<form autocomplete="off" method="POST" action="<?php echo base_url('emat/upload_master_agent_skillset'); ?>" enctype="multipart/form-data">
	<div class="row">
	<div class="col-md-12">
	<div class="form-group">
		<a href="<?php echo base_url() ."emat/download_agent_skillset?type=1"; ?>" class="btn btn-success btn-xs" style="float:right;margin-right: 8px;"><i class="fa fa-download"></i> Download Skillset</a>
	</div>
	</div>
	<div class="col-md-12">
	<div class="form-group">
		<label for="upload_file">Upload File</label>
		<input type="file" class="form-control" name="userfile" id="skill_upload_file" accept=".xls,.xlsx" required>
	</div>
	</div>
	</div>
	<hr>
	<div class="row">
	<div class="col-md-12">
	<div class="form-group">
		<input type="hidden" name="skill_type" value="1">
		<button type="submit" class="btn btn-success"><i class="fa fa-paper-plane"></i> Update</button>
	</div>
	</div>
	</div>
	
</form>
</div>
</div>
</div>





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


