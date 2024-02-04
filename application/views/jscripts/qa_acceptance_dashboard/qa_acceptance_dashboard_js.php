<script src="<?php echo base_url('libs/bower/highcharts/highcharts.js');?>"></script>
<script src="<?php echo base_url('libs/bower/highcharts/no-data-to-display.js')?>"></script>
<script type="text/javascript">
	
	$(document).ready(function(e){
	$('#select_office').select2();
	$('#select_client').select2();
	$('#select_process').select2();
	$('#select_campaign').select2();
	$('#l1_super').select2();
	$('#select_qa').select2();
	$("#select_from_date, #select_to_date").datepicker({
	    dateFormat: "yy-mm-dd",
	});

	
	const get_process_by_client = async() => {

            const clientId = $('#select_client').val();

                try {

                const response = await $.ajax({
                    url:"<?php echo base_url('qa_one_view_dashboard/get_process_by_client');?>",
                    type:"POST",
                    data:{
                        clientId
                    },
                    dataType:"json",
                    success:function(response){
                        let processList = response.processList;
                        const params = window.location.search;
                        $("#select_process").html(`<option value="" selected>Select Process</option>`);
                        if(processList?.length > 0){
                            processList.map((proc, index)=>(
                                $("#select_process").append(`<option value=${proc.process_id} ${params.includes("select_process="+proc.process_id) ? 'selected' : ''}>${proc.process_name}</option>`)
                            ));
                            $("#select_process").attr('disabled',false);
                        }

                    }
                });

                return response;

            } catch(e) {
                // console.log(e);
            }
        }

        const get_campaign_by_process = async() => {

            const clientId = $('#select_client').val();
            const processId = $('#select_process').val();

                try {

                const response = await $.ajax({
                    url:"<?php echo base_url('qa_one_view_dashboard/get_campaign_by_process');?>",
                    type:"POST",
                    data:{
                        clientId,processId
                    },
                    dataType:"json",
                    success:function(response){
                        let campaignList = response.campaignList;
                        const params = window.location.search;
                        
                        if(campaignList?.length > 0){

                            $("#select_campaign").html(`<option value="ALL" ${params.includes("select_campaign[]=ALL") ? 'selected' : ''}>ALL</option>`);

                            campaignList.map((campaign, index)=>(
                                $("#select_campaign").append(`<option value=${campaign.campaign_id} ${params.includes("select_campaign[]="+campaign.campaign_id) ? 'selected' : ''}>${campaign.campaign_name}</option>`)
                            ));
                            $("#select_campaign").attr('disabled',false);
                            $("#search-btn").attr('disabled',false);
                            $("#export-btn").attr('disabled',false);
                            $('#export-btn').attr('onclick','return true');
                        }
                        else
                        {
                            $("#select_campaign").html('');
                            $("#search-btn").attr('disabled',true);
                            $("#export-btn").attr('disabled',true);
                            $('#export-btn').attr('onclick','return false');
                        }
                    }
                });

                return response;

            } catch(e) {
                // console.log(e);
            }
        }

        get_process_by_client().then(() => get_campaign_by_process());

        $(document).on('change','#select_client',function(){

            get_process_by_client();
        });

        $(document).on('change','#select_process',function(){

            get_campaign_by_process();
        });

        $(document).on('change','#rep_type',function(){

            let rep_type = $(this).val();
            RepresentationDisplay(rep_type);
        });

        RepresentationDisplay($('#rep_type').val());

        $(document).on('change','#select_from_date',function(){

            if($('#rep_type').val() == 'weekly'){
                var date2 = $('#select_from_date').datepicker('getDate');
                date2.setDate(date2.getDate() + 6);
                $('#select_to_date').datepicker('setDate', date2);
                $('#select_to_date').datepicker('option', 'minDate', date2);
                $('#select_to_date').datepicker('option', 'maxDate', date2);
            }
            else
            {
                $('#select_to_date').datepicker('setDate', null);
            }
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

		Highcharts.chart('campaign-wise-chart', {
		    chart: {
		        type: 'column'
		    },
		    title: {
		        text: 'Campaign Wise Acceptance Analytics'
		    },
		    subtitle: {
		        text: ''
		    },
		    xAxis: {
		        categories: <?php echo json_encode($campaign_wise_graph_xAxis);?>,
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
		        data: <?php echo json_encode($campaign_wise_graph_feedback_raised);?>,

		    }, {
		        name: 'Feedback Accepted within 24 hour',
		        data: <?php echo json_encode($campaign_wise_graph_feedback_accepted_less24hrs);?>,

		    }, {
		        name: 'Feedback Accepted Post 24 hrs',
		        data: <?php echo json_encode($campaign_wise_graph_feedback_accepted_post24hrs);?>,

		    }, {
		        name: 'Feedback Not Accepted',
		        data: <?php echo json_encode($campaign_wise_graph_feedback_not_accepted);?>,

		    },{
		        name: 'Rebuttal Raised',
		        data: <?php echo json_encode($campaign_wise_graph_feedback_rebuttal);?>,

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
            url: '<?php echo base_url("qa_acceptance_dashboard/get_audit_details?");?>'+urlParams,
            data: { agentId: agentId },
            dataType: "json",
            beforeSend: function(){
               $("#audited-list").html(`<tr><td colspan="11" class="text-center text-bold" style="text-align: center !important;">Please Wait..</td></tr>`);
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
                              <td colspan="11" class="text-center text-bold" style="text-align: center !important;">No Data Available</td>
                            </tr>`;
                }

                $("#audited-list").html(html);
            }
        });
    });
});

function RepresentationDisplay(rep_type){

    if(rep_type=='daily' || rep_type=='weekly'){

        $("#select_from_date, #select_to_date").attr("required", true);
        $("#select_month, #select_year").removeAttr("required");

        $('.daily-section').show();
        $('.monthly-section').hide();

        $('#select_to_date').datepicker('setDate', null);
        $('#select_to_date').datepicker('option', 'minDate', null);
        $('#select_to_date').datepicker('option', 'maxDate', null);
        $('#select_from_date').datepicker('setDate', null);

    }else if(rep_type=='monthly'){
        
        $("#select_month, #select_year").attr("required", true);
        $("#select_from_date, #select_to_date").removeAttr("required");
        $("#select_from_date, #select_to_date").val('');
        $('.monthly-section').show();
        $('.daily-section').hide();

    }
}

</script>