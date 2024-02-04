<div class="row">
	<div class="col-md-12 fnf_info">
		<div class="panel panel-default">
			<div class="panel-body no_padding">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="case">Fusion ID</label>
							<input type="text" class="form-control" id="fnf_id" placeholder="" value="<?php echo $fnfdetails['fusion_id']; ?>" name="fnf_id" required readonly>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="case">Completed Date</label>
							<input type="text" class="form-control" id="fnf_date" placeholder="" value="<?php echo $fnfdetails['final_update_date']; ?>" name="fnf_date" readonly>
						</div>
					</div>
				</div>
				<div class="title_with_bg">
					<h4 class="phead">Local IT Team</h4>
				</div>
				<div class="top_1">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<h2 class="avail_title_heading">Return Date</h2>
							</div>
							<div class="form-group">
								<p><b>Computer/Laptop & Accessories : </b><?php echo $fnfdetails['is_return_date_computer']; ?>, <?php echo !empty($fnfdetails['return_date_computer']) ? $fnfdetails['return_date_computer'] : '-'; ?></p>
								<p><b>Headset : </b><?php echo $fnfdetails['is_return_date_headset']; ?>, <?php echo !empty($fnfdetails['return_date_headset']) ? $fnfdetails['return_date_headset'] : '-'; ?></p>
								<p><b>Any Other Tools/Accessories : </b><?php echo $fnfdetails['is_return_date_accessories']; ?>, <?php echo !empty($fnfdetails['return_date_accessories']) ? $fnfdetails['return_date_accessories'] : '-'; ?></p>
							</div>
						</div>
					</div>
				</div>
				<div class="top_1">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<h2 class="avail_title_heading">Disablement Date</h2>
							</div>
							<div class="form-group">
								<p><b>Dialer : </b><?php echo $fnfdetails['is_disablement_date_dialer']; ?>, <?php echo !empty($fnfdetails['disablement_date_dialer']) ? $fnfdetails['disablement_date_dialer'] : '-'; ?></p>
								<p><b>CRM : </b><?php echo $fnfdetails['is_disablement_date_crm']; ?>, <?php echo !empty($fnfdetails['disablement_date_crm']) ? $fnfdetails['disablement_date_crm'] : '-'; ?></p>
							</div>
						</div>
					</div>
				</div>

				<div class="title_with_bg">
					<h4 class="phead">IT Network Team</h4>
				</div>
				<div class="top_1">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<h2 class="avail_title_heading">Disablement Date</h2>
							</div>
							<div class="form-group">
								<p>Client/Fusion VPN ID : </b><?php echo $fnfdetails['is_disablement_date_vpn']; ?>, <?php echo !empty($fnfdetails['disablement_date_vpn']) ? $fnfdetails['disablement_date_vpn'] : '-'; ?></p>
								<p><b>Firewall Access List : </b><?php echo $fnfdetails['is_disablement_date_firewall']; ?>, <?php echo !empty($fnfdetails['disablement_date_firewall']) ? $fnfdetails['disablement_date_firewall'] : '-'; ?></p>
							</div>
						</div>
					</div>
				</div>
				<div class="title_with_bg">
					<h4 class="phead">IT Global Helpdesk</h4>
				</div>
				<div class="top_1">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<h2 class="avail_title_heading">Disablement Date</h2>
							</div>
							<div class="form-group">
								<p><b>Domain ID : </b><?php echo $fnfdetails['is_disablement_date_domain']; ?>, <?php echo !empty($fnfdetails['disablement_date_domain']) ? $fnfdetails['disablement_date_domain'] : '-'; ?></p>
								<p><b>Email ID : </b><?php echo $fnfdetails['is_disablement_date_email']; ?>, <?php echo !empty($fnfdetails['disablement_date_email']) ? $fnfdetails['disablement_date_email'] : '-'; ?></p>
								<p><b>Ticketing Portal ID : </b><?php echo $fnfdetails['is_disablement_date_ticket']; ?>, <?php echo !empty($fnfdetails['disablement_date_ticket']) ? $fnfdetails['disablement_date_ticket'] : '-'; ?></p>
							</div>
						</div>
					</div>
				</div>
				<div class="title_with_bg">
					<h4 class="phead">Payroll Team Checklist</h4>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<p><b>Last Month Unpaid Gross Salary : </b><?php echo !empty($fnfdetails['last_month_unpaid']) ? $fnfdetails['last_month_unpaid'] : '0'; ?></p>
							<p><b>Leave Encashment (If Applicable): </b><?php echo !empty($fnfdetails['leave_encashment']) ? $fnfdetails['leave_encashment'] : '0'; ?></p>
							<p><b>Notice Pay-Out (If Applicable) : </b><?php echo !empty($fnfdetails['notice_pay']) ? $fnfdetails['notice_pay'] : '0'; ?></p>
							<p><b>PF (If Applicable) : </b><?php echo !empty($fnfdetails['pf_deduction']) ? $fnfdetails['pf_deduction'] : '0'; ?></p>
							<p><b>ESIC (If Applicable) : </b><?php echo !empty($fnfdetails['esic_deduction']) ? $fnfdetails['esic_deduction'] : '0'; ?></p>
							<p><b>P.TAX (If Applicable) : </b><?php echo !empty($fnfdetails['ptax_deduction']) ? $fnfdetails['ptax_deduction'] : '0'; ?></p>
							<p><b>TDS (If Applicable) : </b><?php echo !empty($fnfdetails['tds_deductions']) ? $fnfdetails['tds_deductions'] : '0'; ?></p>
							<p><b>Loan/Joining Bonus (If Applicable) : </b><?php echo !empty($fnfdetails['loan_recovery']) ? $fnfdetails['loan_recovery'] : '0'; ?></p>
							<p><b>Total Deduction : </b><?php echo !empty($fnfdetails['total_deduction']) ? $fnfdetails['total_deduction'] : '0'; ?></p>
							<p><b>Net Payment : </b><?php echo !empty($fnfdetails['net_payment']) ? $fnfdetails['net_payment'] : '0'; ?></p>
							<p><b>Bio-Metric Access revocation Confirmation : </b><?php echo !empty($fnfdetails['biometric_access_revocation']) ? $fnfdetails['biometric_access_revocation'] : '-'; ?></p>
						</div>
					</div>
				</div>
				<div class="title_with_bg">
					<h4 class="phead">Accounts Team</h4>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<p><b>Salary Advance/ Loan Status : </b><?php echo !empty($fnfdetails['status_salary_loan']) ? $fnfdetails['status_salary_loan'] : '-'; ?></p>
							<p><b>Corporate Credit Card Status: </b><?php echo !empty($fnfdetails['status_credit_card']) ? $fnfdetails['status_credit_card'] : '-'; ?></p>
							<p><b>Company Gift Card status : </b><?php echo !empty($fnfdetails['status_gift_card']) ? $fnfdetails['status_gift_card'] : '-'; ?></p>
							<p><b>Reimbursement status : </b><?php echo !empty($fnfdetails['status_reimbursement']) ? $fnfdetails['status_reimbursement'] : '-'; ?></p>
							<p><b>Incentive / Bonus Status : </b><?php echo !empty($fnfdetails['status_incentive']) ? $fnfdetails['status_incentive'] : '-'; ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>