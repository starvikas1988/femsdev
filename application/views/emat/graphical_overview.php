
<style>
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:2px;
		text-align: center;
	}
	
	#show{
		margin-top:5px;
	}
	
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
	
	.modal-dialog{
		width:800px;
	}
	table.google-visualization-orgchart-table {
		border-collapse: separate;
	}
	.headBar {
		background-color:#e7e7e7!important;
	}
</style>


<div class="wrap">
<section class="app-content">
	
	<div class="row">		
	<div class="col-md-12">
	<div class="widget headBar">
		<header class="widget-header">
		<h4 class="widget-title"><i class="fa fa-bar-chart"></i> EMAT Overall Overview</h4>
		</header>
	</div>
	</div>
		
	<div class="col-md-12">
		<div class="widget">
			<div class="widget-body">				
				<div class="row">	
				<div class="col-md-12 table-responsive">	
					<div id="g_email_box"></div>
				</div>
				
				<div class="col-md-6">	
					<div id="g_skill_box_all" style="height:300px"></div>
				</div>
				
				<div class="col-md-6">	
					<div id="g_ticket_box_all" style="height:300px"></div>
				</div>
				</div>				
			</div>
		</div>
	</div>
	</div>
		
	<br/>
	<?php foreach($category_list as $mailBOX){ ?>
	
	<div class="row">		
	<div class="col-md-12">
	<div class="widget headBar">
		<header class="widget-header">
		<h4 class="widget-title"><i class="fa fa-envelope"></i> <?php echo $mailBOX['email_name'] ." : " .$mailBOX['email_id']; ?></h4>
		</header>
	</div>
	</div>
		
	<div class="col-md-12">
		<div class="widget">
			<div class="widget-body">				
				<div class="row">	
				<div class="col-md-12 table-responsive">	
					<div id="g_email_box_<?php echo $mailBOX['id']; ?>"></div>
				</div>
				
				<div class="col-md-6">	
					<div id="g_skill_box_<?php echo $mailBOX['id']; ?>" style="height:300px"></div>
				</div>
				
				<div class="col-md-6">	
					<div id="g_ticket_box_<?php echo $mailBOX['id']; ?>" style="height:300px"></div>
				</div>
				</div>				
			</div>
		</div>
	</div>
	
	</div>
    <br/>

	<?php } ?>

<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>

</section>
</div>