<script src="<?php echo base_url(); ?>assets/chartjs/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/chartjs-plugin-datalabels.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>

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

<?php
$current_data_set = $schedule_monthly[round($selected_month)]['counters'];
?>
//========================================================================
// PRESENT DOUGHNUT
//========================================================================
var ctxBAR = document.getElementById("agent_2dpie_present");
var myBarChart = new Chart(ctxBAR, {
	type: 'doughnut',
	data: {
	  labels: ['Present', 'Absent'],
	  datasets: [
		{
		  data: [<?php echo $current_data_set['present']; ?>, <?php echo $current_data_set['absent']; ?>],
		  backgroundColor: ["<?php echo $colorsLoginArray1[0]; ?>", "<?php echo $colorsLoginArray1[1]; ?>"],
		  borderColor: ["<?php echo $colorsLoginArray1[0]; ?>", "<?php echo $colorsLoginArray1[1]; ?>"],
		  borderWidth: 1
		}
	  ]
	},
	
	options: {
	  cutoutPercentage: 70,
	  legend: { display: false, position: 'right' },
	  elements: {
		center: {
		  text: "<?php echo sprintf('%02d', $current_data_set['present']); ?>",
		  color: '<?php echo $colorsLoginArray1[2]; ?>', // Default is #000000
		  fontStyle: 'Arial', // Default is Arial
		  sidePadding: 80, // Default is 20 (as a percentage)
		  minFontSize: 20, // Default is 20 (in px), set to false and text will not wrap.
		  lineHeight: 25 // Default is 25 (in px), used for when text wraps
		}
	  },
	  title: {
		display: true,
		lineHeight: 1,
		text: "Present"
	  },
	  maintainAspectRatio: false,
	  responsive: true,
	  animation: { animateScale: true, animateRotate: true, 
		onComplete: function(animation) {
            saveImage('schedule_agent_pie_present_<?php echo $selected_fusion; ?>.png', this.toBase64Image());
        } 
	  },
	  plugins: { datalabels: { display:false,} }	
	},
});

//========================================================================
// ABSENT DOUGHNUT
//========================================================================
var ctxBAR = document.getElementById("agent_2dpie_absent");
var myBarChart = new Chart(ctxBAR, {
	type: 'doughnut',
	data: {
	  labels: ['Present', 'Absent'],
	  datasets: [
		{
		  data: [<?php echo $current_data_set['present']; ?>, <?php echo $current_data_set['absent']; ?>],
		  backgroundColor: ["<?php echo $colorsLoginArray2[0]; ?>", "<?php echo $colorsLoginArray2[1]; ?>"],
		  borderColor: ["<?php echo $colorsLoginArray2[0]; ?>", "<?php echo $colorsLoginArray2[1]; ?>"],
		  borderWidth: 1
		}
	  ]
	},
	
	options: {
	  cutoutPercentage: 70,
	  legend: { display: false, position: 'right' },
	  elements: {
		center: {
		  text: "<?php echo sprintf('%02d', $current_data_set['absent']); ?>",
		  color: '<?php echo $colorsLoginArray2[2]; ?>', // Default is #000000
		  fontStyle: 'Arial', // Default is Arial
		  sidePadding: 80, // Default is 20 (as a percentage)
		  minFontSize: 20, // Default is 20 (in px), set to false and text will not wrap.
		  lineHeight: 25 // Default is 25 (in px), used for when text wraps
		}
	  },
	  title: {
		display: true,
		lineHeight: 1,
		text: "Absent"
	  },
	  maintainAspectRatio: false,
	  responsive: true,
	  animation: { animateScale: true, animateRotate: true, 
		onComplete: function(animation) {
            saveImage('schedule_agent_pie_absent_<?php echo $selected_fusion; ?>.png', this.toBase64Image());
        } 
	  },
	  plugins: { datalabels: { display:false,} }	
	},
});

