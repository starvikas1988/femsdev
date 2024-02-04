	<style>
.abItem{
	margin: 5px 0px;
}
.abCLBtn button{
	padding:0px 10px!important;
}
</style>


<div class="row" style="margin-bottom:2px;" >
<div class="col-md-12" style="max-height: 110px; overflow-y: auto;">


<?php 
// echo "<pre>" .print_r($ab_attendanceArray_others, 1) ."</pre>"; ?>

<?php if(isIndiaLocation() == true && !empty($ab_attendanceArray_others)){

foreach($ab_attendanceArray_others as $key => $ab_token){
	
	$ab_cDate = $ab_token['atten_date'];
	
	$mdyabdate = mysqlDt2mmddyyDate($ab_cDate);
	

	$status = "Absent";
	$abClassColour = "text-danger";
	$disable = false;

	if(!empty($ab_leaveAppliedArray[$key])){
		if($ab_leaveAppliedArray[$key][0]['status'] == 0){ 
			$status = "Applied";
			$disable = true;
			$abClassColour = "text-primary"; 
		}else if($ab_leaveAppliedArray[$key][0]['status'] == 1)
		{
			$status = "Approved";
			$disable = true;
			$abClassColour = "text-success";
		}else if($ab_leaveAppliedArray[$key][0]['status'] == 2){
			$status = "Rejected";
			$disable = true;
			$abClassColour = "text-warning";
		}
	}  
?>
<div class="abItem row">
<div class="col-md-4 abCLdate"><span><?php echo $mdyabdate; ?></span></div>
<div class="col-md-5 abCLStatus">
<span class="<?php echo $abClassColour; ?>"><?php echo $status ?></span> 
</div>
<div class="col-md-3 abCLBtn">
	
	 <?php if($leave_accessible && !$disable) :?>
		<button class="btn btn-primary btn-sm pull-right myLeaveModalBtn" data-toggle="modal" data-frmdate='<?php echo $mdyabdate;?>' data-todate='<?php echo $mdyabdate;?>' >Apply </button>
	 <?php else: ?>
		<button class="btn btn-primary btn-sm pull-right" disabled data-toggle="modal" data-frmdate='<?php echo $mdyabdate;?>' data-todate='<?php echo $mdyabdate;?>' >Apply </button>
	 <?php endif; ?>
</div>
</div>
<?php } }

