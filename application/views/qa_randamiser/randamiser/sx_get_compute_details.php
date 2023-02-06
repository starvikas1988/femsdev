<div class="">
	<form id="form_compute_again" method="POST" action="<?php echo base_url('Qa_randamiser/compute_again_logiclist'); ?>">
		<input type="hidden" id="compute_id" name="compute_id" value="<?php echo $compute_id;?>" class="form-control" required>
		<div class="row">
			<div class="col-md-3">
				<div class="form-group">
					<label>Select Date</label>
					<input type="date" id="select_date" name="select_date" value="" class="form-control" required>
				</div>
			</div> 
			<div class="col-md-1" style="margin-top:20px">
				<button class="btn btn-success waves-effect" a href="<?php echo base_url()?>Qa_randamiser/compute_again_logiclist" type="submit" id='btnCompute' name='btnCompute' value="Create">Compute</button>
			</div>
		</div>
	</form>
</div>		