//========================================================================
// ADHERENCE DOUGHNUT
//========================================================================
var ctxBAR = document.getElementById("agent_2dpie_adherence");
var myBarChart = new Chart(ctxBAR, {
	type: 'doughnut',
	data: {
	  labels: ['On Time', 'Overall'],
	  datasets: [
		{
		  data: [<?php echo round($current_data_set['adherence']); ?>, 100],
		  backgroundColor: ["<?php echo $colorsLoginArray3[0]; ?>", "<?php echo $colorsLoginArray3[1]; ?>"],
		  borderColor: ["<?php echo $colorsLoginArray3[0]; ?>", "<?php echo $colorsLoginArray3[1]; ?>"],
		  borderWidth: 1
		}
	  ]
	},
	
	options: {
	  cutoutPercentage: 70,
	  legend: { display: false, position: 'right' },
	  elements: {
		center: {
		  text: "<?php echo round($current_data_set['adherence']); ?>%",
		  color: '<?php echo $colorsLoginArray3[2]; ?>', // Default is #000000
		  fontStyle: 'Arial', // Default is Arial
		  sidePadding: 80, // Default is 20 (as a percentage)
		  minFontSize: 20, // Default is 20 (in px), set to false and text will not wrap.
		  lineHeight: 25 // Default is 25 (in px), used for when text wraps
		}
	  },
	  title: {
		display: true,
		lineHeight: 1,
		text: "Adherence %"
	  },
	  maintainAspectRatio: false,
	  responsive: true,
	  animation: { animateScale: true, animateRotate: true, 
		onComplete: function(animation) {
            saveImage('schedule_agent_pie_adherence_<?php echo $selected_fusion; ?>.png', this.toBase64Image());
        } 
	  },
	  plugins: { datalabels: { display:false,} }	
	},
});

//========================================================================
// SHRINKAGE DOUGHNUT
//========================================================================
var ctxBAR = document.getElementById("agent_2dpie_shrinkage");
var myBarChart = new Chart(ctxBAR, {
	type: 'doughnut',
	data: {
	  labels: ['Overall', 'Absent'],
	  datasets: [
		{
		  data: [<?php echo round($current_data_set['shrinkage']); ?>, 100],
		  backgroundColor: ["<?php echo $colorsLoginArray4[0]; ?>", "<?php echo $colorsLoginArray4[1]; ?>"],
		  borderColor: ["<?php echo $colorsLoginArray4[0]; ?>", "<?php echo $colorsLoginArray4[1]; ?>"],
		  borderWidth: 1
		}
	  ]
	},
	
	options: {
	  cutoutPercentage: 70,
	  legend: { display: false, position: 'right' },
	  elements: {
		center: {
		  text: "<?php echo round($current_data_set['shrinkage']); ?>%",
		  color: '<?php echo $colorsLoginArray4[2]; ?>', // Default is #000000
		  fontStyle: 'Arial', // Default is Arial
		  sidePadding: 80, // Default is 20 (as a percentage)
		  minFontSize: 20, // Default is 20 (in px), set to false and text will not wrap.
		  lineHeight: 25 // Default is 25 (in px), used for when text wraps
		}
	  },
	  title: {
		display: true,
		lineHeight: 1,
		text: "Shrinkage %"
	  },
	  maintainAspectRatio: false,
	  responsive: true,
	  animation: { animateScale: true, animateRotate: true, 
		onComplete: function(animation) {
            saveImage('schedule_agent_pie_shrinkage_<?php echo $selected_fusion; ?>.png', this.toBase64Image());
        } 
	  },
	  plugins: { datalabels: { display:false,} }	
	},
});



