<!DOCTYPE html>
<html lang="en">
<head>
  <title>HR Attendance</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/attendance_reversal/css/custom.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/attendance_reversal/slick/slick.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/attendance_reversal/slick/slick-theme.css">
</head>
<body>

<div class="main">
	<div class="wrap">	
		<div class="gimini-main">
			<div class="common-top3">
				<div class="row align-items-center">
					<div class="col-sm-4">						
					</div>
					<div class="col-sm-4">
						<div class="up-in-toggle toggle_widget">
							<input type="radio" id="switch_left" name="switch_2" value="yes" checked />
							<label for="switch_left">Reversal</label>
							<input type="radio" id="switch_right" name="switch_2" value="no"/>
							<label for="switch_right">All</label>
						  </div>
					</div>
					<div class="col-sm-4">						
						<div class="common-right-new">
							<div class="right-attendance">
								<!-- <a href="javascript:void(0);" class="upload-btn">
									Reversal
								</a> -->
								<a href="#" class="upload-btn">
									Approvals
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="common_top">
				<div class="common-main">
					<div class="row">
						<div class="col-sm-12">
							<div class="common-repeat">
								<div class="white-widget no-padding approval_widget">
									<div class="metrix-widget all-gap">
										<div class="common-left-new">
											<h2 class="heading-title2">
												Approval
											</h2>
										</div>
									</div>
									<div class="slider responsive">
										<!--start slider loop here-->
										<div>
											<div class="table-widget">
												<div class="right-hr">
													<table class="table table-striped">										
														<tbody>
														<tr>
															<td>
																<div class="blue-title">
																	19<br>
																	<span>Mon</span>
																</div>
															</td>
															<td>
																<small>Name:</small> 
																<span class="small_blue_color">Manash Kundu</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Type -</span> 
																	<span class="small_blue_color">Leave</span>
																</div>
															</td>
															<td>
																<small>Days:</small> 
																<span class="small_blue_color">2</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Balance -</span> 
																	<span class="small_blue_color">5</span>
																</div>
															</td>
															<td>
																<small>From:</small> 
																<span class="small_blue_color">19-09-2022</span><br>
																<div class="total_hrs">
																	<span class="actual_new">To -</span> 
																	<span class="small_blue_color">21-09-2022</span>
																</div>
															</td>
															<td>
																<small>Applied:</small> 
																<span class="small_blue_color">19-09-2022</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Contact -</span> 
																	<span class="small_blue_color">123 456 7890</span>
																</div>
															</td>
															<td>
																<small>Shift:</small> 
																<span class="small_blue_color">9:00 - 17:00</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Expected -</span> 
																	<span class="small_blue_color">8:00:00</span>
																</div>
															</td>
															<td>
																<small>MWP:</small> 
																<span class="small_green_color">9:00 - 17:00</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Actual -</span> 
																	<span class="small_green_color">8:00:00</span>
																</div>
															</td>
															<td>
																<small>Dialer:</small> 
																<span class="small_red_color">9:00 - 16:40</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Actual -</span> 
																	<span class="small_red_color">7:40:00</span>
																</div>
															</td>
															<td>
																<a class="action_icon tooltip_new">
																	<i class="fa fa-check" aria-hidden="true"></i>
																	<span class="tooltiptext">Apply Reversal</span>															
																</a>
																<a class="action_icon red_icon tooltip_new">
																	<i class="fa fa-times" aria-hidden="true"></i>
																	<span class="tooltiptext">Cancel Reversal</span>															
																</a>
																<a class="icon-big" id="flip">
																	<i class="fa fa-angle-down down_arrow" aria-hidden="true"></i>																	
																</a>
																<a class="icon-big icon-big1" id="up_flip">
																	<i class="fa fa-angle-up up_arrow" style="display:none ;" aria-hidden="true"></i>
																</a>
															</td>
														</tr>
														<!--start textarea open-->
														<tr id="panel">
															<td>
															</td>
															<td colspan="10">
																<div class="content_widget">
																	<p>
																		<strong>L1 comments: </strong> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
																	</p>
																	<p>
																		<strong>RTA comments: </strong> the industry's standard dummy text ever since the 1500s, when an unknown
																	</p>
																</div>
															</td>
															
														</tr>
														<!--end textarea open-->
														<tr>
															<td>
																<div class="blue-title">
																	06<br>
																	<span>Sat</span>
																</div>
															</td>
															<td>
																<small>Name:</small> 
																<span class="small_blue_color">Kunal Bose</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Type -</span> 
																	<span class="small_blue_color">Absent</span>
																</div>
															</td>
															<td>
																<small>Days:</small> 
																<span class="small_blue_color">1</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Balance -</span> 
																	<span class="small_blue_color">3</span>
																</div>
															</td>
															<td>
																<small>From:</small> 
																<span class="small_blue_color">06-09-2022</span><br>
																<div class="total_hrs">
																	<span class="actual_new">To -</span> 
																	<span class="small_blue_color">06-09-2022</span>
																</div>
															</td>
															<td>
																<small>Applied:</small> 
																<span class="small_blue_color">06-09-2022</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Contact -</span> 
																	<span class="small_blue_color">123 456 7890</span>
																</div>
															</td>
															<td>
																<small>Shift:</small> 
																<span class="small_blue_color">9:00 - 17:00</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Expected -</span> 
																	<span class="small_blue_color">8:00:00</span>
																</div>
															</td>
															<td>
																<small>MWP:</small> 
																<span class="small_green_color">9:00 - 17:00</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Actual -</span> 
																	<span class="small_green_color">8:00:00</span>
																</div>
															</td>
															<td>
																<small>Dialer:</small> 
																<span class="small_green_color">9:00 - 17:20</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Actual -</span> 
																	<span class="small_green_color">8:20:00</span>
																</div>
															</td>
															<td>
																<a class="action_icon tooltip_new">
																	<i class="fa fa-check" aria-hidden="true"></i>
																	<span class="tooltiptext">Apply Reversal</span>															
																</a>
																<a class="action_icon red_icon tooltip_new">
																	<i class="fa fa-times" aria-hidden="true"></i>
																	<span class="tooltiptext">Cancel Reversal</span>															
																</a>
																<a class="icon-big">
																	<i class="fa fa-angle-down" aria-hidden="true"></i>																	
																</a>
															</td>
														</tr>														
														<tr>
															<td>
																<div class="blue-title">
																	15<br>
																	<span>Fri</span>
																</div>
															</td>
															<td>
																<small>Name:</small> 
																<span class="small_blue_color">Sankha Choudhury</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Type -</span> 
																	<span class="small_blue_color">Pending</span>
																</div>
															</td>
															<td>
																<small>Days:</small> 
																<span class="small_blue_color">3</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Balance -</span> 
																	<span class="small_blue_color">2</span>
																</div>
															</td>
															<td>
																<small>From:</small> 
																<span class="small_blue_color">15-07-2022</span><br>
																<div class="total_hrs">
																	<span class="actual_new">To -</span> 
																	<span class="small_blue_color">18-07-2022</span>
																</div>
															</td>
															<td>
																<small>Applied:</small> 
																<span class="small_blue_color">15-07-2022</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Contact -</span> 
																	<span class="small_blue_color">123 456 7890</span>
																</div>
															</td>
															<td>
																<small>Shift:</small> 
																<span class="small_blue_color">9:00 - 17:00</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Expected -</span> 
																	<span class="small_blue_color">8:00:00</span>
																</div>
															</td>
															<td>
																<!-- <small>MWP:</small> 
																<span class="small_green_color"></span><br>
																<div class="total_hrs">
																	<span class="actual_new">Actual -</span> 
																	<span class="small_green_color"></span>
																</div> -->
															</td>
															<td>
																<!-- <small>Dialer:</small> 
																<span class="small_red_color"></span><br>
																<div class="total_hrs">
																	<span class="actual_new">Actual -</span> 
																	<span class="small_red_color"></span>
																</div> -->
															</td>
															<td>
																<a class="action_icon tooltip_new">
																	<i class="fa fa-check" aria-hidden="true"></i>
																	<span class="tooltiptext">Apply Reversal</span>															
																</a>
																<a class="action_icon red_icon tooltip_new">
																	<i class="fa fa-times" aria-hidden="true"></i>
																	<span class="tooltiptext">Cancel Reversal</span>															
																</a>
																<a class="icon-big">
																	<i class="fa fa-angle-down" aria-hidden="true"></i>																	
																</a>
															</td>
														</tr>
														<tr>
															<td>
																<div class="blue-title">
																	02<br>
																	<span>Thu</span>
																</div>
															</td>
															<td>
																<small>Name:</small> 
																<span class="small_blue_color">Saikat Roy</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Type -</span> 
																	<span class="small_blue_color">Pending</span>
																</div>
															</td>
															<td>
																<small>Days:</small> 
																<span class="small_blue_color">4</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Balance -</span> 
																	<span class="small_blue_color">9</span>
																</div>
															</td>
															<td>
																<small>From:</small> 
																<span class="small_blue_color">02-06-2022</span><br>
																<div class="total_hrs">
																	<span class="actual_new">To -</span> 
																	<span class="small_blue_color">06-06-2022</span>
																</div>
															</td>
															<td>
																<small>Applied:</small> 
																<span class="small_blue_color">02-06-2022</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Contact -</span> 
																	<span class="small_blue_color">123 456 7890</span>
																</div>
															</td>
															<td>
																<small>Shift:</small> 
																<span class="small_blue_color">Week off</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Expected -</span> 
																	<span class="small_blue_color"></span>
																</div>
															</td>
															<td>
																<!-- <small>MWP:</small> 
																<span class="small_green_color"></span><br>
																<div class="total_hrs">
																	<span class="actual_new">Actual -</span> 
																	<span class="small_green_color"></span>
																</div> -->
															</td>
															<td>
																<!-- <small>Dialer:</small> 
																<span class="small_red_color"></span><br>
																<div class="total_hrs">
																	<span class="actual_new">Actual -</span> 
																	<span class="small_red_color"></span>
																</div> -->
															</td>
															<td>
																<a class="action_icon tooltip_new">
																	<i class="fa fa-check" aria-hidden="true"></i>
																	<span class="tooltiptext">Apply Reversal</span>															
																</a>
																<a class="action_icon red_icon tooltip_new">
																	<i class="fa fa-times" aria-hidden="true"></i>
																	<span class="tooltiptext">Cancel Reversal</span>															
																</a>
																<a class="icon-big">
																	<i class="fa fa-angle-down" aria-hidden="true"></i>																	
																</a>
															</td>
														</tr>
														<tr>
															<td>
																<div class="blue-title">
																	05<br>
																	<span>Thu</span>
																</div>
															</td>
															<td>
																<small>Name:</small> 
																<span class="small_blue_color">Rajan Singh</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Type -</span> 
																	<span class="small_blue_color">Leave</span>
																</div>
															</td>
															<td>
																<small>Days:</small> 
																<span class="small_blue_color">6</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Balance -</span> 
																	<span class="small_blue_color">7</span>
																</div>
															</td>
															<td>
																<small>From:</small> 
																<span class="small_blue_color">05-05-2022</span><br>
																<div class="total_hrs">
																	<span class="actual_new">To -</span> 
																	<span class="small_blue_color">11-05-2022</span>
																</div>
															</td>
															<td>
																<small>Applied:</small> 
																<span class="small_blue_color">05-05-2022</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Contact -</span> 
																	<span class="small_blue_color">123 456 7890</span>
																</div>
															</td>
															<td>
																<small>Shift:</small> 
																<span class="small_blue_color">9:00 - 17:00</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Expected -</span> 
																	<span class="small_blue_color">8:00:00</span>
																</div>
															</td>
															<td>
																<!-- <small>MWP:</small> 
																<span class="small_green_color"></span><br>
																<div class="total_hrs">
																	<span class="actual_new">Actual -</span> 
																	<span class="small_green_color"></span>
																</div> -->
															</td>
															<td>
																<!-- <small>Dialer:</small> 
																<span class="small_red_color"></span><br>
																<div class="total_hrs">
																	<span class="actual_new">Actual -</span> 
																	<span class="small_red_color"></span>
																</div> -->
															</td>
															<td>
																<a class="action_icon tooltip_new">
																	<i class="fa fa-check" aria-hidden="true"></i>
																	<span class="tooltiptext">Apply Reversal</span>															
																</a>
																<a class="action_icon red_icon tooltip_new">
																	<i class="fa fa-times" aria-hidden="true"></i>
																	<span class="tooltiptext">Cancel Reversal</span>															
																</a>
																<a class="icon-big">
																	<i class="fa fa-angle-down" aria-hidden="true"></i>																	
																</a>
															</td>
														</tr>
														<tr>
															<td>
																<div class="blue-title">
																	03<br>
																	<span>Sun</span>
																</div>
															</td>															
															<td>
																<small>Name:</small> 
																<span class="small_blue_color">Mohan Singh</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Type -</span> 
																	<span class="small_blue_color">Leave</span>
																</div>
															</td>
															<td>
																<small>Days:</small> 
																<span class="small_blue_color">1</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Balance -</span> 
																	<span class="small_blue_color">2</span>
																</div>
															</td>
															<td>
																<small>From:</small> 
																<span class="small_blue_color">03-04-2022</span><br>
																<div class="total_hrs">
																	<span class="actual_new">To -</span> 
																	<span class="small_blue_color">04-04-2022</span>
																</div>
															</td>
															<td>
																<small>Applied:</small> 
																<span class="small_blue_color">04-04-2022</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Contact -</span> 
																	<span class="small_blue_color">123 456 7890</span>
																</div>
															</td>
															<td>
																<small>Shift:</small> 
																<span class="small_blue_color">9:00 - 17:00</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Expected -</span> 
																	<span class="small_blue_color">8:00:00</span>
																</div>
															</td>
															<td>
																<small>MWP:</small> 
																<span class="small_green_color">9:00 - 17:00</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Actual -</span> 
																	<span class="small_green_color">8:00:00</span>
																</div>
															</td>
															<td>
																<small>Dialer:</small> 
																<span class="small_green_color">9:00 - 17:20</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Actual -</span> 
																	<span class="small_green_color">8:20:00</span>
																</div>
															</td>
															<td>
																<a class="action_icon tooltip_new">
																	<i class="fa fa-check" aria-hidden="true"></i>
																	<span class="tooltiptext">Apply Reversal</span>															
																</a>
																<a class="action_icon red_icon tooltip_new">
																	<i class="fa fa-times" aria-hidden="true"></i>
																	<span class="tooltiptext">Cancel Reversal</span>															
																</a>
																<a class="icon-big">
																	<i class="fa fa-angle-down" aria-hidden="true"></i>																	
																</a>
															</td>
														</tr>
														<tr>
															<td>
																<div class="blue-title">
																	10<br>
																	<span>Tue</span>
																</div>
															</td>
															<td>
																<small>Name:</small> 
																<span class="small_blue_color">Roshan Singh</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Type -</span> 
																	<span class="small_blue_color">Leave</span>
																</div>
															</td>
															<td>
																<small>Days:</small> 
																<span class="small_blue_color">9</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Balance -</span> 
																	<span class="small_blue_color">3</span>
																</div>
															</td>
															<td>
																<small>From:</small> 
																<span class="small_blue_color">10-05-2022</span><br>
																<div class="total_hrs">
																	<span class="actual_new">To -</span> 
																	<span class="small_blue_color">19-05-2022</span>
																</div>
															</td>
															<td>
																<small>Applied:</small> 
																<span class="small_blue_color">10-05-2022</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Contact -</span> 
																	<span class="small_blue_color">123 456 7890</span>
																</div>
															</td>
															<td>
																<small>Shift:</small> 
																<span class="small_blue_color">9:00 - 17:00</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Expected -</span> 
																	<span class="small_blue_color">8:00:00</span>
																</div>
															</td>
															<td>
																<small>MWP:</small> 
																<span class="small_green_color">9:00 - 17:00</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Actual -</span> 
																	<span class="small_green_color">8:00:00</span>
																</div>
															</td>
															<td>
																<small>Dialer:</small> 
																<span class="small_red_color">9:00 - 16:40</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Actual -</span> 
																	<span class="small_red_color">7:40:00</span>
																</div>
															</td>
															<td>
																<a class="action_icon tooltip_new">
																	<i class="fa fa-check" aria-hidden="true"></i>
																	<span class="tooltiptext">Apply Reversal</span>															
																</a>
																<a class="action_icon red_icon tooltip_new">
																	<i class="fa fa-times" aria-hidden="true"></i>
																	<span class="tooltiptext">Cancel Reversal</span>															
																</a>
																<a class="icon-big" id="flip1">
																	<i class="fa fa-angle-down down_arrow1" aria-hidden="true"></i>																	
																</a>
																<a class="icon-big icon-big1" id="up_flip1">
																	<i class="fa fa-angle-up up_arrow1" style="display:none ;" aria-hidden="true"></i>
																</a>
															</td>
														</tr>
														<!--start textarea open-->
														<tr id="panel1" style="display:none;background: #fff;">
															<td>
															</td>
															<td colspan="10">
																<div class="content_widget">
																	<p>
																		<strong>Employee comments: </strong> Change - 9:00am to 5:00pm | 8 hrs - Reason: Avaya issue.
																	</p>
																	<p>
																		<strong>L1 comments: </strong> Approved. 
																	</p>
																	<p>
																		<strong>RTA comments: </strong> Yet to be validated.
																	</p>
																</div>
															</td>
														</tr>
														<!--end textarea open-->
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<!--end slider loop here-->
										<div>
											<div class="table-widget">
												<div class="right-hr">
													<table class="table table-striped">										
														<tbody>
														<tr>
															<td class="yellow-left">
																<div class="blue-title">
																	05<br>
																	<span>Mon</span>
																</div>
															</td>
															<td>
																<small>Name:</small> 
																<span class="small_blue_color">Manash Kundu</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Type -</span> 
																	<span class="small_blue_color">Leave</span>
																</div>
															</td>
															<td>
																<small>Days:</small> 
																<span class="small_blue_color">2</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Balance -</span> 
																	<span class="small_blue_color">5</span>
																</div>
															</td>
															<td>
																<small>From:</small> 
																<span class="small_blue_color">19-09-2022</span><br>
																<div class="total_hrs">
																	<span class="actual_new">To -</span> 
																	<span class="small_blue_color">21-09-2022</span>
																</div>
															</td>
															<td>
																<small>Applied:</small> 
																<span class="small_blue_color">19-09-2022</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Contact -</span> 
																	<span class="small_blue_color">123 456 7890</span>
																</div>
															</td>
															<td>
																<small>Shift:</small> 
																<span class="small_blue_color">9:00 - 17:00</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Expected -</span> 
																	<span class="small_blue_color">8:00:00</span>
																</div>
															</td>
															<td>
																<small>MWP:</small> 
																<span class="small_green_color">9:00 - 17:00</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Actual -</span> 
																	<span class="small_green_color">8:00:00</span>
																</div>
															</td>
															<td>
																<small>Dialer:</small> 
																<span class="small_red_color">9:00 - 16:40</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Actual -</span> 
																	<span class="small_red_color">7:40:00</span>
																</div>
															</td>
															<td>
																<a class="action_icon tooltip_new">
																	<i class="fa fa-check" aria-hidden="true"></i>
																	<span class="tooltiptext">Apply Reversal</span>															
																</a>
																<a class="action_icon red_icon tooltip_new">
																	<i class="fa fa-times" aria-hidden="true"></i>
																	<span class="tooltiptext">Cancel Reversal</span>															
																</a>
																<a class="icon-big">
																	<i class="fa fa-angle-down" aria-hidden="true"></i>																	
																</a>
															</td>
														</tr>
														<tr>
															<td class="green-left">
																<div class="blue-title">
																	06<br>
																	<span>Tue</span>
																</div>
															</td>
															<td>
																<small>Name:</small> 
																<span class="small_blue_color">Rahul singh</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Type -</span> 
																	<span class="small_blue_color">Sick Leave</span>
																</div>
															</td>
															<td>
																<small>Days:</small> 
																<span class="small_blue_color">3</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Balance -</span> 
																	<span class="small_blue_color">5</span>
																</div>
															</td>
															<td>
																<small>From:</small> 
																<span class="small_blue_color">02-02-2022</span><br>
																<div class="total_hrs">
																	<span class="actual_new">To -</span> 
																	<span class="small_blue_color">04-02-2022</span>
																</div>
															</td>
															<td>
																<small>Applied:</small> 
																<span class="small_blue_color">04-02-2022</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Contact -</span> 
																	<span class="small_blue_color">123 456 7890</span>
																</div>
															</td>
															<td>
																<small>Shift:</small> 
																<span class="small_blue_color">9:00 - 17:00</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Expected -</span> 
																	<span class="small_blue_color">8:00:00</span>
																</div>
															</td>
															<td>
																<small>MWP:</small> 
																<span class="small_green_color">9:00 - 17:00</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Actual -</span> 
																	<span class="small_green_color">8:00:00</span>
																</div>
															</td>
															<td>
																<small>Dialer:</small> 
																<span class="small_green_color">9:00 - 17:20</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Actual -</span> 
																	<span class="small_green_color">8:20:00</span>
																</div>
															</td>
															<td>
																<a class="action_icon tooltip_new">
																	<i class="fa fa-check" aria-hidden="true"></i>
																	<span class="tooltiptext">Apply Reversal</span>															
																</a>
																<a class="action_icon red_icon tooltip_new">
																	<i class="fa fa-times" aria-hidden="true"></i>
																	<span class="tooltiptext">Cancel Reversal</span>															
																</a>
																<a class="icon-big">
																	<i class="fa fa-angle-down" aria-hidden="true"></i>																	
																</a>
															</td>
														</tr>
														<tr>
															<td class="red-left">
																<div class="blue-title">
																	07<br>
																	<span>Wed</span>
																</div>
															</td>
															<td>
																<small>Name:</small> 
																<span class="small_blue_color">Sakil khan</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Type -</span> 
																	<span class="small_blue_color">PL Leave</span>
																</div>
															</td>
															<td>
																<small>Days:</small> 
																<span class="small_blue_color">10</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Balance -</span> 
																	<span class="small_blue_color">2</span>
																</div>
															</td>
															<td>
																<small>From:</small> 
																<span class="small_blue_color">01-01-2022</span><br>
																<div class="total_hrs">
																	<span class="actual_new">To -</span> 
																	<span class="small_blue_color">11-01-2022</span>
																</div>
															</td>
															<td>
																<small>Applied:</small> 
																<span class="small_blue_color">01-01-2022</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Contact -</span> 
																	<span class="small_blue_color">123 456 7890</span>
																</div>
															</td>
															<td>
																<small>Shift:</small> 
																<span class="small_blue_color">9:00 - 17:00</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Expected -</span> 
																	<span class="small_blue_color">8:00:00</span>
																</div>
															</td>
															<td>
																<small>MWP:</small> 
																<span class="small_green_color">9:00 - 17:00</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Actual -</span> 
																	<span class="small_green_color">8:00:00</span>
																</div>
															</td>
															<td>
																<small>Dialer:</small> 
																<span class="small_red_color">9:00 - 16:40</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Actual -</span> 
																	<span class="small_red_color">7:40:00</span>
																</div>
															</td>
															<td>
																<a class="action_icon tooltip_new">
																	<i class="fa fa-check" aria-hidden="true"></i>
																	<span class="tooltiptext">Apply Reversal</span>															
																</a>
																<a class="action_icon red_icon tooltip_new">
																	<i class="fa fa-times" aria-hidden="true"></i>
																	<span class="tooltiptext">Cancel Reversal</span>															
																</a>
																<a class="icon-big">
																	<i class="fa fa-angle-down" aria-hidden="true"></i>																	
																</a>
															</td>
														</tr>
														<tr>
															<td class="sky-left">
																<div class="blue-title">
																	08<br>
																	<span>Thu</span>
																</div>
															</td>
															<td>
																<small>Name:</small> 
																<span class="small_blue_color">Siltu kolay</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Type -</span> 
																	<span class="small_blue_color">CL Leave</span>
																</div>
															</td>
															<td>
																<small>Days:</small> 
																<span class="small_blue_color">2</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Balance -</span> 
																	<span class="small_blue_color">9</span>
																</div>
															</td>
															<td>
																<small>From:</small> 
																<span class="small_blue_color">07-03-2022</span><br>
																<div class="total_hrs">
																	<span class="actual_new">To -</span> 
																	<span class="small_blue_color">09-03-2022</span>
																</div>
															</td>
															<td>
																<small>Applied:</small> 
																<span class="small_blue_color">07-03-2022</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Contact -</span> 
																	<span class="small_blue_color">123 456 7890</span>
																</div>
															</td>
															<td>
																<small>Shift:</small> 
																<span class="small_blue_color">9:00 - 17:00</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Expected -</span> 
																	<span class="small_blue_color">8:00:00</span>
																</div>
															</td>
															<td>
																<small>MWP:</small> 
																<span class="small_green_color">9:00 - 17:00</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Actual -</span> 
																	<span class="small_green_color">8:00:00</span>
																</div>
															</td>
															<td>
																<small>Dialer:</small> 
																<span class="small_red_color">9:00 - 16:40</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Actual -</span> 
																	<span class="small_red_color">7:40:00</span>
																</div>
															</td>
															<td>
																<a class="action_icon tooltip_new">
																	<i class="fa fa-check" aria-hidden="true"></i>
																	<span class="tooltiptext">Apply Reversal</span>															
																</a>
																<a class="action_icon red_icon tooltip_new">
																	<i class="fa fa-times" aria-hidden="true"></i>
																	<span class="tooltiptext">Cancel Reversal</span>															
																</a>
																<a class="icon-big">
																	<i class="fa fa-angle-down" aria-hidden="true"></i>																	
																</a>
															</td>
														</tr>
														<tr>
															<td class="light-sky-left">
																<div class="blue-title">
																	09<br>
																	<span>Fri</span>
																</div>
															</td>
															<td>
																<small>Name:</small> 
																<span class="small_blue_color">Saikat Naskar</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Type -</span> 
																	<span class="small_blue_color">Leave</span>
																</div>
															</td>
															<td>
																<small>Days:</small> 
																<span class="small_blue_color">6</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Balance -</span> 
																	<span class="small_blue_color">5</span>
																</div>
															</td>
															<td>
																<small>From:</small> 
																<span class="small_blue_color">02-04-2022</span><br>
																<div class="total_hrs">
																	<span class="actual_new">To -</span> 
																	<span class="small_blue_color">08-04-2022</span>
																</div>
															</td>
															<td>
																<small>Applied:</small> 
																<span class="small_blue_color">02-04-2022</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Contact -</span> 
																	<span class="small_blue_color">123 456 7890</span>
																</div>
															</td>
															<td>
																<small>Shift:</small> 
																<span class="small_blue_color">9:00 - 17:00</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Expected -</span> 
																	<span class="small_blue_color">8:00:00</span>
																</div>
															</td>
															<td>
																<small>MWP:</small> 
																<span class="small_green_color">9:00 - 17:00</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Actual -</span> 
																	<span class="small_green_color">8:00:00</span>
																</div>
															</td>
															<td>
																<small>Dialer:</small> 
																<span class="small_red_color">9:00 - 16:40</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Actual -</span> 
																	<span class="small_red_color">7:40:00</span>
																</div>
															</td>
															<td>
																<a class="action_icon tooltip_new">
																	<i class="fa fa-check" aria-hidden="true"></i>
																	<span class="tooltiptext">Apply Reversal</span>															
																</a>
																<a class="action_icon red_icon tooltip_new">
																	<i class="fa fa-times" aria-hidden="true"></i>
																	<span class="tooltiptext">Cancel Reversal</span>															
																</a>
																<a class="icon-big">
																	<i class="fa fa-angle-down" aria-hidden="true"></i>																	
																</a>
															</td>
														</tr>
														<tr>
															<td class="green-left">
																<div class="blue-title">
																	10<br>
																	<span>Sat</span>
																</div>
															</td>
															<td>
																<small>Name:</small> 
																<span class="small_blue_color">Dev Kumar</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Type -</span> 
																	<span class="small_blue_color">Leave</span>
																</div>
															</td>
															<td>
																<small>Days:</small> 
																<span class="small_blue_color">2</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Balance -</span> 
																	<span class="small_blue_color">7</span>
																</div>
															</td>
															<td>
																<small>From:</small> 
																<span class="small_blue_color">08-08-2022</span><br>
																<div class="total_hrs">
																	<span class="actual_new">To -</span> 
																	<span class="small_blue_color">10-08-2022</span>
																</div>
															</td>
															<td>
																<small>Applied:</small> 
																<span class="small_blue_color">08-08-2022</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Contact -</span> 
																	<span class="small_blue_color">123 456 7890</span>
																</div>
															</td>
															<td>
																<small>Shift:</small> 
																<span class="small_blue_color">9:00 - 17:00</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Expected -</span> 
																	<span class="small_blue_color">8:00:00</span>
																</div>
															</td>
															<td>
																<small>MWP:</small> 
																<span class="small_green_color">9:00 - 17:00</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Actual -</span> 
																	<span class="small_green_color">8:00:00</span>
																</div>
															</td>
															<td>
																<small>Dialer:</small> 
																<span class="small_red_color">9:00 - 16:40</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Actual -</span> 
																	<span class="small_red_color">7:40:00</span>
																</div>
															</td>
															<td>
																<a class="action_icon tooltip_new">
																	<i class="fa fa-check" aria-hidden="true"></i>
																	<span class="tooltiptext">Apply Reversal</span>															
																</a>
																<a class="action_icon red_icon tooltip_new">
																	<i class="fa fa-times" aria-hidden="true"></i>
																	<span class="tooltiptext">Cancel Reversal</span>															
																</a>
																<a class="icon-big">
																	<i class="fa fa-angle-down" aria-hidden="true"></i>																	
																</a>
															</td>
														</tr>
														<tr>
															<td class="dark-yellow-left">
																<div class="blue-title">
																	11<br>
																	<span>Sun</span>
																</div>
															</td>
															<td>
																<small>Name:</small> 
																<span class="small_blue_color">Anjali Thakur</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Type -</span> 
																	<span class="small_blue_color">PL Leave</span>
																</div>
															</td>
															<td>
																<small>Days:</small> 
																<span class="small_blue_color">9</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Balance -</span> 
																	<span class="small_blue_color">2</span>
																</div>
															</td>
															<td>
																<small>From:</small> 
																<span class="small_blue_color">10-09-2022</span><br>
																<div class="total_hrs">
																	<span class="actual_new">To -</span> 
																	<span class="small_blue_color">19-09-2022</span>
																</div>
															</td>
															<td>
																<small>Applied:</small> 
																<span class="small_blue_color">10-09-2022</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Contact -</span> 
																	<span class="small_blue_color">123 456 7890</span>
																</div>
															</td>
															<td>
																<small>Shift:</small> 
																<span class="small_blue_color">9:00 - 17:00</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Expected -</span> 
																	<span class="small_blue_color">8:00:00</span>
																</div>
															</td>
															<td>
																<small>MWP:</small> 
																<span class="small_green_color">9:00 - 17:00</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Actual -</span> 
																	<span class="small_green_color">8:00:00</span>
																</div>
															</td>
															<td>
																<small>Dialer:</small> 
																<span class="small_red_color">9:00 - 16:40</span><br>
																<div class="total_hrs">
																	<span class="actual_new">Actual -</span> 
																	<span class="small_red_color">7:40:00</span>
																</div>
															</td>
															<td>
																<a class="action_icon tooltip_new">
																	<i class="fa fa-check" aria-hidden="true"></i>
																	<span class="tooltiptext">Apply Reversal</span>															
																</a>
																<a class="action_icon red_icon tooltip_new">
																	<i class="fa fa-times" aria-hidden="true"></i>
																	<span class="tooltiptext">Cancel Reversal</span>															
																</a>
																<a class="icon-big">
																	<i class="fa fa-angle-down" aria-hidden="true"></i>																	
																</a>
															</td>
														</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
			
		</div>
	</div>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/attendance_reversal/slick/slick.min.js"></script>
