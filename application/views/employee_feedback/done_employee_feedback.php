<style>
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:2px;
		text-align: center;
		font-size:12px;
	}
	
	.table2 > thead > tr > th, .table2 > thead > tr > td, .table2 > tbody > tr > th, .table2 > tbody > tr > td, .table2 > tfoot > tr > th, .table2 > tfoot > tr > td {
		padding:2px;
		text-align: center;
		font-size:12px;
	}
	
	.bg-info-light{
		background-color:#afe1f0;
		color: #0c064f;
	}
	
	.label {
		font-size: 85%;    
	}


</style>

<div class="wrap">
<section class="app-content">


<div class="row">
<div class="col-md-12">
   <h2 class="text-center" style="margin-top: 100px;">Feedback Submitted for <?php echo $FeedBackQuarter; ?> Quarter</h2>
   <h4 class="text-center">Thank You For Your Feedback.</h4>
   <br/>
</div>
</div>


<div class="row">
<div class="col-md-12">
<div class="widget">

<header class="widget-header">
	<h4 class="widget-title">Your Past Feedbacks</h4>
</header>
	
<hr class="widget-separator">

<div class="widget-body">
<table id="default-datatable" data-plugin="DataTable" class=" table2 table-striped skt-table" cellspacing="0" width="100%">
	<thead>
		<tr class='bg-primary'>
			<th>Quarter Year</th>
			<th>Department</th>
			<th>L1 Supervisor</th>
			<th>Employee Name</th>
			<th>Total Score</th>
			<th>Overall</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($performancedata as $tokendata){ ?> 
		<tr>
			<td><?php echo $tokendata['year_quarter']; ?></td>
			<td><?php echo $tokendata['department_name']; ?></td>
			<td><?php echo $tokendata['added_for']; ?></td>
			<td><?php echo $tokendata['added_by']; ?></td>
			<td><?php echo $tokendata['total_score']; ?></td>
			<td><?php echo $tokendata['overall']; ?></td>
			<td>
			<a title="View Feedback" fid="<?php echo $tokendata['performance_id']; ?>" class="openfeedback btn btn-primary btn-xs"><i class="fa fa-eye" aria-hidden="true"></i></a>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
</div>


</div>
</div>
</div>


</section>
</div>


<div class="modal fade" id="modalfeedbackdetails" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" >View Feedback Details</h4>
			</div>
			
			<div class="modal-body" id="feedbackbody">
			
			
				
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
				
		</div>
	</div>
</div>
