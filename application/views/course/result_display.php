<style>
body {
	font-family: 'Poppins', sans-serif;
}
.body-widget {
	width:100%;
}
.score-area {
	padding:4em 0;
}
.heading-title {
	font-size:22px;
	padding:0 0 10px 0;
	margin:0;
	color:#000;
	font-weight:bold;
	letter-spacing:1px;
}
.score-title {
	width:80px;
	height:80px;
	line-height:80px;
	border-radius:50%;
	border:2px solid #000;
	display:inline-block;
	margin:0 auto;
	font-weight:bold;
	background:#f8b718;
}
.score-content {
	font-size:22px;
	padding:0;
	margin:0;
	color:#000;
	font-weight:bold;
	letter-spacing:1px;
}
.gif-animation {
	width:100%;
}
#score-area .img-fluid {
	margin:20px 0;
}
.main-circle {
	width:400px;
	height:400px;
	max-width:100%;
	border:4px solid #000;
	border-radius:50%;
	margin:0 auto;
	display:flex;
	align-items:center;
}

@media all and (max-width:480px){
	.main-circle {
		height:320px;
	}
	.score-title {
		width:50px;
		height:50px;
		line-height:50px;
		font-size:20px;
	}
}
</style>
<section id="score-area" class="score-area">
		<div class="container">
			<div class="main-circle">
				<div class="body-widget text-center">
					<h1 class="heading-title">Score</h1>
					<h2 class="score-title"><?php echo $attempt_data['scored']; ?></h2>
					<div class="gif-animation">
						<?php if((int)$attempt_data['scored'] >= (int)$attempt_data['pass_marks']){ ?>
							<img src="<?php echo base_url();?>main_img/cup-animation.gif" class="img-fluid" alt="">
						<?php }else{  ?>
							<img src="<?php echo base_url();?>main_img/cup-animation-failed.gif" class="img-fluid" alt="">
						<?php }  ?>
						<h2 class="score-content"><?php echo (int)($attempt_data['scored']) >= (int)($attempt_data['pass_marks']) ? 'PASSED' : 'FAILED'; ?></h2>
					</div>
				</div>
			</div>
		</div>
	</section>	