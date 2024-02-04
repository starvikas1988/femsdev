<script src="<?php echo base_url(); ?>assets/chartjs/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/chartjs-plugin-datalabels.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
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
</script>

<?php if(!empty($graph_type) && $graph_type == "overview"){ ?>

<script type="text/javascript">

//=======================================================================================================//
//	 MAIL BOX OVERVIEW
//======================================================================================================//

//====== MAIL BOX CHART
  google.charts.load('current', {packages:["orgchart"]});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {
	var options = {
	  allowHtml: true,
	};
	
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Mail Box');
	data.addColumn('string', 'Info');
	data.addColumn('string', 'ToolTip');
	
	data.addRows([
	 [{'v':'Mail Box', 'f':'Mail Box<div style="color:#d3ffbc;">EMAT CRM</div>'},
	   '', 'Mail Box - EMAT CRM'],
	<?php foreach($category_list as $token){ ?>
	  [{'v':'<?php echo $token['email_id']; ?>', 'f':'<?php echo $token['email_name']; ?><div style="color:black; font-style:italic"><?php echo $token['email_id']; ?></div>'},
	   'Mail Box', '<?php echo $token['email_id']; ?>'],
	<?php } ?>
	]);
	
	data.setRowProperty(0, 'style', 'background-color: rgb(225 134 134);background-image:none;border: 0px solid #e3ca4b;color: #fff;');
	
	<?php $sl=0; foreach($category_list as $token){ ?>
	data.setRowProperty(<?php echo ++$sl; ?>, 'style', 'background-color: rgb(232 237 209);background-image:none;border: 0px solid rgb(227, 202, 75);color: rgb(32 102 70);font-weight: 600;padding: 6px 10px;');
	<?php } ?>
	
	var chart = new google.visualization.OrgChart(document.getElementById('g_email_box'));
	chart.draw(data, options);
  }
  
  google.charts.load("current", {packages:["corechart"]});
  google.charts.setOnLoadCallback(skillChart_all);
  function skillChart_all() {
	var data = google.visualization.arrayToDataTable([
	  ['Mail Box', 'Agents'],
	  <?php 
	  foreach($category_list as $elist){ 
		$counterSkill = !empty($skillsAllArray[$elist['id']]) ? $skillsAllArray[$elist['id']] : 0;
	  ?>
	  ['<?php echo $elist['email_name'] ." (" .$counterSkill .")"; ?>',  <?php echo $counterSkill; ?>],
	  <?php } ?>
	]);
	var options = {
	  title: 'Agents Skilled Overall',
	  is3D: true,
      pieSliceText:'label',
      sliceVisibilityThreshold :0
	};
	var chart = new google.visualization.PieChart(document.getElementById('g_skill_box_all'));
	chart.draw(data, options);
  }
  
  
	google.charts.load('current', {packages: ['corechart', 'bar']});
	google.charts.setOnLoadCallback(tikcetChart_all);
	function tikcetChart_all() {
	  var data = google.visualization.arrayToDataTable([
		['Mail Box', 'Tickets'],
		<?php 
		foreach($category_list as $elist){ 
		$counterSkill = !empty($allTickets[$elist['email_id']]) ? $allTickets[$elist['email_id']]['counter'] : 0;
		?>
		['<?php echo $elist['email_name'] ." (" .$counterSkill .")"; ?>',  <?php echo $counterSkill; ?>],
		<?php } ?>
	  ]);

	  var options = {
		title: 'Tickets Overview',
		chartArea: {width: '100%'},
		hAxis: {
		  title: 'Total Tickets',
		  minValue: 0,
		},
	  };
	  var chart = new google.visualization.ColumnChart(document.getElementById('g_ticket_box_all'));
	  chart.draw(data, options);
	}


<?php foreach($category_list as $mailBOX){ ?>

//====== MAIL BOX CATEGORY
  google.charts.load('current', {packages:["orgchart"]});
  google.charts.setOnLoadCallback(drawChart_<?php echo $mailBOX['id']; ?>);
  function drawChart_<?php echo $mailBOX['id']; ?>() {
	var options = {
	  allowHtml: true,
	};
	
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Mail Box');
	data.addColumn('string', 'Info');
	data.addColumn('string', 'ToolTip');
	
	data.addRows([
	 [{'v':'<?php echo $mailBOX['email_id']; ?>', 'f':'<?php echo $mailBOX['email_name']; ?><div style="color:#357215;"><?php echo $mailBOX['email_id']; ?></div>'},
	   '', '<?php echo $mailBOX['email_id']; ?>'],
	<?php foreach($categroyArray[$mailBOX['id']] as $elist){ ?>
	  [{'v':'<?php echo $elist['category_name']; ?>', 'f':'<?php echo $elist['category_name']; ?><div style="color:black; font-style:italic"><?php echo $elist['category_code']; ?></div>'},
	   '<?php echo $elist['email_id']; ?>', '<?php echo $elist['category_code']; ?>'],
	<?php } ?>
	]);
	
	data.setRowProperty(0, 'style', 'background-color: rgb(132 218 219);background-image:none;border: 0px solid rgb(227, 202, 75);color: rgb(33 77 5);padding: 10px 20px;font-size: 12px;font-weight: 600;');
	
	
	var chart = new google.visualization.OrgChart(document.getElementById('g_email_box_<?php echo $mailBOX['id']; ?>'));
	chart.draw(data, options);
  }
  
   
  google.charts.load("current", {packages:["corechart"]});
  google.charts.setOnLoadCallback(skillChart_<?php echo $elist['id']; ?>);
  function skillChart_<?php echo $elist['id']; ?>() {
	var data = google.visualization.arrayToDataTable([
	  ['Category', 'Agents'],
	  <?php 
	  foreach($categroyArray[$mailBOX['id']] as $elist){ 
		$counterSkill = !empty($skillsArray[$elist['id']]) ? count($skillsArray[$elist['id']]) : 0;
	  ?>
	  ['<?php echo $elist['category_name'] ." (" .$counterSkill .")"; ?>',  <?php echo $counterSkill; ?>],
	  <?php } ?>
	]);
	var options = {
	  title: 'Agents Skilled On <?php echo $mailBOX['email_name']; ?>',
	  is3D: true,
      pieSliceText:'label',
      sliceVisibilityThreshold :0
	};
	var chart = new google.visualization.PieChart(document.getElementById('g_skill_box_<?php echo $mailBOX['id']; ?>'));
	chart.draw(data, options);
  }
  
  
	google.charts.load('current', {packages: ['corechart', 'bar']});
	google.charts.setOnLoadCallback(tikcetChart_<?php echo $elist['id']; ?>);
	function tikcetChart_<?php echo $elist['id']; ?>() {
	  var data = google.visualization.arrayToDataTable([
		['Mail Box', 'Tickets'],
		<?php 
		foreach($categroyArray[$mailBOX['id']] as $elist){ 
		$counterSkill = !empty($allTicketsCat[$elist['category_code']]) ? $allTicketsCat[$elist['category_code']]['counter'] : 0;
		?>
		['<?php echo $elist['category_name'] ." (" .$counterSkill .")"; ?>',  <?php echo $counterSkill; ?>],
		<?php } ?>
	  ]);

	  var options = {
		title: 'Tickets Overview',
		chartArea: {width: '100%'},
		hAxis: {
		  title: 'Total Tickets',
		  minValue: 0,
		},
	  };
	  var chart = new google.visualization.ColumnChart(document.getElementById('g_ticket_box_<?php echo $mailBOX['id']; ?>'));
	  chart.draw(data, options);
	}
  
  
<?php } ?>  
  
  
</script>


<?php } ?>


