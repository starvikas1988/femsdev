<style>
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
	
</style>

<div class="wrap">
	<section class="app-content">
		<div class="row">
		
		<!-- DataTable -->
		<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">WFH Excel Import</h4>
					</header><!-- .widget-header -->
					<hr class="widget-separator">						
					<div class="widget-body">
  
                        <form class="genReport" action="<?php echo base_url()?>Excel_import/import_data" enctype='multipart/form-data' method='POST'>
                            <input type="file" name="upload_file" required accept=".xls, .xlsx">
                            <br>
                            <br>
                            <input type="submit" class="btn btn-sm btn-success" name="submit" value="Upload File">
                        </form>	
                    </div><!-- .widget-body -->
				</div><!-- .widget -->
			</div>
			<!-- END DataTable -->	
		</div><!-- .row -->
	</section>
</div><!-- .wrap -->
	