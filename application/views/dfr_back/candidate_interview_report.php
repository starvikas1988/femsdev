<style>
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:5px;
		font-size:11px;
		border: 1px solid #E2E2E2;
	}
		
</style>

	<div class="wrap">
				<section class="app-content">
					<div class="row">
						<div class="col-md-12">
							<div class="widget">
								<header class="widget-header">
									<h4 class="widget-title" align="center">INTERVIEW ASSESSMENT FORM</h4>
									
								<div style="float:right; margin-top:-25px; margin-right:20px">
									<form id='f1' method="post" action="<?php echo base_url();?>dfr/interview_pdf/<?php echo $c_id ;?>" target="_blank">
										<button type="submit" class="form-controll btn btn-info" >Dowload PDF</button>
									</form>
								</div>
							
								</header>
								<hr class="widget-separator">
								
								<div class="widget-body">
									<div class="row">
										<div class="col-md-6">
											<h6><b>NAME OF THE APPLICATNT :</b> <?php echo strtoupper($candidate_details[0]['can_name']) ; ?></h6>
										</div>
										<div class="col-md-6">
											<h6><b>POSITION APPLIED FOR :</b> <?php echo $candidate_details[0]['dept']; ?></h6>
										</div> 
									</div>
									<div class="row">  
										<div class="col-md-6">
											<h6><b>INTERVIEWER'S NAME :</b> <?=isset($candidate_details[0]['interviewer_name'])?$candidate_details[0]['interviewer_name']:''?></h6>
										</div>
										<div class="col-md-6">
											<h6><b>DATE & VENUE  :</b><?=(isset($candidate_details[0]['interview_date'])?$candidate_details[0]['interview_date']:'').' '.$candidate_details[0]['pool_location'] ?> </h6>
										</div>
										
									</div>
								</div>
								
							</div>
						</div>	
					</div>
				</section>
	
				<section class="app-content">
					<div class="row">
						<div class="col-md-12">
							<div class="widget">
								<header class="widget-header">
									<h4 class="widget-title">Manage Requisition</h4>
								</header>
								<hr class="widget-separator">
								
								<div class="widget-body">
								
									<div class="table-responsive">
										<table id="default-datatable" style="display:table; width:100%;" data-plugin="DataTable" class="table table-striped " cellspacing="0">
										
									<?php 
									
										$Params = array('Parameter','Education Training','Job Knowledge','Work Experience','Analytical Skill','Technical 	skill','General Awareness','Personality/Body language','Comfortable With English','MTI','Enthusiasm','Leader ship skill','Importance to customer','Motivation for the Job','Result/Target Orientation', 'Logic/Convincing Power','Initiative','Assertiveness','Decision making','Overall Assessment','Remarks','Interviewer');
										
										$fldArray = array('parameter','educationtraining_param','jobknowledge_param','workexperience_param','analyticalskills_param','technicalskills_param','generalawareness_param','bodylanguage_param','englishcomfortable_param','mti_param','enthusiasm_param','leadershipskills_param','customerimportance_param','jobmotivation_param','resultoriented_param','logicpower_param','initiative_param','assertiveness_param','decisionmaking_param','overall_assessment','interview_remarks','interviewer');	
																				
										foreach($fldArray as $i => $fild){
											
											echo "<tr>";
												if($i==0) echo "<td style='width:200px; background-color: #35b8e0; color: #fff;' >".$Params[$i]."</td>";
												else echo "<td style='width:200px; ' >".$Params[$i]."</td>";
												foreach($candidate_interview_details as $row){
													if($i==0) echo "<td style='display:table-cell; max-width:0px; text-align: center; background-color: #35b8e0; color: #fff;' >".$row[$fild]."</td>";
													else echo "<td style='display:table-cell; max-width:0px; text-align: center;'>".$row[$fild]."</td>";
												}									
											echo "</tr>"; 
										}
										
									?>
										
											
											
										</table>
									</div>
								</div>
								
							</div>
						</div>	
					</div>
				</section>
	
				<section class="app-content">
					<div class="row">
						<div class="col-md-12">
							<div class="widget">
								<header class="widget-header">
									<h4 class="widget-title" align="center">For HRD Purpose Only</h4>
								</header>
								<hr class="widget-separator">
								<div class="widget-body">
									<div class="table-responsive">
										<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
										
											<thead>	 
											</thead>
											<tbody>
												<tr>
													<td style="width:150px;">Site</td>
													<td style="background-color:white"></td>
													<td style="width:150px;">Reporting To</td>
													<td style="background-color:white"></td>
												<tr>
												<tr>
													<td style="width:150px;">Process</td>
													<td style="background-color:white"></td>
													<td style="width:150px;">D.O.J</td>
													<td style="background-color:white"></td>
												<tr>
												<tr>
													<td style="width:150px;">Designation</td>
													<td style="background-color:white"></td>
													<td style="width:150px;">Gross Salary Offered</td>
													<td style="background-color:white"></td>
												<tr>
											</tbody>
										</table>
									</div>
								
								</div>
							</div>	
						</div>
					</div>
				</section>
				
				<section class="app-content">
					<div class="row">
						<div class="col-md-12">
							<div class="widget">
								<header class="widget-header">
									<h4 class="widget-title" align="center">For HRD Purpose Only</h4>
								</header>
								<hr class="widget-separator">
								<div class="widget-body">
									<div class="table-responsive">
										<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
										
											<thead>	 
											</thead>
											<tbody>
												<tr>
													<td style="width:150px; height:150px">Remarks By Recuriter:</td>
													<td style="background-color:white"></td>
												<tr>
												<tr>
													<td style="width:150px;">Date:</td>
													<td style="background-color:white">Signature:</td>
												<tr>
											</tbody>
										</table>
									</div>
								
								</div>
							</div>	
						</div>
					</div>
				</section>
				
	</div>
 
