<!DOCTYPE html>
<html lang="en">
<head>
  <title>Home Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/home_user_survey/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/home_user_survey/css/custom.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/home_user_survey/css/mobile-responsive.css">  
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/home_user_survey/css/animate.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="preconnect" href="https://fonts.gstatic.com">
</head>
<body>

<section id="fusion-middle" class="fusion-middle">
	<div class="logo-widget">
		<a href="#">
			<img src="<?php echo base_url() ?>assets/home_user_survey/images/fusion-logo.png" class="fusion-logo" alt="">
		</a>
	</div>
	
	<div class="manager-widget">
		<img src="<?php echo base_url() ?>assets/home_user_survey/images/bg.png" class="bg-slider" alt="">
	</div>
	
	<div class="middle-widget">	
		<div class="container">
			<div class="body-widget text-center wow fadeInLeft">
				<h2 class="heading-title2">Please click on appropriate button</h2>
				<h1 class="heading-title1"><?php echo $UserSurveyQuestions['question']; ?></h1>
			</div>
			<div class="button-widget">
				
				<input type="hidden" name="ques_id" id='ques_id' value="<?php echo $UserSurveyQuestions['id']; ?>">
								
				<div class="row">
					<div class="col-sm-2">
						<div class="btn-bg wow fadeInLeft">
							<a href="#" ans='Strongly Disagree' class='YourAnswer' >Strongly <br> Disagree</a>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="btn-bg wow fadeInRight">
							<a href="#" ans='Disagree' class='YourAnswer'>Disagree</a>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="btn-bg wow fadeInLeft">
							<a href="#" ans='Neutral' class='YourAnswer' >Neutral</a>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="btn-bg wow fadeInRight">
							<a href="#" ans='Agree' class='YourAnswer'>Agree</a>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="btn-bg wow fadeInLeft">
							<a href="#" ans='Strongly Agree' class='YourAnswer' >Strongly <br> Agree</a>
						</div>
					</div>
				</div>
				
			</div>
			<div class="skip-widget wow fadeInUp">
				<div class="skip-btn wow fadeInRight">
					<a href="<?php echo base_url('home/skipUserSurvey');?>">
						Skip 
						<i class="fa fa-angle-double-right" aria-hidden="true"></i>
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-new">
		<div class="blue-bg"></div>
		<div class="footer-widget">
			<div class="container">
				<div class="body-widget text-center">
					<p>
						Sentiment analysis is extremely useful in monitoring as it allows us to gain an overview of the wider public opinion behind certain topics.
					</p>
				</div>
			</div>
		</div>
	</div>
</section>

<script src="<?php echo base_url() ?>assets/home_user_survey/js/jquery.min.js"></script>
<script src="<?php echo base_url() ?>assets/home_user_survey/js/popper.min.js"></script>
<script src="<?php echo base_url() ?>assets/home_user_survey/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/home_user_survey/js/wow.js"></script>

<script>
	wow = new WOW(
  {
	animateClass: 'animated',
	offset:       100,
	callback:     function(box) {
	  console.log("WOW: animating <" + box.tagName.toLowerCase() + ">")
	}
  }
);
wow.init();


$(".YourAnswer").click(function(){
		
		var ans=$(this).attr("ans");
		var ques_id = $("input[name='ques_id']").val();
		
		if(ans != ""){
		//var r = confirm("Your Mood on Today is "+txt+"\r\nAre You Sure About Your Mood?");
			var r =true;	
			if(r===true){
				var dUrl="<?php echo base_url();?>home/saveUserSurvey";
				$('#sktPleaseWait').modal('show');
				$.ajax({
					type	:	'POST',
					url		:	dUrl,
					data    :   {
					'ans': ans,
					'ques_id' : ques_id
					},
					success	:	function(msg){
						window.location = '<?php echo base_url();?>home';		
					}
				});
			}
		}else{
			alert('Please select your feedback!');
		}
	});
	
</script>
</body>
</html>