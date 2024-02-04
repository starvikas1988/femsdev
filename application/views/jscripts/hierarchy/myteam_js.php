<script src="https://code.jscharting.com/latest/jscharting.js"></script>
<script>
/*=============== DEPARTMENT ROLE ================*/
//------ IMAGE HORIZONTAL TREE 
function gethorizontalform()
{
	var chart; 
	var data = <?php echo $csvdata; ?>;
	//alert(JSON.stringify(data));
	orgList = makeSeries(data); 
	chart = renderChart(orgList);
	  
	function renderChart(series) { 
	  return JSC.chart('chartDiv', { 
		type: 'organization down', 
		defaultSeries: { 
		  line: { width: 1, color: '#e0e0e0' } 
		}, 
		defaultTooltip: { 
		  asHTML: true, 
		  outline: 'none', 
		  zIndex: 10 
		}, 
		defaultPoint: { 
		  focusGlow_width: 0, 
		  tooltip: 
			'<div class="tooltipBox"><b>%fid</b><br><b>%name</b><br><b>%department</b></div>', 
		  annotation: { 
			padding: 3, 
			asHTML: true, 
			margin: 2, 
			label: { 
			  text: 
				'<img width=64 height=64 margin_bottom=4 src=%photo><br/><div class="personDescription"><b>%position</b><br/>%name<br/></div>', 
			  autoWrap: false, 
			  align: 'center'
			} 
		  }, 
		  outline_width: 0, 
		  color: '#333333'
		}, 
		series: series 
	  }); 
	} 
	  
	function makeSeries(data) { 
	  return [ 
		{ 
		  points: JSC.nest() 
			.key('name') 
			.pointRollup(function(key, val) { 
			  return { 
				name: key, 
				id: val[0].id, 
				parent: val[0].parent, 
				attributes: { 
				  position: 
					'<span style="font-size:13px;">' + 
					val[0].position + 
					'</span>', 
				  fid: val[0].number, 
				  department: val[0].department,
				  photo: val[0].ext
				} 
			  }; 
			}) 
			.points(data) 
		} 
	  ]; 
	} 
}


//------ IMAGE VERTICAL TREE 
function getverticalform()
{ 
	var chart; 
	var data = <?php echo $csvdata; ?>;
	//alert(JSON.stringify(data));
	orgList = makeSeries(data); 
	chart = renderChart(orgList);
	  
	function renderChart(series) { 
	  return JSC.chart('chartDiv', { 
		type: 'organization right', 
		defaultSeries: { 
		  line: { width: 1, color: '#e0e0e0' } 
		}, 
		defaultPoint: { 
		  focusGlow_width: 0, 
		  tooltip: 
			'<b>%fid</b><br><b>%name</b><br/><b>%position</b><br><b>%department</b>', 
		  annotation: { 
			label: { 
			  text: 
				'<b>%position</b><br/>%name<br><img margin_left=-58 margin_top=-39.5 width=50 height=50 src=%photo>', 
			  autoWrap: false, 
			  color: 'slategray', 
			  style: { 
				fontWeight: 'normal', 
				fontSize: 10 
			  }, 
			  margin_left: 50 
			}, 
			padding: [4, 14, 4, 0], 
			corners: 'round', 
			height: 52, 
			radius: 33, 
			margin: [2, 15, 2, 0] 
		  }, 
		  outline_color: '#e0e0e0', 
		  color: 'white'
		}, 
		series: series 
	  }); 
	} 
	  
	function makeSeries(data) { 
	  return [ 
		{ 
		  points: JSC.nest() 
			.key('name') 
			.pointRollup(function(key, val) { 
			  return { 
				name: key, 
				id: val[0].id, 
				parent: val[0].parent, 
				attributes: { 
				  position: val[0].position, 
				  fid: val[0].number, 
				  department: val[0].department,
				  photo: val[0].ext
				} 
			  }; 
			}) 
			.points(data) 
		} 
	  ]; 
	} 
}


<?php 
if($orgchart == 2){ echo "getverticalform();"; }
?>
</script>