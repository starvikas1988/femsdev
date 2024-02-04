<script src="<?php echo base_url(); ?>assets/chartjs/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/chartjs-plugin-datalabels.js"></script>
<script>

<?php if($reportType == "monthly" || $reportType == "all"){ ?>
//============================= DAYWISE LOGIN DATA ============================================
<?php
	$lastday = cal_days_in_month(CAL_GREGORIAN, $selected_month, $selected_year);
	$current_dataSet = $schedule_team[round($selected_month)];		
?>
var ctxBAR = document.getElementById("team_2dpie_daywise");
var myBarChart = new Chart(ctxBAR, {
	type: 'bar',
	data: {
	  labels: ["<?php for($d=1; $d<=$lastday; $d++){ $currDate = $selected_year ."-". $selected_month ."-" .sprintf('%02d', $d); if($todayDate > $currDate){ echo $current_dataSet[$currDate]['counters']['date']; if($d < $lastday){ echo '","'; } } } ?>"],
	  datasets: [		
		{
		  label: "Login",
		  data: [
		  <?php
		    for($d=1; $d<=$lastday; $d++){ 
				$currDate = $selected_year ."-". $selected_month ."-" .sprintf('%02d', $d);
				if($todayDate > $currDate){
				if($todayDate > $currDate){
				echo $current_dataSet[$currDate]['counters']['login'];
				} else { echo "0"; }
				if($d < $lastday){ echo ","; }
				}
		    }
		  ?>			
		  ],
		  backgroundColor: "<?php echo $colorDayWise[0]; ?>",
		  borderColor: "<?php echo $colorDayWise[0]; ?>",
		  borderWidth: 1
		},
		{
		  label: "On Time",
		  data: [
		  <?php
		    for($d=1; $d<=$lastday; $d++){ 
				$currDate = $selected_year ."-". $selected_month ."-" .sprintf('%02d', $d);
				if($todayDate > $currDate){
				if($todayDate > $currDate){
				echo $current_dataSet[$currDate]['counters']['ontime'];
				} else { echo "0"; }
				if($d < $lastday){ echo ","; }
				}
		    }
		  ?>			
		  ],
		  backgroundColor: "<?php echo $colorDayWise[1]; ?>",
		  borderColor: "<?php echo $colorDayWise[1]; ?>",
		  borderWidth: 1
		},
		{
		  label: "Late Login",
		  data: [
		  <?php
		    for($d=1; $d<=$lastday; $d++){ 
				$currDate = $selected_year ."-". $selected_month ."-" .sprintf('%02d', $d);
				if($todayDate > $currDate){
				if($todayDate > $currDate){
				echo $current_dataSet[$currDate]['counters']['latetime']; 
				} else { echo "0"; }
				if($d < $lastday){ echo ","; }
				}
		    }
		  ?>			
		  ],
		  backgroundColor: "<?php echo $colorDayWise[2]; ?>",
		  borderColor: "<?php echo $colorDayWise[2]; ?>",
		  borderWidth: 1
		},
		{
		  label: "No Login",
		  data: [
		  <?php
		    for($d=1; $d<=$lastday; $d++){ 
				$currDate = $selected_year ."-". $selected_month ."-" .sprintf('%02d', $d);
				if($todayDate > $currDate){
				if($todayDate > $currDate){
				echo $current_dataSet[$currDate]['counters']['nologin'];
				} else { echo "0"; }
				if($d < $lastday){ echo ","; }
				}
		    }
		  ?>			
		  ],
		  backgroundColor: "<?php echo $colorDayWise[3]; ?>",
		  borderColor: "<?php echo $colorDayWise[3]; ?>",
		  borderWidth: 1
		}
	  ]
	},	
	options: {
	  legend: { 
	    labels: {
		  padding: 30
		},
		display: true, 
		position: 'bottom' 
	  },
	  title: {
		display: true,
		lineHeight: 2,
		text: "Day Wise Login Data - <?php echo date('F', strtotime($selected_year .'-'.$selected_month.'-01')) ." " . $selected_year; ?>"
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
		display:false,
		formatter: (value, ctx) => {
			return value + '';
		},
		font: {
		  size: 7,
		}
	  }
	  }	
	},
	
});
<?php } ?>


