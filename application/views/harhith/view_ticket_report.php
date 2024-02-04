<div class="row mb-4">
	<div class="col-md-12 grid-margin">
		<div class="d-flex justify-content-between flex-wrap">
			<div class="d-flex align-items-center dashboard-header flex-wrap mb-3 mb-sm-0">
				<h5 class="mr-4 mb-0 font-weight-bold">
					<?php echo !empty($page_title) ? $page_title : "Today Ticket"; ?>
				</h5>                           
			</div>                        
		</div>
	</div>
</div>
			
			<div class="top-filter">
				<div class="card">
					<div class="card-body">
					<form method="GET" autocomplete="off" enctype="multipart/form-data">
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
								  <label>From date (mm/dd/yy)</label>
								  <input type="date" class="form-control" value="<?php echo date('Y-m-d', strtotime($search_start)); ?>" name="search_start">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
								  <label>To date (mm/dd/yy)</label>
								  <input type="date" class="form-control" value="<?php echo date('Y-m-d', strtotime($search_end)); ?>"name="search_end">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
								  <label>Call Type</label>
								  <select class="form-control" name="search_call">
									<?php echo hth_dropdown_3d_options($call_type, 'id', 'name', $search_call); ?>	
								  </select>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
								  <label>District</label>
								  <select class="form-control" name="search_district">
									<?php echo hth_dropdown_options_val($district_list, $search_district); ?>	
								  </select>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<input type="hidden" name="type" value="excel">
									<button type="submit" class="search-btn">Download</button>
								</div>
							</div>
						</div>
					</form>
					</div>
				</div>
			</div>
            