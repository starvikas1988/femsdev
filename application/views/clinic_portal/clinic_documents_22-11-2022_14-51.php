 <style>

	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		vertical-align:middle;
		padding:4px;
		font-size:11px;
	}
	
	.table > thead > tr > th,.table > tfoot > tr > th{
			text-align:center;
	}

	.inputTable > tr > td{
		font-size:12px;
		padding:4px;
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
	
	.docDiv:hover{
		opacity:0.4;
	}
	
</style>
<div class="wrap">
<section class="app-content">

<div class="widget">
<div class="widget-body">
  <div class="row">
  <div class="col-md-6">
  <h4 style="padding-left:10px"><i class="fa fa-bar-chart"></i> Info Documents</h4>
  </div>
  
  
  
  <!--<div class="col-md-6">
	<div class="row pull-right">
	<div class="col-md-6">
		<select style="width:150px" class="form-control" name="monthSelect" id="monthSelect">
			<?php
			for($i=1; $i<=12; $i++){
				$setSelection = "";
				$currDate = date('Y')."-".sprintf('%02d', $i)."-01";
				if($i == $selected_month){ $setSelection = "selected"; }
			?>
				<option value="<?php echo date('m', strtotime($currDate)); ?>" <?php echo $setSelection; ?>><?php echo date('F', strtotime($currDate)); ?></option>
			<?php } ?>
		</select>
	</div>
	<div class="col-md-6">
		<select style="width:150px" class="form-control" name="yearSelect" id="yearSelect">
			<?php
			$current_y = date('Y');
			$last_y = $current_y - 5;
			for($j=$current_y;$j>=$last_y;$j--){
				$selectiny = "";
				if($selected_year == $j){ $selectiny = "selected"; }
			?>
			<option value="<?php echo $j; ?>" <?php echo $selectiny; ?>>
			<?php echo $j; ?>
			</option>
			<?php } ?>
		</select>
	</div>
	</div>
  </div> -->
  
  
  </div>
  <hr style="margin-top: 10px;">
  
<div class="row">
<div class="col-md-12">
<div class="panel panel-default">	 
<div class="panel-body">    
	<div class="row">
	
		<div class="col-md-3 col-sm-6 col-xs-12 docDiv">
		<a style="cursor:pointer" href="<?php echo base_url('clinic_portal/push_file/GOVERNMENT_BENEFITS.docx') ?>">
            <div class="mini-stat clearfix  bg-facebook rounded">
                <div class="mini-stat-info">
                    <span><img style="width:80px;height:70px" src="<?php echo base_url() ."assets/images/excel.png"; ?>"></img></span>
                    Government Benefits
                </div>
            </div>
		</a>
        </div>
	

	<?php 
			if(get_user_fusion_id() != "FMAN000456") {
					 if(get_role_dir() == 'agent' || get_role_dir() == 'tl'){ ?>
        <div class="col-md-3 col-sm-6 col-xs-12 docDiv">
		<a style="cursor:pointer" href="<?php echo base_url('clinic_portal/push_file/CORPORATE_HEALTH_AND_LIFE_INSURANCE_FILE.rar') ?>">
            <div class="mini-stat bg-facebook clearfix rounded">
                <div class="mini-stat-info">
                    <span><img style="width:80px;height:70px" src="<?php echo base_url() ."assets/images/zip.png"; ?>"></img></span>
                    Corporate Health & Life Insurance
                </div>
            </div>
		</a>
        </div>
	
	<?php }} ?>
		<div class="col-md-3 col-sm-6 col-xs-12 docDiv">
		<a style="cursor:pointer" href="<?php echo base_url('clinic_portal/push_file/COMPBEN_DOWNLOADABLE_FORMS.rar') ?>">
            <div class="mini-stat bg-googleplus clearfix rounded">
                <div class="mini-stat-info">
                    <span><img style="width:80px;height:70px" src="<?php echo base_url() ."assets/images/zip.png"; ?>"></img></span>
                    Downloadable Forms
                </div>
            </div>
		</a>
        </div>
		
		<div class="col-md-3 col-sm-6 col-xs-12 docDiv">
		<a style="cursor:pointer" href="<?php echo base_url('clinic_portal/push_file/Other_Employees_Perk.png') ?>">
            <div class="mini-stat bg-facebook clearfix rounded">
                <div class="mini-stat-info">
                    <span><img style="width:80px;height:70px" src="<?php echo base_url() ."assets/images/imageICON.png"; ?>"></img></span>
                    Other Employee Perks
                </div>
            </div>
		</a>
        </div>
		
		<div class="col-md-3 col-sm-6 col-xs-12 docDiv">
		<a style="cursor:pointer" href="<?php echo base_url('clinic_portal/push_file/FAQs_COMPBEN_FINAL.pdf') ?>">
            <div class="mini-stat bg-facebook clearfix rounded">
                <div class="mini-stat-info">
                    <span><img style="width:80px;height:70px" src="<?php echo base_url() ."assets/images/pdf.png"; ?>"></img></span>
                   Frequently Asked Questions
                </div>
            </div>
		</a>
        </div>
	
	</div>
</div>
</div>


</div>
</div>


</div>
</div>  
<section>
</div>