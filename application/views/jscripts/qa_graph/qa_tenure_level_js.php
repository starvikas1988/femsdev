<script src="<?php echo base_url(); ?>assets/chartjs/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/chartjs-plugin-datalabels.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>

// CLIENT CAMPAIGN SELECTION
$("#select_client").change(function(){
	var client_id=$(this).val();
	updateProcessSelection(client_id);
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

//============== PARAMETER PERCENTAGE =================================//
// BAR GRAPH CHARTJS SETTINGS	
	var ctxBAR = document.getElementById("mylinebarchart");
	var myBarChart = new Chart(ctxBAR, {
			
			data: {
			  labels: ["<?php echo implode('","', $graphTenure); ?>"],
			  datasets: [
				{
				  type: 'line',
				  label: "Fatal%",
				  data: [<?php echo implode(',', $graphTenureFatal); ?>],
				  //backgroundColor: ["#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff","#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff"],
				  //borderColor: ["#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff","#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff"],
				  fill: false,
				  backgroundColor: "#3e95cd",
				  borderColor: "#FF0000",
				  borderWidth: 3
				},
				{
				  type: 'bar',
				  label: "Quality Score",
				  data: [<?php echo implode(',', $graphTenureVal); ?>],
				  backgroundColor: ["#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff","#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff"],
				  //borderColor: ["#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff","#cc3300", "#cc6600","#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff"],
				  backgroundColor: "#3e95cd",
				  //borderColor: "#3e95cd",
				  borderWidth: 1
				},
				
			  ]
			},
			
			options: {
			  legend: { display: true, position: 'right' },
			  title: {
				display: true,
				lineHeight: 7,
				text: "Agent Wise Tenure Score in <?php echo date('F Y', strtotime($start_date)); ?>"
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
				display:true,
				anchor: 'end',
				align: 'top',
				formatter: (value, ctx) => {
					if(value == '0'){
						return '';
					}
					else if(value == '00'){
						return '0';
					} else {
						return value +'%';
					}					
				},
				font: {
				  weight: 'bold'
				}
			  }
			  }	
			},
			
		});
	
	
///======================= BAR GRAPH ENDS ===================================////


</script>