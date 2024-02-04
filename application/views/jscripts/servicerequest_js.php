<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/css/custom.css"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>

<!------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------>
<script>
	 $(document).ready(function () {
      $('.select-box').selectize({
          sortField: 'text'
      });
  });
</script>
<script>
$(function() {  
 $('#multiselect').multiselect();

 $('.multi_location').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        }); 
});
</script>
<script>
$("#location_dt1").change(function(){
	var loc_id=$(this).serializeArray();
	var request_url = "<?php echo base_url('servicerequest/get_location_wise_user'); ?>";
	process_ajax(function(response)
	{
		var res = JSON.parse(response);
		if (res.stat == true) 
		{
			var option = '<option value="" selected disabled>--Select--</option>';
			$.each(res.datas,function(index,element)
			{
				option += '<option value="'+element.id+'" >'+element.fname+' '+element.lname+' ('+element.fusion_id+')</option>';
			});
			$('#on_behalf_of').html(option);
		}
	},request_url, loc_id, 'text');
});	
</script>
<!------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------>




<!--<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.css" rel="stylesheet">-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js"></script>-->

<script src="<?php echo base_url() ?>assets/js/echarts.js"></script>



<script>    
$(document).ready(function(){

    // $('#summernote').summernote({
    //     toolbar: [
    //         // [groupName, [list of button]]
    //         ['style', ['bold', 'italic', 'underline', 'clear']],
    //         ['font', ['strikethrough', 'superscript', 'subscript']],
    //         ['fontsize', ['fontsize']],
    //         ['color', ['color']],
    //         ['para', ['ul', 'ol', 'paragraph']],
    //         ['height', ['height']]
    //     ],
    //     height: 200,
    //     placeholder: 'Details'
    // });

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
            $.post("<?php echo base_url(); ?>servicerequest/get_sub_category",{'category_id':$(this).val()}, function(data){
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


    //$("#summernote-disabled").summernote('disable');

    $("span.delete-icons").hover(
        function(){$(this).css("color","#ff0000")},
        function(){$(this).css("color","#cec8c8")
    });  

    $("#addTicket").click(function(){
		var priority = $("#priority").val();
		var location_dt1 = $("#location_dt1").val();
		var loc_cat1 =$("#loc_cat1").val();  

    	if (priority != '' || location_dt1 != '' || loc_cat1 != '') {
           	
	        if(($("#subject").val()).trim().length >= 5){
	            //var plainText = $($("#summernote").summernote("code")).text();
	           var plainText = $("#details_ticket").val();

	            if(plainText.length >= 10){
	                $("#frmAddTicket").submit();
	            }
	            else {
	                alert('Ticket Details field text requires 10 characters or more characters.');
	                //$("#summernote").summernote('focus');
	            }
	        } 
	        else{
	            alert('Subject field is required 5 characters or more characters.');
	            $("#subject").val('');
	            $("#subject").focus();
	        }
	    }
	    else {
	    	alert("Priority, Location & Category is Required");
	    }
    });



});
</script>
<!--<script>
function open_record(id){
    location.href = '<?php echo base_url() ?>'+'servicerequest/ticket/'+id;
}


function takeover(id, created_by){
    $.post('<?php echo base_url() ?>'+'servicerequest/takeover_ticket',{'id':id, 'created_by':created_by}, function(data){
        if(data == 1) location.reload();
        else alert("Operation Failed");
    });
}

function inprocess(id){
    $.post('<?php echo base_url() ?>'+'servicerequest/status_inprocess',{'id':id}, function(data){
        if(data == '1') location.reload();
        else alert("Operation Failed");
    });
}

function putonhold(id){
    $.post('<?php echo base_url() ?>'+'servicerequest/status_putonhold',{'id':id}, function(data){
        if(data == 1) location.reload();
        else alert("Operation Failed");
    });
}

function close_ticket(id){
    $.post('<?php echo base_url() ?>'+'servicerequest/status_closed',{'id':id}, function(data){
        if(data == 1) location.reload();
        else alert("Operation Failed");
    });
}

function reopen_ticket(id){
    $.post('<?php echo base_url() ?>'+'servicerequest/status_reopen',{'id':id}, function(data){
        if(data == 1) location.reload();
        else alert("Operation Failed");
    });
}

function close_as_duplicate(id){
    $.post('<?php echo base_url() ?>'+'servicerequest/close_as_duplicate',{'id':id}, function(data){
        if(data == 1) location.reload();
        else alert("Operation Failed");
    });
}

function reply_and_close(){
    $("#reply_form").attr("action",'<?php echo base_url() ?>'+'servicerequest/reply_and_close');
    $("#reply_form").submit();
}

function delete_file(id){
    $.post('<?php echo base_url() ?>'+'servicerequest/delete_attachments',{'id':id}, function(data){
        if(data == 1) location.reload();
        else alert("Operation Failed");
    });
}

function print_page(){
    window.print();
    return false;
}


</script>-->

<script>
	//get location id
    $("#multi_location_pop").change(function(){
        var location_abbr=$(this).val();
        localStorage.setItem("loc_name", location_abbr);
});
</script>

<script>
    $(".department_name").change(function(){
    console.log(localStorage.getItem("loc_name"));
    var dpt_id=$(this).val();
    var location_name=localStorage.getItem("loc_name");

    var data = {department_id:dpt_id, location:location_name};

	var request_url = "<?php echo base_url('servicerequest/get_dpt_wise_user'); ?>";
	process_ajax(function(response)
    {
        var res = JSON.parse(response);
		if (res.stat == true) 
		{
			var option = '<option value="" selected disabled>--Select--</option>';
			$.each(res.datas,function(index,element)
			{
				option += '<option value="'+element.id+'" >'+element.fname+' '+element.lname+' ('+element.fusion_id+')</option>';
			});
			$('.user_names').html(option);
		}
	},request_url, data, 'text');
});
</script>
<script>
    $(document).on('click',".assign_tic",function(e){
		e.preventDefault();
		
		var ticket_id = $(this).attr('value');
        
		$('#edit_pop').modal('show');
        $('#ticket_id').val(ticket_id);
	});
</script>

<script>
    $(document).on('click',".ticket_view_update",function(e){
		e.preventDefault();
		
		var ticket_id = $(this).attr('value');
        var assign_to = $(this).attr('assign');
        var data = {ticket_id: ticket_id};
        var request_url = "<?php echo base_url('servicerequest/get_ticket_details'); ?>";
        process_ajax(function(response)
        {
            var res = JSON.parse(response);
            if (res.stat == true) 
            {
                $('#tic_reference').text(res.datas[0]['reference_id']);
                $('#tic_subject').text(res.datas[0]['subject']);
                $('#tic_details').text(res.datas[0]['details']);
                $('#input_tic_id').val(res.datas[0]['id']);
                $('#assign_to_input').val(assign_to);

                if (res.datas[0]['user_id'] !== null) { $('#behalf_of').html('<strong>Behalf of another User: </strong>'+res.datas[0]['behalf_of']+" ("+res.datas[0]['user_id']+")"); }
                else { $('#behalf_of').html(' ') }

                if (res.datas[0]['file_location'] !== null) { $('#files').html('<strong>Files: </strong> '+res.datas[0]['file_location']+' <a target="_blank" href="<?=base_url()?>service_request_path/'+ticket_id+'/'+res.datas[0]['file_location']+'">(View)<a/>'); }
                else { $('#files').html(' ') }
                
            }
        },request_url, data, 'text');    
		$('#ticket_view_update').modal('show');
	});
</script>
<script>
$("#loc_cat1").change(function(){    
	var cat_id=$(this).serializeArray();
	var request_url = "<?php echo base_url('servicerequest/get_category_wise_sub_category'); ?>";
	process_ajax(function(response)
	{
		var res = JSON.parse(response);
		if (res.stat == true) 
		{
			var option = '<option value="" selected disabled>--Select--</option>';
			$.each(res.datas,function(index,element)
			{
				option += '<option value="'+element.id+'" >'+element.name+'</option>';
			});
			$('#sub_category1').html(option);
		}
	},request_url, cat_id, 'text');
});
</script>

<script>
//add_category_model_open
$(document).on('click',".edit_category_model",function(e){
		e.preventDefault();

		var id = $(this).attr('value');
        $('#cat_id').val(id);
		$('#edit_category').modal('show');
	});  
</script>

<script>
//add_SUB_category_model_open
$(document).on('click',".edit_sub_category_model",function(e){
		e.preventDefault();

		var id = $(this).attr('value');
        $('#sub_cat_id').val(id);
		$('#edit_sub_category_model').modal('show');
	});  
</script>
<script>
$("#submit_category_preassign").click(function() {
    //$("#d").trigger("reset");
    //$("#d").get(0).reset();
   $("#category_pre_assign")[0].reset();
});    
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

<script>
	var ctxBAR = document.getElementById("bar-chart");
	var myBarChart_dailyVisitor = new Chart(ctxBAR, {
	type: 'bar',
		data: {
		labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
		datasets: [
	{
	label: "Visitors",
		data: [12, 19, 3, 5, 2, 3],
			 backgroundColor: [
			  'rgba(255, 99, 132, 0.9)',
			  'rgba(255, 159, 64, 0.9)',
			  'rgba(255, 205, 86, 0.9)',
			  'rgba(75, 192, 192, 0.9)',
			  'rgba(54, 162, 235, 0.9)',
			  'rgba(153, 102, 255, 0.9)',
			  'rgba(201, 203, 207, 0.9)'
		],
		borderColor: [
		  'rgb(255, 99, 132)',
		  'rgb(255, 159, 64)',
		  'rgb(255, 205, 86)',
		  'rgb(75, 192, 192)',
		  'rgb(54, 162, 235)',
		  'rgb(153, 102, 255)',
		  'rgb(201, 203, 207)'
		],
			borderWidth: 3
		}
	]
},
	options: {
		legend: { display: false, position: 'right' },
		title: {
		display: true,
		lineHeight: 2,
		text: ""
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
	}],
	yAxes: [{
		display:true,
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
</script>

<script>
	var ctxBAR = document.getElementById("bar-doughnut");
	var myBarChart_dailyVisitor = new Chart(ctxBAR, {
	type: 'doughnut',
		data: {
		labels: [
    'Red',
    'Blue',
    'Yellow'
  ],
		datasets: [
	{
	label: "Visitors",
		data: [12, 19, 3],
			 backgroundColor: [
			  'rgba(255, 99, 132, 0.9)',
			  'rgba(255, 159, 64, 0.9)',
			  'rgba(255, 205, 86, 0.9)'			 
		],
		borderColor: [
		  'rgb(255, 99, 132)',
		  'rgb(255, 159, 64)',
		  'rgb(255, 205, 86)'		  
		],
			borderWidth: 3
		}
	]
},
	options: {
		legend: { display: false, position: 'right' },
		title: {
		display: true,
		lineHeight: 2,
		text: ""
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
	}],
	yAxes: [{
		display:true,
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
</script>

