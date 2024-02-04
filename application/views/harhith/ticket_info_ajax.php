<style>
#recordDetailsModal p.boxInfo{
	font-size:13px;
	color:#685f5f;
}
#recordDetailsModal p span{
	font-size:13px;
	font-weight:600;
	color:#684f4f;
}
</style>

<div class="row">

<div class="col-md-6">
<h5><i class="fa fa-bell"></i> INFO DETAILS</h5>
<hr style="margin-top:5px;margin-top:5px" />
<p class="boxInfo">
<span><b>TICKET NO : </b></span><?php echo $tickets_list[0]['ticket_no']; ?><br/>
<span><b>STATUS : </b></span><span class="font-weight-bold text-<?php echo hth_ticket_status_color($tickets_list[0]['ticket_status']); ?>"><?php echo hth_ticket_status($tickets_list[0]['ticket_status']); ?></span><br/>
<span><b>TICKET DATE : </b></span><?php echo $tickets_list[0]['ticket_date']; ?><br/>
<span><b>TICKET TIME : </b></span><?php echo date('H:i:s', strtotime($tickets_list[0]['date_added'])); ?><br/>
<span><b>CALL TYPE : </b></span><?php echo $tickets_list[0]['call_type_name']; ?><br/>
<span><b>ADDED BY: </b></span><?php echo $tickets_list[0]['agent_name']; ?><br/>
</p>
</div>

<div class="col-md-6">
<h5><i class="fa fa-calendar-o"></i> LOG INFO</h5>
<hr style="margin-top:5px;margin-top:5px" />
<p class="boxInfo">
<span><b>ASSIGNED BY : </b></span><?php echo !empty($tickets_list[0]['assigned_name_by']) ? $tickets_list[0]['assigned_name_by'] : "N/A"; ?><br/>
<span><b>ASSIGNED TO : </b></span><?php echo !empty($tickets_list[0]['assigned_name']) ? $tickets_list[0]['assigned_name'] : "N/A"; ?><br/>
<span><b>CLOSED BY : </b></span><?php echo !empty($tickets_list[0]['completed_name']) ? $tickets_list[0]['completed_name'] : "N/A"; ?><br/>
<span><b>CLOSED DATE : </b></span><?php echo !empty($tickets_list[0]['ticket_closed_date']) ? $tickets_list[0]['ticket_closed_date'] : "N/A"; ?><br/>
<span><b>CLOSED REMARKS : </b></span><?php echo !empty($tickets_list[0]['ticket_closed_reamrks']) ? $tickets_list[0]['ticket_closed_reamrks'] : "N/A"; ?><br/>
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
<span><b>ADDRESS : </b></span><?php echo $tickets_list[0]['call_address']; ?><br/>
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
