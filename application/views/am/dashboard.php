 <style>
	td{
		font-size:12px;
	}
	
	#default-datatable th{
		font-size:12px;
	}
	#default-datatable th{
		font-size:12px;
	}
	
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:3px;
		vertical-align:middle;
	}
	.lbl_chk_all{
		padding:0px 5px;
		background-color:#ddd;
	}
	
	.lbl_chk{
		padding:0px 5px;
	}
		
	.table > thead > tr > th,.table > tfoot > tr > th{
			text-align:left;
	}

	
</style>

	<div class="wrap">
	<section class="app-content">
	
	
				
		<?php
		
		if($total_suspended>0 || $total_term_sub>0){
			
			$colClass="col-sm-2";
			
		}else{
			$colClass="col-sm-3";
		}
		?>
		
		
		<div class="row">
			
			<div class="<?php echo $colClass;?>">
				<a  href="<?php echo base_url()?>am/dashboard/1?<?php echo $qStrParam; ?>">
				<div class="widget stats-widget">
					<div class="widget-body clearfix">
						<div class="pull-left">
							<h3 class="widget-title text-primary"><span class="counter" data-plugin="counterUp"><?php echo $total_agent; ?></h3>
						</div>
						<span class="pull-right big-icon watermark"><i class="fa fa-users"></i></span>
					</div>
					<footer class="widget-footer bg-primary">
						<small>Total Users</small>
					</footer>
				</div><!-- .widget -->
				</a>
			</div>

			<div class="<?php echo $colClass;?>">
				<a  href="<?php echo base_url()?>am/dashboard/2?<?php echo $qStrParam; ?>">
				<div class="widget stats-widget">
					<div class="widget-body clearfix">
						<div class="pull-left">
							<h3 class="widget-title text-danger"><span class="counter" data-plugin="counterUp"><?php echo $total_online ?></h3>
						</div>
						<span class="pull-right big-icon watermark"><i class="fa fa-users"></i></span>
					</div>
					<footer class="widget-footer bg-success">
						<small>Total Users Online</small>
					</footer>
				</div><!-- .widget -->
				</a>
				
			</div>
			

			<div class="<?php echo $colClass;?>">
				<a  href="<?php echo base_url()?>am/dashboard/3?<?php echo $qStrParam; ?>">
				<div class="widget stats-widget">
					<div class="widget-body clearfix">
						<div class="pull-left">
							<h3 class="widget-title text-danger"><span class="counter" data-plugin="counterUp"><?php echo $total_offline ?></h3>
						</div>
						<span class="pull-right big-icon watermark"><i class="fa fa-users"></i></span>
					</div>
					<footer class="widget-footer bg-info">
						<small>Total Users Offline</small>
					</footer>
				</div><!-- .widget -->
				</a>
				
			</div>
			
			
			<div class="<?php echo $colClass;?>">
				<a  href="<?php echo base_url()?>am/dashboard/4?<?php echo $qStrParam; ?>">
				<div class="widget stats-widget">
					<div class="widget-body clearfix">
						<div class="pull-left">
							<h3 class="widget-title text-danger"><span class="counter" data-plugin="counterUp"><?php echo $total_leave ?></h3>
						</div>
						<span class="pull-right big-icon watermark"><i class="fa fa-users"></i></span>
					</div>
					<footer class="widget-footer bg-warning">
						<small>Users On Leave</small>
					</footer>
				</div>
				</a>
			</div>
			
			<?php
				if($total_term_sub>0){
			?>
			
			<div class="<?php echo $colClass;?>">
				<a  href="<?php echo base_url()?>am/dashboard/6?<?php echo $qStrParam; ?>">
				<div class="widget stats-widget">
					<div class="widget-body clearfix">
						<div class="pull-left">
							<h3 class="widget-title text-danger"><span class="counter" data-plugin="counterUp"><?php echo $total_term_sub ?></h3>
						</div>
						<span class="pull-right big-icon watermark"><i class="fa fa-users"></i></span>
					</div>
					<footer class="widget-footer bg-danger">
						<small>Term Queue</small>
					</footer>
				</div>
				</a>
			</div>
			
			<?php
				}
			?>
			
			
			
			<?php
				if($total_suspended>0){
			?>
			
			<div class="<?php echo $colClass;?>">
				<a  href="<?php echo base_url()?>am/dashboard/7?<?php echo $qStrParam; ?>">
				<div class="widget stats-widget">
					<div class="widget-body clearfix">
						<div class="pull-left">
							<h3 class="widget-title text-danger"><span class="counter" data-plugin="counterUp"><?php echo $total_suspended ?></h3>
						</div>
						<span class="pull-right big-icon watermark"><i class="fa fa-users"></i></span>
					</div>
					<footer class="widget-footer bg-danger">
						<small>Suspension</small>
					</footer>
				</div>
				</a>
				
			</div>
			
			<?php
				}
			?>
			
	</div><!-- .row -->
	
		
			
	<div class="row">
		
		<!-- DataTable -->
		<div class="col-md-12">
				<div class="widget">
					<div class="row" style="padding-top:10px;">
					<div class="col-md-4">
					<header class="widget-header">
						<h4 class="widget-title">
						<?php
						$ofValue="";
						if($oValue!="ALL"){
							$ofValue=$oValue;
						}
						
							if($filter_id==1) echo "Total Users";
							else if($filter_id==2) echo "Total Users Online";
							else if($filter_id==3) echo "Total Users Offline";
							else if($filter_id==4) echo "Total Users On Leave";
							else if($filter_id==5) echo "Manage NCNS Termination";
							else if($filter_id==6) echo "Manage Termination";
							else if($filter_id==7) echo "Manage Suspended User";
							else if($filter_id==8) echo "Total Scheduled Users on Today";
							else if($filter_id==9) echo "Total Users on Break Now";
							else echo "List Of MIA Users";
						?>
						
												
						</h4>
					</header><!-- .widget-header -->
					</div>
					
						<?php if($filter_id==""  ){ ?>
						
						<div style="float:right; margin-right:10px;" class="col-md-4" >
							<div class="form-group">
							<select class="form-control" name="combo_disposition" id="combo_disposition" >
								<option value=''>Select a Disposition For Bulk Change</option>
								<?php foreach($disp_list as $disp): ?>
									<?php
										$sCss="";
										if($disp->id!=5 && $disp->id!=6) continue;
										//if($disp->id==$dValue) $sCss="selected";
									?>
									<option value="<?php echo $disp->id; ?>" <?php echo $sCss;?> ><?php echo $disp->description; ?></option>
									
								<?php endforeach; ?>
																		
							</select>
							</div>
						<!-- .form-group -->
						</div>
						
						<?php } ?>
						
					</div>
					
					<hr class="widget-separator">
					
					<div class="widget-body">
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped" cellspacing="0" width="100%">
								<thead>
									<tr>
										<?php if($filter_id=="" && is_access_operations_module() ){ ?>
										<th><label class="lbl_chk_all"><input type="checkbox" class="check_all"/></label></th>
										<?php } ?>
										
										<th>SL</th>
										<th>Fusion ID</th>
										<?php if($filter_id!=2){
										echo '<th>Site ID</th>';
									} ?>
										<th>Agent</th>
										<th>Dept</th>
										<th>Client</th>
										<th>Office</th>
										<!-- <th>Site</th> -->
										<th>Designation</th>
										<th>Process</th>
										<?php if($filter_id==2){?>
											<th>Schedule Time</th>;
											<th>Login Time</th>;
									
										<?php }?>
										<?php if($filter_id==6 ){
										
											echo "<th>LWD</th> <th>Last Logout Time</th> <th>Term Time</th> <th>Term Type</th> <th>Remarks</th><th>Raised by</th><th>Action</th>";
											
											}else if($filter_id==7 ){
	
											?>
											
											<th>Assigned To</th>
											<th>Suspended Date</th>
											<th>Resign</th>
											<th>Suspended by</th>
											<th>Action</th>
											<?php
											
											}else if($filter_id==5 ){
	
											?>
											
											<th>Request Time</th>
											<th>Last Login Time</th>
											<th>Last Logout Time</th>
											<th>Next Shift Time</th>
											<th>Term Time</th>
											<th>Action</th>
											
										<?php }else{ ?>
																					
											<th>Assigned To</th>
											
											<?php if($filter_id==2){ ?>
											<th>Logged In</th>
											<?php } ?>
											
											<?php if($filter_id!=2){ ?>
											<th>Status</th>
												<?php //if($filter_id!=4){ ?>
												<th>Action</th>
												<?php //} ?>
											<?php } ?>
										
										
										<?php } ?>
										
									</tr>
								</thead>
								
								<tfoot>
									<tr>
										<?php if($filter_id=="" ){ ?>
										<th><label class='lbl_chk_all'><input type="checkbox" class="check_all"/></label></th>
										<?php } ?>
										
										<th>SL</th>
										<th>Fusion ID</th>
										<?php if($filter_id!=2){
										echo '<th>Site ID</th>';
									} ?>
										<th>Agent</th>
										<th>Dept</th>
										<th>Client</th>
										<th>Office</th>
										<!-- <th>Site</th> -->
										<th>Designation</th>
										<th>Process</th>
										<?php if($filter_id==2){?>
											<th>Schedule Time</th>;
											<th>Login Time</th>;
									
										<?php }?>
										<?php if($filter_id==6 ){
										
											echo "<th>LWD</th> <th>Last Logout Time</th> <th>Term Time</th> <th>Term Type</th> <th>Remarks</th><th>Raised by</th><th>Action</th>";
											
											}else if($filter_id==7 ){
	
											?>
											
											<th>Assigned To</th>
											<th>Suspended Date</th>
											<th>Resign</th>
											<th>Suspended by</th>
											<th>Action</th>
											
											<?php
											}else if($filter_id==5 ){
	
											?>
											
											<th>Request Time</th>
											<th>Last Login Time</th>
											<th>Last Logout Time</th>
											<th>Next Shift Time</th>
											<th>Term Time</th>
											<th>Action</th>
											
										<?php }else{ ?>
										
											<th>Assigned To</th>
											
											<?php if($filter_id==2){ ?>
												<th>Logged In</th>
											<?php } ?>
											
											<?php if($filter_id!=2){ ?>
												<th>Status</th>
												<?php // if($filter_id!=4){ ?>
													<th>Action</th>
												<?php // } ?>
											<?php } ?>
											
										
										<?php } ?>
										
									</tr>
								</tfoot>
	
								<tbody>
								
								<?php 
									$i=1;
									foreach($user_list as $user): 
									$user_id=$user['id'];
									
									$omuid=$user['xpoid'];
									
									// edited by saqlan
									if($filter_id==2){
										$last_logged_in_saq = $user['last_logged_date'];
									$llis=ConvServerToLocalAny($last_logged_in_saq,$user['office_id']);
									}
									// edited by saqlan
									if(isset($user['is_update'])) $is_update=$user['is_update'];
									
									if(isset($user['is_update'])) $is_update=$user['is_update'];
									else $is_update="";
									
									$trCss="";
									if($is_update=="Y") $trCss="updateRows";
									
									if(isset($user['action_status'])) $action_status=$user['action_status'];
									else $action_status="";
								?>
									<tr>
										<?php if($filter_id==""){ ?>
										<td>
										<label class='lbl_chk'><input type="checkbox" class="check_row" name='sel_uids' value="<?php echo $user_id;?>" /></label>
										</td>
										<?php } ?>
										
										<td><?php echo $i++; ?></td>
										<td><?php echo $user['fusion_id']; ?></td>
										<?php if($filter_id!=2){ ?>
											<td><?php echo $omuid;?></td>
										<?php } ?> 
										<td><?php echo $user['fname'] . " ". $user['lname']; ?></td>
										<td><?php echo $user['dept_name']; ?></td>
										<td><?php echo $user['client_name']; ?></td>
										<td><?php echo $user['office_id']; ?></td>
										<!-- <td><?php //echo $user['site_name']; ?></td> -->
										<td><?php echo $user['role_name']; ?></td>
										<td><?php echo $user['process_name'] /*. " ".$user['sub_process_name']*/; ?></td>
										<?php if($filter_id==2){ ?>
											<td><?php echo $user['in_time']?></td>
											<td><?php echo $llis?></td>
										<?php } ?>	
										<?php 
										
											
											
											if($filter_id==6){
																										
													$user_id=$user['id'];
													$lwd=$user['lwd'];
													$llogout_time=$user['llogout_time'];
													$term_date=$user['terms_date'];
													$comments=$user['comments'];
													
													
												echo "<td>".$lwd."</td>";												
												echo "<td>".$llogout_time."</td>";
												echo "<td>".$term_date."</td>";	
												echo "<td>".$user['t_type_name']."";
												echo "<br>".$user['sub_t_type_name']."</td>";
												echo "<td>".$comments."</td>";
												echo "<td>".$user['raised_by']."</td>";
												
												echo "<td width='160px'>";
												
												$terms_date= mdyDateTime2MysqlDate($user['terms_date']);		//echo $terms_date;
												$lwd = mysql2mmddyy($lwd);
												
												if(is_access_complete_kterm()){ 
														
													echo "<button uid='$user_id' lwd='$lwd' type='button' class='completeKnownTerm btn btn-info btn-xs'>Complete Term</button> &nbsp; ";
													
													echo "<button title='Cancel Termination' uid='$user_id' type='button' class='cancelTermination btn btn-danger btn-xs'><i class='fa fa-times' aria-hidden='true'></i></button>";
												
												}else
													echo "<span class='label label-info'>Pending HR Confirmation </span> &nbsp;";
												
												echo "</td>";
											
											}else if($filter_id==7 ){
												
												$user_id=$user['user_id'];
											
												echo "<td>".$user['asign_tl']."</td>";
												echo "<td>".$user['from_date'] . " To " . $user['to_date'] ."</td>";
												echo "<td>".$user['comments']."</td>";
												echo "<td>".$user['evt_by_name']."</td>";
																								
												$ufusion_id=$user['fusion_id'];
												
												echo '<td width="150px">';
												
												echo "<button uid='$user_id' fromdt='".$user['from_date']."' todt='".$user['to_date']."' title='revoke Suspension' type='button' class='cancelSuspension btn btn-primary btn-xs'>Revoke </button>&nbsp;";
												
												echo "&nbsp;<a target='_blank' title='View Profile' href='".base_url()."profile/$ufusion_id'><button title='View Profile' fid='$ufusion_id' type='button' class='btn btn-primary btn-xs'><i class='fa fa-user' aria-hidden='true'></i></button></a>&nbsp;";
												
												if($action_status=="P")
													echo "<button title='Disable For NCNS Term Request' type='button' class='btn btn-default btn-xs'><i class='fa fa-user-times' aria-hidden='true'></i></button>";
												else
													echo "<button title='Terminate' type='button' uid='$user_id' class='termsUserOth btn btn-danger btn-xs'><i class='fa fa-user-times' aria-hidden='true'></i></button>";
																
												echo '</td>';
											
											}else if($filter_id==5){
												
												$pre_user_id=$user['user_id'];
												$pre_row_id=$user['id'];
												
												$term_time=$user['term_time'];
												if($term_time!=""){
													$term_time=mysqlDt2mmddyy($term_time);
												}
												
												echo "<td>".$user['pre_req_date']."</td>";
												echo "<td>".$user['last_login_time']."</td>";
												echo "<td>".$user['last_logout_time']."</td>";
												//echo "<td>".$user['action_status']."</td>";
												echo "<td>".$user['next_shift_time']."</td>";
												echo "<td>".$user['term_time']."</td>";
												
												echo "<td width='250px;'>";
											
												if(is_access_complete_kterm()){
												
													if($is_update=="N") echo "<button uid='$pre_user_id' preRowId='$pre_row_id' type='button' class='ncnsFinalTermsReq btn btn-info btn-xs'>Complete Term Request</button>";
													else if(CurrMySqlDate()>=$user['term_time']){
														echo "<button title='Terminate' type='button' trm_tm='$term_time' uid='$pre_user_id' class='termsUser btn btn-danger btn-xs'><i class='fa fa-user-times' aria-hidden='true'></i></button>";
													}
													echo "&nbsp;<button title='Reject Term Request' type='button' uid='$pre_user_id' preRowId='$pre_row_id' class='rejectPreTermsReq btn btn-primary btn-xs'><i class='fa fa-times' aria-hidden='true'></i></button>";
												}
											
												echo "&nbsp</td>";
												
										}else{
												
													$client_id=$user['client_ids'];
													
													echo "<td>".$user['asign_tl']."</td>";
												
													$assigned_tl=$user['assigned_to'];
													
													$_role_id=$user['role_id'];
													$_is_logged_in=$user['is_logged_in'];
													$_status=$user['status'];
													
													
																								
													$disposition_id=$user['disposition_id'];
													$disp_name=$user['disp_name'];
													
													if($disposition_id==1) $bclass="label-default";
													else if( $disposition_id==2) $bclass="label-danger";
													else if($disposition_id==3 ) $bclass="label-warning";
													else if($disposition_id==4 ) $bclass="label-primary";
													else $bclass="label-info";
													
													$tLtime = "";
													if( isset($user['tLtime'])) $tLtime=$user['tLtime'];
													
													if($filter_id==2 || $filter_id==3){
														
														$_loggedHour=$user['loggedHour'];
														
														if($_is_logged_in==1) echo '<td><span class="label label-success">'.$_loggedHour.' Hrs.</span></td>';
														else if($tLtime!="") echo '<td><span class="label label-success">'.$tLtime.' Hrs.</span></td>';
														else echo '<td>-</td>';
													}
													
													if($filter_id!=2){
														if($_is_logged_in==1) echo '<td>-</td>';
														else if($_is_logged_in!=1 && $tLtime!="") echo '<td><span class="label label-success">P</span></td>';
														else{
															if($filter_id==4)
																	echo '<td><span class="label '.$bclass.'">'.$disp_name. ' ('.$user['start_date']. '-'.$user['end_date'].') </span></td>';
															else 
																echo '<td><span class="label '.$bclass.'">'.$disp_name.'</span></td>';
														}
													}
																									
												echo '<td width="150px">';
												
													//if(is_access_operations_module()){
													
														if($disposition_id==1 && $tLtime=="" && $filter_id!=7){
														
															if($action_status=="P")
																echo "<button title='Disable For NCNS Term Request' type='button' class='btn btn-default btn-xs'>Edit Status</button>";
															else 
																echo "<button uid='$user_id' cid = '$client_id' disp_id='$disposition_id' type='button' class='editDisposition btn btn-primary btn-xs'>Edit Status</button>&nbsp;";
														}
														
														//	if($_is_logged_in!=1){
															
																$ufusion_id=$user['fusion_id'];
																
																echo "&nbsp;<a target='_blank' title='View Profile' href='".base_url()."profile/$ufusion_id'><button title='View Profile' fid='$ufusion_id' type='button' class='btn btn-primary btn-xs'><i class='fa fa-user' aria-hidden='true'></i></button></a>&nbsp;";
															
																if($action_status=="P")
																	echo "<button title='Disable For NCNS Term Request' type='button' class='btn btn-default btn-xs'><i class='fa fa-user-times' aria-hidden='true'></i></button>";
																else
																	echo "<button title='Terminate' type='button' uid='$user_id' class='termsUserOth btn btn-danger btn-xs'><i class='fa fa-user-times' aria-hidden='true'></i></button>";
																
														//	}
														
														
														
														//if($_is_logged_in==1 && $_loggedHour>9)  echo "<button uid='$user_id' type='button' class='btn btn-danger btn-xs'>Force Logout</button>";
													//}
													
												echo '</td>';
												
											}
											
											?>
										
									</tr>
									
											
								<?php endforeach; ?>
										
								</tbody>
							</table>
						</div>
					</div><!-- .widget-body -->
					
					
				</div><!-- .widget -->
			</div>
			<!-- END DataTable -->	
			
		</div><!-- .row -->
				
		
	</section> <!-- #dash-content -->
	
	
	
	
	