<script src="<?php echo base_url();?>assets/attendance_reversal/js/progresscircle.js"></script>
<script src="<?php echo base_url();?>assets/attendance_reversal/js/custom.js"></script>
<script src="<?php echo base_url();?>assets/attendance_reversal/js/chart-bar.js"></script>
<script>
	$(document).ready(function(){
	  $("#flip").click(function(){
		$("#panel").slideToggle("slow");
	  });
	});
</script>
<script>
	$(document).ready(function(){
		$("#flip").click(function() {
			$(".down_arrow").hide();
			$(".up_arrow").show();
		});
		$("#up_flip").click(function() {
			$(".down_arrow").show();
			$(".up_arrow").hide();
			});
			$("#up_flip").click(function() {
			$("#panel").hide();
			});
	});
</script>

<script>
	$(document).ready(function(){
	  $("#flip1").click(function(){
		$("#panel1").slideToggle("slow");
	  });
	});
</script>
<script>
	$(document).ready(function(){
		$("#flip1").click(function() {
			$(".down_arrow1").hide();
			$(".up_arrow1").show();
		});
		$("#up_flip1").click(function() {
			$(".down_arrow1").show();
			$(".up_arrow1").hide();
			});
			$("#up_flip1").click(function() {
			$("#panel1").hide();
			});
	});
