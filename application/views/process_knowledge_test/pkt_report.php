<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/custom.css"/>


<div class="wrap">
	<section class="app-content">
		<div class="widget">
			<div class="widget-body compute-widget">
				<h4>PKT Report</h4>
				<hr class="widget-separator">
				<div class="common-top">
					<div class="filter-widget">
					<?php echo form_open('',array('id'=>'myform','method'=>'get','enctype'=>"multipart/form-data")) ?>
						<div class="row">				
							<div class="col-sm-3">
								<div class="form-group">
									<label>From Date</label>
									<input type='date' name="from_date" id="from_date" value="<?php echo $from_date;?>" class="form-control">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>To Date</label>
									<input type='date' name="to_date" id="to_date" value="<?php echo $to_date;?>" class="form-control">
								</div>
							</div>
						<!--	<div class="col-sm-3">
								 <div class="form-group">
                                    <label>PKT Type</label><span style="color:#FF0000">*</span>
									<?php 
										//$sel1=$sel2 =$sel3="";
										//  if($pkt_type=='NHT') $sel1 = 'selected';
										//  if($pkt_type=='monthly') $sel2 = 'selected';
										//  if($pkt_type=='dipcheck') $sel3 = 'selected';
										 
									?>
                                    <select id="pkt_type" name="pkt_type" class="form-control" required>
                                        <option value="">--Select PKT Exam Type--</option>
                                        <option value="NHT" <?php //echo $sel1;?>>NHT PKT</option>
                                        <option value="monthly" <?php //echo $sel2;?>>Monthly PKT</option>
                                        <option value="dipcheck" <?php //echo $sel3;?>>Dip Check PKT</option>
                                    </select>
                                </div>
							</div>-->
							
							
							<div class="col-sm-12">
								<div class="form-group">
									<button type="submit" name="submit" value="submit" class="submit-btn">							
										Submit
									</button>
								</div>
								
							</div>
							
						</div>
					</form>
					</div>					
				</div>
			</div>
			
		</div>
		
		<div class="common-top">			
			<div class="widget">
				<div class="widget-body">
					<div class="filter-widget">
						<FORM action="<?php echo base_url();?>process_knowledge_test/download_pkt_report" method="POST">
							<div class="row pull-right">				
								
										<input type='hidden' name="from_date" id="from_date" value="<?php echo $from_date;?>" class="form-control">
										<input type='hidden' name="to_date" id="to_date" value="<?php echo $to_date;?>" class="form-control">
										<input type='hidden' name="pkt_type" id="pkt_type" value="<?php echo $pkt_type;?>" class="form-control">
									  <div class="col-sm-12">
										<div class="form-group">
											<!--<button type="submit" name="submit" value="submit" class="submit-btn">							
												Download Report
											</button>-->
										</div>
									  </div>
							   
							</div>
						</form>
					</div>
					<div class="table-small table-bg">
						<table class="table table-bordered table-striped table-responsive">
							<thead>
								<tr>
									<th>Agent Name</th>
									<th>Emp. ID</th>
									<th>Tool ID</th>
									<th>TL Name</th>
									<th>Exam Name</th>
									<th>Exam given Date</th>
									<th>Score Obtained(%)</th>
									<th>Pass/Fail Status</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($details as $info){?>
								<?php $pass_fail_status = (($info['score']/$info['total_score'])*100);?>
								<tr>
									<td><?php echo $info['name'];?></td>
									<td><?php echo $info['xpoid'];?></td>
									<td><?php echo $info['fusion_id'];?></td>
									<td><?php echo $info['tl_name'];?></td>
									<td><?php echo $info['exam_name'];?></td>
									<td><?php echo mysql2mmddyy($info['exam_given_on']);?></td>
									<td><?php echo number_format(($info['score']/$info['total_score'])*100,2).'%';?></td>
									<td><?php if($pass_fail_status<85){
										echo "FAIL";
									}else{
										echo "PASS";
									}?></td>
								</tr>
								
								<?php }?>
								
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		
	</section>
</div>
