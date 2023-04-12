<script src="<?php echo base_url('libs/bower/highcharts/highcharts.js');?>"></script>
<script type="text/javascript">
	
	$(document).ready(function(e){
	$('#select_office').select2();
	// $('#select_process').select2();
	$('#lob_id').select2();
	$('#l1_super').select2();
	$('#select_qa').select2();
	$('#from_date').datepicker({
      dateFormat: 'yy-mm-dd'
	});
	$('#to_date').datepicker({
      dateFormat: 'yy-mm-dd'
	});

	

	Highcharts.chart('acceptance-analytics-chart-1', {
	    title: {
	        text: '',
	        align:'right'
	    },
	    xAxis: {
	        categories: ['Feedback Raised', 'Accepted within 24 hour', 'Accepted post 24 hour', 'Feedback Not Accepted', 'Feedback Rebuttal Raised'],
	        title: {
	            text: null
	        }
	    },
	    yAxis: {
	        title: {
	            useHTML: true,
	            text: 'Feedback Count'
	        }
	    },
	    tooltip: {
	        shared: true,
	        useHTML: true
	    },
	    plotOptions: {
	        bar: {
	            dataLabels: {
	                enabled: true
	            }
	        },
	        series: {
	            dataLabels: {
	                enabled: true
	            }
	        },
	    },
	    
	    credits: {
	        enabled: false
	    },
	    series: [{
	        // name: '',
	        type: 'column',
	        name: '',
	        colorByPoint: true,
	        data: <?php echo json_encode($acceptance_analytics_graph_overall_value);?>,
	        showInLegend: false,
	    }]
	});

	Highcharts.chart('acceptance-analytics-chart-2', {
	    chart: {
	        plotBackgroundColor: null,
	        plotBorderWidth: null,
	        plotShadow: false,
	        type: 'pie'
	    },
	    title: {
	        text: ''
	    },
	    tooltip: {
	        shared: true,
	        useHTML: true
	    },
	    plotOptions: {
	        pie: {
	            allowPointSelect: true,
	            cursor: 'pointer',
	        }
	    },
	    series: [{
	        name: '',
	        colorByPoint: true,
	        data: [
					['Accepted within 24 hour', <?php echo $acceptance_analytics_graph_overall_value[1];?>, true, true],
					['Accepted post 24 hour', <?php echo $acceptance_analytics_graph_overall_value[2];?>, false],
					['Feedback Not Accepted', <?php echo $acceptance_analytics_graph_overall_value[3];?>, false],
					['Feedback Rebuttal Raised', <?php echo $acceptance_analytics_graph_overall_value[4];?>, false]
			      ],
      		showInLegend: true
	    }]
	});


	Highcharts.chart('process-wise-chart', {
	    chart: {
	        type: 'column'
	    },
	    title: {
	        text: 'Process Wise Acceptance Analytics'
	    },
	    subtitle: {
	        text: ''
	    },
	    xAxis: {
	        categories: <?php echo json_encode($process_wise_graph_xAxis);?>,
	        crosshair: true
	    },
	    yAxis: {
	        title: {
	            useHTML: true,
	            text: 'Feedback Count'
	        }
	    },
	    tooltip: {

	        shared: true,
	        useHTML: true
	    },
	    plotOptions: {
	        column: {
	            pointPadding: 0.2,
	            borderWidth: 0
	        }
	    },
	    series: [{
	        name: 'Feedback Raised',
	        data: <?php echo json_encode($process_wise_graph_feedback_raised);?>,

	    }, {
	        name: 'Feedback Accepted within 24 hour',
	        data: <?php echo json_encode($process_wise_graph_feedback_accepted_less24hrs);?>,

	    }, {
	        name: 'Feedback Accepted Post 24 hrs',
	        data: <?php echo json_encode($process_wise_graph_feedback_accepted_post24hrs);?>,

	    }, {
	        name: 'Feedback Not Accepted',
	        data: <?php echo json_encode($process_wise_graph_feedback_not_accepted);?>,

	    },{
	        name: 'Rebuttal Raised',
	        data: <?php echo json_encode($process_wise_graph_feedback_rebuttal);?>,

	    }]
	});

	

	Highcharts.chart('tl-wise-chart', {
	    chart: {
	        type: 'column'
	    },
	    title: {
	        text: 'TL Wise Acceptance Analytics'
	    },
	    subtitle: {
	        text: ''
	    },
	    xAxis: {
	        categories: <?php echo json_encode($tl_wise_graph_xAxis);?>,
	        crosshair: true
	    },
	    yAxis: {
	        title: {
	            useHTML: true,
	            text: 'Feedback Count'
	        }
	    },
	    tooltip: {

	        shared: true,
	        useHTML: true
	    },
	    plotOptions: {
	        column: {
	            pointPadding: 0.2,
	            borderWidth: 0
	        }
	    },
	    series: [{
	        name: 'Feedback Raised',
	        data: <?php echo json_encode($tl_wise_graph_feedback_raised);?>,

	    }, {
	        name: 'Feedback Accepted within 24 hour',
	        data: <?php echo json_encode($tl_wise_graph_feedback_accepted_less24hrs);?>,

	    }, {
	        name: 'Feedback Accepted Post 24 hrs',
	        data: <?php echo json_encode($tl_wise_graph_feedback_accepted_post24hrs);?>,

	    }, {
	        name: 'Feedback Not Accepted',
	        data: <?php echo json_encode($tl_wise_graph_feedback_not_accepted);?>,

	    },{
	        name: 'Rebuttal Raised',
	        data: <?php echo json_encode($tl_wise_graph_feedback_rebuttal);?>,

	    }]
	});

	Highcharts.chart('qa-wise-chart', {
	    chart: {
	        type: 'column'
	    },
	    title: {
	        text: 'QA Wise Acceptance Analytics'
	    },
	    subtitle: {
	        text: ''
	    },
	    xAxis: {
	        categories: <?php echo json_encode($qa_wise_graph_xAxis);?>,
	        crosshair: true
	    },
	    yAxis: {
	        title: {
	            useHTML: true,
	            text: 'Feedback Count'
	        }
	    },
	    tooltip: {

	        shared: true,
	        useHTML: true
	    },
	    plotOptions: {
	        column: {
	            pointPadding: 0.2,
	            borderWidth: 0
	        }
	    },
	    series: [{
	        name: 'Feedback Raised',
	        data: <?php echo json_encode($qa_wise_graph_feedback_raised);?>,

	    }, {
	        name: 'Feedback Accepted within 24 hour',
	        data: <?php echo json_encode($qa_wise_graph_feedback_accepted_less24hrs);?>,

	    }, {
	        name: 'Feedback Accepted Post 24 hrs',
	        data: <?php echo json_encode($qa_wise_graph_feedback_accepted_post24hrs);?>,

	    }, {
	        name: 'Feedback Not Accepted',
	        data: <?php echo json_encode($qa_wise_graph_feedback_not_accepted);?>,

	    },{
	        name: 'Rebuttal Raised',
	        data: <?php echo json_encode($qa_wise_graph_feedback_rebuttal);?>,

	    }]
	});


      $(document).on('click','.audit-deatils',function(){

        let agentId = $(this).attr('agent-id');
        const urlParams = new URLSearchParams(location.search);

        $.ajax({
            type: "GET",
            url: '<?php echo base_url("Qa_boomsourcing_data_analytics/get_audit_details?");?>'+urlParams,
            data: { agentId: agentId },
            dataType: "json",
            beforeSend: function(){
               $("#audited-list").html(`<tr><td colspan="13" class="text-center text-bold" style="text-align: center !important;">Please Wait..</td></tr>`);
            },
            success: function (response) {
                let html = "";
                let row = 0;

                if (response.data.length != 0) {
                    for (const [key, value] of Object.entries(response.data)) {
                    
                        // console.log(value.auditor_name)
                        row = parseInt(key) + 1;
                        html += `<tr> 
                                      <td>${row}</td>
                                      <td align="center">${value.auditor_name}</td>
                                      <td align="center">${value.audit_date}</td>
                                      <td align="center">${value.ticket_id}</td>
                                      <td align="center">${value.process_name}</td>
                                      <td align="center">${value.tl_name}</td>
                                      <td align="center">${value.call_date}</td>
                                      <td align="center">${value.audit_type}</td>
                                      <td align="center">${value.overall_score} %</td>
                                      <td align="center">${value.call_duration}</td>
                                      <td align="center">${value.agent_rvw_date || ''}</td>
                                      <td align="center">${value.mgnt_rvw_name || ''}</td>
                                      <td align="center">${value.mgnt_rvw_date || ''}</td>
                                  </tr>`;
                    }
                } else {

                    html = `<tr>
                              <td colspan="13" class="text-center text-bold" style="text-align: center !important;">No Data Available</td>
                            </tr>`;
                }

                $("#audited-list").html(html);
            }
        });
    });
});
</script>