//========================================================================
// SCHEDULE ADHERENCE LOGIN
//========================================================================
google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
	var data = google.visualization.arrayToDataTable([
	  ['Task', 'Hours per Day'],
	  ["On Time, <?php echo $schedule_monthly[round($selected_month)]['counters']['ontime']; ?>, (<?php echo $schedule_monthly[round($selected_month)]['percent']['ontime']; ?>%)",     <?php echo $schedule_monthly[round($selected_month)]['percent']['ontime']; ?>],
	  ["Late, <?php echo $schedule_monthly[round($selected_month)]['counters']['latetime']; ?>, (<?php echo $schedule_monthly[round($selected_month)]['percent']['latetime']; ?>%)",      <?php echo $schedule_monthly[round($selected_month)]['percent']['latetime']; ?>],
	  ["Off, <?php echo $schedule_monthly[round($selected_month)]['counters']['offtime']; ?>, (<?php echo $schedule_monthly[round($selected_month)]['percent']['offtime']; ?>%)",  <?php echo $schedule_monthly[round($selected_month)]['percent']['offtime']; ?>],
	]);

	var options = {
	  title: "Monthly Schedule Adherence - <?php echo date('F', strtotime($selected_year .'-'.$selected_month.'-01')) ." " . $selected_year; ?>",
	  is3D: true,
	  colors: [<?php $color=0; for($i=0;$i<3;$i++){ echo  "'" .$colorsPieArray[$color]; $color++; echo $color < 3 ?"'," : "'"; } ?>],
	  chartArea: {
		backgroundColor: {
		  fill: '#FF0000',
		  fillOpacity: 0
		},
	   },
	  backgroundColor: {
		fill: '#FF0000',
		fillOpacity: 0
	   },
	   titleTextStyle: { color:'#FFFFFF' }, 
	   pieSliceTextSlice: { color: '#FFFFFF' },
	   legend: {
			textStyle: { color: '#FFFFFF' }
		}
	};

	var chart = new google.visualization.PieChart(document.getElementById('agent_3dpie_adherence'));
	chart.draw(data, options);
	saveImage('schedule_monthly_adherence_<?php echo $selected_fusion; ?>.png', chart.getImageURI());

}




//========================================================================
// MONTHLY ADHERENCE
//========================================================================
Chart.defaults.global.defaultFontColor = "#fff";
var ctxBAR = document.getElementById("agent_2dpie_monthly");
var myBarChart = new Chart(ctxBAR, {
	type: 'bar',
	data: {
	  labels: ["<?php for($i=1;$i<=12;$i++){ echo date('F', strtotime('2019-'.sprintf('%02d', $i) .'-01')); if($i < 12){ echo '","'; } } ?>"],
	  datasets: [
		{
		  data: [<?php $cn = 1;
						for($i=1; $i<=12; $i++)
						{ 	
							$current_data_set = $schedule_monthly[$i];							
							$adherence = $current_data_set['counters']['ontime']/$current_data_set['counters']['nonoff'];
							if(empty($current_data_set['counters']['ontime'])){ $adherence = 0; }
							echo sprintf('%0.2f', ($adherence * 100));
							if($i < 12){ echo ","; }
						}
				?>],
		  backgroundColor: ["<?php shuffle($colorsAllArray); echo $colorSet = implode('","', $colorsAllArray); ?>"],
		  borderColor: ["<?php echo $colorSet; ?>"],
		  borderWidth: 1
		}
	  ]
	},
	
	options: {
	  legend: { display: false, position: 'right' },
	  title: {
		display: true,
		lineHeight: 3,
		text: "MOM ADHERENCE - <?php echo date('F', strtotime($selected_year .'-'.$selected_month.'-01')) ." " . $selected_year; ?>"
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
			gridLines: { color: "rgba(0, 0, 0, 0)", }			
		  }],
		  yAxes: [{
			gridLines: { color: "rgba(0, 0, 0, 0)", },
			ticks: {
			  callback: function(value, index, values) {
					return value + '%';
			  },
			  beginAtZero: true,
			  steps: 10,
			  stepValue: 5,
			  max: 100
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
		  weight: 'bold',
		  size:9,
		}
	  }
	  },
	  animation: {
        onComplete: function(animation) {
            saveImage('schedule_mom_adherence_<?php echo $selected_fusion; ?>.png', this.toBase64Image());
        }
	  }
	},	
});


