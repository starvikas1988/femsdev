<?php  
	//echo'<br>'.$file_url = end(explode('/', $_SERVER['REQUEST_URI']));
?>
<nav class="navbar navbar-default">
	<ul class="nav navbar-nav">

		<?php if (get_dept_folder() == "wfm" || get_dept_folder() == "rta" || get_import_dailer()) { ?>
			<li><a href="<?php echo base_url('ar_data_impoter/attendance_mapped_data_import/'); ?>" target="_blank">Import Data</a></li>
		<?php
		}

		if (get_role_dir() != "agent" || rta_permission()) {
		?>
			<li><a href="<?php echo base_url('attendance_reversal'); ?>">My Attendance Reversal</a></li>

			<li><a href="<?php echo base_url('attendance_reversal/approval'); ?>">Attendance Approval</a></li>

		<?php }

		/*if (rta_permission()) {
		?>
			<li><a href="<?php echo base_url('attendance_reversal/rta_validation'); ?>">RTA Validation</a></li>
			<li><a href="<?php echo base_url('attendance_reversal/rta_validation_all'); ?>">RTA Validation all </a></li>

		<?php
		}*/
		if((get_sub_user_count(get_user_id())==true) && (get_role_dir() != "agent")){
		?>
		<li><a href="<?php echo base_url('attendance_reversal/l2_approval'); ?>">L2 Approval</a></li>
		<?php }if (rta_permission()) { ?>
		<li><a href="<?php echo base_url('attendance_reversal/rta_validation_all'); ?>">Reversal Histroy</a></li>
		<?php } if (ar_report_access()) {

		?>

			<li><a href="<?php echo base_url('ar_reports/'); ?>" target="_blank">Reports</a></li>

		<?php } ?>


	</ul>
</nav>
<script>
	$(function(){
    // this will get the full URL at the address bar
    var url = window.location.href; 
    // passes on every "a" tag 
    $(".navbar-default a").each(function() {
            // checks if its the same on the address bar
			//alert(this.href);
        if(url == (this.href)) { 
            $(this).closest("li").addClass("active");
        }
    });
});
</script>