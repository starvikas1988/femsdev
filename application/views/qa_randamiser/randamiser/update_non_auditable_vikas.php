<div class="">
			<form id="form_create_bucket" method="POST" action="<?php echo base_url('Qa_randamiser/update_distribution'); ?>">
				<input type="hidden" id="randID" name="randID" value="<?php echo $randID;?>" class="form-control" required>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Comment </label>
							
							<textarea name="non_auditable_comment" id="non_auditable_comment" class="form-control" required></textarea>
							<input type="hidden" id="client_id" name="client_id" value="<?php echo $client_id;?>" class="form-control" required>
							<input type="hidden" id="process_id" name="process_id" value="<?php echo $pro_id;?>" class="form-control" required>
							<input type="hidden" id="distribute_date" name="distribute_date" value="<?php echo $disDate;?>" required>
						</div>
					</div> 
					
					<div class="col-md-1" style="margin-top:20px">
						<button class="btn btn-success waves-effect" a href="<?php echo base_url()?>Qa_randamiser/update_randamiser" type="submit" id='btnCreate' name='btnCreate' value="Update">Update</button>
					</div>
				</div>
			</form>
		</div>		