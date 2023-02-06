
<div class="wrap">
	<section class="app-content">

		<div class="row">
			<div class="col-12">

				<div class="widget">

					<div class="row">
						<div class="col-md-10">
							<header class="widget-header">
								<h4 class="widget-title">Search Your Feedback</h4>
							</header>
						</div>
						<hr class="widget-separator">
					</div>

					<div class="widget-body">

						<form id="form_new_user" method="GET" action="<?php echo base_url('Qa_ameridial/agent_amd_feedback'); ?>">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label>From Date (mm/dd/yyyy)</label>
										<input type="text" id="from_date" name="from_date" value="<?php echo mysql2mmddyy($from_date); ?>" class="form-control" readonly>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>To Date (mm/dd/yyyy)</label>
										<input type="text" id="to_date" name="to_date" value="<?php echo mysql2mmddyy($to_date); ?>" class="form-control" readonly>
									</div>
								</div>
								<div class="col-md-5">
									<div class="form-group">
										<label>Select Campaign</label>
										<select class="form-control" id="campaign" name="campaign" required>
											<option value="">--Select--</option>
											<option <?php echo $campaign=='fortunebuilder'?"selected":""; ?> value="fortunebuilder">Fortune Builder</option>
											<option <?php echo $campaign=='hoveround'?"selected":""; ?> value="hoveround">Hoveround</option>
											<option <?php echo $campaign=='ncpssm'?"selected":""; ?> value="ncpssm">NCPSSM</option>
											<option <?php echo $campaign=='stc'?"selected":""; ?> value="stc">STC Scoresheet</option>
											<option <?php echo $campaign=='touchfuse'?"selected":""; ?> value="touchfuse">Touchfuse</option>
											<option <?php echo $campaign=='touchfuse_new'?"selected":""; ?> value="touchfuse_new">Touchfuse New</option>
											<option <?php echo $campaign=='tbn'?"selected":""; ?> value="tbn">TBN Scoresheet</option>
											<option <?php echo $campaign=='purity_free_bottle'?"selected":""; ?> value="purity_free_bottle">Purity Free Bottle</option>
											<option <?php echo $campaign=='purity_catalog'?"selected":""; ?> value="purity_catalog">Purity Catalog</option>
											<option <?php echo $campaign=='purity_care'?"selected":""; ?> value="purity_care">Purity Care</option>
											<option <?php echo $campaign=='puritycare_new'?"selected":""; ?> value="puritycare_new">Purity Care New</option>
											<option <?php echo $campaign=='conduent'?"selected":""; ?> value="conduent">Conduent</option>
											<option <?php echo $campaign=='jfmi'?"selected":""; ?> value="jfmi">JFMI</option>
											<option <?php echo $campaign=='tpm'?"selected":""; ?> value="tpm">TPM Scoresheet</option>
											<option <?php echo $campaign=='patchology'?"selected":""; ?> value="patchology">Patchology Agent Improvement</option>
											<option <?php echo $campaign=='heatsurge'?"selected":""; ?> value="heatsurge">Heat Surge</option>
											<option <?php echo $campaign=='aspca'?"selected":""; ?> value="aspca">ASPCA Scoresheet</option>
											<option <?php echo $campaign=='ffai'?"selected":""; ?> value="ffai">Filter Fast Agent Improvement</option>
											<option <?php echo $campaign=='lifi'?"selected":""; ?> value="lifi">Life Quote(LIFI) QA evalution Form Scorecard</option>
											<option <?php echo $campaign=='stauers_sales'?"selected":""; ?> value="stauers_sales">Stauers Sales</option>
											<option <?php echo $campaign=='operation_smile'?"selected":""; ?> value="operation_smile">Operation Smile</option>
											<option <?php echo $campaign=='5_11_tactical'?"selected":""; ?> value="5_11_tactical">5-11 Tactical</option>
											<option <?php echo $campaign=='jmmi'?"selected":""; ?> value="jmmi">JMMI</option>
											<option <?php echo $campaign=='non_profit'?"selected":""; ?> value="non_profit">Non-Profit</option>
											<option <?php echo $campaign=='revel_new'?"selected":""; ?> value="revel_new">Icario</option>
											<option <?php echo $campaign=='ica_latest'?"selected":""; ?> value="ica_latest">Icario Latest</option> 
											<option <?php echo $campaign=='ica'?"selected":""; ?> value="ica">Icario New</option>
											<option <?php echo $campaign=='qpc'?"selected":""; ?> value="qpc">QPC</option>
											<option <?php echo $campaign=='ancient_nutrition'?"selected":""; ?> value="ancient_nutrition">Ancient Nutrition</option>
											<option <?php echo $campaign=='powerfan'?"selected":""; ?> value="powerfan">Power Fan</option>
											<option <?php echo $campaign=='blains'?"selected":""; ?> value="blains">BLAINS</option>
											<option <?php echo $campaign=='pajamagram'?"selected":""; ?> value="pajamagram">Pajamagram</option>
											<option <?php echo $campaign=='brightway_prescreen_new'?"selected":""; ?> value="brightway_prescreen_new">Brightway Prescreen</option>
											<!-- <option <?php echo $campaign=='brightway_prescreen'?"selected":""; ?> value="brightway_prescreen">Brightway Prescreen(Old)</option> -->
											<option <?php echo $campaign=='brightway_evaluation_new'?"selected":""; ?> value="brightway_evaluation_new">Brightway Evaluation</option>
											<option <?php echo $campaign=='brightway_evaluation'?"selected":""; ?> value="brightway_evaluation">Brightway Evaluation(Old)</option>
											<option <?php echo $campaign=='brightway_ib_bank'?"selected":""; ?> value="brightway_ib_bank">Brightway(IB Banks and Cancellation)</option>
											<option <?php echo $campaign=='offline'?"selected":""; ?> value="offline">Offline Qa</option>
											<option <?php echo $campaign=='phone_inbound'?"selected":""; ?> value="phone_inbound">Phone Inbound Qa</option>
											<option <?php echo $campaign=='phone_inbound_new'?"selected":""; ?> value="phone_inbound_new">Phone Inbound Qa New</option>
											<option <?php echo $campaign=='processing'?"selected":""; ?> value="processing">Processing Qa</option>
											<option <?php echo $campaign=='processing_new'?"selected":""; ?> value="processing_new">Processing Qa New</option>
											<option <?php echo $campaign=='airmethod'?"selected":""; ?> value="airmethod">Air Method</option>
											<option <?php echo $campaign=='airmethod_email'?"selected":""; ?> value="airmethod_email">Air Method Email</option>
											<option <?php echo $campaign=='foodsaver'?"selected":""; ?> value="foodsaver">Food Saver</option>
											<option <?php echo $campaign=='mercy_ship'?"selected":""; ?> value="mercy_ship">Mercy Ship</option>
											<option <?php echo $campaign=='ubp'?"selected":""; ?> value="ubp">UBP</option>
											<option <?php echo $campaign=='sabal'?"selected":""; ?> value="sabal">SABAL</option>
											<option <?php echo $campaign=='curative'?"selected":""; ?> value="curative">CURATIVE</option>
											<option <?php echo $campaign=='episource'?"selected":""; ?> value="episource">EPISOURCE</option>
											<option <?php echo $campaign=='delta'?"selected":""; ?> value="delta">DELTA DENTAL[ILLINOIS]</option>
											<option <?php echo $campaign=='delta_iowa'?"selected":""; ?> value="delta_iowa">DELTA DENTAL[IOWA]</option>
											<option <?php echo $campaign=='trapollo'?"selected":""; ?> value="trapollo">TRAPOLLO</option>
											<option <?php echo $campaign=='sontiq'?"selected":""; ?> value="sontiq">SONTIQ</option>
											<option <?php echo $campaign=='sas'?"selected":""; ?> value="sas">Specialty Answering Service (SAS)</option>
											<option <?php echo $campaign=='gap'?"selected":""; ?> value="gap">Great American Power</option>
											<option <?php echo $campaign=='suarez'?"selected":""; ?> value="suarez">Suarez</option>
											<option <?php echo $campaign=='sfe'?"selected":""; ?> value="sfe">SFE Scorecard</option>
											<option <?php echo $campaign=='pcare_cs'?"selected":""; ?> value="pcare_cs">Purity [Conscious Selling]</option>
											<option <?php echo $campaign=='mpc'?"selected":""; ?> value="mpc">MPC</option>
											<option <?php echo $campaign=='ab_commercial'?"selected":""; ?> value="ab_commercial">AB Commercial Offline</option>
											<?php if(get_user_office_id()=="ELS"){ ?>
												<option <?php echo $campaign=='qpc_esal'?"selected":""; ?> value="qpc_esal">QPC ESAL</option>
											<?php } ?>
											<option <?php echo $campaign=='empire'?"selected":""; ?> value="empire">Empire</option>
											<!-- <option <?php echo $campaign=='cinemark'?"selected":""; ?> value="cinemark">Cinemark</option> -->
											<option <?php echo $campaign=='hcpss'?"selected":""; ?> value="hcpss">HCPSS - Howard County Public School System</option>
											<option <?php echo $campaign=='cmn'?"selected":""; ?> value="cmn">CMN - Children Miracle Network</option>
											<option <?php echo $campaign=='pilgrim'?"selected":""; ?> value="pilgrim">Pilgrim</option>
											<option <?php echo $campaign=='bluebenefits'?"selected":""; ?> value="bluebenefits">Blue Benefits</option>
											<option <?php echo $campaign=='healthbridge'?"selected":""; ?> value="healthbridge">Health Bridge</option> 
											<option <?php echo $campaign=='healthbridgenew'?"selected":""; ?> value="healthbridgenew">Health Bridge New</option> 
											<option <?php echo $campaign=='compliance'?"selected":""; ?> value="compliance">Compliance</option>
											<option <?php echo $campaign=='mcKinsey'?"selected":""; ?> value="mcKinsey">McKinsey</option>
											<option <?php echo $campaign=='affinity'?"selected":""; ?> value="affinity">Affinity</option>
											<option <?php echo $campaign=='affinity_pro'?"selected":""; ?> value="affinity_pro">Affinity Provider</option>
											<option <?php echo $campaign=='cci_medicare'?"selected":""; ?> value="cci_medicare">CCI Medicare</option>
											<option <?php echo $campaign=='cci_commercial'?"selected":""; ?> value="cci_commercial">CCI Commercial</option>
											<option <?php echo $campaign=='lockheed'?"selected":""; ?> value="lockheed">Lockheed Martin</option>
											<option <?php echo $campaign=='homeward_health'?"selected":""; ?> value="homeward_health">Homeward Health</option>
											<option <?php echo $campaign=='kenny_u_pull'?"selected":""; ?> value="kenny_u_pull">Kenny-U-Pull</option>
											<option <?php echo $campaign=='ways2well'?"selected":""; ?> value="ways2well">Ways-2-Well</option>
										</select>
									</div>
								</div>
								<div class="col-md-1" style="margin-top:20px">
								    <button class="btn btn-success waves-effect" a href="<?php echo base_url()?>Qa_ameridial/agent_amd_feedback" type="submit" id='btnView' name='btnView' value="View">View</button>
								</div>
							</div>

						</form>

					</div>
				</div>

			</div>
		</div>


		<div class="row">
			<div class="col-12">
				<div class="widget">

				<?php if($campaign!=""){ ?>

					<div class="row">
						<div class="col-md-12">
							<header class="widget-header">
								<div class="col-md-6">
									<h4 class="widget-title"></h4>
								</div>
								<div class="col-md-6" style="float:right">
									<span style="font-weight:bold; color:red">Total Feedback</span> <span class="badge" style="font-size:12px"><?php echo $tot_feedback; ?></span> - <span style="font-weight:bold; color:green">Yet To Review</span> <span class="badge" style="font-size:12px"><?php echo $yet_rvw; ?></span>
								</div>
							</header>
						</div>
						<hr class="widget-separator">
					</div>

					<div class="widget-body">
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class="bg-info">
										<th>SL</th>
										<th>Auditor</th>
										<th>Audit Date</th>
										<th>Fusion ID</th>
										<th>Agent Name</th>
										<th>L1 Supervisor</th>
										
										<th>Total Score</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;
										foreach($agent_list as $row):
									?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $row['auditor_name']; ?></td>
										<td><?php echo $row['audit_date']; ?></td>
										<td><?php echo $row['fusion_id']; ?></td>
										<td><?php echo $row['fname']." ".$row['lname']; ?></td>
										<td><?php echo $row['tl_name']; ?></td>
										
										<td><?php echo $row['overall_score']."%"; ?></td>
										<td><?php echo $row['agent_rvw_date']; ?></td>
										<td><?php echo $row['mgnt_name']; ?></td>
										<td><?php echo $row['mgnt_rvw_date']; ?></td>
										<td>
											<?php $adid=$row['id']; ?>
												<a class="btn btn-success agentFeedback" href="<?php echo base_url(); ?>Qa_ameridial/agent_amd_rvw/<?php echo $adid ?>/<?php echo $campaign ?>" title="Click to Review" style="margin-left:5px; font-size:10px;">View/Review</a>
										</td>
									</tr>
									<?php endforeach; ?>
								</tbody>
								<tfoot>
									<tr class="bg-info">
										<th>SL</th>
										<th>Auditor</th>
										<th>Audit Date</th>
										<th>Fusion ID</th>
										<th>Agent Name</th>
										<th>L1 Supervisor</th>
										
										<th>Total Score</th>
										<th>Agent Review Date</th>
										<th>Mgnt Review By</th>
										<th>Mgnt Review Date</th>
										<th>Action</th>
									</tr>
								</tfoot>
							</table>
						</div>

					</div>

				<?php } ?>

				</div>
			</div>
		</div>

	</section>
</div>
