<script src="<?php echo base_url(); ?>assets/chartjs/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/chartjs-plugin-datalabels.js"></script>

<script>
<?php if(!empty($survey_site)){ ?>
$('#survey_site').val("<?php echo $survey_site; ?>");
<?php } ?>

<?php if(!empty($survey_dept)){ ?>
$('#survey_dept').val("<?php echo $survey_dept; ?>");
<?php } ?>
//============================= Q1 - SURVEY GRAPH ============================================

	var ctxBAR = document.getElementById("survey_graph_1");
	var myBarChart = new Chart(ctxBAR, {
			type: 'bar',
			data: {
			  labels: [<?php echo '"' .implode('","', array_values($survey_array_1)) .'"'; ?>],
			  datasets: [
				{
				  data: [<?php echo implode(',',array_values($answers['percent']['q1'])); ?>],
				  backgroundColor: ["<?php shuffle($colorsAllArray); echo $colorSet = implode('","', $colorsAllArray); ?>"],
				  borderColor: ["<?php echo $colorSet; ?>"],
				  borderWidth: 1
				}
			  ]
			},
			
			options: {
			  legend: { position: 'right', display: false },
			  title: {
				display: false,
				lineHeight: 5,
				text: "How often do you conduct a structured one-on-one discussion with front line employees (CSS/CSRs/Advisors) on their performance scorecards?"
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
				anchor: 'end',
				align: 'top',
				formatter: (value, ctx) => {
					return value + '%';
				},
				font: {
				  weight: 'bold'
				}
			  }
			  }	
			},
			
		});
		
		
//============================= Q2 - SURVEY GRAPH ============================================

	var ctxBAR = document.getElementById("survey_graph_2");
	var myBarChart = new Chart(ctxBAR, {
			type: 'bar',
			data: {
			  labels: [<?php echo '"' .implode('","', array_values($survey_array_2)) .'"'; ?>],
			  datasets: [
				{
				  data: [<?php echo implode(',',array_values($answers['percent']['q2'])); ?>],
				  backgroundColor: ["<?php shuffle($colorsAllArray); echo $colorSet = implode('","', $colorsAllArray); ?>"],
				  borderColor: ["<?php echo $colorSet; ?>"],
				  borderWidth: 1
				}
			  ]
			},
			
			options: {
			  legend: { position: 'right', display: false },
			  title: {
				display: false,
				lineHeight: 5,
				text: "How often do you conduct a structured one-on-one discussion with front line employees (CSS/CSRs/Advisors) on their performance scorecards?"
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
				anchor: 'end',
				align: 'top',
				formatter: (value, ctx) => {
					return value + '%';
				},
				font: {
				  weight: 'bold'
				}
			  }
			  }	
			},
			
		});
		
//============================= Q3 - SURVEY GRAPH ============================================

	var ctxBAR = document.getElementById("survey_graph_3");
	var myBarChart = new Chart(ctxBAR, {
			type: 'bar',
			data: {
			  labels: [<?php echo '"' .implode('","', array_values($survey_array_3)) .'"'; ?>],
			  datasets: [
				{
				  data: [<?php echo implode(',',array_values($answers['percent']['q3'])); ?>],
				  backgroundColor: ["<?php shuffle($colorsAllArray); echo $colorSet = implode('","', $colorsAllArray); ?>"],
				  borderColor: ["<?php echo $colorSet; ?>"],
				  borderWidth: 1
				}
			  ]
			},
			
			options: {
			  legend: { position: 'right', display: false },
			  title: {
				display: false,
				lineHeight: 5,
				text: "How often do you conduct a structured one-on-one discussion with front line employees (CSS/CSRs/Advisors) on their performance scorecards?"
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
				anchor: 'end',
				align: 'top',
				formatter: (value, ctx) => {
					return value + '%';
				},
				font: {
				  weight: 'bold'
				}
			  }
			  }	
			},
			
		});
		
		
