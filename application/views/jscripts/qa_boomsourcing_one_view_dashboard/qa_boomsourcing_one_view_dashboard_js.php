<script src="<?php echo base_url(); ?>assets/chartjs/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/chartjs-plugin-datalabels.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/d3js/dc.css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/d3js/dc-floatleft.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>assets/d3js/d3.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/d3js/crossfilter.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/d3js/dc.js"></script>

<!-- Edited By Samrat 15-Jun-22 -->
<!-- One View Top Ribbon Animation -->
<script>
function animate(obj, initVal, lastVal, duration) {
    let startTime = null;
    //get the current timestamp and assign it to the currentTime variable
    let currentTime = Date.now();
    //pass the current timestamp to the step function
    const step = (currentTime) => {
        //if the start time is null, assign the current time to startTime
        if (!startTime) {
            startTime = currentTime;
        }
        //calculate the value to be used in calculating the number to be displayed
        const progress = Math.min((currentTime - startTime) / duration, 1);
        //calculate what to be displayed using the value gotten above
        obj.innerHTML = parseFloat(progress * (lastVal - initVal) + initVal).toFixed(2) + "%";
        //checking to make sure the counter does not exceed the last value (lastVal)
        if (progress < 1) {
            window.requestAnimationFrame(step);
        } else {
            window.cancelAnimationFrame(window.requestAnimationFrame(step));
        }
    };
    //start animating
    window.requestAnimationFrame(step);
}
var scores = document.querySelectorAll(".skill_score")
const load = () => {
    animate(scores[0], 0, scores[0].dataset.score, 3000);
    animate(scores[1], 0, scores[1].dataset.score, 3000);
    animate(scores[2], 0, scores[2].dataset.score, 3000);
    animate(scores[3], 0, scores[3].dataset.score, 3000)
}
load()
</script>
<!-- Edited By Samrat 13-Jun-22 -->
<script>
var ctxBAR = document.getElementById("weekly_trendChart")
<?php if(isset($weekly)){
    $weeklyData = $weekly['total_defect']['weeklyData'];
    $weekCounter = 1;
    $chartData = array(
       "labels"=>array(),
       "weeklyAuditCount"=>array(),
       "cq_score"=>array()
    );
    foreach($weeklyData as $week){
       array_push($chartData['labels'], "wk-".$week['week']."-".date("y"));
       array_push($chartData['weeklyAuditCount'], $week['weeklyAuditCount']['weeklyCount']);
       array_push($chartData['cq_score'], number_format((float)$week['cq_score'], 2));
    }
}?>
var myBarChart = new Chart(ctxBAR, {
    data: {
        labels: ["<?php echo implode('","', $chartData['labels']); ?>"],
        datasets: [{
                type: 'line',
                label: "Quality Score",
                data: [<?php echo implode(',', $chartData['cq_score']); ?>],
                fill: false,
                backgroundColor: "#3e95cd",
                borderColor: "#FF0000",
                borderWidth: 3
            },
            {
                type: 'bar',
                label: "No of Audit",
                data: [<?php echo implode(',', $chartData['weeklyAuditCount']); ?>],
                backgroundColor: "#3e95cd",
                borderWidth: 1
            }
        ]
    },
    options: {
        legend: {
            display: true,
            position: 'right'
        },
        title: {
            display: true,
            lineHeight: 2,
            text: "WEEKLY TREND",
            fontSize: 15
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
                //gridLines: { color: "rgba(0, 0, 0, 0)", }
                stacked: true
            }],
            yAxes: [{
                //gridLines: { color: "rgba(0, 0, 0, 0)", },
                ticks: {
                    callback: function(value, index, values) {
                        return value;
                    },
                    min: 0,
                    beginAtZero: true,
                }
            }]
        },
        plugins: {
            datalabels: {
                display: false,
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
</script>
<!-- Edited By Samrat 27-May-22 -->
<script>
window.onload = () => {
    document.querySelectorAll(".oneItem").forEach(single => {
        if (single.classList.contains("active")) {
            let tabName = single.dataset.openTab
            document.querySelectorAll(".tabs").forEach(tab => {
                if (tab.dataset.tabName == tabName) {
                    tab.classList.add("open")
                    tab.style.display = "block"
                } else {
                    tab.classList.remove("open")
                    tab.style.display = "none"
                }
            })
        }
        single.addEventListener("click", (event) => {
            document.querySelectorAll(".oneItem").forEach(item => {
                item.classList.remove("active")
            })
            single.classList.add("active")
            let tabName = single.dataset.openTab
            document.querySelectorAll(".tabs").forEach(tab => {
                if (tab.dataset.tabName == tabName) {
                    tab.classList.add("open")
                    tab.style.display = "block"
                } else {
                    tab.classList.remove('open')
                    tab.style.display = "none"
                }
            })
        })
    })

    //Prepare Charts
    var dateWise_ctx = document.getElementById("dateWiseScoreChart")
    var auditorWise_ctx = document.getElementById("auditorWiseScoreChart")
    var tlWise_ctx = document.getElementById("tlWiseScoreChart")
    var agentWise_ctx = document.getElementById("agentWiseScoreChart")
    <?php
	$dateWise_scores = $dateWise_audits = $dateWise_dates = array();
	foreach($date_wise as $item){
		array_push($dateWise_scores, number_format((float)$item['average_score'], 2));
		array_push($dateWise_audits, $item['audit_count']);
		array_push($dateWise_dates, $item['audit_date']);
	}
	?>
    new Chart(dateWise_ctx, {
        data: {
            labels: ["<?php echo implode('","', $dateWise_dates)?>"],
            datasets: [{
                    type: 'line',
                    label: "No of Audit",
                    data: [<?php echo implode(',', $dateWise_audits); ?>],
                    fill: false,
                    backgroundColor: "#3e95cd",
                    borderColor: "#FF0000",
                    borderWidth: 3
                },
                {
                    type: 'bar',
                    label: "Quality Score",
                    data: [<?php echo implode(',', $dateWise_scores); ?>],
                    backgroundColor: "#3e95cd",
                    borderWidth: 1
                }
            ]
        },
        options: {
            legend: {
                display: true,
                position: 'right'
            },
            title: {
                display: true,
                lineHeight: 7,
                text: "Date Wise Audit <?php echo date('F Y', strtotime($start_date)); ?>"
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
                    display: false,
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
        }
    })
    <?php
	$auditorWise_scores = $auditorWise_audits = $auditorWise_names = array();
	foreach($evaluator_wise as $item){
		array_push($auditorWise_scores, number_format((float)$item['average_score'], 2));
		array_push($auditorWise_audits, $item['audit_count']);
		array_push($auditorWise_names, $item['auditor_name']);
	}
	?>
    new Chart(auditorWise_ctx, {
        data: {
            labels: ["<?php echo implode('","', $auditorWise_names)?>"],
            datasets: [{
                    type: 'line',
                    label: "No of Audit",
                    data: [<?php echo implode(',', $auditorWise_audits); ?>],
                    fill: false,
                    backgroundColor: "#3e95cd",
                    borderColor: "#FF0000",
                    borderWidth: 3
                },
                {
                    type: 'bar',
                    label: "Quality Score",
                    data: [<?php echo implode(',', $auditorWise_scores); ?>],
                    backgroundColor: "#3e95cd",
                    borderWidth: 1
                }
            ]
        },
        options: {
            legend: {
                display: true,
                position: 'right'
            },
            title: {
                display: true,
                lineHeight: 7,
                text: "Date Wise Audit <?php echo date('F Y', strtotime($start_date)); ?>"
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
                    display: false,
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
        }
    })
    <?php
	$tlWise_scores = $tlWise_audits = $tlWise_names = array();
	foreach($tl_wise as $item){
		array_push($tlWise_scores, number_format((float)$item['average_score'], 2));
		array_push($tlWise_audits, $item['audit_count']);
		array_push($tlWise_names, $item['tl_name']);
	}
	?>
    new Chart(tlWise_ctx, {
        data: {
            labels: ["<?php echo implode('","', $tlWise_names)?>"],
            datasets: [{
                    type: 'line',
                    label: "No of Audit",
                    data: [<?php echo implode(',', $tlWise_audits); ?>],
                    fill: false,
                    backgroundColor: "#3e95cd",
                    borderColor: "#FF0000",
                    borderWidth: 3
                },
                {
                    type: 'bar',
                    label: "Quality Score",
                    data: [<?php echo implode(',', $tlWise_scores); ?>],
                    backgroundColor: "#3e95cd",
                    borderWidth: 1
                }
            ]
        },
        options: {
            legend: {
                display: true,
                position: 'right'
            },
            title: {
                display: true,
                lineHeight: 7,
                text: "Date Wise Audit <?php echo date('F Y', strtotime($start_date)); ?>"
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
                    display: false,
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
        }
    })
    <?php
	$agentWise_scores = $agentWise_audits = $agentWise_names = array();
	foreach($agentWise as $item){
		array_push($agentWise_scores, number_format((float)$item['average_score'], 2));
		array_push($agentWise_audits, $item['audit_count']);
		array_push($agentWise_names, $item['agent_name']);
	}
	?>
    new Chart(agentWise_ctx, {
        data: {
            labels: ["<?php echo implode('","', $agentWise_names)?>"],
            datasets: [{
                    type: 'line',
                    label: "No of Audit",
                    data: [<?php echo implode(',', $agentWise_audits); ?>],
                    fill: false,
                    backgroundColor: "#3e95cd",
                    borderColor: "#FF0000",
                    borderWidth: 3
                },
                {
                    type: 'bar',
                    label: "Quality Score",
                    data: [<?php echo implode(',', $agentWise_scores); ?>],
                    backgroundColor: "#3e95cd",
                    borderWidth: 1
                }
            ]
        },
        options: {
            legend: {
                display: true,
                position: 'right'
            },
            title: {
                display: true,
                lineHeight: 7,
                text: "Date Wise Audit <?php echo date('F Y', strtotime($start_date)); ?>"
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
                    display: false,
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
        }
    })
}
</script>
<script>
// CLIENT CAMPAIGN SELECTION
$("#select_client").change(function() {
    var client_id = $(this).val();
    updateProcessSelection(client_id);
});

function updateProcessSelection(client_id, type = 1) {
    var URL = '<?php echo base_url() ."Qa_boomsourcing_one_view_dashboard/select_campaign"; ?>';
    $.ajax({
        type: 'GET',
        url: URL,
        data: 'client_id=' + client_id,
        success: function(data) {
            var a = JSON.parse(data);
            $("#select_process").empty();
            $("#select_process").append('<option value="">-- Select Process --</option>');
            countercheck = 0;
            $.each(a, function(index, jsonObject) {
                countercheck++;
                //console.log(countercheck);
                $("select#select_process").append('<option value="' + jsonObject.id + '">' +
                    jsonObject
                    .name + '</option>');
            });
            if (countercheck == 0) {
                $("#select_process").empty();
                $("#select_process").append('<option value="">-- No Process Found --</option>');
            }
            //$('#select_process').select2();

            if (type == 2) {
                <?php if(!empty($selected_process)){ ?>
                $('#select_process').val('<?php echo $selected_process; ?>');
                <?php } ?>
            }
        },
        error: function() {
            //alert('error!');
        }
    });

}
<?php if(!empty($selected_client)){ ?>
updateProcessSelection('<?php echo $selected_client; ?>', 2);
<?php } ?>




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




//============== PARAMETER PERCENTAGE =================================//
// BAR GRAPH CHARTJS SETTINGS	
var ctxBAR = document.getElementById("scorechart");
var myBarChart = new Chart(ctxBAR, {
    <?php
    $chartData = array("office_names"=>array(), "total_audits"=>array(), "total_cq_score"=>array());
    foreach($location_Data['generic'] as $location){
        array_push($chartData['office_names'], $location['office_name']);
        array_push($chartData['total_audits'], $location['total_audit_count']);
        array_push($chartData['total_cq_score'], $location['cq_score']);
    }
    ?>
    data: {
        labels: ["<?php echo implode('","', $chartData['office_names']); ?>"],
        datasets: [{
                type: 'line',
                label: "No of Audit",
                data: [<?php echo implode(',', $chartData['total_audits']); ?>],
                fill: false,
                backgroundColor: "#3e95cd",
                borderColor: "#FF0000",
                borderWidth: 3
            },
            {
                type: 'bar',
                label: "Quality Score",
                data: [<?php echo implode(',', $chartData['total_cq_score']); ?>],
                backgroundColor: "#3e95cd",
                borderWidth: 1
            }
        ]
    },

    options: {
        legend: {
            display: true,
            position: 'right'
        },
        title: {
            display: true,
            lineHeight: 7,
            text: "Location Wise Audit <?php echo date('F Y', strtotime($start_date)); ?>"
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
                display: false,
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


///======================= BAR GRAPH ENDS ===================================////


///======================= D3 JS ===================================////
var chart = dc.compositeChart("#pareto_test_composed"),
    speed_pie = dc.pieChart("#pareto_pie-chart");

var sample_data = [
    <?php 
$totalpercent = 0;
foreach($cq['params']['count'] as $key=>$value){ 
$errorpercent = 0;
if(!empty($cq['audit']['error'])){
$errorpercent = ($value / $cq['audit']['error']) * 100;
}
$totalpercent = $totalpercent + $errorpercent;
?> {
        reason: "<?php echo $key; ?> (<?php echo sprintf('%.2f', $totalpercent); ?>%)",
        time: <?php echo $value; ?>
    },
    <?php } ?>
];

var ndx_ = crossfilter(sample_data),
    dim_ = ndx_.dimension(function(d) {
        return d.reason;
    }),
    allTime_ = dim_.groupAll().reduceSum(d => d.time),
    grp1_ = dim_.group().reduceSum(function(d) {
        return d.time;
    });

var speedDim_ = ndx_.dimension(d => Math.floor(d.time / 3));

speed_pie
    .width(300)
    .height(300)
    .dimension(speedDim_)
    .group(speedDim_.group());

function pareto_group(group, groupall) {
    return {
        all: function() {
            var total = groupall.value(),
                cumulate = 0;
            return group.all().slice(0)
                .sort((a, b) => d3.descending(a.value, b.value))
                .map(({
                    key,
                    value
                }) => ({
                    key,
                    value: {
                        value,
                        contribution: value / total,
                        cumulative: (cumulate += value / total)
                    }
                }))
        }
    };
}

var pg = pareto_group(grp1_, allTime_);

chart
    .margins({
        top: 10,
        left: 30,
        right: 35,
        bottom: 180
    })
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
        .margins({
            top: 10,
            left: 30,
            right: 35,
            bottom: 180
        })
        .dimension(dim_)
        .barPadding(1)
        .gap(1)
        .centerBar(true)
        .clipPadding(10)
        .group(pg, "Error Count", kv => kv.value.value),
        dc.lineChart(chart)
        .dimension(dim_)
        .colors('red')
        .group(pg, "Cumulative %", kv => Math.floor(kv.value.cumulative * 100))
        .useRightYAxis(true)
        .dashStyle([1, 1])
        .renderDataPoints({
            radius: 2,
            fillOpacity: 0.8,
            strokeOpacity: 0.0
        })
    ])
    .brushOn(false);
chart.rightYAxis().tickFormat(d => d + '%')
chart.render();
speed_pie.render();
</script>
<script>
$(document).ready(function(e) {

    $('#select_office').select2();

});
</script>