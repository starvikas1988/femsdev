<script src="<?php echo base_url(); ?>assets/chartjs/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/chartjs-plugin-datalabels.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
$('#monthSelect,#yearSelect').change(function(){
	getyear = $('#yearSelect').val();
	getmonth = $('#monthSelect').val();
	extraParam = "?m="+getmonth+'&y='+getyear;
	window.location.href = window.location.href.split("?")[0] + extraParam;
});

</script>
<script>
Chart.plugins.register({
  beforeDraw: function(chartInstance, easing) {
    var ctx = chartInstance.chart.ctx;
    ctx.fillStyle = '#fff'; // your color here

    var chartArea = chartInstance.chartArea;
    ctx.fillRect(chartArea.left, chartArea.top, chartArea.right - chartArea.left, chartArea.bottom - chartArea.top);
  }
});

<?php if($content_template == "jurys_inn/jurys_inn_reports_visitors.php"){ ?>
<?php if($reportType == "monthly" || $reportType == "all"){ ?>
//============================= TOP USER VISITORS ============================================
<?php
	$lastday = cal_days_in_month(CAL_GREGORIAN, $selected_month, $selected_year);
	$current_dataSet = $visitors[round($selected_month)];		
?>
var ctxBAR = document.getElementById("team_2dbar_userwise");
var myBarChart_dailyVisitorUser = new Chart(ctxBAR, {
	type: 'bar',
	data: {
	  labels: ["<?php $cl=0; foreach($current_dataSet['users'] as $tokenu){ $cl++; echo $tokenu['full_name']; if($cl < count($current_dataSet['users'])){ echo '","'; }} ?>"],
	  datasets: [		
		{
		  label: "Top Users with Searches",
		  data: [
		  <?php $cl=0; foreach($current_dataSet['users'] as $tokenu){ $cl++; echo $tokenu['total_visits']; if($cl < count($current_dataSet['users'])){ echo ','; }} ?>		
		  ],
		  backgroundColor: "<?php echo $colorDayWise[3]; ?>",
		  borderColor: "<?php echo '#f1c421'; ?>",
		  borderWidth: 3
		}
	  ]
	},	
	options: {
	  legend: { 
	    labels: {
		  padding: 30
		},
		display: false, 
		position: 'bottom' 
	  },
	  title: {
		display: true,
		lineHeight: 2,
		text: "Top Users with Searches - <?php echo date('F', strtotime($selected_year .'-'.$selected_month.'-01')) ." " . $selected_year; ?>"
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
			//gridLines: { color: "rgba(0, 0, 0, 0)", }			
		  }],
		  yAxes: [{
			//gridLines: { color: "rgba(0, 0, 0, 0)", },
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
		display:true,
		anchor: 'end',
		align: 'top',
		formatter: (value, ctx) => {
			return value + '';
		},
		font: {
		  size: 9,
		}
	  }
	  }	
	},
	
});
<?php } ?>

