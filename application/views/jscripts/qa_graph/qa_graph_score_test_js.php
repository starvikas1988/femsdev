
<!--<script src="<?php echo base_url(); ?>assets/highchartjs/highcharts.js"></script>
<script src="<?php echo base_url(); ?>assets/highchartjs/highcharts-3d.js"></script>-->

<script src="<?php echo base_url(); ?>assets/chartjs/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/chartjs-plugin-datalabels.js"></script>


<script>
$(document).ready(function() {
	

$('#select_client').select2();
$('#select_process').select2();

$('#getYear,#getMonth,#getOffice').change(function(){
	getYear = $('#getYear').val();
	getMonth = $('#getMonth').val();
	getOffice = $('#getOffice').val();
	$('input[name="select_month"]').val(getMonth);
	$('input[name="select_year"]').val(getYear);
	$('input[name="select_office"]').val(getOffice);
	$('#summaryForm').submit();
	//extraParam = "?m="+getMonth+'&y='+getYear+'&o='+getOffice;
	//window.location.href = window.location.href.split("?")[0] + extraParam;
});


$("#select_client").change(function(){
	var client_id=$(this).val();
	var URL='<?php echo base_url() ."qa_graph/select_process"; ?>';
	$.ajax({
	   type: 'GET',    
	   url:URL,
	   data:'client_id='+client_id,
		success: function(data){
		  var a = JSON.parse(data);
			$("#select_process").empty();		  
			$.each(a, function(index,jsonObject){
				 $("select#select_process").append('<option value="'+jsonObject.id+'">' + jsonObject.name + '</option>');
			});	
			$('#select_process').select2();
		},
		error: function(){	
			//alert('error!');
		}
	  });
});

<?php if(!empty($selected_process)){ ?>
$('#select_process').val([<?php echo $selected_process; ?>]);
$('#select_process').select2();
<?php } ?>

<?php if(!empty($selected_client)){ ?>
$('#select_client').val([<?php echo $selected_client; ?>]);
$('#select_client').select2();
<?php } ?>
		
///======================= BAR GRAPH ===================================////

// BAR GRAPH HIGHCHART SETTINGS	
/*	var bar_chart = {      
	   type: 'column',
	   margin: 75,
	   options3d: {
		  enabled: true,
		  alpha: 1,
		  beta: 17,
		  depth: 70,
	   }
	};
	var bar_title = {
	   text: "Top 10 Account QA Score in <?php echo date('F Y', strtotime($start_date)); ?>"   
	};
	var bar_subtitle = {
	   text: ''  
	};
	var bar_xAxis = {
	   categories: ["<?php echo $qa_data_label; ?>"],
	};
	var bar_yAxis = {
	   title: {
		  text: null
	   },
	};  
    var bar_credits = {
        enabled: false
    };	
	var bar_series = [{
	   showInLegend : false,
	   colorByPoint: true,
	   dataLabels : {
		  enabled: true,
		  color: '#333',
		  //inside: true
		},
	   name: 'QA Score',
	   colors : ["#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff"],
	   data: [<?php echo $qa_data_value; ?>]
	}];
	

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
	
	
// BAR GRAPH CHARTJS SETTINGS	
	var ctxBAR = document.getElementById("mybarchart");
	var myBarChart = new Chart(ctxBAR, {
			type: 'bar',
			data: {
			  labels: ["<?php echo $qa_data_label; ?>"],
			  datasets: [
				{
				  label: "QA Score",
				  data: [<?php echo $qa_data_value; ?>],
				  backgroundColor: ["#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff","#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff"],
				  borderColor: ["#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff","#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff"],
				  //backgroundColor: "#3e95cd",
				  //borderColor: "#3e95cd",
				  borderWidth: 1
				},
				{
				  label: "Target",
				  data: [<?php echo $qa_target_value; ?>],
				  backgroundColor: "#001a4a",
				  borderColor: "#001a4a",
				  //backgroundColor: "#3e95cd",
				  //borderColor: "#3e95cd",
				  borderWidth: 1
				}
			  ]
			},
			
			options: {
			  legend: { display: true, position: 'right' },
			  title: {
				display: true,
				lineHeight: 7,
				text: "Top 10 Account QA Score in <?php echo date('F Y', strtotime($start_date)); ?>"
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
					  max:100,
					}
				  }]
				},
			  plugins: {
			  datalabels: {
				anchor: 'end',
				align: 'top',
				formatter: (value, ctx) => {
					return value+'%';
				},
				font: {
				  weight: 'bold'
				}
			  }
			  }	
			},
			
		});
	
	
///======================= BAR GRAPH ENDS ===================================////



///======================= LINE GRAPH ===================================////

var ctxLINE = document.getElementById("mylinebarchart");
var myLineChart = new Chart(ctxLINE, {
  type: 'line',
  data: {
    labels: ["<?php echo $qa_data_label; ?>"],
    datasets: [
	 { 
        data: [<?php echo $qa_csat_value; ?>],
        //backgroundColor: ["#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff"],
		//borderColor: ["#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff"],
		label: "CSAT",
        borderColor: "#0099cc",
        fill: false,
		borderWidth: 5
     },
	 /*{ 
        data: [<?php echo $qa_nps_value; ?>],
        //backgroundColor: ["#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff"],
		//borderColor: ["#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff"],
        label: "NPS",
        borderColor: "#99cc00",
		fill: false,
		borderWidth: 5
     }*/
    ]
  },
  options: {
    legend: { display: true, position:'right' },
    title: {
      display: true,
	  lineHeight: 4,
      text: 'Top 10 Account VOC in <?php echo date('F Y', strtotime($start_date)); ?>'
    },
	tooltips: {
		callbacks: {
		   label: function(tooltipItem) {
				  return tooltipItem.yLabel + '%';
				  //return tooltipItem.yLabel;
		   }
		}
	  },
	  maintainAspectRatio: false,
      responsive: true,
	  scales: {
		   xAxes: [{
            //gridLines: { color: "rgba(0, 0, 0, 0)", }
            offset: true		
		  }],
		  yAxes: [{
		   // gridLines: { color: "rgba(0, 0, 0, 0)", },
			ticks: {
			  callback: function(value, index, values) {
					return value + '%';
					//return value;
			  },
			  beginAtZero: true,
			  //max: <?php echo $max_y_limit; ?>
			  max: 100,
			}
		  }]
		},
	  plugins: {
	  datalabels: {
		anchor: 'end',
		align: 'top',
		formatter: (value, ctx) => {
			return value + '%';
			//return value;
		},
		font: {
		  weight: 'bold'
		}
	  }
	  }	
  }
});
	
///======================= LINE GRAPH ENDS ===================================////

});
</script>

<!-- Notification Banner JS -->
<!-- Edited By Samrat 11-Aug-22 -->
<script>
	//$("#banner_notify").modal("show")
</script>