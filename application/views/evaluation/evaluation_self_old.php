<style>

.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		vertical-align:middle;
		padding:4px;
	}
	
.table > thead > tr > th,.table > tfoot > tr > th{
		text-align:center;
}

</style>
<div class="wrap">
<section class="app-content">

<div class="row">
<div class="col-md-12">

		<div class="widget">
			<header class="widget-header">
				<h4 class="widget-title">Quarterly Job  Performance Evaluation Form</h4>
			</header><!-- .widget-header -->
			<hr class="widget-separator">
			
			<div class="widget-body">
				
				<div class="row">
				<div class="col-md-12">
					
					<div class="alert alert-info">
					 Employee Name:<b> <?php echo get_username(); ?></b>
					</div>
					
					<div class="panel panel-info">
						  <div class="panel-heading">Please read carefully and fill self</div>
						  <div class="panel-body">
						  1. Rate your performance, using the definitions below.<br>
						  2. Give an overall rating in the space provided, using the definitions below as a guide.
						</div>
					</div>
					<div class="panel panel-info">
						  <div class="panel-heading">Performance Rating Definitions:</div>
						  <div class="panel-body">
						  <i>The following ratings must be used to ensure commonality of language and consistency on overall ratings: (There should be supporting comments to justify ratings of “Outstanding” “Below Expectations, and “Unsatisfactory”).</i>
						  <br>
						  <br>
							a) Outstanding Performance is consistently superior : <b>5 points </b> <br>
							b) Exceeds Expectations Performance is routinely above job requirements: <b>4 points </b>  <br>
							c) Meets Expectations Performance is regularly competent and dependable: <b>3 points </b> <br>
							d) Below Expectations Performance fails to meet job requirements on a frequent basis: <b>2 points </b> <br>
							e) Unsatisfactory Performance is consistently unacceptable: <b>1 point </b> <br>
						  </ul>
						</div>
					</div>
				</div>
				</div>
				
				<div class="row">
				<div class="col-md-12 text-center">
					<a href='<?php echo base_url();?>user/evaluation_self_add'><button type="button" class="btn btn-success btn-md" id="add_more_user">Click here to proceed</button></a>					
				</div>
				
				</div>
	
			</div><!-- .widget-body -->
			
		</div><!-- .widget -->
	</div>
</div>

</section>
</div>