<script src="<?php echo base_url('libs/bower/highcharts/highcharts.js');?>"></script>
<script type="text/javascript">
    $(function(){
        // $('#select_process').select2();
        $('#select_month').select2();
        $('#select_lob').select2();
        $('#select_office').select2();

        $(document).on('change','#find_by',function(){

            $("#select_qa #select_l1 #select_agent").attr('required',false);
            let find_by = $(this).val();
            switch(find_by) {
              case "QA":
                $('#find-by-qa').show();
                $('#find-by-l1').hide();
                $('#find-by-agent').hide();
                $("#select_qa").attr('required',true);
                break;
              case "L1":
                $('#find-by-l1').show();
                $('#find-by-qa').hide();
                $('#find-by-agent').hide();
                $("#select_l1").attr('required',true);
                break;
              case "Agent":
                $('#find-by-agent').show();
                $('#find-by-qa').hide();
                $('#find-by-l1').hide();
                $("#select_agent").attr('required',true);
                break;
              default:
                console.log('something went worng.');
            } 
        });

        $('#find_by').trigger('change');

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

        Highcharts.chart('mnthly-trend-graph', {
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

        <?php 
            $pcount = 1;
            foreach($parameter_wise_graph as $pgraph): ?>

                Highcharts.chart('parameter-wise-chart-<?php echo $pcount++;?>', {
                    chart: {
                        zoomType: 'xy'
                    },
                    title: {
                        text: '',
                        align: 'left'
                    },
                    xAxis: [{
                        categories: <?php echo json_encode($pgraph['parameter_wise_graph_xAxis']);?>,
                        crosshair: true
                    }],
                    yAxis: [{
                        title: {
                            text: 'Error Count',
                            style: {
                                color: Highcharts.getOptions().colors[1]
                            }
                        }
                    }, { // Secondary yAxis
                        title: {
                            text: 'CF',
                            style: {
                                color: Highcharts.getOptions().colors[0]
                            }
                        },
                        opposite: true
                    }],
                    tooltip: {
                        shared: true,
                        valueDecimals: 2
                    },
                    series: [{
                        name: 'CF',
                        type: 'column',
                        yAxis: 1,
                        data: <?php echo json_encode($pgraph['parameter_wise_graph_quality_score']);?>,

                    }, {
                        name: 'Error Count',
                        type: 'spline',
                        data: <?php echo json_encode($pgraph['parameter_wise_graph_audit_count']);?>,
                    }]
                });
        <?php endforeach;?>

        /*keywords search in table*/
        $(document).on('keyup','#table-search-input-1',function() {
            var $rows = $('#date-agent-wise-date-wise-table tbody tr');
            var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
            
            $rows.show().filter(function() {
                var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
                return !~text.indexOf(val);
            }).hide();
        });
        $(document).on('keyup','#table-search-input-2',function() {
            var $rows = $('#date-agent-wise-week-wise-table tbody tr');
            var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
            
            $rows.show().filter(function() {
                var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
                return !~text.indexOf(val);
            }).hide();
        });

        $(document).on('keyup','#table-search-input-3',function() {
            var $rows = $('#date-qa-wise-date-wise-table tbody tr');
            var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
            
            $rows.show().filter(function() {
                var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
                return !~text.indexOf(val);
            }).hide();
        });

         $(document).on('keyup','#table-search-input-4',function() {
            var $rows = $('#date-qa-wise-week-wise-table tbody tr');
            var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
            
            $rows.show().filter(function() {
                var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
                return !~text.indexOf(val);
            }).hide();
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
