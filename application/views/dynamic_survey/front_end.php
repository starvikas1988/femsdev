<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/custom-frontend.css"/>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<style>
	/*star rating css here*/
.rating-new {
display: inline-block;
position: relative;
font-size: 20px;
}
.rating-new i {
margin:0 5px 0 0;
}
.rating-new label {
position: absolute;
top: 0;
left: 0;
height: 100%;
cursor: pointer;
}



.rating-new label:last-child {
position: static;
}



.rating-new label:nth-child(1) {
z-index: 5;
}



.rating-new label:nth-child(2) {
z-index: 4;
}



.rating-new label:nth-child(3) {
z-index: 3;
}



.rating-new label:nth-child(4) {
z-index: 2;
}



.rating-new label:nth-child(5) {
z-index: 1;
}



.rating-new label input {
position: absolute;
top: 0;
left: 0;
opacity: 0;
}



.rating-new label .icon {
float: left;
color: transparent;
margin:0 0 0 5px;
border:none;
font-size:20px;
width:auto;
}



.rating-new label:last-child .icon {
color: rgba(0,0,0,0.4);
}



.rating-new:not(:hover) label input:checked ~ .icon,
.rating-new:hover label:hover input ~ .icon {
color:#ffc800;
}



.rating-new label input:focus:not(:checked) ~ .icon:last-child {
color: #000;
text-shadow: 0 0 5px #09f;
}
/***** CSS Magic to Highlight Stars on Hover *****/



.rating-new:not(:checked) > label:hover, /* hover current star */
.rating-new:not(:checked) > label:hover ~ label {
color:#dddd00;
cursor:pointer;
} /* hover previous stars in list */



