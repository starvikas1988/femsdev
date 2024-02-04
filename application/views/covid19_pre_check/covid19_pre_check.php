
<style>
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:2px;
		/*text-align: left;*/
		font-size:14px
	}
</style>


<div class="wrap">
	<section class="app-content">
				
	
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Covid-19 PRELIMINARY CHECK-IN</h4>
					</header>
					<hr class="widget-separator">
					
					<?php if(!empty($preCovidList)){ ?>	
						<div class="widget-body">
							<div class="table-responsive">
								<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
									<thead>
										<tr class='bg-info'>
											<th>SL</th>
											<th>Fusion ID</th>
											<th>Name</th>
											<th>Location</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php $i=1; 
										foreach($preCovidList as $row){ ?>
										<tr>
											<td><?php echo $i++; ?></td>
											<td><?php echo $row['fusion_id']; ?></td>
											<td><?php echo $row['fname']." ".$row['lname'] ?></td>
											<td><?php echo $row['office_id'] ?></td>
											<?php 
												if($row['status']==1){ 
													echo '<td>Successfully Submitted</td>';
												}
											?>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					
					<?php }else{ ?>
					
						<div class="widget-body">
							<form class="checkPreCovid19" method="POST">
							
								<div class="row">
									<div class="col-md-3 form-group">NAME OF EMPLOYEE:</div>
									<div class="col-md-9 form-group"><input type="text" class="form-control" value="<?php echo $userstat['fname']." ".$userstat['lname'] ?>" disabled></div>
								</div>
								<div class="row">
									<div class="col-md-3 form-group">PROCESS:</div>
									<div class="col-md-9 form-group"><input type="text" class="form-control" value="<?php echo $userstat['clientName']." - ".$userstat['processName'] ?>" disabled></div>
								</div>
								<div class="row">
									<div class="col-md-3 form-group">AGE:</div>
									<div class="col-md-9 form-group"><input type="text" class="form-control" value="<?php echo $userstat['age']." Years" ?>" disabled></div>
								</div>
								<div class="row">
									<div class="col-md-3 form-group">PRESENT ADDRESS:</div>
									<div class="col-md-9 form-group"><input type="text" class="form-control" value="<?php echo $userstat['address_present'] ?>" disabled></div>
								</div> </br>
								
								<div class="row">
									<div class="col-md-12 form-group"><b>PRE-EXISTING MEDICAL CONDITIONS AND PREDISPOSITIONS:</b> &nbsp Please check if you have any of these.</div>
								</div>
								<div class="row">
									<div class="col-md-12 form-group"><input type="checkbox" class="medical" id="" name="pre_exist_asthma" value="Asthma"> &nbsp Asthma</div>
								</div>
								<div class="row">
									<div class="col-md-12 form-group"><input type="checkbox" class="medical" id="" name="pre_exist_hyper" value="Hypertension"> &nbsp Hypertension</div>
								</div>
								<div class="row">
									<div class="col-md-12 form-group"><input type="checkbox" class="medical" id="" name="pre_exist_transmit" value="Sexually transmitted infections"> &nbsp Sexually transmitted infections</div>
								</div>
								<div class="row">
									<div class="col-md-12 form-group"><input type="checkbox" class="medical" id="" name="pre_exist_diabates" value="Diabetes Mellitus"> &nbsp Diabetes Mellitus</div>
								</div>
								<div class="row">
									<div class="col-md-3 form-group"><input type="checkbox" class="medical" id="pre_exist_pregnant" name="pre_exist_pregnant" value="Pregnancy"> &nbsp Pregnancy (State the age of gestation)</div>
									<div class="col-md-9 form-group"><input type="text" class="form-control preg" id="pre_exist_pregnant_text" name="pre_exist_pregnant_text" placeholder="write here..."></div>
								</div>
								<div class="row">
									<div class="col-md-3 form-group"><input type="checkbox" class="medical" id="pre_exist_disease" name="pre_exist_disease" value="OTHER DISEASE"> &nbsp OTHER DISEASE(Please specify)</div>
									<div class="col-md-9 form-group"><input type="text" class="form-control disea" id="pre_exist_disease_text" name="pre_exist_disease_text" placeholder="write here..."></div>
								</div>
								<div class="row">
									<div class="col-md-12 form-group"><input type="checkbox" class="medical" id="" name="pre_exist_exposer" value="Confirmed COVID-19 case exposure"> &nbsp Has exposure to a confirmed COVID-19 case?</div>
								</div>
								<div class="row">
									<div class="col-md-12 form-group"><input type="checkbox" class="medical" id="" name="pre_exist_contact" value="Contact with anyone having fever, cough, colds, and sore throat for the past 2 weeks"> &nbsp Has contact with anyone having fever, cough, colds, and sore throat for the past 2 weeks?</div>
								</div>
								<div class="row">
									<div class="col-md-12 form-group"><input type="checkbox" class="medical" id="pre_exist_none" name="pre_exist_none" value="None of the above"> &nbsp NONE OF THE ABOVE</div>
								</div> </br>
								
								<div class="row">
									<div class="col-md-12 form-group"><b>SYMPTOMS CHECK:</b> Please check if you are experiencing any of these at present. Manifestation of two (2) or more symptoms would require you to seek medical consultation to your respective Barangay Health Centers and secure your eventual quarantine certificate/ Fit-to-work clearance which is needed to present upon your return to office operations.</div>
								</div>
								<div class="row">
									<div class="col-md-3 form-group"><input type="checkbox" class="symptom" id="symptoms_fever" name="symptoms_fever" value="Fever"> &nbsp Fever; for how long?</div>
									<div class="col-md-9 form-group"><input type="text" class="form-control" id="fever_how_long" name="fever_how_long" placeholder="write here..."></div>
								</div>
								<div class="row">
									<div class="col-md-12 form-group"><input type="checkbox" class="symptom" id="" name="symptoms_headache" value="Headache"> &nbsp Headache</div>
								</div>
								<div class="row">
									<div class="col-md-12 form-group"><input type="checkbox" class="symptom" id="" name="symptoms_muscle" value="Muscle pain"> &nbsp Muscle pain</div>
								</div>
								<div class="row">
									<div class="col-md-12 form-group"><input type="checkbox" class="symptom" id="" name="symptoms_fgatigue" value="Fatigue"> &nbsp Fatigue</div>
								</div>
								<div class="row">
									<div class="col-md-3 form-group"><input type="checkbox" class="symptom" id="symptoms_cough" name="symptoms_cough" value="Cough"> &nbsp Cough; for how long?</div>
									<div class="col-md-9 form-group"><input type="text" class="form-control" id="cough_how_long" name="cough_how_long" placeholder="write here..."></div>
								</div>
								<div class="row">
									<div class="col-md-12 form-group"><input type="checkbox" class="symptom" id="" name="symptoms_cold" value="Colds"> &nbsp Colds</div>
								</div>
								<div class="row">
									<div class="col-md-12 form-group"><input type="checkbox" class="symptom" id="" name="symptoms_breath" value="Shortness of breath"> &nbsp Shortness of breath</div>
								</div>
								<div class="row">
									<div class="col-md-12 form-group"><input type="checkbox" class="symptom" id="" name="symptoms_dificult_breath" value="Difficulty of breathing"> &nbsp Difficulty of breathing</div>
								</div>
								<div class="row">
									<div class="col-md-12 form-group"><input type="checkbox" class="symptom" id="" name="symptoms_throat" value="Sore throat"> &nbsp Sore throat</div>
								</div>
								<div class="row">
									<div class="col-md-12 form-group"><input type="checkbox" class="symptom" id="" name="symptoms_nausea" value="Nausea and Vomiting"> &nbsp Nausea and Vomiting</div>
								</div>
								<div class="row">
									<div class="col-md-12 form-group"><input type="checkbox" class="symptom" id="" name="symptoms_diarrhea" value="Diarrhea"> &nbsp Diarrhea</div>
								</div>
								<div class="row">
									<div class="col-md-12 form-group"><input type="checkbox" class="symptom" id="" name="symptoms_abdominal" value="Abdominal pain"> &nbsp Abdominal pain</div>
								</div>
								<div class="row">
									<div class="col-md-12 form-group"><input type="checkbox" class="symptom" id="" name="symptoms_loss_taste" value="Loss of taste"> &nbsp Loss of taste</div>
								</div>
								<div class="row">
									<div class="col-md-12 form-group"><input type="checkbox" class="symptom" id="" name="symptoms_loss_smell" value="Loss of smell"> &nbsp Loss of smell</div>
								</div>
								<div class="row">
									<div class="col-md-12 form-group"><input type="checkbox" class="symptom" id="" name="symptoms_none" value="None of the above"> &nbsp NONE OF THE ABOVE</div>
								</div> </br>
								
								<div class="row">
									<div class="col-md-12 form-group"><input type="checkbox" id="" name="status" value="1" required> &nbsp <b>NOTE:</b> I ACKNOWLEDGE AND CERTIFY THAT THE ABOVE INFORMATION ARE TRUE, AND I FULLY UNDERSTAND THE PURPOSE OF THE COVID-19 PRELIMINARY CHECK-IN AS REQUISITE FOR MY RETURN TO OFFICE. FALSIFICATION OF ABOVE DETAILS WILL LEAD TO AN ADMINISTRATIVE CASE WHICH WILL BE DEALT ACCORDINGLY BY HR DEPARTMENT. I SIGN IT OF MY OWN FREE WILL.</div>
								</div> </br>
								
								<div class="row">
									<div class="col-md-12 form-group"><input class="btn btn-success waves-effect" id="covid19" type="submit" name="submit" value="SUBMIT"></div>
								</div>
								
							</form>
						</div>
						
					<?php } ?>
					
				</div>
			</div>
		</div>
		
	</section>
</div>	