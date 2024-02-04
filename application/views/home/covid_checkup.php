<div class="wrap">
	<section class="app-content">	
	
	<?php if(!empty($covid_consent_details['id'])){ ?>
	
		<div class="simple-page-wrap" style="width:80%;">
		<div class="simple-page-form animated flipInY">
		<h4 class="form-title m-b-xl text-center">Coronavirus COVID-19 Self Declaration (II)</h4>
				
					
		<div style="padding:10px 10px">
		<p>I, <u>&nbsp;<?php echo get_username(); ?>&nbsp;</u>, identified by the Employee Code <u><?php echo get_user_fusion_id(); ?></u>, 
		<br/><br/><strong>I do hereby submit the following that :</strong></p>
		
		<p style="text-align: left;">
		<ul style="list-style-type: disc;margin-left:20px;">
		<li>I shall strictly adhere to the guidelines/ directives issued by the MHA and/ or State Government in the current pandemic situation; and</li>
		<li>I shall strictly adhere and agree to the guidelines/ instructions issued by National Association of Software and Service Companies (NASSCOM) <!--and Xplore-Tech Services Pvt. Ltd. --> from time to time; and</li>
		<li>I shall adhere to the Social Distancing at workplace; and</li>
		<li>I shall always take necessary precautions towards the health and safety of my colleagues, peers, staff members, external members, etc.; and</li>
		<li>I shall not engage in large gatherings or meetings of 10 or More people at my workplace. However, in case of any unavoidable situation, I shall take written permission from the management and strictly adhere to the directives; and</li>
		<li>I have covered myself under medical insurance; and</li>
		<li>I am not suffering from pre-existing disease such as hypertension, cancer, diabetes, lupus, epilepsy, blood pressure, depression etc. ; and</li>
		<li>I have downloaded Aarogya Setu app on my mobile</li>
		<li>I take full responsibility of any violation of the above guidelines/ directives issued by the Union Home Ministry and/ or State Government and/ or NASSCOM and a strict action can be taken upon such violation;</li>
		</ul>
		</p>
		</div>
		
		<form action="<?php echo base_url('home/covid_check_screening_submit'); ?>" data-toggle="validator" autocomplete="off" method='POST'>
				
		<div class="form-group">
		    <strong>Date & Time :</strong> <?php echo date('d M, Y h:i A', strtotime(GetLocalTime())); ?> <br/><br/>
			
			
			<input type="hidden" value="<?php echo $covid_consent_details['id']; ?>" name="employee_screening_covid_id" id="employee_screening_covid_id" required>
			
			<input type="hidden" value="2" name="covid_submission_type">
			<input type="checkbox" value="1" name="employee_consent" id="employee_consent" style="height:auto" required>
			
			<b>I agree and give my consent for personal data processing and transferring</b>
		</div>
		
		<div class="text-center">
		<input type="submit" style="width:200px" class="btn btn-success" value="Submit" name="submit">
		</div>
		
		</form>

		</div>
		</div>

	<?php } else { ?>
	
		<div class="simple-page-wrap" style="width:80%;">
		<div class="simple-page-form animated flipInY">
		<h4 class="form-title m-b-xl text-center">Coronavirus COVID-19 Self Declaration (I)</h4>
				
					
		<div style="padding:10px 10px">
			
		<p style="text-align: left;"><strong>Purpose: </strong>To ensure the health and safety of all employees returning/ working in the office </p>
		<p style="text-align: left;"><strong>Details : </strong> Details: To ensure health and safety of all employees working in the office, <!--Xplore-Tech Services Pvt Ltd.--> will follow local health department recommendations. <!--Xplore-Tech Services Pvt Ltd. -->requires that every employee be assessed for COVID-19 symptoms and risk factors before joining/ entering our facility. The Declaration must be completed on Joining Date and upon entrance of the building and before entering in to office space. Each employee will be required to show “You are Safe” green code in Aarogya Setu at point of entry. Regardless of survey results, if employees feel that they have symptoms related to COVID-19 he / she should immediately seek guidance from a health professional.</p>
		
		
		<form action="<?php echo base_url('home/covid_check_screening_submit'); ?>" autocomplete="off" method='POST'>
		
		<p style="text-align: center;"><strong>Coronavirus COVID-19 Screening Questionnaire</strong></p>
		
		<div class="row">	
		<div class="col-md-6">
			Name : <input type="text" style="width:60%" id="employee_name" placeholder="" name="employee_name" value="<?php echo get_username(); ?>" readonly required>
		</div>
		<div class="col-md-6">
			Employee ID : <input type="text" style="width:60%" id="employee_id" placeholder="" value="<?php echo get_user_fusion_id(); ?>" name="employee_id" readonly>
		</div>
		
		<div class="col-md-6">
			Date  : <input type="text" style="width:60%" id="employee_date" placeholder="" value="<?php echo GetLocalDate(); ?>" name="employee_date" readonly required>
		</div>
		<div class="col-md-6">
			Phone Number : <input type="text" style="width:60%" id="employee_phone" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  placeholder="" value="<?php echo $personal_row['phone']; ?>" name="employee_phone" 
			<?php if(!empty($personal_row['phone'])){ echo " readonly "; } ?> required>
			<input type="hidden" value="<?php if(empty($personal_row['phone'])){ echo "1"; } else { echo "0"; } ?>" name="phone_number_update">
		</div>
		
		<div class="col-md-6">
			Leader Name : <input type="text" style="width:60%" id="employee_leader" placeholder="" name="employee_leader" value="<?php echo $covid_user_data['l1_supervisor']; ?>"    readonly required>
		</div>
		
		<div class="col-md-6">
			Phone Number : <input type="text" style="width:60%" id="employee_phone_alt" placeholder="" value="<?php echo $covid_user_data['supervisor_phone']; ?>"  name="employee_phone_alt" readonly>
		</div>
		
		<div class="col-md-6">
			  Job Title/Position : <input type="text" style="width:60%" id="employee_job_title" placeholder="" value="<?php echo $covid_user_data['designation']; ?>" name="employee_job_title" readonly>
		</div>
		</div>
		
		<hr/>
		
		<div class="row">
		<div class="col-md-12">
			  Temperature Check : <input type="text" style="width:20%" id="employee_temperature" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  placeholder="" name="employee_temperature"> °F
		</div>
		</div>
		
		<br/><br/>
		
		<div class="row">
		<div class="col-md-7">
			  In the last 30 days have you traveled outside your normal, daily routine ?
		</div>
		<div class="col-md-5">
			  <select class="form-control" name="employee_is_outside" id="employee_is_outside" required>
				  <option value="">Select Option</option>
				  <option value="Y">Yes</option>
				  <option value="N">No</option>
			  </select>
		</div>
		</div>
		
		<br/>
		
		<div class="row">
		<div class="col-md-7">
			  Do you have new or worsening onset of any of the following symptoms: fever, cough, shortness of breath, runny nose, sore throat, chills, body aches, fatigue, headache, loss of taste/smell, eye drainage, and/or congestion ?
		</div>
		<div class="col-md-5">
			  <select class="form-control" name="employee_is_symptom" id="employee_is_symptom" required>
				  <option value="">Select Option</option>
				  <option value="Y">Yes</option>
				  <option value="N">No</option>
			  </select>
		</div>
		</div>
		
		<br/>
		
		<div class="row hide" id="covid_symtomp_found">
		<div class="col-md-7">Enter Symptoms</div>
		<div class="col-md-5">
			  <textarea class="form-control" name="employee_symptoms" id="employee_symptoms"></textarea>
		</div>
		</div>
		
		<br/>
		
		<div class="row">
		<div class="col-md-7">
			  Have you been exposed to someone being tested for COVID-19 or who has symptoms compatible with COVID-19 within the past 14 days? 
		</div>
		<div class="col-md-5">
			  <select class="form-control" name="employee_is_exposed" id="employee_is_exposed" required>
				  <option value="">Select Option</option>
				  <option value="Y">Yes</option>
				  <option value="N">No</option>
			  </select>
		</div>
		</div>
		
		<br/>
		
		<div class="row">
		<div class="col-md-7">
			  Are any members of your household in quarantine, been exposed or diagnosed with COVID-19?
		</div>
		<div class="col-md-5">
			  <select class="form-control" name="employee_is_family_covid" id="employee_is_family_covid" required>
				  <option value="">Select Option</option>
				  <option value="Y">Yes</option>
				  <option value="N">No</option>
			  </select>
		</div>
		</div>
		
		<br/><br/>

		<div class="row">
		<div class="form-group text-cener">
			<b>I understand that I have the responsibility to immediately notify my immediate supervisor/leader should my responses on this questionnaire change. </b>
		</div>
		</div>
		
		<input type="hidden" value="1" name="covid_submission_type">
		<input type="submit" class="btn btn-success" style="width:150px;" value="Submit" name="submit">
		
		</form>
		
		
		</div>

		</div>
		</div>
		
	<?php } ?>	
		
		
</section> 
</div>
