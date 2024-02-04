<div class="wrap">
	<section class="app-content">	
	
	
		<div class="simple-page-wrap" style="width:80%;">
		<div class="simple-page-form animated flipInY">
		<h4 class="form-title m-b-xl text-center">Coronavirus COVID-19 Self Declaration</h4>
				
					
		<div style="padding:10px 10px">
		

		<?php if(empty($covid_consent_details_phil)){ ?>

		<p style="text-align: left;"><strong>As part of our continuous effort to safeguard your health, we will be covering the COVID-19 Vaccination for our employees who wish to be vaccinated. </strong></p>
		<p style="text-align: left;"><strong>*Please note that this is not mandatory. </strong></p>
		
		
		<form action="<?php echo base_url('home/covid_check_screening_submit_phillipines'); ?>" autocomplete="off" method='POST'>
		
		<p style="text-align: center;"><strong>Coronavirus COVID-19 Screening Questionnaire</strong></p>
		
		
		<br/><br/>
		
		<div class="row">
		<div class="col-md-7">
			  Willing to be vaccinated against COVID-19?
		</div>
		<div class="col-md-5">
			  <select class="form-control" name="employee_will_vaccinated" id="employee_will_vaccinated">
				  <option value="">Select Option</option>
				  <option value="Y">Yes</option>
				  <option value="N">No</option>
			  </select>
		</div>
		</div>
		
		<br/>
		
		<br/>
		
		<br/><br/>

		<div class="row">
		<div class="form-group text-cener">
			<b>I understand that I have the responsibility to immediately notify my immediate supervisor/leader should my responses on this questionnaire change. </b>
		</div>
		</div>
		
		<input type="hidden" value="1" name="covid_submission_type">
		<input type="submit" class="btn btn-success" style="width:150px;" value="Submit" name="submit">
		
		</form>
		
		<?php } else { ?>
			<div class="panel panel-default">
			  	<div class="panel-body">
				    
					<div class="row">

					<div class="col-md-12 text-center">
						<div class="form-group">
						  <label for="case"><span class="text-success"><i class="fa fa-check"></i></span> We have received your feedback! Thank you for your submission!</label>
					</div>
					</div>
					
					<div class="col-md-12">	
						<a href="<?php echo base_url('home'); ?>" class="btn btn-success"><i class='fa fa-home'></i> Go to Home</a>
					</div>
					
					</div>
					
				</div>
			</div>
		<?php } ?>
		
		</div>

		</div>
		</div>
		
		
</section> 
</div>