<!-- Model bootstrap-->
<div class="modal fade" id="sktPreTermModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	 
	  
	<form class="frmPreTermReq" onsubmit="return false" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Manage NCNS Termination</h4>
      </div>
      <div class="modal-body">
					
			<input type="hidden" class="form-control required" id="pTermUid" name="pTermUid" required>
			<input type="hidden" class="form-control required" id="preRowId" name="preRowId" required>
			<input type="hidden" class="form-control" id="lastDispDt" name="lastDispDt" required>
			
			<div class="form-group" id="div_pre_term_user_info">
						
			</div>
						
			<div class="form-group">
				<label for="name">Next Shift Time</label>
				<input type="text" class="form-control required" id="next_shift_time" placeholder="Enter Next Shift Time" name="next_shift_time" required>
			</div>
			
			<div class="form-group" id='div_prevDispWithRO' style="display:none;">
				<label for="chk_prevDispWithRO" id='lb_PrevDispWithRO'></label>
				<div class="form-control">
				<!-- <input type="checkbox"  name="chk_prevDispWithRO" id='chk_prevDispWithRO' value="Y"> -->
				<span id='text_chk_prevDispWithRO' ></span>
				</div>
			</div>				
									
			<div class="form-group">
					<label for="terms_time">Termination Time:</label>
					<input type="text" class="form-control required" id="terms_time" placeholder="Enter Termination Date" name="terms_time" required>
			</div>
						
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id='updatePreTermReq' class="btn btn-primary">Save changes</button>
      </div>
	  
	 </form>
	  
    </div>
  </div>