<?php if(!empty($graph_type) && $graph_type == "overview_tickets"){ ?>

<script type="text/javascript">

//=======================================================================================================//
//	 OVERVIEW TICKETS
//======================================================================================================//

	<?php	
	$current_dataSet = $tickets_daily['start']['data'];
	$daysArrayNames = array_keys($current_dataSet);
	$daysArrayValues = array_values($current_dataSet);
	
	$current_dataSet = $assigned_daily['start']['data'];
	$daysArrayNames = array_keys($current_dataSet);
	$assignArrayValues = array_values($current_dataSet);
	
	$current_dataSet = $completed_daily['start']['data'];
	$daysArrayNames = array_keys($current_dataSet);
	$completedArrayValues = array_values($current_dataSet);
	
	?>
	var ctxBAR = document.getElementById("o_ticket_daily");
	var myBarChart_dailyVisitor = new Chart(ctxBAR, {
		
		data: {
		  labels: ["<?php echo implode('","', $daysArrayNames); ?>"],
		  datasets: [
			{
			  type: 'bar',
			  label: "Tickets Added",
			  data: [
			  <?php echo implode(',', $daysArrayValues); ?>			
			  ],
			  backgroundColor: "#3b809b",
			  borderColor: '#152c9a',
			  borderWidth: 3
			},
			/*{
			  type: 'line',
			  label: "Tickets Assigned",
			  data: [
			  <?php echo implode(',', $assignArrayValues); ?>			
			  ],
			  //backgroundColor: "#b5ffb8",
			  borderColor: '#e60606',
			  borderWidth: 3,
			  datalabels : {
				  display: false
			  }
			},*/
			{
			  type: 'line',
			  label: "Tickets Closed",
			  data: [
			  <?php echo implode(',', $completedArrayValues); ?>			
			  ],
			  //backgroundColor: "#b5ffb8",
			  borderColor: '#239a15',
			  borderWidth: 3,
			  datalabels : {
				  display: false
			  }
			}
		  ]
		},	
		options: {
		  legend: { display: true, position: 'bottom',labels: { padding: 50 } },
		  title: {
			display: true,
			lineHeight: 4,
			text: "Ticket Overview - <?php echo date('d M, Y', strtotime($start_date_full)) ." - " . date('d M, Y', strtotime($end_date_full)); ?>"
		  },
		  tooltips: {
			callbacks: {
			   label: function(tooltipItem) {
					  return tooltipItem.yLabel + '';
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
				display:true,
				//gridLines: { color: "rgba(0, 0, 0, 0)", },
				ticks: {
				  callback: function(value, index, values) {
						return value + '';
				  },
				  beginAtZero: false,
				}
			  }]
			},
		  plugins: {
		  datalabels: {
			anchor: 'end',
			align: 'top',
			formatter: (value, ctx) => {
				return value + '';
			},
			font: {
			  size:9,
			  weight: 'bold'
			}
		  }
		  }	
		},
		
	});
		
	google.charts.load("current", {packages:["corechart", "bar"]});
	google.charts.setOnLoadCallback(o_ticket_all);
	function o_ticket_all() {
		var data = google.visualization.arrayToDataTable([
			['Mail Box', 'Agents'],
			<?php 
			$counterEmails = array();
			$dataEmails = array();
			foreach($category_list as $elist){ 
				$counterSkill = !empty($ticketsEmails[$elist['email_id']]) ? count($ticketsEmails[$elist['email_id']]) : 0;
				$counterEmails[$elist['email_id']] = $counterSkill;
				$dataEmails[$elist['email_id']] = $elist;
			}
			arsort($counterEmails);
			foreach($counterEmails as $key=>$counterSkill){
				$elist = $dataEmails[$key];
			?>
			['<?php echo $elist['email_name'] ." (" .$counterSkill .")"; ?>',  <?php echo $counterSkill; ?>],
			<?php } ?>
		]);
		var options = {
			title: 'Mail Box Tickets',
			chartArea: {width: '50%'},
			hAxis: {
			  minValue: 0,
			},
			legend: {position: 'none'}
		};
		var chart = new google.visualization.BarChart(document.getElementById('o_ticket_all'));
		chart.draw(data, options);
	}
	
	
	google.charts.load("current", {packages:["corechart"]});
	google.charts.setOnLoadCallback(o_ticket_classified_all);
	function o_ticket_classified_all() {
		var data = google.visualization.arrayToDataTable([
			['Classification', 'Count'],
			['<?php echo "Tickets Open (" .count($ticketsOpen) .")"; ?>',  <?php echo count($ticketsOpen); ?>],
			//['<?php echo "Breached (" .count($ticketsBreached) .")"; ?>',  <?php echo count($ticketsBreached); ?>],
			['<?php echo "Tickets Closed (" .count($ticketsClosed) .")"; ?>',  <?php echo count($ticketsClosed); ?>],
		]);
		var options = {
			title: 'Mail Box Tickets',
			chartArea: {width: '100%', height:'100%'},
			is3D: true,
			pieSliceText:'value',
			sliceVisibilityThreshold :0,
			colors: ['#ff5252','#28eb86'],
			//slices: {  1: {offset: 0.2}, },
			//legend: { position: 'none' }
		};
		var chart = new google.visualization.PieChart(document.getElementById('o_ticket_classified_all'));
		chart.draw(data, options);
	}
	
	
	var ctxPIE  = document.getElementById("o_ticket_analytics_all_open");
	var o_ticket_analytics_all_open = new Chart(ctxPIE, {
	  type: 'pie',
	  data: {
		labels: [
		'<?php echo "Unassigned (" .count($ticketsPending) .")"; ?>', '<?php echo "Assigned (" .count($ticketsAssigned) .")"; ?>', '<?php echo "SLA Breached (" .count($ticketsBreached) .")"; ?>'
		],
		datasets: [
		 { 
			data: [
			<?php echo count($ticketsPending); ?>,<?php echo count($ticketsAssigned); ?>,<?php echo count($ticketsBreached); ?>
			],
			label: "Analytics",
			backgroundColor: ["#074676", "#f8919f", "#eb1212"],
		 }
		]
	  },
	  options: {
		legend: { display: true, position: 'right', },
		title: {
		  display: true,
		  text: "Open Tickets Overview"
		},
		tooltips: {
			callbacks: {
			label: function(tooltipItem, data) { 
				var indice = tooltipItem.index;                 
				return  data.labels[indice];
			}
			}
		 },
		  maintainAspectRatio: false,
		  responsive: true,
		  plugins: {
		  datalabels: {
			  color: '#ffffff',
			font: {
			  weight: 'bold'
			}
		  }
		  }	
	  }
	});
	
	
	var ctxPIE  = document.getElementById("o_ticket_analytics_all_closed");
	var o_ticket_analytics_all_closed = new Chart(ctxPIE, {
	  type: 'pie',
	  data: {
		labels: [
		'<?php echo "SLA Breached (" .count($ticketsBreachedClosed) .")"; ?>', '<?php echo "Within SLA (" .(count($ticketsClosed) - count($ticketsBreachedClosed)) .")"; ?>'
		],
		datasets: [
		 { 
			data: [
			<?php echo count($ticketsBreachedClosed); ?>,<?php echo count($ticketsClosed) - count($ticketsBreachedClosed); ?>
			],
			label: "Analytics",
			backgroundColor: ["#eb1212", "#3cc047", "#f5f0ca"],
		 }
		]
	  },
	  options: {
		legend: { display: true, position: 'right', },
		title: {
		  display: true,
		  text: "Closed Tickets Overview"
		},
		tooltips: {
			callbacks: {
			label: function(tooltipItem, data) { 
				var indice = tooltipItem.index;                 
				return  data.labels[indice];
			}
			}
		 },
		  maintainAspectRatio: false,
		  responsive: true,
		  plugins: {
		  datalabels: {
			  color: '#ffffff',
			font: {
			  weight: 'bold'
			}
		  }
		  }	
	  }
	});
	
	
</script>
 
<?php } ?>  
  
  
<?php if(!empty($graph_type) && $graph_type == "overview_agents"){ ?>

<script type="text/javascript">

//=======================================================================================================//
//	 OVERVIEW TICKETS
//======================================================================================================//

	<?php	
	arsort($all_agentsCount);
	$agentNames = array();
	$agentValues = array();
	$counter = 0;
	foreach($all_agentsCount as $key=>$val){
		$agentNames[] = $all_agentsList[$key]['agent_name'];
		$agentValues[] = $val;
		if($counter++ > 25){ continue; }
	}
	?>
	var ctxBAR = document.getElementById("o_ticket_daily");
	var myBarChart_dailyVisitor = new Chart(ctxBAR, {
		type: 'bar',
		data: {
		  labels: ["<?php echo implode('","', $agentNames); ?>"],
		  datasets: [
			{			  
			  label: "Agents Assigned",
			  data: [
			  <?php echo implode(',', $agentValues); ?>			
			  ],
			  backgroundColor: "#3b809b",
			  borderColor: '#152c9a',
			  borderWidth: 3
			},
		  ]
		},	
		options: {
		  legend: { display: false, position: 'bottom',labels: { padding: 50 } },
		  title: {
			display: true,
			lineHeight: 4,
			text: "Agent Overview - <?php echo date('d M, Y', strtotime($start_date_full)) ." - " . date('d M, Y', strtotime($end_date_full)); ?>"
		  },
		  tooltips: {
			callbacks: {
			   label: function(tooltipItem) {
					  return tooltipItem.yLabel + '';
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
				display:true,
				//gridLines: { color: "rgba(0, 0, 0, 0)", },
				ticks: {
				  callback: function(value, index, values) {
						return value + '';
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
				return value + '';
			},
			font: {
			  size:9,
			  weight: 'bold'
			}
		  }
		  }	
		},
		
	});
	
	
	<?php	
	arsort($all_agentsCount);
	$agentNames = array();
	$agentValues = array();
	$counter = 0;
	foreach($ticketListAHT as $token){
		$agentNames[] = $token['agent_name'] ."(" .$token['total_seconds_aht'].")";
		$agentValues[] = $token['total_seconds'];
		if($counter++ > 25){ continue; }
	}
	?>
	var ctxPIE  = document.getElementById("o_ticket_daily_all");
	var o_ticket_analytics_all_open = new Chart(ctxPIE, {
	  type: 'pie',
	  data: {
		labels: [
		"<?php echo implode('","', $agentNames); ?>"
		],
		datasets: [
		 { 
			data: [
			<?php echo implode(',', $agentValues); ?>
			],
			label: "Analytics",
			backgroundColor: ["#074676", "#f8919f", "#eb1212"],
		 }
		]
	  },
	  options: {
		legend: { display: true, position: 'right', },
		title: {
		  display: true,
		  text: "Agent AHT Overview"
		},
		tooltips: {
			callbacks: {
			label: function(tooltipItem, data) { 
				var indice = tooltipItem.index;                 
				return  data.labels[indice];
			}
			}
		 },
		  maintainAspectRatio: false,
		  responsive: true,
		  plugins: {
		  datalabels: {
			  color: '#ffffff',
			font: {
			  weight: 'bold'
			}
		  }
		  }	
	  }
	});
	
</script>

<?php } ?>