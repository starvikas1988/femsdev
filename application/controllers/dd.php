	<header class="widget-header">
								<h4 class="widget-title">
									<div class="row">
										<div class="col-sm-12">
									<div class="pull-left">Qa ALPHA GAS AND ELECTRIC Audit</div>
									</div>
									
									<?php if(is_access_qa_module()==true){ ?>
									<!-- <div class="pull-right">
										<?php $stratEmailAuditTime=date('Y-m-d H:i:s'); ?>
										<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_<?php echo $page ?>/process/add/<?php echo $stratEmailAuditTime; ?>/<?php echo $page ?>">Add Feedback</a>
									</div> -->
									<div class="col-sm-8">
									<div class="form-group">
										<?php $stratEmailAuditTime=date('Y-m-d H:i:s'); ?>
										<?= $this->session->flashdata('Success');?>
										<?php $stratAuditTimes=date('Y-m-d H:i:s'); ?>
											<?= form_open( base_url('Qa_philipines_raw/import_alpha_excel_data'),array('method'=>'post','enctype'=>'multipart/form-data'));?>
												<input class="upload-path" disabled />
												<label class="upload">
												<span>Upload Sample</span>
												<input type="hidden" name="star_time" value="<?php echo $stratAuditTimes;?>">
													<input type="file" id="upl_file2" name="file" required>  </label>
												<input type="submit" id="uploadsubmitdata2" name="submit" class="btn btn-submit btn-primary">
												<?= form_close();?>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group pull-right"  style="margin-top: 10px"> <a href="<?php echo base_url();?>Qa_philipines_raw/sample_alpha_download" class="btn btn-success" title="Download Sample alpha Excel" download="Sample alpha Excel.xlsx" style="margin-right:5px;">Sample Excel</a>
									<a class="btn btn-primary" href="<?php echo base_url(); ?>Qa_<?php echo $page ?>/process/add/<?php echo $stratEmailAuditTime; ?>/<?php echo $page ?>">Add Feedback</a>
								</div>
								</div>	
									<?php } ?>
									</div>
								</h4>
							</header>