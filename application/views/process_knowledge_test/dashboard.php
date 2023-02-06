<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>
<script src="<?php echo base_url() ?>assets/css/search-filter/js/chart.js"></script>
<style>
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:2px;
		text-align: center;
	}
	.label {
		/*padding: .7em .6em;*/
	}
	
</style>

<div class="wrap">
	<section class="app-content">

		<div class="widget">
			<div class="widget-body compute-widget">
				<h4>Process Knowledge Test</h4>
				<hr class="widget-separator">
				<div class="common-top">
					<div class="filter-widget">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Select Month</label>
										<select class="form-control" name="selectedMonth" id="selectedMonth">
											<?php $month_names = array("January","February","March","April","May","June","July","August","September","October","November","December");
											foreach($month_names as $row => $month):
												$month_num = $row+1;;
											?>
											<option value="<?php echo $month_num;?>" <?php echo ((date('m') == $month_num) ? 'selected' : '');?>><?php echo $month;?></option>
										<?php endforeach;?>
									</select>
								</div>
							</div>
						</div>
					</div>					
				</div>
			</div>
			
		</div>

		<div class="row">
			<div class="col-sm-6">
				<div class="widget">
					<div class="widget-body text-center bar-chart-area">
						<canvas id="bar-chart" width="400" height="400"></canvas>
					</div>
				</div>
            </div>
			<div class="col-sm-6">
				<div class="widget">
					<div class="widget-body text-center bar-doughnut-area">
						<canvas id="bar-doughnut" width="400" height="400"></canvas>
					</div>
				</div>
            </div>
        </div>

		<!-- <div class="common-top">
			<div class="row">
				<div class="col-sm-12">
					<div class="row">
						<div class="col-md-2">
							<div class="widget">
								<div class="widget-body text-center">
									<h2 class="dashboard-title">
										12, 696
									</h2>
									<h3 class="dashboard-sub-title">
										Sessions
									</h3>
									<div class="count-btn">
										<a href="#">-15%</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<div class="widget">
								<div class="widget-body text-center">
									<h2 class="dashboard-title">
										1.12
									</h2>
									<h3 class="dashboard-sub-title">
										Page Sessions
									</h3>
									<div class="count-btn">
										<a href="#">-15%</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<div class="widget">
								<div class="widget-body text-center">
									<h2 class="dashboard-title">
										00:20
									</h2>
									<h3 class="dashboard-sub-title">
										Avg Sessions
									</h3>
									<div class="count-btn">
										<a href="#">-15%</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<div class="widget">
								<div class="widget-body text-center">
									<h2 class="dashboard-title">
										7.56%
									</h2>
									<h3 class="dashboard-sub-title">
										%New Sessions
									</h3>
									<div class="count-btn">
										<a href="#">-15%</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<div class="widget">
								<div class="widget-body text-center">
									<h2 class="dashboard-title">
										49%
									</h2>
									<h3 class="dashboard-sub-title">
										Bounce Rate
									</h3>
									<div class="count-btn-red">
										<a href="#">-20%</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-2">
							<div class="widget">
								<div class="widget-body text-center">
									<h2 class="dashboard-title">
										2,256
									</h2>
									<h3 class="dashboard-sub-title">
										Goal Completion
									</h3>
									<div class="count-btn">
										<a href="#">-15%</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div> -->
		
		<div class="common-top">
			<div class="row">
				<div class="col-sm-12">
					<div class="widget">
						<div class="table-small table-bg">
							<table class="table table-bordered table-responsive table-striped">
								<thead>
									<th>Agent Name</th>
									<th>Emp. ID</th>
									<th>Tool ID</th>
									<th>TL Name</th>
									<th>Attempt</th>
									<th>Not Attempt</th>
									<th>Total Obtain Score</th>
									<th>Avg Score</th>
									<th>Action</th>
								</thead>
								<tbody id="pkt-agents-list">
									<tr>
										<td>22.11.2021</td>
										<td>kolkata</td>
										<td>Daljeet Singh</td>
										<td>FKOLXXXX</td>
										<td>Leave Portal</td>
										<td>Test 1</td>
										<td>Manash Kundu</td>
										<td>
											<a href="#" class="edit-btn">
												<i class="fa fa-pencil" aria-hidden="true"></i>
											</a>
											<!-- <a href="#" class="edit-btn">
												<i class="fa fa-eye" aria-hidden="true"></i>
											</a> -->
										</td>
									</tr>
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		
    </section>
</div>



