<style>
	.tables table, tr, td {
	  border: 1px solid black;
	  font-size:14px;
	  font-weight: bold;
	}
	.tables td{width:25%;}
</style>
<div style="margin:5px;">
	<table width="100%" cellspacing="0" cellpadding="0" style="border:hidden">
		<tr style="border:hidden">
			<td style="border:hidden"><img src="<?php echo base_url();?>assets/joining_kit/logo.jpg"></td>

			<td style="border:hidden"></td>
			<td colspan="2" style="font-size:20px;border:hidden">Interview Code:</td>

		</tr>
	</table>
		<table width="100%" class="tables" cellspacing="0" cellpadding="5">
			<?php foreach($candidate_details as $row): ?>
			<tr>
				<td>Candidate Name</td>
				<td><?php echo $row['fname'].' '.$row['lname'];?></td>
				<td>Interview Date</td>
				<td><?php echo date('Y-m-d',strtotime($schedule[0]['scheduled_on']));?></td>
			</tr>
			<tr>
				<td>Fathers Name</td>
				<td><?php echo ($row['relation_guardian']=='Father')?$row['guardian_name']:'';?></td>
				<td>Highest Qualification</td>
				<td><?php echo $row['last_qualification'];?></td>
			</tr>
			<tr>
				<td>Date of Birth</td>
				<td><?php echo ($row['dob']!='0000-00-00')?$row['dob']:'';?></td>
				<td>Freshers/Experienced</td>
				<td><?php echo $row['experience'];?></td>
			</tr>
			<tr>
				<td>Address</td>
				<td ><?php echo $row['address'];?></td>
				<td >Position Applied For</td>
				<td ><?php echo $row['position_name'];?></td>
			</tr>
		<?php endforeach;?>
			<tr>
				<td colspan="4" align="center" style="background-color: black;color: #FFF;font-size: 16px;">(For Offical Use)</td>
			</tr>
			<tr>
				<td rowspan="4" style="text-align:center;">Source</td>
				<td>Emp.Refferal</td>
				<td></td>
				<td rowspan="4" valign="top" style="text-align: center;text-decoration: underline;">Details of Source</td>
			</tr>
			<tr>
				<td>Consultant</td>
				<td></td>
			</tr>
			<tr>	
				<td>Walk in</td>
				<td></td>
			</tr>
			<tr>	
				<td>Any Other Source</td>
				<td></td>
			</tr>
		</table>
			<table style="border:hidden;width:100%;">
				<tr style="border:hidden">
					<td  style="background-color:black;color:#FFF;text-align: center;width: 40%;border:hidden"> Rating Factors( For Offical Use )</td>
					<td style="background-color:black;color:#FFF;text-align: center;width: 10%;border:hidden;">Yes</td>
					<td style="background-color:black;color:#FFF;text-align: center;width: 10%;border:hidden;">No</td>
					<td style="background-color:black;color:#FFF;text-align: center;width: 40%;border:hidden;">Hr Remarks</td>
				</tr>
				<tr>
					<td style="width: 40%;">Job Knowledge/Skill</td>
					<td style="width: 10%;"></td>
					<td style="width: 10%;"></td>
					<td rowspan="6" style="width: 40%;"></td>
				</tr>
				<tr>
					<td style="width: 40%;">Communication Skill/Spoken English</td>
					<td style="width: 10%;"></td>
					<td style="width: 10%;"></td>
				</tr>
				<tr>
					<td style="width: 40%;">Interpersonal/Convincing Skills</td>
					<td style="width: 10%;"></td>
					<td style="width: 10%;"></td>
				</tr>
				<tr>
					<td style="width: 40%;">Comprehension</td>
					<td style="width: 10%;"></td>
					<td style="width: 10%;"></td>
				</tr>
				<tr>
					<td style="width: 40%;">Analysticals Skill( Maths )</td>
					<td style="width: 10%;"></td>
					<td style="width: 10%;"></td>
				</tr>
				<tr>
					<td style="width: 40%;">Readiness For Shifts</td>
					<td style="width: 10%;"></td>
					<td style="width: 10%;"></td>
				</tr>
									
			
				
				<tr>
					<td colspan="2"  style="border: hidden;padding-top: 10px;">HR Recuiter Name-__________________________________________________</td>
					<td colspan="2"  style="border: hidden;padding-top: 10px;">HR Recuiter Signatures-__________________________________________</td>
				</tr>
				</table>
				<table style="border:hidden;;width:100%;">
					<tr style="border:hidden">
						<td  style="background-color:black;color:#FFF;text-align: center;width: 40%;border:hidden"> Rating Factors( For Offical Use )</td>
						<td style="background-color:black;color:#FFF;text-align: center;width: 10%;border:hidden;">Yes</td>
						<td style="background-color:black;color:#FFF;text-align: center;width: 10%;border:hidden;">No</td>
						<td style="background-color:black;color:#FFF;text-align: center;width: 40%;border:hidden;">Operations/Training Remarks</td>
					</tr>
					<tr>
						<td style="width: 40%;">Job Knowledge/Skill</td>
						<td style="width: 10%;"></td>
						<td style="width: 10%;"></td>
						<td rowspan="6" style="width: 40%;"></td>
					</tr>
					<tr>
						<td style="width: 40%;">Communication Skill/Spoken English</td>
						<td style="width: 10%;"></td>
						<td style="width: 10%;"></td>
					</tr>
					<tr>
						<td style="width: 40%;">Interpersonal/Convincing Skills</td>
						<td style="width: 10%;"></td>
						<td style="width: 10%;"></td>
					</tr>
					<tr>
						<td style="width: 40%;">Comprehension</td>
						<td style="width: 10%;"></td>
						<td style="width: 10%;"></td>
					</tr>
					<tr>
						<td style="width: 40%;">Analysticals Skill( Maths )</td>
						<td style="width: 10%;"></td>
						<td style="width: 10%;"></td>
					</tr>
					<tr>
						<td style="width: 40%;">Readiness For Shifts</td>
						<td style="width: 10%;"></td>
						<td style="width: 10%;"></td>
					</tr>
										
				<tr>
					<td colspan="2"  style="border: hidden;padding-top: 10px;">Operations/Training<br> Panel Name-______________________________________</td>
					<td colspan="2"  style="border: hidden;padding-top: 10px;">Operations/Training<br> Panel Signatures-___________________________________</td>
				</tr>
			</table>
			<table style="border:hidden;width:100%;">
				<tr style="border:hidden">
					<td  style="background-color:black;color:#FFF;text-align: center;width: 40%;border:hidden"> Rating Factors( For Offical Use )</td>
					<td style="background-color:black;color:#FFF;text-align: center;width: 10%;border:hidden;">Yes</td>
					<td style="background-color:black;color:#FFF;text-align: center;width: 10%;border:hidden;">No</td>
					<td style="background-color:black;color:#FFF;text-align: center;width: 40%;border:hidden;">Client Remarks</td>
				</tr>
				<tr>
					<td style="width: 40%;">Job Knowledge/Skill</td>
					<td style="width: 10%;"></td>
					<td style="width: 10%;"></td>
					<td rowspan="6" style="width: 40%;"></td>
				</tr>
				<tr>
					<td style="width: 40%;">Communication Skill/Spoken English</td>
					<td style="width: 10%;"></td>
					<td style="width: 10%;"></td>
				</tr>
				<tr>
					<td style="width: 40%;">Interpersonal/Convincing Skills</td>
					<td style="width: 10%;"></td>
					<td style="width: 10%;"></td>
				</tr>
				<tr>
					<td style="width: 40%;">Comprehension</td>
					<td style="width: 10%;"></td>
					<td style="width: 10%;"></td>
				</tr>
				<tr>
					<td style="width: 40%;">Analysticals Skill( Maths )</td>
					<td style="width: 10%;"></td>
					<td style="width: 10%;"></td>
				</tr>
				<tr>
					<td style="width: 40%;">Readiness For Shifts</td>
					<td style="width: 10%;"></td>
					<td style="width: 10%;"></td>
				</tr>
				<tr>
					<td colspan="2"  style="border: hidden;padding-top: 10px;">Client Name-_________________________________________________</td>
					<td colspan="2"  style="border: hidden;padding-top: 10px;">Client Signatures-____________________________________________</td>
				</tr>
			</table>
			<table style="border:hidden;width:100%;">
				<tr>
					<td colspan="4" style="background-color: black;color: #fff; text-align: center;">GENERAL ( For Official Use )</td>
				</tr>

				<tr>
					<td colspan="2">Typing/Aptitude test Score</td>
					<td colspan="2"></td>
				</tr>	
				<tr>
					<td colspan="2">Versant Test Score With Verssant Key</td>
					<td colspan="2"></td>
				</tr>
				<tr>
					<td colspan="2">Current Compensation( CTC )</td>
					<td colspan="2"></td>
				</tr>
				<tr>
					<td colspan="2">Local Contact Number( Landline )</td>
					<td colspan="2"></td>
				</tr>
			</table>
			<table style="border:hidden;width:100%;">
				<tr>
					<td colspan="4" style="background-color: black;color: #fff; text-align: center;">Final Observations ( For Official Use )</td>
				</tr>
			</table>
			<table style="border:hidden;width:100%;">
				<tr>
					<td style="width: 10%;">Selected/Hold/Reject</td>
					<td style="width: 25%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td style="width: 10%;">Salary Gross</td>
					<td style="width: 25%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td style="width: 10%;">DOJ</td>
					<td style="width: 20%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>
				<tr>
					<td style="width: 10%;">Position to be Offered</td>
					<td style="width: 25%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td style="width: 10%;">PLB( variable )</td>
					<td style="width: 25%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td style="width: 10%;">center</td>
					<td style="width: 20%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>
				<tr>
					<td colspan="6">Salary Approved By-</td>
				</tr>	
			</table>
					
			<table style="border:hidden;width: 100%;">
				<tr>
					<td style="width: 10%;background-color: black;color: #fff; text-align: center;">S.No</td>
					<td style="width:70%;background-color: black;color: #fff; text-align: center;">Declaration by the Candidate( Filled By Candidate)</td>
					<td style="width: 10%;background-color: black;color: #fff; text-align: center;">Yes</td>
					<td style="width: 10%;background-color: black;color: #fff; text-align: center;">No</td>
				</tr>
				<tr>
					<td style="width: 10%;">1</td>
					<td style="width:70%;">I am willing to work in flexible shifts which include evening shift also (if required)</td>
					<td style="width: 10%;"></td>
					<td style="width: 10%;"></td>
				</tr>
				<tr>
					<td style="width: 10%;">2</td>
					<td style="width:70%;">Have you ever worked in Competent</td>
					<td style="width: 10%;"></td>
					<td style="width: 10%;"></td>
				</tr>
				<tr>
					<td style="width: 10%;">3</td>
					<td style="width:70%;">Leave Required during first three month</td>
					<td style="width: 10%;"></td>
					<td style="width: 10%;"></td>
				</tr>
				<tr>
					<td style="width: 10%;">4</td>
					<td style="width:70%;">Are You Pursuing Regular/Correspondence Studies or Further Plan of Studies</td>
					<td style="width: 10%;"></td>
					<td style="width: 10%;"></td>
				</tr>
				<tr  style="border:hidden">
					<td colspan="1"  style="border:hidden"></td>
					<td colspan="3" rowspan="3"  style="border:hidden;padding-left: 25%;">Signature Of Candidate:_________________________________________________</td>
				</tr>
				<tr  style="border:hidden">
					<td colspan="1"  style="border:hidden"></td>
				</tr>
				<tr  style="border:hidden">
					<td colspan="1"  style="border:hidden"></td>
				</tr>			
			</table>
</div>