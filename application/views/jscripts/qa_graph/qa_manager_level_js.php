<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/chartjs-plugin-datalabels.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
$('#select_process').select2();
$('#select_campaign').select2();
$('#select_manager').select2();
$('#select_tl').select2();
$('#select_agent').select2();

// CLIENT CAMPAIGN SELECTION
$("#select_client").change(function(){
	var client_id=$(this).val();
	updateProcessSelection(client_id);
});
function updateProcessSelection(client_id, type=1){
	var URL='<?php echo base_url() ."qa_graph/select_process"; ?>';
	$.ajax({
	   type: 'GET',    
	   url:URL,
	   data:'client_id='+client_id,
		success: function(data){
		  var a = JSON.parse(data);
			$("#select_process").empty();
			$("#select_process").append('<option value="">-- Select Process --</option>');
			countercheck = 0;
			$.each(a, function(index,jsonObject){
				 countercheck++;
				 $("select#select_process").append('<option value="'+jsonObject.id+'">' + jsonObject.name + '</option>');
			});
			if(countercheck == 0){
				$("#select_process").empty();
				$("#select_process").append('<option value="">-- No Process Found --</option>');			
			}
			$("#select_process").select2();		  
			$("#select_campaign").empty();		  
			$("#select_manager").empty();		
			$("#select_tl").empty();
			$("#select_agent").empty();
			$("#select_campaign").append('<option value="">-- Select Campaign --</option>');		  
			$("#select_agent").append('<option value="ALL">-- All Agent --</option>');		  
			$("#select_tl").append('<option value="ALL">-- All TL --</option>');		  
			$("#select_manager").append('<option value="ALL">--- All Manager ---</option>');
			
		},
		error: function(){	
			//alert('error!');
		}
	  });
	  
}


//====== MANAGER FILTER ===========
$("#select_process").change(function(){
	processID = $('#select_process').val();
	officeID = $('#select_office').val();
	if(processID != "")
	{
		// FILTER CAMPAIGN
		var URL='<?php echo base_url() ."qa_graph/search_campaign_ajax"; ?>';
		$.ajax({
		   type: 'GET',    
		   url: URL,
		   data:'pid='+processID,
			success: function(data){
			  var a = JSON.parse(data);
				$("#select_campaign").empty();
				$("#select_campaign").append('<option value="">--- Select Campaign ---</option>');
				countercheck = 0;				
				$.each(a, function(index,jsonObject){
					 countercheck++;
					 $("#select_campaign").append('<option value="'+jsonObject.process_id+'">' + jsonObject.process_name + '</option>');
				});
				if(countercheck == 0){
					$("#select_campaign").empty();
					$("#select_campaign").append('<option value="">-- No Campaign Found --</option>');			
				}
				$('#select_campaign').select2();
			},
			error: function(){	
				//alert('error!');
			}
		});
		
		
		// FILTER MANAGER
		var URL='<?php echo base_url() ."qa_graph/search_manager_ajax"; ?>';
		$.ajax({
		   type: 'GET',    
		   url: URL,
		   data:'pid='+processID +'&oid='+officeID,
			success: function(data){
			  var a = JSON.parse(data);
				$("#select_manager").empty();		  
				$("#select_tl").empty();		  
				$("#select_agent").empty();		  
				$("#select_agent").append('<option value="ALL">-- All Agent --</option>');		  
				$("#select_tl").append('<option value="ALL">-- All TL --</option>');		  
				$("#select_manager").append('<option value="ALL">--- All Manager ---</option>');		  
				$.each(a, function(index,jsonObject){
					 $("#select_manager").append('<option value="'+jsonObject.id+'">' + jsonObject.fullname + ' (' + jsonObject.fusion_id + ')' + '</option>');
				});	
				$('#select_manager').select2();
			},
			error: function(){	
				//alert('error!');
			}
		});
	}
});


$("#select_manager").change(function(){
	processID = $('#select_process').val();
	officeID = $('#select_office').val();
	managerID = $('#select_manager').val();
	if(processID != "" && managerID != "")
	{
		var URL='<?php echo base_url() ."qa_graph/search_tl_ajax"; ?>';
		$.ajax({
		   type: 'GET',    
		   url: URL,
		   data:'pid='+processID +'&oid='+officeID+'&mid='+managerID,
			success: function(data){
			  var a = JSON.parse(data);
				$("#select_tl").empty();		  
				$("#select_agent").empty();		  
				$("#select_agent").append('<option value="ALL">-- All Agent --</option>');		  
				$("#select_tl").append('<option value="ALL">-- All TL --</option>');		  
				$.each(a, function(index,jsonObject){
					 $("#select_tl").append('<option value="'+jsonObject.id+'">' + jsonObject.fullname + ' (' + jsonObject.fusion_id + ')' + '</option>');
				});	
				$('#select_tl').select2();
			},
			error: function(){	
				//alert('error!');
			}
		});
	}
});


