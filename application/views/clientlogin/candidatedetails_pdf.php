
<style>
	table, tr, td {
	  border: 1px solid black;
	  font-size:12px;
	}
</style>

			
<div style="margin:5px;">	
	
	<div>
		<img src="<?php echo APPPATH; ?>/../assets_home_v3/brand_logo/fusion_logo.svg" height="10%">
	</div>

	
	<?php foreach($candidate_details as $row): ?>
	
	<div>
			<div style="text-align:right; font-size:12px; padding-bottom:10px">Applying Date: <?php echo $row['addedDate']; ?></div></br>
			
			<table cellspacing="0" cellpadding="5" style="width:100%; border:1px solid black">
				<tr>
					<td style="text-align:left;width:100px;"><b>Full Name:</b></td>
					<td style="text-align:left"><?php echo $row['fname']." ".$row['lname']; ?></td>
					<td style="text-align:left; width:80px ;"><b>DOB:</b></td>
					<td style="text-align:left;width:100px;"><?php echo $row['dob']; ?></td>
				</tr>
			</table>
			
			<table cellspacing="0" cellpadding="5" style="width:100%; border:1px solid black">
				<tr>
					<td style="text-align:left"><b>Position Applied For:</b></td>
					<td style="text-align:left"><?php echo $row['position_name']; ?></td>
					<td style="text-align:left"><b>Fresher/Experience:</b></td>
					<td style="text-align:left"><?php echo $row['experience']; ?></td>
				</tr>
				<tr>
					<td style="text-align:left"><b>Field of Interest:</b></td>
					<td style="text-align:left"><?php echo $row['interest']; ?></td>
					<td style="text-align:left"><b>Interest Description:</b></td>
					<td style="text-align:left"><?php echo $row['interest_desc']; ?></td>
				</tr>
			</table>
			
			<div style="padding-top:10px"></div>	
			<table cellspacing="0" cellpadding="5" style="width:100%; border:1px solid black">
				<tr>
					<td colspan="4" style="text-align:left"><b>How you came to know about the vacancy:</b></td>
					<?php if($row['hiring_source']!="Existing Employee"){ ?>
						<td colspan="2" style="text-align:left"><?php echo $row['hiring_source']." (".$row['ref_name'].")"; ?></td>
					<?php }else{ ?>
						<td colspan="2" style="text-align:left"><?php echo $row['hiring_source']; ?></td>
					<?php } ?>
				</tr>
				
				<?php if($row['hiring_source']=="Existing Employee"){ ?>
				<tr>
					<td style="text-align:left"><b>Ref. Name:</b></td>
					<td style="text-align:left"><?php echo $row['ref_name']; ?></td>
					<td style="text-align:left"><b>Ref. Department:</b></td>
					<td style="text-align:left"><?php echo $row['ref_dept']; ?></td>
					<td style="text-align:left"><b>Ref. ID:</b></td>
					<td style="text-align:left"><?php echo $row['ref_id']; ?></td>
				</tr>
				<?php } ?>
			</table>
			
			<div style="padding-top:10px"></div>
			<table cellspacing="0" cellpadding="5" style="width:100%; border:1px solid black">
				<tr>
					<td style="text-align:left"><b>Parmanent Address:</b></td>
					<td style="text-align:left"><?php echo $row['address']; ?></td>
					<td style="text-align:left"><b>Email:</b></td>
					<td style="text-align:left"><?php echo $row['email']; ?></td>
				</tr>
				<tr>
					<td style="text-align:left"><b>Correspondence Address:</b></td>
					<td colspan="3" style="text-align:left"><?php echo $row['correspondence_address']; ?></td>
				</tr>
				<tr>
					<td style="text-align:left"><b>Mobile(1):</b></td>
					<td style="text-align:left"><?php echo $row['phone']; ?></td>
					<td style="text-align:left"><b>Mobile(2):</b></td>
					<td style="text-align:left"><?php echo $row['alter_phone']; ?></td>
				</tr>
				<tr>
					<td style="text-align:left"><b>Own Conveyance:</b></td>
					<td style="text-align:left"><?php echo $row['conveyance']; ?></td>
					<td style="text-align:left"><b>Driving Licence:</b></td>
					<td style="text-align:left"><?php echo $row['d_licence']; ?></td>
				</tr>
			</table>

			<div style="padding-top:10px"></div>
			<table cellspacing="0" cellpadding="5" style="width:100%; border:1px solid black">
				<tr>
					<td colspan="2" style="text-align:left"><b>Have you worked with Xplore-Tech / Fusion BPO before? if yes please specify L.W.D & Department:</b></td>
				</tr>	
				<tr>
					<td colspan="2" style="text-align:left"><?php echo $row['past_employee']; ?></td>
				</tr>
				<tr>
					<td style="text-align:left"><b>Have you appeared for interview before? If yes, please specify when?</b></td>
					
					<td style="text-align:left"><?php echo ($row['past_inter_date'] =="0000-00-00"  ? '' : $row['past_inter_date']) ; ?></td>
				</tr>
				<tr>
					<td style="text-align:left"><b>Are you willing to work in 24x7 service standard?</b></td>
					<td style="text-align:left"><?php echo $row['24_7_service']; ?></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:left"><b>Skill Set Areas:</b> <?php echo $row['skill_set']; ?></td>
				</tr>
			</table>
		
		<div style="padding-top:10px"><b>Educational Details:</b></div>	
		<table cellspacing="0" cellpadding="5" style="width:100%; border:1px solid black">
			<tr style="border:1px solid black; background-color:#D1FAFA">
				<td style="border:1px solid black"></td>
				<td style="border:1px solid black">Course Name</td>
				<td style="border:1px solid black">Board / University</td>
				<td style="border:1px solid black">School / University</td>
				<td style="border:1px solid black">Passing Year</td>
				<td style="border:1px solid black">%</td>
			</tr>
			<?php foreach($can_education_details as $ced){ ?>
			<tr style="border:1px solid black">
				<td style="border:1px solid black"><?php echo $ced['exam']; ?></td>
				<td style="border:1px solid black"><?php echo $ced['specialization']; ?></td>
				<td style="border:1px solid black"><?php echo $ced['board_uv']; ?></td>
				<td style="border:1px solid black"><?php echo $ced['school_name']; ?></td>
				<td style="border:1px solid black"><?php echo $ced['passing_year']; ?></td>
				<td style="border:1px solid black"><?php echo $ced['grade_cgpa']; ?></td>
			</tr>
			<?php } ?>
		</table>
	
		
			<div style="padding-top:10px"><b>Experience Details:</b></div>
			<table cellspacing="0" cellpadding="5" style="width:100%; border:1px solid black">	
				<tr>
					<td style="text-align:left"><b>Total Experience:</b></td>
					<td colspan="2" style="text-align:left"><?php echo $row['total_work_exp']; ?></td>
					<td colspan="2" style="text-align:left"><b>Notice Period for Joining:</b></td>
					<td style="text-align:left"><?php echo $row['notice_period']; ?></td>
				</tr>
			</table>
			
			<div style="padding-top:10px">Last 3 Organization:</div>
			<table cellspacing="0" cellpadding="5" style="width:100%; border:1px solid black">
				<tr style="border:1px solid black; background-color:#D1FAFA">
					<td style="border:1px solid black">Name</td>
					<td style="border:1px solid black">Designation</td>
					<td style="border:1px solid black">Tenure of Work</td>
					<td style="border:1px solid black">References from Each Organization</td>
				</tr>
				<?php foreach($can_experience_details as $cxd){ ?>
				<tr style="border:1px solid black">
					<td style="border:1px solid black"><?php echo $cxd['company_name']; ?></td>
					<td style="border:1px solid black"><?php echo $cxd['designation']; ?></td>
					<td style="border:1px solid black"><?php echo $cxd['work_exp']; ?></td>
					<td style="border:1px solid black"><?php echo $cxd['job_desc']; ?></td>
				</tr>
				<?php } ?>
			</table>
		
		
			<div style="page-break-after: always"><span style="display: none;">&nbsp;</span></div>
		
		
			<div><b>Family Details:</b></div>
			<table cellspacing="0" cellpadding="5" style="width:100%; border:1px solid black">
				<tr>
					<td style="text-align:left"><b>Married:</b></td>
					<td colspan="2" style="text-align:left"><?php echo $row['married']; ?></td>
					<td style="text-align:left"><b>Home Town:</b></td>
					<td colspan="2" style="text-align:left"><?php echo $row['home_town']; ?></td>
				</tr>
			</table>
			
			<table cellspacing="0" cellpadding="5" style="width:100%; border:1px solid black; padding-top:5px">
				<tr style="border:1px solid black; background-color:#D1FAFA">
					<td style="border:1px solid black"></td>
					<td style="border:1px solid black">Name</td>
					<td style="border:1px solid black">Occupation</td>
				</tr>
				<?php foreach($can_family_details as $cfd){ ?>
				<tr>
					<td style="border:1px solid black"><?php echo $cfd['relation_type']; ?></td>
					<td style="border:1px solid black"><?php echo $cfd['name']; ?></td>
					<td style="border:1px solid black"><?php echo $cfd['occupation']; ?></td>
				</tr>
				<?php } ?>
			</table>
			
			<div style="padding-top:10px"></div>
			<table cellspacing="0" cellpadding="5" style="width:100%; border:1px solid black">	
				<tr>
					<td colspan="2" style="text-align:left"><b>Reason for Leaving Job (present/last):</b></td>
					<td colspan="4" style="text-align:left"><?php echo $row['job_leav_reason']; ?></td>
				</tr>
			</table>
			
			<div style="padding-top:10px"><b>Salary/CTC:</b></div>
			<table cellspacing="0" cellpadding="5" style="width:100%; border:1px solid black">
				<tr style="border:1px solid black; background-color:#D1FAFA">
					<td style="border:1px solid black">Present Gross</td>
					<td style="border:1px solid black">Present Take Home</td>
					<td style="border:1px solid black">Expected Take Home</td>
				</tr>
				<tr style="border:1px solid black">
					<td style="border:1px solid black"><?php echo $row['gross']; ?></td>
					<td style="border:1px solid black"><?php echo $row['take_home']; ?></td>
					<td style="border:1px solid black"><?php echo $row['expected']; ?></td>
				</tr>
			</table>
				
			<div style="padding-top:10px"><b>References:</b></div>
			<table cellspacing="0" cellpadding="5" style="width:100%; border:1px solid black">
				<tr style="border:1px solid black; background-color:#D1FAFA">
					<td style="border:1px solid black">(1) Name & Relationship Address & Phone No</td>
					<td style="border:1px solid black">(2) Name & Relationship Address & Phone No</td>
					<td style="border:1px solid black">(3) Name & Relationship Address & Phone No</td>
				</tr>
				<tr style="border:1px solid black">
					<td style="border:1px solid black"><?php echo $row['reference_1']; ?></td>
					<td style="border:1px solid black"><?php echo $row['reference_2']; ?></td>
					<td style="border:1px solid black"><?php echo $row['reference_3']; ?></td>
				</tr>
			</table>
			
			<div style="padding-top:10px"></div>
			<table cellspacing="0" cellpadding="5" style="width:100%; border:1px solid black">		
				<tr>
					<td style="text-align:left"><b>Any known medical illness:</b></td>
					<td colspan="5" style="text-align:left"><?php echo $row['illness']; ?></td>
				</tr>
				<tr>
					<td style="text-align:left"><b>Any accidents in past:</b></td>
					<td colspan="5" style="text-align:left"><?php echo $row['accidents']; ?></td>
				</tr>
				<tr>
					<td colspan="6" style="text-align:left"><b>CONFIRMATION REGARDING LEGAL ASSOCIATION:</b></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:left"><b>Any judicial proceeding against you in the court of law? If yes, please give details:</b></td>
					<td colspan="4" style="text-align:left"><?php echo $row['legal']; ?></td>
				</tr>
			</table>	
			
			<div style="padding-top:10px"></div>
			<table cellspacing="0" cellpadding="10" style="width:100%">		
				<tr>
					<td colspan="2">I declare that above mentioned information is true to the best of my knowledge. Any action which the management deems fit may be taken if discrepancy is found in the same.</td>
				</tr>
				<tr>
					<td style="text-align:left; height:100px">DATE:</td>
					<td style="text-align:center; height:100px; padding-top:35px">Signature</td>
				</tr>
			</table>	
		
	</div>
	
	<?php endforeach; ?>
					
</div>					
					
					