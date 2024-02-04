<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <title>McKinsey Entry From</title>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/mckinsey/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/mckinsey/css/style.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/mckinsey/css/custom.css">    
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/mckinsey/css/metisMenu.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">   
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&amp;display=swap" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/mckinsey/css/dataTables.bootstrap5.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/mckinsey/css/buttons.bootstrap5.min.css">
	
	<!--start summernotes css labraray-->
	<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
	<!--end summernotes css labraray-->
	
</head>

<body>

<div id="page-container">
    <div class="header-area">
        <div class="header-area-left">
            <a href="<?php echo base_url() ?>/home" class="logo">
                <img src="<?php echo base_url() ?>assets/mckinsey/images/logo.png" class="logo" alt="">
            </a>
        </div>
		<!--start mobile logo -->
		<div class="mobile-logo-new">
			<a href="<?php echo base_url() ?>/home" class="logo">
                <img src="<?php echo base_url() ?>assets/mckinsey/images/side-logo.png" class="logo" alt="">
            </a>
		</div>
		<!--end mobile logo -->
		
        <div class="row align-items-center header_right">           
                 <?php include('menu.php');?>             
            </div>            
        </div>

    </div>
   
    <div class="main-content page-content">
        <div class="main-content-inner">
			<div class="top-bg">
				<div class="row">
					<div class="col-md-9">
					   <div class="elements-left">
							<i class="fa fa-ticket" aria-hidden="true"></i>
					   </div>
					   <div class="elements-left">
							<h3 class="small-heading">
								COVID-19 Case
							</h3>
							<p><?php echo ucfirst($incident_id);?></p>
							<input type="hidden" name="case_id" value="<?php echo $incident_id;?>">
							<input type="hidden" name="current_state" id="current_state" value="readonly">
					   </div>
					</div>
					<div class="col-md-3">
						<div class="top-right">
						   <nav aria-label="Page navigation example">
						   <span id="open_case" style="<?php echo ($case_list[0]['status']=='C')?'display:none':'';?>"> 
							  <ul class="pagination">
									<li class="page-item"><a class="page-link" onclick="open_edit_form()" style="cursor: pointer;">Edit</a></li>
								
									<li class="page-item"><a class="page-link" style="cursor: pointer;" onclick="close_case('<?php echo $incident_id;?>');">Close Case</a></li>
								<!--<li class="page-item"><a class="page-link" href="<?php echo base_url() ?>mac/case/Deleted">Delete</a></li>-->
									<li id="update_btn" class="page-item" style="display: none"><a class="page-link" id="update_data" style="cursor: pointer;">Update</a></li>
							  </ul>
							  </span>
							  <span id="close Case" style="<?php echo ($case_list[0]['status']=='C')?'':'display:none';?>;color:red;">
									Case Closed
							 </span>	
							</nav>
						</div>
					</div>
				</div>
			</div>
			<form name="edit_frm" methode="post" id="edit_frm">
            <div class="row">
				<div class="col-sm-9">
					<div class="accordian-widget">
						<div class="accordion" id="accordionExample">
						  <div class="accordion-item">
							<h2 class="accordion-header" id="headingOne">
							  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
								Person Information
							  </button>
							</h2>
							<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
							  <div class="accordion-body">
								<div class="repeat-widget">
									<div class="row">
										<div class="col-sm-6">
											<div class="search-main">
												<div class="mb-3 row">
													<label class="col-sm-5 col-form-label no-padding">
														Name <!--<span class="req">*</span>-->
														<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Person Name">
														<i class="fa fa-question-circle" aria-hidden="true"></i>
													 </a>
													</label>
													<div class="col-sm-7">
													  <div class="has-search">
														<input type="hidden" name="incident_id" id="incident_id" class="form-control" value="<?php echo $incident_id;?>">
														<input type="text" name="person" id="person" value="<?php echo $case_list[0]['name'];?>" class="form-control" onkeydown="return (event.keyCode>=65 && event.keyCode<=90 || event.keyCode==32 || event.keyCode==8 || event.keyCode==110);"  disabled="disabled">
													  </div>
													</div>
												 </div>
											 </div>
											 <div class="search-main">
												 <div class="mb-3 row">
													<label class="col-sm-5 col-form-label no-padding">
														Phone# <!--<span class="req">*</span>-->
														<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="What is your preferred phone #?">
														<i class="fa fa-question-circle" aria-hidden="true"></i>
													 </a>
													</label>
													<div class="col-sm-7">
													  <input type="number" name="phone" class="form-control" id="phone"  value="<?php echo $case_list[0]['phone'];?>" disabled="disabled">
													</div>
												 </div>
											 </div>
											 <div class="search-main">
												 <div class="mb-3 row">
													<label class="col-sm-5 col-form-label no-padding">
														Email <!--<span class="req">*</span>-->
														<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Is your email first_last@mckinsey.com">
														<i class="fa fa-question-circle" aria-hidden="true"></i>
													 </a>
													</label>
													<div class="col-sm-7">
													  <input type="email" name="email" class="form-control" id="email"  value="<?php echo $case_list[0]['email'];?>" disabled="disabled">
													</div>
												 </div>
											 </div>
											 <div class="search-main">
												 <div class="mb-3 row">
													<label class="col-sm-5 col-form-label no-padding">
														City <!--<span class="req">*</span>-->
														<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="What city/state are you in?">
														<i class="fa fa-question-circle" aria-hidden="true"></i>
													 </a>
													</label>
													<div class="col-sm-7">
													  <input type="text" name="city" class="form-control" value="<?php echo $case_list[0]['city'];?>" id="city"  disabled="disabled">
													</div>
												 </div>
											 </div>
										</div>
										<div class="col-sm-6">
											<div class="search-main">
												<div class="mb-3 row">
													<label class="col-sm-5 col-form-label no-padding">
														Communication <!--<span class="req">*</span>-->
														<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="What is your preferred communication?">
														<i class="fa fa-question-circle" aria-hidden="true"></i>
													 </a>
													</label>
													<div class="col-sm-7">
													  <select name="communication" id="communication" class="form-control"  disabled="disabled">
														<option value=""> select </option>
														<option value="email" <?php echo($case_list[0]['communication']=="email")?'selected="selected"':'';?>>Email</option>
														<option value="phone" <?php echo($case_list[0]['communication']=="phone")?'selected="selected"':'';?>>Phone</option>
														<option value="text" <?php echo($case_list[0]['communication']=="text")?'selected="selected"':'';?>>Text</option>
													</select>
													</div>
												 </div>
											 </div>
											 <div class="search-main">
												 <div class="mb-3 row">
													<label class="col-sm-5 col-form-label no-padding">
														FMNO <!--<span class="req">*</span>-->
														<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="What is your Firm Member  # (FMNO)">
														<i class="fa fa-question-circle" aria-hidden="true"></i>
													 </a>
													</label>
													<div class="col-sm-7">
													  <input type="text" name="fmno" class="form-control" id="fmno"  value="<?php echo $case_list[0]['fmno'];?>" disabled="disabled">
													</div>
												 </div>
											 </div>
											 <div class="search-main">
												 <div class="mb-3 row">
													<label class="col-sm-5 col-form-label no-padding">
														Location <!--<span class="req">*</span>-->
														<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Where are you located right now?">
														<i class="fa fa-question-circle" aria-hidden="true"></i>
													 </a>
													</label>
													<div class="col-sm-7">
													  <select name="location" id="location" class="form-control"  disabled="disabled">
														<option value=""> Select </option>
														<option value="home" <?php echo($case_list[0]['location']=="home")?'selected="selected"':'';?>>Home</option>
														<option value="hotel" <?php echo($case_list[0]['location']=="hotel")?'selected="selected"':'';?>>Hotel</option>
														<option value="hospital" <?php echo($case_list[0]['location']=="hospital")?'selected="selected"':'';?>>Hospital</option>
														<option value="other" <?php echo($case_list[0]['location']=="other")?'selected="selected"':'';?>>Other</option>
													</select>
													</div>
												 </div>
												 <!--start for others-->
											 <div class="mb-3 row">
											 <label class="col-sm-5 col-form-label no-padding"></label>
												<div class="col-sm-7">
													<div id="other_loc_div" class="other-widget other_loc_div" style="display: none;">
														<input type="text" class="form-control" id="other_location" name="other_location" value="<?php echo $case_list[0]['other_location'];?>">
													</div>
												</div>
											</div>
											<!--end for others-->
											 </div>
											 <div class="search-main">
												 <div class="mb-3 row">
													<label class="col-sm-5 col-form-label no-padding">
														Country <!--<span class="req">*</span>-->
														<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="What country are you in presently? (If not known from 'Location')">
														<i class="fa fa-question-circle" aria-hidden="true"></i>
													 </a>
													</label>
													<div class="col-sm-7">
													  <select name="country" id="country" class="form-control"  disabled="disabled">
														<option value=""> Select </option>
														<?php foreach($country_list as $key=>$row){ ?>
														<option value="<?php echo $row['id'];?>" <?php echo ($case_list[0]['country']==$row['id'])?'selected="selected"':'';?>><?php echo $row['name'];?></option>
														<?php } ?>
													</select>
													</div>
												 </div>
											 </div>
										</div>																																	
									</div>
								</div>
							  </div>
							</div>
						  </div>
						  <div class="accordion-item">
							<h2 class="accordion-header" id="headingTwo">
							  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
								Basic Information
							  </button>
							</h2>
							<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
							  <div class="accordion-body">
								<div class="repeat-widget">
									<div class="row">
										<div class="col-sm-6">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													Case Manager <!--<span class="req">*</span>-->
												</label>
												<div class="col-sm-7">
												  <div class="has-search">
													<input name="case_manager" id="case_manager" type="text" class="form-control" value="<?php echo $case_list[0]['case_manager'];?>"  disabled="disabled">
												  </div>
												</div>
											 </div>
										</div>
										<div class="col-sm-6">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													Assess situation <span class="req">*</span>
													<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Type of case, to determine appropriate guidance">
													<i class="fa fa-question-circle" aria-hidden="true"></i></a>
												</label>

												<div class="col-sm-7">
												  <select id="assess_situation" name="assess_situation" required="required" class="form-control" disabled="disabled">
												  	<option value=""> Select </option>
													<option value="Confirmed" <?php echo($case_list[0]['assess_situation']=="Confirmed")?'selected="selected"':'';?>>Confirmed</option>
													<option value="Suspect" <?php echo($case_list[0]['assess_situation']=="Suspect")?'selected="selected"':'';?>>Suspect</option>
													<option value="Close contact & what type" <?php echo($case_list[0]['assess_situation']=="Close contact & what type")?'selected="selected"':'';?>>Close contact & what type,</option>
													<option value="Other" <?php echo($case_list[0]['assess_situation']=="Other")?'selected="selected"':'';?>>Other</option>
												</select>
												</div>
											 </div>
										</div>
										<div class="col-sm-6">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													Assumed Location of exposure <!--<span class="req">*</span>-->
													<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Office, or Client Site (based on whether they were notified of exposure or not)">
													<i class="fa fa-question-circle" aria-hidden="true"></i>
												 </a>
												</label>
												<div class="col-sm-7">
												  <select name="assumed_location_exposure" id="assumed_location_exposure" class="form-control"  disabled="disabled">
												  	<option value=""> Select </option>
													<option value="community" <?php echo($case_list[0]['assumed_location_exposer']=="community")?'selected="selected"':'';?>>Community</option>
													<option value="personal" <?php echo($case_list[0]['assumed_location_exposer']=="personal")?'selected="selected"':'';?>>Personal</option>
													<option value="Unknown" <?php echo($case_list[0]['assumed_location_exposer']=="Unknown")?'selected="selected"':'';?>>Unknown</option>
													<option value="Mck Office" <?php echo($case_list[0]['assumed_location_exposer']=="Mck Office")?'selected="selected"':'';?>>Mck Office</option>
													<option value="Client Office" <?php echo($case_list[0]['assumed_location_exposer']=="Client Office")?'selected="selected"':'';?>>Client Office</option>
												</select>
												</div>
											 </div>
										</div>
										<div class="col-sm-6">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													Impacted Mck Office <!--<span class="req">*</span>-->
													<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="If colleague was in a McKinsey office in 48 hours prior to symptoms / COVID + test, name of Office Managing Partner (OMP)">
													<i class="fa fa-question-circle" aria-hidden="true"></i>
												 </a>
												</label>
												<div class="col-sm-7">
												  <div class="has-search">
												  <select name="home_office_lmp" id="home_office_lmp" class="form-control" disabled="disabled">
												  	<option value=""> Select </option>
												  	<?php 
												  	foreach($office_loc as $key=>$rws){ 
												  	?>
												  	<option value="<?php echo $rws['location'];?>" <?php echo($rws['location']==$case_list[0]['home_office_lmp'])?'selected="selected"':'';?>><?php echo $rws['location'];?></option>
												  	<?php } ?>
												  </select>				
													<!--<input type="text" name="home_office_lmp" id="home_office_lmp" class="form-control" value="<?php echo $case_list[0]['home_office_lmp'];?>" disabled="disabled">-->
												  </div>
												</div>
											 </div>
										</div>
										<div class="col-sm-6">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													Date McKinsey notified <!--<span class="req">*</span>-->
												</label>
												<div class="col-sm-7">
												  <input type="date" class="form-control" name="date_mck_notified" id="notified" value="<?php echo $case_list[0]['date_mck_notified'];?>"  disabled="disabled">
												</div>
											 </div>
										</div>
										<div class="col-sm-6">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													Contact status
													<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Have you been notified that you were a close contact to a case of COVID-19?">
													<i class="fa fa-question-circle" aria-hidden="true"></i>
												 </a>
												</label>
												<div class="col-sm-7">
												  <select id="contact_status" name="contact_status" class="form-control" disabled="disabled">
												  	<option value=""> Select </option>
													<option value="known" <?php echo($case_list[0]['contact_status']=="known")?'selected="selected"':'';?>>Known</option>
													<option value="Close contact exposure" <?php echo($case_list[0]['contact_status']=="Close contact exposure")?'selected="selected"':'';?>>Close contact exposure</option>
													<option value="None" <?php echo($case_list[0]['contact_status']=="None")?'selected="selected"':'';?>>None</option>
												</select>
												</div>
											 </div>					
										</div>
										<div class="col-sm-6">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
												<input class="form-check-input" type="checkbox" value="Yes" id="symptom_onset" name="symptom_onset" <?php echo ($case_list[0]['date_of_symptom_onset']!="")?'checked="checked"':'';?> onclick="active_onset('date_of_symptom_onset');" disabled="disabled">
													
												</label>
												<div class="col-sm-7">
												<label>	
												  Symptom status 
												</label>  
												</div>
											 </div>
										</div>
										<div class="col-sm-6">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
												<input class="form-check-input" type="checkbox" value="Yes" id="test_result" name="test_result" checked="checked" onclick="active_positive_test('positive_test_date');" <?php echo ($case_list[0]['positive_test_date']!="")?'checked="checked"':'';?> disabled="disabled">
													
												</label>
												<div class="col-sm-7">
												<label>	
												  Test result 
												</label>  
												</div>
											 </div>
										</div>
										<div class="col-sm-6">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													Date of symptom onset <span id="date_of_symptom_onset_req" class="req">*</span>
													<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Need option if no symptoms (since marked as 'mandatory' or make not mandatory field)">
													<i class="fa fa-question-circle" aria-hidden="true"></i>
												 </a>
												</label>
												<div class="col-sm-7">
												  <input type="date" class="form-control" id="date_of_symptom_onset" name="date_of_symptom_onset" value="<?php echo $case_list[0]['date_of_symptom_onset'];?>" required="required" disabled="disabled">
												</div>
											 </div>
										</div>
										<div class="col-sm-6">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													Positive test date <span id="positive_test_date_req" class="req">*</span>
													<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Need option if no positive test (since marked as 'mandatory' or make not mandatory field)">
													<i class="fa fa-question-circle" aria-hidden="true"></i>
												 </a>
												</label>
												<div class="col-sm-7">
												  <input type="date" class="form-control" name="positive_test_date" id="positive_test_date" value="<?php echo $case_list[0]['positive_test_date'];?>" required="required" disabled="disabled">
												</div>
											 </div>
										</div>
										
										<div class="col-sm-6">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
												Isolation/quarantine start date <!--<span class="req">*</span>-->
												<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Date of symptom onset OR positive test date (date test performed) if no symptoms.)">
													<i class="fa fa-question-circle" aria-hidden="true"></i>
												 </a>
												</label>
												<div class="col-sm-7">
												  <input type="date" class="form-control" id="self_isolated_start_date" name="self_isolated_start_date"  value="<?php echo $case_list[0]['self_lsolated_start_date'];?>" disabled="disabled">
												</div>
											 </div>
										</div>
										
										<div class="col-sm-6">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
												Isolation/quarantine end date <!--<span class="req">*</span>-->
												<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="End date = self-isolate start date +11">
													<i class="fa fa-question-circle" aria-hidden="true"></i>
												 </a>
												</label>
												<div class="col-sm-7">
												  <input type="date" class="form-control" id="self_isolated_end_date" name="self_isolated_end_date"  value="<?php echo $case_list[0]['self_isolated_end_date'];?>" disabled="disabled">
												</div>
											 </div>
										</div>
										
										<div class="col-sm-6">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
												Symptoms currently
												<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Can capture symptoms in 'notes' section, if needed. Otherwise, state will send you a list of symptoms to monitor for and emergency symptoms for seeking immediate care in a follow-up email when we have concluded our call.">
													<i class="fa fa-question-circle" aria-hidden="true"></i>
												 </a>
												</label>
												<div class="col-sm-7">
												  <select name="symptoms_currently" id="symptoms_currently" class="form-control" disabled="disabled">
													<option value="Yes" <?php echo($case_list[0]['symptoms_currently']=="Yes")?'selected="selected"':'';?>>Yes</option>
													<option value="No" <?php echo($case_list[0]['symptoms_currently']=="No")?'selected="selected"':'';?>>No</option>
												  </select>
												</div>
											 </div>
										</div>
										
										<div class="col-sm-6">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
												Are you fully vaccinated? <!--<span class="req">*</span>-->
												</label>
												<div class="col-sm-7">
												  <select name="fully_vaccinated" id="fully_vaccinated"  class="form-control" disabled="disabled">
												  	<option value=""> Select </option>
													<option value="Yes" <?php echo($case_list[0]['fully_vaccinated']=="Yes")?'selected="selected"':'';?>>Yes</option>
													<option value="No" <?php echo($case_list[0]['fully_vaccinated']=="No")?'selected="selected"':'';?>>No</option>
												  </select>
												</div>
											 </div>
										</div>
										
										<div class="col-sm-6">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
												Are you Boosted? <!--<span class="req">*</span>-->
												</label>
												<div class="col-sm-7">
												  <select name="you_boosted" id="you_boosted" class="form-control"  disabled="disabled">
												  	<option value=""> Select </option>
													<option value="Yes" <?php echo($case_list[0]['you_boosted']=="Yes")?'selected="selected"':'';?>>Yes</option>
													<option value="No" <?php echo($case_list[0]['you_boosted']=="No")?'selected="selected"':'';?>>No</option>
												  </select>
												</div>
											 </div>
										</div>
										
										<div class="col-sm-12">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
												Do you have a medical provider / Primary Care Provider? <!--<span class="req">*</span>--->
												<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="If no, reference Dr. on Demand and Cigna telehealth / find a provider resources in follow-up email">
													<i class="fa fa-question-circle" aria-hidden="true"></i>
												 </a>
												</label>
												<div class="col-sm-7">
												  <select name="medical_primary_provider" id="medical_primary_provider" class="form-control"  disabled="disabled">
													<option value="Yes" <?php echo($case_list[0]['medical_primary_provider']=="Yes")?'selected="selected"':'';?>>Yes</option>
													<option value="No" <?php echo($case_list[0]['medical_primary_provider']=="No")?'selected="selected"':'';?>>No</option>
												  </select>
												</div>
											 </div>
										</div>
										
										<div class="col-sm-12">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
												Any needs currently? Things about which you are worried / stressed <!--<span class="req">*</span>-->
												<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="This may mean we refer back to McKinsey team or direct to follow-up resources, e.g., Mind Matters, HR, CDC websites, etc. See Special Situations">
													<i class="fa fa-question-circle" aria-hidden="true"></i>
												 </a>
												</label>
												<div class="col-sm-7">
												  <select name="you_worried" id="you_worried" class="form-control"  disabled="disabled">
												  	<option value=""> Select </option>
													<option value="Yes" <?php echo($case_list[0]['you_worried']=="Yes")?'selected="selected"':'';?>>Yes</option>
													<option value="No" <?php echo($case_list[0]['you_worried']=="No")?'selected="selected"':'';?>>No</option>
												  </select>
												</div>
											 </div>
										</div>
										<div class="col-sm-12">
											<div class="mb-3">
												<label>
													Case Manager notes <!--<span class="req">*</span>-->
													<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Capture notes from caller here for future reference, as helpful re: situation, symptoms, and follow-ups (can reference Special situations below)">
													<i class="fa fa-question-circle" aria-hidden="true"></i></a>
												</label>
												<textarea type="text" class="form-control" id="case_manager_note" name="case_manager_note"  disabled="disabled"><?php echo $case_list[0]['case_manager_notes'];?></textarea>
											</div>
										</div>
										
									</div>
								</div>
							  </div>
							</div>
						  </div>
						  <div class="accordion-item">
							<h2 class="accordion-header" id="headingThree">
							  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
								Contact Tracing							
							  </button>
							</h2>
							<div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
							  <div class="accordion-body">
								<div class="repeat-widget">
									<div class="mb-2">
										<p>CDC reports that people with COVID-19 have had a wide range of symptoms– ranging from mild symptoms to severe illness. Symptoms may appear 2-14 days after exposure to the virus. People with these symptoms may have COVID-19:</p>
									</div>
								</div>
								<div class="repeat-widget">
									<div class="row">
										<div class="col-sm-5">
											<div class="mb-2 left-gap">
												<?php 
												$smp = explode(',', $case_list[0]['symptoms']);
												foreach($symptoms as $key=>$rows){
													if($key==7){
														echo'</div></div>';
														echo'<div class="col-sm-2"></div>';
														echo'<div class="col-sm-5">
																<div class="mb-2 left-gap">';
													}
												?>
												
												<div class="form-check">
												  <input class="form-check-input" type="checkbox" value="<?php echo $rows['id'];?>" id="symptom_<?php echo $rows['id'];?>" name="symptom[]" <?php echo(in_array($rows['id'],$smp))?'checked="checked"':'';?> disabled="disabled">
												  <label class="form-check-label">
													<?php echo $rows['name'];?>
												  </label>
												</div>
											<?php } ?> 
										</div>
										</div>
									</div>
									
								</div>
								<div class="repeat-widget">
									<div class="mb-2">
										<p>Emergency warning signs - if the colleague has any of the below symptoms, they should get medical attention immediately:</p>
									</div>
								</div>
								<div class="repeat-widget">
									<div class="mb-2 left-gap">
										<?php 
										$medical=explode(',', $case_list[0]['medical_attention']);
										foreach ($medical_attention as $key => $rows) {
										?>	
										
										<div class="form-check">
										  <input class="form-check-input" type="checkbox" value="<?php echo $rows['id'];?>" id="medical_attention_<?php echo $rows['id'];?>" name="medical_attention[]" <?php echo(in_array($rows['id'],$medical))?'checked="checked"':'';?> disabled="disabled">
										  <label class="form-check-label">
											<?php echo $rows['name'];?>
										  </label>
										</div>
										<?php } ?>
									</div>
								</div>
								<!--start new element-->
								<div class="repeat-widget">
									<div class="row">
										<div class="col-sm-12">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													When were you last with McKinsey colleagues or clients? <!--<span class="req">*</span>-->
													<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="if in 48 hours prior to symptoms/+ test or since, need all their names (below)">
													<i class="fa fa-question-circle" aria-hidden="true"></i>
												 </a>
												</label>
												<div class="col-sm-7">
												  <div class="has-search">			
													<input type="datetime-local" class="form-control" name="when_you_with_mckinsey" id="when_you_with_mckinsey" required="required" value="<?php echo $case_list[0]['last_mckinsey_colleagues'];?>" disabled="disabled">
												  </div>
												</div>
											 </div>
										</div>
										<div class="col-sm-12">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													When were you last with clients?
													<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="if in 48 hours prior to symptoms/+ test or since, need name of DCS/Senior Partner & to know if s/he yet knows; Will need all client names (below)">
													<i class="fa fa-question-circle" aria-hidden="true"></i>
												 </a>
												</label>
												<div class="col-sm-7">
												  <div class="has-search">			
													<input type="datetime-local" class="form-control" name="las_with_client" id="last_with_client" value="<?php echo $case_list[0]['last_clients'];?>" disabled="disabled">
												  </div>
												</div>
											 </div>
										</div>
										<div class="col-sm-12">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding1">
													Who is the DCS - Responsible Sr Partner - for your engagement or the client? (name, spelled)
													<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="If colleague was at a client site, or co-locating with their client service team (CST) in 48 hours prior to symptoms / COVID + test, need to call / email">
													<i class="fa fa-question-circle" aria-hidden="true"></i>
												 </a>
												</label>
												<div class="col-sm-7">
												  <div class="has-search">			
													<input type="text" name="who_is_dcs" id="who_is_dcs" value="<?php echo $case_list[0]['who_is_dcs'];?>" disabled="disabled" class="form-control">
												  </div>
												</div>
											 </div>
										</div>
										<div class="col-sm-12">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													What is DCS's email?
													<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="First_Last@mckinsey.com or something else?">
													<i class="fa fa-question-circle" aria-hidden="true"></i>
												 </a>
												</label>
												<div class="col-sm-7">
												  <div class="has-search">			
													<input type="text" name="what_is_dcs" id="what_is_dcs" value="<?php echo $case_list[0]['what_is_dcs'];?>" disabled="disabled" class="form-control">
												  </div>
												</div>
											 </div>
										</div>
										<div class="col-sm-12">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													When were you last in a McKinsey office?
													<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="if in 48 hours prior to symptoms/+ test or since, need the office name & location where sat/worked (office # or description)">
													<i class="fa fa-question-circle" aria-hidden="true"></i>
												 </a>
												</label>
												<div class="col-sm-7">
												  <div class="has-search">			
													<input type="datetime-local" name="last_mckinsey_office" id="last_mckinsey_office" value="<?php echo $case_list[0]['last_mckinsey_office'];?>" disabled="disabled" class="form-control">
												  </div>
												</div>
											 </div>
										</div>
										<div class="col-sm-12">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													Which one?
													<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="If colleague was at a McKinsey office in the 48 hours prior to symptoms / COVID + test, notify Office Services team to notify building and clean space (as needed)">
													<i class="fa fa-question-circle" aria-hidden="true"></i>
												 </a>
												</label>
												<div class="col-sm-7">
												  <div class="has-search">
												  <select name="which_one" id="which_one" class="form-control">
												  	<option value=""> Select </option>
												  	<?php 
												  	foreach($office_loc as $key=>$rws){ 
												  	?>
												  	<option value="<?php echo $rws['location'];?>" <?php echo($rws['location']==$case_list[0]['which_one'])?'selected="selected"':'';?>><?php echo $rws['location'];?></option>
												  	<?php } ?>
												  </select>				
													<!--<input type="text" id="which_one" name="which_one" value="<?php echo $case_list[0]['which_one'];?>" disabled="disabled" class="form-control">-->
												  </div>
												</div>
											 </div>
										</div>
										<div class="col-sm-12">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													Only if applicable: When were you last attending a Mckinsey Event?
													<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Were you attending a McKinsey event in the 48 hours prior to symptoms/+ test or since? If yes, which one and who was sponsor / organizer?">
													<i class="fa fa-question-circle" aria-hidden="true"></i>
												 </a>
												</label>
												<div class="col-sm-7">
												  <div class="has-search">			
													<input type="datetime-local" name="last_mckinsey_event" id="last_mckinsey_event" disabled="disabled" class="form-control" value="<?php echo $case_list[0]['last_attending_mckinsey_event'];?>">
												  </div>
												</div>
											 </div>
										</div>
										<div class="col-sm-12">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding1">
													Who is the event sponsor? (Partner, senior Firm leader) (name, spelled)
													<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="If colleague was at a McKinsey event in 48 hours prior to symptoms / COVID + test, need to call / email">
													<i class="fa fa-question-circle" aria-hidden="true"></i>
												 </a>
												</label>
												<div class="col-sm-7">
												  <div class="has-search">			
													<input type="text" name="who_event_sponsor" id="who_event_sponsor" disabled="disabled" value="<?php echo $case_list[0]['who_event_sponsor'];?>" class="form-control">
												  </div>
												</div>
											 </div>
										</div>
										<div class="col-sm-12">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													What is event sponsor's email?
													<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="First_Last@mckinsey.com or something else?">
													<i class="fa fa-question-circle" aria-hidden="true"></i>
												 </a>
												</label>
												<div class="col-sm-7">
												  <div class="has-search">			
													<input type="text" name="event_sponsor_email" id="event_sponor_email" value="<?php echo $case_list[0]['event_sponsor_email'];?>" disabled="disabled" class="form-control">
												  </div>
												</div>
											 </div>
										</div>
										<div class="col-sm-12">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													Is event sponsor already aware?
													<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Yes / No / Unsure">
													<i class="fa fa-question-circle" aria-hidden="true"></i>
												 </a>
												</label>
												<div class="col-sm-7">
												  <div class="has-search">			
													<select name="sponsor_already_aware" id="sponsor_already_aware" class="form-control" disabled="disabled" >
														<option value=""> select </option>
														<option value="Yes" <?php echo($case_list[0]['sponsor_already_aware']=="Yes")?'selected="selected"':'';?>>Yes</option>
														<option value="No" <?php echo($case_list[0]['sponsor_already_aware']=="No")?'selected="selected"':'';?>>No</option>
														<option value="Unsure" <?php echo($case_list[0]['sponsor_already_aware']=="Unsure")?'selected="selected"':'';?>>Unsure</option>
													</select>
												  </div>
												</div>
											 </div>
										</div>
										<div class="col-sm-12">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													Contact Tracing
													<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Is contact tracing required?">
													<i class="fa fa-question-circle" aria-hidden="true"></i>
												 </a>
												</label>
												<div class="col-sm-7">
												  <div class="form-check form-check-inline">
													<input class="form-check-input" type="checkbox" id="contact_tracing_1" name="contact_tracing" value="Yes" <?php echo($case_list[0]['contract_tracing']=="Yes")?'checked="checked"':'';?> disabled="disabled" required>
													<label class="form-check-label" for="inlineCheckbox1">Yes</label>
													</div>
													<div class="form-check form-check-inline">
													<input class="form-check-input" type="checkbox" id="contact_tracing_2" name="contact_tracing" <?php echo($case_list[0]['contract_tracing']=="No")?'checked="checked"':'';?> value="No" disabled="disabled" required>
													<label class="form-check-label" for="inlineCheckbox2">No</label>
													</div>
												</div>
											 </div>
										</div>
										<div class="col-sm-12">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													# of client contacts notified <!--<span class="req">*</span>-->						
												</label>
												<div class="col-sm-7">
												  <input type="number" class="form-control" id="client_contacts_notified" name="client_contacts_notified"  value="<?php echo $case_list[0]['client_contacts_notified'];?>" disabled="disabled">
												</div>
											 </div>
										</div>
										<div class="col-sm-12">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													# of firm contacts notified	<!--<span class="req">*</span>-->
												</label>
												<div class="col-sm-7">
												  <input type="number" class="form-control" id="firm_contacts_notified" name="firm_contacts_notified" value="<?php echo $case_list[0]['firm_contacts_notified'];?>"  disabled="disabled">
												</div>
											 </div>
										</div>
									</div>
								</div>
								<!--end new element-->
								
								<div class="repeat-widget">
									<div class="mb-2">
										<p>Identify any McKinsey, client, or work-related 'close contacts' in the 48 hours before symptom onset (or positive test, if no symptoms).  Here's what we mean by 'close contact':</p>
									</div>
								</div>
								<div class="repeat-widget">
									<div class="mb-2">
										<p>Close contact =  Someone who was within 6 feet of a COVID-positive person for a cumulative total of 15 minutes or more over a 24-hour period (for example, three individual 5-minute exposures for a total of 15 minutes).</p>
									</div>
								</div>
								<div class="repeat-widget">
									<div class="mb-2">
										<p>List and timing of of close contacts - McKinsey colleagues (including contractors, recruits, etc.)</p>
									</div>
								</div>
								<div class="repeat-widget">

									<div id="mckinsey_colleagues_div" class="row">
										<div class="col-sm-6">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													Contact person Name
												</label>
												<div class="col-sm-7">
												  <input type="text" class="form-control" id="mckinsey_colleagues_fname" name="mckinsey_colleagues_fname[]" value="<?php echo $colleague[0]['fname'];?>" onkeydown="return (event.keyCode>=65 && event.keyCode<=90 || event.keyCode==32 || event.keyCode==8 || event.keyCode==110);" disabled="disabled">
												</div>
											 </div>					
										</div>
										<div class="col-sm-6">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													Contact Last Name
												</label>
												<div class="col-sm-7">
												  <input type="text" class="form-control" id="mckinsey_colleagues_lname" name="mckinsey_colleagues_lname[]" onkeydown="return (event.keyCode>=65 && event.keyCode<=90 || event.keyCode==32 || event.keyCode==8 || event.keyCode==110);" value="<?php echo $colleague[0]['lname'];?>" disabled="disabled">
												</div>
											 </div>					
										</div>
										<div class="col-sm-6">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													Mackinsey Email
												</label>
												<div class="col-sm-7">
												  <input type="text" class="form-control email" id="mckinsey_colleagues_email" name="mckinsey_colleagues_email[]" value="<?php echo $colleague[0]['email'];?>" disabled="disabled">
												</div>
											 </div>					
										</div>
										<div class="col-sm-6">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													Date
												</label>
												<div class="col-sm-7">
												  <input type="datetime-local" class="form-control" id="mckinsey_colleagues_date" name="mckinsey_colleagues_date[]" value="<?php echo $colleague[0]['date'];?>" disabled="disabled">
												</div>
											 </div>
										</div>
										<div class="col-sm-6">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													Location
												</label>
												<div class="col-sm-7">
												  <select name="mckinsey_colleagues_location[]" id="mckinsey_colleagues_location" class="form-control" onchange="set_location(this);" disabled="disabled">
												  	<option value=""> Select </option>
													<option value="Office" <?php echo($colleague[0]['location']=='Office')?'selected="selected"':'';?>>Office</option>
													<option value="Client" <?php echo($colleague[0]['location']=='Client')?'selected="selected"':'';?>>Client</option>
													<option value="Event" <?php echo($colleague[0]['location']=='Event')?'selected="selected"':'';?>>Event</option>
													<option value="other" <?php echo($colleague[0]['location']=='other')?'selected="selected"':'';?>>Other</option>
												</select>
												</div>
											 </div>											 
										</div>
										<div class="col-sm-6">
											<!--start for others-->
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label">
													<div class="other-widget minus-top other_location">
														<input type="text" class="form-control" id="mckinsey_colleagues_other_location" name="mckinsey_colleagues_other_location[]" value="<?php echo$colleague[0]['other_location'] ;?>" style="display:none;">
													</div>
												</label>
												<div class="col-sm-7">
												</div>
											</div>
											<!--end for others-->
										</div>
									</div>
									<div id="mckinsey_colleagues_repeat">
										<?php 
										$i=0;
										foreach($colleague as $key=>$cl){
											$i++;
											if($i>1){
										?>
										<div class="row">
										<div class="col-sm-6">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													Contact person Name
												</label>
												<div class="col-sm-7">
												  <input type="text" class="form-control" id="mckinsey_colleagues_fname" name="mckinsey_colleagues_fname[]" value="<?php echo $cl['fname'];?>" onkeydown="return (event.keyCode>=65 && event.keyCode<=90 || event.keyCode==32 || event.keyCode==8 || event.keyCode==110);" disabled="disabled">
												</div>
											 </div>					
										</div>
										<div class="col-sm-6">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													Contact Last Name
												</label>
												<div class="col-sm-7">
												  <input type="text" class="form-control" id="mckinsey_colleagues_lname" name="mckinsey_colleagues_lname[]" value="<?php echo $cl['lname'];?>" onkeydown="return (event.keyCode>=65 && event.keyCode<=90 || event.keyCode==32 || event.keyCode==8 || event.keyCode==110);" disabled="disabled">
												</div>
											 </div>					
										</div>
										<div class="col-sm-6">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													Mackinsey Email
												</label>
												<div class="col-sm-7">
												  <input type="text" class="form-control email" id="mckinsey_colleagues_email" name="mckinsey_colleagues_email[]" value="<?php echo $cl['email'];?>" disabled="disabled">
												</div>
											 </div>					
										</div>
										<div class="col-sm-6">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													Date
												</label>
												<div class="col-sm-7">
												  <input type="datetime-local" class="form-control" id="mckinsey_colleagues_date" name="mckinsey_colleagues_date[]" value="<?php echo $cl['date'];?>" disabled="disabled">
												</div>
											 </div>
										</div>
										<div class="col-sm-6">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													Location
												</label>
												<div class="col-sm-7">
												  <select name="mckinsey_colleagues_location[]" id="mckinsey_colleagues_location" class="form-control" onchange="set_location(this);" disabled="disabled">
												  	<option value=""> Select </option>
													<option value="Office" <?php echo($cl['location']=='Office')?'selected="selected"':'';?>>Office</option>
													<option value="Client" <?php echo($cl['location']=='Client')?'selected="selected"':'';?>>Client</option>
													<option value="Event" <?php echo($cl['location']=='Event')?'selected="selected"':'';?>>Event</option>
													<option value="other" <?php echo($cl['location']=='other')?'selected="selected"':'';?>>Other</option>
												</select>
												</div>
											 </div>
										</div>
										<div class="col-sm-6">
											<!--start for others-->
											 <div class="mb-3 row">
												<div class="col-sm-5 col-form-label no-padding">
												<div class="other-widget minus-top other_location">
													<input type="text" class="form-control" id="mckinsey_colleagues_other_location" name="mckinsey_colleagues_other_location[]" value="<?php echo$cl['other_location'];?>" style="display:none;">
												</div>
												</div>
											 </div>
											 <!--end for others-->
										</div>
										
									 </div>
										<?php
											}	
										}
										?>
									</div>
									<div class="add-widget">
										<div class="row">		
											<div class="col-sm-6"></div>
											<div class="col-sm-6">
												<div class="add-widget1">
												<div id="clon_coll_function" class="mb-3 row" style="display: none;">
												<label class="col-sm-5 col-form-label">
													<a  onclick="clon_colleagues()" class="add-more-btn">Add More <i class="fa fa-plus" aria-hidden="true"></i></a>
												</label>
											</div>
												</div>		
											</div>
										</div>
									</div>
								</div>
								<div class="repeat-widget">
									<div class="mb-2">
										<p>List and timing of of close contacts - Clients </p>
									</div>
								</div>
								<div class="repeat-widget">
									<div id="mckinsey_client_div" class="row">
										<div class="col-sm-6">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													Contact person Name
												</label>
												<div class="col-sm-7">
												  <input type="text" name="client_fname[]" class="form-control" id="client_fname" onkeydown="return (event.keyCode>=65 && event.keyCode<=90 || event.keyCode==32 || event.keyCode==8 || event.keyCode==110);" value="<?php echo $client[0]['fname'];?>" disabled="disabled">
												</div>
											 </div>
										</div>
										<div class="col-sm-6">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													Contact Last Name
												</label>
												<div class="col-sm-7">
												  <input type="text" class="form-control" id="client_lname" name="client_lname[]" onkeydown="return (event.keyCode>=65 && event.keyCode<=90 || event.keyCode==32 || event.keyCode==8 || event.keyCode==110);" value="<?php echo $client[0]['lname'];?>" disabled="disabled">
												</div>
											 </div>
										</div>
										<div class="col-sm-6">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													Date
												</label>
												<div class="col-sm-7">
												  <input type="datetime-local" class="form-control" name="client_date[]" id="client_date" value="<?php echo $client[0]['date'];?>" disabled="disabled">
												</div>
											 </div>
										</div>
										<div class="col-sm-6">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													Location
												</label>
												<div class="col-sm-7">
												  <select name="client_location[]" id="client_location" class="form-control" disabled="disabled">
													<option value="Office" <?php echo($client[0]['location']=='Office')?'selected="selected"':'';?>>Office</option>
													<option value="Client" <?php echo($client[0]['location']=='Client')?'selected="selected"':'';?>>Client</option>
													<option value="Event" <?php echo($client[0]['location']=='Event')?'selected="selected"':'';?>>Event</option>
													<option value="other" <?php echo($client[0]['location']=='other')?'selected="selected"':'';?>>Other</option>
												</select>
												</div>
											 </div>
											 <!--start for others-->
											<!--<div class="mb-3 row">
												<label class="col-sm-5 col-form-label">
													
												</label>
												<div class="col-sm-7">
													<div class="other-widget minus-top">
														<input type="text" class="form-control" id="">
													</div>
												</div>
											</div>-->
											<!--end for others-->
										</div>										
									</div>
									
									<div id="mckinsey_client_repeat">
									<?php 
									$i=0;
									foreach ($client as $key => $clnt) {
										$i++;
										if($i>1){
									?>
									<div class="row">
										<div class="col-sm-6">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													Contact person Name
												</label>
												<div class="col-sm-7">
												  <input type="text" name="client_fname[]" class="form-control" id="client_fname" onkeydown="return (event.keyCode>=65 && event.keyCode<=90 || event.keyCode==32 || event.keyCode==8 || event.keyCode==110);" value="<?php echo $clnt['fname'];?>" disabled="disabled">
												</div>
											 </div>
										</div>
										<div class="col-sm-6">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													Contact Last Name
												</label>
												<div class="col-sm-7">
												  <input type="text" class="form-control" id="client_lname" name="client_lname[]" onkeydown="return (event.keyCode>=65 && event.keyCode<=90 || event.keyCode==32 || event.keyCode==8 || event.keyCode==110);" value="<?php echo $clnt['lname'];?>" disabled="disabled">
												</div>
											 </div>
										</div>
										<div class="col-sm-6">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													Date
												</label>
												<div class="col-sm-7">
												  <input type="datetime-local" class="form-control" name="client_date[]" id="client_date" value="<?php echo $clnt['date'];?>" disabled="disabled">
												</div>
											 </div>
										</div>
										<div class="col-sm-6">
											<div class="mb-3 row">
												<label class="col-sm-5 col-form-label no-padding">
													Location
												</label>
												<div class="col-sm-7">
												  <select name="client_location[]" id="client_location" class="form-control" disabled="disabled">
													<option value="Office" <?php echo($clnt['location']=='Office')?'selected="selected"':'';?>>Office</option>
													<option value="Client" <?php echo($clnt['location']=='Client')?'selected="selected"':'';?>>Client</option>
													<option value="Event" <?php echo($clnt['location']=='Event')?'selected="selected"':'';?>>Event</option>
													<option value="other" <?php echo($clnt['location']=='other')?'selected="selected"':'';?>>Other</option>
												</select>
												</div>
											 </div>
										</div>			
									</div>
									<?php
									}}
									?>	
									</div>
									<div class="add-widget">
										<div class="row">			
											<div class="col-sm-12">
												<div class="add-widget2">
												<div id="clon_client_function" class="mb-3 row" style="display: none;">
												<label class="col-sm-12 col-form-label">
													<a onclick="clon_client()" class="add-more-btn">Add More <i class="fa fa-plus" aria-hidden="true"></i></a>
												</label>
											</div>
												</div>		
											</div>
										</div>
									</div>
								</div>
								<div class="repeat-widget">
									<div class="mb-2">
										<!--<div class="note-red">
											<p>[Note: Given that this is a confirmed case all McKinsey colleagues would be advised to self isolate for 14 days from the point of last contact]</p>
										</div>-->
									</div>
								</div>
							  </div>
							</div>
						  </div>
						  
						  <div class="accordion-item">
							<h2 class="accordion-header" id="headingThree">
							  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
								Special situations & follow-up resources	
							  </button>
							</h2>
							<div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
							  <div class="accordion-body">
								<div class="repeat-widget">
									<div class="mb-2">
										<p>In first discussion or any thereafter, check if colleague's situation meets any of the following (check for reminder on follow-ups). Email scripts / referrals in 'special situations' document</p>
									</div>
								</div>
								<div class="repeat-widget">
									<div class="row left-gap">
										<div class="col-sm-12">
											<div class="mb-2">
												<div class="form-check" style="<?php echo($case_list[0]['working_mckinsey_office']=='Yes')?"font-weight: bold;":"";?>">
												  <input class="form-check-input" type="checkbox" value="Yes" id="working_mckinsey_office" name="working_mckinsey_office" <?php echo($case_list[0]['working_mckinsey_office']=='Yes')?"checked='checked'":"";?> disabled="disabled" onclick="activate_mail(this);">
												  <label class="form-check-label">
													Colleague working in McKinsey office (in last 48 hours)
													<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Notify Office Services for cleaning / bldg. report; Copying Gretchen Scheidler">
														<i class="fa fa-question-circle" aria-hidden="true"></i>
													</a>
													<span id="working_mckinsey_office_email" style="<?php echo($case_list[0]['working_mckinsey_office']=='Yes')?"":"display: none;";?>">
													<a href="javascript:void();" onclick="get_email_data('working_mckinsey_office_email');" class="mail-small-icon" data-bs-toggle="modal" data-bs-target="#myModal">
														<i class="fa fa-envelope-o" aria-hidden="true"></i>
													</a>
													<span class="mail-add">
													 <a href="javascript:void();" class="new-mail" data-bs-toggle="modal" data-bs-target="#myModal" onclick="mail_popuo();">
														<i class="fa fa-envelope" aria-hidden="true"></i>
													 </a>
												  </span>
												</span>
												  </label>
												</div>
											</div>
										</div>			
										<div class="col-sm-12">
											<div class="mb-2">
												<div class="form-check" style="<?php echo($case_list[0]['mckinsey_event_close_contact_email']=='Yes')?"font-weight: bold;":"";?>">
												  <input class="form-check-input" type="checkbox" value="Yes" id="mckinsey_event_close_contact" name="mckinsey_event_close_contact" <?php echo($case_list[0]['mckinsey_event_close_contact']=='Yes')?"checked='checked'":"";?> disabled="disabled" onclick="activate_mail(this);">
												  <label class="form-check-label">
													Colleague at McKinsey event & close contacts (in last 48 hours)
													<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Event email from organizer post-contact tracing; Copying Gretchen Scheidler">
													<i class="fa fa-question-circle" aria-hidden="true"></i>
												 </a>
												 <span id="mckinsey_event_close_contact_email" style="<?php echo($case_list[0]['mckinsey_event_close_contact_email']=='Yes')?"":"display: none;";?>">
												 <a href="javascript:void();" onclick="get_email_data('mckinsey_event_close_contact_email');" class="mail-small-icon" data-bs-toggle="modal" data-bs-target="#myModal">
													<i class="fa fa-envelope-o" aria-hidden="true"></i>
												 </a>
												 <span class="mail-add">
													 <a href="javascript:void();" class="new-mail" data-bs-toggle="modal" data-bs-target="#myModal" onclick="mail_popuo();">
														<i class="fa fa-envelope" aria-hidden="true"></i>
													 </a>
												  </span>
												</span>
												  </label>
												</div>
											</div>
										</div>
										<div class="col-sm-12">
											<div class="mb-2">
												<div class="form-check" style="<?php echo($case_list[0]['client_close_contact_email']=='Yes')?"font-weight: bold;":"";?>">
												  <input class="form-check-input" type="checkbox" value="Yes" id="client_close_contact" name="client_close_contact" <?php echo($case_list[0]['client_close_contact']=='Yes')?"checked='checked'":"";?> disabled="disabled" onclick="activate_mail(this);">
												  <label class="form-check-label">
													Colleague with client close contacts (in last 48 hours)
													<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Senior Partner comms for client; Copying Gretchen Scheidler">
													<i class="fa fa-question-circle" aria-hidden="true"></i>
												 </a>
												 <span id="client_close_contact_email" style="<?php echo($case_list[0]['client_close_contact_email']=='Yes')?"":"display: none;";?>">
												 <a href="javascript:void();" onclick="get_email_data('client_close_contact_email');" class="mail-small-icon" data-bs-toggle="modal" data-bs-target="#myModal">
													<i class="fa fa-envelope-o" aria-hidden="true"></i>
												 </a>
												 <span class="mail-add">
													 <a href="javascript:void();" class="new-mail" data-bs-toggle="modal" data-bs-target="#myModal" onclick="mail_popuo();">
														<i class="fa fa-envelope" aria-hidden="true"></i>
													 </a>
												  </span>
												</span>
												  </label>
												</div>
											</div>
										</div>
										<div class="col-sm-12">
											<div class="mb-2">
												<div class="form-check" style="<?php echo($case_list[0]['colleague_close_contact_email']=='Yes')?"font-weight: bold;":"";?>">
												  <input class="form-check-input" type="checkbox" value="Yes" id="colleague_close_contact" name="colleague_close_contact" <?php echo($case_list[0]['colleague_close_contact']=='Yes')?"checked='checked'":"";?> disabled="disabled" onclick="activate_mail(this);">
												  <label class="form-check-label">
													Colleague / close contacts still interacting (e.g., ongoing office meeting, client meeting, event) & need urgent next steps
													<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Live conversation to assess situation & lay out process; Contact trace & advise by person">
													<i class="fa fa-question-circle" aria-hidden="true"></i>
												 </a>
												 <span id="colleague_close_contact_email" style="<?php echo($case_list[0]['colleague_close_contact_email']=='Yes')?"":"display: none;";?>">
														<a href="javascript:void();" onclick="show_info('colleague_close_contact_email');" class="mail-small-icon" data-bs-toggle="modal" data-bs-target="#myModalcase">
															<i class="fa fa-info" aria-hidden="true"></i>
														</a>
														<a href="javascript:void();" onclick="get_email_data('colleague_close_contact_email');" class="mail-small-icon" data-bs-toggle="modal" data-bs-target="#myModal">
															<i class="fa fa-envelope-o" aria-hidden="true"></i>
														</a>
													<span class="mail-add">
														<a href="javascript:void();" class="new-mail" data-bs-toggle="modal" data-bs-target="#myModal" onclick="mail_popuo();">
															<i class="fa fa-envelope" aria-hidden="true"></i>
														</a>
													</span>
												</span>
												  </label>
												</div>
											</div>
										</div>
										<div class="col-sm-12">
											<div class="mb-2">
												<div class="form-check" style="<?php echo($case_list[0]['colleague_ill_5_day_email']=='Yes')?"font-weight: bold;":"";?>">
												  <input class="form-check-input" type="checkbox" value="Yes" id="colleague_ill_5_day" name="colleague_ill_5_day" <?php echo($case_list[0]['colleague_ill_5_day']=='Yes')?"checked='checked'":"";?>  disabled="disabled" onclick="activate_mail(this);">
												  <label class="form-check-label">
													Colleague ill 5+ days
													<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Connect to local McKinsey HR team for STD">
													<i class="fa fa-question-circle" aria-hidden="true"></i>
												 </a>
												 <span id="colleague_ill_5_day_email" style="<?php echo($case_list[0]['colleague_ill_5_day_email']=='Yes')?"":"display: none;";?>">
												 <a href="javascript:void();" onclick="get_email_data('colleague_ill_5_day_email');" class="mail-small-icon" data-bs-toggle="modal" data-bs-target="#myModal">
													<i class="fa fa-envelope-o" aria-hidden="true"></i>
												 </a>
												 <span class="mail-add">
													 <a href="javascript:void();" class="new-mail" data-bs-toggle="modal" data-bs-target="#myModal" onclick="mail_popuo();">
														<i class="fa fa-envelope" aria-hidden="true"></i>
													 </a>
												  </span>
												</span>
												  </label>
												</div>
											</div>
										</div>
										<div class="col-sm-12">
											<div class="mb-2">
												<div class="form-check" style="<?php echo($case_list[0]['colleague_away_from_home_email']=='Yes')?"font-weight: bold;":"";?>">
												  <input class="form-check-input" type="checkbox" value="Yes" id="colleague_away_from_home" name="colleague_away_from_home" <?php echo($case_list[0]['colleague_away_from_home']=='Yes')?"checked='checked'":"";?> disabled="disabled" onclick="activate_mail(this);">
												  <label class="form-check-label">
													Colleague away from home (confirmed or ‘not up to date on vaccination’ close contact)
													<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Advise on protocol & check-in daily with text/call; Report in dashboard if in hotel">
													<i class="fa fa-question-circle" aria-hidden="true"></i>
												 </a>
												 <span id="colleague_away_from_home_email" style="<?php echo($case_list[0]['colleague_away_from_home_email']=='Yes')?"":"display: none;";?>">
												 <a href="javascript:void();" onclick="get_email_data('colleague_away_from_home_email');" class="mail-small-icon" data-bs-toggle="modal" data-bs-target="#myModalcase">
													<i class="fa fa-info" aria-hidden="true"></i>
												 </a>
												 <span class="mail-add">
													 <a href="javascript:void();" class="new-mail" data-bs-toggle="modal" data-bs-target="#myModal" onclick="mail_popuo();">
														<i class="fa fa-envelope" aria-hidden="true"></i>
													 </a>
												  </span>
												</span>
												  </label>
												</div>
											</div>
										</div>
										<div class="col-sm-12">
											<div class="mb-2">
												<div class="form-check" style="<?php echo($case_list[0]['drivable_well_email']=='Yes')?"font-weight: bold;":"";?>">
												  <input class="form-check-input" type="checkbox" value="Yes" id="drivable_well" name="drivable_well" <?php echo($case_list[0]['drivable_well']=='Yes')?"checked='checked'":"";?> disabled="disabled" onclick="activate_mail(this);">
												  <label class="form-check-label">
													1. Colleague is away from home but drivable & well
													<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="If have personal/rental car & well, can drive w/out stopping">
													<i class="fa fa-question-circle" aria-hidden="true"></i>
												 </a>
												 <span id="drivable_well_email" style="<?php echo($case_list[0]['drivable_well_email']=='Yes')?"":"display: none;";?>">
												 <a href="javascript:void();" onclick="get_email_data('drivable_well_email');" class="mail-small-icon" data-bs-toggle="modal" data-bs-target="#myModalcase">
													<i class="fa fa-info" aria-hidden="true"></i>
												 </a>
												 <span class="mail-add">
													 <a href="javascript:void();" class="new-mail" data-bs-toggle="modal" data-bs-target="#myModal" onclick="mail_popuo();">
														<i class="fa fa-envelope" aria-hidden="true"></i>
													 </a>
												  </span>
												</span>
												  </label>
												</div>
											</div>
										</div>
										<div class="col-sm-12">
											<div class="mb-2">
												<div class="form-check" style="<?php echo($case_list[0]['quarantining_place_email']=='Yes')?"font-weight: bold;":"";?>">
												  <input class="form-check-input" type="checkbox" value="Yes" id="quarantining_place" name="quarantining_place" <?php echo($case_list[0]['quarantining_place']=='Yes')?"checked='checked'":"";?> disabled="disabled" onclick="activate_mail(this);">
												  <label class="form-check-label">
													2. Colleague is away from home and isolating / quarantining in place (hotel)
													<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Advise re: hotel precautions, timeline, expenses, mental health; Report in dashboard">
													<i class="fa fa-question-circle" aria-hidden="true"></i>
												 </a>
												 <span id="quarantining_place_email" style="<?php echo($case_list[0]['quarantining_place_email']=='Yes')?"":"display: none;";?>">
												 <a href="javascript:void();" onclick="get_email_data('quarantining_place_email');" class="mail-small-icon" data-bs-toggle="modal" data-bs-target="#myModal">
													<i class="fa fa-envelope-o" aria-hidden="true"></i>
												 </a>
												 <span class="mail-add">
													 <a href="javascript:void();" class="new-mail" data-bs-toggle="modal" data-bs-target="#myModal" onclick="mail_popuo();">
														<i class="fa fa-envelope" aria-hidden="true"></i>
													 </a>
												  </span>
												</span>
												  </label>
												</div>
											</div>
										</div>
										<div class="col-sm-12">
											<div class="mb-2">
												<div class="form-check" style="<?php echo($case_list[0]['international_email']=='Yes')?"font-weight: bold;":"";?>">
												  <input class="form-check-input" type="checkbox" value="Yes" id="international" name="international" <?php echo($case_list[0]['international']=='Yes')?"checked='checked'":"";?> disabled="disabled" onclick="activate_mail(this);">
												  <label class="form-check-label">
													3. Colleague is away from home & international
													<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Same as above + involve McKinsey for extra support (call & email Gretchen Scheidler)">
													<i class="fa fa-question-circle" aria-hidden="true"></i>
												 </a>
												 <span id="international_email" style="<?php echo($case_list[0]['international_email']=='Yes')?"":"display: none;";?>">
												 <a href="javascript:void();" onclick="get_email_data('international_email');" class="mail-small-icon" data-bs-toggle="modal" data-bs-target="#myModal">
													<i class="fa fa-envelope-o" aria-hidden="true"></i>
												 </a>
												 <span class="mail-add">
													 <a href="javascript:void();" class="new-mail" data-bs-toggle="modal" data-bs-target="#myModal" onclick="mail_popuo();">
														<i class="fa fa-envelope" aria-hidden="true"></i>
													 </a>
												  </span>
												</span>
												  </label>
												</div>
											</div>
										</div>
										<div class="col-sm-12">
											<div class="mb-2">
												<div class="form-check" style="<?php echo($case_list[0]['colleague_seriously_ill_email']=='Yes')?"font-weight: bold;":"";?>">
												  <input class="form-check-input" type="checkbox" value="Yes" id="colleague_seriously_ill" name="colleague_seriously_ill" <?php echo($case_list[0]['colleague_seriously_ill']=='Yes')?"checked='checked'":"";?> disabled="disabled" onclick="activate_mail(this);">
												  <label class="form-check-label">
													Colleague seriously ill / ED visit / admitted to hospital
													<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Escalate immediately to McKinsey (call & email Gretchen Scheidler); Report in dashboard">
													<i class="fa fa-question-circle" aria-hidden="true"></i>
												 </a>
												 <span id="colleague_seriously_ill_email" style="<?php echo($case_list[0]['colleague_seriously_ill_email']=='Yes')?"":"display: none;";?>">
												 <a href="javascript:void();" onclick="get_email_data('colleague_seriously_ill_email');" class="mail-small-icon" data-bs-toggle="modal" data-bs-target="#myModalcase">
													<i class="fa fa-info" aria-hidden="true"></i>
												 </a>
												 <span class="mail-add">
													 <a href="javascript:void();" class="new-mail" data-bs-toggle="modal" data-bs-target="#myModal" onclick="mail_popuo();">
														<i class="fa fa-envelope" aria-hidden="true"></i>
													 </a>
												  </span>
												</span>
												  </label>
												</div>
											</div>
										</div>
										<div class="col-sm-12">
											<div class="mb-2">
												<div class="form-check" style="<?php echo($case_list[0]['colleague_exhibiting_email']=='Yes')?"font-weight: bold;":"";?>">
												  <input class="form-check-input" type="checkbox" value="Yes" id="colleague_exhibiting" name="colleague_exhibiting" <?php echo($case_list[0]['colleague_exhibiting']=='Yes')?"checked='checked'":"";?>  disabled="disabled" onclick="activate_mail(this);">
												  <label class="form-check-label">
													Colleague exhibiting or reporting anxiety / duress
													<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Share mental health resources & hand off to McKinsey HR (copying Gretchen Scheidler)">
													<i class="fa fa-question-circle" aria-hidden="true"></i>
												 </a>
												 <span id="colleague_exhibiting_email" style="<?php echo($case_list[0]['colleague_exhibiting_email']=='Yes')?"":"display: none;";?>">
												 <a href="javascript:void();" onclick="get_email_data('colleague_exhibiting_email');" class="mail-small-icon" data-bs-toggle="modal" data-bs-target="#myModal">
													<i class="fa fa-envelope-o" aria-hidden="true"></i>
												 </a>
												 <span class="mail-add">
													 <a href="javascript:void();" class="new-mail" data-bs-toggle="modal" data-bs-target="#myModal" onclick="mail_popuo();">
														<i class="fa fa-envelope" aria-hidden="true"></i>
													 </a>
												  </span>
												</span>
												  </label>
												</div>
											</div>
										</div>
										<div class="col-sm-12">
											<div class="mb-2">
												<div class="form-check" style="<?php echo($case_list[0]['colleague_underlying_complications']=='Yes')?"font-weight='blod'":"";?>">
												  <input class="form-check-input" type="checkbox" value="Yes" id="colleague_underlying_complications" name="colleague_underlying_complications" <?php echo($case_list[0]['colleague_underlying_complications']=='Yes')?"checked='checked'":"";?> disabled="disabled" onclick="activate_mail(this);">
												  <label class="form-check-label" >
													Colleague with underlying complications / seeking second opinion
													<a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Escalate / hand off to McKinsey (without over-committing); Call & email Gretchen Scheidler">
													<i class="fa fa-question-circle" aria-hidden="true"></i>
												 </a>
													<span id="colleague_underlying_complications_email" style="display: none;">
														<a href="javascript:void();" onclick="get_email_data('colleague_underlying_complications_email');" class="mail-small-icon" data-bs-toggle="modal" data-bs-target="#myModal">
															<i class="fa fa-envelope-o" aria-hidden="true"></i>
														</a>
														<span class="mail-add">
													 <a href="javascript:void();" class="new-mail" data-bs-toggle="modal" data-bs-target="#myModal" onclick="mail_popuo();">
														<i class="fa fa-envelope" aria-hidden="true"></i>
													 </a>
												  </span>
													</span>
												  </label>
												</div>
											</div>
										</div>
										<!--<div class="col-sm-12">
											<div class="mb-2">
												<label>Case Manager notes</label>
												<textarea type="text" class="form-control" id=""></textarea>
											</div>
										</div>-->
									</div>
								</div>								
							  </div>
							</div>
						  </div>
						  
						</div>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="right-area">
						<!--<div class="tabs-widget">
							<ul class="nav nav-pills" role="tablist">
								<li class="nav-item">
								  <a class="nav-link active" data-bs-toggle="pill" href="#home">New Task</a>
								</li>
								<li class="nav-item">
								  <a class="nav-link" data-bs-toggle="pill" href="#menu1">Log a Call</a>
								</li>    
							</ul>
						</div>-->
						<div class="tab-content">
							<div id="home" class="tab-pane active">
								<!--<div class="add-top">
								  <div class="example">
									  <input type="text" class="form-control" placeholder="Create a Task" name="search">
									  <button type="submit">Add</button>
								  </div>
								</div>-->
								<div class="add-top form-right">
									<h3 class="small-heading-right">
										Email templates for case type
										<div class="dropdown">
										 <!-- <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
											<i class="fa fa-cog" aria-hidden="true"></i>
										  </button>
										  <ul class="dropdown-menu">
											<li><a class="dropdown-item" href="#">Link 1</a></li>
											<li><a class="dropdown-item" href="#">Link 2</a></li>
											<li><a class="dropdown-item" href="#">Link 3</a></li>
										  </ul>-->
										</div>
									</h3>
								</div>
								<div class="add-top no-margin form-right">
									<div class="text-link">
										<a href="#" onclick="get_email_data('confirm');"  data-bs-toggle="modal" data-bs-target="#myModal">Confirmed</a>
										<a href="#" onclick="get_email_data('close_contact');" data-bs-toggle="modal" data-bs-target="#myModal">Close contact</a>
										<!--<a href="#">Event</a>-->
										<a href="#" onclick="get_email_data('auto_reply');"  data-bs-toggle="modal" data-bs-target="#myModal">Auto-reply</a>
									</div>
								</div>
								<div class="add-top form-right accordian-widget">
									<div class="accordion" id="accordionExample1">
										  <div class="accordion-item">
											<h2 class="accordion-header" id="headingOne1">
											  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne1" aria-expanded="true" aria-controls="collapseOne1">
												Email Logs
											  </button>
											</h2>
											<div id="collapseOne1" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample1">
											<?php foreach($sql_email_log as $key=>$rws){ ?>	
											  <div class="accordion-body text-left-align">
												<p>Email sent at <b><?php echo $rws['sended_on'];?></b> by <b><?php echo $rws['fname'].' '.$rws['lname'];?><b> <a href="#" class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="<?php echo $rws['subject'];?>">
												<span style="color:blue;">
														<i class="fa fa-info" aria-hidden="true"></i>
													</span>	
													</a>
													<a href="javascript:void();" onclick="set_log_data('<?php echo $rws['id'];?>');" class="mail-small-icon new-mail" data-bs-toggle="modal" data-bs-target="#myModal">
															<i class="fa fa-envelope-o" aria-hidden="true"></i>
														</a>
												</p>	
											  </div>
											<?php } ?>
											</div>
										  </div>
										  <!--<div class="accordion-item">
											<h2 class="accordion-header" id="headingOne2">
											  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne2" aria-expanded="true" aria-controls="collapseOne1">
												
											  </button>
											</h2>
											<div id="collapseOne2" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample2">
											  <div class="accordion-body text-center">
												<p>No next steps</p>
												<p>To get things moving, add a task or set up a meeting</p>
												<p>No past activity, Past meetings and task as done show up here.</p>
											  </div>
											</div>
										  </div>-->
									</div>
								</div>
							</div>
							<div id="menu1" class="tab-pane fade">
								<div class="add-top form-right">
									<h3 class="small-heading-right">
										Filter All time + All activities + All types
										<div class="dropdown">
										  <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
											<i class="fa fa-cog" aria-hidden="true"></i>
										  </button>
										  <ul class="dropdown-menu">
											<li><a class="dropdown-item" href="#">Link 1</a></li>
											<li><a class="dropdown-item" href="#">Link 2</a></li>
											<li><a class="dropdown-item" href="#">Link 3</a></li>
										  </ul>
										</div>
									</h3>
								</div>
								<div class="add-top no-margin form-right">
									<div class="text-link">
										<a href="#">Confirmed</a>
										<a href="#">Close contact</a>
										<a href="#">Event</a>
										<a href="#">Auto-reply</a>
									</div>
								</div>
							</div>    
						</div>
					</div>
				</div>
			</div>
			</form>
		</div>
		
	</div>

