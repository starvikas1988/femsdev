<style>
.customRadio{
	padding-left:20px;
}
.customRadio input{
	margin-right:10px;
}

/*
#modalc {
    z-index:100;
    height:500px;
    width:400px;
    background: white;
    border: 1px solid #ccc;
    -moz-box-shadow: 0 0 3px #ccc;
    -webkit-box-shadow: 0 0 3px #ccc;
    box-shadow: 0 0 3px #ccc;
    text-align: center;
}

button, .button {
    position: relative;
    background-color: purple;
    color: white;
    padding: 10px 15px;
    border-radius: 3px;
    border: 1px solid #cccccc;
    font-size: 16px;
    font-weight: bold;
    display: block;
    cursor: pointer;
    margin: 0 auto;
    width: 200px;
    margin-bottom: 10px;
  text-transform: uppercase;
    
  &.actionCancel {
    background-color: #ddd;
    color: purple;
  }
  &.actionDone {
    display: none;
  }
  input[type="file"] {
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0;
  }
}
*/

#croppie-demo {
	width: 350px;
}
#croppie-container {
	padding-top: 30px;
}
#croppie-view {
	background: #e1e1e1;
	width: 300px;
	padding: 30px;
	height: 300px;
	margin-top: 0px
}
.btn {
    outline: 0 !important;
    font-weight: 500;
    font-size: 14px;
    padding: 5px 12px;
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.css" />
<div class="wrap">
<section class="app-content">
<div class="widget" <?php if($id_refer == 'home'){  echo 'style="width:80%;margin:0 auto;"'; } ?>>
<div class="widget-body">	

  <h4><i class="zmdi zmdi-card"></i> Employee ID Card</h4>
  <hr/>
  <?php 
    if(($check_entry > 0 && !empty($check_details['id']) && $check_details['status'] != 'R') || strtoupper($is_idcard)=="YES"){
	  if($check_details['status'] == 'H' || strtoupper($is_idcard)=="YES"){
		echo '<span class="text-success"><b><i class="fa fa-check"></i> You have successfully, received your new ID Card!</b></span><br/><br/>';  
	  } else {
		echo '<span class="text-danger"><b><i class="fa fa-check"></i> Your Request Is In Progress, Thank You For Your Patience.</b></span><br/><br/>';
	  }
    } else {
  ?>
  
  <?php 
  if(!empty($check_details['id']) && $check_details['status'] == 'R'){ 
	echo '<i class="fa fa-warning"></i> Your Previous Request was Rejected, Please Re-Apply again! <br/><hr/>';
  }
  ?>
  
  <h5>
  <?php if(!empty($agent_details['id'])){ ?>
  <b>NAME: </b>&nbsp;&nbsp;<u>&nbsp;<?php echo $agent_details['fname'] ." " .$agent_details['lname']; ?> (<?php echo $agent_details['fusion_id']; ?>)&nbsp;</u>
  <input type="hidden" class="form-control" id="agent_uid" value="<?php echo $agent_details['id']; ?>" placeholder="" name="agent_uid" required readonly>
  <input type="hidden" class="form-control" id="agent_profile" value="<?php echo $agent_details['fusion_id']; ?>" placeholder="" name="agent_profile" required readonly>
  <?php } else { ?>
		NAME : <span class="text-danger"><b>--- INVALID ---</b></span>
<?php } ?>
  </h5>
  
  <hr/>

	<div class="panel panel-default">
	 <div class="panel-body">
		
		<!-- <div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label>Have you received your Permanent Fusion ID CARD ?</label>
					<select class="form-control" name="applyID" id="">
						<option value="">-- Select --</option>
						<option value="Yes">Yes</option>
						<option value="No">No</option>
					</select>
				</div> -->
			</div>
			
			<!--<div class="col-md-4">
				<div class="form-group">
					<button style="margin-top:20px" type="button" class="btn btn-success">Apply Now</button>
				</div>
			</div>-->
		</div>
		
	</div>
	</div>	
		
	<div class="panel panel-default requestApplyDiv"  >
	  <div class="panel-body">
	  
		<div class="row">
		<?php if(!empty($agent_details['id'])){ ?>
			<div class="col-md-4 text-center">
				<div id="croppie-demo"></div>
			</div>
			<div class="col-md-4  text-center" id="croppie-container">
			<center>
				<br/>
				<input class="btn btn-primary text-center" type="file" accept=".png,.jpg,.jpeg" id="croppie-input">
				<span style="color:red;">(Max File Size 1 MB)</span>
				<br/>		
				<button class="btn btn-primary croppie-upload"><i class="fa fa-upload"></i> Crop & Upload Image</button>
			</center>
			</div>
			<div class="col-md-4" style="">
				<div id="croppie-view">
				<?php //if(!empty($id_card)){ echo '<img src="' .$id_card .'"'; } ?>
				</div>
			</div>
		<?php } else { ?>
			<div class="col-md-12" style="">
				<span class="text-danger"><b>--- User Not Found ---</b></span>
			</div>
		<?php } ?>

		</div>
	  </div>
	</div>


	<div class="panel panel-default requestApplyDiv" >
	  <div class="panel-body">	  
		<form method="POST" action="<?php echo base_url('employee_id_card/requestCardSubmit'); ?>">
		<div class="row">
			<div class="col-md-6 text-center">
			<div class="form-group generateCard" style="display:none">
				<label>Please click, apply now to request for ID CARD for the above cropped image?</label>
			</div>
			<input type="hidden" name="agent_id" value="<?php echo get_user_id(); ?>">
			<input type="hidden" name="is_idcard" value="No">
			<input type="hidden" name="is_refer" value="<?php echo (!empty($id_refer)) ? $id_refer : ""; ?>">
			</div>
			<div class="col-md-6 generateCard" style="display:none">
				<button onclick="return confirm('Are you sure, you want to apply ?')" type="submit" class="btn btn-success"><i class="fa fa-check"></i> Apply Now</button>
				<a style="display:none" href="<?php echo base_url() ."employee_id/generateCard/download/".$agent_details['fusion_id']; ?>" class="btn btn-success"><i class="fa fa-download"></i> Download ID Card</a>
			</div>
		</div>
		</form>
		<br/><br/><br/><br/><br/><br/>
	  </div>
	</div>
	
	<div class="panel panel-default haveIDCard" style="display:none">
	  <div class="panel-body">	  
		<form method="POST" action="<?php echo base_url('employee_id_card/requestCardSubmit'); ?>">
		<div class="row">
			<div class="col-md-12 text-center">
			<input type="hidden" name="agent_id" value="<?php echo get_user_id(); ?>">
			<input type="hidden" name="is_idcard" value="Yes">
			<input type="hidden" name="is_refer" value="<?php echo (!empty($id_refer)) ? $id_refer : ""; ?>">
			</div>
			<div class="col-md-12">
				<button type="submit" class="btn btn-success"><i class="fa fa-sign-in"></i> Submit</button>
			</div>
		</div>
		</form>
		<br/><br/><br/><br/><br/><br/>
	  </div>
	</div>
	
	<div class="panel panel-default skipIDCard" <?php if($id_refer != 'home'){  echo 'style="display:none"'; } ?>>
	  <div class="panel-body">	
		<br/><br/>
		<form method="GET" action="<?php echo base_url('employee_id_card/skipCardRequest'); ?>">
		<div class="row">
			<div class="col-md-12 text-center">
			<input type="hidden" name="agent_id" value="<?php echo get_user_id(); ?>">
			<input type="hidden" name="is_idcard" value="Yes">
			<input type="hidden" name="is_refer" value="<?php echo (!empty($id_refer)) ? $id_refer : ""; ?>">
			</div>
			<div class="col-md-12 text-right">
				<button type="submit" class="btn btn-primary"><i class="fa fa-arrow-right"></i> Skip Now</button>
			</div>
		</div>
		</form>
		<br/><br/><br/><br/>
	  </div>
	</div>



<?php } ?>

<div class="panel panel-default skipIDCard" <?php if($is_idcard !='Yes' ){echo 'style="display:none"';} ?>>
	  <div class="panel-body">	  
		<form method="POST" action="<?php echo base_url('employee_id_card/reapply_id_card'); ?>">
		<div class="row">
			<div class="col-md-12">
			<input type="hidden" name="agent_id" value="<?php echo get_user_id(); ?>">
				<button type="submit"  class="btn btn-primary"><i class="fa fa-arrow-right"></i> Re Apply</button>
			</div>
		</div>
		</form>
		<br/><br/><br/><br/><br/><br/>
	  </div>

</div>
</div>
<section>
</div>