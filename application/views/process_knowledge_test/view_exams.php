<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/custom.css"/>
<?php //print_r($examination);?>

<div class="wrap">
	<section class="app-content">
		<div class="widget">
			<div class="widget-body compute-widget">
				<h4><?php echo $examination['exam_name'];?></h4>
				<hr class="widget-separator">
				
			</div>			
		</div>
		
		<div class="common-top">
			<div class="widget">
				<div class="widget-body no-padding">
					<div class="table-small table-bg">
						<table class="table table-bordered table-striped table-responsive">
							<thead>
								<tr>
									<th>Set Name</th>
									<th>Date of Creation</th>
									<th>Download</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($question_set_list as $token){?>
								<tr>
									<td><?php echo $token['set_name'];?></td>
									
									<td><?php echo $token['created_on'];?></td>
									<td>
										<a href="<?php echo base_url();?>process_knowledge_test/exam_set_download/<?php echo $token['id'];?>" class="edit-btn">
											<i class="fa fa-download" aria-hidden="true" title="Download Set"></i>
										</a>
										<a href="<?php echo base_url();?>process_knowledge_test/view_question_list/<?php echo $token['id'];?>" data-toggle="modal" class="edit-btn">
											<i class="fa fa-eye" aria-hidden="true" title="View Question List"></i>
										</a>
									</td>
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

<!--start popup here-->
<div class="modal fade modal-design" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Assign</h4>
        </div>
        <div class="modal-body">
          <div class="filter-widget pop-select">
				<div class="row">				
					<div class="col-sm-4">
						<div class="form-group">
							<label>Label 1</label>
							<select id="multi_pop1" class="multiple-select" multiple="multiple">
								<option value="India">India</option>
								<option value="Australia">Australia</option>
								<option value="United State">United State</option>
								<option value="Canada">Canada</option>
								<option value="Taiwan">Taiwan</option>
								<option value="Romania">Romania</option>
							</select>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label>Label 2</label>
							<select id="multi_pop2" class="multiple-select" multiple="multiple">
								<option value="India">India</option>
								<option value="Australia">Australia</option>
								<option value="United State">United State</option>
								<option value="Canada">Canada</option>
								<option value="Taiwan">Taiwan</option>
								<option value="Romania">Romania</option>
							</select>
						</div>
					</div>				
					<div class="col-sm-4">
						<div class="form-group">
							<label>Label 3</label>
							<select id="multi_pop3" class="multiple-select" multiple="multiple">
								<option value="India">India</option>
								<option value="Australia">Australia</option>
								<option value="United State">United State</option>
								<option value="Canada">Canada</option>
								<option value="Taiwan">Taiwan</option>
								<option value="Romania">Romania</option>
							</select>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label>Label 4</label>
							<select id="multi_pop4" class="multiple-select" multiple="multiple">
								<option value="India">India</option>
								<option value="Australia">Australia</option>
								<option value="United State">United State</option>
								<option value="Canada">Canada</option>
								<option value="Taiwan">Taiwan</option>
								<option value="Romania">Romania</option>
							</select>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label>Label 5</label>
							<select id="multi_pop5" class="multiple-select" multiple="multiple">
								<option value="India">India</option>
								<option value="Australia">Australia</option>
								<option value="United State">United State</option>
								<option value="Canada">Canada</option>
								<option value="Taiwan">Taiwan</option>
								<option value="Romania">Romania</option>
							</select>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label>Label 6</label>
							<select id="multi_pop6" class="multiple-select" multiple="multiple">
								<option value="India">India</option>
								<option value="Australia">Australia</option>
								<option value="United State">United State</option>
								<option value="Canada">Canada</option>
								<option value="Taiwan">Taiwan</option>
								<option value="Romania">Romania</option>
							</select>
						</div>
					</div>					
				</div>
			</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="red-btn1" data-dismiss="modal">
			Cancel
		  </button>
		  <button type="submit" class="submit-btn">							
			Save
		  </button>
        </div>
      </div>
      
    </div>
  </div>
<!--end popup here-->  