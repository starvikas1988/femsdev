<script src="https://code.jscharting.com/latest/jscharting.js"></script>
<script>
/*=============== DEPARTMENT ROLE ================*/
function getchart_department() {

	// FETCH DATA TREE	
	var data = [
		{
			name: "",
			id: "organisation",
			attributes: { 
				position: "FEMS Organisation",
				units: ''
			}, 
			label_style_fontSize: 14, 
			color: '#008080'
		},

		<?php
		$currentcontroller = "super";
		$getpid = "";
		$ij = 0;
		foreach($folder as $token){
			$ij++;
			if($token['name'] != $currentcontroller){ $getpid = $currentcontroller;  }
			
		?>
		{
			name: "",
			id: "<?php echo $token['name']; ?>",
			parent: "organisation",
			<?php if($getpid == "13124"){ ?>
			parent: "<?php echo $getpid; ?>",
			<?php } ?>
			attributes: { 
				position: "<?php echo ucwords($token['name']); ?>",
				units: ''
			}, 
			label_style_fontSize: 14, 
			color: '<?php echo $colordark[$ij]; ?>'
		},
		
		<?php 
		$currentgroup = "";
		foreach($folderd[$token['name']] as $tokeni){
				$currentcontroller = $tokeni['controller'];
				$currentgroup .=  "<li><b>" .ucwords($tokeni['name']) ."</b></li>";
		}
		?>
		{	
			name: "",
			id: "<?php echo $token['name']; ?>_",
			parent: "<?php echo $currentcontroller; ?>",
			attributes: { 
				position: "",
				units: "<ul><?php echo $currentgroup; ?></ul>"
			}, 
			label_style_fontSize: 14,
			color: '<?php echo $colorlight[$ij]; ?>', 
			annotation_label_text: '<div class="units"><b>%units</b></div>' 
		},		
	<?php } ?>   
	];	
		
	// CONFIGURE CHART
	var config = { 
	  type: 'organization down', 
	  defaultPoint: { 
		outline_width: 0, 
		annotation: { asHTML: true, 
		  label: { 
			text: '<div class="department" style="border-bottom:5px solid %color;"><b>%position</b>%name%units</div>', 
			align: 'center'
		  } 
		} 
	  }, 
	  defaultSeries: { mouseTracking_enabled: false, line: { width: 1, color: '#e0e0e0' } }, 
	  series: [ { points: data } ] 
	}; 

	// REPLACE COLOR LI  
	config.series[0].points.forEach(function(point) { 
	  point.attributes.units = point.attributes.units.replace( 
		/<li>/g, 
		'<li style="background-color: %color;">' 
	  ); 
	}); 

	// INITIALIZE CHART
	var chart = JSC.chart('chartDiv', config); 

}

<?php 
if($orgchart == 1){ echo "getchart_department();"; }
?>
</script>