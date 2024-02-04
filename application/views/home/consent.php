<div class="wrap">
	<section class="app-content">	
	
		<div class="simple-page-wrap" style="width:80%;">
			
			<div class="simple-page-form animated flipInY">
				<h4 class="form-title m-b-xl text-center">Accept Consent</h4>
				
				<?php if($error!='') echo $error; ?>
					
		<div style="height: 500px;overflow-y: auto;padding:10px 10px">
			
		<p style="text-align: center;"><strong>DECLARATION OF CONSENT</strong></p>
		<p style="text-align: center;"><strong>ON</strong></p>
		<p style="text-align: center;"><strong>PERSONAL DATA PROCESSING AND TRANSFERRING</strong></p>
		<p>&nbsp;</p>
		<p>I, the undersigned <u>&nbsp;<?php echo get_username(); ?>&nbsp;</u>, born in <u>&nbsp;<?php echo $hr_row['dob']; ?>&nbsp;</u>, <!--on <u><?php echo date('Y-m-d'); ?></u>,--> identified by the identification card no <u><?php if(!$personal_row['social_security_no']){ echo $personal_row['social_security_no']; } else { echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; } ?></u>, major and with full capacity to act, upon my free and full will, declare as follows:</p>
		<p>I hereby authorize and give my consent to &nbsp;&ldquo;Fusion BPO Services&rdquo; sh.p.k, a limited liability company, registered with the National Business Center in the Republic of Albania under NUIS L82427012J to process ,whether or not by automatic means,&nbsp; by collecting, recording, organizing, storing, adapting or altering, retrieving, consulting, using, transmitting, disseminating or otherwise making available, aligning or combining, photographing, reflecting, entering, filling in, selecting, blocking, erasing or destructing my following personal data:</p>
		<ul style="list-style-type: disc;margin-left:20px;">
		<li>Name, surname, maiden name;</li>
		<li>Date of birth</li>
		<li>The birthplace;</li>
		<li>Gender;</li>
		<li>Marital status;</li>
		<li>Dependents;</li>
		<li>Work position;</li>
		<li>Educational level;</li>
		<li>Emergency contact information;</li>
		<li>Home Address;</li>
		<li>National identification number;</li>
		<li>Bank account details (Swift number IBAN; credit card);</li>
		<li>Telephone number;</li>
		<li>Email;</li>
		<li>Photography;</li>
		<li>Payroll data;</li>
		<li>Talent management information (letter of application, CV, previous employment background, education history, professional qualifications, language and other relevant skills);</li>
		<li>Compensation and benefits;</li>
		<li>Sensitive Personal Data only as required and permitted by Albanian Law: for example, diversity-related Sensitive Personal Data such as racial or ethnic origin in order to comply with legal obligations and internal policies relating to diversity and anti‑discrimination, health information as necessary to manage sickness absence and provide employee health and safety programs, including employee assistance plans, and information necessary to perform appropriate background checks.</li>
		</ul>

		<br/>
		<p>The abovementioned personal data will be collected and processed by &ldquo;Fusion BPO Services&rdquo; sh.p.k only for the purposes as below:</p>
		<ul style="list-style-type: number;margin-left:20px;">
		<li>Employment;</li>
		<li>Managing workforce;</li>
		<li>Human Resources Information System entry and administration;</li>
		<li>Communication and Emergencies, including pandemic planning and flu vaccine or anti-viral distribution, aiming at protecting the health and safety of employees and others, and facilitating communication in an emergency;</li>
		<li>Compliance with legal and other requirement (such as income tax and national insurance deductions, auditing, government inspections etc).</li>
		<li>Employee resource Usage and Corporate Investigations, as permitted by local law including the monitoring telephone, email, Internet, site access and other company resources, conducting internal investigations.</li>
		</ul>

		<br/>
		<p>Moreover, I agree and give my consent for the international transferring of my personal data to countries with adequate level of personal data protection determined on Decision of Information and Data Protection Commissioner &nbsp;No.8, dated 31.10.2016 &ldquo;On determining countries with adequate level of&nbsp; personal data protection&rdquo; &nbsp;where are located legal entities, part of the group companies Fusion, which are directly or indirectly related to &ldquo;Fusion BPO Services&rdquo;, including all of its operating units and affiliates.</p>

		<br/>
		<p>Particularly, I agree and give my consent for the international transferring of my personal data even in the states &nbsp;which don&rsquo;t provide adequate level of personal data protection, especially in India.</p>
		<p>Based on the above provisions, any collection, use, processing and international transferring of my personal data has to be performed in accordance with the legal provisions of the Albanian Law no. 9887, dated 10.03.2008, &ldquo;On the protection of the personal data&rdquo;, as amended and on the respective bylaws approved for its implementation.</p>
		<p>I admit that I have been informed in advance by Fusion BPO Services and I have read and agree to comply with the Fusion BPO Services Employee Personal Data Protection Notice.&nbsp;</p>
		<p>I also understand that under applicable law, none of the Personal Data can be collected, used, transferred or disclosed without my consent and that the Company reserves the right to undertake that activity after my approval as expressed in this Declaration of consent on Personal Data processing and transferring as permitted by Albanian law.</p>
		<p>By signing this declaration I give my consent and approval for the collection, use, process, international transferring and disclose of my personal data by Fusion BPO Services, as provided above in this declaration and only and exclusively for the intended and agreed purposes as defined herein.</p>
		<p>This declaration of consent has no term and can be revoked only through a written notification by the undersigned.</p>

		<p>&nbsp;</p>
		<p style="text-align: right;"><strong> Employee</strong></p>
		<p style="text-align: right;">(<?php echo get_username(); ?>)</p>
		<p style="text-align: right;">Signature</p>
		<p style="text-align: right;">_________________</p>
					
		</div>
		
		<br/><br/>

		<form action="<?php echo base_url(); ?>home/accept_consent" data-toggle="validator" autocomplete="off" method='POST'>
		
		<div class="form-group text-cener">
			<input type="checkbox" name="check_consent" id="check_consent" style="height:auto" required>
			<b>I agree and give my consent for personal data processing and transferring</b>
		</div>
			<input type="submit" class="btn btn-success" value="Save" name="submit">
		</form>
		
		
			</div>

		</div>
			
</section> 
</div>