<?php if($reportType == "monthly" || $reportType == "all"){ ?>
//============================= DAILY VISITORS ============================================
<?php
	$lastday = cal_days_in_month(CAL_GREGORIAN, $selected_month, $selected_year);
	$current_dataSet = $visitors_daily[round($selected_month)];		
?>
var ctxBAR = document.getElementById("team_2dbar_daywise");
var myBarChart_dailyVisitor = new Chart(ctxBAR, {
	type: 'line',
	data: {
	  labels: ["<?php for($d=1; $d<=$lastday; $d++){ $currDate = $selected_year ."-". $selected_month ."-" .sprintf('%02d', $d); echo date('d M', strtotime($current_dataSet[$currDate]['counters']['date'])); if($d < $lastday){ echo '","'; } } ?>"],
	  datasets: [
		{
		  label: "Visitors",
		  data: [
		  <?php
		    for($d=1; $d<=$lastday; $d++){ 
				$currDate = $selected_year ."-". $selected_month ."-" .sprintf('%02d', $d);
				echo $current_dataSet[$currDate]['counters']['count']; 
				if($d < $lastday){ echo ","; }
		    }
		  ?>			
		  ],
		  backgroundColor: "#b5ffb8",
		  borderColor: '#0e9b14',
		  borderWidth: 3
		}
	  ]
	},	
	options: {
	  legend: { display: false, position: 'right' },
	  title: {
		display: true,
		lineHeight: 2,
		text: "Daily Searches - <?php echo date('F', strtotime($selected_year .'-'.$selected_month.'-01')) ." " . $selected_year; ?>"
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
			//gridLines: { color: "rgba(0, 0, 0, 0)", }			
		  }],
		  yAxes: [{
			display:true,
			//gridLines: { color: "rgba(0, 0, 0, 0)", },
			ticks: {
			  callback: function(value, index, values) {
					return value + '';
			  },
			  beginAtZero: false,
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
<?php } ?>


<?php if($reportType == "monthly" || $reportType == "all"){ ?>
//============================= FEEDBACK ============================================
<?php
	$lastday = cal_days_in_month(CAL_GREGORIAN, $selected_month, $selected_year);
	$current_dataSet = $visitors[round($selected_month)];		
?>
google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChartFeedback);
function drawChartFeedback() {
	var data = google.visualization.arrayToDataTable([
	['Task', 'Hours per Day'], 
	["Like (<?php echo $current_dataSet['feedback']['like']; ?>)",  <?php echo $current_dataSet['feedback']['like']; ?>],
    ["Dislike (<?php echo $current_dataSet['feedback']['dislike']; ?>)",  <?php echo $current_dataSet['feedback']['dislike']; ?>],
	]);

	var options = {
	  title: "User Feedback - <?php echo date('F', strtotime($selected_year .'-'.$selected_month.'-01')) ." " . $selected_year; ?>",
	  'is3D':  true,
	  pieHole: 0.4,
	  tooltip: { text: 'value' },
	  slices: {0: {color: '#2dc22d'}, 1:{color: '#dc0b0b'}}
	};

	var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
	chart.draw(data, options);
	saveGoogleImage('feedback', chart.getImageURI());
}

<?php } ?>


//============================= TOP LIKE QUESTIONS ============================================
<?php 
	if($reportType == "monthly" || $reportType == "all"){ 
	$current_dataSet = $visitors[round($selected_month)]['feedback']['data']['like'];		
?>
var ctxBAR = document.getElementById("team_2dbar_liked");
var myBarChart_dailyVisitorUser = new Chart(ctxBAR, {
	type: 'bar',
	data: {
	  labels: ["<?php $cl=0; foreach($current_dataSet as $tokenu){ $cl++; if($cl <= 20){ echo $tokenu['question_intent']; if($cl < 20){ echo '","'; }} } ?>"],
	  datasets: [		
		{
		  label: "Top Liked Feedback",
		  data: [
		  <?php $cl=0; foreach($current_dataSet as $tokenu){ $cl++; if($cl <= 20){ echo $tokenu['feedbacks']; if($cl < 20){ echo ','; }} } ?>		
		  ],
		  backgroundColor: "<?php echo '#2dc22d'; ?>",
		  borderColor: "<?php echo '#2dc22d'; ?>",
		  borderWidth: 3
		}
	  ]
	},	
	options: {
	  legend: { 
	    labels: {
		  padding: 30
		},
		display: false, 
		position: 'bottom' 
	  },
	  title: {
		display: true,
		lineHeight: 2,
		text: "Top Liked Feedback - <?php echo date('F', strtotime($selected_year .'-'.$selected_month.'-01')) ." " . $selected_year; ?>"
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
			//gridLines: { color: "rgba(0, 0, 0, 0)", }			
		  }],
		  yAxes: [{
			//gridLines: { color: "rgba(0, 0, 0, 0)", },
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
		display:true,
		anchor: 'end',
		align: 'top',
		formatter: (value, ctx) => {
			return value + '';
		},
		font: {
		  size: 9,
		}
	  }
	  }	
	},
	
});
<?php } ?>


//============================= TOP DISLIKED QUESTIONS ============================================
<?php 
	if($reportType == "monthly" || $reportType == "all"){ 
	$current_dataSet = $visitors[round($selected_month)]['feedback']['data']['dislike'];		
?>
var ctxBAR = document.getElementById("team_2dbar_disliked");
var myBarChart_dailyVisitorUser = new Chart(ctxBAR, {
	type: 'bar',
	data: {
	  labels: ["<?php $cl=0; foreach($current_dataSet as $tokenu){ $cl++; if($cl <= 20){ echo $tokenu['question_intent']; if($cl < 20){ echo '","'; }}} ?>"],
	  datasets: [		
		{
		  label: "Top Liked Feedback",
		  data: [
		  <?php $cl=0; foreach($current_dataSet as $tokenu){ $cl++; if($cl <= 20){ echo $tokenu['feedbacks']; if($cl < 20){ echo ','; }} } ?>		
		  ],
		  backgroundColor: "<?php echo '#dc0b0b'; ?>",
		  borderColor: "<?php echo '#dc0b0b'; ?>",
		  borderWidth: 3
		}
	  ]
	},	
	options: {
	  legend: { 
	    labels: {
		  padding: 30
		},
		display: false, 
		position: 'bottom' 
	  },
	  title: {
		display: true,
		lineHeight: 2,
		text: "Top Disliked Feedback - <?php echo date('F', strtotime($selected_year .'-'.$selected_month.'-01')) ." " . $selected_year; ?>"
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
			//gridLines: { color: "rgba(0, 0, 0, 0)", }			
		  }],
		  yAxes: [{
			//gridLines: { color: "rgba(0, 0, 0, 0)", },
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
		display:true,
		anchor: 'end',
		align: 'top',
		formatter: (value, ctx) => {
			return value + '';
		},
		font: {
		  size: 9,
		}
	  }
	  }	
	},
	
});
<?php } ?>


<?php } ?>
<?php if($content_template == "jurys_inn/jurys_inn_reports_questions.php"){ ?>

<?php if($reportType == "monthly" || $reportType == "all"){ ?>
//============================= TOP QUESTIONS ============================================
<?php
	$lastday = cal_days_in_month(CAL_GREGORIAN, $selected_month, $selected_year);
	$current_dataSet = $search[round($selected_month)];		
?>
var ctxBAR = document.getElementById("team_2dbar_questions");
var myBarChart_monthly_top_questions = new Chart(ctxBAR, {
	type: 'bar',
	data: {
	  labels: ["<?php $cl=0; foreach($current_dataSet['questions'] as $tokenu){ $cl++; echo $tokenu['question_intent']; if($cl < count($current_dataSet['questions'])){ echo '","'; }} ?>"],
	  datasets: [		
		{
		  label: "Top 10 Questions Searched",
		  data: [
		  <?php $cl=0; foreach($current_dataSet['questions'] as $tokenu){ $cl++; echo $tokenu['total_users']; if($cl < count($current_dataSet['questions'])){ echo ','; }} ?>		
		  ],
		  backgroundColor: ["<?php echo implode('","',$colorsAllArray); ?>"],
		  borderColor: ["<?php echo implode('","',$colorsAllArray); ?>"],
		  borderWidth: 3
		}
	  ]
	},	
	options: {
	  legend: { 
	    labels: {
		  padding: 30
		},
		display: false, 
		position: 'bottom' 
	  },
	  title: {
		display: true,
		lineHeight: 2,
		text: "Top 10 Questions Searched - <?php echo date('F', strtotime($selected_year .'-'.$selected_month.'-01')) ." " . $selected_year; ?>"
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
			//gridLines: { color: "rgba(0, 0, 0, 0)", }			
		  }],
		  yAxes: [{
			//gridLines: { color: "rgba(0, 0, 0, 0)", },
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
		display:true,
		anchor: 'end',
		align: 'top',
		formatter: (value, ctx) => {
			return value + '';
		},
		font: {
		  size: 9,
		}
	  }
	  }	
	},
	
});

//============================= WEEKLY TOP QUESTIONS ============================================
<?php
	$lastday = cal_days_in_month(CAL_GREGORIAN, $selected_month, $selected_year);
	$current_dataSet = $questions[round($selected_month)];		
?>
google.charts.load("current", {packages:["corechart"]});
<?php $weekSl = 0; for($i=0; $i<$current_dataSet['weekcount']; $i++){ $weekSl++; ?>
<?php if(date('Y-m-d') >= $current_dataSet['weeklyQuestions'][$i]['start']){ ?>
google.charts.setOnLoadCallback(drawChartWeek_<?php echo $weekSl; ?>);
function drawChartWeek_<?php echo $weekSl; ?>() {
	var data = google.visualization.arrayToDataTable([
	['Task', 'Hours per Day'],
	<?php $cl=0; foreach($current_dataSet['weeklyQuestions'][$i]['data'] as $tokenu){ ?>	  
	  ["<?php echo ++$cl .'. ' .$tokenu['question_intent'] .' (' .round($tokenu['total_users']) .')'; ?>", <?php echo round($tokenu['total_users']); ?>],
	<?php } ?>
	]);

	var options = {
	  title: "Top 10 Questions - Week <?php echo $weekSl; ?> (<?php echo date('d M', strtotime($current_dataSet['weeklyQuestions'][$i]['start'])) .' - ' .date('d M', strtotime($current_dataSet['weeklyQuestions'][$i]['end'])); ?>)",
	
	  <?php if(date('Y-m-d') >= $current_dataSet['weeklyQuestions'][$i]['start'] && date('Y-m-d') <= $current_dataSet['weeklyQuestions'][$i]['end']){ ?>
	  'is3D':  true,
	  <?php } else { ?>
	  'is3D':   false,
	  <?php } ?>
	  pieHole: 0.4,
	  tooltip: { text: 'value' },
	};

	var chart = new google.visualization.PieChart(document.getElementById('team_2dbar_questions_week_<?php echo $weekSl; ?>'));
	chart.draw(data, options);
	saveGoogleImage('week<?php echo $weekSl; ?>', chart.getImageURI());
}
<?php } ?>
<?php } ?>

<?php } ?>
<?php } ?>


