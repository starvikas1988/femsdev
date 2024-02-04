<div class="wrap">
	<section class="app-content">
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Your Contacts Information </h4>
					</header>
					<hr class="widget-separator"/>
					<div class="widget-body clearfix">
						
						<?php 
							if($error!='') echo $error;
							//print_r($user_info);
							$user=$user_info[0];
							
							
						?>
						
						<?php echo form_open('') ?>
						
							
							<input type="hidden" class="form-control" id="uid" value='<?php echo $user['id']; ?>' name="uid" required>
							
							
							<div class="form-group">
								<label for="name">Email ID:</label>
								<input type="text" class="form-control" id="email_id" value='<?php echo $user['email_id']; ?>' placeholder="Email ID" name="email_id">
									
							</div>
							
							<div class="form-group">
								<label for="phno">Phone No:</label>
								<input type="text" class="form-control" id="phno" value='<?php echo $user['phno']; ?>' placeholder="Phone No" name="phno">
							</div>
							
							<div class="col-md-12 text-center">
								<input type="submit" name="submit" class="btn btn-success btn-md" value="Update">
								<!-- <button type="button" class="btn btn-danger btn-md" id="btnEdit">Edit</button>	 -->
							</div>
							
						</form>
			
			        </div>
		</div><!-- .row -->

	</section>
	
</div><!-- .wrap -->