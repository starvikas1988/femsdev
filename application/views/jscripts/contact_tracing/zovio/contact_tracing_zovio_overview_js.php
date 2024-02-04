<script>
$('#search_from_date').datepicker({ dateFormat:'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#search_to_date').datepicker({ dateFormat:'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
</script>
<script src="<?php echo base_url(); ?>assets/chartjs/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/chartjs-plugin-datalabels.js"></script>
<script>
<?php
function d_char_escape($text=''){
	$text = addslashes($text);
	$textFinal = str_replace(array("\r\n", "\r", "\n"), "", $text);
	return $textFinal;
}
?>

//==================== OVERVIEW DASHBOARD ====================================================================//
var ctxPIE  = document.getElementById("qa_2dpie_graph_container");
var myLineChart = new Chart(ctxPIE, {
  type: 'pie',
  data: {
    labels: [
	<?php $ij=0; foreach($tableArray as $key=>$val){ $ij++; echo  "'" .$val ." (".$today[$key].")"; echo $ij< count($tableArray)?"'," : "'"; } ?>
	],
    datasets: [
	 { 
        data: [
		<?php $ij=0; foreach($tableArray as $key=>$val){ $ij++; echo  $today[$key]; echo $ij< count($tableArray)? "," : ""; } ?>
		],
        label: "Zovio Overview",
        backgroundColor: [<?php $ij=0; shuffle($randomColors); foreach($tableArray as $token){ echo  "'" .$randomColors[$ij]; $ij++; echo $ij< count($tableArray)?"'," : "'"; } ?>],
     }
    ]
  },
  options: {
    legend: { display: true,position: 'right', },
    title: {
      display: false,
      text: "Zovio Overview"
    },
	tooltips: {
		callbacks: {
        label: function(tooltipItem, data) { 
            var indice = tooltipItem.index;                 
            return  data.labels[indice];
			//+': '+data.datasets[0].data[indice] + ' %';
        }
		}
	 },
	  maintainAspectRatio: false,
	  responsive: true,
	  plugins: {
	  datalabels: {
		  color: '#ffffff',
		//anchor: 'end',
		//align: 'top',
		/*formatter: (value, ctx) => {
			if(value == 0){
			return "";
			} else {
			return value + '%';
			}
		},*/
		font: {
		  weight: 'bold'
		}
	  }
	  }	
  }
});


//==================== OVERVIEW DASHBOARD ====================================================================//
var ctxPIE  = document.getElementById("qa_2dpie_graph_container_loc");
var myLineChart = new Chart(ctxPIE, {
  type: 'pie',
  data: {
    labels: [
	<?php $ij=0; foreach($locationArray as $token){ $ij++; echo  "'" .d_char_escape($token['p_store_location']) ." (".$token['casecounts'].")"; echo $ij< count($locationArray)?"'," : "'"; } ?>
	],
    datasets: [
	 { 
        data: [
		<?php $ij=0; foreach($locationArray as $token){ $ij++; echo  $token['casecounts']; echo $ij< count($locationArray)? "," : ""; } ?>
		],
        label: "Zovio Overview",
        backgroundColor: [<?php $ij=0; shuffle($randomColors); foreach($locationArray as $token){ if($ij > 12){ $ij=0; } echo  "'" .$randomColors[$ij]; $ij++; echo $ij< count($locationArray)?"'," : "'"; } ?>],
     }
    ]
  },
  options: {
    legend: { display: true,position: 'right', },
    title: {
      display: false,
      text: "Zovio Location Cases Overview"
    },
	tooltips: {
		callbacks: {
        label: function(tooltipItem, data) { 
            var indice = tooltipItem.index;                 
            return  data.labels[indice];
			//+': '+data.datasets[0].data[indice] + ' %';
        }
		}
	 },
	  maintainAspectRatio: false,
	  responsive: true,
	  plugins: {
	  datalabels: {
		  color: '#ffffff',
		//anchor: 'end',
		//align: 'top',
		/*formatter: (value, ctx) => {
			if(value == 0){
			return "";
			} else {
			return value + '%';
			}
		},*/
		font: {
		  weight: 'bold'
		}
	  }
	  }	
  }
});



//==================== OVERVIEW DASHBOARD ====================================================================//
var ctxPIE  = document.getElementById("qa_2dpie_graph_container_agent");
var myLineChart = new Chart(ctxPIE, {
  type: 'pie',
  data: {
    labels: [
	<?php $ij=0; foreach($agentsArray as $token){ $ij++; echo  "'" .$token['fullname'] ." (".$token['casecounts'].")"; echo $ij< count($agentsArray)?"'," : "'"; } ?>
	],
    datasets: [
	 { 
        data: [
		<?php $ij=0; foreach($agentsArray as $token){ $ij++; echo  $token['casecounts']; echo $ij< count($agentsArray)? "," : ""; } ?>
		],
        label: "Zovio Overview",
        backgroundColor: [<?php $ij=0; shuffle($randomColors); foreach($agentsArray as $token){ if($ij > 12){ $ij=0; } echo  "'" .$randomColors[$ij]; $ij++; echo $ij< count($agentsArray)?"'," : "'"; } ?>],
     }
    ]
  },
  options: {
    legend: { display: true,position: 'right', },
    title: {
      display: false,
      text: "Zovio Location Cases Overview"
    },
	tooltips: {
		callbacks: {
        label: function(tooltipItem, data) { 
            var indice = tooltipItem.index;                 
            return  data.labels[indice];
			//+': '+data.datasets[0].data[indice] + ' %';
        }
		}
	 },
	  maintainAspectRatio: false,
	  responsive: true,
	  plugins: {
	  datalabels: {
		  color: '#ffffff',
		//anchor: 'end',
		//align: 'top',
		/*formatter: (value, ctx) => {
			if(value == 0){
			return "";
			} else {
			return value + '%';
			}
		},*/
		font: {
		  weight: 'bold'
		}
	  }
	  }	
  }
});

</script>