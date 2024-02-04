
<style>
		
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:5px;
	}
	
</style>

<!-- report -->


<div class="wrap">
<section class="app-content">
	
	
<div class="row">
<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title">Fusion Process Updates</h4>
</header>
<hr class="widget-separator"/>

<div class="widget-body clearfix">

<?php echo form_open('',array('method' => 'get')) ?>

	<div class="row">

	<div class="col-md-2">
		<div class="form-group" id="foffice_div" >
			<label for="office_id">Select a Location</label>
			<select class="form-control" name="office_id" id="foffice_id" >
				<?php
					if(get_global_access()==1) echo "<option value='ALL'>ALL</option>";
				?>
				<?php foreach($location_list as $loc): ?>
					<?php
					$sCss="";
					if($loc['abbr']==$office_id) $sCss="selected";
					?>
				<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>><?php echo $loc['office_name']; ?></option>
					
				<?php endforeach; ?>
														
			</select>
		</div>
		
	<!-- .form-group -->
	</div>
	
	<div class="col-md-3">
		<div class="form-group">
			<label for="client_id">Select a Function</label>
			<select class="form-control" name="function_id" id="ffunction_id" >
				<option value='ALL'>ALL</option>
				<?php foreach($function_list as $func): ?>
					<?php
					$sCss="";
					if($func['id']==$func_id) $sCss="selected";
					?>
					<option value="<?php echo $func['id']; ?>" <?php echo $sCss;?>><?php echo $func['description']; ?></option>
					
				<?php endforeach; ?>
														
			</select>
			
		</div>
					
	<!-- .form-group -->
	</div>
	
	
	<div class="col-md-2">
		<div class="form-group">
		<br>
		<input type="submit" style='margin-top:4px;' class="btn btn-primary btn-md" id='showReports' name='showReports' value="Show">
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
		
		<!-- DataTable -->
		<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Users Reports</h4>
					</header><!-- .widget-header -->
					<hr class="widget-separator">
					
					<div class="widget-body">
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
									
										<th>SL</th>
										<th>Location</th>
									    <th>Function</th>
										<th>Title</th>
										<th>Description</th>
										<th>Attachment</th>
										
									</tr>
								</thead>
								
								<tfoot>
									<tr class='bg-info'>
										<th>SL</th>
										<th>Location</th>
									    <th>Function</th>
										<th>Title</th>
										<th>Description</th>
										<th>Attachment</th>
									</tr>
								</tfoot>
	
								<tbody>
																
								<?php
								
									$pDate=0;
									foreach($policy_list as $row):
									
								?>
									<tr>
									
										<td><?php echo $row['office_id']; ?></td>
										<td><?php echo $row['function_id']; ?></td>
										<td><?php echo $row['title']; ?></td>
										<td><?php echo $row['description']; ?></td>
										<td><?php echo $row['attachment']; ?></td>
										
									</tr>
									
								<?php endforeach; ?>
										
								</tbody>
							</table>
						</div>
					</div><!-- .widget-body -->
					
				</div><!-- .widget -->
			</div>
			<!-- END DataTable -->	
						
		</div><!-- .row -->
		
	</section>

</div><!-- .wrap -->





