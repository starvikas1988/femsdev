<script src="<?php echo base_url(); ?>assets/chartjs/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/chartjs-plugin-datalabels.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/d3js/dc.css"/>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/d3js/dc-floatleft.css"/>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/d3js/d3.js" ></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/d3js/crossfilter.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/d3js/dc.js"></script>
<script>
// CLIENT CAMPAIGN SELECTION
$("#select_client").change(function(){
	var client_id=$(this).val();
	updateProcessSelection(client_id);
	updateUserSelection(client_id);
	updateTLSelection(client_id);
});
function updateProcessSelection(client_id, type=1){
	var URL='<?php echo base_url() ."qa_graph/select_campaign"; ?>';
	$.ajax({
	   type: 'GET',    
	   url:URL,
	   data:'client_id='+client_id,
		success: function(data){
		  var a = JSON.parse(data);
			$("#select_process").empty();
			$("#select_process").append('<option value="">-- Select Campaign --</option>');
			countercheck = 0;
			$.each(a, function(index,jsonObject){
				 countercheck++;
				 $("select#select_process").append('<option value="'+jsonObject.id+'">' + jsonObject.name + '</option>');
			});
			if(countercheck == 0){
				$("#select_process").empty();
				$("#select_process").append('<option value="">-- No Campaign Found --</option>');			
			}
			//$('#select_process').select2();
			
			if(type == 2){
			<?php if(!empty($selected_process)){ ?>
			$('#select_process').val('<?php echo $selected_process; ?>');			
		    <?php } ?>
			}
		},
		error: function(){	
			//alert('error!');
		}
	  });
	  
}
<?php if(!empty($selected_client)){ ?>
updateProcessSelection('<?php echo $selected_client; ?>', 2);	
<?php } ?>


$('#select_start_date').datepicker();
$('#select_end_date').datepicker();
$('.filterType').change(function(){
	curVal = $(this).val();
	if(curVal == 'date'){
		$('.dateInfo').show();
		$('.monthInfo').hide();
	} else {
		$('.dateInfo').hide();
		$('.monthInfo').show();
	}
});
$('select[name="select_process"]').change(function(){
	curVal = $(this).val();
	$('.productShow_99').hide();
	$('.productShow_209').hide();
	if(curVal == '99'){
		$('.productShow_99').show();
	}
	if(curVal == '209'){
		$('.productShow_209').show();
	}
});

<?php if(!empty($selected_process) && $selected_process == '99'){ ?>
	$('.productShow_99').show();
<?php } ?>
<?php if(!empty($selected_process) && $selected_process == '209'){ ?>
	$('.productShow_209').show();
<?php } ?>


$("#select_office").change(function(){
	var client_id=$('#summaryForm #select_client').val();
	if(client_id!='ALL' && client_id!=""){
	updateProcessSelection(client_id);
	updateUserSelection(client_id);
	updateTLSelection(client_id);
	}
});

$("#select_tl").change(function(){
	var client_id=$('#summaryForm #select_client').val();
	updateTLSelection(client_id);
});

function updateUserSelection(client_id, type=1){	  
	  var URL='<?php echo base_url() ."qa_graph/select_user"; ?>';
	  
	  officeID = $('#summaryForm #select_office').val();
	  tlID = '';
	    
	  $.ajax({
	   type: 'GET',    
	   url:URL,
	   data: {
		   'client_id' : client_id,
		   'office_id' : officeID,
		   'tl_id' : tlID,
		   'role' : 'tl',
	   },
		success: function(data){
		  var a = JSON.parse(data);
			$("#select_tl").empty();
			$("#select_tl").append('<option value="ALL">ALL</option>');
			countercheck = 0;
			$.each(a, function(index,jsonObject){
				 countercheck++;
				 $("select#select_tl").append('<option value="'+jsonObject.id+'">' + jsonObject.fullname + ' (' + jsonObject.fusion_id + ')</option>');
			});
			if(countercheck == 0){
				$("#select_tl").empty();
				$("#select_tl").append('<option value="ALL">-- No TL Found --</option>');			
			}
			//$('#select_process').select2();
					},
		error: function(){	
			//alert('error!');
		}
	  });
}	  

