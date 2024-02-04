<style>
.btn-sm{
	padding: 2px 5px;
}

.scrollheightdiv{
	max-height:600px;
	overflow-y:scroll;
}
.circleTab li a{
	background-color: #fff!important;
}
</style>




<div class="wrap">
<section class="app-content">

<div class="row">
<div class="col-md-12">
<?php if(!empty($this->input->get('elog')) && $this->input->get('elog') == "error"){ ?>
<div class="alert alert-danger" role="alert">
  <i class="fa fa-warning"></i> Category Code Already Exist!
</div>
<?php } ?>
</div>
</div>

<div class="row">


<div class="col-md-6">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title">Ticket Category</h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">
<form autocomplete="off" method="POST" action="<?php echo base_url('emat/add_ticket_category'); ?>" enctype="multipart/form-data">				
	<div class="row">
	<div class="col-md-12">
	<div class="form-group">
		<label>Mail Box</label>
		<select class="form-control" name="email_id" required>
				<option value="">-- Select --</option>
			<?php foreach($mail_list as $token){ ?>
				<option value="<?php echo $token['id']; ?>"><?php echo $token['email_name']; ?> (<?php echo $token['email_id']; ?>)</option>
			<?php } ?>
		</select>
	</div>
	</div>
	<div class="col-md-12">
	<div class="form-group">
		<label>Category Code</label>
		<input class="form-control text-uppercase" name="category_code" onkeypress="return event.charCode != 32" required>
	</div>
	</div>
	<div class="col-md-12">
	<div class="form-group">
		<label>Category Name</label>
		<input class="form-control" name="category_name" required>
	</div>
	</div>
	<div class="col-md-12">
	<div class="form-group">
		<label>SLA (in Hours)</label>
		<input class="form-control" name="category_sla" required>
	</div>
	</div>
	</div>	
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


<div class="col-md-6">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title">Add Category from Mail Box</h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix categoryFolderRow">
<form autocomplete="off" method="POST" action="<?php echo base_url('emat/bulk_ticket_category'); ?>" enctype="multipart/form-data">				
	<div class="row">
	<div class="col-md-12">
	<div class="form-group">
		<label>Mail Box</label>
		<select class="form-control showCategoryMailBox" name="email_id" required>
				<option value="">-- Select --</option>
			<?php foreach($mail_list as $token){ ?>
				<option value="<?php echo $token['id']; ?>"><?php echo $token['email_name']; ?> (<?php echo $token['email_id']; ?>)</option>
			<?php } ?>
		</select>
	</div>
	</div>
	
	<div class="col-md-12 table-responsive" style="max-height:300px;">
			
		  <table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
			<thead>
				<tr class='bg-primary'>
					<th><input type="checkbox" name="folderAllCheckBox" class="folderAllCheckBox" value="1"></th>
					<th>Folder</th>
					<th>Name</th>
					<th>Category Code</th>
				</tr>
			</thead>
			<tbody id="allCategoryTableList">								
			</tbody>
		</table>				
			
	</div>
	</div>	
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

<!--
<div class="col-md-12">
<br/><br/>
<div class="widget">
<div class="widget-body clearfix">
<ul class="nav nav-tabs" id="mailBoxTab" role="tablist">
<?php 
$sl = 0;
foreach($mail_list as $token){ 
	$activeShow = "";
	if(++$sl == 1){ $activeShow = "active"; }
?>
  <li class="nav-item">
    <a class="nav-link <?php echo $activeShow; ?>" id="mail<?php echo $token['id']; ?>-tab" data-toggle="tab" href="#mail<?php echo $token['id']; ?>" role="tab" aria-controls="mail<?php echo $token['id']; ?>" aria-selected="true"><b><?php echo $token['email_name']; ?></b></a>
  </li>
<?php } ?>
</ul>
</div>
</div>
</div>
-->

<div class="col-md-12">
<br/><br/>
<ul class="nav nav-tabs circleTab" id="mailBoxTab" role="tablist">
<?php 
$sl = 0;
foreach($mail_list as $token){ 
	$activeShow = "";
	if(++$sl == 1){ $activeShow = "active"; }
?>
  <li class="nav-item">
    <a class="nav-link <?php echo $activeShow; ?>" id="mail<?php echo $token['id']; ?>-tab" data-toggle="tab" href="#mail<?php echo $token['id']; ?>" role="tab" aria-controls="mail<?php echo $token['id']; ?>" aria-selected="true"><b><?php echo $token['email_name']; ?></b></a>
  </li>
<?php } ?>
</ul>
</div>

<div class="col-md-12">

<!-- Tabs content -->

<div class="widget">
<div class="widget-body clearfix">	

