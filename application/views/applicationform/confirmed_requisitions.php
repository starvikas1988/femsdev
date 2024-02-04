<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
		<title>Hello, world!</title>
	</head>
	<body style="background: #f0f0f0;">
		<div class="container" style="background: white;border: 3px solid #b4b4b4;border-radius: 4px;">
			<div class="form-group">
			<label for="skills" class="font-weight-bold">Available Positions:</label>
			<table class="table table-bordered">
				<thead class="thead-light">
					<tr class='bg-info'>
						
						<th>Due Date</th>
						<th>Location</th>
						<th>Department</th>
						<th>Position</th>
						<th>Job Title</th>
						<th>Raised By</th>
					</tr>
				</thead>
				<tbody>
					<?php
						//echo '<pre>';
						//print_r($get_requisition);
						$i=1;
						foreach($get_requisition as $key=>$value)
						{
							if($value['requisition_status'] == 'A')
							{
								echo '<tr>';
									
									echo '<td>'.$value['dueDate'].'</td>';
									echo '<td>'.$value['off_loc'].'</td>';
									echo '<td>'.$value['department_name'].'</td>';
									echo '<td>'.$value['role_name'].'</td>';
									echo '<td>'.$value['job_title'].'</td>';
									echo '<td><a href="'.base_url('applicationform/fill/'.$value['requisition_id'].'/'.str_replace('/',' ',$value['job_title']).'/'.$value['id']).'"><button type="button" class="btn btn-block btn-success">Apply</button></a></td>';
								echo '</tr>';
							}
						}
					?>
				</tbody>
			</table>
		</div>
		
		</div>
		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</body>
</html>