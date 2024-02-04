<script>
    function total_performance()
    {
        var overall_performance = 0;
        $('#leadership_performance,#work_knowledge_performance,#decision_making_performance,#communication_performance,#crisis_performance').each(function (index, element)
        {
            overall_performance += parseFloat($(element).text().replace('%', ''));
        });
        $('#overall_performance').text(overall_performance.toFixed(2));
    }
</script>
<script>
    $('.leadership').change(function ()
    {
        var total_leadership = 0;
        $('.leadership').each(function (index, element)
        {
            if ($(element).val() !== '')
            {
                var value = parseInt($(element).val());
                total_leadership += value;
            }
        });
        var percentage = ((20 / 25) * total_leadership).toFixed(2);
        $('#leadership_performance').text(percentage);
        total_performance();
    });
</script>

<script>
    $('.work_knowledge').change(function ()
    {
        var total_leadership = 0;
        $('.work_knowledge').each(function (index, element)
        {
            if ($(element).val() !== '')
            {
                var value = parseInt($(element).val());
                total_leadership += value;
            }
        });
        var percentage = ((20 / 25) * total_leadership).toFixed(2);
        $('#work_knowledge_performance').text(percentage);
        total_performance();
    });
</script>
<script>
    $('.decision_making').change(function ()
    {
        var total_leadership = 0;
        $('.decision_making').each(function (index, element)
        {
            if ($(element).val() !== '')
            {
                var value = parseInt($(element).val());
                total_leadership += value;
            }
        });
        var percentage = ((20 / 25) * total_leadership).toFixed(2);
        $('#decision_making_performance').text(percentage);
        total_performance();
    });
</script>
<script>
    $('.communication').change(function ()
    {
        var total_leadership = 0;
        $('.communication').each(function (index, element)
        {
            if ($(element).val() !== '')
            {
                var value = parseInt($(element).val());
                total_leadership += value;
            }
        });
        var percentage = ((20 / 25) * total_leadership).toFixed(2);
        $('#communication_performance').text(percentage);
        total_performance();
    });
</script>
<script>
    $('.crisis').change(function ()
    {
        var total_leadership = 0;
        $('.crisis').each(function (index, element)
        {
            if ($(element).val() !== '')
            {
                var value = parseInt($(element).val());
                total_leadership += value;
            }
        });
        var percentage = ((20 / 25) * total_leadership).toFixed(2);
        $('#crisis_performance').text(percentage);
        total_performance();
    });
</script>

<script>
    $('#feedback_form').submit(function (e)
    {
        e.preventDefault();
        var datas = $(this).serializeArray();
        var leadership = parseFloat($('#leadership_performance').text());
        datas.push({name:"leadership",value:leadership});
        
        var work_knowledge = parseFloat($('#work_knowledge_performance').text());
        datas.push({name:"work_knowledge",value:work_knowledge});
        
        var decision_making = parseFloat($('#decision_making_performance').text());
        datas.push({name:"decision_making",value:decision_making});
        
        var communication = parseFloat($('#communication_performance').text());
        datas.push({name:"communication",value:communication});
        
        var crisis = parseFloat($('#crisis_performance').text());
        datas.push({name:"crisis",value:crisis});
        
        var overall_performance = parseFloat($('#overall_performance').text());
        datas.push({name:"overall_performance",value:overall_performance});
        
        
        
        if(confirm("Are you sure? You Want to Submit!")){
       
			$.ajax({
				  type: 'POST',
				  url: '<?php echo base_url('employee_feedback/process_feedback'); ?>',
				  data: datas,
				  success: function(resultData)
					{
						var response = JSON.parse(resultData);
						if(response.stat == true)
						{
							alert("Thank You For Giving Your Feedback!");
							location.reload();
						}
						else
						{
							alert("Sorry, Please Try Again");
						}
					}
			});
		}
		
    });
	
	
	
	
////////////////////////////////////////////////
// FEEDBACK SUMMARY INFORMATION

baseURL = "<?php echo base_url(); ?>";

$('.openfeedback').click(function(){
	var paramskpi = $(this).attr("fid");
	$.ajax({
	   type: 'GET',    
	   url: baseURL+'employee_feedback/feedback_details',
	   data:'fid=' + paramskpi,
	   success: function(data){
			$('#feedbackbody').html(data);
			$('#modalfeedbackdetails').modal('show');	
		},
		error: function(){
			alert('Fail!');
		}
	});
});

$('#office_id').change(function(){
	var paramskpi = $(this).val();
	$.ajax({
	   type: 'GET',    
	   url: baseURL+'employee_feedback/get_quarter_year_distinct',
	   data:'oid=' + paramskpi,
	   success: function(data){
			$('#quartertime').html(data);
		},
		error: function(){
			alert('Fail!');
		}
	});
});
	
	
	
	
	
	
	
	
	
	
</script>