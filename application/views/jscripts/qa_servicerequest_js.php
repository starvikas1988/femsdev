<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js"></script>

<!--<script src="<?php echo base_url() ?>assets/js/echarts.js"></script>-->



<script type="text/javascript">
    
    
$(document).ready(function(){
	
    $('#summernote').summernote({
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ],
        height: 200,
        placeholder: 'Details'
    });

    if($("#self_submit").prop('checked')){
            $("#on_behalf_of-div").show();
            $("#on_behalf_of").attr('required',true);
    }else{
        $("#on_behalf_of-div").hide();
        $("#on_behalf_of").attr('required',false);
    }

    $("#self_submit").click(function(){
        if($(this).prop('checked')){
            $("#on_behalf_of-div").show();
            $("#on_behalf_of").attr('required',true);
        }else{
            $("#on_behalf_of-div").hide();
            $("#on_behalf_of").attr('required',false);
        }
    });

    $("#addTicketModel").on('hidden.bs.modal', function(){
        document.getElementById("frmAddTicket").reset();
        $("#on_behalf_of-div").hide();
        $("#sub_category").empty().html('<option value=""></option>');
        $("#on_behalf_of").attr('required',false);
    });


    $("#category").change(function(){

        if($(this).val()==''){
            $("#sub_category").empty().html('<option value="">ALL</option>');
        }else{
            $.post("<?php echo base_url(); ?>qa_servicerequest/get_sub_category",{'category_id':$(this).val()}, function(data){
                $("#sub_category").empty().html('<option value="">ALL</option>');
                $("#sub_category").append(data);
            });
        }
    });

    $("#editTicketmodal_button").click(function() {
        $(".modal").modal('hide');
        $('#editTicketmodal').modal('show');  
        //$('#transfer-ticket-modal').modal('hide');  
    });


    $("#summernote-disabled").summernote('disable');

    $("span.delete-icons").hover(
        function(){$(this).css("color","#ff0000")},
        function(){$(this).css("color","#cec8c8")
    });
    

    $("#addTicket").click(function(){
        if(($("#subject").val()).trim().length >= 10){
            var plainText = $($("#summernote").summernote("code")).text();
            if(plainText.length >= 25){
                $("#frmAddTicket").submit();
            }
            else {
                alert('"Ticket Details" field text text requires 25 characters or more characters.');
                $("#summernote").summernote('focus');
            }
        } 
        else{
            alert('"Subject" field text requires 10 characters or more characters.');
            $("#subject").val('');
            $("#subject").focus();
        }
    });



});

function open_record(id){
    location.href = '<?php echo base_url() ?>'+'qa_servicerequest/ticket/'+id;
}


function takeover(id, created_by){
    $.post('<?php echo base_url() ?>'+'qa_servicerequest/takeover_ticket',{'id':id, 'created_by':created_by}, function(data){
        if(data == 1) location.reload();
        else alert("Operation Failed");
    });
}

function inprocess(id){
    $.post('<?php echo base_url() ?>'+'qa_servicerequest/status_inprocess',{'id':id}, function(data){
        if(data == '1') location.reload();
        else alert("Operation Failed");
    });
}

function putonhold(id){
    $.post('<?php echo base_url() ?>'+'qa_servicerequest/status_putonhold',{'id':id}, function(data){
        if(data == 1) location.reload();
        else alert("Operation Failed");
    });
}

function close_ticket(id){
    $.post('<?php echo base_url() ?>'+'qa_servicerequest/status_closed',{'id':id}, function(data){
        if(data == 1) location.reload();
        else alert("Operation Failed");
    });
}

function reopen_ticket(id){
    $.post('<?php echo base_url() ?>'+'qa_servicerequest/status_reopen',{'id':id}, function(data){
        if(data == 1) location.reload();
        else alert("Operation Failed");
    });
}

function close_as_duplicate(id){
    $.post('<?php echo base_url() ?>'+'qa_servicerequest/close_as_duplicate',{'id':id}, function(data){
        if(data == 1) location.reload();
        else alert("Operation Failed");
    });
}

function reply_and_close(){
    $("#reply_form").attr("action",'<?php echo base_url() ?>'+'qa_servicerequest/reply_and_close');
    $("#reply_form").submit();
}

function delete_file(id){
    $.post('<?php echo base_url() ?>'+'qa_servicerequest/delete_attachments',{'id':id}, function(data){
        if(data == 1) location.reload();
        else alert("Operation Failed");
    });
}

function print_page(){
    window.print();
    return false;
}


</script>

<!--
<script>
// Reports Section Javascript

// based on prepared DOM, initialize echarts instance
var myChart = function(selector){
    console.log(selector);
    return echarts.init(document.getElementById(selector));
}

// specify chart configuration item and data
var option = function(legend_array = [],series_data_array = []){
            options = {
                title: {
                    text: 'Tickets',
                    x:'center'
                },
                tooltip: {
                    trigger: 'item',
                    formatter: "{a} <br/>{b} : {c} ({d}%)"
                },
                legend: {
                    orient: 'vertical',
                    left: 'left',
                    data: legend_array,
                },                
                series: series_data_array
            }

            return options;
        };

// temp

series_data_array = [{ name: 'Tickets',
            type: 'pie',
            radius : '50%',
            center: ['50%', '60%'],
            data:[
                {value:335, name:'a'},
                {value:310, name:'b'},
                {value:234, name:'c'},
                {value:135, name:'d'},
                {value:1548, name:'e'}
            ],
        }];

// temp
legend_array = ['a','b','c','d','e'];

myChart("chart_canvas").setOption(option(legend_array, series_data_array));
myChart("chart_canvas_2").setOption(option(legend_array, series_data_array));
myChart("chart_canvas_3").setOption(option(legend_array, series_data_array));
myChart("chart_canvas_4").setOption(option(legend_array, series_data_array));
myChart("chart_canvas_5").setOption(option(legend_array, series_data_array));
</script>-->