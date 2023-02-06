<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/custom.css"/>
<script>
function valiadteFunc(){
	if(document.getElementById('location').value==""){
		alert("Please select location.");
		return false;
	}
	if(document.getElementById('department').value==""){
		alert("Please select department.");
		return false;
	}
	if(document.getElementById('clients').value==""){
		alert("Please select client.");
		return false;
	}
	if(document.getElementById('exams').value==""){
		alert("Please select exam.");
		return false;
	}
	if(document.getElementById('assign_type').value==""){
		alert("Please select question assign type.");
		return false;
	}
	if(document.getElementById('assign_type').value == 'random'){
		if(document.getElementById('no_of_questions').value == ""){
			alert("Please select no. of questions");
			return false;
		}
	}else if(document.getElementById('assign_type').value == 'set')
	{
		if(document.getElementById('sets').value == ""){
			alert("Please select set");
			return false;
		}
	}
}

</script>

<div class="wrap">
	<section class="app-content">
		<div class="widget">
			<div class="widget-body compute-widget">
				<h4>Assign Exam</h4>
				<hr class="widget-separator">
				<div class="common-top">
					<div class="filter-widget">
					<?php echo form_open('',array('id'=>'myform','enctype'=>"multipart/form-data")); ?>
						<input type="hidden" name="locationArr" id="locationArr" value="">
						<input type="hidden" name="supervisorArr" id="supervisorArr" value="">
						<input type="hidden" name="agentArr" id="agentArr" value="">
						
						<div class="row">				
							<div class="col-sm-3">
								<div class="form-group">
									<label>Location</label><span style="color:#FF0000">*</span>
									<select id="location" name="location" class="multiple-select" multiple="multiple" required onchange='locationchange();'>
										<?php foreach($location as $locData){?>
										<option value="<?php echo $locData['abbr']?>"><?php echo $locData['location'];?></option>
										<?php }?>
									</select>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>Department</label><span style="color:#FF0000">*</span>
									<select id="department" class="from-control select-box" name="department" required onchange='locationchange();'>
										<option value="">Please select</option>
										<?php foreach($department as $deptData){?>
										<option value="<?php echo $deptData['id']?>"><?php echo $deptData['description'];?></option>
										<?php }?>
									</select>
								</div>
							</div>	
							<div class="col-sm-3">
								<div class="form-group">
									<label>Clients</label><span style="color:#FF0000">*</span>
									<select id="clients" class="from-control select-box" name="clients" onclick="getSupervisor();" required onchange='locationchange();'>
										<option value="">Please select</option>
										<?php foreach($client as $clientData){?>
										<option value="<?php echo $clientData['id'];?>"><?php echo $clientData['fullname'];?></option>
										<?php }?>
									</select>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>Supervisors</label>
									<select id="supervisor" name="supervisor" multiple="multiple" onChange="getAgent();">
										<option value="">Select Supervisor</option>
									</select>
								</div>
							</div>
							</div>
							<div class="row">
								<div class="col-sm-3">
								<div class="form-group agent-select">
									<label>Agents</label>
									<select id="agents" name="agents" class="multi-agent" multiple="multiple" onChange="getAgentID();">
										<option value="">Select Agent</option>
									</select>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>Exams</label><span style="color:#FF0000">*</span>
									<select id="exams" class="from-control select-box" name="exams" onChange="selectSet(this.value);">
										<option value="">Select Exam</option>
										<?php foreach($exams as $examData){?>
										<option value="<?php echo $examData['id'];?>"><?php echo $examData['exam_name'];?></option>
										<?php }?>
									</select>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<label>Question Assign Type</label><span style="color:#FF0000">*</span>
									<select id="assign_type" name="assign_type" onChange="selectType(this.value);">
										<option value="">Select option</option>
										<option value="random">Random</option>
										<option value="set">Set</option>
									</select>
								</div>
							</div>
							<div id="question_no_block" class="col-sm-3" style="display:none;">
								<div class="form-group">
									<label>Number of Questions</label><span style="color:#FF0000">*</span>
									<select id="no_of_questions" name="no_of_questions" class="from-control select-box">
										<option value="">Select number of questions</option>
										<option value="5">5</option>
										<option value="10">10</option>
										<option value="15">15</option>
									</select>
								</div>
							</div>
							<div id="question_set_block" class="col-sm-3" style="display:none;">
								<div class="form-group">
									<label>Sets</label><span style="color:#FF0000">*</span>
									<select id="sets" name="sets" class="from-control select-box">
										<option value="">Select option</option>
									</select>
								</div>
							</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<button type="submit" name="submit" value="submit" class="submit-btn" onclick='return valiadteFunc();'>
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
				<div class="widget-body no-padding">
					<div class="table-small table-bg">
						<table class="table table-bordered table-striped table-responsive">
							<?php if(isset($message) && !empty($message)){?>
							<thead>
								<tr>
									<th colspan="5"><?php echo $message;?></th>
								</tr>
							</thead>
							<?php }?>
							<!--<thead>
								<tr>
									<th>Name</th>
									<th>Download Questions</th>
									<th>Created By</th>
									<th>Date of Creation</th>
									<th>Asign</th>
								</tr>
							</thead>-->
							<tbody>
								<tr>
									<td colspan=5>Temporary Listing of assigned users pending</td>
									<!--<td>Daljeet Singh</td>
									<td>Download Questions</td>
									<td>Daljeet Singh</td>
									<td>24.11.2021</td>
									<td>
										<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal" class="edit-btn">
											<i class="fa fa-hand-pointer-o" aria-hidden="true"></i>
										</a>
									</td>-->
								</tr>
								
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