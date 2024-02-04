
<!--<script src="<?php echo base_url(); ?>assets/highchartjs/highcharts.js"></script>
<script src="<?php echo base_url(); ?>assets/highchartjs/highcharts-3d.js"></script>-->

<script src="<?php echo base_url(); ?>assets/chartjs/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/chartjs-plugin-datalabels.js"></script>


<script>
$(document).ready(function() {
	

$('#select_client').select2();
$('#select_process').select2();

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
$('#select_process').val(['<?php echo implode("','", explode(',',$selected_process)); ?>']);
$('#select_process').select2();
<?php } ?>

<?php if(!empty($selected_client)){ ?>
$('#select_client').val(['<?php echo implode("','", explode(',',$selected_client)); ?>']);
$('#select_client').select2();
<?php } ?>

<?php if(!empty($selected_allmonth)){ ?>
$('#select_allmonth').val(['<?php echo implode("','", explode(',',$selected_allmonth)); ?>']);
<?php } ?>




<?php if($currentGraphType == 'monthly'){ ?>
$('#select_allmonth').select2();


<?php 
/*$campaignArray = array();
foreach($campaignCQ as $token){
	$campaignArray[] = strtoupper(str_replace('_', ' ', str_replace('feedback', ' ', str_replace('qa', '', trim($token['table_name'])))));
	$campaignArray[] = strtoupper(str_replace('_', ' ', str_replace('feedback', ' ', str_replace('qa', '', trim($token['table_name']))))) ."Target";
} 
$scoresArray = array();
$scoresTargetArray = array();
foreach($monthList['id'] as $tokenc){
	foreach($campaignCQ as $token){
		$scoresArray[] = $monthCQ[$token['process_id']][$tokenc]['score'];
		//$scoresArray[] = $monthCQ[$token['process_id']][$tokenc]['target'];
	}
}*/
$randomColor = array("#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff","#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff");
?>
// BAR GRAPH CHARTJS SETTINGS	
var ctxBAR = document.getElementById("mybarchart");
var myBarChart = new Chart(ctxBAR, {
		type: 'bar',
		data: {
		  labels: ["<?php echo implode('","', $monthList['names']); ?>"],
		  datasets: [
		  <?php $i=0; foreach($campaignCQ as $token){ ?>
			{
			  label: ["<?php echo strtoupper(str_replace('_', ' ', str_replace('feedback', ' ', str_replace('qa', '', trim($token['table_name']))))); ?>"],
			  data: [<?php $scoreQArray = array(); foreach($monthList['id'] as $tokenc){ $scoreQArray[] = $monthCQ[$token['process_id']][$tokenc]['score']; } echo implode(',', $scoreQArray); ?>],
			 // backgroundColor: ["#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff","#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff"],
			  //borderColor: ["#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff","#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff"],
			  backgroundColor: "<?php if($i == 9){ $i=0; } $i++; echo $randomColor[$i]; ?>",
			  //borderColor: "#3e95cd",
			  borderWidth: 1
			},
		  <?php } ?>
		  ]
		},
		
		options: {
		  legend: { display: true, position: 'right' },
		  title: {
			display: true,
			lineHeight: 7,
			text: "Quality CQ Score for Process"
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
    labels: ["<?php echo implode('","', $monthList['names']); ?>"],
    datasets: [		  
	<?php $i=0; foreach($campaignCQ as $token){ ?>
	 { 
		data: [<?php $scoreQArray = array(); foreach($monthList['id'] as $tokenc){ $scoreQArray[] = $monthCQ[$token['process_id']][$tokenc]['csat']; } echo implode(',', $scoreQArray); ?>],
        //backgroundColor: ["#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff"],
		//borderColor: ["#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff"],
		label: "<?php echo strtoupper(str_replace('_', ' ', str_replace('feedback', ' ', str_replace('qa', '', trim($token['table_name']))))); ?> CSAT",
        borderColor: "<?php if($i == 9){ $i=0; } $i++; echo $randomColor[$i]; ?>",
        fill: false,
		borderWidth: 5
     },
	 { 
		data: [<?php $scoreQArray = array(); foreach($monthList['id'] as $tokenc){ $scoreQArray[] = $monthCQ[$token['process_id']][$tokenc]['nps']; } echo implode(',', $scoreQArray); ?>],
        //backgroundColor: ["#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff"],
		//borderColor: ["#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff"],
        label: "<?php echo strtoupper(str_replace('_', ' ', str_replace('feedback', ' ', str_replace('qa', '', trim($token['table_name']))))); ?> NPS",
        borderColor: "<?php if($i == 9){ $i=0; } echo $randomColor[$i]; ?>",
		fill: false,
		borderWidth: 5
     },
	 <?php } ?>
    ]
  },
  options: {
    legend: { display: true },
    title: {
      display: true,
      text: 'Quality VOC for Process'
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






<?php } ?>




<?php if($currentGraphType == 'weekly' || $currentGraphType == 'daily'){ ?>
$('#select_start_date').datepicker();
$('#select_end_date').datepicker();

<?php
$randomColor = array("#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff","#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff");
?>

// BAR GRAPH CHARTJS SETTINGS	
var ctxBAR = document.getElementById("mybarchart");
var myBarChart = new Chart(ctxBAR, {
		type: 'bar',
		data: {
		  labels: ["<?php $weekArray = array(); foreach($weekList as $token){ $weekArray[] = $token['fullname']; } echo implode('","', $weekArray); ?>"],
		  datasets: [
		  <?php $i=0; foreach($campaignCQ as $token){ ?>
			{
			  label: ["<?php echo strtoupper(str_replace('_', ' ', str_replace('feedback', ' ', str_replace('qa', '', trim($token['table_name']))))); ?>"],
			  data: [<?php $scoreQArray = array(); foreach($weekList as $tokenc){ $scoreQArray[] = $weekCQ[$token['process_id']][$tokenc['count']]['score']; } echo implode(',', $scoreQArray); ?>],
			 // backgroundColor: ["#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff","#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff"],
			  //borderColor: ["#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff","#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff"],
			  backgroundColor: "<?php if($i == 9){ $i=0; } echo $randomColor[$i++]; ?>",
			  //borderColor: "#3e95cd",
			  borderWidth: 1
			},
		  <?php } ?>
		  ]
		},
		
		options: {
		  legend: { display: true, position: 'right' },
		  title: {
			display: true,
			lineHeight: 7,
			text: "Quality CQ Score for Process"
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
    labels: ["<?php $weekArray = array(); foreach($weekList as $token){ $weekArray[] = $token['fullname']; } echo implode('","', $weekArray); ?>"],
    datasets: [		  
	<?php $i=0; foreach($campaignCQ as $token){ ?>
	 { 
		data: [<?php $scoreQArray = array(); foreach($weekList as $tokenc){ $scoreQArray[] = $weekCQ[$token['process_id']][$tokenc['count']]['csat']; } echo implode(',', $scoreQArray); ?>],
        //backgroundColor: ["#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff"],
		//borderColor: ["#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff"],
		label: "<?php echo strtoupper(str_replace('_', ' ', str_replace('feedback', ' ', str_replace('qa', '', trim($token['table_name']))))); ?> CSAT",
        borderColor: "<?php if($i == 9){ $i=0; } $i++; echo $randomColor[$i]; ?>",
        fill: false,
		borderWidth: 5
     },
	 { 
		data: [<?php $scoreQArray = array(); foreach($weekList as $tokenc){ $scoreQArray[] = $weekCQ[$token['process_id']][$tokenc['count']]['nps']; } echo implode(',', $scoreQArray); ?>],
        //backgroundColor: ["#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff"],
		//borderColor: ["#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff"],
        label: "<?php echo strtoupper(str_replace('_', ' ', str_replace('feedback', ' ', str_replace('qa', '', trim($token['table_name']))))); ?> NPS",
        borderColor: "<?php if($i == 9){ $i=0; } echo $randomColor[$i]; ?>",
		fill: false,
		borderWidth: 5
     },
	 <?php } ?>
    ]
  },
  options: {
    legend: { display: true },
    title: {
      display: true,
      text: 'Quality VOC for Process'
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


<?php } ?>






});


</script>