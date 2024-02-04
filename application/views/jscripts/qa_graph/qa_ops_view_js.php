
<!--<script src="<?php echo base_url(); ?>assets/highchartjs/highcharts.js"></script>
<script src="<?php echo base_url(); ?>assets/highchartjs/highcharts-3d.js"></script>--->

<script src="<?php echo base_url(); ?>assets/chartjs/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/chartjs-plugin-datalabels.js"></script>


<script>
$(document).ready(function() {

$("#select_client").change(function(){
	var client_id=$(this).val();
	populate_process_combo(client_id,'','select_process','N');
});

<?php if($this->input->get('submitgraph')){ ?>
$('#select_office').val('<?php echo $selected_office; ?>');
$('#select_client').val('<?php echo $selected_client; ?>');
$('#select_process').val('<?php echo $selected_process; ?>');
<?php } ?>

///======================= 3D PIE CHART ===================================////

// PIE CHART - SETTINGS	
/*	var pie_chart = {      
	   type: 'pie',
	   margin: 75,
	   options3d: {
		  enabled: true,
		  alpha: 45,
		  beta: 0
	   }
	};
	var pie_title = {
	   text: "Tenure & Score View for <?php echo date('F Y', strtotime($start_date)); ?>"   
	};
	var pie_tooltip = {
	   pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
	};
	var pie_plotOptions = {
	   pie: {
		  allowPointSelect: true,
		  cursor: 'pointer',
		  depth: 35,
		  
		  dataLabels: {
			 enabled: true,
			 format: '{point.name}'
		  }
	   }
	};
	var pie_credits = {
        enabled: false
    };
	var pie_legend = {
        enabled: true
    };	
	var pie_series = [{
	   type: 'pie',
	   name: 'Tenure & Score View',
	   data: [
	   ['0-30 Days',<?php echo number_format(round($tenure['0-30'],2),2); ?>],
	   ['31-60 Days',<?php echo number_format(round($tenure['31-60'],2),2); ?>],
	   ['Above 60 Days',<?php echo number_format(round($tenure['above-60'],2),2); ?>]
	   ],
	   colors : ["#cc3300", "#00cccc","#99cc00"],
	}];  
	

// RENDERING PIE GRAPH 
	var pie_json = {};   
	pie_json.chart = pie_chart; 
	pie_json.title = pie_title;   
	pie_json.tooltip = pie_tooltip;    
	pie_json.plotOptions = pie_plotOptions;
	pie_json.series = pie_series;
	pie_json.credits = pie_credits;
	pie_json.legend = pie_legend;
	$('#qa_pie_graph_container').highcharts(pie_json);
*/

///======================= 3D PIE CHART ENDS ===================================////




///======================= 2D PIE CHART ===================================////
var ctxPIE  = document.getElementById("qa_2dpie_graph_container");
var myLineChart = new Chart(ctxPIE, {
  type: 'pie',
  data: {
    labels: [
	"0-30 Days - <?php echo number_format(round($tenure['0-30'],2),2); ?>%", 
	"31-60 Days - <?php echo number_format(round($tenure['31-60'],2),2); ?>%", 
	"Above 60 Days - <?php echo number_format(round($tenure['above-60'],2),2); ?>%"
	],
    datasets: [
	 { 
        data: [
		<?php echo number_format(round($tenure['0-30'],2),2); ?>,
		<?php echo number_format(round($tenure['31-60'],2),2); ?>,
		<?php echo number_format(round($tenure['above-60'],2),2); ?>
		],
        label: "Tenure & Score View",
        backgroundColor: ["#cc3300", "#00cccc","#99cc00"],
		borderColor: ["#cc3300", "#00cccc","#99cc00"],
        fill: false,
		borderWidth: 0
     }
    ]
  },
  options: {
    legend: { display: true,position: 'right', },
    title: {
      display: true,
      text: "Tenure & Score View for <?php echo date('F Y', strtotime($start_date)); ?>"
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
///======================= 2D PIE CHART ENDS ===================================////



///======================= 2D PIE CHART TL ===================================////
var ctxPIE  = document.getElementById("qa_2dpie_graph_container_tl");
var myLineChart = new Chart(ctxPIE, {
  type: 'pie',
  data: {
    labels: ["<?php $ic=1; foreach($managers_list as $token){ $mid = $token['userid']; echo ucwords($token['fullname']) .' (' .$managers[$mid]['audit_count'] .')'; if($ic++<count($managers_list)){ echo '","'; } } ?>"],
    datasets: [
	 { 
        data: [
		<?php $ic=1; foreach($managers_list as $token){ $mid = $token['userid']; echo $managers[$mid]['audit_count']; if($ic++ < count($managers_list)){ echo ','; } } ?>
		],
        label: "<?php echo isADLocation($selected_office)==true ? 'TL Name' : 'AM Name'; ?>",
        backgroundColor: ["<?php /*shuffle($colorsAllArray);*/ echo $colorSet = implode('","', $colorsAllArray); ?>"],
		borderColor: ["<?php echo $colorSet = implode('","', $colorsAllArray); ?>"],
        fill: false,
		borderWidth: 0
     }
    ]
  },
  options: {
    legend: { display: true,position: 'right', },
    title: {
      display: true,
      text: "<?php echo isADLocation($selected_office)==true ? 'TL Score' : 'AM Score'; ?> View for <?php echo date('F Y', strtotime($start_date)); ?>"
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
///======================= 2D PIE CHART TL ENDS ===================================////



///======================= BAR LINE CHART STARTS ===================================////
var ctxBARLINE  = document.getElementById("mybarlinechart");
var myBarLineChart = new Chart(ctxBARLINE, {
    type: 'bar',
    data: {
      labels: ["<?php echo implode('","',$defect_dc_graph['labels']); ?>"],
      datasets: [
		{
          label: "Series 1",
		  type: "line",
		  fill: false,
		  data: [<?php echo implode(',',$defect_dc_graph['data']); ?>],
		  borderColor: ["#c45850"],
		  borderWidth: 5
        },
		{
          label: "Series 2",
		  type: "bar",
		  data: [<?php echo implode(',',$defect_dc_graph['data']); ?>],
          backgroundColor: "#3e95cd",
		  borderColor: "#3e95cd",
		  borderWidth: 1
        },
      ]
    },
	
    options: {
      legend: { display: false },
      title: {
        display: true,
        text: 'Program Defect View'
      },
	  tooltips: {
		callbacks: {
		   label: function(tooltipItem) {
				  //return tooltipItem.yLabel + '%';
				  return tooltipItem.yLabel;
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
					//return value + '%';
					return value;
			  },
			  beginAtZero: true,
			}
		  }]
		},
	  plugins: {
	  datalabels: {
	    display:false,
		anchor: 'end',
		align: 'top',
		formatter: (value, ctx) => {
			//return value + '%';
			return value;
		},
		font: {
		  weight: 'bold'
		}
	  }
	  }	
    },
	
});
///======================= BAR LINE CHART ENDS ===================================////

});
</script>