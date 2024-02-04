
<script>
$( "#start_date" ).datepicker({maxDate: new Date()});
</script>

<?php if($content_template=="activities/monitoring2.php"){ ?>
<script src='https://cdn.rawgit.com/AdventCoding/Timespace/e24e8fe6/jquery.timespace.js'></script>
<script>  
  $('#timelineClock').timespace({
    selectedEvent: -1,
    data: {
      headings: [
        {start: 0, end: 6, title: 'Night'},
        {start: 6, end: 12, title: 'Morning'},
        {start: 12, end: 18, title: 'Afternoon'},
        {start: 18, end: 24, title: 'Evening'},
      ],
      events: [
	  <?php foreach($myactivities as $token){
			$apname = $token['app_name'];
			$getcolor = $array_color[$apname];
	   ?>
		{
			start: <?php echo str_replace(':', '.', ltrim(date('H:i',strtotime($token['start_datetime'])), 0)); ?>, 
			end: <?php echo str_replace(':', '.', ltrim(date('H:i',strtotime($token['end_datetime'])), 0)); ?>, 
			title: '<?php echo $token['app_name']; ?>', 
			description: '<?php echo $token['window_title']; ?>',
			<?php echo "class : '" .$getcolor ."'"; ?>,
		},
	  <?php } ?>
      ]
    }
  });
</script>
<?php } ?>




<?php if($content_template=="activities/monitoring3.php"){ ?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
<?php if($myactivitieslist != ""){ ?>
  google.charts.load("current", {packages:["timeline"]});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {
    var options = { 
		hAxis: {
          minValue: new Date(0, 0, 0,0,0,0),
          maxValue: new Date(0, 0, 0,23,59,59)
        },
        timeline: { groupByRowLabel: true, 
		            rowLabelStyle: { fontName: 'Helvetica', fontSize: 12, color: '#603913' },
                    barLabelStyle: { fontName: 'Garamond', fontSize: 10 } ,
					showBarLabels: false
				   },
		backgroundColor: '#fff',
	}; 
    var container = document.getElementById('checkactivities');
    var chart = new google.visualization.Timeline(container);
    var dataTable = new google.visualization.DataTable();
    dataTable.addColumn({ type: 'string', id: 'Position' });
    dataTable.addColumn({ type: 'string', id: 'Name' });
    dataTable.addColumn({ type: 'date', id: 'Start' });
    dataTable.addColumn({ type: 'date', id: 'End' });
    dataTable.addRows([
	<?php echo $myactivitieslist; ?>    
	]);

    chart.draw(dataTable, options);
  }
<?php } else { ?>
    document.getElementById('checkactivities').innerHTML = "<h6>-- No Activities Found --</h6>";
<?php } ?>
  

<?php if($myeventslist != ""){ ?>
  google.charts.setOnLoadCallback(drawChartidle);
  function drawChartidle() {
    var options = { 
		hAxis: {
          minValue: new Date(0, 0, 0,0,0,0),
          maxValue: new Date(0, 0, 0,23,59,59)
        },
        timeline: { groupByRowLabel: true, 
		            rowLabelStyle: { fontName: 'Helvetica', fontSize: 12, color: '#603913' },
                    barLabelStyle: { fontName: 'Garamond', fontSize: 10 } ,
					showBarLabels: false
				   },
		backgroundColor: '#fff',
	}; 
    var container = document.getElementById('checkidle');
    var chart = new google.visualization.Timeline(container);
    var dataTable = new google.visualization.DataTable();
    dataTable.addColumn({ type: 'string', id: 'Position' });
    dataTable.addColumn({ type: 'string', id: 'Name' });
    dataTable.addColumn({ type: 'date', id: 'Start' });
    dataTable.addColumn({ type: 'date', id: 'End' });
    dataTable.addRows([
	<?php echo $myeventslist; ?>    
	]);

    chart.draw(dataTable, options);
  }
<?php } else { ?>
    document.getElementById('checkidle').innerHTML = "<h6>-- No Idle Time Found --</h6>";
<?php } ?>
</script>
<?php } ?>



<?php if($content_template=="activities/teammonitoring3.php"){ ?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
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
          minValue: new Date(0, 0, 0,0,0,0),
          maxValue: new Date(0, 0, 0,23,59,59)
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
		 if(label == "<?php echo $sl .". " .$tokend['fullname']; ?>"){ //window.open(baseurl + "activities/monitor2?uid=" + <?php echo $uid; ?>, '_blank'); }
		<?php } ?>
	}
  
}


function prepareDataTable() {
  var dataTable = new google.visualization.DataTable();

  // Add columns
  dataTable.addColumn({ type: 'string', id: 'Label'});
  dataTable.addColumn({ type: 'string', id: 'Place'});
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
</script>
<?php } ?>


<?php if($content_template=="activities/teammonitoring2.php"){ ?> 

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript"> 

   google.charts.load("current", {packages:["timeline"]});
   
  // GET ALL TEAMS
  <?php foreach($myteam as $tokend){ $uid = $tokend['user_id']; ?>
  
    google.charts.setOnLoadCallback(drawChart<?php echo $uid; ?>);
	function drawChart<?php echo $uid; ?>() {
    var options = { 
		hAxis: {
          minValue: new Date(0, 0, 0,0,0,0),
          maxValue: new Date(0, 0, 0,23,59,59)
        },
        timeline: { groupByRowLabel: true, 
		            rowLabelStyle: { fontName: 'Helvetica', fontSize: 12, color: '#603913' },
                    barLabelStyle: { fontName: 'Garamond', fontSize: 10 } ,
					showBarLabels: false
				   },
		backgroundColor: '#fff',
	}; 
    var container = document.getElementById('team<?php echo $uid; ?>');
    var chart = new google.visualization.Timeline(container);
    var dataTable = new google.visualization.DataTable();
    dataTable.addColumn({ type: 'string', id: 'Position' });
    dataTable.addColumn({ type: 'string', id: 'Name' });
    dataTable.addColumn({ type: 'date', id: 'Start' });
    dataTable.addColumn({ type: 'date', id: 'End' });
    dataTable.addRows([
	<?php echo $team['chart'][$uid]; ?>    
	]);

    chart.draw(dataTable, options);
  }
  
  <?php } ?>
  
</script>

<?php } ?>
