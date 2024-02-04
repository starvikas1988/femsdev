<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
// CLIENT CAMPAIGN SELECTION
$("#select_client").change(function(){
	var client_id=$(this).val();
	updateProcessSelection(client_id);
	updateUserSelection(client_id);
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
			if(client_id == 'ALL'){
				$("#select_process").append('<option value="ALL">ALL</option>');
			} else {
				$("#select_process").append('<option value="">-- Select Campaign --</option>');			
			}
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


$("#select_office").change(function(){
	var client_id=$('#summaryForm #select_client').val();
	if(client_id!='ALL' && client_id!=""){
	updateProcessSelection(client_id);
	updateUserSelection(client_id);
	}
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




google.charts.load('current', {'packages':['bar']});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
	var data = google.visualization.arrayToDataTable([
	  ['', 'Feedback Raised', 'Feedback Accepted within 24 Hours',  'Feedback Accepted in 24 - 48 Hours', 'Feedback Accepted post 48 Hours'],
	  <?php 
	  $countZero = 0;
	  foreach($overview['reviewData'] as $token){
		    //if($countZero <= 5){
			if($token['total_feedback'] > 0 || !empty($selected_process)){
			//if($token['total_feedback'] <= 0){ $countZero++; }
	  ?> 
	  ["<?php echo $token['qa_name']; ?> (<?php echo $token['total_feedback']; ?>)", <?php echo $token['total_feedback']; ?>, <?php echo $token['agent_before24']; ?>, <?php echo $token['agent_before2448']; ?>, <?php echo $token['agent_after24']; ?>],
	  <?php } } ?>
	]);

	var options = {
	 legend: { position: 'top' },
	  chart: {
		//title: 'Acceptance Timeline',
	  },
	  bars: 'horizontal', // Required for Material Bar Charts.
	  isStacked: true,	  
	  bar: { groupWidth: '100%' },
	  series: {
		0:{color:'#4285f4'},
		1:{color:'#db4437'},
		2:{color:'#fde7ab'},
		3:{color:'#ace4bd'},
	  },
	  hAxis: { 
		format: '',
	  }
	};

	var chart = new google.charts.Bar(document.getElementById('mySmartViewAcceptance'));
	chart.draw(data, google.charts.Bar.convertOptions(options));
}



google.charts.load('current', {'packages':['bar']});
google.charts.setOnLoadCallback(drawChart1);
function drawChart1() {
	var data = google.visualization.arrayToDataTable([
	  ['', 'Feedback Raised', 'Feedback Accepted', 'Acceptance%'],
	  <?php 
	  $countZero = 0;
	  foreach($overview['reviewData'] as $token){
		    //if($countZero <= 5){
			if($token['agent_review'] > 0 || !empty($selected_process)){
			//if($token['total_feedback'] <= 0){ $countZero++; }
	  ?> 
	  ["<?php echo $token['qa_name']; ?>", <?php echo $token['total_feedback']; ?>, <?php echo $token['agent_review']; ?>, <?php echo $token['feedback_percent']; ?>],
	  <?php } } ?>
	]);
	var options = {
	  legend: { position: 'bottom' },
	  chart: {
		//title: 'Acceptance View',
	  },
	  bars: 'vertical', // Required for Material Bar Charts.  
	  bar: { groupWidth: '100%' },
	  vAxis: { format: '' } 
	};
	var chart = new google.charts.Bar(document.getElementById('mySmartViewAcceptanceTimeline'));
	chart.draw(data, google.charts.Bar.convertOptions(options));
}
</script>