</script>
<script>	
$('.responsive').slick({
	  dots: false,
	  infinite: false,
	  speed: 300,
	  slidesToShow: 1,  
	  slidesToScroll: 1,  
	  responsive: [
		{
		  breakpoint: 1024,
		  settings: {
			slidesToShow: 1,
			slidesToScroll: 1,
			infinite: true,
			dots: false
		  }
		},
		{
		  breakpoint: 600,
		  settings: {
			slidesToShow: 1,
			slidesToScroll: 1
		  }
		},
		{
		  breakpoint: 480,
		  settings: {
			slidesToShow: 1,
			slidesToScroll: 1
		  }
		}    
	  ]
	});
	</script>
<script>
	var ctxBAR = document.getElementById("bar-chart5");
	var myBarChart_dailyVisitor = new Chart(ctxBAR, {
	type: 'line',
	stack: 'combined',
		data: {
		labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
		datasets: [
	{
	label: "Visitors",
		data: [12, 19, 15, 20, 20, 10],
			 backgroundColor: [
			  'rgba(55, 74, 216, 0.9)'			  
		],
		borderColor: [
		  'rgba(55, 74, 216, 0.9)'		  
		],
			borderWidth: 3
		}
	]
},
	options: {
		legend: { display: false, position: 'right' },
		title: {
		display: true,
		lineHeight: 2,
		text: ""
	},
	tooltips: {
		callbacks: {
			label: function(tooltipItem) {
			return tooltipItem.yLabel + '';
			}
		}
	},
		maintainAspectRatio: false,
			responsive: true,
			scales: {
		xAxes: [{
	}],
	yAxes: [{
		display:true,
		ticks: {
		callback: function(value, index, values) {
		return value + '';
	},
	beginAtZero: true,
		}
	}]
},
	plugins: {
		datalabels: {
			anchor: 'end',
			align: 'top',
			formatter: (value, ctx) => {
			return value + '';
			},
			font: {
			size:9,
			weight: 'bold'
			}
		}
	}
},
});
</script>


</body>
</html>