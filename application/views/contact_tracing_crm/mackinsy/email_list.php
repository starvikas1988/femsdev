<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <title>Mckinsey Mail list</title>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/mckinsey/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/mckinsey/css/style.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/mckinsey/css/custom.css">    
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/mckinsey/css/metisMenu.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">   
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&amp;display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/mckinsey/css/buttons.bootstrap5.min.css">
	
	<!--start summernotes css labraray-->
	<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
	<!--end summernotes css labraray-->
	
</head>

<body>

<div id="page-container">
<div class="header-area">
        <div class="header-area-left">
            <a href="<?php echo base_url() ?>/home" class="logo">
                <img src="<?php echo base_url() ?>assets/mckinsey/images/logo.png" class="logo" alt="">
            </a>
        </div>		
        <div class="row align-items-center header_right">           
               <?php include('menu.php');?>             
            </div>            
        </div>

    </div>
   
    <div class="main-content page-content">
        <div class="main-content-inner">
			<div class="white-area">
				<div class="top-filter">					
					<table id="example" class="table table-striped table-bordered">
						<thead>
						  <tr>
							<th>Situations</th>
							<th>Next steps</th>
							<th>Resources</th>
							<th>Follow-up emails</th>
							<th>Action</th>
						  </tr>
						</thead>
						<tbody>
						<?php
							foreach ($list as $key => $rws) {
							
						?>	
						  <tr>
							<td><?php echo $rws['situations'];?></td>
							<td><?php echo $rws['Next steps'];?></td>
							<td><?php echo $rws['Resources'];?></td>
							<td><?php echo $rws['body'];?></td>
							<td>
								<?php //$rws['body'];?>
								<a href="javascript:void();" onclick="set_data('<?php echo $rws['email_identifier'];?>');" data-bs-toggle="modal" data-bs-target="#myModal" class="editable">
									<i class="fa fa-envelope" aria-hidden="true"></i>
								</a>
							</td>
						  </tr>
						  <?php } ?>	  
						</tbody>
					  </table>
				  </div>
			</div>
		</div>
		
	</div>

<div class="footer-new">
	© Copyright 2022. All right reserved.
</div>

<form nane="frm" id="frm" method="POST" action="<?php echo base_url();?>/mck/update_email">
<!--start mail pop up here-->
<div class="modal fade modal-design mail-widget" id="myModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-envelope-o" aria-hidden="true"></i> Confirmed case email</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
	  <input type="hidden" name="email_identifier" id="email_identifier" value="">
      <!-- Modal body -->
      <div class="modal-body">
		<div class="filter-widget">
			<div class="mb-3">
				<div class="left-mail">To</div>
				<input type="text" class="form-control" placeholder="" id="to_email" name="to_email">
			</div>
			<div class="mb-3">
				<div class="left-mail">Cc</div>
				<input type="text" class="form-control" placeholder="" id="cc_email" name="cc_email">
			</div>
			<div class="mb-3">
				<div class="left-mail">Subject</div>
				<input type="text" class="form-control subject-gap" placeholder="" id="subject" name="subject">
			</div>
			<div class="mb-3">
				<div class="left-mail">Situations</div>
				<textarea name="situations" id="situations" class="form-control"></textarea>
			</div>
			<!--<div class="mb-3">
				<div class="left-mail">Next Steps</div>
				<textarea name="next_steps" id="next_steps" class="form-control"></textarea>
			</div>-->
			<div class="mb-3">
				<div class="left-mail">Resources</div>
				<textarea name="resources" id="resources" class="form-control"></textarea>
			</div>
			<div class="mb-3">
				<div id="summernote"></div>
			</div>
			<button type="button" class="send-btn" id="send_btn" name="send_btn">
				<i class="fa fa-paper-plane" aria-hidden="true"></i> Update
			</button>
		</div>
      </div>
      
    </div>
  </div>
</form>
<!--end mail pop up here-->

<script src="<?php echo base_url() ?>assets/mckinsey/js/jquery.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/metisMenu.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/main.js"></script>

<!--start summernotes js labraray-->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $('#summernote').summernote({
        placeholder: 'Enter Your Message',
        tabsize: 2,
        height: 120,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]
      });
  </script>
<!--js summernotes js labraray-->

<!--start data table library here-->
<script src="<?php echo base_url() ?>assets/mckinsey/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/buttons.bootstrap5.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/jszip.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/vfs_fonts.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/buttons.print.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/buttons.colVis.min.js"></script>

<script>
	$(document).ready(function() {
    var table = $('#example').DataTable( {
        lengthChange: false,
        //buttons: [ 'excel', 'pdf', '', '' ]
		buttons: [ 'excel', '', '', '' ]
    } );
 
    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );
function set_data(id){
	//var  dt=$("#frm").serialize();
  	dt='email_map_id='+id;
  	//console.log(dt);
  	
  	var actionurl = "<?php echo base_url();?>/mck/get_mail";
			$.ajax({
                url: actionurl,
                type: 'post',
                dataType: 'text',
                data: dt,
                success: function(data) {
                	//console.log(data);
                	var rw = jQuery.parseJSON(data);
					$('#email_identifier').val(id);
                	$('#cc_mail').val(rw['cc_email']);
                	$('#subject').val(rw['subject']);
                	//$('#summernote').val(rw['body']);
                	$('#summernote').summernote('code', rw['body']);
                }
        });
}
$('#send_btn').on('click',function(){
  	var  dt=$("#frm").serialize();
  	var email_identifier=$('#email_identifier').val();
  	var sum_note=$('#summernote').summernote('code');
	  sumnote = sum_note.replaceAll("&amp;", " and").replaceAll("&gt;"," ").replaceAll("&lt;"," ");
	
	// $('#send_btn').css('display','none'); 
	//$('#send_info').css('display','inline'); 
  	//summnote=replaceAll(sumnote, "'", '`');
	  
  	dt=dt+'&email_identifier='+email_identifier;
  	dt=dt+'&summernote='+sumnote;
  	
  	var actionurl = "<?php echo base_url();?>/mck/update_email";
			$.ajax({
                url: actionurl,
                type: 'post',
                dataType: 'text',
                data: dt,
                success: function(data) {
					console.log(data);
                	if(data==1){
                		alert('Data Updated Successfully');
                	}
					$('#send_btn').css('display','inline'); 
	 				//$('#send_info').css('display','none');
                	$('#myModal').modal('hide');
                	$('#to_mail').val('');
                	$('#cc_email').val('');
                	$('#subject').val('');
					$('#situations').val('');
					$('#next_steps').val('');
					$('#resources').val('');
                	//$('#summernote').val(rw['body']);
                	$('#summernote').summernote('code', '');
					location.reload();
                }
        });
  }); 	
</script>

<!--end data table library here-->
</body>
</html>