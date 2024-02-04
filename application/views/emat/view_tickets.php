
 <style>

	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		vertical-align:middle;
		padding:4px;
		font-size:11px;
	}
	
	.table > thead > tr > th,.table > tfoot > tr > th{
			text-align:center;
	}

	.inputTable > tr > td{
		font-size:12px;
		padding:4px;
	}
	
	.hide{
	  disply:none;	  
	}
	
	.modal-dialog {
		width: 800px;
	}
	.modal
	{
		overflow:auto;
	}
	#modalInfoDetails img{
	  display: block;
	  max-width:230px;
	  max-height:95px;
	  width: auto;
	  height: auto;
	  margin-top:2px;
	  margin-bottom:2px;
	}	
</style>



<div class="wrap">
<section class="app-content">
	
<div class="row">

<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title">EMAIL : <?php echo $email_id; ?>

<a onclick="javascript:window.location.reload()" class="btn btn-primary pull-right"><i class="fa fa-refresh"></i> Refresh</a>


<a target="_blank" href="<?php echo base_url()?>emat/cron_update_tickets/<?php echo bin2hex($email_id); ?>/" class="btn btn-danger pull-right" style="margin-right:10px"><i class="fa fa-envelope-o"></i> Update Tickets</a>


</h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">					
<div class="table-responsive">
	
  <table id="default-datatable" class="table table-bordered mb-0 table table-striped skt-table" data-plugin="DataTable">  
    <thead>
      <tr class="bg-primary text-white">
	    <th scope="col">#</th>
        <th scope="col">Ticket</th>
        <th scope="col">Date</th>
        <th scope="col">From</th>
        <th scope="col">Subject</th>
        <th scope="col">Category</th>
        <th scope="col">Status</th>
		<th scope="col">Action</th>
      </tr>
    </thead>
	
    <tbody>	
	<?php
	$countc = 0;
	foreach($messageList as $token){ 
		$countc++;
	?>	
      <tr>
        <td scope="row" class="text-center"><?php echo $countc; ?></td>
        <td scope="row"><b><?php echo $token['ticket_no']; ?></b></td>
        <td scope="row"><b><?php echo date('Y-m-d h:i:s',$token['e_udate']); ?></b></td>
        <td scope="row"><b><?php echo $token['ticket_email_from']; ?></b></td>
        <td scope="row"><b><?php echo $token['ticket_subject']; ?></b></td>
		<td scope="row"><b><?php echo $token['ticket_category']; ?></b></td>
        <td scope="row" title="<?php echo "REF#".$token['ticket_email_uid']; ?>">
		<b><?php echo $token['ticket_status'] == 'P' ? '<span class="text-danger">Open</span>' : '<span class="text-success">Closed</span>'; ?></b>
		</td>
		<td scope="row" class="text-center">
		<a style="cursor:pointer" class="btn btn-success btn-xs ticketMailInfoDetails" ticket_no="<?php echo $token['ticket_no']; ?>">
		  <i class="fa fa-eye"></i> View Email Details
		 </a>
		 <a style="cursor:pointer" class="btn btn-danger btn-xs ticketMailReply" ticket_no="<?php echo $token['ticket_no']; ?>">
		  <i class="fa fa-reply"></i>
		 </a>
		</td>
      </tr>
	<?php } ?>	
    </tbody>
  </table>
		
		
</div>

<br/><br/><br/><br/><br/>
<br/><br/><br/><br/><br/>
</div>
</div>
</div>


</div><!-- .row -->


<br/><br/><br/><br/><br/>

</div>		
</section>


	
</div><!-- .wrap -->





<div class="modal fade" id="modalInfoDetails" tabindex="-1" role="dialog" aria-labelledby="modalInfoDetails" aria-hidden="true">
  <div class="modal-dialog" style="width:90%">  
    <div class="modal-content">				
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title">EMail Details</h4>
		</div>		
		<div class="modal-body">
			<span class="text-danger">-- No Info Found --</span>
		</div>
	  <div class="modal-footer">			
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>			
	  </div>		
	</div>
</div>
</div>



<div class="modal fade" id="modalInfoReplyTicket" tabindex="-1" role="dialog" aria-labelledby="modalInfoReplyTicket" aria-hidden="true">
  <div class="modal-dialog">  
    <div class="modal-content">				
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title">Reply Ticket</h4>
		</div>		
		<div class="modal-body">
			<span class="text-danger">-- No Info Found --</span>
		</div>
	  <div class="modal-footer">			
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>			
	  </div>		
	</div>
</div>
</div>