</div>


<!-- Model bootstrap-->
<div class="modal fade" id="sktRejPreTermModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	 
	  
	<form class="frmRejPreTermReq" onsubmit="return false" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Reject NCNS Termination</h4>
      </div>
      <div class="modal-body">
					
			<input type="hidden" class="form-control required" id="rejPreTermUid" name="rejPreTermUid" required>
			
			<input type="hidden" class="form-control required" id="rejPreRowId" name="rejPreRowId" required>
			
									
			<div class="form-group">
				<label for="name">Remarks::</label>
				<input type="text" class="form-control required" id="action_desc" placeholder="Enter Remarks" name="action_desc" required>
			</div>
						
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id='updateRejPreTermReq' class="btn btn-primary">Save changes</button>
      </div>
	  
	 </form>
	  
    </div>
  </div>
</div>

<!-- for Complete pre terminate users (NCNS) Not required -->

<div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
		
		<form class="frmTermsUser" onsubmit="return false" method='POST'>
			
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Terminatation User</h4>
			</div>
			
			<div class="modal-body">
								
				<input type="hidden" class="form-control" id="tuid" name="tuid" required>
												
				<div class="form-group">
					<label for="terms_date">Termination Date:</label>
					<input type="text" class="form-control" id="terms_date" placeholder="Enter Termination Date" name="terms_date" required>
				</div>
				
				
				<div class="form-group">
					<label for="ticket_no">Ticket No:</label>
					<input type="text" class="form-control" placeholder="Enter Ticket No" id="ticket_no" name="ticket_no" required>
				</div>
				
				<div class="form-group">
					<label for="ticket_date">Ticket Date:</label>
					<input type="text" class="form-control" placeholder="Enter Ticket Date" id="ticket_date" name="ticket_date" required>
				</div>
			
			
				<div class="form-group">
					<label for="name">Comments:</label>
					<textarea rows="4" cols="50" class="form-control" id="comments" placeholder="Enter Comments" name="comments" required></textarea>
				</div>
				
			</div>
	  
	   
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id='terminateUser' class="btn btn-primary">Terminate user</button>
      </div>
	  
		</form>
	
	</div>
   </div>