<?php if($content_template == "jurys_inn/jurys_inn_reports_users.php"){ ?>
<?php if($reportType == "monthly" || $reportType == "all"){ ?>
//============================= TOP USER QUESTIONS ============================================
<?php
	$lastday = cal_days_in_month(CAL_GREGORIAN, $selected_month, $selected_year);
	$current_dataSet = $search[round($selected_month)];		
?>
var ctxBAR = document.getElementById("team_2dbar_users");
var myBarChart_questions_users = new Chart(ctxBAR, {
	type: 'line',
	data: {
	  labels: ["<?php $cl=0; foreach($current_dataSet['users'] as $tokenu){ $cl++; echo $tokenu['full_name']; if($cl < count($current_dataSet['users'])){ echo '","'; }} ?>"],
	  datasets: [		
		{
		  label: "Top Users Asked Questions",
		  data: [
		  <?php $cl=0; foreach($current_dataSet['users'] as $tokenu){ $cl++; echo $tokenu['total_quest']; if($cl < count($current_dataSet['users'])){ echo ','; }} ?>		
		  ],
		  backgroundColor: "<?php echo $colorDayWise[3]; ?>",
		  borderColor: "<?php echo '#f1c421'; ?>",
		  borderWidth: 3
		}
	  ]
	},	
	options: {
	  legend: { 
	    labels: {
		  padding: 30
		},
		display: false, 
		position: 'bottom' 
	  },
	  title: {
		display: true,
		lineHeight: 2,
		text: "Top Users with No of Questions - <?php echo date('F', strtotime($selected_year .'-'.$selected_month.'-01')) ." " . $selected_year; ?>"
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
			//gridLines: { color: "rgba(0, 0, 0, 0)", }			
		  }],
		  yAxes: [{
			//gridLines: { color: "rgba(0, 0, 0, 0)", },
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
		display:true,
		anchor: 'end',
		align: 'top',
		formatter: (value, ctx) => {
			return value + '';
		},
		font: {
		  size: 9,
		}
	  }
	  }	
	},
	
});

//============================= ALL USERS HISTOGRAM ============================================
<?php
	$lastday = cal_days_in_month(CAL_GREGORIAN, $selected_month, $selected_year);
	$current_dataSet = $search[round($selected_month)];
?>
google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChartUsers);
function drawChartUsers() {
	var data = google.visualization.arrayToDataTable([
	  ['User', 'Questions'],
	  <?php $cl=0; foreach($current_dataSet['users'] as $tokenu){ ?>	  
		["<?php echo $tokenu['full_name'] .' (' .$tokenu['fusion_id'] .')'; ?>", <?php echo round($tokenu['total_quest']); ?>],
	  <?php } ?>
	]);

	var options = {
	  title: "No. of questions asked by Users - <?php echo date('F', strtotime($selected_year .'-'.$selected_month.'-01')) ." " . $selected_year; ?>",
	  legend: { position: 'none' },
	};

	var chart = new google.visualization.Histogram(document.getElementById('team_2dbar_allusers'));
	chart.draw(data, options);
	saveGoogleImage('users_histogram', chart.getImageURI());
}

