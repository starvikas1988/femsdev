<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
	var data = google.visualization.arrayToDataTable([
	  ['Feedback', 'Received'],
	  ["Total Customer (<?php echo $totalCRMCount; ?>)", <?php echo $totalCRMCount; ?>],
	  ["Feedback Received (<?php echo $totalFeedbackCount; ?>)", <?php echo $totalFeedbackCount; ?>],
	  ]);

	var options = {
	  title: "Feedback Overview",
	  is3D: true,
	  colors: ['#ef2c2c','#5cb85c'],
	};

	var chart = new google.visualization.PieChart(document.getElementById('feedback_overview_graph'));
	chart.draw(data, options);
}


$('.downloadFeedback').click(function(){
	monthSelect = $('#monthSelect').val();
	yearSelect = $('#yearSelect').val();
	url = "<?php echo base_url(); ?>feedback/generate_feedback_reports?monthSelect="+monthSelect+"&yearSelect="+yearSelect;
	window.location.href= url;
});
</script>