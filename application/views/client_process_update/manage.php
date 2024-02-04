
<style>
		
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:5px;
	}
	

.prevAttachDiv{
	background-color:#f5f5f5;
	float:left;
	position:relative;
	height:auto; min-height:70px;
	width:100%;
	border:1px solid #ccc; 
	padding:3px;
	z-index:0;
}

.currAttachDiv{
	background-color:#f5f5f5;
	float:left;
	position:relative;
	height:auto; min-height:70px;
	width:100%;
	border:1px solid #ccc; 
	padding:3px;
	z-index:0;
	display:none;
}

.attachDiv{
	width: 50px;
	height: 50px;
	float:left;
	padding:1px;
	border:2px solid #ccc; 
	margin:5px;
	position:relative;
	cursor:pointer;
}

.attachDiv img{
	width: 100%;
	height: 100%;
	position:relative;
}

.deleteAttach{
	display:none;
	cursor:pointer;
	top:0;
	right:0;
	position:absolute;
	z-index:99;
}

input[type="checkbox"]{
  width: 20px;
  height: 20px;
}

textarea.form-control {
   min-height: 100px;
}

</style>


<!-- report -->


<div class="wrap">
<section class="app-content">
	
<?php if(get_role_dir()!="agent"){ ?>	
	
<div class="row">
<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title">Search Process Updates</h4>
</header>
<hr class="widget-separator"/>

<div class="widget-body clearfix">

<?php echo form_open('',array('method' => 'get')) ?>

	<div class="row">

<!-- 		<div class="col-md-2">
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
		</div> -->
		
		
	<!-- 	<div class="col-md-3">
			<div class="form-group">
				<label>Select Client(s)</label>
				<select class="form-control" name="client_id" id="fclient_id">
					<option value=''>-Select Client-</option>
					<?php
						if(get_global_access()==1 || get_role_dir()=="admin") echo "<option value='ALL'>ALL</option>";
					?>
					<?php foreach($client_list as $client): ?>
						<?php
						$sCss1="";
						if($client->id==$cValue) $sCss1="selected";
						?>
						<option value="<?php echo $client->id; ?>" <?php echo $sCss1;?>><?php echo $client->shname; ?></option>
						
					<?php endforeach; ?>
															
				</select>
			</div>
		</div> -->
		
		<div class="col-md-3">
			<div class="form-group">
				<label>Select Process</label>
				<select class="form-control" name="process_id" id="fprocess_id" >
					<option value=''>-Select Process-</option>
					
					
					<?php foreach($process_list as $process): ?>
						<?php
						$sCss="";
						if($process['id']==$pValue) $sCss="selected";
						?>
						<option value="<?php echo $process['id']; ?>" <?php echo $sCss;?> ><?php echo $process['name']; ?></option>
						
					<?php endforeach; ?>
															
				</select>
			</div>
		</div>
	</div>	
	<div class="row">
		<div class="col-md-8">
			<div class="form-group">
				<label>Type your Search Text</label>
				<input type="text" class="form-control" id="search_text" name="search_text" value="<?php echo $search_text; ?>" >
			</div>
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

<?php } ?>
	
		<div class="row">
		
		<!-- DataTable -->
		<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Fusion Process Updates</h4>
					</header><!-- .widget-header -->
					<hr class="widget-separator">
						
						<?php if( isProcessUpdates()== true){ ?>
						
						<!-- <div style='float:right; margin-top:-35px; margin-right:10px;' class="col-md-4">
							<div class="form-group" style='float:right;'>
							<span style="cursor:pointer;padding:10px;" id='btn_add_processUpdates' class="label label-primary">Add Process Updates</span>
							</div>
						</div> -->
						
						<?php } ?>
						
						
						
					<div class="widget-body">
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
									
										<th>SL</th>
										<th>Date</th>
										<th>Location</th>
										
									    <th>Client</th>
									    <th>Process</th>
			
										<th>Title</th>
										<th>Description</th>
										<th>Attachment</th>
										<th> Action</th>
								
									</tr>
								</thead>
								
								<tfoot>
									<tr class='bg-info'>
										<th>SL</th>
										<th>Date</th>
										<th>Location</th>
										
									    <th>Client</th>
									    <th>Process</th>
										
										<th>Title</th>
										<th>Description</th>
										<th>Attachment</th>
										<th> Action</th>
										
										
									</tr>
								</tfoot>
	
								<tbody>
																
								<?php
								
									$pDate=0;
									$slno=1;
									
									foreach($process_updates as $row):
									
																		
									$params = $row['title']."#". str_replace('"','',stripslashes($row['description'])) ."#".$row['office_id']."#".$row['client_id']."#".$row['process_id']."#".$row['is_active'];
									
								?>
									<tr>
										<td><?php echo $slno++; ?></td>
										<td><?php echo $row['addedDate']; ?></td>
										<td><?php echo $row['office_id']; ?></td>
										<td><?php echo $row['clientID']; ?></td>
										<td><?php echo $row['processID']; ?></td>
										<td><?php echo $row['title']; ?></td>
										<td> <div style="max-height:150px; overflow:auto"><?php echo stripslashes($row['description']); ?></div></td>
										
										<td width="150px">
										<?php 
											$pu_ID=$row['id'];
											$attach_list=$all_pu_attach[$pu_ID];
											if(!empty($attach_list)){
											?>
											<div class='pageAttachDiv' id='attDiv<?php $row['id']; ?>'>
											<?php 	
											foreach($attach_list as $attRow){
											
											$iconUrl=base_url().getIconUrl($pu_ID."-".$attRow['id'].".".$attRow['ext'],"process_updates");
											$attachUrl=base_url()."uploads/process_updates/".$pu_ID."-".$attRow['id'].".".$attRow['ext'];
											$attID=$attRow['id'];
											
											
											//$params = $row['title']."#".$row['description']."#".$row['office_id']."#".$row['clientID']."#".$row['processID']."#".$row['is_active'];
										
											?>
											
											<div class='attachDiv' title='Click here to open' id="div_<?php echo $attID ?>">
											
											<a target='_blank' class='atLink' href="<?php echo $attachUrl; ?>">
												<img src="<?php echo $iconUrl; ?>" id="<?php echo $attID ?>"/>
											</a>
											
											
												<?php if( isProcessUpdates()== true){ ?>
													<button title='Delete File' atid="<?php echo $attID ?>" type='button' class='deleteAttach btn btn-danger btn-xs'><i class='fa fa-times-circle' aria-hidden='true'></i></button>
												<?php } ?>
												
												</div>
											<?php } ?>
												
											</div>
											<?php } ?>
										
										</td>
										
										<td width="280px">
										<?php
											if( isProcessUpdates()== true){
										 ?>
											
											
											<button title="Attach Files" pid='<?php echo $row['id'] ?>' type='button' class='attachFile btn btn-primary btn-xs'><i class='fa fa-upload' aria-hidden='true'></i></button> &nbsp;
											
											
										<?php if($row['is_active']==1):?>
																							
											<button title="Record is Active - Click to In-Activate" titleJS="In-Activate"" pstat='0' adpid='<?php echo $row['id'] ?>' type='button' class='pActDeact btn btn-success btn-xs'><i class='fa fa-check-circle-o fa-fw'  aria-hidden='true'></i></button> &nbsp;
											
											
											
											
										<?php else: ?>
											<button title="Record is In-Active - Click to Active" pstat='1' titleJS="Active"  adpid='<?php echo $row['id'] ?>' type='button' class='pActDeact btn btn-danger btn-xs'><i class='fa fa-check-circle-o fa-fw'  aria-hidden='true'></i></button> &nbsp;
											
										<?php endif; ?>
										
											<button title="Edit Process Updates" epid='<?php echo $row['id'] ?>'  params=" <?php echo $params; ?> " type='button' class='editProcessUpdates btn btn-info btn-xs'><i class='fa fa-pencil-square' aria-hidden='true'></i></button>
										
										
										
										<?php } ?>
										
										
										</td>
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
		
		
<!---------- Start Add ---------->
<div class="modal fade" id="modalAddProcessUpdates" tabindex="-1" role="dialog" aria-labelledby="addProcessPolicy" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
		
		<form class="frmAddProcessUpdates" method='POST' action="<?php echo base_url() ?>process_update/addProcessUpdate" data-toggle="validator">
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="addProcessLabel">Add Process Updates</h4>
			</div>
			
			<div class="modal-body">
			
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="office_id">Select The Location</label>
							<select class="form-control" name="office_id" id="aoffice_id" required >
								<option value=''>--Select--</option>
								<!--<option value='ALL'>ALL</option>-->
								<?php foreach($location_list as $loc): ?>
									<option value="<?php echo $loc['abbr']; ?>"><?php echo $loc['office_name']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="name">Title:</label>
							<input type="text" class="form-control" placeholder="Enter Process Updates Title" id="atitle" name="title" required>
						</div>
					</div>
				</div>	
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Select Client(s)</label>
							<select class="form-control" name="client_id" id="client_id" required>
								<option value=''>--Select--</option>
								<?php foreach($client_list as $client): ?>
									<option value="<?php echo $client->id ?>"><?php echo $client->shname ?></option>
								<?php endforeach; ?>							
							</select>
						</div>
					</div>	
					<div class="col-md-6">
						<div class="form-group">
							<label>Select Process</label>
							<select class="form-control" name="process_id" id="process_id" required>
								<option value="">--Select--</option>
								<option value='0'>ALL</option>
								<?php foreach($process_list as $process): ?>
									<option value="<?php echo $process->id ?>"><?php echo $process->name ?></option>
								<?php endforeach; ?>							
							</select>
						</div>
					</div>
				</div>
				
				<div class="row" id="specificUser">
					<div class="col-md-4">
						<input type="checkbox" id="specific_user" name="specific_user" value="1">
						Access By Specific User
					</div>
				</div>
				
				<div class="row" id="accessControl" style="display:none">
					<div class="col-md-12">
						<div class="form-group">
							<label>Access Control</label>
							<select class="form-control" id="access_control" name="access_control[]" multiple style="width:100%">
								
								<?php foreach($get_access_control as $row): ?>
									<option value="<?php echo $row["id"]; ?>"><?php echo $row["fname"]." ".$row["lname"]; ?> (<?php echo $row["fusion_id"]; ?>)</option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>
				</br>
				
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="name">Description/Content:</label>
							<textarea class="form-control" placeholder="Enter Process Updates Description" style="width: 100%; height: 150px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" id="adescription1" name="description" ></textarea>
							
							
						</div>
					</div>
				</div>
				
			</div>
			
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" id='btnAddProcessUpdates' class="btn btn-primary">Save</button>
			  </div>
		</form>	
	</div>
   </div>
