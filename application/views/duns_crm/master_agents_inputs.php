<style>
.btn-sm{
	padding: 2px 5px;
}
.scrollheightdiv{
	max-height:600px;
	overflow-y:scroll;
}
.qCircle{
	padding:5px 10px;
	border-radius:50%;
	background-color:#000;
	color:#fff;
	margin-right:6px;
}
.panelQ{
	font-size:14px;
	font-weight:600;
	margin-top: 20px;
}
.btn-new{
	width: 150px;
	padding: 10px;
	margin-top: 21px;
	border-radius: 3px!important;
}

textarea.form-control {
  height: 40px !important;
  min-height: 40px !important;
  width: 100% !important;
  max-width: 303px;
  max-height: 40px;
}
.form-control{
border-radius: 3px!important;
}
.fa{
padding-right: 2px;
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
<h4 class="widget-title"><i class="fa fa-pie-chart"></i> Master Agent Inputs <?php echo !empty($client_id) ? " | <span class='text-primary'> <i class='fa fa-users'></i> " .$duns_clients_indexed[$client_id]['name'] : "</span>"; ?></h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">
<form autocomplete="off" method="GET" enctype="multipart/form-data">		
	<div class="row">
	<div class="col-md-6">
	<div class="form-group">
		<label>Client</label>
		 <select class="form-control" name="client_id" required>
			<?php echo duns_dropdown_3d_options($duns_clients_list, 'id', 'name', $client_id); ?>
		 </select>
	</div>
	</div>
	<div class="col-md-6">
	<div class="form-group">
		<button type="submit" class="btn btn-success btn-new">Open</button>
	</div>
	</div>
	</div>
</form>
</div>
</div>
</div>
</div>


<?php if($show_addition == true){ ?>
<div class="row">
<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title"><i class="fa fa-user-plus"></i> Add New Field</h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">
<form autocomplete="off" action="<?php echo duns_url('add_agent_columns'); ?>" method="POST" enctype="multipart/form-data">
	
	<input class="form-control" type="hidden" name="client_id" value="<?php echo $client_id; ?>" required>
	<input class="form-control" type="hidden" name="last_position" value="<?php echo $duns_last_position; ?>" required>
	
	<div class="row div_agentInputAddition">
	<div class="col-md-3">
	<div class="form-group">
		<label>Enter Field Name</label>
		 <input class="form-control" name="field_name" required>
	</div>
	</div>
	<div class="col-md-3">
	<div class="form-group">
		<label>Field Type</label>
		 <select class="form-control" name="field_type" required>
			<?php 
			$dropdown_options = duns_dropdown_field_type();
			echo duns_dropdown_options($dropdown_options); 
			?>
		 </select>
	</div>
	</div>
	<div class="col-md-3 div_drodpdownOption" style="display:none">
	<div class="form-group">
		<label>Dropdown Options (Comma Separated)</label>
		 <textarea class="form-control" name="field_options"></textarea>
	</div>
	</div>
	<div class="col-md-3">
	<div class="form-group">
		<button  type="submit" class="btn btn-danger btn-new"><i class="fa fa-plus"></i> Add</button>
	</div>
	</div>	
	</div>
	
</form>
</div>
</div>
</div>
</div>

<div class="row">
<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title"><i class="fa fa-gear"></i> Modify Fields</h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">	
	
	<?php
	$cn=0;
	foreach($duns_agent_inputs as $token){ 
	   $cn++;
	?>
	
	<form autocomplete="off" action="<?php echo duns_url('update_agent_columns'); ?>" method="POST" enctype="multipart/form-data">
	
	<input class="form-control" type="hidden" name="client_id" value="<?php echo $token['client_id']; ?>" required>
	<input class="form-control" type="hidden" name="field_position" value="<?php echo $token['position']; ?>" required>
	<input class="form-control" type="hidden" name="field_id" value="<?php echo $token['id']; ?>" required>
	<input class="form-control" type="hidden" name="field_column" value="<?php echo $token['column_name']; ?>" required>
	
	<div class="row div_agentInputAddition">
	
	<div class="col-md-1">
	<div class="form-group">
	<div class="panelQ">
	<span class="qCircle"><?php echo $cn; ?></span>
	</div>
	</div>
	</div>
	
	<div class="col-md-3">
	<div class="form-group">
		<label>Field Name</label>
		 <input class="form-control" name="field_name" value="<?php echo $token['reference_name']; ?>" required>
	</div>
	</div>
	<div class="col-md-3">
	<div class="form-group">
		<label>Field Type</label>
		 <select class="form-control" name="field_type" required>
			<?php 
			$dropdown_options = duns_dropdown_field_type();
			echo duns_dropdown_options($dropdown_options, $token['column_type']); 
			?>
		 </select>
	</div>
	</div>
	<div class="col-md-3">
	<div class="form-group div_drodpdownOption text-area" <?php echo $token['column_type'] == "select" ? "" : 'style="display:none"'; ?>>
		<label>Dropdown Options (Comma Separated)</label>
		 <textarea class="form-control" name="field_options"><?php echo $token['column_options']; ?></textarea>
	</div>
	</div>
	<div class="col-md-2">
	<div class="form-group">
		<button style="" type="submit" class="btn btn-primary btn-new"><i class="fa fa-upload"></i> Update</button>
	</div>
	</div>
	
	</div>

	</form>
	
	<?php } ?>

</div>
</div>
</div>
</div>

<?php } ?>

<br/><br/><br/><br/><br/><br/><br/>

</section>
</div>