<div class="tab-content" id="mailBoxTabContent">	
<?php 
$sl = 0;
foreach($mail_list as $tokenE){ 
	$activeShow = "";
	if(++$sl == 1){ $activeShow = "active"; }
?>
   <div class="tab-pane <?php echo $activeShow; ?>" id="mail<?php echo $tokenE['id']; ?>" role="tabpanel" aria-labelledby="mail<?php echo $tokenE['id']; ?>-tab">
    
	<header class="widget-header">
	<h4 class="widget-title"><i class="fa fa-envelope"></i> <?php echo $tokenE['email_name']; ?> (<?php echo $tokenE['email_id']; ?>)</h4>
	</header>
	<hr class="widget-separator"/>
	
	<div class="table-responsive">
		
	  <table id="default-datatable" class="table table-bordered mb-0 table table-striped skt-table" data-plugin="DataTable">  
		<thead>
		  <tr class="bg-primary text-white">
			<th scope="col">#</th>
			<th scope="col">Email ID</th>
			<th scope="col">Category</th>
			<th scope="col">Category Name</th>
			<th scope="col">SLA</th>
			<th scope="col">Action</th>
		  </tr>
		</thead>
		
		<tbody>	
		<?php
		$countc = 0;
		foreach($mail_category[$tokenE['id']] as $token){ 
			$countc++;
		?>	
		  <tr>
			<td scope="row" class="text-center"><?php echo $countc; ?></td>
			<td scope="row">
			<b><?php echo $token['email_id']; ?></b>		
			</td>
			<td scope="row"><b><?php echo $token['category_code']; ?></b></td>
			<td scope="row">
			<b><?php echo $token['category_name']; ?></b>		
			</td>
			<td scope="row">
			<b><?php echo $token['category_sla']; ?>h</b>		
			</td>
			<td scope="row" class="text-center">
			<a class="btn btn-primary btn-sm courseCatEditInfo" title="Update Details" eid="<?php echo $token['id']; ?>"><i class="fa fa-gear"></i></a>
			<a class="btn btn-primary btn-sm courseCatEdit" title="Edit Category"  eid="<?php echo $token['id']; ?>"><i class="fa fa-edit"></i></a>
			<a onclick="return confirm('Do you really want to delete?')" href="<?php echo base_url() ."ld_programs/delete_course_category?did=" .$token['id']; ?>" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></a>
			</td>
		  </tr>
		<?php } ?>	
		</tbody>
	  </table>
			
			
	</div>	
	
  </div>
<?php } ?> 


</div>
</div>
  
</div>
<!-- Tabs content -->



</div>

</div>

<br/><br/><br/><br/><br/><br/><br/>

</section>
</div>





<div class="modal fade" id="modalUpdateEmatCategory" tabindex="-1" role="dialog" aria-labelledby="modalUpdateEmatCategory" aria-hidden="true">
  <div class="modal-dialog">  
    <div class="modal-content">
		
	<form class="frmUpdateEmatCategory" id="frmUpdateEmatCategory" action="<?php echo base_url(); ?>emat/add_ticket_category" method='POST' enctype="multipart/form-data">			
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title">Category Update</h4>
		</div>
		
		<div class="modal-body">				
			<input type="hidden" id='edit_id' name='edit_id' required>		
			<div class="row">
			<div class="col-md-12">
			<div class="form-group">
				<label>Mail Box</label>
				<select class="form-control" name="email_id" style="pointer-events: none;" readonly required>
						<option value="">-- Select --</option>
					<?php foreach($mail_list as $token){ ?>
						<option value="<?php echo $token['id']; ?>"><?php echo $token['email_name']; ?> (<?php echo $token['email_id']; ?>)</option>
					<?php } ?>
				</select>
			</div>
			</div>
			<div class="col-md-12">
			<div class="form-group">
				<label>Category Code</label>
				<input class="form-control" name="category_code" readonly required>
			</div>
			</div>
			<div class="col-md-12">
			<div class="form-group">
				<label>Category Name</label>
				<input class="form-control" name="category_name" required>
			</div>
			</div>
			<div class="col-md-12">
			<div class="form-group">
				<label>SLA (in Hours)</label>
				<input class="form-control" name="category_sla" required>
			</div>
			</div>
			</div>														
		</div>
	  <div class="modal-footer">			
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='btnUpdateEmatDCategory' class="btn btn-primary">Update</button>			
	  </div>		  
	</form>
		
	</div>
</div>
</div>


<div class="modal fade" id="modalUpdateEmatCategoryInfo" tabindex="-1" role="dialog" aria-labelledby="modalUpdateEmatCategoryInfo" aria-hidden="true">
  <div class="modal-dialog" style="width:60%">  
    <div class="modal-content">
		
	<form class="frmUpdateEmatCategoryInfo" id="frmUpdateEmatCategoryInfo" action="<?php echo base_url(); ?>emat/update_ticket_category" method='POST' enctype="multipart/form-data">			
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title">Category Info Update</h4>
		</div>
		
		<div class="modal-body">				
			<input type="hidden" id='edit_id' name='edit_id' required>		
			<div class="row">
			<div class="col-md-12">
			<div class="form-group">
				<label>Mail Box</label>
				<select class="form-control" name="email_id" style="pointer-events: none;" readonly required>
						<option value="">-- Select --</option>
					<?php foreach($mail_list as $token){ ?>
						<option value="<?php echo $token['id']; ?>"><?php echo $token['email_name']; ?> (<?php echo $token['email_id']; ?>)</option>
					<?php } ?>
				</select>
			</div>
			</div>
			<div class="col-md-12">
			<div class="form-group">
				<label>Category Info</label>
				<textarea class="form-control" id="moreInfoEditor" name="category_info" required></textarea>
			</div>
			</div>
			<div class="col-md-12">
			<div class="form-group">
				<label>File Attachments</label>
				<input type="file" class="form-control" accept=".pdf,.jpg,.png,.docx,.xlsx,.doc,.xls,.jpeg,.gif" name="category_attachments[]" multiple>
			</div>
			</div>
			</div>														
		</div>
	  <div class="modal-footer">			
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="submit" id='btnUpdateEmatDCategoryInfo' class="btn btn-primary">Update</button>			
	  </div>		  
	</form>
		
	</div>
  </div>
</div>



