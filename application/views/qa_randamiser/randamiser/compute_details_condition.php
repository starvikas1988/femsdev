<div class="">

		
		<div class="row">
			<div class="col-md-3">
				<div class="form-group">
					<label>Date Wise </label>
					
				</div>
			</div> 
			<div class="col-sm-3">
				<div class="form-group">
					<label><?php echo $compute_logic['from_date'];?> </label>
					
				</div>
			</div>
			
		</div>
		<hr>
		
		<div class="row">
			<div class="col-md-3">
				<div class="form-group">
					<label>Selected Agent </label>
					
				</div>
			</div> 
			<div class="col-sm-3">
				<div class="form-group">
					 
					<?php foreach($agent_list as $agent){?>
						<label><?php echo $agent['name'];?></label><br>
					<?php }?>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label>Selected Queue Name </label>
					
				</div>
			</div> 
			<div class="col-sm-3">
				<div class="form-group">
					 
					<?php if(!empty($compute_logic['queue_name'])){?>
					<?php $queue_nameArr = explode(',',$compute_logic['queue_name']);?> 
					<?php foreach($queue_nameArr as $queue_name){?>
						<label><?php echo $queue_name;?></label><br>
					<?php }}else{?>
						<label>--</label>
					<?php }?>
				</div>
			</div>
		</div>
		<hr>
		<div class="row">
		
			<div class="col-md-3">
				<div class="form-group">
					<label>Selected AHT in Sec </label>
					
				</div>
			</div> 
			<div class="col-sm-3">
				<div class="form-group">
					 
					<?php if(!empty($compute_logic['aht'])){?>
					<?php $ahtArr = explode(',',$compute_logic['aht']);?> 
					<?php foreach($ahtArr as $aht){?>
						<label><?php echo str_replace('aht_sec','',$aht);?></label><br>
					<?php }}else{?>
						<label>--</label>
					<?php }?>
				</div>
			</div>
		</div>
		<hr>
		
		
</div>		