</div>

<!-- for Terminate users 1st -->
<div class="modal fade" id="termsModalOth" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
		
		<form class="frmTermsUserOth" onsubmit="return false" method='POST'>
			
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabelOth">Terminatation User</h4>
			</div>
			
			<div class="modal-body">
								
				<input type="hidden" class="form-control" id="tuid_oth" name="uid" required>
				<input type="hidden" class="form-control" value='7' name="event_master_id" required>
				
				<div class="form-group">
					<label for="lwd">Last Working Date:</label>
					<input type="text" class="form-control" placeholder="Last Working Date" value='' id="lwd_oth" name="lwd" required>
				</div>
				
				<div class="form-group">
					<label for="terms_date">Termination Date:</label>
					<input type="text" class="form-control" placeholder="Enter Termination Date" value='<?php echo CurrDateTimeMDY()?>' id="terms_date_oth" name="terms_date" required>
				</div>
				
				<div class="form-group">
				<label for="role">Select Termination Type</label>
					<select class="form-control" id="t_type_oth" name="t_type" required>
						<option value=''>-- Select Term Type --</option>
						<?php foreach($ttype_list as $ttype): ?>
							<option value="<?php echo $ttype['id'] ?>"><?php echo $ttype['name'] ?></option>
						<?php endforeach; ?>									
					</select>
				</div>
				
				<div class="form-group">
					<label for="role">Select Sub Termination Type</label>
					<select class="form-control" id="sub_t_type_oth" name="sub_t_type" required>
						<option value=''>-- Select Sub Term Type --</option>
						<?php foreach($sub_ttype_list as $sub_ttype): ?>
							<option value="<?php echo $sub_ttype['id'] ?>"><?php echo $sub_ttype['name'] ?></option>
						<?php endforeach; ?>									
					</select>
				</div>
				
				<div class="form-group">
					<label for="role">Eligible for Rehire</label>
					<select class="form-control" id="is_rehire" name="is_rehire" required>
						<option value=''>-- Select Eligibility --</option>
						<option value="Y">Yes</option>									
						<option value="N">No</option>									
					</select>
				</div>
								
				<div class="form-group" id="term_comment">
					<label for="name">Comments:</label>
					<textarea rows="4" cols="50" class="form-control" placeholder="Enter Comments" id='remarks_oth' name="remarks" required></textarea>
				</div>
				
				<div class="form-group" id="resign_comment">
					<label for="role">Select Resign Reason</label>
					<select class="form-control" id="resign_remarks" name="remarks">
						<option value=''>-- Select Term Type --</option>
						<?php foreach($resign_reason as $rr): ?>
							<option value="<?php echo $rr['description'] ?>"><?php echo $rr['description'] ?></option>
						<?php endforeach; ?>									
					</select>
				</div>
				
			</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id='terminateUserOth' class="btn btn-primary">Terminate user</button>
      </div>
	  
		</form>
	
	</div>
   </div>
