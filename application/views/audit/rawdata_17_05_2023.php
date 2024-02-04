<style>
	td{
		font-size:12px;
	}
	
	#default-datatable th{
		font-size:12px;
	}
	#default-datatable th{
		font-size:12px;
	}
	
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:2px;
	}
	.lbl_chk_all{
		padding:0px 5px;
		background-color:#ddd;
	}
	
	.lbl_chk{
		padding:0px 5px;
	}
	
	.updateRows{
		background-color:#ADEBAD;
	}
	
</style>

	<div class="wrap">
	
	<section class="app-content">
	
	<div class="row">
		<div class="col-md-12">
		<div class="widget">

		<header class="widget-header">
			<h4 class="widget-title">Audit Raw Data</h4>
		</header>
		
		<hr class="widget-separator"/>
		<div class="widget-body clearfix">
		
		<?php echo form_open('',array('method' => 'get')) ?>
		
		<div class="row">

			<div class="col-md-2">
				<div class="form-group">
				<label for="start_date">Start Date</label>
				<input type="text" class="form-control" id="start_date" value='<?php echo $start_date; ?>' name="start_date" >
				</div>
			</div>

			<div class="col-md-2">
				<div class="form-group">
				<label for="end_date">End Date</label>
				<input type="text" class="form-control" id="end_date" value='<?php echo $end_date; ?>' name="end_date" >
				</div>
			</div>
		</div>
		
		<div class="row">
	
		<div class="col-md-2">
			<div class="form-group">
				<label for="client_id">Select a Client</label>
				<select class="form-control" name="client_id" id="fclient_id" >
					<option value='ALL'>ALL</option>
					<?php foreach($client_list as $client): ?>
						<?php
						$sCss="";
						if($client->id==$cValue) $sCss="selected";
						?>
						<option value="<?php echo $client->id; ?>" <?php echo $sCss;?>><?php echo $client->shname; ?></option>
						
					<?php endforeach; ?>
															
				</select>
			</div>
		<!-- .form-group -->
		</div>
		
	<?php
	if($cValue==1){
		$sHid="";
		$oHid='style="display:none;"';
	}else{
		$oHid="";
		$sHid='style="display:none;"';
	}
	?>
	
		
		<div class="col-md-2">
			<div class="form-group" id="fsite_div" <?php echo $sHid;?> >
				<label for="site_id">Select a Site</label>
				<select class="form-control" name="site_id" id="fsite_id" >
					<option value='ALL'>ALL</option>
					<?php foreach($site_list as $site): ?>
						<?php
						$sCss="";
						if($site->id==$sValue) $sCss="selected";
						?>
						<option value="<?php echo $site->id; ?>" <?php echo $sCss;?>><?php echo $site->name; ?></option>
						
					<?php endforeach; ?>
															
				</select>
			</div>
				
			<div class="form-group" id="foffice_div" <?php echo $oHid;?>>
				<label for="office_id">Select a Location</label>
				<select class="form-control" name="office_id" id="foffice_id" >
					<option value='ALL'>ALL</option>
					<?php foreach($location_list as $loc): ?>
						<?php
						$sCss="";
						if($loc['abbr']==$oValue) $sCss="selected";
						?>
					<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>><?php echo $loc['office_name']; ?></option>
						
					<?php endforeach; ?>
															
				</select>
			</div>
			
		<!-- .form-group -->
		</div>
		
		<div class="col-md-2">
			<div class="form-group">
			<label for="process_id">Select a process</label>
			<select class="form-control" name="process_id" id="fprocess_id" >
				<option value='ALL'>ALL</option>
				<?php foreach($process_list as $process): ?>
					<?php
						$sCss="";
						if($process->id==$pValue) $sCss="selected";
					?>
					<option value="<?php echo $process->id; ?>" <?php echo $sCss;?> ><?php echo $process->name; ?></option>
					
				<?php endforeach; ?>
														
			</select>
			</div>
		<!-- .form-group -->
		</div>
		
				
		<div class="col-md-2" id="" >
			<div class="form-group">
				<label for="role">Select TL/Trainer</label>
				<select class="form-control" name="assigned_to" id="assigned_to">
					<option value='ALL'>ALL</option>
					<?php foreach($tl_list as $tl): 
						$sCss="";
						if($tl->id==$aValue) $sCss="selected";
						
					?>
					<option value="<?php echo $tl->id ?>" <?php echo $sCss;?> ><?php echo $tl->tl_name ?></option>
					<?php endforeach; ?>
															
				</select>
			</div>
		<!-- .form-group -->
		</div>
		
			<div class="col-md-2">
			<div class="form-group">
			<br>
			<input type="submit" class="btn btn-primary btn-md" style='margin-top:4px;' id='showReports' name='showReports' value="Export As CSV">
			</div>
		</div>
				
		</div><!-- .row -->
		</form>
		
		</div>
		</div>
		</div>
	</div><!-- .row -->
			
	
	<?php 
		if(empty($audit_list)){
	?>
					
	<div class="row">
		<!-- DataTable -->
		<div class="col-md-12">
				<div class="widget">
					<div class="row" style="padding-top:10px;">
					
					<header class="widget-header">
						<h4 class="widget-title"> Audit Raw Data </h4>
					</header><!-- .widget-header -->
					
					<hr class="widget-separator">
					<div class="widget-body">
						<div class="table-responsive">
						
							Please select the date range
													
					</div>
				</div><!-- .widget-body -->
			
			</div> <!-- .row -->
			
			<!-- END DataTable -->	
			
			</div>
		</div>
	</div><!-- .row -->
	
	<?php 
		}
	?>
				
		
</section> <!-- #dash-content -->	
	
</div><!-- .wrap -->