google.charts.load('current', {'packages':['table']});
google.charts.setOnLoadCallback(drawUsersTable);
function drawUsersTable() {
	var data = new google.visualization.DataTable();	
	data.addColumn('string', 'Fusion ID');
	data.addColumn('string', 'Name');
	data.addColumn('string', 'Designation');
	data.addColumn('string', 'L1 Supervisor');	
	data.addColumn('number', 'No of Questions');
	data.addRows([
	<?php $cl=0; foreach($current_dataSet['users'] as $tokenu){ ?>	  
		["<?php echo $tokenu['fusion_id']; ?>", "<?php echo $tokenu['full_name']; ?>", "<?php echo $tokenu['designation']; ?>", "<?php echo $tokenu['l1_supervisor']; ?>", <?php echo round($tokenu['total_quest']); ?>],
	<?php } ?>
	]);

	var table = new google.visualization.Table(document.getElementById('team_2dbar_alluserstable'));
	table.draw(data, {showRowNumber: true, width: '100%', height: '100%'});
}

<?php } ?>
<?php } ?>


$('.exportGraphDailyVisitor').click(function(){
	urlLoc = $('.exportGraphDailyVisitorExcel').attr('href');
	saveImage('daily_visitor', urlLoc);
});

$('.exportGraphDailyVisitorUsers').click(function(){
	urlLoc = $('.exportGraphDailyVisitorUsersExcel').attr('href');
	saveImage('daily_visitor_user', urlLoc);
});