//============================= Q8 - SURVEY GRAPH ============================================

	var ctxBAR = document.getElementById("survey_graph_8");
	var myBarChart = new Chart(ctxBAR, {
			type: 'bar',
			data: {
			  labels: [<?php echo '"' .implode('","', array_values($survey_array_8)) .'"'; ?>],
			  datasets: [
				{
				  data: [<?php echo implode(',',array_values($answers['percent']['q8'])); ?>],
				  backgroundColor: ["<?php shuffle($colorsAllArray); echo $colorSet = implode('","', $colorsAllArray); ?>"],
				  borderColor: ["<?php echo $colorSet; ?>"],
				  borderWidth: 1
				}
			  ]
			},
			
			options: {
			  legend: { position: 'right', display: false },
			  title: {
				display: false,
				lineHeight: 5,
				text: "How often do you conduct a structured one-on-one discussion with front line employees (CSS/CSRs/Advisors) on their performance scorecards?"
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
				anchor: 'end',
				align: 'top',
				formatter: (value, ctx) => {
					return value + '%';
				},
				font: {
				  weight: 'bold'
				}
			  }
			  }	
			},
			
		});
		
		
		
//============================= Q4 - SURVEY GRAPH ============================================

	var ctxBAR = document.getElementById("survey_graph_4");
	var myBarChart = new Chart(ctxBAR, {
			type: 'horizontalBar',
			data: {
			  labels: [<?php echo '"' .implode('","', array_values($survey_array_4_questions)) .'"'; ?>],
			  datasets: [
			  <?php $sl=0; foreach($survey_array_4 as $search => $token){ ?>
				{
				  label: "<?php echo $token; ?>",
				  data: [<?php echo implode(',',array_values($answers['percent']['q4'][$search])); ?>],
				  backgroundColor: "<?php echo $colorsArray[$sl++]; ?>",
				  borderWidth: 1
				},
			  <?php } ?>
			  ]
			},			
			options: {
				elements: {
					rectangle: {
						borderWidth: 2,
					}
				},
				responsive: true,
				legend: {
					position: 'right',
				},
				title: {
					display: false,
					text: 'Which of the following performance parameters are included in the scorecards as qualifiers and performance parameters?'
				},
				plugins: {
					datalabels: {
						display: false,
					},
				},
				scales: {
				xAxes: [{
					ticks: {
						beginAtZero: true,
						min: 0,
						max: 100,
						stepSize: 20
					}
				}]
				}
			}			
		});
		
		
		
