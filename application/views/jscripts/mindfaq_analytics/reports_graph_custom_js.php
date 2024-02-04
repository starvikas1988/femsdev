<script src="<?php echo base_url(); ?>assets/chartjs/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/chartjs-plugin-datalabels.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
$('.newDatePick').datepicker({ dateFormat: 'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '2020:' + new Date().getFullYear().toString() });
$('#monthSelect,#yearSelect,#processSelect').change(function(){
	getyear = $('#yearSelect').val();
	getmonth = $('#monthSelect').val();
	getprocess = $('#processSelect').val();
	extraParam = "?m="+getmonth+'&y='+getyear+'&p='+getprocess;
	window.location.href = window.location.href.split("?")[0] + extraParam;
});

$('.viewAnalyticsBtn').on('click', function(){
	dataURL = $(this).attr('urlcheck');
	dataURLType = $(this).attr('urltype');
	$('#modalProcessReport').find('form').attr('action', dataURL);
	
	$('#sktPleaseWait').modal('show');
	$("#modalProcessReport select[name='processSelect']").empty();
	$("#modalProcessReport select[name='processSelect']").html('<option value="ALL">All</option>');
	$("#modalProcessReport select[name='compare_processSelect']").html('<option value="ALL">All</option>');
	$.ajax({
		url: "<?php echo base_url('mindfaq_analytics/reports_process_list'); ?>",
		type: "GET",
		data: { urltype : dataURLType },
		dataType: "json",
		success : function(result){
			counterCheck = 0;
			$.each(result, function(i,token){
				 counterCheck++;
				 $("#modalProcessReport select[name='processSelect']").append('<option value="'+token.id+'">' + token.name + '</option>');
				 $("#modalProcessReport select[name='compare_processSelect']").append('<option value="'+token.id+'">' + token.name + '</option>');
			});
			if(counterCheck == 0){
				$("#modalProcessReport select[name='processSelect']").html('<option value="">-- No Process Found --</option>');
				$("#modalProcessReport select[name='compare_processSelect']").html('<option value="">-- No Process Found --</option>');
			}
			$('#sktPleaseWait').modal('hide');
		},
		error : function(result){
			$('#sktPleaseWait').modal('hide');
			alert('Something Went Wrong!');
		}
	});
	
	$('#modalProcessReport').modal('show');
});

$('input[name="is_compare"]').click(function(){
	if($(this).is(':checked')){
		$('.comparableDiv').find('select').removeAttr('disabled','disabled');
		$('.comparableDiv').find('input').removeAttr('readonly','readonly');
	} else {
		$('.comparableDiv').find('select').attr('disabled','disabled');
		$('.comparableDiv').find('input').attr('readonly','readonly');		
	}
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



<?php if($content_template == "mindfaq_analytics/reports_custom.php"){ ?>

<?php if($reportType == "monthly" || $reportType == "all"){ ?>

//============================= HOURLY VISITORS ============================================
<?php	
	$current_dataSet = $visitors_hourly['start']['data'];
	$daysArrayNames = array_keys($current_dataSet);
	$daysArrayValues = array_values($current_dataSet);
?>
var ctxBAR = document.getElementById("team_2dbar_hourwise");
var myBarChart_hourVisitor = new Chart(ctxBAR, {
	type: 'line',
	data: {
	  labels: ["<?php echo implode('","', $daysArrayNames); ?>"],
	  datasets: [
		{
		  label: "Visitors",
		  data: [
		  <?php echo implode(',', $daysArrayValues); ?>			
		  ],
		  backgroundColor: "#8798e8",
		  borderColor: '#374275',
		  borderWidth: 3
		}
	  ]
	},	
	options: {
	  legend: { display: false, position: 'right' },
	  title: {
		display: true,
		lineHeight: 4,
		text: "Hourly Searches - <?php echo date('d M, Y', strtotime($selected_start)) ." - " . date('d M, Y', strtotime($selected_end)); ?>"
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

<?php if(!empty($is_compare)){ ?>

//============================= HOURLY COMPARE VISITORS ============================================
<?php	
	$current_dataSet = $visitors_hourly['compare']['data'];
	$daysArrayNames = array_keys($current_dataSet);
	$daysArrayValues = array_values($current_dataSet);
?>
var ctxBAR = document.getElementById("team_2dbar_compare_hourwise");
var myBarChart_hourCompareVisitor = new Chart(ctxBAR, {
	type: 'line',
	data: {
	  labels: ["<?php echo implode('","', $daysArrayNames); ?>"],
	  datasets: [
		{
		  label: "Visitors",
		  data: [
		  <?php echo implode(',', $daysArrayValues); ?>			
		  ],
		  backgroundColor: "#b4e0e0",
		  borderColor: '#2e6f6f',
		  borderWidth: 3
		}
	  ]
	},	
	options: {
	  legend: { display: false, position: 'right' },
	  title: {
		display: true,
		lineHeight: 4,
		text: "Hourly Searches - <?php echo date('d M, Y', strtotime($compare_start)) ." - " . date('d M, Y', strtotime($compare_end)); ?>"
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


<?php } ?>

<?php if($reportType == "monthly" || $reportType == "all"){ ?>

//============================= DAILY VISITORS ============================================
<?php	
	$current_dataSet = $visitors_daily['start']['data'];
	$daysArrayNames = array_keys($current_dataSet);
	$daysArrayValues = array_values($current_dataSet);
?>
var ctxBAR = document.getElementById("team_2dbar_daywise");
var myBarChart_dailyVisitor = new Chart(ctxBAR, {
	type: 'line',
	data: {
	  labels: ["<?php echo implode('","', $daysArrayNames); ?>"],
	  datasets: [
		{
		  label: "Visitors",
		  data: [
		  <?php echo implode(',', $daysArrayValues); ?>			
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
		text: "Daily Searches - <?php echo date('d M, Y', strtotime($selected_start)) ." - " . date('d M, Y', strtotime($selected_end)); ?>"
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


<?php if(!empty($is_compare)){ ?>
//============================= DAILY COMPARE VISITORS ============================================
<?php	
	$current_dataSet = $visitors_daily['compare']['data'];
	$daysArrayNames = array_keys($current_dataSet);
	$daysArrayValues = array_values($current_dataSet);
?>
var ctxBAR = document.getElementById("team_2dbar_compare_daywise");
var myBarChart_compareVisitor = new Chart(ctxBAR, {
	type: 'line',
	data: {
	  labels: ["<?php echo implode('","', $daysArrayNames); ?>"],
	  datasets: [
		{
		  label: "Visitors",
		  data: [
		  <?php echo implode(',', $daysArrayValues); ?>			
		  ],
		  backgroundColor: "#c7eaa0",
		  borderColor: '#648441',
		  borderWidth: 3
		}
	  ]
	},	
	options: {
	  legend: { display: false, position: 'right' },
	  title: {
		display: true,
		lineHeight: 4,
		text: "Daily Searches - <?php echo date('d M, Y', strtotime($compare_start)) ." - " . date('d M, Y', strtotime($compare_end)); ?>"
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

<?php } ?>


<?php if($reportType == "monthly" || $reportType == "all"){ ?>

//============================= FEEDBACK ============================================
<?php
$current_dataSet = $visitors['start'];		
?>
<?php if(!empty($current_dataSet['feedback']['like']) || !empty($current_dataSet['feedback']['dislike'])){ ?>
google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChartFeedback);
function drawChartFeedback()
{
	var data = google.visualization.arrayToDataTable([
	['Feedback', 'No of Feedback'], 
	["Like (<?php echo $current_dataSet['feedback']['like']; ?>)",  <?php echo $current_dataSet['feedback']['like']; ?>],
    ["Dislike (<?php echo $current_dataSet['feedback']['dislike']; ?>)",  <?php echo $current_dataSet['feedback']['dislike']; ?>],
	]);

	var options = {
	  title: "User Feedback - <?php echo date('d M, Y', strtotime($selected_start)) ." - " . date('d M, Y', strtotime($selected_end)); ?>",
	  'is3D':  true,
	  pieHole: 0.4,
	  tooltip: { text: 'value' },
	  slices: {0: {color: '#2dc22d'}, 1:{color: '#dc0b0b'}},
	  chartArea:{width:'100%'}
	};

	var chart = new google.visualization.PieChart(document.getElementById('chart_div_feedback'));
	chart.draw(data, options);
}
<?php } ?>
<?php if(!empty($is_compare)){ ?>
<?php
$current_dataSet = $visitors['compare'];		
?>
<?php if(!empty($current_dataSet['feedback']['like']) || !empty($current_dataSet['feedback']['dislike'])){ ?>
google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChartFeedbackCompare);
function drawChartFeedbackCompare()
{
	var data = google.visualization.arrayToDataTable([
	['Feedback', 'No of Feedback'], 
	["Like (<?php echo $current_dataSet['feedback']['like']; ?>)",  <?php echo $current_dataSet['feedback']['like']; ?>],
    ["Dislike (<?php echo $current_dataSet['feedback']['dislike']; ?>)",  <?php echo $current_dataSet['feedback']['dislike']; ?>],
	]);

	var options = {
	  title: "User Feedback - <?php echo date('d M, Y', strtotime($compare_start)) ." - " . date('d M, Y', strtotime($compare_end)); ?>",
	  'is3D':  true,
	  pieHole: 0.4,
	  tooltip: { text: 'value' },
	  slices: {0: {color: '#a8e2a8'}, 1:{color: '#ff9292'}},
	  chartArea:{width:'100%'}
	};

	var chart = new google.visualization.PieChart(document.getElementById('chart_div_feedback_compare'));
	chart.draw(data, options);
}
<?php } ?>
<?php } ?>
<?php } ?>




<?php if($reportType == "monthly" || $reportType == "all"){ ?>

//============================= TOP QUESTIONS ============================================
<?php
$current_dataSet = $visitors['start'];		
?>
google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChartStartTop);
function drawChartStartTop() 
{
	var data = google.visualization.arrayToDataTable([
	['Questions', 'No Of Searches'],
	<?php $cl=0; foreach($current_dataSet['questions'] as $tokenu){ ?>	  
	  ["<?php echo ++$cl .'. ' .d_char_escape($tokenu['question_intent']) .' (' .round($tokenu['total_users']) .')'; ?>", <?php echo round($tokenu['total_users']); ?>],
	<?php } ?>
	]);
	var options = {
	  title: "Top 10 Questions - <?php echo date('d M, Y', strtotime($selected_start)) ." - " . date('d M, Y', strtotime($selected_end)); ?>",	
	  'is3D':   false,
	  pieHole: 0.4,
	  tooltip: { text: 'value' },
	  colors:['#1e064c','#35149a','#14949a','#149a69','#149a3d','#8c9a14','#9a7d14','#9a5214','#c33535','#cc7d7d'],
	  chartArea:{width:'100%'}
	};
	var chart = new google.visualization.PieChart(document.getElementById('chart_div_questions'));
	chart.draw(data, options);
}
<?php if(!empty($is_compare)){ ?>
<?php
$current_dataSet = $visitors['compare'];		
?>
google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChartCompareTop);
function drawChartCompareTop() 
{
	var data = google.visualization.arrayToDataTable([
	['Questions', 'No Of Searches'],
	<?php $cl=0; foreach($current_dataSet['questions'] as $tokenu){ ?>	  
	  ["<?php echo ++$cl .'. ' .d_char_escape($tokenu['question_intent']) .' (' .round($tokenu['total_users']) .')'; ?>", <?php echo round($tokenu['total_users']); ?>],
	<?php } ?>
	]);
	var options = {
	  title: "Top 10 Questions - <?php echo date('d M, Y', strtotime($compare_start)) ." - " . date('d M, Y', strtotime($compare_end)); ?>",	
	  'is3D':   false,
	  pieHole: 0.4,
	  tooltip: { text: 'value' },
      //colors:['#d1ae2b','#b38849','#d8a35c','#636466','#a09f9f','#31536e','#4c7ea4','#73bfe5','#88d6f8'],
      colors:['#a98ae4','#b5a9da','#31c5cc','#38ca94','#31c35e','#b6c52d','#dab530','#dc8840','#ec5454','#f9baba'],
	  chartArea:{width:'100%'}
	};
	var chart = new google.visualization.PieChart(document.getElementById('chart_div_questions_compare'));
	chart.draw(data, options);
}

<?php } ?>
<?php } ?>



<?php } ?>


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