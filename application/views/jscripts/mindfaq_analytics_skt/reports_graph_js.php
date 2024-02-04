<script src="<?php echo base_url(); ?>assets/chartjs/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/chartjs-plugin-datalabels.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
$('.newDatePick').datepicker({ dateFormat: 'mm/dd/yy' });
$('#monthSelect,#yearSelect,#processSelect').change(function(){
	getyear = $('#yearSelect').val();
	getmonth = $('#monthSelect').val();
	getprocess = $('#processSelect').val();
	extraParam = "?m="+getmonth+'&y='+getyear+'&p='+getprocess;
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

<?php if($content_template == "mindfaq_analytics_skt/reports_visitors.php"){ ?>
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
		lineHeight: 4,
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
		lineHeight: 4,
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
<?php if(!empty($current_dataSet['feedback']['like']) || !empty($current_dataSet['feedback']['dislike'])){ ?>
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
<?php } ?>


//============================= TOP LIKE QUESTIONS ============================================
<?php 
	if($reportType == "monthly" || $reportType == "all"){ 
	$current_dataSet = $visitors[round($selected_month)]['feedback']['data']['like'];		
?>
<?php if(!empty($current_dataSet)){ ?>
var ctxBAR = document.getElementById("team_2dbar_liked");
var myBarChart_dailyVisitorUser = new Chart(ctxBAR, {
	type: 'bar',
	data: {
	  labels: ["<?php $cl=0; foreach($current_dataSet as $tokenu){ $cl++; if($cl <= 20){ if($cl > 1  && $cl <= 20){ echo '","'; } echo d_char_escape($tokenu['question_intent']); } } ?>"],
	  datasets: [		
		{
		  label: "Top Liked Feedback",
		  data: [
		  <?php $cl=0; foreach($current_dataSet as $tokenu){ $cl++; if($cl <= 20){ if($cl > 1 && $cl <= 20){ echo ','; } echo d_char_escape($tokenu['feedbacks']); } } ?>		
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
		lineHeight: 4,
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
<?php } ?>


//============================= TOP DISLIKED QUESTIONS ============================================
<?php 
	if($reportType == "monthly" || $reportType == "all"){ 
	$current_dataSet = $visitors[round($selected_month)]['feedback']['data']['dislike'];		
?>
<?php if(!empty($current_dataSet)){ ?>
var ctxBAR = document.getElementById("team_2dbar_disliked");
var myBarChart_dailyVisitorUser = new Chart(ctxBAR, {
	type: 'bar',
	data: {
	  labels: ["<?php $cl=0; foreach($current_dataSet as $tokenu){ $cl++; if($cl <= 20){ if($cl > 1  && $cl <= 20){ echo '","'; }  echo d_char_escape($tokenu['question_intent']); }} ?>"],
	  datasets: [		
		{
		  label: "Top Liked Feedback",
		  data: [
		  <?php $cl=0; foreach($current_dataSet as $tokenu){ $cl++; if($cl <= 20){ if($cl > 1 && $cl <= 20){ echo ','; } echo d_char_escape($tokenu['feedbacks']); } } ?>		
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
		lineHeight: 4,
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


<?php } ?>
<?php if($content_template == "mindfaq_analytics_skt/reports_questions.php"){ ?>

<?php if($reportType == "monthly" || $reportType == "all"){ ?>
//============================= TOP QUESTIONS ============================================
<?php
	$lastday = cal_days_in_month(CAL_GREGORIAN, $selected_month, $selected_year);
	$current_dataSet = $search[round($selected_month)];

	// QUESTIONS
	$cl=0; $questionEarray = array(); $maxlen = 1;
	foreach($current_dataSet['questions'] as $tokenu){ 
		$cl++; $questionEarray[] = d_char_escape($tokenu['question_intent']); 
		if(strlen($tokenu['question_intent']) > $maxlen){ $maxlen = strlen($tokenu['question_intent']); }
	}
	$finalQuestion = array(); $cl=0; 
	foreach($questionEarray as $tokenu){
		$cl++;
		$addUp = "      ";
		if($maxlen > strlen($tokenu) && $cl==1){ for($i=1;$i<($maxlen - strlen($tokenu));$i++){ $addUp .= " "; } }
		$finalQuestion[] = $addUp.$tokenu;
	}
?>
var ctxBAR = document.getElementById("team_2dbar_questions");
var myBarChart_monthly_top_questions = new Chart(ctxBAR, {
	type: 'bar',
	data: {
	  labels: ["<?php echo implode('","', $finalQuestion); ?>"],
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
		lineHeight: 4,
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
			   ticks: {
				fontSize: 10,
				//autoSkip: false
			  }
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
	  ["<?php echo ++$cl .'. ' .d_char_escape($tokenu['question_intent']) .' (' .round($tokenu['total_users']) .')'; ?>", <?php echo round($tokenu['total_users']); ?>],
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


<?php if($content_template == "mindfaq_analytics_skt/reports_users.php"){ ?>
<?php if($reportType == "monthly" || $reportType == "all"){ ?>
//============================= TOP USER QUESTIONS ============================================
<?php
	$lastday = cal_days_in_month(CAL_GREGORIAN, $selected_month, $selected_year);
	$current_dataSet = $search[round($selected_month)];	
	$totalShow = "30";
?>
var ctxBAR = document.getElementById("team_2dbar_users");
var myBarChart_questions_users = new Chart(ctxBAR, {
	type: 'line',
	data: {
	  labels: ["<?php $cl=0; foreach($current_dataSet['users'] as $tokenu){ $cl++; if($cl > $totalShow){ continue; } echo $tokenu['full_name']; if($cl < $totalShow){ echo '","'; }} ?>"],
	  datasets: [		
		{
		  label: "Top Users Asked Questions",
		  data: [
		  <?php $cl=0; foreach($current_dataSet['users'] as $tokenu){ $cl++; if($cl > $totalShow){ continue; } echo $tokenu['total_quest']; if($cl < $totalShow){ echo ','; }} ?>		
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
		lineHeight: 4,
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
		["<?php echo $tokenu['fusion_id']; ?>", "<?php echo d_char_escape($tokenu['full_name']); ?>", "<?php echo d_char_escape($tokenu['designation']); ?>", "<?php echo d_char_escape($tokenu['l1_supervisor']); ?>", <?php echo round($tokenu['total_quest']); ?>],
	<?php } ?>
	]);

	var table = new google.visualization.Table(document.getElementById('team_2dbar_alluserstable'));
	table.draw(data, {showRowNumber: true, width: '100%', height: '100%'});
}

<?php } ?>
<?php } ?>



<?php if($content_template == "mindfaq_analytics_skt/reports_overview.php"){ ?>

<?php if($reportType == "monthly" || $reportType == "all"){ ?>

//==================== DAILY QUESTIONS OVERVIEW ===============================
<?php
	$current_dataSet = $overview_daily[round($selected_month)];
	$current_dateSet = $overview_dates[round($selected_month)];	
?>
google.charts.load("current", {packages:["corechart"]});
<?php 
	$weekSl = 0;
	for($i=0; $i<$current_dateSet['count']; $i++){ 
	$currentDate = $current_dateSet['date'][$i];
	if(date('Y-m-d') >= $currentDate){
		++$weekSl;
?>
google.charts.setOnLoadCallback(drawChartDaily_<?php echo $weekSl; ?>);
function drawChartDaily_<?php echo $weekSl; ?>() {
	var data = google.visualization.arrayToDataTable([
	['Task', 'Hours per Day'],
	<?php $cl=0; $countCheck = 0; foreach($current_dataSet[$currentDate]['counters']['data'] as $tokenu){ $countCheck++; if($countCheck == 31){ break; } ?>	  
	  ["<?php echo ++$cl .'. ' .d_char_escape($tokenu['question_intent']) .' (' .round($tokenu['total_users']) .')'; ?>", <?php echo round($tokenu['total_users']); ?>],
	<?php } ?>
	]);

	var options = {
	  title: "Questions Overview - (<?php echo date('d F Y', strtotime($currentDate)); ?>)",
	
	  <?php if(date('Y-m-d') >= $currentDate && date('Y-m-d') <= $currentDate){ ?>
	  'is3D':  true,
	  <?php } else { ?>
	  'is3D':   false,
	  <?php } ?>
	  pieHole: 0.4,
	  tooltip: { text: 'value' },
	};

	var chart = new google.visualization.PieChart(document.getElementById('team_2dbar_questions_week_<?php echo $weekSl; ?>'));
	chart.draw(data, options);
	//saveGoogleImage('week<?php echo $weekSl; ?>', chart.getImageURI());
}
<?php } ?>
<?php } ?>


//============================= QUESTIONS OVERVIEW ============================================
<?php
$current_dataSet = $feedback_daily[round($selected_month)];
$current_dateSet = $overview_dates[round($selected_month)];	
$current_alldateSet = $overview_daily[round($selected_month)];	
?>

google.charts.load('current', {'packages':['table']});
<?php 
	$weekSl = 0;
	foreach($current_dateSet['date'] as $token){
	$currentDate = $token;
	if(date('Y-m-d') >= $currentDate){
		++$weekSl;
?>


google.charts.setOnLoadCallback(drawFeedbackTable_<?php echo $weekSl; ?>);
function drawFeedbackTable_<?php echo $weekSl; ?>() {
	var data = new google.visualization.DataTable();	
	data.addColumn('string', 'Question Asked');
	data.addColumn('string', 'Actual Question');
	data.addColumn('string', 'Answer');
	data.addRows([
	<?php 
	$cl=0; 
	$currentDataGot = $current_alldateSet[$token]['counters']['data'];
	$countCheck = 0;
	foreach($currentDataGot as $tokenu){
		$countCheck++;
		if($countCheck == 31){ break; }
	?>	  
	  ["<?php echo $tokenu['question_org']; ?>", "<?php echo d_char_escape($tokenu['question_intent']); ?>", "<?php echo !empty($tokenu['answer']) ? d_char_escape($tokenu['answer']) : '-'; ?>"],
	<?php } ?>
	]);
	

	var table = new google.visualization.Table(document.getElementById('team_2dbar_allfeedbacktable_<?php echo $weekSl; ?>'));
	table.draw(data, {showRowNumber: true,  allowHtml:true, page:true, width: '100%', height: '100%'});
	$('#team_2dbar_allfeedbacktable_<?php echo $weekSl; ?>').closest('div.row').find('.dataDiv').hide();
}
<?php } ?>
<?php } ?>

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
	  url: "<?php echo base_url('mindfaq_analytics_skt/saveImageOnServer'); ?>",
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
	  url: "<?php echo base_url('mindfaq_analytics_skt/saveImageOnServer'); ?>",
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


$('.headDiv h3 a').on('click', function(){
	$('.dataDiv').hide();
	$(this).closest('div.row').find('.dataDiv').show();
	$('html,body').animate({
	   scrollTop: $(this).closest('div.row').offset().top
	});
});


<?php
function d_char_escape($text=''){
	$text = addslashes($text);
	$textFinal = str_replace(array("\r\n", "\r", "\n"), "", $text);
	//$newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");
	//$one_string = str_replace($newlines, "", html_entity_decode($textFinal));
	return $textFinal;
}
?>

<?php
function d_char_find($start='', $end='', $sentence){
	$result = "";
	if(preg_match('/Reason(.*?)User Comment/', $sentence, $match) == 1){
	//if(preg_match('/'.$start.'(.*?).'.$end.'/', $sentence, $match) == 1){
		$result = !empty($match[1]) ? $match[1] : "";
	}
	return $result;
}
?>
</script>