<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/> 
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/custom.css"/> 
<style>

	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		vertical-align:middle;
		padding:2px;
		font-size:11px;
	}
	
	.table > thead > tr > th,.table > tfoot > tr > th{
			text-align:center;
	}

	.panel .table td, .panel .table th{
		font-size:11px;
		padding:6px;
	}
	
	.hide{
	  disply:none;	  
	}
	
	.modal-dialog {
		width: 800px;
	}
	.modal
	{
		overflow:auto;
	}
	
	/*---------- MY CUSTOM CSS -----------*/
	.rounded {
	  -webkit-border-radius: 3px !important;
	  -moz-border-radius: 3px !important;
	  border-radius: 3px !important;
	}

	.mini-stat {
	  padding: 5px;
	  margin-bottom: 20px;
	}

	.mini-stat-icon {
	  width: 30px;
	  height: 30px;
	  display: inline-block;
	  line-height: 30px;
	  text-align: center;
	  font-size: 15px;
	  background: none repeat scroll 0% 0% #EEE;
	  border-radius: 100%;
	  float: left;
	  margin-right: 10px;
	  color: #FFF;
	}

	.mini-stat-info {
	  font-size: 12px;
	  padding-top: 2px;
	}

	span, p {
	  /*color: white;*/
	}

	.mini-stat-info span {
	  display: block;
	  font-size: 20px;
	  font-weight: 600;
	  margin-bottom: 5px;
	  margin-top: 7px;
	}

	/* ================ colors =====================*/
	.bg-facebook {
	  background-color: #3b5998 !important;
	  border: 1px solid #3b5998;
	  color: white;
	}

	.fg-facebook {
	  color: #3b5998 !important;
	}

	.bg-twitter {
	  background-color: #00a0d1 !important;
	  border: 1px solid #00a0d1;
	  color: white;
	}

	.fg-twitter {
	  color: #00a0d1 !important;
	}

	.bg-googleplus {
	  background-color: #db4a39 !important;
	  border: 1px solid #db4a39;
	  color: white;
	}

	.fg-googleplus {
	  color: #db4a39 !important;
	}

	.bg-bitbucket {
	  background-color: #205081 !important;
	  border: 1px solid #205081;
	  color: white;
	}

	.fg-bitbucket {
	  color: #205081 !important;
	}
	
		
	.highcharts-credits {
		display: none !important;
	}
	
	.form-group {
		margin-bottom:8px;
	}

	.checklist input[type=checkbox]{
		margin-right:5px;
	}
	.phead{
		background-color: #f5f7f9;
		padding: 10px 15px;
	}
	.bRow{
		background-color: #f1f1f1;
		padding: 10px 0px;
		text-align: center;
		font-size: 16px;
		font-weight: 600;
	}
	.bCol{
		padding:10px 0px;
		text-align: center;
		font-size: 14px;
	}
	.disabled {
		cursor:not-allowed;
	}
	.disabled:hover {
		background-color: gray;
		cursor:not-allowed;
	}
	.list_cat:hover{
		background-color: #ebeced;
		border-radius:5px;
	}
</style>
<div class="wrap">
	<section class="app-content">
		<div class="widget">
			<div class="widget-body">
				<h4 class="widget-title">
				<span id="cat_title">Add Category</span>
				</h4>
			</div>
			<hr class="widget-separator">
			<div class="widget-body">
				<div class="filter-widget">
					<div style="text-align:center">
						<span id="delete_survey" style="color:red;padding-bottom:5px;"></span>
					</div>
					<form action="<?php echo base_url(); ?>dynamic_survey/survey_category" method="post">
					<input type="hidden" name="cat_id" value="" id="cat_edit_id">
					<div class="form-group">							
						<input type="text" name="category" class="form-control" id="category" required>
					</div>
					<div class="form-group">						
						<button type="submit" id="submit_category" class="green-btn1">
							Submit
						</button>
					</div>
					</form>
					<span id="added_category"></span>
				</div>
			</div>
		</div>		
	</section>
	<div class="common-top">
		<div class="widget">
			<div class="widget-body">
				<div class="category-widget">
					<p style="font-size:20px;">Category</p>
					<ul>
						<?php 
						foreach($master_survey_category as $key=>$val){
							$cat_id ='';$cat_name='';
							$cat_id = $val['id'];
							$cat_name = $val['name'];
							$list = '';
							$list = "<li class='list_cat' id=".$cat_id.">".$cat_name;
							if($val['created_by'] == get_user_id()){
								$list .= "<span style='float:right;font-size:18px'>";
								$list .= "<i class='fa fa-edit' style='color:#188ae2' onclick='edit_cat(".$cat_id.")'></i>";
								$list .= "<i class='fa fa-trash' style='color:red;margin-left:8px;' onclick='delete_cat(".$cat_id.")'></i></span>";
							}
							$list .= "</li>";
							echo $list;
						}
						 ?>
					</ul>
				</div>
			</div>
		</div>
    </div>
</div>

<script>
function edit_cat(cat_id){
	var cat_name = $('#'+cat_id).text();
	// alert(cat_name);
	$('#cat_edit_id').val(cat_id);
	$('#category').val(cat_name);
	$('#cat_title').text('Edit Category '+cat_name);
	$("#category").focus();
}
function delete_cat(cat_id){
	var result = confirm("Want to delete?");
	if(result){
		if(cat_id){
			$('#delete_survey').html('Deleting survey category ...');
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>dynamic_survey/delete_category',
				data: 'cat_id='+cat_id,
				success: function (response){
					location.reload();
				}
			});
		}else{
			alert('No category selected!!');
		}
	}

}
</script>

