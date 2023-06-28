<div class="wrap">
	<section class="app-content">

		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header"><h4 class="widget-title">Romtech Scorecard </h4></header>


						</div>
						<hr class="widget-separator">
					</div>

					<div class="widget-body">
						<div class="row">
						  <form id="form_new_user" method="GET" action="<?php echo base_url('reports_qa/qa_romtech_report'); ?>">
						  <?php echo form_open('',array('method' => 'get')) ?>

							<div class="col-md-4">
							<!-- 	<div class="form-group">
									<label>Search From Date  (mm/dd/yyyy)</label>
									<input type="text" id="from_date" name="date_from"  onchange="date_validation(this.value,'S')"        value="<?php //echo mysql2mmddyy($date_from); ?>" class="form-control" onkeydown="return false;" required autocomplete="off">
									<span class="start_date_error" style="color:red"></span>
								</div> -->
								<div class="form-group">
										<label>From Date (MM/DD/YYYY)</label>
										<input type="text" id="from_date"  onchange="date_validation(this.value,'S')"    name="date_from" value="<?php $date= mysql2mmddyy($date_from); echo str_replace('-', '/', $date); ?>" class="form-control" readonly>
										<span class="start_date_error" style="color:red"></span>
								</div>

							</div>
							<div class="col-md-4">
								<!-- <div class="form-group">
									<label>Search  To  Date (mm/dd/yyyy)</label>
									<input type="text" id="to_date" name="date_to" onchange="date_validation(this.value,'E')"   value="<?php //echo mysql2mmddyy($date_to); ?>" class="form-control" onkeydown="return false;" required autocomplete="off">
									<span class="end_date_error" style="color:red"></span>
								</div> -->
								<div class="form-group">
										<label>To Date (MM/DD/YYYY)</label>
										<input type="text" id="to_date" name="date_to"   onchange="date_validation(this.value,'E')"    value="<?php $date= mysql2mmddyy($date_to); echo str_replace('-', '/', $date); ?>" class="form-control" readonly>
										<span class="end_date_error" style="color:red"></span>
									</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="office_id">Select a Location</label>
									<select class="form-control" name="office_id" id="office_id">
										<option value='All'>ALL</option>
										<?php foreach($location_list as $loc):
											$sCss="";
											if($loc['abbr']==$office_id) $sCss="selected";
											?>
										<option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss;?>><?php echo $loc['office_name']; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							
<br>
<br>

						<div class="row">
						<div class="col-md-3"> 
								<div class="form-group">
									<label>Select Campaign</label>
									<select class="form-control" name="campaign" required>
										<option value="">--Select--</option>
										<option <?php echo $campaign=='romtech'?"selected":""; ?> value="romtech">RomTech</option>
										<option <?php echo $campaign=='romtech_csat'?"selected":""; ?> value="romtech_csat">RomTech CSAT</option>
										<option <?php echo $campaign=='romtech_intro'?"selected":""; ?> value="romtech_intro">RomTech Intro</option>
										<option <?php echo $campaign=='romtech_inbound'?"selected":""; ?> value="romtech_inbound">RomTech Inbound</option>
										
									</select>
								</div>
							</div>

							<div class="col-md-3" style='margin-top:22px;margin-left: 10px;'>
								<div class="form-group">
									<button class="btn btn-primary blains-effect" a href="<?php echo base_url()?>reports_qa/qa_romtech_report" type="submit" id='show' name='show' value="Show">SHOW</button>
								</div>
							</div>

							<?php if($download_link!=""){ ?>
								<div style='float:right; margin-top:25px;' class="col-md-2">
									<div class="form-group" style='float:right;margin-bottom: 20px;margin-right: 10px;'>
										<a href='<?php echo $download_link; ?>' <span style="padding:12px;" class="label label-success">Export Report</span></a>
									</div>
								</div>
							<?php } ?>

						  </form>
						</div>

					<div class="col-md-12">
							<div class="table-responsive">
								<table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">

									<?php  if(!isset($qa_romtech_list)) {?>

										<tbody>

										<tr> </tr>

									</tbody>
									<?php  }
									else{
										?>
                                           <thead>
										<tr class='bg-info'>
											<th>SL</th>
											<th>Auditor</th>
											<th>Audit Date</th>
											<th>Over All Score </th>
											<th>Agent Name</th>
											<th>L1 Supervisor</th>
										</tr>
									</thead>



									<tbody>
										<?php $i=1;
										foreach($qa_romtech_list as $row){ ?>
										<tr>
											<td><?php echo $i++; ?></td>
											<td><?php echo $row['auditor_name']; ?></td>
											<td><?php echo $row['audit_date']; ?></td>
											 <td><?php echo $row['overall_score']."% "; ?></td>
											<td><?php echo $row['fname']." ".$row['lname']; ?></td>
											<td><?php echo $row['tl_name']; ?></td>
										</tr>
										<?php } ?>
									</tbody>

<?php  }?>

								</table>
							</div>
						</div>
					</div>

					</div>
					</div>

				</div>
			</div>
		</div>

	</section>
</div>
