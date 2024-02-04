
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
	
	
</style>

<?php ///* ?>

<div class="wrap">
<ul class="nav nav-tabs" style="background:#fff">

<?php 
//, "TICKETS"
$category_list = array( "ALL", "INBOX", "DRAFTS", "SENT ITEMS");
foreach($category_list as $jkey=>$jval)
{	
	$urlFolder = preg_replace('/\s+/', '_', $jval);
	$tabClass = "style='color:#888181;font-weight:600;border-right:1px solid #eee;font-size:11px'";
	$alinkColor = "";
	if(!empty($this->uri->segment(4))){
		if($this->uri->segment(4) == $urlFolder)
		{
			$tabClass = "style='background-color:#3cc3b5;color:#fff;font-weight:600;font-size:11px'";
			$alinkColor = "style='color:#fff'";
		}
	}
?>
<li class="nav-item" <?php echo $tabClass; ?>>
  <a class="nav-link" href="<?php echo base_url()?>emat/view_mails/<?php echo bin2hex($email_id); ?>/<?php echo $urlFolder; ?>" <?php echo $alinkColor; ?> > <?php echo $jval; ?></a>
</li>
<?php } ?>
 </ul>
</div>


<?php //*/ ?>


<div class="wrap">
<section class="app-content">
	
<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title">EMAIL : <?php echo $email_id; ?>

<a onclick="javascript:window.location.reload()" class="btn btn-primary pull-right"><i class="fa fa-refresh"></i> Refresh</a>

<?php ///* ?>
<a href="<?php echo base_url()?>emat/view_mails/<?php echo bin2hex($email_id); ?>/<?php echo !empty($email_folder_check) ? $email_folder_check : "ALL"; ?>" class="btn btn-success pull-right" style="margin-right:10px"><i class="fa fa-envelope-o"></i> All</a>

<a href="<?php echo base_url()?>emat/view_mails/<?php echo bin2hex($email_id); ?>/<?php echo !empty($email_folder_check) ? $email_folder_check : "ALL"; ?>/unseen" class="btn btn-danger pull-right" style="margin-right:10px"><i class="fa fa-envelope-o"></i> Unread</a>
<?php //*/ ?>

</h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">					
<div class="table-responsive">
	
  <table id="default-datatable" class="table table-bordered mb-0 table table-striped skt-table" data-plugin="DataTable">  
    <thead>
      <tr class="bg-primary text-white">
	    <th scope="col">#</th>
        <th scope="col">Date</th>
        <th scope="col">From</th>
        <th scope="col">Subject</th>
        <th scope="col">Reference</th>
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
        <td scope="row"><b><?php echo date('Y-m-d h:i:s',$token['udate']); ?></b></td>
        <td scope="row"><b><?php echo $token['from']['email']; ?></b></td>
        <td scope="row"><b><?php echo $token['subject']; ?></b></td>
        <td scope="row"><b><?php echo "REF#".$token['uid']; ?></b></td>
		<td scope="row" class="text-center">
		<a style="cursor:pointer" class="btn btn-success btn-xs mailInfoDetails" efolder="<?php echo $email_folder_check; ?>" email="<?php echo bin2hex($email_id); ?>" eid="<?php echo $token['uid']; ?>">
		  <i class="fa fa-eye"></i> View Email Details
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