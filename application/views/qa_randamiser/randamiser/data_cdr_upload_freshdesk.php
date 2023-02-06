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
						<div class="filter-widget compute-widget">
							<div class="row">
								<div class="col-sm-8">
									<div class="form-group">
									
									<?= $this->session->flashdata('Success');?>
									<?= form_open( base_url('Qa_randamiser/import_cdr_excel_data/'),array('method'=>'post','enctype'=>'multipart/form-data'));?>
										<input class="upload-path" disabled />
										  <label class="upload">
											<input type="file" id="upl_file" name="file" required>
											<span>Upload Sample</span>
										  </label>
										  <input type="hidden" name="client_id" value="<?php echo $client_id;?>">
										  <input type="hidden" name="pro_id" value="<?php echo $pro_id;?>">
										  <input type="submit" id="uploadsubmitdata" name="submit"/>
									<?= form_close();?>
									
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group" style="float:right; padding-right:10px; background-color:red">
										<a href="<?php echo base_url();?>Qa_randamiser/sample_cdr_download" class="btn btn-primary" title="Download Sample Examination Excel" download="Sample Excel.xlsx">Sample Excel</a>
									</div>
								</div>
								<!--<div class="col-sm-4">
									<div class="form-group">
										<button type="button" class="submit-btn">
											<i class="fa fa-download" aria-hidden="true"></i>
											Download Sample
										</button>
									</div>
								</div>-->
							</div>
							<!--<div class="row">
								<div class="col-sm-12">									
									<div class="msg-widget">
										<div class="alert alert-danger">  
											<strong>Data</strong> cannot be synced due to error. 
										</div>
									</div>
									<div class="msg-widget">
										<div class="alert alert-info">  
											<strong>Data</strong> Uploaded successfuly.
										</div>
									</div>
								</div>
							</div>-->
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
												<a href="<?php echo base_url();?>Qa_randamiser/remove_data_cdr_upload_freshdesk/?up_date=<?php echo $row['uplDate'];?>" class="edit-btn">
													<i class="fa fa-trash" aria-hidden="true"></i>
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


