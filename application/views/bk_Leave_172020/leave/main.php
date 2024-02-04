<style>
	td{
		font-size:10px;
	}
	
	#default-datatable th{
		font-size:11px;
	}
	#default-datatable th{
		font-size:11px;
	}
	
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:3px;
	}
	
</style>


<div class="wrap">
	<section class="app-content">
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
                    <header class="widget-header" style="padding:10px">
						<h4 class="widget-title" style="line-height:35px; display:inline">Leaves Dashboard</h4>                        
                    </header>
                    <hr class="widget-separator">
                    <div class="widget-body">
                        <form action="" method="get">                            
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <label for="location">Location</label>
                                    <select class="input-sm form-control" name="location">
                                        <option value=""></option>
                                        <?php foreach($get_office_location_list as $row): ?>                                        
                                            <option value="<?php echo $row["abbr"]; ?>"><?php echo $row["office_name"] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="department">Department</label>
                                    <select class="input-sm form-control" name="department" id="department">
                                        <option value=""></option>
                                        <?php foreach($get_department_list as $row): ?>                                        
                                            <option value="<?php echo $row["id"]; ?>"><?php echo $row["description"] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="sub-department">Sub Department</label>
                                    <select class="input-sm form-control" name="sub_department" id="sub-department">
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-success btn-sm" style="margin-top:25px;">SUBMIT</button>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                        <div class="table-responsive" style="scroll:auto">
                            <form action="<?php echo base_url() ?>leave/operation_leave_access_to_selected" method="post" id="operation_leave_access_to_selected">
                                <input type="hidden" name="query_str" class="query_str">
                                <input type="hidden" name="operation_type" id="operation_type">
                                <table id="default-datatable" data-plugin="DataTable" class="table table-bordered" cellspacing="0" width="100%">
                                    <thead style="background-color:#eee">
                                        <tr>
                                            <td colspan="20" style="padding:5px 0px;">
                                                <button type="button" class="btn btn-danger btn-xs pull-right" style="margin-right:5px" onclick="operation_t(0)">Deny Selected</button>
                                                <button type="button" class="btn btn-primary btn-xs pull-right" style="margin-right:5px" onclick="operation_t(1)">Allow Selected</button>                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-center">
                                                <input type="checkbox" id="select_all">
                                            </th>
                                            <th class="text-center">XPOID</th>
                                            <th class="text-center">Employee Name</th>
                                            <th class="text-center">Location</th>
                                            <th class="text-center" width="60px">Gender</th>
                                            <th class="text-center">Department</th>
                                            <th class="text-center">Sub Department</th>
                                            <?php foreach($get_leave_criterias_location_based as $leave_type): ?>
                                                <th class="text-center"><?php echo $leave_type->description." (".$leave_type->leave_type.")" ?></th>
                                            <?php endforeach; ?>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot style="background-color:#eee">
                                        <tr>
                                            <th class="text-center"></th>
                                            <th class="text-center">XPOID</th>
                                            <th class="text-center">Employee Name</th>
                                            <th class="text-center">Location</th>
                                            <th class="text-center" width="60px">Gender</th>
                                            <th class="text-center">Department</th>
                                            <th class="text-center">Sub Department</th>
                                            <?php foreach($get_leave_criterias_location_based as $leave_type): ?>
                                                <th class="text-center"><?php echo $leave_type->description." (".$leave_type->leave_type.")" ?></th>
                                            <?php endforeach; ?>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>                                    
                                    <?php foreach($users_list as $user): ?>                                    
                                        <tr>
                                            <td width="30px;" class="text-center"><input class="inverted_checkboxes" type="checkbox" value='<?php echo $user["user_id"]; ?>' name="user_ids[]"></td>
                                            <td><?php echo $user["xpoid"]; ?></td>
                                            <td><?php echo $user["name"]; ?></td>
                                            <td class="text-center"><?php echo $user["location"]; ?></td>
                                            <td><?php echo $user["gender"]; ?></td>
                                            <td><?php echo $user["dept"]; ?></td>
                                            <td><?php echo $user["sub_dept"]; ?></td>
                                            <?php foreach($user["leave_criteria"] as $leave_type): ?>
                                                <td class="text-center">
                                                    <?php if($leave_type == 1): ?>
                                                        <i class="fa fa-check" style="font-weight:bold; font-size:11px; color:#099a01"></i>                                                 
                                                    <?php endif; ?>
                                                    <?php if($leave_type == 0): ?>
                                                        <i class="fa fa-times" style="font-size:11px; color:#FF0000"></i>
                                                    <?php endif; ?>
                                                </td>
                                            <?php endforeach; ?>
                                            <td class="text-center">
                                                <button class="btn btn-xs btn-primary" type="button" onclick='grant_leave_access(<?php echo $user["user_id"]; ?>,"<?php echo $user["name"] ?>")'>
                                                    <i class="fa fa-save"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>                                    
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo base_url()?>leave/grant_leave_access" method="post">  
            <input type="hidden" name="user_id" id="user_id">                                      
            <input type="hidden" name="query_str" class="query_str">                                      
            <div class="modal-header">
                <small><strong>Set Applicable Types of Leave for</strong></small>
                <h5 id="user-name"></h5>                
            </div>
                <div class="modal-body">
                    <?php foreach($get_leave_criterias_location_based as $leave_criteria): ?>                         
                        <div class="row form-group" style="margin-bottom:5px;">
                            <label class="col-md-8"><?php echo $leave_criteria->description." (".$leave_criteria->leave_type.")" ?></label>                            
                            <div class="col-md-4">
                                <input type="hidden" name="leave_criteria[]" value="<?php echo $leave_criteria->l_criteria_id ?>">
                                <input type="hidden" name="record_<?php echo $leave_criteria->l_criteria_id ?>" id="record_<?php echo $leave_criteria->l_criteria_id ?>">
                                <select class="form-control input-sm" style="height:30px;" id="id_<?php echo $leave_criteria->l_criteria_id ?>" name="select_<?php echo $leave_criteria->l_criteria_id ?>">                               
                                    <option value="0">Cannot Apply</option>
                                    <option value="1">Can Apply</option>
                                </select>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
