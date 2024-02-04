	<div>
		<h4 class="widget-title" align="center"><u>INTERVIEW ASSESSMENT FORM</u></h4>
	</div>
	
	<div>
		<table cellspacing="0" style="width:100%">
			<tr>
				<td style="border: 1px solid #000; text-align: left; padding:5px 2px;  width:170px; "><h6><b>NAME OF THE APPLICANT :</b></td>
				<td style="border: 1px solid #000; text-align: left; padding:5px 2px;  "><h6><?php echo strtoupper($candidate_details[0]['name']) ; ?></h6></td>
				<td style="border: 1px solid #000; text-align: left; padding:5px 2px;  width:155px;"><h6><b>POSITION APPLIED FOR :</b> </h6></td>
				<td style="border: 1px solid #000; text-align: left;"><h6><?php echo $candidate_details[0]['dept']; ?></h6></td>
			</tr>
			<tr>
				<td style="border: 1px solid #000; text-align: left; padding:5px 2px;   width:170px;"><h6><b>INTERVIEWER'S NAME :</b></h6></td>
				<td style="border: 1px solid #000; text-align: left; padding:5px 2px;  "></td>
				<td style="border: 1px solid #000; text-align: left; padding:5px 2px;  width:155px; "><h6><b>DATE & VENUE :</b></h6></td>
				<td style="border: 1px solid #000; text-align: left;"></td>
			</tr>
		</table>	
	</div>
	
	<br/>
	
	<div>
			<table cellspacing="0" cellpadding="0" style="display:table; width:100%;">
					
					
						<?php 
						
							$Params = array('Parameter','Education Training','Job Knowledge','Work Experience','Analytical Skill','Technical 	skill','General Awerness','Personality/Body language','Comfortable With english','MTI','Enthusiasm','Leader ship skill','Importance to customer','Motivation for the Job','Result/Target Orientation', 'Logic/Convinencing Power','Initative','Assertiveness','Decision making','Over all Assesment','Remarks','Interviewer');
							
							$fldArray = array('parameter','educationtraining_param','jobknowledge_param','workexperience_param','analyticalskills_param','technicalskills_param','generalawareness_param','bodylanguage_param','englishcomfortable_param','mti_param','enthusiasm_param','leadershipskills_param','customerimportance_param','jobmotivation_param','resultoriented_param','logicpower_param','initiative_param','assertiveness_param','decisionmaking_param','overall_assessment','interview_remarks','interviewer');
																	
							foreach($fldArray as $i => $fild){
								
								echo "<tr>";
									if($i==0) echo "<td style='width:170px; background-color: #35b8e0; color: #fff; padding:4px; font-size:11px; border: 1px solid #000; ' >".$Params[$i]."</td>";
									else echo "<td style='width:170px; padding:4px; font-size:11px; border: 1px solid #000; ' >".$Params[$i]."</td>";
									foreach($candidate_interview_details as $row){
										if($i==0) echo "<td style='display:table-cell; max-width:0px; text-align: center; background-color: #35b8e0; color: #fff; padding:4px; font-size:11px; border: 1px solid #000; ' >".$row[$fild]."</td>";
										else echo "<td style='display:table-cell; max-width:0px; text-align: center; padding:4px; font-size:11px; border: 1px solid #000;'>".$row[$fild]."</td>";
									}									
								echo "</tr>"; 
							}
																	
								?>
								
						
			</table>
	</div>
	
	<!-- <div style="page-break-after: always"><span style="display: none;">&nbsp;</span></div> -->
	
	<div>

		<div>
			<h4 class="widget-title" align="center">For HRD Purpose Only</h4>
		</div>
				
		<div>
			<table cellspacing="0" width="100%">
			 
				<tr>
					<td style="border: 1px solid #000; padding:5px; text-align: left;width:100px; font-size:11px; ">Site</td>
					<td style="border: 1px solid #000; padding:5px; text-align: left; "> </td>
					<td style="border: 1px solid #000; padding:5px; text-align: left; width:100px; font-size:11px; ">Reporting To</td>
					<td style="border: 1px solid #000; padding:5px; text-align: left;"> </td>
				</tr>
				<tr>
					<td style="border: 1px solid #000; padding:5px; text-align: left;width:100px; font-size:11px; ">Process</td>
					<td style="border: 1px solid #000; padding:5px; text-align: left;"></td>
					<td style="border: 1px solid #000; padding:5px; text-align: left;width:100px; font-size:11px; ">D.O.J</td>
					<td style="border: 1px solid #000; padding:5px; text-align: left;"></td>
				</tr>
				<tr>
					<td style="border: 1px solid #000; padding:5px; text-align: left;width:100px; font-size:11px;">Designation</td>
					<td style="border: 1px solid #000; padding:5px; text-align: left;"> </td>
					<td style="border: 1px solid #000; padding:5px; text-align: left;width:120px; font-size:11px; ">Gross Salary Offered</td>
					<td style="border: 1px solid #000; padding:5px; text-align: left;"> </td>
				</tr>
			
		</table>
		</div>
		
	</div>

	<br/>
	
	<div>
		<table cellspacing="0" width="100%">
						
			<thead>	 
			</thead>
			<tbody>
				<tr style="style=border: 1px solid #000; ">
					<td style="border: 1px solid #000; text-align: left;width:150px; height:100px; font-size:11px; padding:8px;">Remarks By Recuriter</td>
					<td style="border: 1px solid #000; text-align: left; "></td>
				</tr>
				<tr>
					<td style="border: 1px solid #000; text-align: left;width:150px; font-size:11px; padding:10px;">Date : </td>
					<td style="border: 1px solid #000; text-align: left; font-size:11px; padding:10px;">Signature : </td>
				</tr>
			</tbody>
		</table>
	</div>
				