</div>

<!-- for Update Status -->
	
<!-- Model bootstrap-->
<div class="modal fade" id="sktModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	 	  
	<form class="editDisp" onsubmit="return false" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Status</h4>
      </div>
      <div class="modal-body">
					
			<input type="hidden" class="form-control" id="uid" name="uid" required>
			
			<input type="hidden" class="form-control" id="linDate" name="linDate" >
			<input type="hidden" class="form-control" id="loutDate" name="loutDate" >
			<input type="hidden" class="form-control" id="cid" name="cid" >
						
			<div class="form-group">
			<label for="role">Select a Status</label>
				<select class="form-control" name="event_master_id" id="event_master_id" required>
					<option value=''>-- Select a Status --</option>
					<?php foreach($disp_list as $disp): 
							
					?>
						<option value="<?php echo $disp->id ?>"><?php echo $disp->description ?></option>
					<?php endforeach; ?>									
				</select>
			</div>
			
			<div class="form-group" id='div_kterms_date' style="display:none;">
					<label for="kterms_date">Termination Date:</label>
					<input type="text" class="form-control" id="kterms_date" placeholder="Enter Termination Date" name="kterms_date" readonly required>
			</div>
						
			<div class="form-group" id='div_start_date' >
				<label id='lbl_start_date' for="name">Date (mm/dd/yyyy)</label>
				<input type="text" class="form-control" id="start_date" value='' name="start_date" required>
			</div>
			
						
			<div class="form-group" id='div_end_date'>
				<label id='lbl_end_date' for="name">End Date (mm/dd/yyyy)</label>
				<input type="text" class="form-control" id="end_date" value='' name="end_date" >
			</div>
			
						
			<div class="form-group" id='div_request_type' style="display:none;" >
				<label for="us_request_type">Request Type:</label>
				<select class="form-control" name="request_type" id="request_type">
					<option value=''>-- Select Request Type --</option>
						<option value="Medical Leave">Medical Leave</option>
						<option value="Vacation/RTO">Vacation/RTO</option>
						<option value="Non Medical/Personal">Non Medical/Personal</option>
				</select>
				
			</div>
						
			<div class="form-group" id='div_request_id' style="display:none;" >
				<label for="ut_request_id">Request ID:</label>
				<input type="text" class="form-control" placeholder="Enter Request ID" id="us_request_id" name="request_id">
			</div>
				
			<div class="form-group" id='div_ticket_no' style="display:none;">
				<label for="ticket_no">Ticket No If Any:</label>
				<input type="text" class="form-control" placeholder="Enter Ticket No" id='us_ticket_no' name="ticket_no">
			</div>
			
			<div class="form-group" id='div_term_type' style="display:none;">
			<label for="role">Select Termination Type</label>
				<select class="form-control" name="t_type" id="t_type">
					<option value=''>-- Select Term Type --</option>
					<?php foreach($ttype_list as $ttype): ?>
						<option value="<?php echo $ttype['id'] ?>"><?php echo $ttype['name'] ?></option>
					<?php endforeach; ?>									
				</select>
			</div>
			
			<div class="form-group" id='div_sub_term_type' style="display:none;">
			<label for="role">Select Sub Termination Type</label>
				<select class="form-control" name="sub_t_type" id="sub_t_type" required>
					<option value='' >-- Select Sub Term Type --</option>
					<?php foreach($sub_ttype_list as $subttype): ?>
						<option value="<?php echo $subttype['id'] ?>"><?php echo $subttype['name'] ?></option>
					<?php endforeach; ?>									
				</select>
			</div>
						
			
			<div id='div_schedule_data' style="display:none;">
			
				<div class="row">
				
					<div class="col-md-6">
						<div class="form-group">
							<label for="omuid">Day</label>
							<input type="text" class="form-control" id="edshday" name="shday" placeholder="Day"  readonly>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<label for="omuid">In Time</label>
							<input type="text" class="form-control" id="edin_time" name="in_time" placeholder="In time" >
						</div>
					</div>
				</div>
				
				<div class="row">
					
					<div class="col-md-6">
						<div class="form-group">
							<label for="omuid">Break - 1</label>
							<input type="text" class="form-control" id="edbreak1" name="break1" placeholder="break 1" >
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<label for="omuid">Lunch</label>
							<input type="text" class="form-control" id="edlunch" name="lunch" placeholder="Lunch" >
						</div>
					</div>
				</div>
				
				<div class="row">
					
					<div class="col-md-6">
						<div class="form-group">
							<label for="omuid">Break - 2</label>
							<input type="text" class="form-control" id="edbreak2" name="break2" placeholder="break1" >
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<label for="omuid">Out Time</label>
							<input type="text" class="form-control" id="edout_time" name="out_time" placeholder="OUT" >
						</div>
					</div>
				</div>
			</div>
			
			
			<div class="form-group">
				<label for="name">Comment</label>
				<textarea rows="2" cols="50" class="form-control" placeholder="Enter Comments" id='remarks' name="remarks" ></textarea>
			</div>
						
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id='updateDisp' class="btn btn-primary" >Save changes</button>
      </div>
	  
	 </form>
	  
    </div>
  </div>
