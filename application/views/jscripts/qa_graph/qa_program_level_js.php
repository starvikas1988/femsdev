<script src="<?php echo base_url(); ?>assets/chartjs/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/chartjs-plugin-datalabels.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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

Chart.defaults.global.defaultFontColor = "#fff";

<?php 
  $sl=0;  
  foreach($cq['params']['count'] as $key => $val){ 
  $sl++;
  if($sl > 5){ break; }
?>

//========================================================================
<?php echo "// PARAMETER " .$sl ." DOUGHNUT"; ?> 
//========================================================================
var ctxBAR = document.getElementById("agent_2dpie_<?php echo $sl; ?>");
var myBarChart = new Chart(ctxBAR, {
	type: 'doughnut',
	data: {
	  labels: ['<?php echo $key; ?>', 'Overall'],
	  datasets: [
		{
		  data: [<?php echo $cq['params']['percent'][$key]; ?>,<?php echo 100-$cq['params']['percent'][$key]; ?>],
		  backgroundColor: ["<?php echo implode('","', $cq['params']['graph'][$sl]); ?>"],
		  borderColor: ["<?php echo implode('","', $cq['params']['graph'][$sl]); ?>"],
		  borderWidth: 1
		}
	  ]
	},
	
	options: {
	  cutoutPercentage: 70,
	  legend: { display: false, position: 'right' },
	  elements: {
		center: {
		  text: "<?php echo $cq['params']['percent'][$key]; ?>%",
		  color: '#ffffff', // Default is #000000
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



<?php 
  if(!empty($selected_client == '105')){
  $sl=0;  
  foreach($cq['params']['count'] as $key => $val){ 
  $sl++;
?>

//========================================================================
<?php echo "// PARAMETER " .$sl ." DOUGHNUT"; ?> 
//========================================================================
var ctxBAR = document.getElementById("agent_2dpieall_<?php echo $sl; ?>");
var myBarChart = new Chart(ctxBAR, {
	type: 'doughnut',
	data: {
	  labels: ['<?php echo $key; ?>', 'Overall'],
	  datasets: [
		{
		  data: [<?php echo $cq['params']['percent'][$key]; ?>,<?php echo 100-$cq['params']['percent'][$key]; ?>],
		  backgroundColor: ["#00b0f0","#cceffc"],
		  borderColor: ["#00b0f0","#cceffc"],
		  borderWidth: 1
		}
	  ]
	},
	
	options: {
	  cutoutPercentage: 70,
	  legend: { display: false, position: 'right' },
	  elements: {
		center: {
		  text: "<?php echo $cq['params']['percent'][$key]; ?>%",
		  color: '#ffffff', // Default is #000000
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
<?php } } ?>

//========================================================================
// PARAMETER 6 AUDIT
//========================================================================
var ctxBAR = document.getElementById("agent_2dpie_audit");
var myBarChart = new Chart(ctxBAR, {
	type: 'doughnut',
	data: {
	  labels: ['CQ Audit', 'Overall'],
	  datasets: [
		{
		  data: [<?php echo $cq['audit']['percent']; ?>,<?php echo 100-$cq['audit']['percent']; ?>],
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
		  data: [<?php echo $cq['fatal']['percent']; ?>,<?php echo 100-$cq['fatal']['percent']; ?>],
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
</script>