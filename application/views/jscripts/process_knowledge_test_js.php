<script>
// This function is called when location, department & client is changed
function locationchange(){
	var location_str="";
	var dept;
	var client;
	var x=document.getElementById("location");
      for (var i = 0; i < x.options.length; i++) {
         if(x.options[i].selected ==true){
             // alert(x.options[i].value);
			  location_str = location_str+','+x.options[i].value;
          }
      }
	document.getElementById('locationArr').value = location_str;
	if(document.getElementById("department").value!=""){
		var dept = document.getElementById("department").value;
	}
	if(document.getElementById("clients").value!=""){
		var client = document.getElementById("clients").value;
	}
	//alert(location_str+":"+dept+":"+client);
	 var root_path = "<?php echo base_url(); ?>";
	 var path = root_path+"process_knowledge_test/get_supervisor";
		$.ajax({
			type: "POST",
			url: path,
			data:{location:location_str,department:dept,client:client},
			
			success: function(data){
				
				$("#supervisor").html(data);
				
			}
		});
	
}

function getSupervisor() {

	var dept = document.getElementById("department").value;
	var client = document.getElementById("clients").value;
	var location_str="";
	
	var x=document.getElementById("location");
      for (var i = 0; i < x.options.length; i++) {
         if(x.options[i].selected ==true){
             // alert(x.options[i].value);
			  location_str = location_str+','+x.options[i].value;
          }
      }
	document.getElementById('locationArr').value = location_str;
	 //var data = location_str+':'+ dept+':'+client;
	 //alert(data);
	 var root_path = "<?php echo base_url(); ?>";
	 var path = root_path+"process_knowledge_test/get_supervisor";
	 //alert(path);
	// var jquery = jQuery.noConflict();
		$.ajax({
			type: "POST",
			url: path,
			data:{location:location_str,department:dept,client:client},
			
			success: function(data){
				//alert(data);
				//console.log(data);
				$("#supervisor").html(data);
			}
		});
	
}

function getAgent(){
	//alert("Hi");
	var supervisor_str="";
	var x=document.getElementById("supervisor");
	
      for (var i = 0; i < x.options.length; i++) {
         if(x.options[i].selected ==true){
             //alert(x.options[i].value);
			  supervisor_str = supervisor_str+','+x.options[i].value;
          }
      }
	 
	  if(supervisor_str!=','){
	  document.getElementById('supervisorArr').value = supervisor_str;
	  }else{
		  supervisor_str ="";
	  }
	  
	  var root_path = "<?php echo base_url(); ?>";
	 var path = root_path+"process_knowledge_test/get_agent";
	
	$.ajax({
		type: "POST",
		url: path,
		data:{supervisor:supervisor_str},
		
		success: function(data){
			//alert(data.length);
			//console.log(data);
			$("#agents").html(data);
			
		}
	});
}
function selectType(val){
	if(val=='random'){
		document.getElementById('question_no_block').style.display="block";
		document.getElementById('question_set_block').style.display="none";
	}if(val=='set'){
		document.getElementById('question_no_block').style.display="none";
		document.getElementById('question_set_block').style.display="block";
		
		
		  var exams =document.getElementById("exams").value;
		  var root_path = "<?php echo base_url(); ?>";
		  var path = root_path+"process_knowledge_test/get_sets";
	      //alert(path);
	      var jquery = jQuery.noConflict();
		  jquery.ajax({
			type: "POST",
			url: path,
			data:{exams:exams},
		
			success: function(data){
				//alert(data);
				jquery("#sets").html(data);	
			}
		  });
	}
}
function selectSet(val){
	//alert(val);
		  var exams =val;
		  var root_path = "<?php echo base_url(); ?>";
		  var path = root_path+"process_knowledge_test/get_sets";
	      //alert(path);
	      var jquery = jQuery.noConflict();
		  jquery.ajax({
			type: "POST",
			url: path,
			data:{exams:exams},
		
			success: function(data){
				//alert(data);
				jquery("#sets").empty().html(data);
			}
		  });
}
function getAgentID(){
		var x=document.getElementById("agents");
		var agents="";
		  for (var i = 0; i < x.options.length; i++) {
			 if(x.options[i].selected ==true){
				  agents = agents+','+x.options[i].value;
			  }
		  }
		  document.getElementById("agentArr").value = agents;
}

</script>


<script src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>
<script src="<?php echo base_url() ?>assets/css/search-filter/js/chart.js"></script>

<script>
$(function() {  
 $('#multiselect').multiselect();

 $('.multiple-select').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        }); 
});
</script>

<script>
	$('.upload input[type="file"]').on('change', function() {
  
  $('.upload-path').val(this.value.replace('C:\\fakepath\\', ''));

});
</script>

<script>
	$(function() {
  $(".repeat").on('click', function(e) {
		var c = $('.base-group').clone();
    c.removeClass('base-group').css('display','block').addClass("child-group");
    $("#main-form").append(c);
  });
});
</script>