<div class="modal fade in modal-design" id="addTicketModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        
        <form  enctype="multipart/form-data" id="frmAddTicket" action="<?php echo base_url(); ?>servicerequest/add_ticket" data-toggle="validator" method="POST" novalidate="true">
            
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel">Add New Ticket</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-check" style="line-height:35px">
                        <input type="checkbox" class="form-check-input" id="self_submit" value="1" name="self_submit">
                        <label class="form-check-label" for="exampleCheck1">Submit on behalf of another user</label>                        
                    </div>
                </div>
                <div class="col-md-4" id="on_behalf_of-div"  style="display:none">
                    <!--<label class="col-md-4 form-check-label" for="on_behalf_of" style="line-height:30px;text-align:right;">User's Name</label>--> 
                    <!--<input type="text" class="form-control" id="on_behalf_of" name="on_behalf_of" placeholder="User's Name or Fusion ID">-->
					<select class="form-control" id="on_behalf_of" name="on_behalf_of">
						<option value="">Select</option>
						<?php foreach($user_ticket_list as $row): ?>
							<option value="<?php echo $row['id']; ?>"><?php echo $row['fname']." ".$row['lname']." (".$row['fusion_id'].")"; ?></option>
						<?php endforeach; ?>
					</select>
                </div>
                <div class="col-md-4">
                    <label class="col-md-4" for="attachments" style="line-height:40px;text-align:right;">Attach</label> 
                    <div class="col-md-8"> 
                        <input type="file" class="form-control" id="attachments" name="attachments[]" multiple>
                    </div>
                </div>
            </div>
            <div class="row" style="padding-top:5px;">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-check-label" for="subject">Subject</label>
                        <input pattern=".{10,100}" type="text" class="form-control" id="subject" name="subject" placeholder="Subject" required>                        
                    </div>
                </div>
            </div>
            <div class="row" style="padding-top:0px;">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-check-label" for="subject">Ticket Details</label>
                        <textarea id="summernote" name="details" required></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-check-label" for="category">Priority</label>
                        <select name="priority" class="form-control" id="priority" required>
                        <option value=""></option>
                            <?php echo $priority_dropdown; ?>
                        </select>                      
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label style="display:block">Location</label>                                 
                        <select class="form-control" name="office_id" id="location_dt1">
                            <option>--Select--</option>
                                                <?php if($is_global_access==1){ ?>             
                                                <option value="ALL">ALL</option>
                                                <?php } ?>
                                                <?php foreach($location_list as $loc): ?>
                                                    <?php
                                                    $sCss="";
                                                    if($loc['abbr']==$office_id) $sCss="selected";
                                                    ?>
                                                    <option value="<?php echo $loc['abbr']; ?>" ><?php echo $loc['office_name']; ?></option>
                                                    
                                                <?php endforeach; ?>
                        </select>                      
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-check-label" for="category">Category</label>
                        <select class="form-control" id="loc_cat1" name="category" required>
                            <option value=""></option>
                            <?php echo $category_dropdown_form; ?>
                        </select>                     
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-check-label" for="sub_category">Sub Category</label>
                        <select class="form-control" id="sub_category1" name="sub_category" required></select>                     
                    </div>
                </div>
                <div class="col-md-3" style="display:none">
                    <div class="form-group">
                        <label class="form-check-label" for="due_date">Due Date</label>
                        <input type="date" class="form-control" id="due_date" name="due_date">                        
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal-footer">
            <button type="button" class="submit-btn" data-dismiss="modal">Close</button>
            <button type="button" id="addTicket" class="submit-btn1">Submit</button>
        </div>
        
        </form>
        
        </div>
    </div>
</div>

<!-- Agent pkt Details  modal-->

<div class="modal fade" id="agent-pkt-details-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agent PKT Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="widget-body table-responsive">
		    <table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" width="100%" cellspacing="0">
		        <thead>
		            <tr class="bg-info">
		                <th class="text-center">Agent Name</th>
						<th class="text-center">Emp. ID</th>
						<th class="text-center">Tool ID</th>
						<th class="text-center">TL Name</th>
						<th class="text-center">Status</th>
						<th class="text-center">Exam Name</th>
						<th class="text-center">Exam given Date</th>
						<th class="text-center">Total Score</th>
						<th class="text-center">Obtain Score</th>
						<th class="text-center">Score Obtained(%)</th>
						<th class="text-center">Pass/Fail Status</th>
		            </tr>
		        </thead>
		        <tbody style="text-align: center;" id="pkt-agents-details-list">
		            <tr>
		                <td>1</td>
		                <td align="center">Bangalore Test QA</td>
		                <td align="center">2022-08-17</td>
		                <td align="center">Bangalore test_1 agent</td>
		                <td align="center">Bangalore Test Manager</td>
		                <td align="center">2022-08-17</td>
		                <td align="center">CQ Audit</td>
		                <td align="center">100 %</td>
		                <td align="center">00:04:00</td>
		                <td align="center"></td>
		                <td align="center"></td>
		                <td align="center"></td>
		            </tr>
		        </tbody>
		    </table>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>