</div>

<!-- end Add -->


<!-- Start edit -->
<div class="modal fade" id="modalEditProcessUpdates" tabindex="-1" role="dialog" aria-labelledby="editProcessPolicy" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
		
		<form class="frmEditProcessUpdates" method='POST' action="<?php echo base_url() ?>process_update/editProcessUpdate" data-toggle="validator">
			
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="addProcessLabel">Edit Process Updates</h4>
			</div>
			
			<div class="modal-body">
				
				<input type="hidden" class="form-control" id="edpid" name="pid" required>
				
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="office_id">Select The Location</label>
							<select class="form-control" name="office_id" id="edoffice_id" required >
								<option value=''>--Select--</option>
								<!--<option value='ALL'>ALL</option>-->
								<?php foreach($location_list as $loc): ?>
									<option value="<?php echo $loc['abbr']; ?>"><?php echo $loc['office_name']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="name">Title:</label>
							<input type="text" class="form-control" placeholder="Enter Process Updates Title" id="edtitle" name="title" required>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Select Client(s)</label>
							<select class="form-control" name="client_id" id="edclient_id" required>
								<option value="">--Select--</option>
								<?php foreach($client_list as $client): ?>
									<option value="<?php echo $client->id ?>"><?php echo $client->shname ?></option>
								<?php endforeach; ?>							
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Select Process</label>
							<select class="form-control" name="process_id" id="edprocess_id" required>
								<option value="">--Select--</option>
								<option value='0'>ALL</option>
															
							</select>
						</div>
					</div>
				</div>
				
				<div class="row" id="edspecificUser">
					<div class="col-md-4">
						<input type="checkbox" id="edspecific_user" name="specific_user" value="1">
						Access By Specific User
					</div>
				</div>
				
				<div class="row" id="edaccessControl" style="display:none">
					<div class="col-md-12">
						<div class="form-group">
							<label>Access Control</label>
							<select class="form-control" id="edaccess_control" name="access_control[]" multiple style="width:100%">
								
								<?php foreach($get_access_control as $row): ?>
									<option value="<?php echo $row["id"]; ?>"><?php echo $row["fname"]." ".$row["lname"]; ?> (<?php echo $row["fusion_id"]; ?>)</option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>
				</br>
				
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="name">Description/Content:</label>
							<textarea class="form-control" placeholder="Enter Policy Description" style="width: 100%; height: 150px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" id="eddescription" name="description"></textarea>
						</div>
					</div>
				</div>
				
			</div>
			
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" id='btnEditProcessUpdates' class="btn btn-primary">Update</button>
			  </div>
		</form>	
	</div>
   </div>