//============================= Q5 - SURVEY GRAPH ============================================

	var ctxBAR = document.getElementById("survey_graph_5");
	var myBarChart = new Chart(ctxBAR, {
		type: 'horizontalBar',
		data: {
		  labels: [<?php echo '"' .implode('","', array_values($survey_array_5_questions)) .'"'; ?>],
		  datasets: [
			{
			  data: [<?php echo implode(',',array_values($answers['percent']['q5'])); ?>],
			  backgroundColor: ["#cc3300", "#99cc00","#00cc99","#0099cc", "#00cccc", "#cccc33","#a633cc","#ff8000","#0080ff","#ACDC82", "#cc6600", "#DC82BB", "#64A3AC", '#E6CF6F', '#E6CF6F'],
			  borderWidth: 1
			},
		  ]
		},			
		options: {
			elements: {
				rectangle: {
					borderWidth: 2,
				}
			},
			responsive: true,
			legend: {
				position: 'right',
				display: false
			},
			title: {
				display: false,
				text: 'Which of the following performance parameters are included in the scorecards as qualifiers and performance parameters?'
			},
			plugins: {
				datalabels: {
					anchor: 'end',
					align: 'right',
					font: {
					  weight: 'bold'
					},
					display: true,
				},
			},
			scales: {
			xAxes: [{
				ticks: {
					//beginAtZero: true,
					//min: 0,
					//max: 100,
					//stepSize: 20
				}
			}]
			}
		}			
	});
	
	
	
	//============================= Q6 - SURVEY GRAPH ============================================

	var ctxBAR = document.getElementById("survey_graph_6");
	var myBarChart = new Chart(ctxBAR, {
		type: 'bar',
		data: {
		  labels: ["Eligible for Performance"],
		  datasets: [
			{
			  data: [<?php echo $answers['percent']['q6']; ?>],
			  backgroundColor: ["<?php shuffle($colorsAllArray); echo $colorSet = implode('","', $colorsAllArray); ?>"],
			  borderColor: ["<?php echo $colorSet; ?>"],
			  borderWidth: 1
			},
		  ]
		},			
		options: {
			elements: {
				rectangle: {
					borderWidth: 2,
				}
			},
			responsive: true,
			legend: {
				position: 'right',
				display: false
			},
			title: {
				display: false,
				text: 'Which of the following performance parameters are included in the scorecards as qualifiers and performance parameters?'
			},
			plugins: {
				datalabels: {
					anchor: 'end',
					align: 'top',
					font: {
					  weight: 'bold'
					},
					display: true,
				},
			},
			scales: {
			yAxes: [{
				ticks: {
					beginAtZero: true,
					min: 0,
					max: 100,
					stepSize: 10
				}
			}]
			}
		}			
	});
	
	
	//============================= Q7 - SURVEY GRAPH ============================================

	var ctxBAR = document.getElementById("survey_graph_7");
	var myBarChart = new Chart(ctxBAR, {
		type: 'bar',
		data: {
		  labels: ["Performance Improvement Plan"],
		  datasets: [
			{
			  data: [<?php echo $answers['percent']['q7']; ?>],
			  backgroundColor: ["<?php shuffle($colorsAllArray); echo $colorSet = implode('","', $colorsAllArray); ?>"],
			  borderColor: ["<?php echo $colorSet; ?>"],
			  borderWidth: 1
			},
		  ]
		},			
		options: {
			elements: {
				rectangle: {
					borderWidth: 2,
				}
			},
			responsive: true,
			legend: {
				position: 'right',
				display: false
			},
			title: {
				display: false,
				text: 'Which of the following performance parameters are included in the scorecards as qualifiers and performance parameters?'
			},
			plugins: {
				datalabels: {
					anchor: 'end',
					align: 'top',
					font: {
					  weight: 'bold'
					},
					display: true,
				},
			},
			scales: {
			yAxes: [{
				ticks: {
					beginAtZero: true,
					min: 0,
					max: 100,
					stepSize: 10
				}
			}]
			}
		}			
	});
	
	
	
	//============================= DEPARTMENT - SURVEY GRAPH ============================================

	var ctxBAR = document.getElementById("dept_graph");
	var myBarChart = new Chart(ctxBAR, {
		type: 'bar',
		data: {
			  labels: [<?php echo '"' .implode('","', array_values($survey_dept_array)) .'"'; ?>],
			  datasets: [
				{
				  data: [<?php echo implode(',',array_values($answers['percent']['dept'])); ?>],
				  backgroundColor: ["<?php shuffle($colorsAllArray); echo $colorSet = implode('","', $colorsAllArray); ?>"],
				  borderColor: ["<?php echo $colorSet; ?>"],
				  borderWidth: 1
				}
			  ]
		},			
		options: {
			elements: {
				rectangle: {
					borderWidth: 2,
				}
			},
			responsive: true,
			legend: {
				position: 'right',
				display: false
			},
			title: {
				display: false,
				text: 'Which of the following performance parameters are included in the scorecards as qualifiers and performance parameters?'
			},
			plugins: {
				datalabels: {
					anchor: 'end',
					align: 'top',
					font: {
					  weight: 'bold'
					},
					display: true,
				},
			},
			scales: {
			yAxes: [{
				ticks: {
					beginAtZero: true,
					min: 0,
					max: 100,
					stepSize: 10
				}
			}]
			}
		}			
	});
	
	
	
	
	//============================= SITE - SURVEY GRAPH ============================================

	var ctxBAR = document.getElementById("site_graph");
	var myBarChart = new Chart(ctxBAR, {
		type: 'bar',
		data: {
			  labels: [<?php echo '"' .implode('","', array_values($survey_site_array)) .'"'; ?>],
			  datasets: [
				{
				  data: [<?php echo implode(',',array_values($answers['percent']['site'])); ?>],
				  backgroundColor: ["<?php shuffle($colorsAllArray); echo $colorSet = implode('","', $colorsAllArray); ?>"],
				  borderColor: ["<?php echo $colorSet; ?>"],
				  borderWidth: 1
				}
			  ]
		},		
		options: {
			elements: {
				rectangle: {
					borderWidth: 2,
				}
			},
			responsive: true,
			legend: {
				position: 'right',
				display: false
			},
			title: {
				display: false,
				text: 'Which of the following performance parameters are included in the scorecards as qualifiers and performance parameters?'
			},
			plugins: {
				datalabels: {
					anchor: 'end',
					align: 'top',
					font: {
					  weight: 'bold'
					},
					display: true,
				},
			},
			scales: {
			yAxes: [{
				ticks: {
					beginAtZero: true,
					min: 0,
					max: 100,
					stepSize: 10
				}
			}]
			}
		}			
	});

</script>