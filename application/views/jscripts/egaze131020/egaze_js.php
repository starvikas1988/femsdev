<script>
//--- REPORTS DATE
$('.myreports #selectdate').datepicker({ dateFormat: 'yy-mm-dd' });
$('.myreports #selectdatepick').click(function() {
    $("#selectdate").focus();
});

// PROCESS --> CLIENT FILTER
$("#client_id").change(function(){
	var client_id=$(this).val();
	populate_process_combo(client_id,'0','process_id','Y');
});



$('.myreports #selectdate, .myreports #officeid, .myreports #departmentid, .myreports #process_id, .myreports #client_id').change(function(){
	var office = $('.myreports #officeid').val();
	var dept = $('.myreports #departmentid').val();
	var client = $('.myreports #client_id').val();
	var process = $('.myreports #process_id').val();
	var datein = $('.myreports #selectdate').val();
	window.location.href = "<?php echo base_url(); ?>egaze/reports?d=" + datein + "&office=" + office + "&dept=" + dept + "&client=" + client + "&process=" + process;
});

//--- DASHBOARD DATE
$('.mydashboard #selectdate').datepicker({ dateFormat: 'yy-mm-dd' });
$('.mydashboard #selectdatepick').click(function() {
    $(".mydashboard #selectdate").focus();
});
$('.mydashboard #selectdate, .mydashboard #officeid, .mydashboard #departmentid, .mydashboard #process_id, .mydashboard #client_id').change(function(){
	var office = $('.mydashboard #officeid').val();
	var dept = $('.mydashboard #departmentid').val();
	var client = $('.mydashboard #client_id').val();
	var process = $('.mydashboard #process_id').val();
	var datein = $('.mydashboard #selectdate').val();
	window.location.href = "<?php echo base_url(); ?>egaze/dashboard?d=" + datein + "&office=" + office + "&dept=" + dept + "&client=" + client + "&process=" + process;
});


//--- REALTIME DATE
$('.myrealtime #selectdate').datepicker({ dateFormat: 'yy-mm-dd' });
$('.myrealtime #selectdatepick').click(function() {
    $(".myrealtime #selectdate").focus();
});
$('.myrealtime #selectdate, .myrealtime #officeid, .myrealtime #departmentid, .myrealtime #process_id, .myrealtime #client_id').change(function(){
	var office = $('.myrealtime #officeid').val();
	var dept = $('.myrealtime #departmentid').val();
	var client = $('.myrealtime #client_id').val();
	var process = $('.myrealtime #process_id').val();
	var datein = $('.myrealtime #selectdate').val();
	window.location.href = "<?php echo base_url(); ?>egaze/realtime?d=" + datein + "&office=" + office + "&dept=" + dept + "&client=" + client + "&process=" + process;
});

</script>


<?php if($content_template=="egaze/individual.php"){ ?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
<?php if($myactivitieslist != ""){ ?>
  google.charts.load("current", {packages:["timeline"]});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {
    var options = { 
		hAxis: {
          // minValue: new Date(0, 0, 0,0,0,0),
          minValue: new Date(<?php echo date('Y', strtotime($date_now)); ?>, <?php echo date('m', strtotime($date_now)); ?>, <?php echo date('d', strtotime($date_now)); ?>,0,0,0),
         // maxValue: new Date(0, 0, 0,23,59,59)
          maxValue: new Date(<?php echo date('Y', strtotime($date_now)); ?>, <?php echo date('m', strtotime($date_now)); ?>, <?php echo date('d', strtotime($date_now)); ?>,23,59,59)
        },
        timeline: { groupByRowLabel: true, 
		            rowLabelStyle: { fontName: 'Helvetica', fontSize: 12, color: '#603913' },
                    barLabelStyle: { fontName: 'Garamond', fontSize: 10 } ,
					showBarLabels: false
				   },
		backgroundColor: '#fff',
	}; 
    var container = document.getElementById('timestamp');
    var chart = new google.visualization.Timeline(container);
    var dataTable = new google.visualization.DataTable();
    dataTable.addColumn({ type: 'string', id: 'Position' });
    dataTable.addColumn({ type: 'string', id: 'Name' });
    dataTable.addColumn({ type: 'string', role: 'style' });
    dataTable.addColumn({ type: 'date', id: 'Start' });
    dataTable.addColumn({ type: 'date', id: 'End' });
    dataTable.addRows([
	<?php echo $myactivitieslist; ?>    
	]);

    chart.draw(dataTable, options);
  }
<?php } else { ?>
    document.getElementById('timestamp').innerHTML = "<h6>-- No Activities Found --</h6>";
<?php } ?>
</script>
<?php } ?>







