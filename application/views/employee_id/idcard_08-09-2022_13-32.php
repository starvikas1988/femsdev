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
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.css" />
<div class="wrap">
<section class="app-content">
<div class="widget">
<div class="widget-body">	

  <h4><i class="zmdi zmdi-card"></i> Employee ID Card</h4>
  <hr/>
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
<div class="row">
<?php if(!empty($agent_details['id'])){ ?>
	<div class="col-md-4 text-center">
		<div id="croppie-demo"></div>
	</div>
	<div class="col-md-4" id="croppie-container">
		<strong>Select Image:</strong>
		<br/>
		<input type="file" accept=".png,.jpg,.jpeg" id="croppie-input">
		<br/>		
		<?php if(is_ppbl_check()!='1'){?>	
		<button class="btn btn-primary croppie-upload"><i class="fa fa-upload"></i> Upload Image</button>	
		<?php }?>		
	</div>
	<div class="col-md-4" style="">
		<div id="croppie-view">
		<?php if(!empty($id_card)){ echo '<img src="' .$id_card .'"'; } ?>
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


<div class="panel panel-default">
<div class="panel-body">
<div class="row">
	<div class="col-md-4 text-center">
	</div>
	<div class="col-md-4">
	</div>
	<div class="col-md-4 generateCard" <?php if(empty($id_card)){ ?>style="display:none"<?php } ?>>
		<a href="<?php echo base_url() ."employee_id/generateCard/download/".$agent_details['fusion_id']; ?>" class="btn btn-success"><i class="fa fa-download"></i> Download ID Card</a>
	</div>

</div>
</div>
</div>	

	
	
  </div>
 </div>
<section>
</div>