function updateTLSelection(client_id, type=1){  
	  var URL='<?php echo base_url() ."qa_graph/select_user"; ?>';
	  
	  officeID = $('#summaryForm #select_office').val();
	  tlID = $('#summaryForm #select_tl').val();
	    
	  $.ajax({
	   type: 'GET',    
	   url:URL,
	   data: {
		   'client_id' : client_id,
		   'office_id' : officeID,
		   'tl_id' : tlID,
		   'role' : 'agent',
	   },
		success: function(data){
		  var a = JSON.parse(data);
			$("#select_agent").empty();
			$("#select_agent").append('<option value="ALL">ALL</option>');
			countercheck = 0;
			$.each(a, function(index,jsonObject){
				 countercheck++;
				 $("select#select_agent").append('<option value="'+jsonObject.id+'">' + jsonObject.fullname + ' (' + jsonObject.fusion_id + ')</option>');
			});
			if(countercheck == 0){
				$("#select_agent").empty();
				$("#select_agent").append('<option value="ALL">-- No Agent Found --</option>');			
			}
			//$('#select_process').select2();
		},
		error: function(){	
			//alert('error!');
		}
	  });
	  
}



//========================================================================
// PARAMETER 6 AUDIT
//========================================================================
/*var ctxBAR = document.getElementById("agent_2dpie_audit");
var myBarChart = new Chart(ctxBAR, {
	type: 'doughnut',
	data: {
	  labels: ['CQ Audit', 'Overall'],
	  datasets: [
		{
		  data: [<?php echo $cq['audit']['percent']; ?>,100],
		  backgroundColor: ["#00b050", "#a7e9c5"],
		  borderColor: ["#00b050", "#a7e9c5"],
		  borderWidth: 1
		}
	  ]
	},
	
	options: {
	  cutoutPercentage: 70,
	  legend: { display: false, position: 'right' },
	  elements: {
		center: {
		  text: "<?php echo $cq['audit']['percent']; ?>%",
		  color: '#000000', // Default is #000000
		  fontStyle: 'Arial', // Default is Arial
		  sidePadding: 80, // Default is 20 (as a percentage)
		  minFontSize: 16, // Default is 20 (in px), set to false and text will not wrap.
		  lineHeight: 25 // Default is 25 (in px), used for when text wraps
		}
	  },
	  title: {
		display: true,
		lineHeight: 1,
		text: ""
	  },
	  maintainAspectRatio: false,
	  responsive: true,
	  plugins: { datalabels: { display:false,} }	
	},
});

//========================================================================
// PARAMETER 6 FATAL
//========================================================================
var ctxBAR = document.getElementById("agent_2dpie_fatal");
var myBarChart = new Chart(ctxBAR, {
	type: 'doughnut',
	data: {
	  labels: ['Fatal', 'Overall'],
	  datasets: [
		{
		  data: [<?php echo $cq['fatal']['percent']; ?>,100],
		  backgroundColor: ["#f81a1a", "#fcb5b5"],
		  borderColor: ["#f81a1a", "#fcb5b5"],
		  borderWidth: 1
		}
	  ]
	},
	
	options: {
	  cutoutPercentage: 70,
	  legend: { display: false, position: 'right' },
	  elements: {
		center: {
		  text: "<?php echo $cq['fatal']['percent']; ?>%",
		  color: '#000000', // Default is #000000
		  fontStyle: 'Arial', // Default is Arial
		  sidePadding: 80, // Default is 20 (as a percentage)
		  minFontSize: 16, // Default is 20 (in px), set to false and text will not wrap.
		  lineHeight: 25 // Default is 25 (in px), used for when text wraps
		}
	  },
	  title: {
		display: true,
		lineHeight: 1,
		text: ""
	  },
	  maintainAspectRatio: false,
	  responsive: true,
	  plugins: { datalabels: { display:false,} }	
	},
});
*/