$('.exportGraphTopQuestions').click(function(){
	urlLoc = $('.exportGraphTopQuestionsExcel').attr('href');
	saveImage('top_questions', urlLoc);
});

$('.exportGraphUsersQuestions').click(function(){
	urlLoc = $('.exportGraphUsersQuestionsExcel').attr('href');
	saveImage('users_questions', urlLoc);
});



function saveImage(graph = 'daily_visitor', urlLoc){
  if(graph == 'daily_visitor')
  {
	var dataURL = myBarChart_dailyVisitor.toBase64Image();
    var fileName = "jurysinn_daily_visitors_img.png";  	
  }
  if(graph == 'daily_visitor_user')
  {
	var dataURL = myBarChart_dailyVisitorUser.toBase64Image();
    var fileName = "jurysinn_daily_visitors_users_img.png";  	
  }
  if(graph == 'top_questions')
  {
	var dataURL = myBarChart_monthly_top_questions.toBase64Image();
    var fileName = "jurysinn_monthly_top_questions_img.png";  	
  }
  if(graph == 'users_questions')
  {
	var dataURL = myBarChart_questions_users.toBase64Image();
    var fileName = "jurysinn_users_questions_img.png";  	
  }
  $.ajax({
	  type: "POST",
	  url: "<?php echo base_url('jurys_inn/saveImageOnServer'); ?>",
	  data: { 
		 filData: dataURL,
		 fileName: fileName
	  }
	}).done(function(success) {
	  console.log('saved');
	  window.location.href = urlLoc;
	});
}



function saveGoogleImage(graph = 'feedback', dataURL){
  if(graph == 'feedback')
  {
    var fileName = "jurysinn_feedback_questions_img.png";  	
  }
  if(graph == 'week1')
  {
    var fileName = "jurysinn_weekly_1_top_questions_img.png";  	
  }
  if(graph == 'week2')
  {
    var fileName = "jurysinn_weekly_2_top_questions_img.png";  	
  }
  if(graph == 'week3')
  {
    var fileName = "jurysinn_weekly_3_top_questions_img.png";  	
  }
  if(graph == 'week4')
  {
    var fileName = "jurysinn_weekly_4_top_questions_img.png";  	
  }
  if(graph == 'week5')
  {
    var fileName = "jurysinn_weekly_5_top_questions_img.png";  	
  }
  if(graph == 'week6')
  {
    var fileName = "jurysinn_weekly_6_top_questions_img.png";  	
  }
  if(graph == 'week7')
  {
    var fileName = "jurysinn_weekly_7_top_questions_img.png";  	
  }
  if(graph == 'users_histogram')
  {
    var fileName = "jurysinn_users_histogram_img.png";  	
  }
  $.ajax({
	  type: "POST",
	  url: "<?php echo base_url('jurys_inn/saveImageOnServer'); ?>",
	  data: { 
		 filData: dataURL,
		 fileName: fileName
	  }
	}).done(function(success) {
	  console.log('saved');
	  if(graph == "feedback")
	  {
		window.location.href = urlLoc;  
	  }	  
	});
}
</script>