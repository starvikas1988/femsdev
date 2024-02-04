<link href="<?=base_url()?>assets/css/search-filter/assets/css/custom.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Schedule -->

<div class="wrap">
<style>
	#OutputDiv{
	
		color:red;
		font-weight:bold;
		font-size:1.1em;
	}
	
	.glowbutton {
	  background-color: #004A7F;
	  -webkit-border-radius: 10px;
	  border-radius: 10px;
	  border: none;
	  color: #FFFFFF;
	  cursor: pointer;
	  display: inline-block;
	  font-family: Arial;
	  font-size: 14px;
	  padding: 5px 10px;
	  text-align: center;
	  text-decoration: none;
	  -webkit-animation: glowing 1500ms infinite;
	  -moz-animation: glowing 1500ms infinite;
	  -o-animation: glowing 1500ms infinite;
	  animation: glowing 1500ms infinite;
	}
	@-webkit-keyframes glowing {
	  0% { background-color: #B20000; -webkit-box-shadow: 0 0 3px #B20000; }
	  50% { background-color: #FF0000; -webkit-box-shadow: 0 0 40px #FF0000; }
	  100% { background-color: #B20000; -webkit-box-shadow: 0 0 3px #B20000; }
	}

	@-moz-keyframes glowing {
	  0% { background-color: #B20000; -moz-box-shadow: 0 0 3px #B20000; }
	  50% { background-color: #FF0000; -moz-box-shadow: 0 0 40px #FF0000; }
	  100% { background-color: #B20000; -moz-box-shadow: 0 0 3px #B20000; }
	}

	@-o-keyframes glowing {
	  0% { background-color: #B20000; box-shadow: 0 0 3px #B20000; }
	  50% { background-color: #FF0000; box-shadow: 0 0 40px #FF0000; }
	  100% { background-color: #B20000; box-shadow: 0 0 3px #B20000; }
	}

	@keyframes glowing {
	  0% { background-color: #B20000; box-shadow: 0 0 3px #B20000; }
	  50% { background-color: #FF0000; box-shadow: 0 0 40px #FF0000; }
	  100% { background-color: #B20000; box-shadow: 0 0 3px #B20000; }
	}
.dt-buttons {
  margin: 0!important;
}
/*.buttons-excel span {
display:none;
}
.buttons-excel:after {
content:"Export";
}*/
.buttons-excel {
  background: #188ae2 !important;
  color: #fff!important;
  border: none;
  text-transform: capitalize;
  box-shadow: none;
  letter-spacing: 1px;
  font-size: 14px;
}
.buttons-excel:focus {
            border:none;
     				background: #188ae2;
     				box-shadow: none;
}
.buttons-excel:active:focus{
box-shadow: none;
}
.buttons-excel:hover {
        border:none;
  			background: #188ae2 !important;
    		box-shadow: none;
   		  color: #fff!important;
  }
  .upload{
	background-color:#188ae2;
	color:#fff;
  }
</style>


<section class="app-content">

<div class="row">
<div class="col-md-12">
<?php if($this->uri->segment($this->uri->total_segments()) == 'error'){ ?>
<div class="alert alert-danger" role="alert">
  ERROR : Something Went Wrong!
</div>
<?php } ?>
<?php if($this->uri->segment($this->uri->total_segments()) == 'success'){ ?>
<div class="alert alert-success" role="alert">
  SUCCESS : Data Uploaded Successfully!
</div>
<?php } ?>
</div>
</div>

<div class="row">
<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title">Call Alert  Upload
<a class="btn btn-primary btn-sm pull-right" target="_blank" href='<?php echo base_url('call_alert/download_sample_log'); ?>'><i class="fa fa-download"></i> Sample Format</a></h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">

<form method="POST" action="<?php echo base_url();?>/call_alert/bulk_uploads_record" enctype="multipart/form-data">

<div class="row">
<div class="col-md-6">
	<div class="form-group" >
	<h4 class="widget-title">Please Select the File to Upload </h4>
	</div>
</div>
</div>

<hr/>
<div class="row">
<div class="col-md-3" style="width:215px;">	
	<div class="form-group" >
		<label for="sedate">Upload File</label>
	</div>
</div>

<div class="col-md-3" style="width:215px;">	
	<div class="form-group" >
		<input type="file" name="userfile" accept=".xlsx" required>
		<input type="hidden" name="upload_file" value="1">
	</div>
</div>
</div>
<div class="row">
<div class="col-md-3" style="width:215px;">	
	<div class="form-group" >
		<button type="submit" name="uploadSchedule" class="btn btn-danger1 upload">Upload</button>
	</div>
</div>
</div><!-- .row -->
</form>
</div>
</div>
</div>



<?php if(!empty($uploadData)){ ?>
<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title">Download Log
<!--<a class="btn btn-primary btn-sm pull-right" target="_blank" href='<?php echo base_url('cns/download_upload_log'); ?>'><i class="fa fa-download"></i> Export Log</a>--->

</h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">
<div class="table-responsive">
	<table id="example" class="table table-striped skt-table" cellspacing="0" width="100%">
		<thead>
			<tr class='bg-info'>
				<th>SL</th>
				<th>Date</th>
				<th>type</th>
				<th>location</th>
				<th>Email IDs</th>
				<th>Notification Days</th>
				<th>Notification Time</th>
				<th>Supervisor's Email</th>
				<th>Supervisor's Notication Days</th>
				<th>Supervisor's Notication Time</th>
				<th>Duration</th>
				<th>Duration Type</th>
				<th>Comment</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$counter=0;
			foreach($uploadData['csv'] as $row){ 
				$counter++;
				$classCheck = "";
				if($row['status'] == 'error'){
					$classCheck = "style='background-color:#fbd1d1'";
				}
				if($row['status'] == 'success'){
					$classCheck = "style='background-color:#d2ffd3'";
				}
				if($row['status'] == 'Duplicate Entry'){
					$classCheck = "style='background-color:#eba134'";
				}
			?>
			<tr <?php echo $classCheck; ?>>
				<td><?php echo $counter; ?></td>
				<td><?php echo $row['call_alert_date']; ?></td>
				<td><?php echo $row['type']; ?></td>
				<td><?php echo $row['location']; ?></td>
				<td><?php echo $row['emails']; ?></td>
				<td><?php echo $row['notification_days']; ?></td>
				<td><?php echo $row['notification_time']; ?>
				<td><?php echo $row['emails1']; ?></td>
				<td><?php echo $row['notification_days1']; ?></td>
				<td><?php echo $row['supervisor_notification_time']; ?>
				<td><?php echo $row['duration']; ?>
				<td><?php echo $row['duration_type']; ?>
				<td><?php echo $row['Comment']; ?></td>
				<td><?php echo $row['status']; ?></td>
				
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
</div>
</div>
</div>
<?php } ?>


</div><!-- .row -->

</section>

</div><!-- .wrap -->

				<script src="<?=base_url()?>assets/css/assets/js/jquery.dataTables.min.js"></script>
         <script src="<?=base_url()?>assets/css/assets/js/dataTables.bootstrap5.min.js"></script>
         <script src="<?=base_url()?>assets/css/assets/js/dataTables.buttons.min.js"></script>
         <script src="<?=base_url()?>assets/css/assets/js/buttons.bootstrap5.min.js"></script>
         <script src="<?=base_url()?>assets/css/assets/js/jszip.min.js"></script>
         <script src="<?=base_url()?>assets/css/assets/js/pdfmake.min.js"></script>
         <script src="<?=base_url()?>assets/css/assets/js/vfs_fonts.js"></script>
         <script src="<?=base_url()?>assets/css/assets/js/buttons.html5.min.js"></script>
          <script src="<?=base_url()?>assets/css/assets/js/buttons.print.min.js"></script>
          <script src="<?=base_url()?>assets/css/assets/js/buttons.colVis.min.js"></script>
          <script>
//         $(document).ready(function() {
//     var table = $('#example').DataTable( {
//         lengthChange: false,
//         buttons: [ 'excel' ]
//     } );
 
//     table.buttons().container()
//         .appendTo( '#example_wrapper .col-md-6:eq(0)' );
// } );

$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
           
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-cloud-download" aria-hidden="true"></i>',
                titleAttr: 'Excel'
            }
           
        ]
    } );
} );
        </script>


