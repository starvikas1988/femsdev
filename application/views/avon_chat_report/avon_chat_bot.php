<style>
.blue-btn {
	width:200px;
	padding:10px;
	background:#188ae2;
	color:#fff;
	font-size:13px;
	letter-spacing:0.5px;
	transition:all 0.5s ease-in-out 0s;
	border:none;
    border-radius:5px;
}
.blue-btn:hover {
	background:#1373bd;
}
.blue-btn:focus {
	background:#1373bd;
	outline:none;
	box-shadow:none;
}
.submit-btn {
	width:200px;
	padding:10px;
	background:#5cb85c;
	color:#fff!important;
	font-size:13px;
	letter-spacing:0.5px;
	transition:all 0.5s ease-in-out 0s;
	border:none;
    border-radius:5px;
	display: inline-block;
    text-align: center;
    margin: 0 0 0 30px;
}
.submit-btn:hover {
	background:#2f742f;
	color:#fff!important;
}
.submit-btn:focus {
	background:#2f742f;
	color:#fff!important;
	outline:none;
	box-shadow:none;
}
.export-widget-new {
	width:100%;
	text-align:right;
}
.table-widget .dataTables_length {
	margin:0;
	padding:0;
}
.table-widget select {
	margin:0 5px;
	transition:all 0.5s ease-in-out 0s;
}
.table-widget select:hover {
	border:1px solid #188ae2;
}
.table-widget select:focus {
	border:1px solid #188ae2;
	outline:none;
	box-shadow:none;
}
.table-widget .dataTables_filter {
	padding:0 0 10px 0;
}
.table-widget .form-control {
	margin:0 0 0 5px;
	transition:all 0.5s ease-in-out 0s;
}
.table-widget .form-control:hover {
	border:1px solid #188ae2;
}
.table-widget .form-control:focus {
	border:1px solid #188ae2;
	outline:none;
	box-shadow:none;
}
.filter-widget select {
	width: 100%;
    height: auto;
    padding: 10px;
    height: 40px;
    transition: all 0.5s ease-in-out 0s;
	border: 1px solid #ccc;
}
.filter-widget select:hover {
    border: 1px solid #188ae2;
}
.filter-widget select:focus {
    border: 1px solid #188ae2;
	outline:none;
	box-shadow:none;
}
.filter-widget .form-control {
	width:100%;
	height:auto;
	padding:10px;
	height:40px;
	transition:all 0.5s ease-in-out 0s;
}
.filter-widget .form-control:hover {
	border:1px solid #188ae2;
}
.filter-widget .form-control:focus {
	border:1px solid #188ae2;
	outline:none;
	box-shadow:none;
}
.common-top {
	width:100%;
	margin:15px 0 0 0;
}
</style>

<div class="wrap">
	<section class="app-content">
		
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
					<div class="row">
						<div class="col-md-10">
							<header class="widget-header">
								<h4 class="widget-title"><?php   echo ($status=="bot_avon_chat_conv")?"Avon Chat Data":"Avon Chat Data" ?></h4>
							</header>
						</div>	
						<hr class="widget-separator">
					</div>
					
					<div class="widget-body">	

					
					<form id="form_new_user" method="GET" action="<?php echo base_url('avon_chat_report/export'); ?>">	
					  <?php echo form_open('',array('method' => 'get')) ?>
						<div class="filter-widget">
							<div class="row">
							  <div class="col-md-3">
									<div class="form-group">
										<label>Date From</label>
										<input type="text" id="date_from" name="date_from" value="<?php echo mysql2mmddyy($date_from); ?>" class="form-control" autocomplete="off" required>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Date To</label>
										<input type="text" id="date_to" name="date_to" value="<?php echo mysql2mmddyy($date_to); ?>" class="form-control" autocomplete="off" required>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group" required>
										<label for="office_id">Select Data</label>
										<select class="form-control" name="status" id="status" >
											<option value="bot_avon_chat_users" <?php echo ($status=="bot_avon_chat_users")?"selected":"" ?> >User</option>
											<option value="bot_avon_chat_conv" <?php echo ($status=="bot_avon_chat_conv")?"selected":"" ?> >Conversatoin</option>
										</select>
									</div>
								</div>
								
							</div>
						</div>						
						<div class="filter-widget">							
							<div class="btn-widget">
								<div class="row">
									<div class="col-sm-2">
										<div class="export-widget">
											<button class="blue-btn" a href="#" type="submit" id='export' name='export' value="Export">Export</button>
										</div>
									</div>
									
								</div>								
							</div>
							
						</div>
						
					 </form>					 
						
					</div>
					
				</div>
				
			</div>
		</div>
	
	</section>
</div>	