/*
//============== PARAMETER PERCENTAGE =================================//
// BAR GRAPH CHARTJS SETTINGS	
	var ctxBAR = document.getElementById("mylinebarchart");
	var myBarChart = new Chart(ctxBAR, {
			
			data: {
			  labels: ["<?php echo implode('","', $defectKey); ?>"],
			  datasets: [
				{
				  type: 'bar',
				  label: "Error Count%",
				  data: [<?php echo implode(',', $defectValues); ?>],
				  //backgroundColor: ["#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff","#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff"],
				  //borderColor: ["#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff","#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff"],
				  backgroundColor: "#3e95cd",
				  //borderColor: "#3e95cd",
				  borderWidth: 1
				},
				{
				  type: 'line',
				  label: "Cummulative%",
				  data: [<?php echo implode(',', $defectCUM); ?>],
				  //backgroundColor: ["#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff","#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff"],
				  //borderColor: ["#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff","#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff"],
				  fill: false,
				  backgroundColor: "#3e95cd",
				  borderColor: "#FF0000",
				  borderWidth: 3
				},
			  ]
			},
			
			options: {
			  legend: { display: true, position: 'right' },
			  title: {
				display: true,
				lineHeight: 7,
				text: "Defect Parameter Score in <?php echo date('F Y', strtotime($start_date)); ?>"
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
				display:false,
				anchor: 'end',
				align: 'top',
				formatter: (value, ctx) => {
					return value;
				},
				font: {
				  weight: 'bold'
				}
			  }
			  }	
			},
			
		});
	
	*/
///======================= BAR GRAPH ENDS ===================================////


///======================= D3 JS ===================================////
var chart = dc.compositeChart("#pareto_test_composed"),
speed_pie = dc.pieChart("#pareto_pie-chart");

var sample_data = [
<?php 
$totalpercent = 0; $sl=0;
foreach($cq['params']['count'] as $key=>$value){ 
$errorpercent = 0;
if(!empty($value / $cq['audit']['error'])){
$errorpercent = ($value / $cq['audit']['error']) * 100;
}
$totalpercent = $totalpercent + $errorpercent;
if($value > 0){
?>
  { reason: "<?php echo ++$sl ."." .ucwords(str_replace('_',' ',$key)); ?> (<?php echo sprintf('%.2f', $totalpercent); ?>%)", time: <?php echo $value; ?> },
<?php } } ?>
];

var ndx_ = crossfilter(sample_data),
  dim_  = ndx_.dimension( function(d) {return d.reason;} ),
  allTime_ = dim_.groupAll().reduceSum(d => d.time),
  grp1_ = dim_.group().reduceSum(function(d){ return d.time;});

var speedDim_ = ndx_.dimension(d => Math.floor(d.time/3));

speed_pie
.width(300)
.height(300)
.dimension(speedDim_)
.group(speedDim_.group());

function pareto_group(group, groupall) {
  return {
	  all: function() {
		  var total = groupall.value(), cumulate = 0;
		  return group.all().slice(0)
			  .sort((a,b) => d3.descending(a.value, b.value))
			  .map(({key,value}) => ({
				  key,
				  value: {
					  value,
					  contribution: value/total,
					  cumulative: (cumulate += value/total)
				  }
			  }))
	  }
  };
}

var pg = pareto_group(grp1_, allTime_);

chart
.margins({ top: 10, left: 30, right: 35, bottom: 180 })
.x(d3.scaleBand())
.elasticX(true)
.clipPadding(2)
.xUnits(dc.units.ordinal)
.group(pg)
._rangeBandPadding(1)
.yAxisLabel("Parameters Error Count")
.legend(dc.legend().x(80).y(20).itemHeight(13).gap(5))
.renderHorizontalGridLines(true)
.ordering(kv => -kv.value.value)
.compose([
	dc.barChart(chart)
		.margins({ top: 10, left: 30, right: 35, bottom: 180 })
		.dimension(dim_)
		.barPadding(1)
		.gap(1)
		.centerBar(true)
		.clipPadding(10)		
		.group(pg, "Error Count", kv => kv.value.value),
	dc.lineChart(chart)
		.dimension(dim_)
		.colors('red')
		.group(pg, "Cumulative %", kv => Math.floor(kv.value.cumulative*100))
		.useRightYAxis(true)
		.dashStyle([1,1])
		.renderDataPoints({radius: 2, fillOpacity: 0.8, strokeOpacity: 0.0})
])
.brushOn(false);
chart.rightYAxis().tickFormat(d => d + '%')
chart.render();
speed_pie.render();


</script>