// echo "<pre>";print_r($ab_attendanceArray);
foreach($ab_attendanceArray as $ab_token){ 
	
	$ab_cDate = $ab_token['rDate'];
	
	$mdyabdate = mysqlDt2mmddyyDate($ab_cDate);
	
	$ab_logged_in_hours = $ab_token['logged_in_hours'];
	$ab_logged_in_hours_local = $ab_token['logged_in_hours_local'];
	$ab_rdate = $ab_token['rDate'];
	$ab_disposition = $ab_token['disposition'];
	
	$todayLoginTime=$ab_token['todayLoginTime'];
	$is_logged_in = $ab_token['is_logged_in'];
	$office_id = $ab_token['office_id'];
	
	$abClassColour = "text-danger";
	// LEAVE DETAILS
	$ab_leave_dtl = "";		
	if(!empty($ab_token['leave_type'])){
		$ab_leave_status = $ab_token['leave_status'];
		if($ab_leave_status == '0'){ $ab_leave_dtl = $ab_token['leave_type'] . " Applied"; $abClassColour = "text-primary"; }
		else if( $ab_leave_status == '1'){  $ab_leave_dtl = $ab_token['leave_type'] . " Approved"; $abClassColour = "text-success"; }
		else if( $ab_leave_status == '2'){  $ab_leave_dtl = $ab_token['leave_type'] . " Reject"; $abClassColour = "text-warning"; }
	}
	
	// EST DSIPOSITION CHECK
	$ab_disposition_est = "";
	if($ab_logged_in_hours!="0"){
		if($ab_token['user_disp_id']=="8" || $ab_token['user_disp_id']=="7") $ab_disposition_est =  " P &". $ab_disposition;
		else $ab_disposition_est =  "P";
	} 
	else if($ab_disposition != "") 			$ab_disposition_est =  $ab_disposition; 
	else if($ab_rdate < $ab_token['doj']) 	$ab_disposition_est = "";
	else if($ab_leave_dtl != "") 			$ab_disposition_est = $ab_leave_dtl;	
	else 									$ab_disposition_est =  "Absent"; 
	
	
	// LOCAL DSIPOSITION CHECK
	$ab_disposition_local = "";
	if($ab_logged_in_hours_local != "0"){
		if($ab_token['user_disp_id']=="8" || $ab_token['user_disp_id']=="7") $ab_disposition_local =  " P &". $ab_disposition;
		else $ab_disposition_local =  "P";
	} 
	else if($ab_disposition != "") 			$ab_disposition_local =  $ab_disposition; 
	else if($ab_rdate < $ab_token['doj']) 	$ab_disposition_local = "";
	else if($ab_leave_dtl != "") 			$ab_disposition_local = $ab_leave_dtl;	
	else 									$ab_disposition_local =  "Absent"; 
	
	
	//echo $ab_cDate . ">><br>";
	
	if($is_logged_in == '1'){
		
		
		$todayLoginArray = explode(" ",$todayLoginTime);
		$todayLoginTime_local = ConvServerToLocalAny($todayLoginTime,$office_id);
		$todayLoginArray_local = explode(" ",$todayLoginTime_local);
		
		
		
		if($ab_cDate == $todayLoginArray[0]){
			
			$flogin_time = $todayLoginTime;
			$ab_disposition_est="online";
			
		}
		
		//echo $ab_cDate . "==". $todayLoginArray_local[0]."<br>";
		
		if($ab_cDate == $todayLoginArray_local[0]){
			
				$flogin_time_local=$todayLoginTime_local;
				$ab_disposition_local="online";
				
		}
	}
			
	// ABSENT OR LEAVE CHECK
	if($ab_disposition_local == 'Absent'  || !empty($ab_leave_dtl))
	{
?>
<div class="abItem row">
<div class="col-md-4 abCLdate"><span><?php echo $ab_cDate; ?></span></div>
<div class="col-md-5 abCLStatus">
<span class="<?php echo $abClassColour; ?>"><?php echo $ab_disposition_local; ?></span> 
</div>
<div class="col-md-3 abCLBtn">
<?php if($ab_disposition_local == 'Absent'){ ?>
	
	 <?php if($leave_accessible) :?>
		<button class="btn btn-primary btn-sm pull-right myLeaveModalBtn" data-toggle="modal" data-frmdate='<?php echo $mdyabdate;?>' data-todate='<?php echo $mdyabdate;?>' >Apply </button>
	 <?php else: ?>
		<button class="btn btn-primary btn-sm pull-right" disabled data-toggle="modal" data-frmdate='<?php echo $mdyabdate;?>' data-todate='<?php echo $mdyabdate;?>' >Apply </button>
	 <?php endif; ?>
						
<?php } ?>
</div>
</div>
<?php } ?>
<?php }  ?>



</div>
</div>

<?php 
// print_r($holiday_list); ?>


