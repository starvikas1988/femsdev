<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/custom.css"/>

<style> 
input[type=submit]{
  background-color: #4c7aaf;
  border: none;
  color: white;
  padding: 10px 20px;
  text-decoration: none;
  margin: 4px 2px;
  border-radius: 3px!important;
}
.upload input[type="file"] {
  border: 1px solid #ccc!important;
  padding: 7px;
  margin-top: 5px;
 
}
.upload span{
	margin-bottom: 5px;
}
.margin-Top{
	margin-top: -21px;
}
.btn-excl {
  float: right;
  padding: 10px;
  width: 120px;
}
 .btn-view{
  border-radius: 50%;
  padding: 5px 9px!important;
}

</style>

<div class="wrap">
	<section class="app-content">
	
		<div class="row">
			<div class="col-12">
				<div class="widget">
					<div class="widget-body">
						<div class="compute-widget">
							<h4>Data Upload</h4>
							<hr class="widget-separator">
						</div>
					</div>
					<div class="widget-body">
						<div class="filter-widget-na compute-widget">
							<div class="row">
								<div class="col-sm-8">
									<div class="form-group margin-Top">
									
									<?= $this->session->flashdata('Success');?>
									<?= form_open( base_url('Qa_agent_coaching_upload/import_cdr_excel_data'),array('method'=>'post','enctype'=>'multipart/form-data'));?>
										<!-- <input class="upload-path" disabled /> -->
										  <label class="upload">
										  	<span>Upload Sample</span>
											<input type="file" id="upl_file" name="file" class="form-control" required>
											
										  </label>
										  <input type="submit" id="uploadsubmitdata" name="submit"/>
									<?= form_close();?>
									
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group" >
										<a href="<?php echo base_url();?>Qa_agent_coaching_upload/sample_cdr_download" class="btn btn-success btn-excl" title="Download Sample Examination Excel" download="Sample Excel.xlsx">Sample Excel</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
		
		<div class="row">
			<div class="col-12">
				<div class="widget">
					<div class="widget-body">
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
								<thead>
									<tr class="bg-info">
										<td style="font-size:15px">SL No</td>
										<td style="font-size:15px">Count Data</td>
										<td style="font-size:15px">Upload Date</td>
										<td style="font-size:15px">Action</td>
									</tr>
								</thead>
								<tbody>
									<?php 
										$i=1; 
										foreach($sampling as $row){ ?>
										<tr>
											<td><?php echo $i++; ?></td>
											<td><?php echo $row['count']; ?></td>
											<td><?php echo $row['uplDate']; ?></td>
											<td>
												<a href="<?php echo base_url();?>Qa_agent_coaching_upload/qa_agent_upload_feedback/?up_date=<?php echo $row['uplDate'];?>" class="btn btn-success btn-view" title="view Upload"><i class="fa fa-eye" aria-hidden="true"></i>
												</a>
											</td>
										</tr>
										<?php } ?>
								</tbody>
							</table>
						</div>
						
					
						
					</div>
				</div>
			</div>
		</div>
		
	</section>
</div>


