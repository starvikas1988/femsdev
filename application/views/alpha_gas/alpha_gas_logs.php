	<div class="table-responsive">
		<table style="margin-top: 10px;" id="default-datatable-logs" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
		
			<thead>
				<tr class='bg-info'>
					<th>#</th>
					<th>Date</th>
					<th>Disposition</th>
					<th>Comments</th>
					<th>Added by</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			$cn = 1;
			foreach($crmCase as $token){ 								
			?>
			<tr>
				<td><?php echo $cn++; ?></td>
				<td><?php echo date('d M, Y h:i A', strtotime($token['cl_date_added'])); ?></td>
				<td><b><?php echo $token['cl_disposition']; ?></b></td>
				<td><?php echo $token['cl_comments']; ?></td>
				<td><b><?php echo $token['added_by_name']; ?></b></td>
			</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
					