<div id="myLeaveModal" class="modal fade" role="dialog" style="font-size:90%; ">
    <div class="modal-dialog">
		<div class="modal-header">
			<h4 class="modal-title">Leave Application</h4>
			<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-content">
            <form method="post" action="<?php echo base_url('leave'); ?>" id="leave_form">
                <div class="modal-body">
					<div class="mb-3 row">
						<label class="col-sm-3 col-form-label">
							Employee Name
						</label>
						<div class="col-sm-9">
							<div class="name-widget">
								<?php echo get_username(); ?>
							</div>
						</div>
					</div>
					<div class="mb-3 row">
						<label class="col-sm-3 col-form-label">
							Leave Type
						</label>
						<div class="col-sm-9">
						  <?php 
                                    $_date_join = date_create($ab_leaveData['date_of_joining']);
                                    $diff = date_diff(date_create(date('Y-m-d')), $_date_join);
                                ?>
                                <select id="form-leave_type" name="leave_criteria_id" required>
                                    <option value="">Select</option>
                                    <?php foreach($ab_leaveData['leave_structure'] as $leave): ?>
                                        <?php if($leave["leave_access_allowed"] == 1): ?>
                                            <?php                                                 
                                                if( (int)$diff->format("%a") >= $leave["show_after_days"]): 
                                            ?>
                                                <option value="<?php echo $leave["leave_criteria_id"]; ?>">
                                                    <?php echo $leave["description"]; ?>
                                                </option>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <input type="hidden" name="leave_type_id" id="leave_type_id">
						</div>
					</div>
                    
                    

                    <!-- IF HAS SUBSECTIONS -->
                        <div class="row sub_sections" style="padding:3px 0px; display:none;">
                            <div class="form-group">
                                <label class="col-md-4" style="line-height:37px;">Leave Sub Sections</label>
                                <div class="col-md-8">
                                    <select class="form-control" name="sub_sections" id="sub_select_select">
                                    </select>
                                </div>
                            </div>
                        </div>
                    <!-- END SUB SECTIONS -->

                    <div class="mb-3 row">
                        
                            <label class="col-sm-3 col-form-label">Available Balance</label>
                            <div class="col-md-9" id="leave-balance" style="font-weight:bold; margin-top:5px;"></div>
                        
                    </div>
					
					<div class="mb-3 row">
						<label class="col-sm-3 col-form-label">
							From Date
						</label>
						<div class="col-sm-9">
						  <input  readonly autocomplete="off" type="text" name="from_date" class="form-control" id="from_date" required>
						</div>
					</div>
					
					<div class="mb-3 row">
						<label class="col-sm-3 col-form-label">
							To Date
						</label>
						<div class="col-sm-9">
						  <input readonly autocomplete="off" type="text" name="to_date" class="form-control" id="to_date" required>
						</div>
					</div>
					
					<div class="mb-3 row">
						<label class="col-sm-3 col-form-label">
							No. of Day(s)
						</label>
						<div class="col-sm-9" id="no_of_days"> 
						</div>
					</div>
                   
                    
                    
                    <!-- FOR JAM -->
                    <div class="row" id="additional_section_JAM" style="padding:13px 0px;display:none;">
                        <div class="form-group">
                            <label class="col-md-4">Apply From Other Leaves</label>
                            <div class="col-md-8" id="no_of_days">
                                <input type="checkbox" value="1" name="apply_additional_leaves" id="apply_from_vl">
                            </div>
                        </div>                           
                    </div>                    

                    <div class="row additional_section_JAM" style="padding:3px 0px;display:none;">
                        <div class="form-group">
                            <label class="col-md-4" style="line-height:37px;">No. of Additional Leaves</label>
                            <div class="col-md-8">
                                <select class="form-control" name="no_of_additional_leaves" id="additional_leaves_select">
                                </select>
                            </div>
                        </div>                           
                    </div>

                    <!-- JAM CLOSED -->
					
					<div class="mb-3 row">
						<label class="col-sm-3 col-form-label">
							Reporting Head
						</label>
						<div class="col-sm-9" id="reporting-head">
							<div class="name-widget">
								<?php echo get_assigned_to_name() ?>
							</div>
						</div>
					</div>
					
					<div class="mb-3 row">
						<label class="col-sm-3 col-form-label">
							Reason
						</label>
						<div class="col-sm-9">
							<textarea class="form-control" name="reason" required></textarea>
						</div>
					</div>
					
					<div class="mb-3 row">
						<label class="col-sm-3 col-form-label">
							Contact Details
						</label>
						<div class="col-sm-9">
							<input type="text" name="contact_details" class="form-control" required>
						</div>
					</div>
					
					
                </div>
                <div class="modal-footer">
                    <button disabled id="sub_but" type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
	$(document).ready(function(){
		
				
		$(".myLeaveModalBtn").click(function(){

            var is_ind_loc = '<?php echo isIndiaLocation(); ?>';
			
			var fdate = $(this).attr('data-frmdate');
			var tdate = $(this).attr('data-todate');
			
			$("#myLeaveModal").modal('show');
            urls='<?php echo base_url();?>/home/check_holiday'
            if(fdate==tdate){
                $.ajax({
                        url : urls,
                        type: "GET",
                        data :'hdate='+fdate,
                        success: function(data, textStatus, jqXHR)
                        {
                            if(data==0){
                                $("#form-leave_type option:contains('Holiday')").hide();
                                //$("#form-leave_type option[value=Holiday]").hide();

                            }else{
                                $("#form-leave_type option:contains('Holiday')").show();
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                    
                        }
                });

                if (is_ind_loc == 1) {

                    $("#form-leave_type option:contains('Paternity Leave')").hide();
                    $("#form-leave_type option:contains('Maternity Leave')").hide();

                     //Leave check for Comp off

                    var datas = { 'from_date': fdate, 'to_date': tdate, 'deff_days': 1};
                    var request_url = "<?=base_url()?>leave/check_com_off_date_apply";

                    process_ajax(function(response)
                    {
                        var res = JSON.parse(response);
                        if (res.stat == true) 
                        {
                            $("#form-leave_type option:contains('Comp Off')").show();
                        }
                        else {
                            $("#form-leave_type option:contains('Comp Off')").hide();
                        }                 
                    },request_url, datas, 'text'); 

                }

            }
			
			$("#leave_form #from_date").val(fdate);
			$("#leave_form #to_date").val(tdate);
			//$("#myLeaveModal").show();
						
		});	
			
	});	
</script>
