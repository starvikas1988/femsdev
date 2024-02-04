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
<h4 class="widget-title"><i class="fa fa-users"></i> Master Canned Message</h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">
<form autocomplete="off" method="POST" action="<?php echo base_url('emat/add_master_canned_message'); ?>" enctype="multipart/form-data">
			
	<div class="row">	
	
	<div class="col-md-12">
	<div class="form-group">
		<label>Message Name</label>
		<input class="form-control" name="message_name" required>
	</div>
	</div>
	
	<div class="col-md-12">
	 <label>Message Body</label>
	<div class="editor-full">
	  <textarea class="form-control" id="moreInfoEditor" name="message_body" required></textarea>
	</div>
	</div>
	
	<div class="col-md-12">
	<br/>
	<div class="form-group">
		<label>Mail Box</label>
		<select class="form-control" name="mail_box[]" multiple required>
			<?php foreach($category_list as $token){ ?>
				<option value="<?php echo $token['id']; ?>"><?php echo $token['email_name']; ?></option>
			<?php } ?>
		</select>
	</div>
	</div>
	
	</div>
	
	
	<hr/>
	
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
<h4 class="widget-title"><i class="fa fa-users"></i> Canned Message List</h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">					
<div class="table-responsive">
	
  <table id="default-datatable-list" class="table table-bordered mb-0 table table-striped skt-table" data-plugin="DataTable">  
    <thead>
      <tr class="bg-primary text-white">
	    <th scope="col">#</th>        
        <th scope="col">Name</th>
		<th scope="col">Message</th>
        <th scope="col">Mail Box</th>
		<th scope="col">Action</th>
      </tr>
    </thead>
	
    <tbody>	
	<?php
	$countc = 0;
	foreach($canned_list as $token){ 
		$countc++;
		$currID = $token['id'];
		$mail_box = explode(',', $token['mail_box']);
		$emailName = array();
		$emailID = array();
		foreach($mail_box as $tokene){
			$emailName[] = $email_list_names[$tokene]['email_name'];
			$emailID[] = $email_list_names[$tokene]['email_id'];
		}
	?>	
      <tr>
        <td scope="row" class="text-center"><?php echo $countc; ?></td>       
        <td scope="row"><b><?php echo $token['canned_name']; ?></b></td>
		 <td scope="row"><b><?php echo $token['canned_message']; ?></b></td>
        <td scope="row"><b><?php echo implode(',',$emailName); ?></b></td>
		<td scope="row" class="text-center">
			<a class="btn btn-primary btn-sm cannedEdit" eid="<?php echo $token['id']; ?>"><i class="fa fa-edit"></i></a>
			<a onclick="return confirm('Do you really want to delete?')" href="<?php echo base_url() ."emat/delete_master_canned_message?did=" .$token['id']; ?>" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></a>
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





<div class="modal fade" id="modalUpdateEmailCanned" tabindex="-1" role="dialog" aria-labelledby="modalUpdateEmailCanned" aria-hidden="true">
  <div class="modal-dialog">  
    <div class="modal-content">
		
	<form class="frmUpdateEmailCanned" id="frmUpdateEmailCanned" action="<?php echo base_url(); ?>emat/add_master_canned_message" method='POST' enctype="multipart/form-data">			
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="updateEmail">Canned message Update</h4>
		</div>
		
		<div class="modal-body agentWidget">				
			<input type="hidden" id='edit_id' name='edit_id' required>		
			<div class="row">	
			<div class="col-md-12">
			<div class="form-group">
				<label>Message Name</label>
				<input class="form-control" name="message_name" required>
			</div>
			</div>
			
			<div class="col-md-12">
			 <label>Message Body</label>
			<div class="editor-full">
			  <textarea class="form-control" id="moreInfoEditorEdit" name="message_body" required></textarea>
			</div>
			</div>
			
			<div class="col-md-12">
			<br/>
			<div class="form-group">
				<label>Mail Box</label>
				<select class="form-control" name="mail_box[]" style="width:100%" multiple required>
					<?php foreach($category_list as $token){ ?>
						<option value="<?php echo $token['id']; ?>"><?php echo $token['email_name']; ?></option>
					<?php } ?>
				</select>
			</div>
			</div>
			
			</div>														
		</div>
			
	
	  <div class="modal-footer">			
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='btnUpdateEmailCanned' class="btn btn-primary">Update</button>			
	  </div>		  
	</form>
		
	</div>
</div>
</div>
