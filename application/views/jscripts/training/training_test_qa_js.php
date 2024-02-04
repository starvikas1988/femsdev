
<script src="<?php echo base_url(); ?>assets/chartjs/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/chartjs-plugin-datalabels.js"></script>
<script>
var ctxBAR  = document.getElementById("mybarchart");

//------- BARCHART
var myBarChart = new Chart(ctxBAR, {
    type: 'bar',
    data: {
      labels: ["<?php echo $qa_data_label; ?>"],
      datasets: [
        {
          label: "Report",
		  data: [<?php echo $qa_data_value; ?>],
          backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850", "#ffbf00", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
		  borderColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850", "#ffbf00", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
		  borderWidth: 1
        }
      ]
    },
	
    options: {
      legend: { display: false },
      title: {
        display: true,
        text: ''
      },
	  tooltips: {
		callbacks: {
		   label: function(tooltipItem) {
				  return tooltipItem.yLabel + '%';
		   }
		}
	  },
	  maintainAspectRatio: false,
      responsive: true,
	  scales: {
		   xAxes: [{
            gridLines: { color: "rgba(0, 0, 0, 0)", }			
		  }],
		  yAxes: [{
		    gridLines: { color: "rgba(0, 0, 0, 0)", },
			ticks: {
			  callback: function(value, index, values) {
					return value + '%';
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
			return value + '%';
		},
		font: {
		  weight: 'bold'
		}
	  }
	  }	
    },
	
});
</script>