<?php if($reportType == "monthly" || $reportType == "all"){ ?>
//============================= DAYWISE ADHERENCE ============================================

var ctxBAR = document.getElementById("team_2dpie_daywise_adherence");
var myBarChart = new Chart(ctxBAR, {
	type: 'line',
	data: {
	  labels: ["<?php for($d=1; $d<=$lastday; $d++){ $currDate = $selected_year ."-". $selected_month ."-" .sprintf('%02d', $d); if($todayDate > $currDate){ echo $current_dataSet[$currDate]['counters']['date']; if($d < $lastday){ echo '","'; } } } ?>"],
	  datasets: [
		{
		  label: "Adherence",
		  data: [
		  <?php
		    for($d=1; $d<=$lastday; $d++){ 
				$currDate = $selected_year ."-". $selected_month ."-" .sprintf('%02d', $d);
				if($todayDate > $currDate){
				if($todayDate > $currDate){
				echo $current_dataSet[$currDate]['percent']['adherence'];
				} else { echo "0"; }				
				if($d < $lastday){ echo ","; }
				}
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
		text: "Day Wise Adherence - <?php echo date('F', strtotime($selected_year .'-'.$selected_month.'-01')) ." " . $selected_year; ?>"
	  },
	  tooltips: {
		callbacks: {
		   label: function(tooltipItem) {
				  return tooltipItem.yLabel + '%';
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
					return value + '%';
			  },
			  beginAtZero: false,
			  steps: 5,
			  stepValue: 5,
			  max: 100
			}
		  }]
		},
	  plugins: {
	  datalabels: {
		anchor: 'end',
		align: 'top',
		formatter: (value, ctx) => {
			return value + '%';
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


<?php if($reportType == "weekly" || $reportType == "all"){ ?>
//============================= WEEKLY ADHERENCE ============================================

var ctxBAR = document.getElementById("team_2dpie_weekly_adherence");
var myBarChart = new Chart(ctxBAR, {
	type: 'line',
	data: {
	  labels: ["<?php $current_week_data = $schedule_weekly[round($selected_month)]; $cc=1; foreach($current_week_data as $tokenweek){ if($todayDate > date('Y-m-d', strtotime($tokenweek['sdate']))){ echo date('d-M', strtotime($tokenweek['sdate'])); if($cc<count($current_week_data)){ echo '","'; } } $cc++;  } ?>"],
	  datasets: [
		{
		  data: [<?php $cn = 1;
						foreach($current_week_data as $tokenweek)
						{
							$weekDataOnTime = $tokenweek['percent']['adherence'];
							if($todayDate > date('Y-m-d', strtotime($tokenweek['sdate']))){
							if(empty($tokenweek['data'])){ $weekDataOnTime = "0"; }
							if($todayDate <= date('Y-m-d', strtotime($tokenweek['sdate']))){  $weekDataOnTime = "0";  }
							echo $weekDataOnTime;
							if($cn < count($current_week_data)){ echo ","; }
							}
							$cn++;
						}
				?>],
		  backgroundColor: ["<?php echo $colorDayWise[3]; ?>"],
		  borderColor: '#978926',
		  borderWidth: 3,
		  fill: true,
		}
	  ]
	},
	
	options: {
	  legend: { display: false, position: 'right' },
	  title: {
		display: true,
		lineHeight: 2,
		text: "WOW ADHERENCE - <?php echo date('F', strtotime($selected_year .'-'.$selected_month.'-01')) ." " . $selected_year; ?>",
		position:'bottom'
	  },
	  tooltips: {
		callbacks: {
		   label: function(tooltipItem) {
				  return tooltipItem.yLabel + '%';
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
					return value + '%';
			  },
			  beginAtZero: false,
			  steps: 5,
			  stepValue: 5,
			  max: 100
			}
		  }]
		},
	  plugins: {
	  datalabels: {
		anchor: 'end',
		align: 'top',
		formatter: (value, ctx) => {
			return value + '%';
		},
		font: {
		  weight: 'bold'
		}
	  }
	  }	
	},
	
});
<?php } ?>


<?php if($reportType == "weekly" || $reportType == "all"){ ?>
//============================= WOW LOGIN DATA ============================================

var ctxBAR = document.getElementById("team_2dpie_weekly");
var myBarChart = new Chart(ctxBAR, {
	type: 'bar',
	data: {
	  labels: ["<?php $current_week_data = $schedule_weekly[round($selected_month)]; $cc=1; foreach($current_week_data as $tokenweek){ if($todayDate > date('Y-m-d', strtotime($tokenweek['sdate']))){ echo date('d-M', strtotime($tokenweek['sdate'])); if($cc<count($current_week_data)){ echo '","'; } } $cc++;  } ?>"],
	    datasets: [
		{
		  label: "Schedule",
		  data: [
		  <?php
			$cc=1;
		    foreach($current_week_data as $tokenweek){
				$currDate = $selected_year ."-". $selected_month ."-" .sprintf('%02d', $d);
				if($todayDate > date('Y-m-d', strtotime($tokenweek['sdate']))){
				if($todayDate > date('Y-m-d', strtotime($tokenweek['sdate']))){
				echo $tokenweek['counters']['scheduled']; 
				} else { echo "0"; }
				if($cl < count($current_week_data)){ echo ","; }
				}
				$cc++;
		    }
		  ?>			
		  ],
		  backgroundColor: "<?php echo $colorWeeklyWise[0]; ?>",
		  borderColor: "<?php echo $colorWeeklyWise[0]; ?>",
		  borderWidth: 1
		},
		{
		  label: "Login",
		  data: [
		  <?php
			$cc=1;
		    foreach($current_week_data as $tokenweek){
				$currDate = $selected_year ."-". $selected_month ."-" .sprintf('%02d', $d);
				if($todayDate > date('Y-m-d', strtotime($tokenweek['sdate']))){
				if($todayDate > date('Y-m-d', strtotime($tokenweek['sdate']))){
				echo $tokenweek['counters']['login']; 
				} else { echo "0"; }
				if($cl < count($current_week_data)){ echo ","; }
				}
				$cc++;
		    }
		  ?>			
		  ],
		  backgroundColor: "<?php echo $colorWeeklyWise[1]; ?>",
		  borderColor: "<?php echo $colorWeeklyWise[1]; ?>",
		  borderWidth: 1
		},
		{
		  label: "On Time",
		  data: [
		  <?php
		    $cc=1;
		    foreach($current_week_data as $tokenweek){
				$currDate = $selected_year ."-". $selected_month ."-" .sprintf('%02d', $d);
				if($todayDate > date('Y-m-d', strtotime($tokenweek['sdate']))){
				if($todayDate > date('Y-m-d', strtotime($tokenweek['sdate']))){
				echo $tokenweek['counters']['ontime']; 
				} else { echo "0"; }
				if($cl < count($current_week_data)){ echo ","; }
				}
				$cc++;
		    }
		  ?>			
		  ],
		  backgroundColor: "<?php echo $colorWeeklyWise[2]; ?>",
		  borderColor: "<?php echo $colorWeeklyWise[2]; ?>",
		  borderWidth: 1
		},
		{
		  label: "Late Login",
		  data: [
		  <?php
		    $cc=1;
		    foreach($current_week_data as $tokenweek){
				$currDate = $selected_year ."-". $selected_month ."-" .sprintf('%02d', $d);
				if($todayDate > date('Y-m-d', strtotime($tokenweek['sdate']))){
				if($todayDate > date('Y-m-d', strtotime($tokenweek['sdate']))){
				echo $tokenweek['counters']['latetime']; 
				} else { echo "0"; }
				if($cl < count($current_week_data)){ echo ","; }
				}
				$cc++;
		    }
		  ?>			
		  ],
		  backgroundColor: "<?php echo $colorWeeklyWise[3]; ?>",
		  borderColor: "<?php echo $colorWeeklyWise[3]; ?>",
		  borderWidth: 1
		},
		{
		  label: "No Login",
		  data: [
		  <?php
		    $cc=1;
		    foreach($current_week_data as $tokenweek){
				$currDate = $selected_year ."-". $selected_month ."-" .sprintf('%02d', $d);
				if($todayDate > date('Y-m-d', strtotime($tokenweek['sdate']))){
				if($todayDate > date('Y-m-d', strtotime($tokenweek['sdate']))){
				echo $tokenweek['counters']['nologin']; 
				} else { echo "0"; }
				if($cl < count($current_week_data)){ echo ","; }
				}
				$cc++;
		    }
		  ?>			
		  ],
		  backgroundColor: "<?php echo $colorWeeklyWise[4]; ?>",
		  borderColor: "<?php echo $colorWeeklyWise[4]; ?>",
		  borderWidth: 1
		}
	  ]
	},	
	options: {
	  legend: { 
	    labels: {
		  padding: 30
		},
		display: true, 
		position: 'bottom' 
	  },
	  title: {
		display: true,
		lineHeight: 4,
		text: "WOW Login Data - <?php echo date('F', strtotime($selected_year .'-'.$selected_month.'-01')) ." " . $selected_year; ?>"
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



function saveGoogleImage(graph = 'feedback', dataURL){
  if(graph == 'feedback')
  {
    var fileName = "schedule_adherence_img.png";  	
  }
  $.ajax({
	  type: "POST",
	  url: "<?php echo base_url('schedule_adherence/saveImageOnServer'); ?>",
	  data: { 
		 filData: dataURL,
		 fileName: fileName
	  }
	}).done(function(success) {
	  console.log('saved');  
	});
}
</script>