</div>


<!-- for Complete Known term -->

<!-- Model bootstrap-->
<div class="modal fade" id="sktUdateTermModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	 
	  
	<form class="frmUdateTerm" onsubmit="return false" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Terminatation User</h4>
      </div>
      <div class="modal-body">
								
				<input type="hidden" class="form-control" id="ut_uid" name="ut_uid" required>
				
				<div class="form-group">
					<label for="lwd">Last Working Date:</label>
					<input type="text" class="form-control" placeholder="Last Working Date" value='' id="ut_lwd" name="lwd" required>
				</div>
				
				<div class="form-group">
					<label for="ut_request_id">Request ID (If any):</label>
					<input type="text" class="form-control" placeholder="Enter Request ID" id="ut_request_id" name="ut_request_id">
				</div>
				
				<div class="form-group">
					<label for="ticket_no">Ticket/Ref No (If any) :</label>
					<input type="text" class="form-control" placeholder="Enter Ticket No" id="ut_ticket_no" name="ut_ticket_no" >
				</div>
				
				<div class="form-group">
					<label for="ut_ticket_date">Ticket/Ref Date (If any):</label>
					<input type="text" class="form-control" placeholder="Enter Ticket Date" id="ut_ticket_date" name="ut_ticket_date" >
				</div>
			
				<!--
				<div class="form-group">
					<label for="name">Comments:</label>
					<textarea rows="4" cols="50" class="form-control" id="ut_comments" placeholder="Enter Comments" name="ut_comments" required></textarea>
				</div>
				-->
				
			</div>
	  
	   
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id='updateTerminateUser' class="btn btn-primary">Terminate user</button>
      </div>
	  
		</form>
	
	</div>
   </div>
