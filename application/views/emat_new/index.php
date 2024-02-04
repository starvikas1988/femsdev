<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $page_name;?></title>
    <link rel="stylesheet" href="<?php  echo base_url() ?>assets/emat_new/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/emat_new/css/bootstrap-multiselect.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/emat_new/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/emat_new/css/style.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/emat_new/css/custom.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/emat_new/css/metisMenu.css">
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&amp;display=swap" rel="stylesheet">
	<!--start data table css here-->
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/emat_new/css/dataTables.bootstrap4.min.css"/>
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/emat_new/css/buttons.bootstrap4.min.css"/>
	<!--end data table css here-->
</head>
<?php
$ldcdHide = "";
$cbHide = "";
$cdHide = "";
$diasable = "";
$ldDiasable = "";
$cbDiasable = "";
$checked="";
if($this->ematnew_model->check_break_on($current_user)===true) {
	$break_on=true;
	$checked="checked";
	$ldDiasable = "disabled";
}
if($this->ematnew_model->check_break_on_ld($current_user)===true) {
	$break_on_ld=true;
	$checked="checked";
	$diasable = "disabled";
}
if($this->ematnew_model->check_break_on_cb($current_user)===true) {
	$break_on_cb=true;
	$checked="checked";
	$cbDiasable = "disabled";
}


?>
<body ><!--============= start main area -->
<div id="page-container">
    <div class="header-area">
        <div class="header-area-left">
            <a href="#">
                <img src="<?php echo base_url() ?>assets/emat_new/images/logo.png" class="logo" alt="">
            </a>
        </div>
		<!--start mobile logo -->
		<div class="mobile-logo-new">
			<a href="#" class="logo">
                <img src="<?php echo base_url() ?>assets/emat_new/images/side-logo.png" class="logo" alt="">
            </a>
		</div>
		<!--end mobile logo -->

        <div class="row align-items-center header_right">
            <div class="col-md-9 d_none_sm align-items-center">
                <div class="row">
					<div class="col-sm-2">
						<div class="switch-widget">
							<label class="switch">

								<?php if ($break_on === true) : ?>
									<input type="checkbox" id="break_check_button" <?php echo $checked ;?>>
								<?php else : ?>
									<input type="checkbox" id="break_check_button" <?php echo $diasable .' '.$cbDiasable;?>>
								<?php endif; ?>
								<div class="slider round">
									<span class="on short_time" style="background:red;color:#fff;">Short Break</span>
									<span class="off break_time">Break</span>
									<span class="switch-label" data-on="Off" data-off="On"></span>
									<span class="switch-handle"></span>
								</div>
							</label>
						</div>
					</div>
					<div class="col-sm-2">
						<label class="switch">

						 <?php if ($break_on_ld === true) : ?>
												<input class="switch-input" type="checkbox" id="break_check_button_ld" checked >
											<?php else : ?>
												<input class="switch-input" type="checkbox" id="break_check_button_ld" <?php echo $ldDiasable.' '.$cbDiasable; ?>>
											<?php endif; ?>
						 <div class="slider round">
						  <span class="on" style="background:red;color: #fff;">Lunch Break ON</span>
						  <span class="off" style="bg-color: green; text-color: white;">Lunch</span>
						 </div>
						</label>
					</div>

					<div class="col-sm-2">
						<div class="avail-widget">
						<label class="switch">
						 <?php if ($break_on_cb === true) { ?>
												<input class="switch-input" type="checkbox" id="break_check_button_cb" checked >
											<?php }else{ ?>
												<input class="switch-input" type="checkbox" id="break_check_button_cb"  <?php echo $ldDiasable .' '.$diasable;?>>
											<?php } ?>
						 <div class="slider round">

						  <span class="on">Unavailable</span>
						  <span class="off">Available</span>
						 </div>
						</label>
					</div>
					</div>

					<!-- <div class="col-sm-2">
						<div class="avail-widget">
							<label class="switch">
							 <input type="checkbox" id="togBtn" <?php echo $ldDiasable .' '.$diasable;?>>
							 <div class="slider round">
							  <span class="on" id="unavail">Unavailable</span>
							  <span class="off" data-toggle="modal" data-target="#exampleModal">Available</span>
							 </div>
							</label>
						</div>
					</div> -->
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <ul class="notification-area pull-right">
                    <li class="mobile_menu_btn">
                        <span class="nav-btn pull-left d_none_lg">
                            <button class="open-left waves-effect">
                                <i class="fa fa-bars" aria-hidden="true"></i>
                            </button>
                        </span>
                    </li>
                    <li id="full-view-exit" class="d_none_sm">
						<i class="fa fa-window-minimize" aria-hidden="true"></i>
					</li>

                    <li class="user-dropdown">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="<?php echo base_url()?>assets/emat_new/images/user.jpg" alt="" class="img-fluid">
                            </button>
                            <div class="dropdown-menu dropdown_user" aria-labelledby="dropdownMenuButton" >
                                <div class="dropdown-header d-flex flex-column align-items-center">
                                    <div class="user_img mb-3">
                                        <img src="<?php echo base_url()?>assets/emat_new/images/user.jpg" alt="User Image">
                                    </div>
                                    <div class="user_bio text-center">
                                        <p class="name font-weight-bold mb-0">
											<?php
				echo get_username();
				if(get_deptname()!="") echo " (". get_role().", ".get_deptshname().")";
			?>
										</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

    </div>
 <?php $this->load->view('emat_new/aside'); ?>