//========================================================================
// WEEKLY ADHERENCE
//========================================================================
var ctxBAR = document.getElementById("agent_2dpie_weekly");
var myBarChart = new Chart(ctxBAR, {
	type: 'line',
	data: {
	  labels: ["<?php $current_week_data = $schedule_weekly[round($selected_month)]; $cc=1; foreach($current_week_data as $tokenweek){ echo date('d-M', strtotime($tokenweek['sdate'])); if($cc<count($current_week_data)){ echo '","'; } $cc++; } ?>"],
	  datasets: [
		{
		  data: [<?php $cn = 1;
						foreach($current_week_data as $tokenweek)
						{
							$weekDataOnTime = $tokenweek['percent']['ontime'];
							if(empty($tokenweek['data'])){ $weekDataOnTime = "0"; }
							echo $weekDataOnTime;
							if($cn < count($current_week_data)){ echo ","; }
							$cn++;
						}
				?>],
		  backgroundColor: ["<?php echo $colorsLineArray[0]; ?>"],
		  borderColor: '#a99611',
		  borderWidth: 3,
		  fill: true,
		}
	  ]
	},
	
	options: {
	  legend: { display: false, position: 'right' },
	  title: {
		display: true,
		lineHeight: 4,
		text: "WOW ADHERENCE - <?php echo date('F', strtotime($selected_year .'-'.$selected_month.'-01')) ." " . $selected_year; ?>"
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
			gridLines: { color: "rgba(0, 0, 0, 0)", }			
		  }],
		  yAxes: [{
			display:true,
			gridLines: { color: "rgba(0, 0, 0, 0)", },
			ticks: {
			  callback: function(value, index, values) {
					return value + '%';
			  },
			  beginAtZero: false,
			  steps: 5,
			  stepValue: 5,
			  max: 100
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
		  weight: 'bold',
		  size:9,
		}
	  }
	  },
	  animation: {
        onComplete: function(animation) {
            saveImage('schedule_wow_adherence_<?php echo $selected_fusion; ?>.png', this.toBase64Image());
        }
	  }
	},
	
});


function hoverdiv(e,divid){
    var left  = e.clientX  + "px";
    var top  = e.clientY  + "px";

    var div = document.getElementById(divid);

    div.style.left = left;
    div.style.top = top;

    $("#"+divid).toggle();
    return false;
	
	//onmouseover="hoverdiv(event,'agent_2dpie_monthly_img')" onmouseout="hoverdiv(event,'agent_2dpie_monthly_img')" 
}

$("#agent_2dpie_weekly_img").hide();
$("#agent_2dpie_monthly_img").hide();
$("#agent_3dpie_adherence_img").hide();

/*$("#agent_2dpie_weekly").on({
    mouseenter: function () {
        $("#agent_2dpie_weekly_img").show();
    },
    mouseleave: function () {
        $("#agent_2dpie_weekly_img").hide();
    }
});

$("#agent_2dpie_monthly").on({
    mouseenter: function () {
        $("#agent_2dpie_monthly_img").show();
    },
    mouseleave: function () {
        $("#agent_2dpie_monthly_img").hide();
    }
});

$("#agent_3dpie_adherence").on({
    mouseenter: function () {
        $("#agent_3dpie_adherence_img").show();
    },
    mouseleave: function () {
        $("#agent_3dpie_adherence_img").hide();
    }
});
*/

function saveImage(fileName, dataURL){  
  $.ajax({
	  type: "POST",
	  url: "<?php echo base_url('schedule_adherence/saveImageOnServer'); ?>",
	  data: { 
		 filData: dataURL,
		 fileName: fileName
	  }
	}).done(function(success) {
	  console.log('saved');
	});
}
</script>