</div>




<div class="modal fade" id="sktSuspensionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	 	  
	<form class="frmSuspensionReq" onsubmit="return false" method='POST'>
		
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Cancel Suspension</h4>
      </div>
      <div class="modal-body">
					
			<input type="hidden" class="form-control" id="csuid" name="csuid" required>
			
			<div class="form-group" id='div_ret_date'>
				<label id='lbl_ret_date' for="name">Final Return Date (mm/dd/yyyy)</label>
				<input type="text" class="form-control" id="final_return_date" value='' name="final_return_date" >
			</div>
			
			<div class="form-group">
				<label for="name">Remarks::</label>
				<input type="text" class="form-control required" id="update_comments" placeholder="Enter Remarks" name="update_comments" required>
			</div>
						
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" id='btnCancelSuspension' class="btn btn-primary">Cancel Suspension</button>
      </div>
	  
	 </form>
	  
    </div>
  </div>
</div>



<!--- cancel popup -->

<div class="modal fade" id="cancelpopupModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  <form class="frmCancelTermination" onsubmit="return false" method='POST'>
	  
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Cancel Termination</h4>
      </div>
      <div class="modal-body">
			<input type="hidden" class="form-control" id="ct_uid" name="uid" required>
			
		<div class="form-group">
			<label>Remarks</label>
				<textarea class="form-control" id="ct_update_remarks" name="ct_update_remarks" required></textarea>
		</div>
		
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="submit" id='btnCancelTermination' class="btn btn-primary">Save changes</button>
		</div>
		
	  </form>
	  
    </div>
  </div>
 </div>
</div>	
	
	
	
	
</div><!-- .wrap -->


