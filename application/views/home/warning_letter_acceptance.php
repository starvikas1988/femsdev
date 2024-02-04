<style>
		
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:5px;
		font-size:14px;
	}
	
.prevAttachDiv{
	background-color:#f5f5f5;
	float:left;
	position:relative;
	height:auto; min-height:70px;
	width:100%;
	border:1px solid #ccc; 
	padding:3px;
	z-index:0;
}

.currAttachDiv{
	background-color:#f5f5f5;
	float:left;
	position:relative;
	height:auto; min-height:70px;
	width:100%;
	border:1px solid #ccc; 
	padding:3px;
	z-index:0;
	display:none;
}

.attachDiv{
	width: 50px;
	height: 50px;
	float:left;
	padding:1px;
	border:2px solid #ccc; 
	margin:5px;
	position:relative;
	cursor:pointer;
}

.attachDiv img{
	width: 100%;
	height: 100%;
	position:relative;
}

.deleteAttach{
	display:none;
	cursor:pointer;
	top:0;
	right:0;
	position:absolute;
	z-index:99;
}

input[type="checkbox"]{
  width: 20px;
  height: 20px;
}

html,
body {
    height: 100%;
}

.container {
    height: 100%;
    /*display: flex;*/
    justify-content: center;
    align-items: center;
}
</style>

<?php 
	if(get_user_office_id()=="CHA") $compName=" CSPL ";
	else $compName=" Fusion ";
?>
	


	
<div class="container">
	<section class="app-content">	
	<br/>
	

	
		<div class="row">
		
		<!-- DataTable -->
		<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Pending Warning Letter Acceptance</h4>
					</header><!-- .widget-header -->
					<hr class="widget-separator">
						
					<div class="widget-body">
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class='bg-info'>
									    <th>Warning Level</th>
										<th>Issue Date</th>
										<th>Review Date</th>
										<th>Details</th>
										<th> Action</th>
								
									</tr>
								</thead>
								
								<tfoot>
									<tr class='bg-info'>
									    <th>Warning Level</th>
										<th>Issue Date</th>
										<th>Review Date</th>
										<th>Reason</th>
										<th>Action</th>
									</tr>
								</tfoot>
	
								<tbody>
										<?php foreach ($warning as $key => $value) { ?>
										<tr>
											<td><?php echo $value['warning_level']; ?></td>
											<td><?php if($value['issued_date'] != "") echo date('d-m-Y', strtotime(date($value['issued_date']))); else echo "NA"; ?></td>
											<td><?php if($value['review_date'] != "") echo date('d-m-Y', strtotime(date($value['review_date']))); else echo "NA"; ?></td>
											
											<td><?php if($value['reason'] != "") echo $value['reason']; else echo "NA"; ?></td>
											
											<td>
													<?php 
													// print_r($value);
												$user_id =$value['user_id'];
												$warned_user_id =$value['id'];
											 	if($value['acceptance']==''){ 
											 ?>
												<button title="" titleJS="" adpid='<?php echo $value['id'] ?>' type='button' class='acptPolicy btn btn-warning btn-xs' data-toggle='modal'>Accept Warning</button> &nbsp;
												<?php }else{
														echo '<span style="color:green; font-size:14px"><b>Warning Accepted</b></span>';
													} 
												?>
												<a href='<?php echo base_url()."warning_mail_employee/send_mail/Y/$user_id/$warned_user_id" ?>' title='Download Warning Letter' class='btn btn-primary btn-xs'><i class='fa fa-download' aria-hidden='true'></i>
												</a>
												
												
											</td>
										</tr>	
										<?php } ?>	
								</tbody>
							</table>
						</div>
					</div><!-- .widget-body -->
					
				</div><!-- .widget -->
			</div>
			<!-- END DataTable -->	
						
		</div>
	
	
	
			
</section> 
</div>


<!------------------------------------------------------------------------------------------------>

<!--- Pending Policy Acceptance --->
<div class="modal fade" id="myPolicyModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
		<form class="frmPolicyAccept" method='POST' action="<?php echo base_url('') ?>warning_mail_employee/warning_letter_acceptance" data-toggle="validator">  
		
        <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Warning Acceptance</h4>
        </div>
		
        <div class="modal-body">
			<input type="hidden" id="w_id" name="w_id" value="">
			
			<div class="row">
				<div class="col-md-12">
					<input type="checkbox" id="p_status" name="p_status" required>
					Check here to indicate that you have read & accept this warning
				</div>
			</div>
			
        </div>
		
        <div class="modal-footer">
			<button type="submit" id='btnPolicyAccept' class="btn btn-primary">I Agree</button>
        </div>
		
		</form>
      </div>
      
    </div>
  </div>

<!--- --->



<script type="text/javascript">
    $(document).ready(function(){
		
		$(".acptPolicy").click(function(){
			var adpid=$(this).attr("adpid");	
			$('#w_id').val(adpid);
			$("#myPolicyModal").modal('show');		 
		});
		
		$('.frmPolicyAccept').submit(function(){
			if($('#p_status').prop("checked") == true){
				$("#myPolicyModal").modal('hide');
			}else{
				alert("Please select the CheckBox.");
			}
		});

    });
</script>


