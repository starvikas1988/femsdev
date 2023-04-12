<script src="<?php echo base_url('libs/bower/highcharts/highcharts.js');?>"></script>
<script type="text/javascript">

$("#select_from_date, #select_to_date").datepicker({
    dateFormat: "yy-mm-dd",
});


$(function(){

    // $("#select_process").select2();
    // $("#select_lob").select2();
    /*$("#vertical").select2();
    $("#campaign_process").select2();
    $("#select_qa").select2();
    $("#select_l1").select2();
    $("#select_agent").select2();*/

    $(document).on('change','#rep_type',function(){

        let rep_type = $(this).val();
        RepresentationDisplay(rep_type);
    });
    
    RepresentationDisplay($('#rep_type').val());
    
    $(document).on('change','#rep_type',function(){
        let searchType = $(this).val();
    });

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
            // console.log('something went worng.');
        } 
    });

    $('#find_by').trigger('change');

<?php $i = 1; 
    foreach($parameter_details as $defect_table_key => $data):?>
    Highcharts.chart('chart-<?php echo $i;?>', {
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
            text: '<?php echo strtoupper(str_replace('qa_', '', str_replace('_feedback', '', $defect_table_key)));?>',
            align: 'left'
        },
        xAxis: [{
            categories: <?php echo json_encode($graph_data[$defect_table_key]['xAxis']);?>,
            crosshair: true
        }],
        yAxis: [{
            labels: {
                format: '{value}',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            },
            title: {
                text: 'Score',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            }
        }, {
            title: {
                text: 'Count',
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
            name: 'Yes',
            type: 'column',
            yAxis: 1,
            data: <?php echo json_encode($graph_data[$defect_table_key]['yes_count']);?>

        },{
            name: 'No',
            type: 'column',
            yAxis: 1,
            data: <?php echo json_encode($graph_data[$defect_table_key]['no_count']);?>

        },{
            name: 'NA',
            type: 'column',
            yAxis: 1,
            data: <?php echo json_encode($graph_data[$defect_table_key]['na_count']);?>

        }, {
            name: 'Score (%)',
            type: 'spline',
            data: <?php echo json_encode($graph_data[$defect_table_key]['score']);?>
        }]
    });

    /*keywords search in table*/
    $(document).on('keyup','#table-search-input-<?php echo $i;?>',function() {
        var $rows = $('#table-data-<?php echo $i;?> tbody tr');
        var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
        
        $rows.show().filter(function() {
            var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
            return !~text.indexOf(val);
        }).hide();
    });

<?php $i++; endforeach;?>

});

function RepresentationDisplay(rep_type){

    if(rep_type=='daily' || rep_type=='weekly'){

        $("#select_from_date, #select_to_date").attr("required", true);
        $("#select_month, #select_year").removeAttr("required");

        $('#daily').show();
        $('#monthly').hide();
        $('#weekly').hide();
        $('#select_from_date').datepicker('setDate', null);

        $('#select_to_date').datepicker('setDate', null);
        $('#select_to_date').datepicker('option', 'minDate', null);
        $('#select_to_date').datepicker('option', 'maxDate', null);

        if(rep_type=='daily'){

            const params = new Proxy(new URLSearchParams(window.location.search), {
              get: (searchParams, prop) => searchParams.get(prop),
            });

            $("#select_from_date").datepicker('setDate', params.select_from_date);
            $("#select_to_date").datepicker('setDate', params.select_to_date);
        }

    }else if(rep_type=='monthly'){
        
        $("#select_month, #select_year").attr("required", true);
        $("#select_from_date, #select_to_date").removeAttr("required");
        $("#select_from_date, #select_to_date").val('');
        $('#monthly').show();
        $('#daily').hide();
        $('#weekly').hide();
    }
}

/*function from_to_date_diff(){
    var start= $("#select_from_date").datepicker("getDate");
    var end= $("#select_to_date").datepicker("getDate");
    days = (end- start) / (1000 * 60 * 60 * 24);
    // alert(Math.round(days));
    return days;
}*/
</script>
