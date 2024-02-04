<!DOCTYPE html>
<html lang="en" >
<head>
<meta charset="UTF-8">
<title>Multi Form Design</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://fonts.googleapis.com/css?family=Poppins:400,600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">  
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/date-picker.css">  
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<style>
		.correct_file
		{
			border: 2px solid #23e123 !important;
		}
		.wrong_file
		{
			border: 2px solid #e12323 !important;
		}
		#other_source_ref_container
		{
			display:none;
		}

		td{
			font-size: 12px;
		}
		.form-control {
			height: unset;
		}
		input[type=file] {
			background: skyblue;
		}

</style>
</head>
<body>
<div class="container">
	<div class="top-main">
		<div class="row" style="border-bottom: 2px solid #b4b4b4;margin-bottom: 20px;">
			<div class="col-sm-4">
				<div class="body-widget">
					<img src="<?php echo base_url(); ?>assets/css/images/fusion-logo.png" class="logo" alt="">
				</div>
			</div>
		</div>	
	</div>
	<div class="row">
		<div class="col-sm-12">
			<form action="" method="" enctype="multipart/form-data">
				<table class="table table-bordered table-striped">
					<thead style="
					    background: skyblue;
					    color: #495057;
					    vertical-align: middle!important;
					    font-size: 14px;
					">
					  <tr>
						<th>Description</th>
						<th>Action</th>
					  </tr>
					</thead>
					<tbody>
					  <tr>

						<td>
							<label>Aadhar Card / Social Security No</label>
						</td>
						<td>
							<input type="file" name="adhar" class="form-control" placeholder="" id="adhar">
						</td>
					  </tr>

					  <tr>
						<td>
							<label>PAN Card</label>
						</td>
						<td>
							<input type="file" name="pan" class="form-control" placeholder="" id="pan">
						</td>
					  </tr>

					  <tr>
						<td>
							<label>Photograph</label>
						</td>
						<td>
							<input type="file" name="photo" class="form-control" placeholder="" id="photo">
						</td>
					  </tr>
<!-- 					  <tr>
						<td>
							<label>Covid-19 Declaration</label>
						</td>
						<td>
							<input type="file" name="covid" class="form-control" placeholder="" id="covid">
						</td>
					  </tr> -->


					</tbody>
				  </table>
				  <button type="submit" class="btn btn-block btn-info">Submit</button>
			</form>			
		</div>
	</div>
</div>

</body>