<div class="footer-new">
	© Copyright 2021. All right reserved.
</div>

<!--start right Guidance section pop up-->
<div class="modal fade modal-design mail-widget" id="myModalcase">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Case Information</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <!-- Modal body class="filter-content"-->
      <div class="modal-body">
        <div id="info_contact" >
			<p>
				
			</p>
		</div>
      </div>

      
    </div>
  </div>
</div>
<!--end right Guidance section pop up-->

<!--start mail pop up here-->
<div class="modal fade modal-design mail-widget" id="myModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-envelope-o" aria-hidden="true"></i>  email</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
	  <form name="frm_mail" id="frm_mail">
      <!-- Modal body -->
      <div class="modal-body">
		<div class="filter-widget">
			<div class="mb-3">
				<div class="left-mail">To</div>
				<input type="text" class="form-control" placeholder="" id="to_email" name="to_email">
			</div>
			<div class="mb-3">
				<div class="left-mail">Cc</div>
				<input type="text" class="form-control" placeholder="" id="cc_mail" name="cc_mail">
			</div>
			<div class="mb-3">
				<div class="left-mail">Subject</div>
				<input type="text" class="form-control subject-gap" placeholder="" id="subject" name="subject">
			</div>
			<div class="mb-3">
				<div id="summernote"></div>
			</div>
			<button type="button" id="sub_button" class="send-btn">
				<i class="fa fa-paper-plane" aria-hidden="true"></i> Send
			</button>
			<span id="send_info" style="display:none">Sending...</span>
		</div>
      </div>
	</form>
    </div>
  </div>