<div id='main_page_content'>
		<?php $this->load->view('emat_new/'.$content_template); ?>
	</div>
<footer>
        <div class="footer-area">
            <p>&copy; Copyright 2021. All right reserved.</p>
        </div>
    </footer>
</div>

<!--start Unavailable-->
<div class="pop-up" style="display:none;">
	<div class="pop-up-content">
		<div class="alert alert-danger" role="alert">
			You are currently unavailable!
		</div>
	</div>
</div>
<!--end Unavailable-->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-dialog-centered">
      <div class="modal-body">
        <div class="pop-up-content">
			<div class="alert alert-danger" role="alert">
				You are currently unavailable!
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script src="<?php echo base_url() ?>assets/emat_new/js/jquery.min.js"></script>
<script src="<?php echo base_url() ?>assets/emat_new/js/popper.min.js"></script>
<script src="<?php echo base_url() ?>assets/emat_new/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/emat_new/js/bootstrap-multiselect.js"></script>
<script src="<?php echo base_url() ?>assets/emat_new/js/metisMenu.min.js"></script>
<script src="<?php echo base_url() ?>assets/emat_new/js/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url() ?>assets/emat_new/js/main.js"></script>
<script src="<?php echo base_url() ?>assets/emat_new/js/chart.js"></script>
<!--
<script src="<?php echo base_url() ?>assets/emat_new/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/emat_new/js/jquery.dataTables.min.js"></script>
-->

<!--start data table-->
<script src="<?php echo base_url() ?>assets/emat_new/data-table/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/emat_new/data-table/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/emat_new/data-table/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>assets/emat_new/data-table/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/emat_new/data-table/js/jszip.min.js"></script>
<script src="<?php echo base_url() ?>assets/emat_new/data-table/js/vfs_fonts.js"></script>
<script src="<?php echo base_url() ?>assets/emat_new/data-table/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url() ?>assets/emat_new/data-table/js/buttons.print.min.js"></script>
<script src="<?php echo base_url() ?>assets/emat_new/data-table/js/buttons.colVis.min.js"></script>
<!--end data table-->
<!-- <script>
	$("#avail").click(function(){
		$(".main-content-inner").addClass("add_disable");
		$(".sidebar_menu").addClass("add_disable");
		$(".header-area-left").addClass("add_disable");
		$(".user-dropdown").addClass("add_disable");
	});
	$("#unavail").click(function(){
		$(".main-content-inner").removeClass("add_disable");
		$(".sidebar_menu").removeClass("add_disable");
		$(".header-area-left").removeClass("add_disable");
		$(".user-dropdown").removeClass("add_disable");
	});
	$("#avail").click(function(){
		$(".pop-up").fadeIn('show');
	});
	$("#unavail").click(function(){
		$(".pop-up").fadeOut('');
	});

	$(".break_time").click(function(){
		$(".main-content-inner").addClass("add_disable");
		$(".sidebar_menu").addClass("add_disable");
		$(".header-area-left").addClass("add_disable");
		$(".user-dropdown").addClass("add_disable");
	});
	$(".short_time").click(function(){
		$(".main-content-inner").removeClass("add_disable");
		$(".sidebar_menu").removeClass("add_disable");
		$(".header-area-left").removeClass("add_disable");
		$(".user-dropdown").removeClass("add_disable");
	});
	$(".break_time").click(function(){
		$(".pop-up").fadeIn('show');
	});
	$(".short_time").click(function(){
		$(".pop-up").fadeOut('');
	});

