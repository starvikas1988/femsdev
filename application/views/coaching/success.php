<style>
	td{
		font-size:14px;
	}
	
	
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:10px;
	}
	
</style>


<div class="wrap">
	<section class="app-content">
			
		<div class="row">
		
			<div class="col-md-12">
			<div class="widget">
			<header class="widget-header">
			<h4 class="widget-title">Add New User</h4>
			</header>
			<hr class="widget-separator"/>
			<div class="widget-body clearfix">
			
				<center><b>Successfully Saved The User.</b></center>
				<br><br>
				<table class='table'>
					<TR>
						<TD width='150px'>Name:</TD><TD><?php echo $user_name;?></TD>
					</TR>
					<TR>
						<TD>Role:</TD><TD><?php echo $role_name;?></TD>
					</TR>
					<TR>
						<TD>Office Location:</TD><TD><?php echo $office_name;?></TD>
					</TR>
					<TR>
						<TD>Fusion ID:</TD><TD><?php echo $fusion_id;?></TD>
					</TR>
					<TR>
						<TD>OMID:</TD><TD><?php echo $omuid;?></TD>
					</TR>
				</table>
				
			</div>
			</div>
			</div>
		
		</div><!-- .row -->
		<div class="row">
			<div class="col-md-12 text-center">
				<a href='<?php echo base_url();?>users/add'><button type="button" class="btn btn-primary btn-md" id="add_more_user">Add More User</button></a>
				<a href='<?php echo base_url();?>users/manage'><button type="button" class="btn btn-primary btn-md" id="manage_users">Manage Users</button></a>
			</div>
		
		</div><!-- .row -->
		<br><br>
		
</section>
</div>