</div>

<!-- end edit -->


<div id="attach_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display:none;">
		<div class="modal-dialog modal-lg">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-themecolor" id="myLargeModalLabel">Add/Edit Attachment <span id="message_id1"></span></h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div class="modal-body">
						<input type="hidden" value="" name="atpid" id='atpid'>
					
						<div class="form-group">
							<div id='currAttachDiv' class='currAttachDiv'>
							
							
							</div>
						</div>
				
						<div class="form-group">
								Upload attachment to message 
								<div style="z-index:10;" id="mulitplefileuploader">Upload</div>
						</div>
				</div>
			</div>
		</div>
</div>

<!-- end attach_modal -->
	
<!-------------------------------------------------------------------------------------->

<!---Process Updates Acceptance--->
<div class="modal fade" id="modalProcessUpdatesAccept" tabindex="-1" role="dialog" aria-labelledby="addProcessPolicy" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
		
		<form class="frmProcessUpdatesAccept" method='POST' action="<?php echo base_url() ?>process_update/accept_process_update" data-toggle="validator">
			
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="addProcessLabel">Process Updates Acceptance</h4>
			</div>
			
			<div class="modal-body">
				<input type="hidden" id="adpid" name="adpid">
			
				<div class="row">
					<div class="col-md-12">
						<input type="checkbox" id="p_status" name="p_status" required>
						Check here to indicate that you have read & agree to the process updates.
					</div>
				</div>
			</div>
			
			  <div class="modal-footer">
				<button type="submit" id='btnProcessUpdatesAccept' class="btn btn-primary">I Agree</button>
			  </div>
			  
		</form>	
	</div>
   </div>
</div>



