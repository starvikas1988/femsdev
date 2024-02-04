<style>
.btn-sm{
	padding: 2px 5px;
}
.scrollheightdiv{
	max-height:600px;
	overflow-y:scroll;
}
.qCircle{
	/* padding: 5px 10px; */
    border-radius: 50%;
    background-color: #000;
    color: #fff;
    margin-right: 6px;
    width: 25px;
    height: 25px;
    display: inline-block;
    text-align: center;
    line-height: 25px;
}
.panelQ{
	font-size:14px;
	font-weight:600;
	margin-top: 3px;
}
/*start new custom 25.05.2022*/
.common-top {
	width: 100%;
	margin-top: 10px;
}
.file-upload {
	width: 100%;

}
.file-upload .form-control:focus {
	outline: none;
	box-shadow: none;
}
/*end new custom 25.05.2022*/
.btn-new{
width: 150px;
padding: 10px;
border-radius: 3px;
margin-top: 21px;
}
.form-control{
border-radius: 3px;
}
.input-file{
border: 1px solid #ddd!important;
padding: 10px 5px 10px 5px;
margin-top: 2px;
}
</style>

<div class="wrap">
<section class="app-content">

<div class="row">
<div class="col-md-12">
<?php if(!empty($this->input->get('elog')) && $this->input->get('elog') == "error"){ ?>
<div class="alert alert-danger" role="alert">
  <i class="fa fa-warning"></i> Record Already Exist!
</div>
<?php } ?>
</div>
</div>

<div class="row">
<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title"><i class="fa fa-pie-chart"></i> Upload Data <?php echo !empty($client_id) ? " | <span class='text-primary'> <i class='fa fa-users'></i> " .$duns_clients_indexed[$client_id]['name'] : "</span>"; ?></h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">
<form autocomplete="off" method="POST" enctype="multipart/form-data">		
	<div class="row">
	<div class="col-md-4">
	<div class="form-group">
		<label>Client</label>
		 <select class="form-control" name="client_id" required>
			<?php echo duns_dropdown_3d_options($duns_clients_list, 'id', 'name', $client_id); ?>
		 </select>
	</div>
	</div>	
	<div class="col-md-4">
	<div class="form-group file-upload">
		<label></label>
		 <input type="file" class="form-control input-file" name="upload_file" accept=".xlsx,.xls,.csv" required>
	</div>
	</div>
	
	<div class="col-md-4">
	<div class="form-group">
		<button type="submit" class="btn btn-success btn-new">Upload & Verify</button>
	</div>
	</div>
	</div>
</form>
</div>
</div>
</div>
</div>

<div class="common-top">
<?php if($show_addition == true){ ?>
<div class="row">
<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title"><i class="fa fa-gear"></i> Verify Header Mapping</h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">	

	<form autocomplete="off" action="<?php echo duns_url('upload_file_data'); ?>" method="POST" enctype="multipart/form-data">
	
	<input class="form-control" type="hidden" name="client_id" value="<?php echo $client_id; ?>" required>
	<input class="form-control" type="hidden" name="upload_id" value="<?php echo $upload_id; ?>" required>
	
	<div class="row">
	
	<div class="col-md-1">
	<div class="form-group">
	<div class="panelQ">
	
	</div>
	</div>
	</div>
	
	<div class="col-md-4">
	<div class="form-group">
		<label>Header Name</label>
	</div>
	</div>
	<div class="col-md-4">
	<div class="form-group">
		<label>Select Existing Column</label>
	</div>
	</div>
	<div class="col-md-3">
	<div class="form-group">
		<label>New Column Name</label>
	</div>
	</div>
	
	</div>
	
	<?php
	$cn=0;
	foreach($result_columns as $token){ 
	   $cn++;
	?>
	
	
	<div class="row div_agentColumnAddition">
	
	<div class="col-md-1">
	<div class="form-group">
	<div class="panelQ">
	<span class="qCircle"><?php echo $token['cell']; ?></span>
	<input type="checkbox" name="checkbox_<?php echo $token['name']; ?>" value="1">
	</div>
	</div>
	</div>
	
	<div class="col-md-4">
	<div class="form-group">
		 <input class="form-control" type="hidden" name="header_cell[]" value="<?php echo $token['cell']; ?>" readonly required>
		 <input class="form-control" name="header_name[]" value="<?php echo $token['name']; ?>" readonly required>
	</div>
	</div>
	<div class="col-md-4">
	<div class="form-group">
		 <select class="form-control" name="header_map[]" required>
			<?php 
			$dropdown_options = $duns_upload_header;			
			echo duns_dropdown_3d_options_du($dropdown_options, 'column_header', 'column_header', $token['column']);
			$is_new = false;
			if(!in_array('du_'.$token['column'], array_column($dropdown_options, 'column_header'))){ 
				$is_new = true;
				echo "<option value='_add_column' selected>Add New Column</option>";
			}
			?>
		 </select>
	</div>
	</div>
	<div class="col-md-3 div_newColumnEntry" <?php if($is_new == false){ echo 'style="display:none;"'; } ?>>
	<div class="form-group">
		<input class="form-control" name="header_new[]" value="<?php echo $token['column']; ?>" readonly <?php if($is_new == true){ echo 'required'; } ?>>
	</div>
	</div>
	
	</div>

	
	
	<?php } ?>
	
	<div class="row">
	<div class="col-md-12">
	<div class="form-group">
		<button style="margin-top:20px" type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Map & Upload Data</button>
	</div>
	</div>
	</div>
	
	</form>

</div>
</div>
</div>
</div>
</div>

<?php } ?>

<br/><br/>

</section>
</div>