<div class="row">
<div class="col-md-12">
<b>Mail BOX : <span class="text-primary"><?php echo $emailInfo[0]['email_name']; ?></span></b><br/>
<b>Email ID : <span class="text-primary"><?php echo $emailInfo[0]['email_id']; ?></span></b><br/><br/>
</div>
<div class="col-md-12 table-responsive">
			
	  <table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
		<thead>
			<tr class='bg-primary'>
				<th></th>
				<th>Folder</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>	
		<?php 
		$cn=0; 
		foreach($folderInfo as $token){ 
		$cn++;
		?>
			<tr>
				<td><?php echo $cn; ?></td>
				<td><?php echo $token['folder']; ?></td>
				<td>
				<?php if($emailInfo[0]['folder_complete'] == $token['folder']){ echo '<span class="text-success"><b>Currently Selected as Deafult</b></span>'; } else { ?>
				<a eid="<?php echo $emailInfo[0]['id']; ?>" folder="<?php echo $token['folder']; ?>" class="btn btn-primary btn-sm editMasterMailFolder"><i class="fa fa-check"></i> Mark as Default</a>
				<?php } ?>
				</td>
			</tr>
		<?php } ?>
		</tbody>
	</table>				
		
</div>
</div>