.rating-new > input:checked + label:hover, /* hover current star when changing rating */
.rating-new > label:hover ~ input:checked ~ label, /* lighten current selection */
.rating-new > input:checked ~ label:hover ~ label {
color:#dddd00 !important;
cursor:pointer;
}
/*end star rating css here*/
</style>
<?php if(!empty($survey_questions)){ ?>
<div class="container">  
	<div style="text-align:center;margin:20px">
		<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal"> Take Survey</button>
	</div>
	<?php if(get_user_office_id() == "CAS" || get_global_access() == '1') { ?>
	<div style="text-align:center;margin:20px">
		<a href="<?=base_url()?>home/dynamic_survey_skip"><button style="background-color: red;border: red;padding: 7px;width: 108px;" type="button" class="btn btn-info btn-lg"> Skip Now</button></a>
	</div>	
<p style="text-align: center;font-size: 15px;font-weight: bolder;">Afin de répondre efficacement à vos besoins et dans le cadre de l’amélioration de nos prestations, nous avons mis en place cette enquête de satisfaction. Toutes les données recueillies restent confidentielles et seront traitées de manière anonyme. Nous vous serions reconnaissants de participer à cette enquête en remplissant ce questionnaire.</p>	
<?php } ?>

  <!-- Modal -->
  <div class="modal fade modal-design modal-big" id="myModal" role="dialog">
    <div class="modal-dialog">
    
    
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>          
        </div>
        <div class="modal-body">
		<div class="header-pop">
				<div class="body-widget text-center">
					<p style="font-size:18px;"><strong><?php echo $survey_questions[0]['survey_name'] ?></strong></p>
				</div>
				<div class="top-pop">
					<div class="top-left">
						<img src="images/fusion-logo.png" class="survey-logo" alt="">
					</div>
					<div class="top-right">					
					</div>
				</div>
			</div>
		  <div class="pop-content-widget">	
			  <div class="row">			
				<div class="col-sm-12">
					<form action="<?php echo base_url(); ?>dynamic_survey/submit_survey" method="POST" autocomplete="off">
					<input name="sid" type="hidden" value="<?php echo $survey_id; ?>"/>
					<?php
					// var_dump($survey_questions);
					$i=1;
					foreach ($survey_questions as $key => $value) { 
						
					$required='';
					$feedback_required = '';
					$star = '';
					$type='';
					$type = $value['type'];
					if (get_user_office_id() == "CAS") {
						if($value['is_mandatory'] == '1') { $required = 'required'; $star = '*'; }
					}
					else {
						if($value['is_mandatory'] == '1') { $required = 'required'; $star = '*'; $feedback_required = 'required';}
					}
					?>
					
					<div class="question-popup-white">
						<h2 class="question-title">
						 <?php echo $value['questions']; ?> <sup style="color:red;font-size:16px;"><?php echo $star; ?></sup>
						</h2>
					  <input name="qid<?php echo $i; ?>" type="hidden" value="<?php echo $value['qid'] ?>"/>
					  <?php 
					  	$name = 'name="q'.$i.'"';
					  ?>
						<div class="common-top">
							<div class="filter-widget">
								<div class="row">
									
									<?php
										if($type == '1'){
									?>
									<div class="col-md-3">
										<div class="form-group">
											<div class="rating-new">
								
												<label>
												<input type="radio" <?php echo $name; ?> value="1" <?php echo $required; ?>/>
												<span class="icon"><i class="fa fa-star" aria-hidden="true"></i></span>
												</label>
												<label>
												<input type="radio" <?php echo $name; ?> value="2" />
												<span class="icon"><i class="fa fa-star" aria-hidden="true"></i></span>
												<span class="icon"><i class="fa fa-star" aria-hidden="true"></i></span>
												</label>
												<label>
												<input type="radio" <?php echo $name; ?> value="3" />
												<span class="icon"><i class="fa fa-star" aria-hidden="true"></i></span>
												<span class="icon"><i class="fa fa-star" aria-hidden="true"></i></span>
												<span class="icon"><i class="fa fa-star" aria-hidden="true"></i></span>
												</label>
												<label>
												<input type="radio" <?php echo $name; ?> value="4" />
												<span class="icon"><i class="fa fa-star" aria-hidden="true"></i></span>
												<span class="icon"><i class="fa fa-star" aria-hidden="true"></i></span>
												<span class="icon"><i class="fa fa-star" aria-hidden="true"></i></span>
												<span class="icon"><i class="fa fa-star" aria-hidden="true"></i></span>
												</label>
												<label>
												<input type="radio" <?php echo $name; ?> value="5" />
												<span class="icon"><i class="fa fa-star" aria-hidden="true"></i></span>
												<span class="icon"><i class="fa fa-star" aria-hidden="true"></i></span>
												<span class="icon"><i class="fa fa-star" aria-hidden="true"></i></span>
												<span class="icon"><i class="fa fa-star" aria-hidden="true"></i></span>
												<span class="icon"><i class="fa fa-star" aria-hidden="true"></i></span>
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-9">
										<div class="body-widget">
											<textarea type="text" class="form-control" id="" name="feedback<?php echo $i; ?>" placeholder="Feedback.." <?php echo $feedback_required; ?>></textarea>
										</div>
									</div>
									<?php }else{ ?>
									<div class="col-md-12">
										<div class="btn-widget">
											<div>
												<input type="radio" <?php echo $name; ?> id="radio1<?php echo $i; ?>" class="radio" value="1" <?php echo $required; ?>/>
												<label for="radio1<?php echo $i; ?>"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> <?php 
												if (get_user_office_id() == "CAS") echo "Pas du tout d'accord";
												else echo "Strongly disagree";
												?></label>
											</div>
		
											<div>
												<input type="radio" <?php echo $name; ?> id="radio2<?php echo $i; ?>" class="radio" value="2"/>
												<label for="radio2<?php echo $i; ?>"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> <?php 
												if (get_user_office_id() == "CAS") echo "Pas d'accord";
												else echo "Disagree";
												?></label>
											</div>

											<div>	
												<input type="radio" <?php echo $name; ?> id="radio3<?php echo $i; ?>" class="radio" value="3"/>
												<label for="radio3<?php echo $i; ?>"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> <?php 
												if (get_user_office_id() == "CAS") echo "Neutre";
												else echo "Neither agree nor disagree";
												?> </label>
											</div>

											<div>	
												<input type="radio" <?php echo $name; ?> id="radio4<?php echo $i; ?>" class="radio" value="4"/>
												<label for="radio4<?php echo $i; ?>"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> <?php 
												if (get_user_office_id() == "CAS") echo "D'accord";
												else echo "Agree";
												?> </label>
											</div>

											<div>	
												<input type="radio" <?php echo $name; ?> id="radio5<?php echo $i; ?>" class="radio" value="5"/>
												<label for="radio5<?php echo $i; ?>"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> <?php 
												if (get_user_office_id() == "CAS") echo "Absolument d'accord";
												else echo "Strongly agree";
												?> </label>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="body-widget">
											<p>Feedback:</p>
											<textarea type="text" class="form-control" id="" name="feedback<?php echo $i; ?>" placeholder="Feedback.." <?php echo $feedback_required; ?>></textarea>
										</div>
									</div>
									
									<?php } ?>							
								</div>
							</div>
						</div>
					</div>
					<?php $i++;}
					?>
					<div class="form-group" style="float:right">
								<button type="submit" class="submit-btn">
									Submit
								</button>
							</div>
					</form>
					
				</div>
			  </div>
		  </div>
        </div>        
      </div> 
      
    </div>
  </div> 
  			
</div>
<?php }else{
	echo  "<p style='text-align:center;padding-top:20px;'>No Survey Exists!</p>";
} ?>
<script>
$(".rating label").click(function(){  
  $(this).css({"color": "#dddd00"});
  $(this).nextAll().css({"color": "#dddd00"});
});
// document.addEventListener("DOMContentLoaded", function() {
//   window.open("https://10.100.21.120/meeshodev/home", "myPopup", 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=120,height=120')
// });
</script>

<script>
	$('#other-field').focus(function() {
  $('#other').prop("checked", true);
});
</script>