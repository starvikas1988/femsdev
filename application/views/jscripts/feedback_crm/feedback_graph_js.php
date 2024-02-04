
<script src="<?php echo base_url(); ?>assets/chartjs/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/chartjs-plugin-datalabels.js"></script>

<script>

$('#search_from_date').datepicker({ dateFormat:'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#search_to_date').datepicker({ dateFormat:'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });

//==================== Alpha Gas DISPOSITION ====================================================================//
var ctxPIE  = document.getElementById("qa_2dpie_graph_container");
var myLineChart = new Chart(ctxPIE, {
  type: 'pie',
  data: {
    labels: [
	<?php //echo "'".implode("','", array_column($dispoisition_records, 'c_disposition'))."'"; ?>
	<?php $ij=0; foreach($dispoisition_records as $token){ $ij++; echo  "'" .ucwords($token['c_status']) ." (".$token['counter'].")"; echo $ij< count($dispoisition_records)?"'," : "'"; } ?>
	],
    datasets: [
	 { 
        data: [
		<?php echo implode(',', array_column($dispoisition_records, 'counter')); ?>
		],
        label: "Alpha Gas Customer Records",
        backgroundColor: [<?php $ij=0; shuffle($randomColors); foreach($dispoisition_records as $token){ echo  "'" .$randomColors[$ij]; $ij++; echo $ij< count($dispoisition_records)?"'," : "'"; } ?>],
     }
    ]
  },
  options: {
    legend: { display: true,position: 'right', },
    title: {
      display: false,
      text: "Jurys Inn Customer Record Counts"
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



//========================================================================
// DAYWISE RECORDS
//========================================================================
var ctxBAR = document.getElementById("qa_2dbar_graph_container");
var myBarChart = new Chart(ctxBAR, {
	type: 'bar',
	data: {
	  labels: ["<?php for($i=1;$i<=$totalDays;$i++){ $currentDate = $currYear ."-" .$currMonth ."-" .sprintf('%02d', $i); echo date('d M', strtotime($currentDate)); if($i < $totalDays){ echo '","'; } } ?>"],
	  datasets: [
		{
		  data: [<?php $cn = 1;
						for($i=1;$i<=$totalDays;$i++){
							$currentDate = $currYear ."-" .$currMonth ."-" .sprintf('%02d', $i);
							echo $month[$currMonth]['date'][$i];
							if($i < $totalDays){ echo ","; }
						}
				?>],
		  backgroundColor: "#FFA500",
		  borderColor: "#FFA500",
		  borderWidth: 1
		}
	  ]
	},
	
	options: {
	  legend: { display: false, position: 'right' },
	  title: {
		display: true,
		lineHeight: 3,
		text: "Daily Records - <?php echo date('F', strtotime($currYear .'-'.$currMonth.'-01')) ." " . $currYear; ?>"
	  },
	  tooltips: {
		callbacks: {
		   label: function(tooltipItem) {
				  return tooltipItem.yLabel;
		   }
		}
	  },
	  maintainAspectRatio: false,
	  responsive: true,
	  scales: {
		   xAxes: [{
			gridLines: { color: "rgba(0, 0, 0, 0)", }			
		  }],
		  yAxes: [{
			gridLines: { color: "rgba(0, 0, 0, 0)", },
			ticks: {
			  callback: function(value, index, values) {
					return value;
			  },
			  beginAtZero: true,
			  //steps: 5,
			  max: <?php echo !empty($allTotal) ? $allTotal : "0"; ?>,
			  min:0
			}
		  }]
		},
	  plugins: {
	  datalabels: {
		anchor: 'end',
		align: 'top',
		formatter: (value, ctx) => {
			return value;
		},
		font: {
		  weight: 'bold',
		  size:9,
		}
	  }
	  },
	},	
});


</script>