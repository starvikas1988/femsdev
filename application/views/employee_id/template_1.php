<!DOCTYPE html>
<html lang="en">
<head>
  <title>Fusion Id</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1"> 
  <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
  <style type="text/css">
  body{
	  margin: 0;
	  padding:0;
	  /*background-image: url('assets/idcard/fusion-bg.jpg');*/
	  background-position: top left;
	  background-repeat: no-repeat;
	  background-image-resize: 4;
	  background-image-resolution: from-image;
  }
  </style>
</head>
<body>
	<div style="max-width:100%;display:block;">
		<div style="width:100%; padding:4em 0 0 0;text-align:center;">
			<img src="<?php echo $id_card; ?>" style="margin:0 auto 30px auto;display:block;border:1px solid #000;max-width:100%;height:130px;" alt="">			
			<h1 style="font-weight:800;font-size:14px;padding:0;margin:0;font-family: 'Montserrat', sans-serif;text-transform:uppercase;letter-spacing:1px;position:absolute;width:280px;height:80px;margin-left:10px">
				<?php echo $agent_details['fname'] ." " .$agent_details['lname']; ?><br>
				<span style="font-size:12px;">(<?php echo $agent_details['fusion_id']; ?>)</span>
			</h1>
						
		</div>
	</div>
</body>
</html>