$("#select_tl").change(function(){
	processID = $('#select_process').val();
	officeID = $('#select_office').val();
	managerID = $('#select_manager').val();
	tlID = $('#select_tl').val();
	if(processID != "" && managerID != "" && tlID != "")
	{
		var URL='<?php echo base_url() ."qa_graph/search_agent_ajax"; ?>';
		$.ajax({
		   type: 'GET',    
		   url: URL,
		   data:'pid='+processID +'&oid='+officeID+'&mid='+managerID+'&tid='+tlID,
			success: function(data){
			  var a = JSON.parse(data);
				$("#select_agent").empty();		  
				$("#select_agent").append('<option value="ALL">-- All Agent --</option>');		  
				$.each(a, function(index,jsonObject){
					 $("#select_agent").append('<option value="'+jsonObject.id+'">' + jsonObject.fullname + ' (' + jsonObject.fusion_id + ')' + '</option>');
				});	
				$('#select_agent').select2();
			},
			error: function(){	
				//alert('error!');
			}
		});
	}
});



// == CENTER TEXT ELEMENT DOUGHNUT
Chart.pluginService.register({
  beforeDraw: function(chart) {
    if (chart.config.options.elements.center) {
      // Get ctx from string
      var ctx = chart.chart.ctx;

      // Get options from the center object in options
      var centerConfig = chart.config.options.elements.center;
      var fontStyle = centerConfig.fontStyle || 'Arial';
      var txt = centerConfig.text;
      var color = centerConfig.color || '#000';
      var maxFontSize = centerConfig.maxFontSize || 75;
      var sidePadding = centerConfig.sidePadding || 20;
      var sidePaddingCalculated = (sidePadding / 100) * (chart.innerRadius * 2)
      // Start with a base font of 30px
      ctx.font = "30px " + fontStyle;

      // Get the width of the string and also the width of the element minus 10 to give it 5px side padding
      var stringWidth = ctx.measureText(txt).width;
      var elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;

      // Find out how much the font can grow in width.
      var widthRatio = elementWidth / stringWidth;
      var newFontSize = Math.floor(30 * widthRatio);
      var elementHeight = (chart.innerRadius * 2);

      // Pick a new font size so it will not be larger than the height of label.
      var fontSizeToUse = Math.min(newFontSize, elementHeight, maxFontSize);
      var minFontSize = centerConfig.minFontSize;
      var lineHeight = centerConfig.lineHeight || 25;
      var wrapText = false;

      if (minFontSize === undefined) {
        minFontSize = 20;
      }

      if (minFontSize && fontSizeToUse < minFontSize) {
        fontSizeToUse = minFontSize;
        wrapText = true;
      }

      // Set font settings to draw it correctly.
      ctx.textAlign = 'center';
      ctx.textBaseline = 'middle';
      var centerX = ((chart.chartArea.left + chart.chartArea.right) / 2);
      var centerY = ((chart.chartArea.top + chart.chartArea.bottom) / 2);
      ctx.font = fontSizeToUse + "px " + fontStyle;
      ctx.fillStyle = color;

      if (!wrapText) {
        ctx.fillText(txt, centerX, centerY);
        return;
      }

      var words = txt.split(' ');
      var line = '';
      var lines = [];

      // Break words up into multiple lines if necessary
      for (var n = 0; n < words.length; n++) {
        var testLine = line + words[n] + ' ';
        var metrics = ctx.measureText(testLine);
        var testWidth = metrics.width;
        if (testWidth > elementWidth && n > 0) {
          lines.push(line);
          line = words[n] + ' ';
        } else {
          line = testLine;
        }
      }

      // Move the center up depending on line height and number of lines
      centerY -= (lines.length / 2) * lineHeight;

      for (var n = 0; n < lines.length; n++) {
        ctx.fillText(lines[n], centerX, centerY);
        centerY += lineHeight;
      }
      //Draw text in center
      ctx.fillText(line, centerX, centerY);
    }
  }
});


