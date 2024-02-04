<script>
$('#search_from_date').datepicker({ dateFormat:'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#search_to_date').datepicker({ dateFormat:'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#search_from_date1').datepicker({ dateFormat:'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
</script>
<script src="<?php echo base_url(); ?>assets/chartjs/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/chartjs-plugin-datalabels.js"></script>
<script>
//==================== OVERVIEW DASHBOARD ====================================================================//
<?php
$course_data_label = array_column($course_data, 'course_name');
$course_data_value = array_column($course_data, 'count');
?>
var ctxPIE  = document.getElementById("qa_2dpie_graph_container");
var myLineChart = new Chart(ctxPIE, {
  type: 'pie',
  data: {
    labels: ["<?php echo implode('","', $course_data_label); ?>"],
    datasets: [
	 { 
        data: [<?php echo implode(',', $course_data_value); ?>],
        label: "KYT Courses Availability",
        backgroundColor: [<?php $ij=0; shuffle($randomColors); foreach($course_data as $token){ echo  "'" .$randomColors[$ij]; $ij++; echo $ij< count($course_data)?"'," : "'"; } ?>],
     }
    ]
  },
  options: {
    legend: { display: true,position: 'right', },
    title: {
      display: false,
      text: "KYT Courses Availability"
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
		/*formatter: (value, ctx) => {
			if(value == 0){
			return "";
			} else {
			return value + '%';
			}
		},*/
		font: {
		  weight: 'bold'
		}
	  }
	  }	
  }
});
//========================================================================
//====== Qenglish caller student registration form time calculation
//========================================================================

$('#holdCallModal').on('change', '#modal_hold_option', function(){
	$('#modal_hold_reason').html('');
	holdOption = $(this).val();
	$('#modal_hold_reason').val(holdOption);
});

function callActionButton(current){
	callType = $(current).attr('btype');
	if(callType == 'start'){ 
		startTimerNew(new Date());
		$('#formInfoJurysInn').show();
		$('#startCallModalButton').hide();
		$('#holdCallModalButton').show();
		$('#unholdCallModalButton').hide();
		$('#endCallModalButton').show();
		$(current).closest('.modal').modal('hide');
	}
	if(callType == 'hold'){
		reasonHold = $('#modal_hold_reason').val();
		reasonOption = $('#modal_hold_option').val();
		if(reasonHold != ""){
			startHoldNew(new Date());
			$('#startCallModalButton').hide();
			$('#holdCallModalButton').hide();
			$('#unholdCallModalButton').show();
			$('#endCallModalButton').hide();
			extraAdd = "";
			extraAddOption = "";
			reasonSet = $('#c_hold_reason').val();
			reasonSelect = $('#c_reasons').val();
			if(reasonSet != ""){ extraAdd = " || "; }
			if(reasonSelect != ""){ extraAddOption = " || "; }
			$('#c_hold_reason').val(reasonSet + extraAdd + reasonHold);
			$('#c_reasons').val(reasonSelect + extraAdd + reasonOption);
			holdCount = $('#c_hold').val();
			$('#c_hold').val(Number(holdCount) + 1);
			$(current).closest('.modal').modal('hide');
		} else {
			alert('Please Enter the Reason!');
		}
	}
	if(callType == 'unhold'){ 
		startHoldEnd(); 
		$('#modal_hold_reason').val('');
		$('#startCallModalButton').hide();
		$('#holdCallModalButton').show();
		$('#unholdCallModalButton').hide();
		$('#endCallModalButton').show();
		$(current).closest('.modal').modal('hide');
	}	
	if(callType == 'end'){ 
		$('#endCallSubmit').click(); 
		$(current).closest('.modal').modal('hide');
	}	
}
function startTimerNew(startDate){
	var total_seconds = (new Date() - startDate) / 1000;   
	var newTime = new Date(null);
	newTime.setSeconds(total_seconds);
	var result = newTime.toISOString().substr(11, 8);
	$("#timer_start").val(result);
	$('.inCall span').html(result);	
	timerStatus = $("#timer_start_status").val();
	if(timerStatus == 'S'){
		$('.inCall').show();
		$('.inHold, .inWait').hide();
		setTimeout(function(){startTimerNew(startDate)}, 1000);
	} else {
		$('.inCall').hide();
		setTimeout(function(){startTimerNew(startDate)}, 1000);
	}
}

function startHoldNew(startDate){
	var total_seconds = (new Date() - startDate) / 1000;   
	var newTime = new Date(null);
	newTime.setSeconds(total_seconds);
	var result = newTime.toISOString().substr(11, 8);
	$("#timer_hold").val(result);
	$('.inHold span').html(result);	
	timerHoldStatus = $("#timer_hold_status").val();
	if(timerHoldStatus == 'H'){
		$('.inHold').show();
		$('.inCall, .inWait').hide();
		$("#timer_start_status").val('H');
		timeOutVar = setTimeout(function(){startHoldNew(startDate)}, 1000);
		console.log('hi');
	} else {
		clearTimeout(timeOutVar);
		$("#timer_hold").val('');
		$("#timer_hold_status").val('H');	
		console.log('byee');
	}
}

function startHoldEnd(){
	holded = $("#timer_hold").val();
	holdedNo = $('#c_hold').val();
	$("#timeHolder").append('Hold ' + holdedNo + ' - ' + holded + '<br/>');
	pastHold = getSeconds($('#c_holdtime').val());
	currentHold = getSeconds(holded);
	var newTime = new Date(null);
	newTime.setSeconds(Number(pastHold) + Number(currentHold));
	var result = newTime.toISOString().substr(11, 8);
	$('#c_holdtime').val(result);	
	$("#timer_hold_status").val('U');
	$("#timer_start_status").val('S');
	$('.inCall').show();
	$('.inHold, .inWait').hide();
}

function getSeconds(time)
{
    var ts = time.split(':');
    return Date.UTC(1970, 0, 1, ts[0], ts[1], ts[2]) / 1000;
}

//===========================================================================
//===========================================================================

//===========================================================================


//========================================================================
// DAYWISE RECORDS
//========================================================================
var ctxBAR = document.getElementById("qa_2dbar_graph_container");
var myBarChart = new Chart(ctxBAR, {
	type: 'bar',
	data: {
	  labels: ["<?php for($i=1;$i<=$totalDays;$i++){ $currentDate = $currYear ."-" .$currMonth ."-" .sprintf('%02d', $i); echo date('d M', strtotime($currentDate)); if($i < $totalDays){ echo '","'; } } ?>"],
	  datasets: [
		{
		  data: [<?php $cn = 1;
						for($i=1;$i<=$totalDays;$i++){
							$currentDate = $currYear ."-" .$currMonth ."-" .sprintf('%02d', $i);
							echo $month[$currMonth]['date'][$i];
							if($i < $totalDays){ echo ","; }
						}
				?>],
		  backgroundColor: "#FFA500",
		  borderColor: "#FFA500",
		  borderWidth: 1
		}
	  ]
	},
	
	options: {
	  legend: { display: false, position: 'right' },
	  title: {
		display: true,
		lineHeight: 3,
		text: "Available Slots - <?php echo date('F', strtotime($currYear .'-'.$currMonth.'-01')) ." " . $currYear; ?>"
	  },
	  tooltips: {
		callbacks: {
		   label: function(tooltipItem) {
				  return tooltipItem.yLabel;
		   }
		}
	  },
	  maintainAspectRatio: false,
	  responsive: true,
	  scales: {
		   xAxes: [{
			gridLines: { color: "rgba(0, 0, 0, 0)", }			
		  }],
		  yAxes: [{
			gridLines: { color: "rgba(0, 0, 0, 0)", },
			ticks: {
			  callback: function(value, index, values) {
					return value;
			  },
			  beginAtZero: true,
			  //steps: 5,
			  max: <?php echo !empty($allTotal) ? $allTotal : "0"; ?>,
			  min:0
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
		  weight: 'bold',
		  size:9,
		}
	  }
	  },
	},	
});
/************************************************************************/

<?php
$course_data_label1 = array_column($course_data1, 'course_name');
$course_data_value1 = array_column($course_data1, 'count');
?>
var ctxPIE  = document.getElementById("qa_2dpie_graph_container1");
var myLineChart = new Chart(ctxPIE, {
  type: 'pie',
  data: {
    labels: ["<?php echo implode('","', $course_data_label1); ?>"],
    datasets: [
	 { 
        data: [<?php echo implode(',', $course_data_value1); ?>],
        label: "KYT Courses Availability",
        backgroundColor: [<?php $ij=0; shuffle($randomColors); foreach($course_data1 as $token){ echo  "'" .$randomColors[$ij]; $ij++; echo $ij< count($course_data1)?"'," : "'"; } ?>],
     }
    ]
  },
  options: {
    legend: { display: true,position: 'right', },
    title: {
      display: false,
      text: "KYT Courses Availability"
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
		/*formatter: (value, ctx) => {
			if(value == 0){
			return "";
			} else {
			return value + '%';
			}
		},*/
		font: {
		  weight: 'bold'
		}
	  }
	  }	
  }
});
</script>

