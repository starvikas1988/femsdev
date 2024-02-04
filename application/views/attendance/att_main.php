<!-- report -->

<div class="wrap">

<section class="app-content">
	
<div class="row">
<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title">Attendance (Local Time Wise)</h4>
<center>
<h5 class="widget-title"><?php echo $error ?></h5>
</center>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">

<?php echo form_open('',array('method' => 'post')) ?>

<div class="row">

	<div class="col-md-2">
		<div class="form-group">
		<label for="start_date">Start Date</label>
		<input type="text" class="form-control" id="start_date" value='<?php echo $start_date; ?>' name="start_date" required autocomplete="off">
		</div>
	</div>

	<div class="col-md-2">
		<div class="form-group">
		<label for="end_date">End Date</label>
		<input type="text" class="form-control" id="end_date" value='<?php echo $end_date; ?>' name="end_date" required autocomplete="off">
		</div>
	</div>
		
	<div class="col-md-3">
			
		<div class="form-group" id="foffice_div" >
			<label for="office_id">Select a Location</label>
			<select class="form-control" name="office_id" id="foffice_id" >
				<?php
					//if(get_global_access()==1) echo "<option value='ALL'>ALL</option>";
				?>
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
	
	<div class="col-md-3">
		<div class="form-group">
			<label for="client_id">Select a Department</label>
			<select class="form-control" name="dept_id" id="fdept_id" >
								
				<?php
				if(get_global_access()==1 || get_dept_folder()=="mis" || get_dept_folder()=="hr" || get_dept_folder()=="wfm" || get_dept_folder()=="rta" || is_all_dept_access()) echo "<option value='ALL'>ALL</option>";
				?>
				
				<?php foreach($department_list as $dept): ?>
					<?php
					$sCss="";
					if($dept['id']==$dept_id) $sCss="selected";
					?>
					<option value="<?php echo $dept['id']; ?>" <?php echo $sCss;?>><?php echo $dept['description']; ?></option>
					
				<?php endforeach; ?>
														
			</select>
		</div>
					
	<!-- .form-group -->
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
	
	
	
	
<div class="col-md-3">
	<div class="form-group">
	<label for="filter_key">Select criteria for custom report</label>
	
	<select class="form-control" name="filter_key" id="filter_key" >
	<option value=''>-- select a criteria --</option>
	
	<?php   
				
		$sHide = "style='display:none'";
		$sValue="";
		$aHide = "style='display:none'";
		$aValue="";
		$pHide = "style='display:none'";
		$pValue="";
		$dHide = "style='display:none'";
		$dValue="";
		
		$rHide = "style='display:none'";
		$rValue="";
		
		$afHide = "style='display:none'";
		$afValue="";
		$afReq="";
		
		/*
		if($ses_role_id<=1 || $ses_role_id==6){
			if($filter_key=="Site"){
				echo "<option value='Site' selected>Site</option>";
				$sHide="";
				$sValue=$filter_value;
			}else echo "<option value='Site' >Site</option>";
		}
		*/
		if($filter_key=="Agent"){
			echo "<option value='Agent' selected>Agent</option>";
			$aHide = "";
			$aValue=$filter_value;
		}else echo "<option value='Agent'>Agent</option>";
		
		if($filter_key=="Process"){
			echo "<option value='Process' selected>Process</option>";
			$pHide = "";
			$pValue=$filter_value;
		}else echo "<option value='Process'>Process</option>";
		
		if($filter_key=="Role"){
			echo "<option value='Role' selected>Role</option>";
			$rHide = "";
			$rValue=$filter_value;
		}else echo "<option value='Role'>Role</option>";
		
		/*
		if($filter_key=="Disposition"){
			echo "<option value='Disposition' selected>Disposition</option>";
			$dHide="";
			$dValue=$filter_value;
		}else echo "<option value='Disposition'>Disposition</option>";
		
		if($filter_key=="OfflineList"){
			echo "<option value='OfflineList' selected>Only Offline Users</option>";
		}else echo "<option value='OfflineList'>Only Offline Users</option>";
		*/
		
		if($filter_key=="AOF"){
			echo "<option value='AOF' selected>Agents Of</option>";
			$afHide = "";
			$afReq="required";
			$afValue=$filter_value;
		}else echo "<option value='AOF'>Agents Of</option>";
		
		
	?>
	</select>
	</div>

<!-- .form-group -->
</div>

<div class="col-md-3" id="agent_div" <?php echo $aHide;?>>
	<div class="form-group">
	<label for="filter_key">Enter Agent Fusion-ID/OM-ID</label>
	<input type='text' id='agent_id' name='agent_id'  value='<?php echo $aValue;?>' class="form-control" placeholder="Agent Fusion-ID/OM-ID" />
	</div> 
<!-- .form-group -->
</div>


<div class="col-md-3" id="process_div" <?php echo $pHide;?>>
	<div class="form-group">
	<label for="process_id">Select a process</label>
	<select class="form-control" name="process_id" id="fprocess_id" >
		<option value=''>-- Select a process --</option>
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

<div class="col-md-3" id="disp_div" <?php echo $dHide;?> >
	<div class="form-group">
	<label for="disp_id">Select a Disposition</label>
	<select class="form-control" name="disp_id" id="disp_id">
		<option value=''>-- Select a Disposition --</option>
		<?php foreach($disp_list as $disp): ?>
		<?php //if($disp->id==1) continue; ?>
			<?php
				$sCss="";
				if($disp->id==$dValue) $sCss="selected";
			?>
			
			<option value="<?php echo $disp->id; ?>" <?php echo $sCss;?> ><?php echo $disp->description; ?></option>
		<?php endforeach; ?>
		
		<?php if($filter_value=="2,3,4") echo '<option value="2,3,4" selected>ALL Absent</option>';
			  else echo '<option value="2,3,4">ALL Absent</option>';
		?>
		
	</select>
	</div>
	
</div>


<div class="col-md-3" id="role_div" <?php echo $rHide;?>>
	<div class="form-group">
	<label for="process_id">Select a Role</label>
	<select class="form-control" name="role_id" id="role_id" >
		<option value=''>-- Select a Role --</option>
		<?php foreach($role_list as $role): ?>
			<?php
				$sCss="";
				if($role->id==$rValue) $sCss="selected";
			?>
			<option value="<?php echo $role->id; ?>" <?php echo $sCss;?> ><?php echo $role->name; ?></option>
			
		<?php endforeach; ?>
												
	</select>
	</div>
<!-- .form-group -->
</div>

<div class="col-md-3" id="aof_div" <?php echo $afHide;?>>
	<div class="form-group">
	<label for="process_id">Select a TL/Supervisor/Trainer</label>
	<select class="form-control" name="assign_id" id="assign_id" <?php echo $afReq;?> >
		<option value=''>-- Select a TL --</option>
		<?php foreach($assign_list as $list): ?>
			<?php
				$sCss="";
				if($list->id==$afValue) $sCss="selected";
			?>
			<option value="<?php echo $list->id; ?>" <?php echo $sCss;?> ><?php echo $list->tl_name; ?></option>
			
		<?php endforeach; ?>
												
	</select>
	</div>
<!-- .form-group -->
</div>


<div class="col-md-2">
	<div class="form-group">
	<br>
	<input type="submit" style='margin-top:4px;' class="btn btn-primary btn-md" id='exportReports' name='exportReports' value="Export As Excel">
	</div>
</div>

</div><!-- .row -->

</form>



</div>
</div>
</div>
</div><!-- .row -->
<!-- report -->


<div class="row">
	
</div><!-- .row -->

		
</section>

</div><!-- .wrap -->
