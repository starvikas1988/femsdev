<script type="text/javascript">
	// $(window).on('beforeunload', function(){
	// 	//return 'Are you sure you want to leave this page?';
	// 	if (confirm('Are you sure you want to leave this page?')) {
	// 		window.history.back();
	// 	}
	// });

	//window.addEventListener('beforeunload', function(event) { event.preventDefault(); event.returnValue = ''; return 'Are you sure you want to leave this page?'; });

	/*jQuery(document).ready(function($) {
		if (window.history && window.history.pushState) {
			window.history.pushState('forward', null, './#forward');
			$(window).on('popstate', function() {
				//alert('Back button was pressed.');
				if (confirm('Are you sure you want to leave this page?')) {
					window.history.back();
				}
			});
		}
	});*/

	// history.pushState(null, null, window.location.href);
	// history.back(-1);
	// window.onpopstate = () => history.forward();

	//history.pushState(null, null, location.href); window.onpopstate = function(event) { history.go(1); }; //working in firefox

	window.onbeforeunload = function() { return false; };
	



// function HandleBackFunctionality()
// {
// 	if(window.event)
// 	{
// 		if(window.event.clientX < 40 && window.event.clientY < 0)
// 		{
// 		//alert("Browser back button is clicked...");
// 		//window.history.forward();
// 		return "Your work will be lost.";
// 		}
// 		else
// 		{
// 		//alert("Browser refresh button is clicked...");
// 		return "Your work will be lost.";
// 		}
// 	}
// 	else
// 	{
// 		if(event.currentTarget.performance.navigation.type == 1)
// 		{
// 		//alert("Browser refresh button is clicked...");
// 		return "Your work will be lost.";
// 		}
// 		if(event.currentTarget.performance.navigation.type == 2)
// 		{
// 		//alert("Browser back button is clicked...");
// 		return "Your work will be lost.";
// 		}
// 	}
// }

</script>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body onbeforeunload="HandleBackFunctionality();">

<div id="container">
	<h1>Welcome to CodeIgniter!</h1>

	<div id="body">
		<p>The page you are looking at is being generated dynamically by CodeIgniter.</p>

		<p>If you would like to edit this page you'll find it located at:</p>
		<code>application/views/welcome_message.php</code>

		<p>The corresponding controller for this page is found at:</p>
		<code>application/controllers/Welcome.php</code>

		<p>If you are exploring CodeIgniter for the very first time, you should start by reading the <a href="user_guide/">User Guide</a>.</p>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>