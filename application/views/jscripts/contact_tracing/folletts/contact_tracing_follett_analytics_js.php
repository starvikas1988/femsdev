<script src="<?php echo base_url(); ?>assets/chartjs/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/chartjs-plugin-datalabels.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
<?php
function d_char_escape($text=''){
	$text = addslashes($text);
	$textFinal = str_replace(array("\r\n", "\r", "\n"), "", $text);
	return $textFinal;
}
?>
$('#monthSelect,#yearSelect').change(function(){
	getyear = $('#yearSelect').val();
	getmonth = $('#monthSelect').val();
	extraParam = "?m="+getmonth+'&y='+getyear;
	window.location.href = window.location.href.split("?")[0] + extraParam;
});
</script>

<script>
//=============================================================
// MONTH OVERVIEW
//==============================================================
//--- POSITIVE
<?php
	$lastday = cal_days_in_month(CAL_GREGORIAN, $selected_month, $selected_year);
	$current_dataSet = $months[round($selected_month)]['positive'];		
?>
google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChartMonthPositive);
function drawChartMonthPositive() {
	var data = google.visualization.arrayToDataTable([
	['Location', 'Case Count'],
	<?php $cl=0; foreach($current_dataSet as $tokenu){ ?>	  
	  ["<?php echo ++$cl .'. ' .d_char_escape($tokenu['p_store_location']) .' (' .round($tokenu['casecounts']) .')'; ?>", <?php echo round($tokenu['casecounts']); ?>],
	<?php } ?>
	]);

	var options = {
	  title: "Follett Cases Positive - <?php echo date('F', strtotime($selected_year .'-'.$selected_month.'-01')) ." " . $selected_year; ?>",
	  'is3D':   false,
	  pieHole: 0.4,
	  tooltip: { text: 'value' },
	};

	var chart = new google.visualization.PieChart(document.getElementById('team_2dbar_cases_positive'));
	chart.draw(data, options);
}

//--- NEGATIVE 
<?php
	$lastday = cal_days_in_month(CAL_GREGORIAN, $selected_month, $selected_year);
	$current_dataSet = $months[round($selected_month)]['negative'];		
?>
google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChartMonthNegative);
function drawChartMonthNegative() {
	var data = google.visualization.arrayToDataTable([
	['Location', 'Case Count'],
	<?php $cl=0; foreach($current_dataSet as $tokenu){ ?>	  
	  ["<?php echo ++$cl .'. ' .d_char_escape($tokenu['p_store_location']) .' (' .round($tokenu['casecounts']) .')'; ?>", <?php echo round($tokenu['casecounts']); ?>],
	<?php } ?>
	]);

	var options = {
	  title: "Follett Cases Negative - <?php echo date('F', strtotime($selected_year .'-'.$selected_month.'-01')) ." " . $selected_year; ?>",
	  'is3D':   false,
	  pieHole: 0.4,
	  tooltip: { text: 'value' },
	};

	var chart = new google.visualization.PieChart(document.getElementById('team_2dbar_cases_negative'));
	chart.draw(data, options);
}

//============================= WEEKLY TOP QUESTIONS ============================================
<?php
	$lastday = cal_days_in_month(CAL_GREGORIAN, $selected_month, $selected_year);
	$current_dataSet = $months[round($selected_month)];		
?>
google.charts.load("current", {packages:["corechart"]});
<?php $weekSl = 0; for($i=0; $i<$current_dataSet['weekcount']; $i++){ $weekSl++; ?>
<?php //if(date('Y-m-d') >= $current_dataSet['weekly'][$i]['start']){ ?>

google.charts.setOnLoadCallback(drawChartWeek_positive_<?php echo $weekSl; ?>);
function drawChartWeek_positive_<?php echo $weekSl; ?>() {
	var data = google.visualization.arrayToDataTable([
	['Location', 'Case Count'],
	<?php $cl=0; foreach($current_dataSet['weekly'][$i]['positive'] as $tokenu){ ?>	  
	  ["<?php echo ++$cl .'. ' .d_char_escape($tokenu['p_store_location']) .' (' .round($tokenu['casecounts']) .')'; ?>", <?php echo round($tokenu['casecounts']); ?>],
	<?php } ?>
	]);

	var options = {
	  title: "Follett Positive Case - Week <?php echo $weekSl; ?> (<?php echo date('d M', strtotime($current_dataSet['weekly'][$i]['start'])) .' - ' .date('d M', strtotime($current_dataSet['weekly'][$i]['end'])); ?>)",
	
	  <?php if(date('Y-m-d') >= $current_dataSet['weekly'][$i]['start'] && date('Y-m-d') <= $current_dataSet['weekly'][$i]['end']){ ?>
	  'is3D':  true,
	  <?php } else { ?>
	  'is3D':   false,
	  <?php } ?>
	  pieHole: 0.4,
	  tooltip: { text: 'value' },
	};

	var chart = new google.visualization.PieChart(document.getElementById('team_2dbar_cases_week_positive_<?php echo $weekSl; ?>'));
	chart.draw(data, options);
}

google.charts.setOnLoadCallback(drawChartWeek_negative_<?php echo $weekSl; ?>);
function drawChartWeek_negative_<?php echo $weekSl; ?>() {
	var data = google.visualization.arrayToDataTable([
	['Location', 'Case Count'],
	<?php $cl=0; foreach($current_dataSet['weekly'][$i]['negative'] as $tokenu){ ?>	  
	  ["<?php echo ++$cl .'. ' .d_char_escape($tokenu['p_store_location']) .' (' .round($tokenu['casecounts']) .')'; ?>", <?php echo round($tokenu['casecounts']); ?>],
	<?php } ?>
	]);

	var options = {
	  title: "Follett Negative Case - Week <?php echo $weekSl; ?> (<?php echo date('d M', strtotime($current_dataSet['weekly'][$i]['start'])) .' - ' .date('d M', strtotime($current_dataSet['weekly'][$i]['end'])); ?>)",
	
	  <?php if(date('Y-m-d') >= $current_dataSet['weekly'][$i]['start'] && date('Y-m-d') <= $current_dataSet['weekly'][$i]['end']){ ?>
	  'is3D':  true,
	  <?php } else { ?>
	  'is3D':   false,
	  <?php } ?>
	  pieHole: 0.4,
	  tooltip: { text: 'value' },
	};

	var chart = new google.visualization.PieChart(document.getElementById('team_2dbar_cases_week_negative_<?php echo $weekSl; ?>'));
	chart.draw(data, options);
}

<?php //} ?>
<?php } ?>

</script>