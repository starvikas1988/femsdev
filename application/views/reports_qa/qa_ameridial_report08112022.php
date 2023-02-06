<div class="wrap">
	<section class="app-content">

		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header"><h4 class="widget-title">QA AMERIDIAL Report</h4></header>
						</div>
						<hr class="widget-separator">
					</div>

					<div class="widget-body">
						<div class="row">
						  <form id="form_new_user" method="GET" action="<?php echo base_url('reports_qa/qa_ameridial_report'); ?>">
						  <?php echo form_open('',array('method' => 'get')) ?>

							<div class="col-md-4">
								<div class="form-group">
									<label>Search Date From - Audit Date (mm/dd/yyyy)</label>
									<input type="text" id="from_date" name="from_date" value="<?php echo mysql2mmddyy($from_date); ?>" class="form-control" required autocomplete="off">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Search Date To - Audit Date (mm/dd/yyyy)</label>
									<input type="text" id="to_date" name="to_date" value="<?php echo mysql2mmddyy($to_date); ?>" class="form-control" required autocomplete="off">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="office_id">Select a Location</label>
									<select class="form-control" name="office_id" id="foffice_id" >
										<option value='All'>ALL</option>
										<?php foreach($location_list as $loc):
											$sCss="";
											if($loc['abbr']==$office_id) $sCss="selected";
											?>
										<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>><?php echo $loc['office_name']; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">

							<div class="col-md-5">
								<div class="form-group">
									<label>Select Process</label>
									<select class="form-control" name="p_id" id="process_id" required>
										<option value=''>-Select Campaign-</option>
										<?php if(get_login_type() == "client"){
											
											if(get_clients_process_id()==377){ ?>
												<option <?php echo $process_id=='377.1'?"selected":""; ?> value="377.1">Brightway Prescreen(Old)</option>
												<option <?php echo $process_id=='377.2'?"selected":""; ?> value="377.2">Brightway Prescreen</option>
												<option <?php echo $process_id=='377.3'?"selected":""; ?> value="377.3">Brightway Evaluation(Old)</option>
												<option <?php echo $process_id=='377.4'?"selected":""; ?> value="377.4">Brightway Evaluation</option>
												<option <?php echo $process_id=='377.5'?"selected":""; ?> value="377.5">Brightway(IB Banks and Cancellation)</option>
												<option <?php echo $process_id=='offline'?"selected":""; ?> value="offline">Offline Qa</option>
												<option <?php echo $process_id=='phone_inbound'?"selected":""; ?> value="phone_inbound">Phone Inbound Qa</option>
												<option <?php echo $process_id=='processing'?"selected":""; ?> value="processing">Processing Qa</option>
										<?php }else{
											
												$qa_menu=get_client_qa_menu();
												foreach($qa_menu as $menu){
													$usrpid=$menu['id'];
													$sel="";
													if($process_id == $usrpid) $sel="selected";
													echo "<option value='".$usrpid."' $sel>".$menu['name']."</option>";
												}
												
											}
										
										}else{ ?>
											<option <?php echo $process_id=='fortunebuilder'?"selected":""; ?> value="fortunebuilder">Fortune Builder</option>
											<option <?php echo $process_id=='hoveround'?"selected":""; ?> value="hoveround">Hoveround</option>
											<option <?php echo $process_id=='ncpssm'?"selected":""; ?> value="ncpssm">NCPSSM</option>
											<option <?php echo $process_id=='stc'?"selected":""; ?> value="stc">STC Scoresheet</option>
											<option <?php echo $process_id=='touchfuse'?"selected":""; ?> value="touchfuse">Touchfuse</option>
											<option <?php echo $process_id=='touchfuse_new'?"selected":""; ?> value="touchfuse_new">Touchfuse New</option>
											<option <?php echo $process_id=='tbn'?"selected":""; ?> value="tbn">TBN Scoresheet</option>
											<option <?php echo $process_id=='275'?"selected":""; ?> value="275">Purity Free Bottle</option>
											<option <?php echo $process_id=='280'?"selected":""; ?> value="280">Purity Catalog</option>
											<!--<option <?php echo $process_id=='purity_care'?"selected":""; ?> value="purity_care">Purity Care</option>-->
											<option <?php echo $process_id=='273'?"selected":""; ?> value="273">Purity Care</option>
											<option <?php echo $process_id=='261'?"selected":""; ?> value="261">Conduent</option>
											<option <?php echo $process_id=='pcare_cs'?"selected":""; ?> value="pcare_cs">Purity [Conscious Selling]</option>
											<option <?php echo $process_id=='jfmi'?"selected":""; ?> value="jfmi">JFMI</option>
											<option <?php echo $process_id=='tpm'?"selected":""; ?> value="tpm">TPM Scoresheet</option>
											<option <?php echo $process_id=='patchology'?"selected":""; ?> value="patchology">Patchology Agent Improvement</option>
											<option <?php echo $process_id=='heatsurge'?"selected":""; ?> value="heatsurge">Heat Surge</option>
											<option <?php echo $process_id=='aspca'?"selected":""; ?> value="aspca">ASPCA Scoresheet</option>
											<option <?php echo $process_id=='ffai'?"selected":""; ?> value="ffai">Filter Fast Agent Improvement Form Scorecard</option>
											<option <?php echo $process_id=='lifi'?"selected":""; ?> value="lifi">Life Quote(LIFI) QA evalution Form Scorecard</option>
											<option <?php echo $process_id=='stauers_sales'?"selected":""; ?> value="stauers_sales">Stauers Sales</option>
											<option <?php echo $process_id=='operation_smile'?"selected":""; ?> value="operation_smile">Operation Smile</option>
											<option <?php echo $process_id=='5_11_tactical'?"selected":""; ?> value="5_11_tactical">5-11 Tactical</option>
											<option <?php echo $process_id=='jmmi'?"selected":""; ?> value="jmmi">JMMI</option>
											<option <?php echo $process_id=='non_profit'?"selected":""; ?> value="non_profit">Non-Profit</option>
											<option <?php echo $process_id=='303'?"selected":""; ?> value="303">Icario</option>
											<option <?php echo $process_id=='icario'?"selected":""; ?> value="icario">Icario New</option>
											<option <?php echo $process_id=='ica'?"selected":""; ?> value="ica">Icario New 2</option>
											<option <?php echo $process_id=='272'?"selected":""; ?> value="272">QPC</option>
											<option <?php echo $process_id=='ancient_nutrition'?"selected":""; ?> value="ancient_nutrition">Ancient Nutrition</option>
											<option <?php echo $process_id=='powerfan'?"selected":""; ?> value="powerfan">Power Fan</option>
											<option <?php echo $process_id=='sabal'?"selected":""; ?> value="sabal">SABAL</option>
											<option <?php echo $process_id=='302'?"selected":""; ?> value="302">CURATIVE</option>
											<option <?php echo $process_id=='episource'?"selected":""; ?> value="episource">EPISOURCE</option>
											<option <?php echo $process_id=='blains'?"selected":""; ?> value="blains">BLAINS</option>
											<option <?php echo $process_id=='413'?"selected":""; ?> value="413">Pajamagram</option>
											<option <?php echo $process_id=='377.1'?"selected":""; ?> value="377.1">Brightway Prescreen(Old)</option>
											<option <?php echo $process_id=='377.2'?"selected":""; ?> value="377.2">Brightway Prescreen</option>
											<option <?php echo $process_id=='377.3'?"selected":""; ?> value="377.3">Brightway Evaluation(Old)</option>
											<option <?php echo $process_id=='377.4'?"selected":""; ?> value="377.4">Brightway Evaluation</option>
											<option <?php echo $process_id=='377.5'?"selected":""; ?> value="377.5">Brightway(IB Banks and Cancellation)</option>
											<option <?php echo $process_id=='offline'?"selected":""; ?> value="offline">Offline Qa</option>
											<option <?php echo $process_id=='phone_inbound'?"selected":""; ?> value="phone_inbound">Phone Inbound Qa</option>
											<option <?php echo $process_id=='phone_inbound_new'?"selected":""; ?> value="phone_inbound_new">Phone Inbound Qa New</option>
											<option <?php echo $process_id=='processing'?"selected":""; ?> value="processing">Processing Qa</option>
											<option <?php echo $process_id=='processing_new'?"selected":""; ?> value="processing_new">Processing Qa New</option>
											<option <?php echo $process_id=='262'?"selected":""; ?> value="262">Delta Dental [ILLINOIS]</option>
											<option <?php echo $process_id=='delta_iowa'?"selected":""; ?> value="delta_iowa">Delta Dental [IOWA]</option>
											<option <?php echo $process_id=='443'?"selected":""; ?> value="443">TRAPOLLO</option>
											<option <?php echo $process_id=='465'?"selected":""; ?> value="465">SONTIQ</option>
											<option <?php echo $process_id=='airmethod'?"selected":""; ?> value="airmethod">Air Method</option>
											<option <?php echo $process_id=='airmethod_email'?"selected":""; ?> value="airmethod_email">Air Method Email</option>
											<option <?php echo $process_id=='foodsaver'?"selected":""; ?> value="foodsaver">Food Saver</option>
											<option <?php echo $process_id=='ubp'?"selected":""; ?> value="ubp">UBP</option>
											<option <?php echo $process_id=='471'?"selected":""; ?> value="471">SAS</option>
											<option <?php echo $process_id=='473'?"selected":""; ?> value="473">GAP</option>
											<option <?php echo $process_id=='suarez'?"selected":""; ?> value="suarez">Suarez</option>
											<option <?php echo $process_id=='488'?"selected":""; ?> value="488">SFE Scorecard</option>
											<option <?php echo $process_id=='mpc'?"selected":""; ?> value="mpc">MPC</option>
											<option <?php echo $process_id=='qpc_esal'?"selected":""; ?> value="qpc_esal">QPC ESAL</option>
											<option <?php echo $process_id=='ab_commercial'?"selected":""; ?> value="ab_commercial">AB Commercial Offline</option>
											<option <?php echo $process_id=='empire'?"selected":""; ?> value="empire">Empire</option>
											<option <?php echo $process_id=='cinemark'?"selected":""; ?> value="cinemark">Cinemark</option>
											<option <?php echo $process_id=='hcpss'?"selected":""; ?> value="hcpss">HCPSS - Howard County Public School System</option>
											<option <?php echo $process_id=='cmn'?"selected":""; ?> value="cmn">CMN - Children Miracle Network</option>
											<option <?php echo $process_id=='pilgrim'?"selected":""; ?> value="pilgrim">Pilgrim</option>
											<option <?php echo $process_id=='bluebenefits'?"selected":""; ?> value="bluebenefits">Blue Benefits</option>
											<option <?php echo $process_id=='healthbridge'?"selected":""; ?> value="healthbridge">Health Bridge</option>
											<option <?php echo $process_id=='healthbridgenew'?"selected":""; ?> value="healthbridgenew">Health Bridge New</option>
											<option <?php echo $process_id=='compliance'?"selected":""; ?> value="compliance">Compliance</option>
											<option <?php echo $process_id=='mcKinsey'?"selected":""; ?> value="mcKinsey">mcKinsey</option>
											<option <?php echo $process_id=='affinity'?"selected":""; ?> value="affinity">Affinity</option>
											<option <?php echo $process_id=='affinity_pro'?"selected":""; ?> value="affinity_pro">Affinity Provider</option>
											<option <?php echo $process_id=='cci_medicare'?"selected":""; ?> value="cci_medicare">CCI Medicare</option>
											<option <?php echo $process_id=='cci_commercial'?"selected":""; ?> value="cci_commercial">CCI Commercial</option>
											<option <?php echo $process_id=='lockheed'?"selected":""; ?> value="lockheed">Lockheed</option>
											<option <?php echo $process_id=='754'?"selected":""; ?> value="754">Homeward Health</option>
											<option <?php echo $process_id=='756'?"selected":""; ?> value="756">Kenny-U-Pull</option>

										<?php } ?>

									</select>
								</div>
							</div>


							<div class="col-md-1" style='margin-top:22px;'>
								<div class="form-group">
									<button class="btn btn-primary waves-effect" a href="<?php echo base_url()?>reports_qa/qa_ameridial_report" type="submit" id='show' name='show' value="Show">SHOW</button>
								</div>
							</div>

							<?php if($download_link!=""){ ?>
								<div style='float:right; margin-top:25px;' class="col-md-1">
									<div class="form-group" style='float:right;'>
										<a href='<?php echo $download_link; ?>'> <span style="padding:12px;" class="label label-success">Export Report</span></a>
									</div>
								</div>
							<?php } ?>

						  </form>
						</div>


						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
										<th>SL</th>
										<th>Auditor</th>
										<th>Audit Date</th>
										<th>Fusion ID</th>
										<th>Agent Name</th>
										<th>L1 Supervisor</th>
										<th>Call Date</th>
										<th>Call Duration</th>
										<th>Total Score</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$i=1;
										foreach($qa_ameridial_list as $row){
									?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['auditor_name']; ?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										<td><?php echo $row['call_date']; ?></td>
										<td>
											<?php
												if($process_id == "purity_care")
												{
													$call_duration_str	=	"";
													if($row['call_one_call_duration'] != "")
													{
														$call_duration_str	.=	"Call One-".$row['call_one_call_duration'];
													}
													if($row['call_two_call_duration'] != "")
													{
														$call_duration_str	.=	",Call Two-".$row['call_two_call_duration'];
													}
													if($row['call_three_call_duration'] != "")
													{
														$call_duration_str	.=	",Call Three-".$row['call_three_call_duration'];
													}
													echo ltrim($call_duration_str,",");
												}
												else
												{
													echo $row['call_duration'];
												}
											?>
										</td>
										<td><?php echo $row['overall_score']."%"; ?></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>


					</div>

				</div>
			</div>
		</div>

	</section>
</div>