<script type="text/javascript">
$(function () {
    $("#agents").select2();
    $("#supervisor").select2();

    $("#exam-click").click(function () {
        $(".exam-widget").show();
    });

    var topTenScore = null;
    var overallMonthlyScore = null;

    get_monthly_top_tem_score();
    get_overall_monthly_data();
    get_pkt_agents();

    $(document).on("change", "#selectedMonth", function () {
        if (topTenScore !== null) { topTenScore.destroy(); }
        if (overallMonthlyScore !== null) { overallMonthlyScore.destroy(); }
        get_monthly_top_tem_score();
        get_overall_monthly_data();
        get_pkt_agents();
    });

    $(document).on('click','.pkt-agent',function(){

    	let agentId = $(this).attr('pkt-agent-id');
    	let selectedMonth = $("#selectedMonth").val();
	    $.ajax({
	        type: "POST",
	        url: '<?php echo base_url("/process_knowledge_test/get_agent_pkt_details")?>',
	        data: { selectedMonth: selectedMonth ,agentId:agentId},
	        dataType: "json",
	        beforeSend: function () {
	            $("#pkt-agents-details-list").html(`<td colspan="11" style="text-align:center !important;" class="text-bold">Please Wait..</td>`);
	        },
	        success: function (response) {

	            let html = "";
	            let row = 0;

	            if (response.data.length != 0) {
	                for (const [key, value] of Object.entries(response.data)) {
	                    row = parseInt(key) + 1;
	                    html += `<tr>
				                      <td align="center">${value.name}</td>
				                      <td align="center">${value.xpoid}</td>
				                      <td align="center">${value.fusion_id}</td>
				                      <td align="center">${value.tl_name}</td>
				                      <td align="center">${value.action_taken}</td>
				                      <td align="center">${value.exam_name}</td>
				                      <td align="center">${value.exam_given_on}</td>
				                      <td align="center">${value.total_score}</td>
				                      <td align="center">${value.score}</td>
				                      <td align="center">${value.score_percent}</td>
				                      <td align="center">${ parseInt(value.score_percent) >= 85 ? 'Pass' : (value.score !='' ? 'Fail' : 'NA') }</td>
				                      
				                  </tr>`;
	                }
	            } else {
	                html = `<tr>
		                      <td colspan="11" class="text-bold" style="text-align:center !important;">No Data Available</td>
		                    </tr>`;
	            }
	            $("#pkt-agents-details-list").html(html);
	        }
	    });
    });

    function get_monthly_top_tem_score() {
        let selectedMonth = $("#selectedMonth").val();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url("/process_knowledge_test/getMonthlyTopTenScore")?>',
            data: { selectedMonth: selectedMonth },
            dataType: "json",
            beforeSend: function () {
                // $("#leaderAgent").html(`<td colspan="5" align="center" class="text-bold">Please Wait..</td>`);
            },
            success: function (response) {

                if (response.scorePercent.length == 0) {
	                $(".bar-chart-area").html(`<div class="text-bold text-center">No Data Available</div>`);
	            }
	            else
	            {
	                $(".bar-chart-area").html(`<canvas id="bar-chart" width="400" height="400"></canvas>`);

	                topTenScore = new Chart("bar-chart", {
	                    type: "bar",
	                    data: {
	                        labels: response.labels,//["Red", "Blue", "Yellow", "Green", "Purple", "Orange","Orange1","Orange2","Orange3","Orange4"],
	                        datasets: [
	                            {
	                                label: "Agents",
	                                data: response.scorePercent, //[12, 19, 3, 5, 2, 3,22,10,2,5]
	                                backgroundColor: [
	                                    "rgba(255, 99, 132, 0.9)",
	                                    "rgba(255, 159, 64, 0.9)",
	                                    "rgba(255, 205, 86, 0.9)",
	                                    "rgba(75, 192, 192, 0.9)",
	                                    "rgba(54, 162, 235, 0.9)",
	                                    "rgba(153, 102, 255, 0.9)",
	                                    "rgba(201, 203, 207, 0.9)",
	                                ],
	                                borderColor: ["rgb(255, 99, 132)", "rgb(255, 159, 64)", "rgb(255, 205, 86)", "rgb(75, 192, 192)", "rgb(54, 162, 235)", "rgb(153, 102, 255)", "rgb(201, 203, 207)"],
	                                borderWidth: 3,
	                            },
	                        ],
	                    },
	                    options: {
	                        legend: { display: false, position: "right" },
	                        title: {
	                            display: true,
	                            lineHeight: 2,
	                            text: "",
	                        },
	                        tooltips: {
	                            callbacks: {
	                                label: function (tooltipItem) {
	                                    return tooltipItem.yLabel + "";
	                                },
	                            },
	                        },
	                        maintainAspectRatio: false,
	                        responsive: true,
	                        scales: {},
	                        plugins: {
	                            datalabels: {
	                                anchor: "end",
	                                align: "top",
	                                formatter: (value, ctx) => {
	                                    return value + "";
	                                },
	                                font: {
	                                    size: 9,
	                                    weight: "bold",
	                                },
	                            },
	                        },
	                    },
	                });

                }
            }
        });
    }

    function get_overall_monthly_data() {
	    let selectedMonth = $("#selectedMonth").val();
	    $.ajax({
	        type: "POST",
	        url: '<?php echo base_url("/process_knowledge_test/get_overall_monthly_data")?>',
	        data: { selectedMonth: selectedMonth },
	        dataType: "json",
	        beforeSend: function () {
	            // $("#leaderAgent").html(`<td colspan="5" align="center" class="text-bold">Please Wait..</td>`);
	        },
	        success: function (response) {

	        	if (response.data.length == 0) {
	                $(".bar-doughnut-area").html(`<div class="text-bold text-center">No Data Available</div>`);
	            }
	            else
	            {
		            $(".bar-doughnut-area").html(`<canvas id="bar-doughnut" width="400" height="400"></canvas>`);
		            overallMonthlyScore = new Chart("bar-doughnut", {
		                type: "doughnut",
		                data: {
		                    labels: response.labels,//["Red", "Blue", "Yellow"],
		                    datasets: [
		                        {
		                            label: "Visitors",
		                            data: response.data,//[12, 19, 3],
		                            backgroundColor: ["rgba(255, 99, 132, 0.9)", "rgba(255, 159, 64, 0.9)", "rgba(255, 205, 86, 0.9)","rgba(201, 203, 207, 0.9)"],
		                            borderColor: ["rgb(255, 99, 132)", "rgb(255, 159, 64)", "rgb(255, 205, 86)", "rgb(201, 203, 207)"],
		                            borderWidth: 3,
		                        },
		                    ],
		                },
		                options: {
		                    legend: { display: false, position: "right" },
		                    title: {
		                        display: true,
		                        lineHeight: 2,
		                        text: "",
		                    },
		                    tooltips: {
		                        callbacks: {
		                            label: function (tooltipItem) {
		                                return tooltipItem.yLabel + "";
		                            },
		                        },
		                    },
		                    maintainAspectRatio: false,
		                    responsive: true,
		                    scales: {
		                        // xAxes: [{}],
		                        // yAxes: [
		                        //     {
		                        //         display: true,
		                        //         ticks: {
		                        //             callback: function (value, index, values) {
		                        //                 return value + "";
		                        //             },
		                        //             beginAtZero: true,
		                        //         },
		                        //     },
		                        // ],
		                    },
		                    plugins: {
		                        datalabels: {
		                            anchor: "end",
		                            align: "top",
		                            formatter: (value, ctx) => {
		                                return value + "";
		                            },
		                            font: {
		                                size: 9,
		                                weight: "bold",
		                            },
		                        },
		                    },
		                },
		            });

	        	}
	        }
	    });
	}
	function get_pkt_agents(){

		let selectedMonth = $("#selectedMonth").val();
	    $.ajax({
	        type: "POST",
	        url: '<?php echo base_url("/process_knowledge_test/get_pkt_agent")?>',
	        data: { selectedMonth: selectedMonth },
	        dataType: "json",
	        beforeSend: function () {
	            $("#pkt-agents-list").html(`<td colspan="9" style="text-align:center !important;" class="text-bold">Please Wait..</td>`);
	        },
	        success: function (response) {

	            let html = "";
	            let row = 0;

	            if (response.data.length != 0) {
	                for (const [key, value] of Object.entries(response.data)) {
	                    row = parseInt(key) + 1;
	                    html += `<tr>
				                      <td align="center">${value.name}</td>
				                      <td align="center">${value.xpoid}</td>
				                      <td align="center">${value.fusion_id}</td>
				                      <td align="center">${value.tl_name}</td>
				                      <td align="center">${value.attempt}</td>
				                      <td align="center">${value.not_attempt}</td>
				                      <td align="center">${value.total_obtain_score}</td>
				                      <td align="center">${value.avg_score}</td>
				                      <td align="center">
					                      <a href="javascript:void(0)" class="edit-btn pkt-agent" pkt-agent-id="${value.assigned_user_id}" data-toggle="modal" data-target="#agent-pkt-details-modal">
													<i class="fa fa-eye" aria-hidden="true"></i>
												</a>
											</td>
				                  </tr>`;
	                }
	            } else {
	                html = `<tr>
		                      <td colspan="9" class="text-bold" style="text-align:center !important;">No Data Available</td>
		                    </tr>`;
	            }
	            $("#pkt-agents-list").html(html);
	        },
	    });
	}
});

</script>
