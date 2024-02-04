<style>
	td{
		font-size:12px;
	}
	
</style>
<div class="wrap">
	<section class="app-content">
		<div class="row">
		
		<!-- DataTable -->
		<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Email Notifications</h4>
					</header><!-- .widget-header -->
					<hr class="widget-separator">
					<div class="widget-body">
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped" cellspacing="0" width="100%">
								<thead>
									<tr>
									    <th>SL</th>
										<th>Client</th>
										<th>Notify for</th>
										<th>Email_id</th>
										<th>Subject</th>
										<th>Body</th>
									</tr>
								</thead>
								
								<tfoot>
									<tr>
										<th>SL</th>
										<th>Client</th>
										<th>Notify for</th>
										<th>Email_id</th>
										<th>Subject</th>
										<th>Body</th>
									</tr>
								</tfoot>
	
								<tbody>
								
								<?php foreach($info_list as $user): ?>
								
									<tr>
										<td><?php echo $user['id']; ?></td>
										<td><?php echo $user['client_name']; ?></td>
										<td><?php echo $user['sch_for']; ?></td>
										<td><?php echo $user['email_id']; ?></td>
										<td><?php echo $user['email_subject']; ?></td>
										<td><?php echo $user['email_body']; ?></td>

										<td>
											
											
											<?php
											
												$info_id=$user['id'];
											
												$params=$user['sch_for']."#".$user['email_id']."#".$user['email_subject']."#".$user['email_body'];
												
																								
												echo "<button params='$params' sid='$info_id' type='button' class='editSchedule btn btn-primary btn-xs'>Edit</button>&nbsp;";
												
											?>
											
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
	
<!-- Default bootstrap-->
<div class="modal fade" id="sktModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	 
	  
	<form class="editSch" onsubmit="return false" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Change Email Notification</h4>
      </div>
      <div class="modal-body">
								
			<input type="hidden" class="form-control" id="sid" name="sid" required>
			
			<div class="form-group">
				<label for="sch_for">Schedule For:</label>
				<input type="text" class="form-control" id="sch_for" placeholder="Schedule For" name="sch_for" readonly required>
			</div>
			
			<div class="form-group">
				<label for="email_id">Email ID</label>
				<input type="text" class="form-control" id="email_id" placeholder="Email ID" name="email_id" required>
			</div>
			
			<div class="form-group">
				<label for="email_subject">Email Subject</label>
				<input type="text" class="form-control" id="email_subject" placeholder="Email Subject" name="email_subject" required>
			</div>
			
			
			<div class="form-group">
				<label for="email_body">Email Body:</label>
				<textarea  class="form-control" rows="2" id="email_body" name="email_body" ></textarea> 
			</div>
			
			
	  
	   
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id='updateSchedule' class="btn btn-primary">Save changes</button>
      </div>
	  
	 </form>
	  
    </div>
  </div>
</div>


</div><!-- .wrap -->