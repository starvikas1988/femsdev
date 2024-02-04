<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Email</title>
	<!-- Latest compiled and minified CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Latest compiled JavaScript -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,500;1,900&display=swap');

		body {

			font-family: 'Roboto', sans-serif;

		}
	</style>
</head>

<body>
	<div class="container" style="box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;width: 700px;padding: 40px;height: 100vh;">
		<div style="margin-bottom: 20px;margin-top: 10px;padding: 0 40px 40px 0px;">
			<img src="https://mindwork.place/fusion/assets/images/fusion-bpo.png" style="width:300px;">
		</div>
		<div style="width:100%;margin-bottom:20px;">
			<h3 style="font-size: 18px;">Dear <span><?php echo $name; ?></span>,</h3>
		</div>
		<div style="width:100%;margin-bottom:20px;">
			<p>Happy <span><?php echo $count; ?></span> work anniversary! We celebrate with you and take pride in your commitment and your accomplishment to excellence. Thank you for all the contributions that you have made over the years in making Fusion BPO successful. We know you will continue to inspire us for many years to come.</p>
		</div>
		<div style="width:100%;margin-bottom:10px ;">
			<p>All the best!</p>
		</div>

		<div style="width:100%;margin-bottom:10px;width: 100%;
text-align: center;
font-size: 10px;
opacity: 0.5;
margin-top: 100px;">
			<p style="margin-bottom:0px;">7F Robinsons Cybergate, Fuente Osmena, Cebu City, Cebu, Philippines</p>
			<p style="margin-bottom:0px;">www.fusionbposervices.com
			</p>
		</div>
	</div>
</body>

</html>