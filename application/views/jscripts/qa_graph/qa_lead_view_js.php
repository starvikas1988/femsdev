
<!--<script src="<?php echo base_url(); ?>assets/highchartjs/highcharts.js"></script>
<script src="<?php echo base_url(); ?>assets/highchartjs/highcharts-3d.js"></script>-->

<script src="<?php echo base_url(); ?>assets/chartjs/Chart.js"></script>
<script src="<?php echo base_url(); ?>assets/chartjs/chartjs-plugin-datalabels.js"></script>


<script>
$(document).ready(function() {

<?php if($this->input->get('submitgraph')){ ?>
$('#select_process').val('<?php echo $selected_process; ?>');
$('#select_office').val('<?php echo $selected_office; ?>');
<?php } ?>



});
</script>