<?php if(empty($selected_manager)){ ?>
<?php foreach($managerAgents as $token){ ?>

//========================================================================
// TENURE 1
//========================================================================
var ctxBAR = document.getElementById("manager_score_view_<?php echo $token['id']; ?>");
var myBarChart = new Chart(ctxBAR, {
	type: 'doughnut',
	data: {
	  labels: ['Audit Count', 'Overall'],
	  datasets: [
		{
		  data: [<?php echo $managerCQScore[$token['id']]['cq']; ?>,<?php echo 100 - $managerCQScore[$token['id']]['cq']; ?>],
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
		  text: "<?php echo sprintf('%.2f', $managerCQScore[$token['id']]['cq']); ?>%",
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

<?php } ?>
<?php } ?>



<?php foreach($overview['tl_array'] as $token){ ?>

//========================================================================
// TENURE 1
//========================================================================
var ctxBAR = document.getElementById("tl_score_view_<?php echo $token['fusion_id']; ?>");
var myBarChart = new Chart(ctxBAR, {
	type: 'doughnut',
	data: {
	  labels: ['Audit Count', 'Overall'],
	  datasets: [
		{
		  data: [<?php echo $token['score']; ?>,<?php echo 100 - $token['score']; ?>],
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
		  text: "<?php echo sprintf('%.2f', $token['score']); ?>%",
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

<?php } ?>

//======================= AGENT VIEW DETAILS ================================//
$('#default-datatable-details').DataTable({
	searching: true,
	info:false,
	pageLength:50,	
});
			
$(document).on('click', '.agetnViewDetails', function(){
    pid = $(this).attr('pid');
    uid = $(this).attr('uid');
    oid = $(this).attr('oid');
    sdate = $(this).attr('sdate');
    edate = $(this).attr('edate');
	$('#logDetailsModal .modal-title').html('CQ Score Details');
	$('#logDetailsModal .modal-body').html('No Records Found');
	$('#sktPleaseWait').modal('show');
	bUrl = '<?php echo base_url(); ?>qa_graph/agent_level_details';
	$.ajax({
		type: 'GET',
		url: bUrl,
		data: 'pid=' + pid + '&uid=' + uid + '&oid=' + oid +'&sdate=' + sdate + '&edate=' + edate,
		success: function(response) {
			console.log(response);
			$('#logDetailsModal .modal-body').html(response);
			$('#logDetailsModal').modal('show');			
			$('#sktPleaseWait').modal('hide');
			$('#default-datatable-logs').DataTable({
				searching: true,
				info:false,
				pageLength:50,
				
			});
		},
	});
});


$(document).on('click', '.agetnListViewDetails', function(){
    pid = $(this).attr('pid');
    uid = $(this).attr('uid');
    oid = $(this).attr('oid');
    tid = $(this).attr('tid');
    mid = $(this).attr('mid');
    sdate = $(this).attr('sdate');
    edate = $(this).attr('edate');
	$('#tlWiseDetailsModal .modal-title').html('Agent Wise CQ Score');
	$('#tlWiseDetailsModal .modal-body').html('No Records Found');
	$('#sktPleaseWait').modal('show');
	bUrl = '<?php echo base_url(); ?>qa_graph/tl_level_wise_details';
	$.ajax({
		type: 'GET',
		url: bUrl,
		data: 'pid=' + pid + '&uid=' + uid + '&oid=' + oid+ '&tid=' + tid + '&mid=' + mid +'&sdate=' + sdate + '&edate=' + edate,
		success: function(response) {
			console.log(response);
			$('#tlWiseDetailsModal .modal-body').html(response);
			$('#tlWiseDetailsModal').modal('show');			
			$('#sktPleaseWait').modal('hide');
			$('#default-datatable-tl').DataTable({
				searching: true,
				info:false,
				pageLength:50,
				
			});
		},
	});
});

$('#search_to_date,#search_from_date').datepicker({ dateFormat: 'yy-mm-dd' });

// ========= SAMRT VIEW TL WISE GRAPH ====================//
var ctxBARtL = document.getElementById("mySmartTLScores");
var myBarCharttL = new Chart(ctxBARtL, {
	type: 'bar',
	data: {
	  labels: [<?php 
	  $sl=0; 
	  foreach($overview['tl_array'] as $token){ 
		echo '"' .$token['fullname'];
		$sl++; if($sl < count($overview['tl_array'])){ echo '",'; } else { echo '"'; }
	  } 
	  ?>],
	  datasets: [
		{
		  label: "Total Audit",
		  data: [<?php $scoreArray = array_column($overview['tl_array'], 'auditCount'); echo implode(',', $scoreArray); ?>],
		  backgroundColor: "#3e95cd",
		  borderColor: "#3e95cd",
		  borderWidth: 1
		},
		/*{
		  label: "Auto Fail",
		  data: [<?php 
	  $sl=0; 
	  foreach($overview['tl_array'] as $token){ 
		echo !empty($tlOverview['autofail'][$token['fusion_id']]['total_count']) ? $tlOverview['autofail'][$token['fusion_id']]['total_count'] : 0;
		$sl++; if($sl < count($overview['tl_array'])){ echo ','; } else { echo ''; }
	  } 
	  ?>],
		  backgroundColor: "#d40000",
		  borderColor: "#d40000",
		  borderWidth: 1
		},*/
		{
		  label: "Auto Fail",
		  data: [<?php 
	  $sl=0; 
	  foreach($overview['tl_array'] as $token){ 
		echo !empty($tlOverview['fatal'][$token['fusion_id']]['total_count']) ? $tlOverview['fatal'][$token['fusion_id']]['total_count'] : 0;
		$sl++; if($sl < count($overview['tl_array'])){ echo ','; } else { echo ''; }
	  } 
	  ?>],
		  backgroundColor: "#d40000",
		  borderColor: "#d40000",
		  borderWidth: 1
		},
		/*{
		  label: "Score",
		  data: [<?php 
	  $sl=0; 
	  foreach($overview['tl_array'] as $token){ 
		echo sprintf('%.2f', $token['score']);
		$sl++; if($sl < count($overview['tl_array'])){ echo ','; } else { echo ''; }
	  } 
	  ?>],
		  backgroundColor: "#c4eb71",
		  borderColor: "#c4eb71",
		  borderWidth: 1
		},*/
	  ]
	},
	
	options: {
	  legend: { display: true, position: 'right' },
	  title: {
		display: true,
		lineHeight: 5,
		text: "TL Smart View"
	  },
	  tooltips: {
		callbacks: {
		   label: function(tooltipItem) {
				  return tooltipItem.yLabel;
		   }
		}
	  },
	  //maintainAspectRatio: false,
	  responsive: true,
	  scales: {
		   xAxes: [{
			//gridLines: { color: "rgba(0, 0, 0, 0)", }			
		  }],
		  yAxes: [{
			//gridLines: { color: "rgba(0, 0, 0, 0)", },
			ticks: {
			  callback: function(value, index, values) {
					return value;
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
			return value;
		},
		font: {
		  weight: 'bold'
		}
	  }
	  }	
	},
});




<?php if(empty($selected_manager)){ ?>
// ========= SAMRT VIEW AM WISE GRAPH ====================//
var ctxBARtL = document.getElementById("mySmartAMScores");
var myBarCharttL = new Chart(ctxBARtL, {
	type: 'bar',
	data: {
	  labels: [<?php 
	  $sl=0; 
	  foreach($managerAgents as $token){ 
		echo '"' .$token['data']['fullname'];
		$sl++; if($sl < count($managerAgents)){ echo '",'; } else { echo '"'; }
	  } 
	  ?>],
	  datasets: [
		{
		  label: "Total Audit",
		  data: [<?php 
	  $sl=0; 
	  foreach($managerAgents as $token){ 
		echo $managerCQScore[$token['id']]['audit'];
		$sl++; if($sl < count($managerAgents)){ echo ','; } else { echo ''; }
	  } 
	  ?>],
		  backgroundColor: "#3e95cd",
		  borderColor: "#3e95cd",
		  borderWidth: 1
		},
		/*{
		  label: "Auto Fail",
		  data: [<?php 
	  $sl=0; 
	  foreach($managerAgents as $token){ 
		echo $managerCQScore[$token['id']]['autofail'];
		$sl++; if($sl < count($managerAgents)){ echo ','; } else { echo ''; }
	  } 
	  ?>],
		  backgroundColor: "#d40000",
		  borderColor: "#d40000",
		  borderWidth: 1
		},*/
		{
		  label: "Auto Fail",
		  data: [<?php 
	  $sl=0; 
	  foreach($overview['tl_array'] as $token){ 
		echo $managerCQScore[$token['id']]['fail'];
		$sl++; if($sl < count($overview['tl_array'])){ echo ','; } else { echo ''; }
	  } 
	  ?>],
		  backgroundColor: "#d40000",
		  borderColor: "#d40000",
		  borderWidth: 1
		},
		/*{
		  label: "Score",
		  data: [<?php 
	  $sl=0; 
	  foreach($managerAgents as $token){ 
		echo $managerCQScore[$token['id']]['cq'];
		$sl++; if($sl < count($managerAgents)){ echo ','; } else { echo ''; }
	  } 
	  ?>],
		  backgroundColor: "#c4eb71",
		  borderColor: "#c4eb71",
		  borderWidth: 1
		},*/
	  ]
	},
	
	options: {
	  legend: { display: true, position: 'right' },
	  title: {
		display: true,
		lineHeight: 5,
		text: "AM Smart View"
	  },
	  tooltips: {
		callbacks: {
		   label: function(tooltipItem) {
				  return tooltipItem.yLabel;
		   }
		}
	  },
	  //maintainAspectRatio: false,
	  responsive: true,
	  scales: {
		   xAxes: [{
			//gridLines: { color: "rgba(0, 0, 0, 0)", }			
		  }],
		  yAxes: [{
			//gridLines: { color: "rgba(0, 0, 0, 0)", },
			ticks: {
			  callback: function(value, index, values) {
					return value;
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
			return value;
		},
		font: {
		  weight: 'bold'
		}
	  }
	  }	
	},
});

<?php } ?>






// ========= SAMR VIEW GRAPH ====================//
<?php if($showtype == 'month'){ ?>
var ctxBAR = document.getElementById("mySmartViewAgent");
var myBarChart = new Chart(ctxBAR, {
	type: 'bar',
	data: {
	  labels: [<?php 
	  $sl=0; 
	  foreach($monthArray as $token){ 
		echo '"' .$token['month'] .' ' .$token['year'];
		$sl++; if($sl < count($monthArray)){ echo '",'; } else { echo '"'; }
	  } 
	  ?>],
	  datasets: [
		{
		  label: "CQ Score(%)",
		  data: [<?php $scoreArray = array_column($monthArray, 'score'); echo implode(',', $scoreArray); ?>],
		  backgroundColor: "#3e95cd",
		  borderColor: "#3e95cd",
		  borderWidth: 1
		}
	  ]
	},
	
	options: {
	  legend: { display: true, position: 'right' },
	  title: {
		display: true,
		lineHeight: 5,
		text: "Monthly CQ Score - Smart View"
	  },
	  tooltips: {
		callbacks: {
		   label: function(tooltipItem) {
				  return tooltipItem.yLabel;
		   }
		}
	  },
	  //maintainAspectRatio: false,
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
			return value +'%';
		},
		font: {
		  weight: 'bold'
		}
	  }
	  }	
	},
});
<?php } else { ?>
var ctxBAR = document.getElementById("mySmartViewAgent");
var myBarChart = new Chart(ctxBAR, {
	type: 'bar',
	data: {
	  labels: [<?php 
	  $sl=0; 
	  foreach($weekArray as $token){ 
		echo '"' .$token['week']; 
		//." (" .date('d M, Y', strtotime($token['start_date']));
		//." - " .date('d M, Y', strtotime($token['end_date'])) 
		echo "";  $sl++; 
		if($sl < count($weekArray)){ echo '",'; } else { echo '"'; }
	  } 
	  ?>],
	  datasets: [
		{
		  label: "CQ Score(%)",
		  data: [<?php $scoreArray = array_column($weekArray, 'score'); echo implode(',', $scoreArray); ?>],
		  backgroundColor: "#3e95cd",
		  borderColor: "#3e95cd",
		  borderWidth: 1
		},
	  ]
	},
	
	options: {
	  legend: { display: true, position: 'right' },
	  title: {
		display: true,
		lineHeight: 5,
		text: "Weekly CQ Score - Smart View"
	  },
	  tooltips: {
		callbacks: {
		   label: function(tooltipItem) {
				  return tooltipItem.yLabel;
		   }
		}
	  },
	  //maintainAspectRatio: false,
	  responsive: true,
	  scales: {
		   xAxes: [{
			//gridLines: { color: "rgba(0, 0, 0, 0)", }			
		  }],
		  yAxes: [{
			//gridLines: { color: "rgba(0, 0, 0, 0)", },
			ticks: {
			  callback: function(value, index, values) {
					return value +'%';
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
			return value +'%';
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