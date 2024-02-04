
<!--<script src="<?php echo base_url(); ?>assets/highchartjs/highcharts.js"></script>
<script src="<?php echo base_url(); ?>assets/highchartjs/highcharts-3d.js"></script>-->

<script src="<?php echo base_url(); ?>assets/chartjs/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/chartjs-plugin-datalabels.js"></script>


<script>
$(document).ready(function() {

<?php if($this->input->get('submitgraph')){ ?>
$('#select_office').val('<?php echo $selected_office; ?>');
$('#select_client').val('<?php echo $selected_client; ?>');
<?php } ?>



///======================= BAR GRAPH ===================================////

// BAR GRAPH HIGH CHART SETTINGS	
/*	var bar_chart = {      
	   type: 'column',
	   margin: 75,
	   options3d: {
		  enabled: true,
		  alpha: 10,
		  beta: 17,
		  depth: 70,
	   }
	};
	var bar_title = {
	   text: "Global View CQ Score for <?php echo date('F Y', strtotime($start_date)); ?>"   
	};
	var bar_subtitle = {
	   text: ''  
	};
	var bar_xAxis = {
	   categories: [<?php for($h=1; $h<= $process['total']; $h++){ echo '"'.$process[$h]['info']['name'] .'",'; } ?>],
	};
	var bar_yAxis = {
	   title: {
		  text: null
	   },
	};  
    var bar_credits = {
        enabled: false
    };	
	var bar_series = [
	<?php for($i=1; $i<=4; $i++){ ?>
	{
	   showInLegend : true,
	   colorByPoint: false,
	   dataLabels : {
		  enabled: true,
		  color: '#333',
		},
	   name: 'Week <?php echo $i; ?>',
	   colors : ["<?php echo $colors[$i]; ?>"],
	   data: [<?php for($j=1; $j<=$process['total']; $j++){ echo $process[$j]['week'][$i] .","; } ?>]
	},
	<?php } ?>
	];
	

// RENDERING BAR GRAPH 
	var bar_json = {};   
	bar_json.chart = bar_chart; 
	bar_json.title = bar_title;   
	bar_json.subtitle = bar_subtitle;    
	bar_json.xAxis = bar_xAxis; 
	bar_json.yAxis = bar_yAxis; 
	bar_json.series = bar_series;
	bar_json.credits = bar_credits;
	$('#qa_bar_graph_container').highcharts(bar_json);
*/
	
	
	
	
// BAR GRAPH CHART JS SETTINGS	
	var ctxBAR = document.getElementById("mybarchart");
	var myBarChart = new Chart(ctxBAR, {
			type: 'bar',
			data: {
			  labels: [<?php for($h=1; $h<= $process['total']; $h++){ echo '"'.$process[$h]['info']['name'] .'",'; } ?>],
			  datasets: [
			  <?php for($i=1; $i<=4; $i++){ ?>
				{
				   type: 'bar',
				   label: 'Week <?php echo $i; ?>',
				   backgroundColor : "<?php echo $colors[$i]; ?>",
				   borderColor : "<?php echo $colors[$i]; ?>",
				   borderWidth: 1,
				   data: [<?php for($j=1; $j<=$process['total']; $j++){ echo $process[$j]['week'][$i] .","; } ?>]
				},
			  <?php } ?>
			  ]
			},
			
			options: {
			  legend: { display: true, position: 'bottom', },
			  title: {
				display: true,
				lineHeight: 5,
				text: "Global View CQ Score for <?php echo date('F Y', strtotime($start_date)); ?>"
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
	
	

	
///======================= BAR GRAPH ENDS ===================================////




});
</script>