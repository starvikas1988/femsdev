<script>
</script>
<?php if($content_template == "clinic_portal/clinic_dashboard.php"){ ?>
<script src="<?php echo base_url(); ?>assets/chartjs/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/chartjs-plugin-datalabels.js"></script>
<script>
//============================= DAILY VISITORS ============================================
<?php
	$lastday = cal_days_in_month(CAL_GREGORIAN, $selected_month, $selected_year);	
?>
var ctxBAR = document.getElementById("qa_2dline_graph_container");
var myBarChart_dailyVisitor = new Chart(ctxBAR, {
	type: 'bar',
	data: {
	  labels: ["<?php for($i = 1; $i <= 12; $i++){ echo $visitors[$i]['month']; if($i < 12){ echo '","'; } } ?>"],
	  datasets: [
		{
		  label: "Visitors",
		  data: [
		  <?php for($i = 1; $i <= 12; $i++){ echo $visitors[$i]['count']; if($i < 12){ echo ','; } } ?>			
		  ],
		  //backgroundColor: ["<?php echo implode('","',$randomColors); ?>"],
		  backgroundColor: "#3f9907",
		  borderColor: "#3f9907",
		 // borderColor: ["<?php echo implode('","',$randomColors); ?>"],
		  borderWidth: 3
		}
	  ]
	},	
	options: {
	  legend: { display: false, position: 'right' },
	  title: {
		display: true,
		lineHeight: 2,
		text: "Monthly Patient Analytics - <?php echo $selected_year; ?>"
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
</script>