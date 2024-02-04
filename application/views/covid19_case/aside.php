<!-- APP ASIDE ==========-->


<?php 
$sectionCheck = array('personal', 'administrative', 'demographics', 'clinical', 'treatment', 'notes', 
					   'exposure', 'transmission', 'risk', 'aftercase', 'investigation', 'contacts');
					   
if(!empty($crm_treatment)){ 
	if($crm_treatment != 'Y'){
		$sectionCheck = array('personal', 'administrative', 'demographics', 'clinical', 'treatment', 'notes');
		$mysections = array('personal', 'administrative', 'demographics', 'clinical', 'treatment', 'notes');
		if(!empty($crmdetails['a_is_outbreak_related'])){ 
		if($crmdetails['a_is_outbreak_related'] == 'N'){
			$sectionCheck = array('personal', 'administrative', 'notes');
			$mysections = array('personal', 'administrative', 'notes');
		}}
	} 
}

if((!empty($crmdetails['ongoing_status']) && $crmdetails['ongoing_status'] == 'P') || (!empty($crmrow) && $crmrow['ongoing_status'] == 'P'))
{
	$sectionCheck = array('personal', 'administrative', 'demographics', 'clinical', 'treatment', 'notes', 
					   'exposure', 'transmission', 'risk', 'aftercase', 'investigation', 'contacts');
	$mysections = array('personal', 'administrative', 'demographics', 'clinical', 'treatment', 'notes', 'exposure', 'risk', 'aftercase');
	if(!empty($crmdetails['a_is_outbreak_related'])){ 
	if($crmdetails['a_is_outbreak_related'] == 'N'){
		$sectionCheck = array('personal', 'administrative', 'demographics', 'clinical', 'treatment', 'notes', 'exposure', 'risk', 'aftercase');
		$mysections = array('personal', 'administrative', 'demographics', 'clinical', 'treatment', 'notes', 'exposure', 'risk', 'aftercase');
	}}
}
		

$extraFormCheck = "";
if(($this->uri->segment(2) == 'form') && (!empty($this->uri->segment(3))) && (in_array($this->uri->segment(4), $sectionCheck))){
	$extraFormCheck = "return confirm('Are you sure you want to exit the form? All unsaved form changes will be lost? Click ok to exit or click cancel to continue with form?')";
}
?>
			
			
<style>
#sendFormFixed {
    position: fixed;
    top: 30%;
    right: 0px;
	display:none;
}

p.timerClock {
	/*visibility: hidden;*/
}
</style>

<?php if(($this->uri->segment(2) == 'form') && (!empty($this->uri->segment(3))) && (in_array($this->uri->segment(4), $sectionCheck))){ 
if((empty($crmdetails['case_status'])) && (empty($crmrow['case_status']))){
?>
<div id="sendFormFixed">
<a data-toggle="modal" data-target="#myEmailSendModal" class="btn btn-danger"><i class="fa fa-envelope"></i></a>
</div>

<div id="myEmailSendModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
	
	<form action="<?php echo base_url(); ?>covid_case/send_email" method="POST" autocomplete="off">
	
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Send Contact Tracing Form</h4>
      </div>
      <div class="modal-body">
		<?php 
		if(empty($crmrow['fname'])){
			if(!empty($crmdetails['fname'])){ $form_case_name = $crmdetails['fname'] ." " .$crmdetails['lname']; $form_email_id = $crmdetails['p_email']; } 
		} else { 
			if(!empty($crmrow['p_email'])){ $form_case_name = $crmrow['fname'] ." " .$crmrow['lname']; $form_email_id = $crmrow['p_email']; }
		}		
		?>

        <div class="row">
		<div class="col-md-6">
			<div class="form-group">
			  <label for="case">CRM ID</label>
			  <input type="text" class="form-control" id="form_crm_id" placeholder="" value="<?php echo $crmid; ?>" name="form_crm_id" required readonly>
			</div>
		</div>
		
		<div class="col-md-6">
			<div class="form-group">
			  <label for="case">Case Name</label>
			  <input type="text" class="form-control" id="form_case_name" placeholder="" value="<?php echo $form_case_name; ?>" name="form_case_name" required readonly>
			</div>
		</div>
		
		<div class="col-md-6">
			<div class="form-group">
			  <label for="case">E-Mail ID</label>
			  <input type="text" class="form-control" id="form_email_id" placeholder="" value="<?php echo $form_email_id; ?>" name="form_email_id" required readonly>
			</div>
		</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you want to send this form to <?php echo $form_email_id; ?>?');" name="crmFormSubmission">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
	  
	 </form> 
    </div>

  </div>
</div>
<?php } } ?>


<aside id="app-aside" class="app-aside left light">
	<div style="padding:20px 0; clear:both;"></div>
	<div class="aside-scroll">
		<div id="aside-scroll-inner" class="aside-scroll-inner">
			<ul class="aside-menu aside-left-menu">
						
				<li class="menu-item">
					<a href="<?php echo base_url()?>covid_case" class="menu-link" onclick="<?php echo $extraFormCheck; ?>">
						<span class="menu-icon"><i class="zmdi zmdi-view-dashboard zmdi-hc-lg"></i></span>
						<span class="">Dashboard</span>
					</a>
				</li>
				
				<li class="menu-item open">
					
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-email-open zmdi-hc-lg"></i></span>
						<span class="menu-text foldable">Contact Tracing</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					
					<ul class="submenu" style="display:block">
						
						<?php if(!is_crm_readonly_access_mindfaq()){ ?>
						<li>
							<a  href="<?php echo base_url()?>covid_case/form" onclick="<?php echo $extraFormCheck; ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">New Case</span>
							</a>
						</li>
						<?php } ?>
						
						<li>
							<a  href="<?php echo base_url()?>covid_case/updatecase" onclick="<?php echo $extraFormCheck; ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Search Case</span>
							</a>
						</li>
					
						<li>
							<a  href="<?php echo base_url()?>covid_case/case_list" onclick="<?php echo $extraFormCheck; ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Case List</span>
							</a>
						</li>
						
						<li>
							<a  href="<?php echo base_url()?>covid_case/case_individual_list" onclick="<?php echo $extraFormCheck; ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Public List</span>
							</a>
						</li>
					</ul>
						
				</li>
				
				
				
				<li class="menu-item">
					
					<a href="" class="menu-link submenu-toggle">
						<span class="menu-icon"><i class="zmdi zmdi-email-open zmdi-hc-lg"></i></span>
						<span class="menu-text foldable">QA Contact Tracing</span>
						<span class="menu-caret foldable"><i class="zmdi zmdi-hc-sm zmdi-chevron-right"></i></span>
					</a>
					
					<ul class="submenu">
						
						<li>
							<a  href="<?php echo base_url()?>qa_contact_tracing/add_feedback" onclick="<?php echo $extraFormCheck; ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Add Feedback</span>
							</a>
						</li>
						
						<li>
							<a  href="<?php echo base_url()?>qa_contact_tracing/" onclick="<?php echo $extraFormCheck; ?>">
								<span class="menu-icon"><i class="zmdi zmdi-assignment-check zmdi-hc-lg"></i></span>
								<span class="">Search Feedback</span>
							</a>
						</li>
					</ul>
										
				</li>
								
				
				</ul>
			</footer><!-- #sidebar-footer -->
		</div><!-- .aside-scroll-inner -->
	</div><!-- #aside-scroll -->
</aside>
<!--========== END app aside -->