<script src="<?php echo base_url(); ?>assets/chartjs/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/chartjs-plugin-datalabels.js"></script>
<script>
$(".kyt_datePicker").datepicker();



<?php if($content_template == "kyt/ldc_teacher_utilise_report.php"){ ?>
<?php
	$hoursAvailable = array();
	$scheduleAvailable = array();
	$teacherNameAr = array();
	foreach($teacherArray as $key=>$token){
		$teacherID = $token['id'];		
		$teacherNameAr[] = $token['fname'] ." " .$token['lname'];
		$totalSeconds = array_sum($overview[$teacherID]['all']);
		$scheduleSeconds = array_sum($overview[$teacherID]['schedule']);
		$hoursAvailable[] = $totalSeconds/3600;
		$scheduleAvailable[] = $scheduleSeconds/3600;
	}	
?>

<?php if(!empty($teacherNameAr)){ ?>
var ctxBAR = document.getElementById("team_2dpie_daywise");
var myBarChart = new Chart(ctxBAR, {
	type: 'bar',
	data: {
	  labels: ["<?php echo implode('","', $teacherNameAr); ?>"],
	  datasets: [		
		{
		  label: "Available",
		  data: [
		  <?php echo implode(',', $hoursAvailable); ?>		
		  ],
		  backgroundColor: "<?php echo $colorDayWise[1]; ?>",
		  borderColor: "<?php echo $colorDayWise[1]; ?>",
		  borderWidth: 1
		},
		{
		  label: "Schedule",
		  data: [
		  <?php echo implode(',', $scheduleAvailable); ?>
		  ],
		  backgroundColor: "<?php echo $colorDayWise[0]; ?>",
		  borderColor: "<?php echo $colorDayWise[0]; ?>",
		  borderWidth: 1
		},
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
		text: "Teacher Utilization Report"
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
<?php } ?>







<?php if($content_template == "kyt/ldc_teacher_hourly_report.php"){ ?>
<?php
	$hoursAvailable = array();
	$scheduleAvailable = array();
	$dates = array();
	for($d=1; $d<=$maxDay; $d++){ 
		$currDate = $gotYear ."-". $gotMonth ."-" .sprintf('%02d', $d);
		$hoursAvailable[] = $totalSeconds = !empty($currDate) ? array_sum($reporting[$currDate][$gotTeacher]['all']) : '0';
		$scheduleAvailable[] = $scheduleSeconds = !empty($currDate) ? array_sum($reporting[$currDate][$gotTeacher]['schedule']) : '0';
		$dates[] = date('d M, Y', strtotime($currDate));
		$unutilisedSeconds = $totalSeconds - $scheduleSeconds;
		$untilisation = 0;
		if($unutilisedSeconds > 0){
			$untilisation = ($scheduleSeconds/$totalSeconds) * 100;
		}
		$utilise[] = $untilisation;
	}	
?>

<?php if(!empty($dates)){ ?>
var ctxBAR = document.getElementById("team_2dpie_daywise_adherence");
var myBarChart = new Chart(ctxBAR, {
	type: 'line',
	data: {
	  labels: ["<?php echo implode('","', $dates); ?>"],
	  datasets: [
		{
		  label: "Available Utilization",
		  data: [
		  <?php echo implode(',', $utilise); ?>		
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
		text: "Available Utilization"
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
<?php } ?>



<?php if($content_template == "kyt/ldc_teacher_leave_report.php"){ ?>
<?php
	$nameAr = array();
	$leaveAr = array();
	foreach($teacherArray as $key=>$token){
		$tid = $token['employee_id'];
		$nameAr[] =  $token['teacher_name'];
		$leaveAr[] =  !empty($overallDates[$tid]) ? count($overallDates[$tid]) : "0";
	}
?>

<?php if(!empty($nameAr)){ ?>
var ctxPIE  = document.getElementById("qa_2dpie_graph_container");
var myLineChart = new Chart(ctxPIE, {
  type: 'pie',
  data: {
    labels: ["<?php echo implode('","', $nameAr); ?>"],
    datasets: [
	 { 
        data: [<?php echo implode(',', $leaveAr); ?>],
        label: "KYT Leave",
        backgroundColor: [<?php $ij=0; shuffle($randomColors); foreach($nameAr as $token){ echo  "'" .$randomColors[$ij]; $ij++; echo $ij< count($nameAr)?"'," : "'"; } ?>],
     }
    ]
  },
  options: {
    legend: { display: true,position: 'right', },
    title: {
      display: false,
      text: "KYT Leave Report"
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
		//anchor: 'end',
		//align: 'top',
		/*formatter: (value, ctx) => {
			if(value == 0){
			return "";
			} else {
			return value + '%';
			}
		},*/
		font: {
		  weight: 'bold'
		}
	  }
	  }	
  }
});
<?php } ?>
<?php } ?>







</script>