<!--end mail pop up here-->



<script src="<?php echo base_url() ?>assets/mckinsey/js/jquery.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/metisMenu.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/main.js"></script>

<!--start summernotes js labraray-->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $('#summernote').summernote({
        placeholder: 'Enter Your Message',
        tabsize: 2,
        height: 120,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]
      });
  </script>
<!--js summernotes js labraray-->

<!--start data table library here-->
<script src="<?php echo base_url() ?>assets/mckinsey/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/buttons.bootstrap5.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/jszip.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/vfs_fonts.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/buttons.print.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/buttons.colVis.min.js"></script>

<script>
	$(document).ready(function() {
    var table = $('#example').DataTable( {
        lengthChange: false,
        buttons: [ 'excel', '', '', '' ]
    } );
 
    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );

function clon_colleagues(){
	mydiv=$('#mckinsey_colleagues_div').clone();
	mydiv.find('input:text, select')
                    .each(function () {
                        $(this).val('');
                    });
    mydiv.find('#mckinsey_colleagues_date').val('');                
	$('#mckinsey_colleagues_repeat').append(mydiv);
}
function clon_client(){
	mydiv=$('#mckinsey_client_div').clone();
	mydiv.find('input:text, select')
                    .each(function () {
                        $(this).val('');
                    });
    mydiv.find('#client_date').val('');                
	$('#mckinsey_client_repeat').append(mydiv);
}		
</script>

<!--end data table library here-->

<script>
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
</script>
<?php
include_once 'application/views/jscripts/contact_tracing/mackinsy/ticket_list_js.php';
?>
<script>
	$('#update_data').click(function(){
		var required = $('input,textarea,select').filter('[required]:visible');
		var allRequired = true;
		required.each(function(){
		    if($(this).val() == ''){
		    	$(this).css('border-color','red');
		        allRequired = false;
		    }
		});
		
		var actionurl = "<?php echo base_url();?>/mck/update_data";
		if(allRequired==true){
			$.ajax({
                url: actionurl,
                type: 'post',
                dataType: 'text',
                data: $("#edit_frm").serialize(),
                success: function(res) {
                	console.log(res);
                    alert('Data Updated Successfully');
                     location.reload(true);
                }
        });
		}
	});
	$('#self_isolated_start_date').blur(function() {
		var start_date=$(this).val();
		var newdate = new Date(start_date);
	    newdate.setDate(newdate.getDate() + 11);
	    var dd = newdate.getDate();
	    if(dd<10){
	    	dd='0'+dd;
	    }
    	var mm = newdate.getMonth() + 1;
    	if(mm<10){
    		mm='0'+mm
    	}
    	var y = newdate.getFullYear();
    	var endDate = y + '-' + mm + '-' + dd;
    	//alert(endDate);
    	$('#self_isolated_end_date').val(endDate);
	});
	$('#location').click(function(){
		loc=$(this).val();
		
		if(loc=='other'){
			$('#other_loc_div').css('display','');
		}
		else
		{
			$('#other_loc_div').css('display','none');
		}
	});
	function set_location(obj){
  	dt=$(obj).val();
  	
  	if(dt=='other'){
  		$(obj).closest(".col-sm-6").next('.col-sm-6').find("input").css('display','block');
  	}else{
  		$(obj).closest(".col-sm-6").next('.col-sm-6').find("input").css('display','none');
  	}
  	
  }
  $('#email').on('blur', function() {
    var re = /([A-Z0-9a-z_-][^@])+?@[^$#<>?]+?\.[\w]{2,4}/.test(this.value);
    if(!re) {
        alert('Invalid Email Address');
    } else {
        //alert('');
    }
});
$('.email').on('blur', function() {
    var re = /([A-Z0-9a-z_-][^@])+?@[^$#<>?]+?\.[\w]{2,4}/.test(this.value);
    if(!re) {
        alert('Invalid Email Address');
    } else {
        //alert('');
    }
});
function set_log_data(id){
	$('#sub_button').css('display','none');
	dt='incident_id='+id;
	var actionurl = "<?php echo base_url();?>/mck/get_mail_log";
			$.ajax({
                url: actionurl,
                type: 'post',
                dataType: 'text',
                data: dt,
                success: function(data) {
                	console.log(data);
                	var rw = jQuery.parseJSON(data);
                	$('#to_email').val(rw['to_email']);
                	$('#cc_mail').val(rw['cc_email']);
                	$('#subject').val(rw['subject']);
                	//$('#summernote').val(rw['body']);
                	$('#summernote').summernote('code', rw['email_body']);
                }
        });
} 
function activate_mail(obj){
  /*	var id=$(obj).attr('id');

  	if($(obj).is(':checked')){
     	$('#'+id+'_email').css('display','inline');
		 $(obj).closest('div').css('font-weight', 'bold');
;
	} else {
	    $('#'+id+'_email').css('display','none');
		$(obj).closest('div').css('font-weight', 'normal');
;
	}*/
  }
  function get_email_data(id){
  	/*var  dt=$("#edit_frm").serialize();
  	dt=dt+'&email_map_id='+id;
  	//console.log(dt);
  	
  	
  	var actionurl = "<?php echo base_url();?>/mck/get_mail_data";
			$.ajax({
                url: actionurl,
                type: 'post',
                dataType: 'text',
                data: dt,
                success: function(data) {
                	console.log(data);
                	var rw = jQuery.parseJSON(data);
					if(id=='drivable_well_email' || id=='colleague_away_from_home_email'||id=='colleague_seriously_ill_email'){
						$('#info_contact').html(rw['body']);
					}else{
  					$('#sub_button').css('display','');
  	
					$('#to_email').val(rw['to_email']);
                	$('#cc_mail').val(rw['cc_email']);
                	$('#subject').val(rw['subject']);
                	//$('#summernote').val(rw['body']);
                	$('#summernote').summernote('code', rw['body']);
					}
                }
        });*/
  }
  $('#email').on('blur', function() {
    var re = /([A-Z0-9a-z_-][^@])+?@[^$#<>?]+?\.[\w]{2,4}/.test(this.value);
    if(!re) {
        alert('Invalid Email Address');
    } else {
        //alert('');
    }
});
  $('#sub_button').on('click',function(){
  	var  dt=$("#frm_mail").serialize();
  	var incident_id=$('#incident_id').val();
  	var sumnote=$('#summernote').summernote('code');
	  $('#sub_button').css('display','none'); 
	 $('#send_info').css('display','inline'); 
  	//summnote=replaceAll(sumnote, "'", '`');
  	dt=dt+'&incident_id='+incident_id;
  	dt=dt+'&summernote='+sumnote;
  	//console.log(dt);
  	//console.log(sumnote);
  	var actionurl = "<?php echo base_url();?>/mck/send_mail";
			$.ajax({
                url: actionurl,
                type: 'post',
                dataType: 'text',
                data: dt,
                success: function(data) {
					console.log(data);
                	if(data==1){
                		alert('Mail Send Successfully');
                	}
					$('#sub_button').css('display','inline'); 
	 				$('#send_info').css('display','none');
                	$('#myModal').modal('hide');
                	$('#to_mail').val('');
                	$('#cc_mail').val('');
                	$('#subject').val('');
                	//$('#summernote').val(rw['body']);
                	$('#summernote').summernote('code', '');
                }
        });
  }); 
  function mail_popuo(){
	$('#myModal').modal('hide');
	$('#to_mail').val('');
	$('#cc_mail').val('');
	$('#subject').val('');
	//$('#summernote').val(rw['body']);
	$('#summernote').summernote('code', '');
  }
  function show_info(id){
	if(id='colleague_close_contact_email'){
		data='<p>First, call relevant leader to ensure you let them know that NA COVID Case Management team has already been looped in, to remind re: colleague privacy, and to answer any immediate questions or concerns they have.</p><p>Note: If helpful to have Gretchen (678-644-2680) on these calls initially, that is fine – just let me know w/ a text or phone call and we can call the person together</p><p>Follow-up emails, as needed only</p>';
	}
	$('#info_contact').html(data);
  }
  function active_onset(id){
	if($('#symptom_onset').is(':checked')){
		$('#date_of_symptom_onset_req').css('display','inline');
	    $('#date_of_symptom_onset').attr('required','required');
		$('#date_of_symptom_onset').removeAttr('disabled');
	}else{
		$('#date_of_symptom_onset_req').css('display','none');
	    $('#date_of_symptom_onset').removeAttr('required');
		$('#date_of_symptom_onset').attr('disabled','disabled');
	} 
  }
  function active_positive_test(id){
	if($('#test_result').is(':checked')){
		$('#positive_test_date_req').css('display','inline');
	    $('#positive_test_date').attr('required','required');
		$('#positive_test_date').removeAttr('disabled');
	}else{
		$('#positive_test_date_req').css('display','none');
	    $('#positive_test_date').removeAttr('required');
		$('#positive_test_date').attr('disabled','disabled');
	} 
  }
</script>

</body>
</html>