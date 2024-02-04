
<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <title>Dashboard<?php//echo APP_TITLE;?></title>
    <link rel="stylesheet" href="<?php  echo base_url() ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/style.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/custom.css">    
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/metisMenu.css">	
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&amp;display=swap" rel="stylesheet">
</head>
	
<body ><!--============= start main area -->
<div id="page-container" style="border:1px solid red;">
    <div class="header-area">
        <div class="header-area-left">
            <a href="#">
                <img src="<?php echo base_url() ?>assets/images/logo.png" class="logo" alt="">
            </a>
        </div>
		<!--start mobile logo -->
		<div class="mobile-logo-new">
			<a href="#" class="logo">
                <img src="<?php echo base_url() ?>assets/images/side-logo.png" class="logo" alt="">
            </a>
		</div>
		<!--end mobile logo -->
		
        <div class="row align-items-center header_right">           
            <div class="col-md-9 d_none_sm align-items-center">
                <div class="row">
					<div class="col-sm-2">
						<div class="switch-widget">
							<label class="switch">
							 <input type="checkbox" id="togBtn">
							 <div class="slider round">
							  <span class="on">Short Break</span>
							  <span class="off">Break</span>  
							 </div>
							</label>
						</div>
					</div>
					<div class="col-sm-2">
						<label class="switch">
						 <input type="checkbox" id="togBtn">
						 <div class="slider round">
						  <span class="on">Lunch</span>
						  <span class="off">Lunch</span>  
						 </div>
						</label>
					</div>
					<div class="col-sm-2">
						<div class="login-widget">
							<label class="switch">
							 <input type="checkbox" id="togBtn">
							 <div class="slider round">
							  <span class="on">Log In</span>
							  <span class="off">Log Out</span>  
							 </div>
							</label>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="avail-widget">
							<label class="switch">
							 <input type="checkbox" id="togBtn">
							 <div class="slider round">
							  <span class="on">Unavailable</span>
							  <span class="off">Available</span>  
							 </div>
							</label>
						</div>
					</div>
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
					
                    <li class="dropdown">
                        <i class="fa fa-bell-o dropdown-toggle" data-toggle="dropdown" aria-hidden="true">
							<span class="badge bg-danger rounded-pill">7</span>
						</i>
                        <div class="dropdown-menu notify-box nt-enveloper-box">
                            <span class="notify-title">You have 3 new Messages</span>
                            <div class="nofity-list">
                                <a href="#" class="notify-item">
                                    <div class="notify-thumb">
                                        <img src="<?php echo base_url() ?>assets/images/notification/user.jpg" alt="image">
                                    </div>
                                    <div class="notify-text">
                                        <h3>Name Here</h3>
                                        <span class="msg">
											Sub content Goes Here
										</span>                                        
                                    </div>
                                </a>
                                <a href="#" class="notify-item">
                                    <div class="notify-thumb">
                                        <img src="<?php echo base_url() ?>assets/images/notification/user.jpg" alt="image">
                                    </div>
                                    <div class="notify-text">
                                        <h3>Name Here</h3>
                                        <span class="msg">
											Sub content Goes Here
										</span>
                                    </div>
                                </a>
                                <a href="#" class="notify-item">
                                    <div class="notify-thumb">
                                        <img src="<?php echo base_url() ?>assets/images/notification/user.jpg" alt="image">
                                    </div>
                                    <div class="notify-text">
                                        <h3>Name Here</h3>
                                        <span class="msg">
											Sub content Goes Here
										</span>
                                    </div>
                                </a>
                                <a href="#" class="notify-item">
                                    <div class="notify-thumb">
                                        <img src="<?php echo base_url() ?>assets/images/notification/user.jpg" alt="image">
                                    </div>
                                    <div class="notify-text">
                                        <h3>Name Here</h3>
                                        <span class="msg">
											Sub content Goes Here
										</span>
                                    </div>
                                </a>
                                <a href="#" class="notify-item">
                                    <div class="notify-thumb">
                                        <img src="<?php echo base_url() ?>assets/images/notification/user.jpg" alt="image">
                                    </div>
                                    <div class="notify-text">
                                        <h3>Name Here</h3>
                                        <span class="msg">
											Sub content Goes Here
										</span>
                                    </div>
                                </a>
                                <a href="#" class="notify-item">
                                    <div class="notify-thumb">
                                        <img src="<?php echo base_url() ?>assets/images/notification/user.jpg" alt="image">
                                    </div>
                                    <div class="notify-text">
                                        <h3>Name Here</h3>
                                        <span class="msg">
											Sub content Goes Here
										</span>
                                    </div>
                                </a>
                                <a href="#" class="notify-item">
                                    <div class="notify-thumb">
                                        <img src="<?php echo base_url() ?>assets/images/notification/user.jpg" alt="image">
                                    </div>
                                    <div class="notify-text">
                                        <h3>Name Here</h3>
                                        <span class="msg">
											Sub content Goes Here
										</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown" style="display:none;">
                        <i class="fa fa-envelope-o dropdown-toggle" data-toggle="dropdown" aria-hidden="true">
							<span class="notification_dot"></span>
						</i>
                        <div class="dropdown-menu notify-box nt-enveloper-box">
                            <span class="notify-title">You have 3 new Messages</span>
                            <div class="nofity-list">
                                <a href="#" class="notify-item">
                                    <div class="notify-thumb">
                                        <img src="<?php echo base_url() ?>assets/images/notification/user.jpg" alt="image">
                                    </div>
                                    <div class="notify-text">
                                        <h3>Name Here</h3>
                                        <span class="msg">
											Sub content Goes Here
										</span>                                        
                                    </div>
                                </a>
                                <a href="#" class="notify-item">
                                    <div class="notify-thumb">
                                        <img src="<?php echo base_url() ?>assets/images/notification/user.jpg" alt="image">
                                    </div>
                                    <div class="notify-text">
                                        <h3>Name Here</h3>
                                        <span class="msg">
											Sub content Goes Here
										</span>
                                    </div>
                                </a>
                                <a href="#" class="notify-item">
                                    <div class="notify-thumb">
                                        <img src="<?php echo base_url() ?>assets/images/notification/user.jpg" alt="image">
                                    </div>
                                    <div class="notify-text">
                                        <h3>Name Here</h3>
                                        <span class="msg">
											Sub content Goes Here
										</span>
                                    </div>
                                </a>
                                <a href="#" class="notify-item">
                                    <div class="notify-thumb">
                                        <img src="<?php echo base_url() ?>assets/images/notification/user.jpg" alt="image">
                                    </div>
                                    <div class="notify-text">
                                        <h3>Name Here</h3>
                                        <span class="msg">
											Sub content Goes Here
										</span>
                                    </div>
                                </a>
                                <a href="#" class="notify-item">
                                    <div class="notify-thumb">
                                        <img src="<?php echo base_url() ?>assets/images/notification/user.jpg" alt="image">
                                    </div>
                                    <div class="notify-text">
                                        <h3>Name Here</h3>
                                        <span class="msg">
											Sub content Goes Here
										</span>
                                    </div>
                                </a>
                                <a href="#" class="notify-item">
                                    <div class="notify-thumb">
                                        <img src="<?php echo base_url() ?>assets/images/notification/user.jpg" alt="image">
                                    </div>
                                    <div class="notify-text">
                                        <h3>Name Here</h3>
                                        <span class="msg">
											Sub content Goes Here
										</span>
                                    </div>
                                </a>
                                <a href="#" class="notify-item">
                                    <div class="notify-thumb">
                                        <img src="<?php echo base_url() ?>assets/images/notification/user.jpg" alt="image">
                                    </div>
                                    <div class="notify-text">
                                        <h3>Name Here</h3>
                                        <span class="msg">
											Sub content Goes Here
										</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </li>
                    
                    <li class="user-dropdown">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="<?php echo base_url()?>assets/images/user.jpg" alt="" class="img-fluid">
                            </button>
                            <div class="dropdown-menu dropdown_user" aria-labelledby="dropdownMenuButton" >
                                <div class="dropdown-header d-flex flex-column align-items-center">
                                    <div class="user_img mb-3">
                                        <img src="<?php echo base_url()?>assets/images/user.jpg" alt="User Image">
                                    </div>
                                    <div class="user_bio text-center">
                                        <p class="name font-weight-bold mb-0">
											Profile Name
										</p>
                                        <p class="email text-muted mb-3">
											<a href="#" class="pl-3 pr-3">example@gmail.com</a>
										</p>
                                    </div>
                                </div>
                                <a class="dropdown-item" href="#">
									<i class="fa fa-user" aria-hidden="true"></i> Profile
								</a>
                                <span role="separator" class="divider"></span>
                                <a class="dropdown-item" href="#">
									<i class="fa fa-sign-out" aria-hidden="true"></i> Logout
								</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>            
        </div>

    </div>
<?php include_once $aside_template; ?>
<div id='main_page_content'>
		<?php include_once $content_template; ?>
	</div>
<footer>
        <div class="footer-area">
            <p>&copy; Copyright 2021. All right reserved.</p>
        </div>
    </footer>    
</div>

<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/popper.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/metisMenu.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/main.js"></script>
<script src="<?php echo base_url() ?>assets/js/chart.js"></script>
<script>
	var ctxBAR = document.getElementById("bar-chart");
	var myBarChart_dailyVisitor = new Chart(ctxBAR, {
	type: 'bar',
		data: {
		labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
		datasets: [
	{
	label: "Visitors",
		data: [12, 19, 3, 5, 2, 3],
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
		labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
		datasets: [
	{
	label: "Visitors",
		data: [12, 19, 3, 5, 2, 3],
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
		labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
		datasets: [
	{
	label: "Visitors",
		data: [12, 19, 3, 5, 2, 3],
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

</body>
</html>