</script> -->
<script>
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})
</script>
<script>
    $(document).ready(function() {
        $('.multi_select').multiselect({
            // enableFiltering: true,
            // includeSelectAllOption: true,
            // maxHeight: 400,
            // dropUp: true
        });
    });
</script>
<script>
	$(document).ready(function() {
    var table = $('.common-data').DataTable( {
        lengthChange: false,
        buttons: [
            {
                extend: 'excel',
                split: [ '', ''],
            }
        ]
    } );

    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );
</script>

<script>
	var ctxBAR = document.getElementById("bar-chart");
	var myBarChart_dailyVisitor = new Chart(ctxBAR, {
	type: 'bar',
		data: {

		labels: [<?php foreach($count_details as $tv){ ?>
'<?php echo $tv["trans_type_name"]?>',<?php } ?>],
		datasets: [
	{
	label: "Transaction Count vs Transaction Type",
		data: [<?php foreach($count_details as $tv){ ?>
'<?php echo $tv["count_data"]?>',<?php } ?>],
			 backgroundColor: [
			  'rgba(255, 99, 132, 0.9)',
			  'rgba(255, 159, 64, 0.9)',
			  'rgba(255, 205, 86, 0.9)',
			  'rgba(75, 192, 192, 0.9)',
			  'rgba(54, 162, 235, 0.9)',
			  'rgba(153, 102, 255, 0.9)',
			  'rgba(201, 203, 207, 0.9)'
		],
		borderColor: [
		  'rgb(255, 99, 132)',
		  'rgb(255, 159, 64)',
		  'rgb(255, 205, 86)',
		  'rgb(75, 192, 192)',
		  'rgb(54, 162, 235)',
		  'rgb(153, 102, 255)',
		  'rgb(201, 203, 207)'
		],
			borderWidth: 3
		}
	]
},
	options: {
		legend: { display: false, position: 'right' },
		title: {
		display: true,
		lineHeight: 2,
		text: ""
	},
	tooltips: {
		callbacks: {
			label: function(tooltipItem) {
			return tooltipItem.yLabel + '';
			}
		}
	},
		maintainAspectRatio: false,
			responsive: true,
			scales: {
		xAxes: [{
	}],
	yAxes: [{
		display:true,
		ticks: {
		callback: function(value, index, values) {
		return value + '';
	},
	beginAtZero: true,
		}
	}]
},
	plugins: {
		datalabels: {
			anchor: 'end',
			align: 'top',
			formatter: (value, ctx) => {
			return value + '';
			},
			font: {
			size:9,
			weight: 'bold'
			}
		}
	}
},
});
</script>

<script>
	var ctxBAR = document.getElementById("pie-chart");
	var myBarChart_dailyVisitor = new Chart(ctxBAR, {
	type: 'pie',
		data: {
		labels: [<?php foreach($count_details as $tv){ ?>
'<?php echo $tv["trans_type_name"]?>',<?php } ?>],
		datasets: [
	{
	label: "Visitors",
		data: [<?php foreach($count_details as $tv){ ?>
'<?php echo $tv["count_data"]?>',<?php } ?>],
			 backgroundColor: [
			  'rgba(255, 99, 132, 0.9)',
			  'rgba(255, 159, 64, 0.9)',
			  'rgba(255, 205, 86, 0.9)',
			  'rgba(75, 192, 192, 0.9)',
			  'rgba(54, 162, 235, 0.9)',
			  'rgba(153, 102, 255, 0.9)',
			  'rgba(201, 203, 207, 0.9)'
		],
		borderColor: [
		  'rgb(255, 99, 132)',
		  'rgb(255, 159, 64)',
		  'rgb(255, 205, 86)',
		  'rgb(75, 192, 192)',
		  'rgb(54, 162, 235)',
		  'rgb(153, 102, 255)',
		  'rgb(201, 203, 207)'
		],
			borderWidth: 3
		}
	]
},
	options: {
		legend: { display: false, position: 'right' },
		title: {
		display: true,
		lineHeight: 2,
		text: ""
	},
	tooltips: {
		callbacks: {
			label: function(tooltipItem) {
			return tooltipItem.yLabel + '';
			}
		}
	},
		maintainAspectRatio: false,
			responsive: true,
			scales: {
		xAxes: [{
	}],
	yAxes: [{
		display:true,
		ticks: {
		callback: function(value, index, values) {
		return value + '';
	},
	beginAtZero: true,
		}
	}]
},
	plugins: {
		datalabels: {
			anchor: 'end',
			align: 'top',
			formatter: (value, ctx) => {
			return value + '';
			},
			font: {
			size:9,
			weight: 'bold'
			}
		}
	}
},
});
</script>

<script>
	var ctxBAR = document.getElementById("full-chart");
	var myBarChart_dailyVisitor = new Chart(ctxBAR, {
	type: 'bar',
		data: {
		labels: [<?php foreach($user_count_details as $tv){ ?>
'<?php echo $tv["added_by_name"]?>',<?php } ?>],
		datasets: [
	{
	label: "Transaction Type vs User Count",
		data: [<?php foreach($user_count_details as $tv){ ?>
'<?php echo $tv["count_data"]?>',<?php } ?>],
			 backgroundColor: [
			  'rgba(255, 99, 132, 0.9)',
			  'rgba(255, 159, 64, 0.9)',
			  'rgba(255, 205, 86, 0.9)',
			  'rgba(75, 192, 192, 0.9)',
			  'rgba(54, 162, 235, 0.9)',
			  'rgba(153, 102, 255, 0.9)',
			  'rgba(201, 203, 207, 0.9)'
		],
		borderColor: [
		  'rgb(255, 99, 132)',
		  'rgb(255, 159, 64)',
		  'rgb(255, 205, 86)',
		  'rgb(75, 192, 192)',
		  'rgb(54, 162, 235)',
		  'rgb(153, 102, 255)',
		  'rgb(201, 203, 207)'
		],
			borderWidth: 3
		}
	]
},
	options: {
		legend: { display: false, position: 'right' },
		title: {
		display: true,
		lineHeight: 2,
		text: ""
	},
	tooltips: {
		callbacks: {
			label: function(tooltipItem) {
			return tooltipItem.yLabel + '';
			}
		}
	},
		maintainAspectRatio: false,
			responsive: true,
			scales: {
		xAxes: [{
	}],
	yAxes: [{
		display:true,
		ticks: {
		callback: function(value, index, values) {
		return value + '';
	},
	beginAtZero: true,
		}
	}]
},
	plugins: {
		datalabels: {
			anchor: 'end',
			align: 'top',
			formatter: (value, ctx) => {
			return value + '';
			},
			font: {
			size:9,
			weight: 'bold'
			}
		}
	}
},
});
</script>

<script>
	$('#break_check_button_ld').change(function(){

		if($(this).prop("checked")==true){

			swal({
			  title: "Are You Sure to Turn Lunch/Dinner Break Timer On?",
			  text: "",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			})
			.then((willDelete) => {
			if(willDelete){
				$.post("<?php echo base_url();?>emat_new/break_on_ld",function(data){
					//window.location.href = "<?php echo base_url().get_role_dir();?>/dashboard";
					window.location.href = "<?php echo base_url();?>emat_new";
				});


			}else $(this).prop("checked",false);
			});

		}else{

				$.post("<?php echo base_url();?>emat_new/break_off_ld",function(data){
					if(data==1){
						$(this).prop("checked",false);
						//window.location.href = "<?php echo base_url().get_role_dir();?>/dashboard";
						window.location.href = "<?php echo base_url();?>emat_new";
					}else{
						$(this).prop("checked",true);
						alert(data);//("Error Occurred. Contact TL/Supervisor/Administrator");
					}
				});

			}
	});


	$('#break_check_button').change(function(){
		if($(this).prop("checked")==true){

			swal({
			  title: "Are You Sure to Turn Other Break Timer On?",
			  text: "",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			})
			.then((willDelete) => {
			if(willDelete){

				$.post("<?php echo base_url();?>emat_new/break_on",function(data){
					window.location.href = "<?php echo base_url();?>emat_new";
				});

			}else $(this).prop("checked",false);

			});

		}else{
				$.post("<?php echo base_url();?>emat_new/break_off",function(data){
					if(data==1){
						$(this).prop("checked",false);
						window.location.href = "<?php echo base_url();?>emat_new";
					}else{
						$(this).prop("checked",true);
						alert(data);//("Error Occurred. Contact TL/Supervisor/Administrator");
					}
				});
		}
	});
	
	
	
	
	
		$('#break_check_button_cb').change(function(){
		if($(this).prop("checked")==true){
			swal({
			 title: "",
			 text: "",
			 html: "<form action='<?php echo base_url(); ?>emat_new/cb_form_data' method='POST' autocomplete='off'><select id='button_cb_option' name='button_cb'><option value='Unavilable Downtime'>Unavilable Downtime</option><option value='Coaching'>Coaching</option><option value='Team Meeting'>Team Meeting</option><option value='System Downtime'>System Downtime</option><option value='Short Break'>Short Break</option></select>",
			 icon: "warning",
			  buttons: true,
			 dangerMode: true,
			 
			})	
			.then((willDelete) => {
			if(willDelete){
				/*var button_cb_option = $(this).attr('button_cb');
				alert(button_cb_option);*/
 
				$.post("<?php echo base_url();?>emat_new/break_on_coaching",function(data){
					window.location.href = "<?php echo base_url();?>emat_new";
				});

			}else $(this).prop("checked",false);

			});

		}else{

				$.post("<?php echo base_url();?>emat_new/break_off_coaching",function(data){
					if(data==1){
						$(this).prop("checked",false);
						window.location.href = "<?php echo base_url();?>emat_new";
					}else{
						$(this).prop("checked",true);
						alert(data);
					}
				});
		}
	});
	
	
	
</script>


<?php
if(isset($content_js) && !empty($content_js))
{
	if(is_array($content_js))
	{
		foreach($content_js as $key=>$script_url)
		{
			if(!preg_match("/.php/", $script_url))
			{
				if(preg_match("/\Ahttp/", $script_url))
				{
					echo '<script src="'.$script_url.'"></script>';
				}
				else
				{
					echo '<script src="'. base_url('application/views/jscripts/'.$script_url).'"></script>';
				}
			}
			else
			{
				$this->load->view('jscripts/'.$script_url);
			}
		}
	}
	else
	{
		if(!preg_match("/.php/", $content_js))
		{
			if(preg_match("/\Ahttp/", $content_js))
			{
				echo '<script src="'.$content_js.'"></script>';
			}
			else
			{
				echo '<script src="'. base_url('application/views/jscripts/'.$content_js).'"></script>';
			}
		}
		else
		{
			$this->load->view('jscripts/'.$content_js);
		}
	}
}
?>

<!--start sweetalert custom library here-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.3.5/sweetalert2.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.3.5/sweetalert2.all.js"></script>
<!--end sweetalert custom library here-->


<!--start Outbound Call hold btn (new transaction page)-->
<script>
    $(function () {
        $("#outbond_call").change(function () {
            if ($(this).val() == "1") {
                $("#holdCallModalButton").show();
            } else {
                $("#holdCallModalButton").hide();
            }
        });
    });
</script>

<script>
	$(document).ready(function(){
		$(".new-hold-btn").click(function(){
			$("#holdCallModalButton").hide();
		});
	});
</script>

<!--end Outbound Call hold btn (new transaction page)-->


</body>
</html>