<?php if($content_template=="egaze/teammonitoring.php"){ ?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
<?php if($found > 0){ ?>
google.load('visualization', '1.0', { packages:["timeline"] });
google.setOnLoadCallback(start);

function start() {
  var timelineHolder = document.getElementById("example31");
  var timeline = new google.visualization.Timeline(timelineHolder);
  var dataTable = prepareDataTable();

  var config = {
		backgroundColor: '#FFF',
		//timeline: { singleColor: '#669900' },
		hAxis: {
         // minValue: new Date(0, 0, 0,0,0,0),
          minValue: new Date(<?php echo date('Y', strtotime($date_now)); ?>, <?php echo date('m', strtotime($date_now)); ?>, <?php echo date('d', strtotime($date_now)); ?>,0,0,0),
         // maxValue: new Date(0, 0, 0,23,59,59)
          maxValue: new Date(<?php echo date('Y', strtotime($date_now)); ?>, <?php echo date('m', strtotime($date_now)); ?>, <?php echo date('d', strtotime($date_now)); ?>,23,59,59)
        },
        timeline: { groupByRowLabel: true, 
		            rowLabelStyle: { fontName: 'Helvetica', fontSize: 12, color: '#603913' },
                    barLabelStyle: { fontName: 'Garamond', fontSize: 10 } ,
					showBarLabels: false
				   },
  }

	google.visualization.events.addListener(timeline, 'select', function() {
		valueset = dataTable.getValue(timeline.getSelection()[0].row, 0);
		sendToUrl(valueset);
	});
  
    google.visualization.events.addListener(timeline, 'ready', function () {
	  var rowLabels = timelineHolder.getElementsByTagName('text');
	  Array.prototype.forEach.call(rowLabels, function (label) {
		$(label).css("cursor", "pointer");
		if (label.getAttribute('text-anchor') === 'end') {
		  label.addEventListener('click', displayDetails, false);
		}
	  });
	});
	
    timeline.draw(dataTable, config);
	
	function displayDetails(sender) {
		label = sender.target.innerHTML;
		sendToUrl(label);
	}
	
	function sendToUrl(label){
		baseurl = "<?php echo base_url(); ?>";
		<?php $sl=0; foreach($myteam as $tokend){ $uid = $tokend['user_id']; if($team['chart'][$uid] != ""){ $sl++; } ?>
		 if(label == "<?php echo $sl .". " .$tokend['fullname']; ?>"){ window.open(baseurl + "egaze/individual?uid=" + <?php echo $uid; ?>, '_blank'); }
		<?php } ?>
	}
  
}


function prepareDataTable() {
  var dataTable = new google.visualization.DataTable();

  // Add columns
  dataTable.addColumn({ type: 'string', id: 'Label'});
  dataTable.addColumn({ type: 'string', id: 'Place'});
  dataTable.addColumn({ type: 'string', role: 'style' });
  dataTable.addColumn({ type: 'date', id: 'Arrival Date'});
  dataTable.addColumn({ type: 'date', id: 'Departure Date'});

  //Add Rows
  dataTable.addRows([
  <?php foreach($myteam as $tokend){ $uid = $tokend['user_id']; ?>
	<?php echo $team['chart'][$uid]; ?>
	<?php } ?>
   ]);

  return dataTable;
}
<?php } else { ?>
    document.getElementById('example31').innerHTML = "<h6>-- No Activities Found --</h6>";
<?php } ?>
</script>
<?php } ?>



