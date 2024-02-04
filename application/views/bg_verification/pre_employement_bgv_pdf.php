<style>
body {
	background: #ffffff;
	font-family: "apercu", sans-serif,"Helvetica Neue", Helvetica, Arial;
	font-size: 13px;
	line-height: 1.4;
	color: #67686a;
	/*#6a6c6f*/
}
.text-center{
	text-align:center;
}
.form-title{
	font-size:16px;
}
th{
	font-size:12px;
}
td{
	font-size:10px;
}

</style>

<div class="wrap">
	<section class="app-content">	
	
	
		<div class="simple-page-wrap" style="width:100%;">
		<div class="simple-page-form animated flipInY">
		<h4 class="form-title m-b-xl text-center"><b><u>Applicant’s Approval For Pre-Employment Back Ground Verification</u></b></h4>
				
					
		<div style="padding:10px 10px">
		<p style="text-align: left;">I, <b><u>&nbsp;<?php echo $personal_row['fullname']; ?>&nbsp;</u></b>, hereby give my approval to Xplore-Tech Services Pvt. Ltd.(A Fusion BPO Services Group Company) and authorize its appointed agency to do following pre-employment verifications for me :</p>
		
		
		<p style="text-align:left;margin:15px 0px 15px 0px"><strong>1.	Service record background check with my previous worked companies:</strong></p>
		
		<div class="row">	
		<div class="col-md-12">
		<table id="recordsTable" style="width:100%;border:1px solid #68696b;border-collapse: collapse;">
		<tr style="background-color:#f3f3f3">
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;">
			Company Name <br/><span style="font-size:9px">(in reverse chronological order)</span></th>
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;">Worked Period (dd/mm/yy)</th>
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;">Contact Person’s Name and Designation</th>
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;">Contact Person’s <br/>Contact Phone No.</th>
			<th style="border: 1px solid #68696b;padding:5px 10px;text-align:center;">Contact Person’s <br/>Email Address</th>
		</tr>
		<?php $counter=0; foreach($experience_row as $token){ $counter++; ?>
		<tr style="font-size:10px">
			<td style="border: 1px solid #68696b;padding:5px 10px">
			<?php echo $token['org_name']; ?>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px;text-align:center">
			<?php echo date('d, M Y', strtotime($token['from_date'])); ?>  - <?php echo date('d, M Y', strtotime($token['to_date'])); ?>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px">
			<?php echo $token['contact_name']; ?>, <?php echo $token['contact_designation']; ?>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px;text-align:center">
			<?php echo $token['contact']; ?>
			</td>
			<td style="border: 1px solid #68696b;padding:5px 10px">
			<?php echo $token['contact_email']; ?>
			</td>
		</tr>
		<?php } ?>
		
		<?php if($counter == 0){ ?>
		<tr style="font-size:10px">
			<td style="border: 1px solid #68696b;padding:5px 10px" colspan="6">
			-- No Records Found --
			</td>
		</tr>		
		<?php } ?>
		</table>
		
		</div>
		</div>
		
		
		<p style="text-align:left;margin:25px 0px 15px 0px"><strong>2.	Third party background verification check which includes :</strong></p>
		
		<div class="row">	
		<div class="col-md-6">
			I. Educational Qualification Verification &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" value="1" name="is_educational" style="height:15px" <?php echo $personal_row['is_bgv_educational'] == 1 ? 'checked="checked"' : ''; ?>> Yes &nbsp;&nbsp;&nbsp;
			<input type="radio" value="0" name="is_educational" style="height:15px" <?php echo $personal_row['is_bgv_educational'] == 0 ? 'checked="checked"' : ''; ?>> No
		</div>
		</div>
		
		<div class="row">	
		<div class="col-md-12">
			II.	Residential Address Verification  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" value="1" name="is_residential" style="height:15px;" <?php echo $personal_row['is_bgv_residential'] == 1 ? 'checked="checked"' : ''; ?>> Yes &nbsp;&nbsp;&nbsp;
			<input type="radio" value="0" name="is_residential" style="height:15px;" <?php echo $personal_row['is_bgv_residential'] == 0 ? 'checked="checked"' : ''; ?>> No
		</div>
		</div>
		
		<div class="row">	
		<div class="col-md-12">
			III. Criminal Verification &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" value="1" name="is_criminal" style="height:15px;" <?php echo $personal_row['is_bgv_criminal'] == 1 ? 'checked="checked"' : ''; ?>> Yes &nbsp;&nbsp;&nbsp;
			<input type="radio" value="0" name="is_criminal" style="height:15px;" <?php echo $personal_row['is_bgv_criminal'] == 0 ? 'checked="checked"' : ''; ?>> No
		</div>
		</div>
		
		<br/><hr/>

		<div class="row">
		<div class="form-group text-cener">
			I understand that if my background verification report results negative my application will not be processed further.
		</div>
		</div>
		<br/>
		<div class="row">	
		<div class="col-md-12"><b>Full Signature of Applicant: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b><u><?php echo $personal_row['fullname']; ?></u></div>
		</div>
		
		<?php
		// GET ADDRESS
		$permanent_address = $personal_row['address_permanent']; 
		$flag = "";
		if(!empty($permanent_address)){ $flag = ", "; }
		if(!empty($personal_row['city'])){ $permanent_address .= $flag.$personal_row['city']; $flag = ", "; }
		if(!empty($personal_row['state'])){ $permanent_address .= $flag .$personal_row['state']; $flag = ", "; }
		if(!empty($personal_row['pin'])){ $permanent_address .= $flag ."PIN - " .$personal_row['pin']; $flag = ", "; }
		if(!empty($personal_row['country'])){ $permanent_address .= $flag.$personal_row['country']; $flag = ", "; }
		?>
		<div class="row">	
		<div class="col-md-12"><b>Permanent Address of Applicant: &nbsp;&nbsp;</b><u><?php echo $permanent_address; ?></u></div>
		</div>
		
		<br/><br/>
		
		
		</div>

		</div>
		</div>
		
	
</section> 
</div>
