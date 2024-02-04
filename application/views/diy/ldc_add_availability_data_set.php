<style>
.slotUI li{
	font-size:10px!important;
}
</style>

<?php if(!empty($availData)){ ?>
	
	<section id="calendar-area" class="calendar-area">
		<div class="calendar-widget">
		  <div class="calendar-main box">
			<div class="gmt-widget">
			  <small id="timezone"><?php echo $timezone;?></small>
			</div>
			<table class="table table-striped">
			  <thead>
				<tr>
				<th></th>
				<?php
					$date_check="";
       				$ch='true';
					foreach($availData as $key=>$rows){

		       		if($date_check!=$rows['avail_date']){
		       			$date_check=$rows['avail_date'];
		       			foreach($leaveData as $k=>$diy){
		       				if (($date_check >= $diy['from_date']) && ($date_check <= $diy['to_date'])){
							   $ch='false';
							}else{
							    $ch='true';  
							}
		       			}
		       		if($ch=='true'){

		       		?>
		       		<input type="hidden" name="date_avail[]" id="date_avail" value="<?php echo $date_check;?>">
		       		<?php		
		       			if($rows['avail_day']=='MON'){
					?>
				<th>Mon</th>
				<?php } if($rows['avail_day']=='TUE'){?>
				<th>Tue</th>
				<?php } if($rows['avail_day']=='WED'){?>
				<th>Wed</th>
				<?php } if($rows['avail_day']=='THU'){?>
				<th>Thu</th>
				<?php } if($rows['avail_day']=='FRI'){?>
				<th>Fri</th>
				<?php } if($rows['avail_day']=='SAT'){?>
				<th>Sat</th>
				<?php } if($rows['avail_day']=='SUN'){?>
				<th>Sun</th>
				<?php }}}} ?>
				</tr>
			  </thead>
			  <tbody>
			  	<?php 
			  		foreach($slotData as $token){
			  			$currentSlotID = $token['id'];
						
						
	       		?>
	       		<tr>
				<td>
				  <?php echo $token['slot_name'];?>
				</td>
				
	       		<?php 		
						foreach($availData as $key=>$rows){
							$classCheck = ""; $selected = "";
			       		if($date_check!=$rows['avail_date']){
			       			$date_check=$rows['avail_date'];
			       			foreach($leaveData as $k=>$diy){
			       				if (($date_check >= $diy['from_date']) && ($date_check <= $diy['to_date'])){
								   $ch='false';
								}else{
								    $ch='true';  
								}
			       			}
			       		if($ch=='true'){
			       			
			       			if(!empty($allSlotSet[$date_check][$currentSlotID])){
						   if($rows['avail_date']==$allSlotSet[$date_check][$currentSlotID]['avail_date']){	
								$classCheck = "Unavailable";
								$selected = "checked='checked'";
							}	
						}
						
						//if($rows['avail_day']=='MON'){		
			  		?>
				
				<td>
				  <label class="checkbox-widget">
					<input type="checkbox" name="<?php echo strtoupper(date('D', strtotime($rows['avail_day']))); ?>[<?php echo  $date_check;?>][]"  value="<?php echo $token['id'];?>" <?php echo $selected;?>>
					<span class="checkmark"></span>
				  </label>
				</td>
				<?php		
		       		/*}if($rows['avail_day']=='TUE'){
				?>
				<td>
				  <label class="checkbox-widget">
					<input type="checkbox" name="TUE[]"  value="<?php echo $token['id'];?>">
					<span class="checkmark"></span>
				  </label>
				</td>
				<?php		
		       		}if($rows['avail_day']=='WED'){
				?>
				<td>
				  <label class="checkbox-widget">
					<input type="checkbox" name="WED[]"  value="<?php echo $token['id'];?>">
					<span class="checkmark"></span>
				  </label>
				</td>
				<?php		
		       		}if($rows['avail_day']=='THU'){
				?>
				<td>
				  <label class="checkbox-widget">
					<input type="checkbox" name="THU[]"  value="<?php echo $token['id'];?>">
					<span class="checkmark"></span>
				  </label>
				</td>
				<?php		
		       		}if($rows['avail_day']=='FRI'){
				?>
				<td>
				  <label class="checkbox-widget">
					<input type="checkbox" name="FRI[]"  value="<?php echo $token['id'];?>">
					<span class="checkmark"></span>
				  </label>
				</td>
				<?php		
		       		}if($rows['avail_day']=='SAT'){
				?>
				<td>
				  <label class="checkbox-widget">
					<input type="checkbox" name="SAT[]"  value="<?php echo $token['id'];?>">
					<span class="checkmark"></span>
				  </label>
				</td>
				<?php		
		       		}if($rows['avail_day']=='SUN'){
				?>
				<td>
				  <label class="checkbox-widget">
					<input type="checkbox" name="SUN[]"  value="<?php echo $token['id'];?>">
					<span class="checkmark"></span>
				  </label>
				</td>
				<?php } */?>
				
				<?php }}} ?>
				</tr>
				<?php } ?>
			  </tbody>
			</table>
		  </div>
		</div>
    </section>	
	<div class="col-md-12">
		<button  type="submit" style="height: 2.5rem;" name="submit" class="btn btn-success col-md-12" onclick="return confirm('Are you sure?')"><i class="fa fa-save"></i> Submit </button>
	</div>
	
<?php } else {  ?>

<span class="text-danger">-- No Records Found --<span>

<?php } ?>
<script>
//var j = jQuery.noConflict();
$('.box').overlayScrollbars({className       : "os-theme-round-dark",resize          : "both",
  sizeAutoCapable : true,
  paddingAbsolute : true}); 
  </script>