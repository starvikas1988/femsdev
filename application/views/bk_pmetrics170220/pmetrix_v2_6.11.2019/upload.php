<!-- Performance Metrix  -->

<div class="wrap">
<section class="app-content">
	
<div class="row">
<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title">Upload Performance Metrix</h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">

<div class="row">
	
	<?php echo form_open('',array('method' => 'get')) ?>
	
		
		<div class="col-md-2" >
			
			<div class="form-group" id="foffice_div">
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
		</div>
				
		<div class="col-md-3">
			<div class="form-group">
				<label for="client_id">Select a Client</label>
				<select class="form-control" name="client_id" id="fclient_id" required>
				
					<?php //foreach($client_list as $client): ?>
						<?php
						//$sCss="";
						//if($client['id']==$cValue) $sCss="selected";
						?>
						<!--<option value="<?php echo $client['id']; ?>" <?php echo $sCss;?>><?php echo $client['shname']; ?></option>-->
						
					<?php //endforeach; ?>
															
				</select>
			</div>
		</div>
	
		<div class="col-md-2" id="process_div" >
			<div class="form-group">
			<label for="process_id">Select a process</label>
			<select class="form-control" name="process_id" id="fprocess_id" >
				<option value='0'>ALL Process</option>
				<?php foreach($process_list as $process): ?>
					<?php
						if($process->id ==0 ) continue;
						$sCss="";
						if($process->id==$pValue) $sCss="selected";
					?>
					<option value="<?php echo $process->id; ?>" <?php echo $sCss;?> ><?php echo $process->name; ?></option>
					
				<?php endforeach; ?>
				
			</select>
			</div>
		</div>
		
		<div class="col-md-2">
		<div class="form-group">
			<input type="submit" class="btn btn-primary btn-md" style="margin-top:24px;" id='goNext' name='goNext' value="Next">
			</div>
		</div>
		</form>
		
</div><!-- .row -->


<div class="row" id='updiv_details'>

<?php 
	if(count($pm_design) > 0 ){
		$pm_design_row = $pm_design[0];
		//echo count($pm_design) . ">>" . $pm_design_row['mp_id'];
		
		$mptype=$pm_design_row['mp_type'];
		$mpid=$pm_design_row['mp_id'];
		
?>


<div class="row" >

	<div class="col-md-4" >
		<div class="form-group">
		
			<label for="process_id">Download Sample Metrix Excel</label>
				
				<div class="form-group" style='float:right; padding-right:10px;'>
					<a href='downloadMetrixHeader?pmdid=<?php echo $mpid;?>'>
						<span style="padding:12px;" class="label label-success"> Download header</span>
					</a>
				</div>
								
		</div>
	</div>
</div>	

</br>

<div class="row">

	<div class="form-group" >
	<h4 class="widget-title">Please Select the Performance Metrix Start Date and End Date</h4>
	</div>
	
	
	<input type="hidden" class="form-control" id="mptype" value='<?php echo $mptype;?>' name="mptype" required>
	<input type="hidden" class="form-control" id="mpid" value='<?php echo $mpid;?>' name="mpid" required>
	<?php
	if($mptype != 1)
	{
	?>
	<div class="col-md-3" style="width:215px;">
		<div class="form-group">
			<label for="ssdate">Start Date (mm/dd/yyyy)</label>
			<input type="text" class="form-control" id="ssdate" typ='<?php echo $mptype;?>' value='' name="ssdate" required>
		</div>
	</div>
	<div class="col-md-3" style="width:215px;">	
		<div class="form-group" >
			<label for="sedate">End Date(mm/dd/yyyy)</label>
			<input type="text" class="form-control" id="sedate" value='' name="sedate" >
		</div>
	</div>
	<?php
	}
	?>
	
</div>

<div class="row">

	<div class="form-group">
			Upload Your Performance Metrix Excel File
			<div id="mulitplefileuploader">Upload</div>

			<div id="status"></div>
			
			<div id="OutputDiv"></div>

	</div>

</div>


<?php 
	}else{
	
?>

</div><!-- .row -->


<div class="row">

	<div class="col-md-4" >
		<div class="form-group">
			<label> Metrix Design Not Found. <br>Please select proper filter OR Create the Design.</label>
				
		</div>
	</div>
</div>	

<?php 
	}
?>


</div>
</div>
</div>
</div><!-- .row -->

</section>

</div><!-- .wrap -->


