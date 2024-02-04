	
	
	<div class="row mb-4">
		<div class="col-md-12 grid-margin">
			<div class="d-flex justify-content-between flex-wrap">
				<div class="d-flex align-items-center dashboard-header flex-wrap mb-3 mb-sm-0">
					<h5 class="mr-4 mb-0 font-weight-bold">
						<?php echo !empty($page_title) ? $page_title : "Today Ticket"; ?>
					</h5>                           
				</div>                        
			</div>
		</div>
	</div>
	
	<div class="top-filter">
		<div class="card">
			<div class="card-body searchBodyDiv">
			<form id="searchTicketForm" method="GET" autocomplete="off" enctype="multipart/form-data">
				<div class="row">
				
					<div class="col-sm-6">
					<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
						  <label>Phone No</label>
						  <input type="text" minlen="5" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control numberCheckPhone" value="<?php echo $search_phone; ?>"name="search_phone" required>
						</div>
					</div>
					<div class="col-sm-12">
						<div class="form-group">
						  <label>Ticket No</label>
						  <input type="text" minlen="5" class="form-control" value="<?php echo $search_ticket; ?>"name="search_ticket" required>
						</div>
					</div>
					</div>
					</div>
					
					<div class="col-sm-6">
					<div class="row">
					<div class="col-md-12">					
					<div class="row captchaDIV">
					<div style="width:300px;margin:0 auto;margin-top:40px">
					<p style="text-align:center" id="image_captcha"><?php echo $captchaImg; ?></p>
					<div class="form-group">
					<div class="input-group flex-nowrap">
					  <div class="input-group-prepend">
						<span class="input-group-text" style="font-size: 11px;"><a href="javascript:void(0);" class="captcha-refresh"><i class="fa fa-refresh"></i></a></span>
					  </div>
					  <input type="text" class="form-control" placeholder="Enter Captcha" name="captcha" required>
					</div>
					</div>
					</div>
					</div>
					</div>
					</div>
					</div>
					
					<div class="col-sm-6">
					<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<button type="button"  style="width:300px" style="margin-top:30px" class="search-btn verify_captcha_search">Search</button>
						</div>
					</div>
					</div>
					</div>
					
				</div>
			</form>
			</div>
		</div>
	</div>


<?php if(!empty($search_result)){ ?>	
	
	<div class="common-top">
		<div class="middle-content">
			<div class="row align-items-center">
				<br/>
			</div>
			
			<div class="card padderCard">
				<div class="card-body">
				

<?php if(!empty($tickets_list)){ ?>
<div class="row">

<div class="col-md-6">
<h5><i class="fa fa-bell"></i> TICKET STATUS</h5>
<hr style="margin-top:5px;margin-top:5px" />
<p class="boxInfo">
<span><b>TICKET NO : </b></span><?php echo $tickets_list[0]['ticket_no']; ?><br/>
<span><b>STATUS : </b></span><span class="font-weight-bold text-<?php echo hth_ticket_status_color($tickets_list[0]['ticket_status']); ?>"><?php echo hth_ticket_status($tickets_list[0]['ticket_status']); ?></span><br/>

</p>
</div>

<div class="col-md-6">
<h5><i class="fa fa-calendar-o"></i> INFO DETAILS</h5>
<hr style="margin-top:5px;margin-top:5px" />
<p class="boxInfo">
<span><b>TICKET DATE : </b></span><?php echo $tickets_list[0]['ticket_date']; ?><br/>
<span><b>TICKET TIME : </b></span><?php echo date('H:i:s', strtotime($tickets_list[0]['date_added'])); ?><br/>
<span><b>CALL TYPE : </b></span><?php echo $tickets_list[0]['call_type_name']; ?><br/>
</p>
</div>

</div>

<hr/>

<div class="row">

<div class="col-md-6">
<h5><i class="fa fa-pie-chart"></i> CALL DETAILS</h5>
<hr style="margin-top:5px;margin-top:5px" />
<p class="boxInfo">
<span><b>FRANCHISEE TYPE : </b></span><?php echo !empty($tickets_list[0]['franchisee_type']) ? hth_dropdown_franchisee_type($tickets_list[0]['franchisee_type']) : "n/a"; ?><br/>
<span><b>DISPOSITION TYPE : </b></span><?php echo !empty($tickets_list[0]['disposition_type']) ? $tickets_list[0]['disposition_name'] : "n/a"; ?><br/>
<span><b>FIRSTNAME : </b></span><?php echo $tickets_list[0]['customer_fname']; ?><br/>
<span><b>LASTNAME : </b></span><?php echo $tickets_list[0]['customer_lname']; ?><br/>
<span><b>PHONE NO : </b></span><?php echo $tickets_list[0]['customer_phone']; ?><br/>
<span><b>CONTACT REASON : </b></span><?php echo !empty($tickets_list[0]['customer_reason']) ? $tickets_list[0]['reason_name']: "N/A"; ?><br/>
<span><b>SUB REASON : </b></span><?php echo !empty($tickets_list[0]['customer_subreason']) ? $tickets_list[0]['sub_reason_name'] : "N/A"; ?><br/>
<span><b>COMMENTS : </b></span><?php echo $tickets_list[0]['customer_comments']; ?><br/>
</p>
</div>

<div class="col-md-6">
<h5><i class="fa fa-pie-chart"></i> ADDRESS DETAILS</h5>
<hr style="margin-top:5px;margin-top:5px" />
<p class="boxInfo">
<span><b>DISTRICT : </b></span><?php echo $tickets_list[0]['call_district']; ?><br/>
<span><b>CITY : </b></span><?php echo $tickets_list[0]['call_city']; ?><br/>
<span><b>POST OFFICE : </b></span><?php echo !empty($tickets_list[0]['call_postoffice']) ? $tickets_list[0]['call_postoffice'] : "n/a"; ?><br/>
<span><b>PINCODE : </b></span><?php echo !empty($tickets_list[0]['call_pincode']) ? $tickets_list[0]['call_pincode'] : "n/a"; ?><br/><br/>
<span><b>ADDRESS : </b></span><?php echo !empty($tickets_list[0]['call_address']) ? $tickets_list[0]['call_address'] : "n/a"; ?><br/>
</p>
</div>

</div>

<hr/>

<div class="row">

<div class="col-md-12">
<h5><i class="fa fa-pie-chart"></i> COMMENTS</h5>
<hr style="margin-top:5px;margin-top:5px" />
<p class="boxInfo">
<?php 
if(!empty($tickets_logs)){ 
foreach($tickets_logs as $ltoken){ 
if($ltoken['log_type'] == "comments"){
?>
<span><b><?php echo $ltoken['agent_name']; ?> : <?php echo $ltoken['date_added']; ?><br/></b></span><?php echo !empty($ltoken['log_comments']) ? $ltoken['log_comments'] : "n/a"; ?><br/><br/>
<?php } } } else { ?>
<span class="text-danger">-- No Comments Found --</span>
<?php } ?>
</p>
</div>

</div>

<?php } else { ?>

<div class="row">
<div class="col-md-12">
<span class="text-danger">-- No Search Result Found! --</span>
</div>
</div>
<?php } ?>		
					
					
				</div>
			</div>
		</div>
	</div>
<?php } ?>			
			
			
<div class="modal fade" id="viewTicketsModal" tabindex="-1" role="dialog" aria-labelledby="viewTicketsModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width:60%">
    <div class="modal-content">
      <div class="modal-header">        
        <h4 class="modal-title">Ticket Details</h4>
		<button type="button" class="close" data-dismiss="modal" data-toggle="validator" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">	  
	  
	  </div>	  
      <div class="modal-footer">	 
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>