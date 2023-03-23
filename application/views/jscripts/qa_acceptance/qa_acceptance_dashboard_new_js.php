<script src="<?php echo base_url('libs/bower/highcharts/highcharts.js');?>"></script>
<script src="<?php echo base_url('libs/bower/highcharts/no-data-to-display.js')?>"></script>
<script type="text/javascript">
    $(function(){
        $("#select_client").select2();
        $('#select_process').select2();
        $('#select_campaign').select2();
         $('#l1_super').select2();
        $('#select_qa').select2();
        $('#select_month').select2();
        $('#select_office').select2();

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

       get_process_by_client().then(() => get_campaign_by_process())
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

        Highcharts.chart('weekly-trend-graph', {
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: '',
                align: 'center'
            },
            xAxis: [{
                categories: <?php echo json_encode($graph_week_name);?>,
                crosshair: true
            }],
            yAxis: [{
                title: {
                    text: 'Quality Score',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                }
            }, { // Secondary yAxis
                title: {
                    text: 'Number Of Audit',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: true
            }],
            tooltip: {
                shared: true
            },
            series: [{
                name: 'Number Of Audit',
                type: 'column',
                yAxis: 1,
                data: <?php echo json_encode($graph_weekly_audit_count);?>,

            },{
                name: 'Number Of Fatal',
                type: 'column',
                yAxis: 1,
                data: <?php echo json_encode($graph_weekly_fatal_count);?>,

            }, 
            {
                name: 'Quality Score',
                type: 'spline',
                data: <?php echo json_encode($graph_weekly_quality_score);?>,
            }]
        });

        Highcharts.chart('monthly-trend-graph', {
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: '',
                align: 'center'
            },
            xAxis: [{
                categories: <?php echo json_encode($graph_mnth_name);?>,
                crosshair: true
            }],
            yAxis: [{
                title: {
                    text: 'Quality Score',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                }
            }, { // Secondary yAxis
                title: {
                    text: 'Number Of Audit',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: true
            }],
            tooltip: {
                shared: true
            },
            series: [{
                name: 'Number Of Audit',
                type: 'column',
                yAxis: 1,
                data: <?php echo json_encode($graph_mnthly_audit_count);?>,

            },{
                name: 'Number Of Fatal',
                type: 'column',
                yAxis: 1,
                data: <?php echo json_encode($graph_mnthly_fatal_count);?>,

            }, 
            {
                name: 'Quality Score',
                type: 'spline',
                data: <?php echo json_encode($graph_mnthly_quality_score);?>,
            }]
        });

        Highcharts.chart('date-wise-chart', {
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: 'Date Wise Audit',
                align: 'center'
            },
            xAxis: [{
                categories: <?php echo json_encode($date_wise_graph_xAxis);?>,
                crosshair: true
            }],
            yAxis: [{
                title: {
                    text: 'Quality Score',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                }
            }, { // Secondary yAxis
                title: {
                    text: 'Number Of Audit',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: true
            }],
            tooltip: {
                shared: true
            },
            series: [{
                name: 'Number Of Audit',
                type: 'column',
                yAxis: 1,
                data: <?php echo json_encode($date_wise_graph_audit_count);?>,

            }, {
                name: 'Quality Score',
                type: 'spline',
                data: <?php echo json_encode($date_wise_graph_quality_score);?>,
            }]
        });

        Highcharts.chart('location-wise-chart', {
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: 'Location Wise Audit',
                align: 'center'
            },
            xAxis: [{
                categories: <?php echo json_encode($location_wise_graph_xAxis);?>,
                crosshair: true
            }],
            yAxis: [{
                title: {
                    text: 'Quality Score',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                }
            }, { // Secondary yAxis
                title: {
                    text: 'Number Of Audit',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: true
            }],
            tooltip: {
                shared: true
            },
            series: [{
                name: 'Number Of Audit',
                type: 'column',
                yAxis: 1,
                data: <?php echo json_encode($location_wise_graph_audit_count);?>,

            }, {
                name: 'Quality Score',
                type: 'spline',
                data: <?php echo json_encode($location_wise_graph_quality_score);?>,
            }]
        });

        Highcharts.chart('evaluator-wise-chart', {
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: 'Evaluator Wise Audit',
                align: 'center'
            },
            xAxis: [{
                categories: <?php echo json_encode($evaluator_wise_graph_xAxis);?>,
                crosshair: true
            }],
            yAxis: [{
                title: {
                    text: 'Quality Score',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                }
            }, { // Secondary yAxis
                title: {
                    text: 'Number Of Audit',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: true
            }],
            tooltip: {
                shared: true
            },
            series: [{
                name: 'Number Of Audit',
                type: 'column',
                yAxis: 1,
                data: <?php echo json_encode($evaluator_wise_graph_audit_count);?>,

            }, {
                name: 'Quality Score',
                type: 'spline',
                data: <?php echo json_encode($evaluator_wise_graph_quality_score);?>,
            }]
        });

        Highcharts.chart('tl-wise-chart', {
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: 'Supervisor Wise Audit',
                align: 'center'
            },
            xAxis: [{
                categories: <?php echo json_encode($tl_wise_graph_xAxis);?>,
                crosshair: true
            }],
            yAxis: [{
                title: {
                    text: 'Quality Score',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                }
            }, { // Secondary yAxis
                title: {
                    text: 'Number Of Audit',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: true
            }],
            tooltip: {
                shared: true
            },
            series: [{
                name: 'Number Of Audit',
                type: 'column',
                yAxis: 1,
                data: <?php echo json_encode($tl_wise_graph_audit_count);?>,

            }, {
                name: 'Quality Score',
                type: 'spline',
                data: <?php echo json_encode($tl_wise_graph_quality_score);?>,
            }]
        });

        Highcharts.chart('agent-wise-chart', {
            chart: {
                zoomType: 'xy',
                events: {
                        load: function(event) {
                            /*hide Highchart Tag*/
                            $('.highcharts-credits').attr('style', 'display:none');
                        }
                    }
            },
            title: {
                text: 'Agent Wise Data',
                align: 'center'
            },
            xAxis: [{
                categories: <?php echo json_encode(array_values($agent_wise_graph_xAxis))?>,
                crosshair: true
            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                title: {
                    text: 'Avg. Score',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                }
            }, { // Secondary yAxis
                title: {
                    text: 'Audit Count',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: true
            }],
            tooltip: {
                shared: true
            },
            series: [{
                name: 'Audit Count',
                type: 'column',
                yAxis: 1,
                data: <?php echo json_encode(array_values($agent_wise_graph_audit_count))?>

            }, {
                name: 'Accepted',
                type: 'column',
                data: <?php echo json_encode(array_values($agent_wise_graph_accepted))?>
            },{
                name: 'Quality Score',
                type: 'spline',
                data: <?php echo json_encode(array_values($agent_wise_graph_quality_score))?>
            }]
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
$("#select_from_date, #select_to_date").datepicker({
    dateFormat: "yy-mm-dd",
});

$(function(){

    /*For Tab*/
    $(document).on('click','.oneItem',function(){

        const tabName = $(this).attr('data-open-tab');

        $(this).closest('.oneTabs').find('li').each(function(i){
            $(this).removeClass('active');
        });

        $(this).addClass('active');

        $(this).closest('.widget-body').find('.tabs').each(function(i){
       
            if(tabName == $(this).attr('data-tab-name')){
                $(this).addClass('open');
                $(this).attr('style','display:block');
            }
            else
            {
                $(this).removeClass('open');
                $(this).attr('style','display:none');
            }
        });
    });
});
</script>
