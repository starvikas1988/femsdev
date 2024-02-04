<script src="<?php echo base_url(); ?>assets/chartjs/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/chartjs-plugin-datalabels.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>
<?php if($reportType == "monthly" || $reportType == "all"){ ?>
//==================== MONTHLY SCHEDULE ADHERENCE ====================================================================//
/*
var ctxPIE  = document.getElementById("agent_2dpie_monthly_adherence");
var myLineChart = new Chart(ctxPIE, {
  type: 'pie',
  data: {
    labels: ["On Time, <?php echo $schedule_monthly[round($selected_month)]['counters']['ontime']; ?>, (<?php echo $schedule_monthly[round($selected_month)]['percent']['ontime']; ?>%)", 
	         "Late Login, <?php echo $schedule_monthly[round($selected_month)]['counters']['latetime']; ?>, (<?php echo $schedule_monthly[round($selected_month)]['percent']['latetime']; ?>%)", 
			 "Off, <?php echo $schedule_monthly[round($selected_month)]['counters']['offtime']; ?>, (<?php echo $schedule_monthly[round($selected_month)]['percent']['offtime']; ?>%)"],
    datasets: [
	 { 
        data: [
		<?php echo $schedule_monthly[round($selected_month)]['percent']['ontime']; ?>,
		<?php echo $schedule_monthly[round($selected_month)]['percent']['latetime']; ?>,
		<?php echo $schedule_monthly[round($selected_month)]['percent']['offtime']; ?>
		],
        label: "Monthly Schedule Adherence",
        backgroundColor: [<?php $color=0; for($i=0;$i<3;$i++){ echo  "'" .$colorsArray2[$color]; $color++; echo $color < 3 ?"'," : "'"; } ?>],
     }
    ]
  },
  options: {
    legend: { display: true,position: 'right', },
    title: {
      display: false,
      text: "Monthly Schedule Adherence"
    },
	tooltips: {
		callbacks: {
        label: function(tooltipItem, data) { 
            var indice = tooltipItem.index;                 
            return  data.labels[indice];
			//+': '+data.datasets[0].data[indice] + ' %';
        }
		}
	 },
	  maintainAspectRatio: false,
	  responsive: true,
	  plugins: {
	  datalabels: {
		  color: '#ffffff',
		  formatter: (value, ctx) => {
			if(value == 0){
			return "";
			} else {
			return value + '%';
			}
		},
		font: {
		  weight: 'bold'
		}
	  }
	  }	
  }
});
*/

//==================== MONTHLY SCHEDULE ADHERENCE GOOGLE PIE ====================================================================//
google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ["On Time, <?php echo $schedule_monthly[round($selected_month)]['counters']['ontime']; ?>, (<?php echo $schedule_monthly[round($selected_month)]['percent']['ontime']; ?>%)",     <?php echo $schedule_monthly[round($selected_month)]['percent']['ontime']; ?>],
          ["Late Login, <?php echo $schedule_monthly[round($selected_month)]['counters']['latetime']; ?>, (<?php echo $schedule_monthly[round($selected_month)]['percent']['latetime']; ?>%)",      <?php echo $schedule_monthly[round($selected_month)]['percent']['latetime']; ?>],
          ["Off, <?php echo $schedule_monthly[round($selected_month)]['counters']['offtime']; ?>, (<?php echo $schedule_monthly[round($selected_month)]['percent']['offtime']; ?>%)",  <?php echo $schedule_monthly[round($selected_month)]['percent']['offtime']; ?>],
        ]);

        var options = {
          title: "Monthly Schedule Adherence - <?php echo date('F', strtotime($selected_year .'-'.$selected_month.'-01')) ." " . $selected_year; ?>",
          is3D: true,
		  colors: [<?php $color=0; for($i=0;$i<3;$i++){ echo  "'" .$colorsPieArray[$color]; $color++; echo $color < 3 ?"'," : "'"; } ?>],
        };

        var chart = new google.visualization.PieChart(document.getElementById('agent_3dpie_monthly_adherence'));
        chart.draw(data, options);
      }


<?php } ?>


<?php if($reportType == "yearly" || $reportType == "all"){ ?>
//============================= MOM ADHERENCE ============================================

var ctxBAR = document.getElementById("agent_2dpie_mom");
var myBarChart = new Chart(ctxBAR, {
	type: 'bar',
	data: {
	  labels: ["<?php for($i=1;$i<=12;$i++){ echo date('F', strtotime('2019-'.sprintf('%02d', $i) .'-01')); if($i < 12){ echo '","'; } } ?>"],
	  datasets: [
		{
		  data: [<?php $cn = 1;
						for($i=1; $i<=12; $i++)
						{ 	
							$current_data_set = $schedule_monthly[$i];							
							$adherence = $current_data_set['counters']['ontime']/$current_data_set['counters']['nonoff'];
							if(empty($current_data_set['counters']['ontime'])){ $adherence = 0; }
							echo sprintf('%0.2f', ($adherence * 100));
							if($i < 12){ echo ","; }
						}
				?>],
		  backgroundColor: ["<?php shuffle($colorsAllArray); echo $colorSet = implode('","', $colorsAllArray); ?>"],
		  borderColor: ["<?php echo $colorSet; ?>"],
		  borderWidth: 1
		}
	  ]
	},
	
	options: {
	  legend: { display: false, position: 'right' },
	  title: {
		display: true,
		lineHeight: 3,
		text: "MOM ADHERENCE - <?php echo date('F', strtotime($selected_year .'-'.$selected_month.'-01')) ." " . $selected_year; ?>"
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
			//gridLines: { color: "rgba(0, 0, 0, 0)", },
			ticks: {
			  callback: function(value, index, values) {
					return value + '%';
			  },
			  beginAtZero: true,
			  steps: 10,
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
//============================= WEEKLY ADHERENCE ============================================

var ctxBAR = document.getElementById("agent_2dpie_weekly");
var myBarChart = new Chart(ctxBAR, {
	type: 'line',
	data: {
	  labels: ["<?php $current_week_data = $schedule_weekly[round($selected_month)]; $cc=1; foreach($current_week_data as $tokenweek){ echo date('d-M', strtotime($tokenweek['sdate'])); if($cc<count($current_week_data)){ echo '","'; } $cc++; } ?>"],
	  datasets: [
		{
		  data: [<?php $cn = 1;
						foreach($current_week_data as $tokenweek)
						{
							$weekDataOnTime = $tokenweek['percent']['ontime'];
							if(empty($tokenweek['data'])){ $weekDataOnTime = "0"; }
							echo $weekDataOnTime;
							if($cn < count($current_week_data)){ echo ","; }
							$cn++;
						}
				?>],
		  backgroundColor: ["<?php echo $colorsLineArray[0]; ?>"],
		  borderColor: '#a99611',
		  borderWidth: 3,
		  fill: true,
		}
	  ]
	},
	
	options: {
	  legend: { display: false, position: 'right' },
	  title: {
		display: true,
		lineHeight: 4,
		text: "WOW ADHERENCE - <?php echo date('F', strtotime($selected_year .'-'.$selected_month.'-01')) ." " . $selected_year; ?>"
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

</script>