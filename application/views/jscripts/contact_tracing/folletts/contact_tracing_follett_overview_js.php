<script>
$('#search_from_date').datepicker({ dateFormat:'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
$('#search_to_date').datepicker({ dateFormat:'mm/dd/yy', changeMonth: true, changeYear: true, yearRange: '1940:' + new Date().getFullYear().toString() });
</script>
<script src="<?php echo base_url(); ?>assets/chartjs/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/chartjs-plugin-datalabels.js"></script>
<script>
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
        label: "K2 Claims Overview",
        backgroundColor: [<?php $ij=0; shuffle($randomColors); foreach($tableArray as $token){ echo  "'" .$randomColors[$ij]; $ij++; echo $ij< count($tableArray)?"'," : "'"; } ?>],
     }
    ]
  },
  options: {
    legend: { display: true,position: 'right', },
    title: {
      display: false,
      text: "K2 Claims Overview"
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