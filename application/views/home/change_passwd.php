<div class="wrap">
	<section class="app-content">	
	
		<div class="simple-page-wrap">
			
			<div class="simple-page-form animated flipInY">
				<h4 class="form-title m-b-xl text-center">Change Password</h4>
				
				<?php if($error!='') echo $error; ?>
					
				<form action="<?php echo base_url(); ?>home/change_password" data-toggle="validator" autocomplete="off" method='POST'>
										
					<div class="form-group">
						<input id="old_password" type="password" class="form-control" placeholder="Type Your Old Password" name="old_password" required>
					</div>

					<div class="form-group">
						<input id="new_password" type="password" class="form-control" data-minlength="8" placeholder="Type New Password" name="new_password" pattern="(?=^.{6,40}$)(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&amp;*()_+}{&quot;:;'?/&gt;.&lt;,])(?!.*\s).*$" required>
						<div class="help-block">
						Password should contain atleast 1-UC Character, 1-LC Character, Special Character, Number and minimum of 8 digits
						</div>
					</div>
					
					<div class="form-group">
						<input id="re_password" type="password" class="form-control" placeholder="Re-type Password" data-match="#new_password" data-match-error="Whoops, password doesn't match" name="re_password" required>
						<div class="help-block with-errors"></div>
					</div>

					<input type="submit" class="btn btn-success" value="Save" name="submit">
				</form>
			</div>

		</div>
			
</section> 
</div>
