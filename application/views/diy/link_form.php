<style>
p.chatquote{
	background-color: #fbfbfb;
    font-size: 12px;
    padding: 5px 14px;
    line-height: 1.3em;
}
p.chatimp{
	background-color:#f3e8e8;
}
</style>

<div class="wrap">
	<section class="app-content">
		<div class="widget">
			<div class="widget-body">	

			  <h4>Send New Joining Link / Registration Link</h4>
			  <hr/>
			  <?php 
					if($this->session->flashdata('response')){
			  		echo $this->session->flashdata('response');
					  if(isset($_SESSION['response'])){
						unset($_SESSION['response']);
					}
					}
			  ?>
				<form id="" method="post" action="<?php echo base_url('diy/send_diy_add_link');?>">
					
					
					<div class="panel panel-default">
					  <div class="panel-heading">Basic Information</div>
						  <div class="panel-body">
								

							
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
									  <label for="case">Email ID : </label>
									  <input type="email" class="form-control" id="email" value="" placeholder="" name="email" required>
									</div>
								</div>	
								<div class="col-md-4">
									<div class="form-group">
									  <label for="case">First Name : </label>
									  <input type="text" class="form-control" id="fname" value="" placeholder="" name="fname" required>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
									  <label for="case">Last Name : </label>
									  <input type="text" class="form-control" id="lname" value="" placeholder="" name="lname" required>
									</div>
								</div>
							</div>
								<input id="sub_btn" class="btn btn-success waves-effect" type="submit" value="Send Link in Mail">
							
						
					    </div>
<!-- 
					    <div class="panel-footer">
					    	
					    </div> -->

					</div>
				
				</form> 
		 
		   </div>
	  </div>

	<section>
</div>


<script type="text/javascript">


	$(document).on('focusout','#email',function()
			{
				// showPleaseWait();

				var email = $(this).val();
				
				  	if(email.length > 0)
					{
						
						var datas = {'email':email};
						console.log(datas);
						$.ajax({
							type	:	'POST',
							url		:	'<?php echo base_url('diy/check_email_exist'); ?>',
							data	:	datas,
							success	:	function(msg){
									// hidePleaseWait();
								
								var msg = JSON.parse(msg);
									if(msg.error == 'true')
									{
											alert('Email ID is already registered.');
											$('#email').val('');
									}
								}
						});
					}

				//alert(email.length);
				
			});
</script>
