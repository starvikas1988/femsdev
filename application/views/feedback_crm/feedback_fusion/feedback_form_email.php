<html>
<head></head>
<body style="background-color: #eaeaea;">
<div class="survey-main" style="width: 80%;margin: 0 auto;">
			
<?php
$client_name = "Fusion";
$header_name = "Fusion BPO Services - Client Feedback";
if($crm_details['c_client'] == "FUSION"){
	$header_name = "Fusion BPO Services - Client Feedback";
	$client_name = "Fusion";
}
if($crm_details['c_client'] == "OMIND"){
	$header_name = "Omind Technologies - Client Feedback";
	$client_name = "Omind";
}
if($crm_details['c_client'] == "AD"){
	$header_name = "Ameridial - Client Feedback";
	$client_name = "Ameridial";
}


$brand_name = "Fusion";
if(!empty($crm_details['c_brand'])){ 
	$brand_name = $crm_details['c_brand'];
}
?>			
	     		  
		  
			<div class="common-repeat">
				<div class="white-main">
					<div class="blue-bg">
						<h2 class="heading-title" style="background-color: #15618d;padding: 5px 16px;color: #fff;">
							&nbsp;&nbsp;&nbsp; <?php echo $header_name; ?>
						</h2>
					</div>
					<div class="survey-content">
						<div class="body-widget">
							<p>
								We would love to hear your thoughts or feedback on how we can improve your experience!
							</p>
							
						</div>
					</div>
				</div>
			</div>
			
						
			<?php
			$values = array(
				"customer_training" => "Training Team",
				"customer_quality" => "Quality / Process Team",
				"customer_operations" => "Operations Managers",
				"customer_itteam" => "IT Team",
				"customer_workforce" => "Workforce Management",
			);
			$valuesService = array(
				"solve_training" => "Training Team",
				"solve_quality" => "Quality / Process Team",
				"solve_operations" => "Operations Managers",
				"solve_itteam" => "IT Team",
				"solve_workforce" => "Workforce Management",
			);			
			$options = array(
				"1" => "Strongly Disagree",
				"2" => "Disagree",
				"3" => "Neutral",
				"4" => "Agree",
				"5" => "Strongly Agree",
				"6" => "N/A",
			);
			?>
			
			
			<div class="common-repeat" style="background-color: #f4f4f4;">
				<div class="white-main">					
					<div class="survey-content" style="padding: 2px 20px;">
						<div class="body-widget">
							<p>
								There is strong collaboration / communication between the following <?php echo $client_name ; ?> departments: 
								<span class="red-color">*</span>
							</p>							
						</div>
						<div class="common-top">
							<div class="table-widget">
								<table class="table table-striped">
									<thead>
									  <tr>
										<th></th>
										<th>Strongly Disagree</th>
										<th>Disagree</th>
										<th>Neutral</th>
										<th>Agree</th>
										<th>Strongly Agree</th>
										<th>N/A</th>
									  </tr>
									</thead>
									<tbody>
									<?php foreach($values as $key=>$token){ ?>
									<tr>
										<td style="padding: 10px 25px;"><?php echo $token; ?></td>
										<?php foreach($options as $keyop=>$tokenOP){ ?>
										<td style="padding: 10px 25px;"><label class="radio-inline"><a href="<?php echo fdcrm_url('feedback/'.$urlForm); ?>"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAZCAYAAAGz7rX1AAAACXBIWXMAABJ0AAASdAHeZh94AAAF8WlUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNi4wLWMwMDIgNzkuMTY0NDg4LCAyMDIwLzA3LzEwLTIyOjA2OjUzICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgMjIuMCAoV2luZG93cykiIHhtcDpDcmVhdGVEYXRlPSIyMDIxLTA3LTIyVDE0OjI1OjU5KzA1OjMwIiB4bXA6TW9kaWZ5RGF0ZT0iMjAyMS0wNy0yMlQxNDozOTozOCswNTozMCIgeG1wOk1ldGFkYXRhRGF0ZT0iMjAyMS0wNy0yMlQxNDozOTozOCswNTozMCIgZGM6Zm9ybWF0PSJpbWFnZS9wbmciIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiIHBob3Rvc2hvcDpJQ0NQcm9maWxlPSJzUkdCIElFQzYxOTY2LTIuMSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpjZjM1NGNkMC0wNDU3LWRhNGUtYjk1OC0zODUyODE0NjZmMzYiIHhtcE1NOkRvY3VtZW50SUQ9ImFkb2JlOmRvY2lkOnBob3Rvc2hvcDpmYzU3ZGRhNC1hNTgxLWNlNDYtYTU5YS05ZGJmMmI5NmQ2OTMiIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDpkOWQ1Y2VkYy0zZjg3LTJkNDctOWIzYi01MDlkZWU5MTgxOTAiPiA8eG1wTU06SGlzdG9yeT4gPHJkZjpTZXE+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJjcmVhdGVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOmQ5ZDVjZWRjLTNmODctMmQ0Ny05YjNiLTUwOWRlZTkxODE5MCIgc3RFdnQ6d2hlbj0iMjAyMS0wNy0yMlQxNDoyNTo1OSswNTozMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgUGhvdG9zaG9wIDIyLjAgKFdpbmRvd3MpIi8+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJzYXZlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDpjZjM1NGNkMC0wNDU3LWRhNGUtYjk1OC0zODUyODE0NjZmMzYiIHN0RXZ0OndoZW49IjIwMjEtMDctMjJUMTQ6Mzk6MzgrMDU6MzAiIHN0RXZ0OnNvZnR3YXJlQWdlbnQ9IkFkb2JlIFBob3Rvc2hvcCAyMi4wIChXaW5kb3dzKSIgc3RFdnQ6Y2hhbmdlZD0iLyIvPiA8L3JkZjpTZXE+IDwveG1wTU06SGlzdG9yeT4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz51G4HIAAAB50lEQVRIia2VPbLqMAyFPzH3XTbFHrhL4S0qpUv6bCN0pgolXWyK84rYuc4PCY/hzDAZYulIio4sk0SJXXoq/YYXA77S0/ILKzm+sh/A7vF4sGhG+nNSAeAuabAcZ5ZYdgBmZiNus7/zGGVZZsblcsllCZBZX4PTBM45WZ/knG4H/MzSMhuyaTNNVVVazYrJwQGI3ntJUtd1cs4JqEf22amqqmniMwD18EnNrJO0X87lFyEE9vu95dbfthwAbrfbrKZ2LbWmaQQcRjUVOAKevlUd4MrDUiavY+JQO+fUdZ0kyXsvINK3YeZw36jjVDrUW33J0kASzs0U+KyZziQRQtB+v9lHzCysDdOSQz/w1+v1FXuAa9ZWlPRnzfLxePD9/f2Tv9KhaZqtgltg1IfTkuxjjL/GE4cMR68j0evqOCp8wWEdkpailDimqL6InNXs09nxmbPyWCwEOQFtVVWKMW6qJsaY5daSdboS5AC0W51ZQxqINnHNghyB+Ermr1RGP7LHaRCfr9FPIN0NXuWtY2bS/6pmA2aGJCuXbgghfCxA4gow3uzn8/n8sSCJqyfUWF31K1trC0nOdeZfmpMTcH9Hxkm+d4pZeRYk45Cyic45ee+HrSL1i9x7n5d5TLaHKYne2mlv4B/PvtrGfJq3hQAAAABJRU5ErkJggg==" /></a></label></td>
										<?php } ?>
									</tr>
									<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
			<div class="common-repeat" style="background-color: #f4f4f4;margin-top:20px">
				<div class="white-main">					
					<div class="survey-content" style="padding: 2px 20px;">
						<div class="body-widget">
							<p>
								The ability of following departments to solve problems, escalations and/or incidents:
								<span class="red-color">*</span>
							</p>							
						</div>
						<div class="common-top">
							<div class="table-widget">
								<table class="table table-striped">
									<thead>
									  <tr>
										<th></th>
										<th>Strongly Disagree</th>
										<th>Disagree</th>
										<th>Neutral</th>
										<th>Agree</th>
										<th>Strongly Agree</th>
									  </tr>
									</thead>
									<tbody>
									<?php foreach($valuesService as $key=>$token){ ?>
									<tr>
										<td style="padding: 10px 25px;"><?php echo $token; ?></td>
										<?php foreach($options as $keyop=>$tokenOP){ ?>
										<td style="padding: 10px 25px;"><label class="radio-inline"><a href="<?php echo fdcrm_url('feedback/'.$urlForm); ?>"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAZCAYAAAGz7rX1AAAACXBIWXMAABJ0AAASdAHeZh94AAAF8WlUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNi4wLWMwMDIgNzkuMTY0NDg4LCAyMDIwLzA3LzEwLTIyOjA2OjUzICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgMjIuMCAoV2luZG93cykiIHhtcDpDcmVhdGVEYXRlPSIyMDIxLTA3LTIyVDE0OjI1OjU5KzA1OjMwIiB4bXA6TW9kaWZ5RGF0ZT0iMjAyMS0wNy0yMlQxNDozOTozOCswNTozMCIgeG1wOk1ldGFkYXRhRGF0ZT0iMjAyMS0wNy0yMlQxNDozOTozOCswNTozMCIgZGM6Zm9ybWF0PSJpbWFnZS9wbmciIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiIHBob3Rvc2hvcDpJQ0NQcm9maWxlPSJzUkdCIElFQzYxOTY2LTIuMSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpjZjM1NGNkMC0wNDU3LWRhNGUtYjk1OC0zODUyODE0NjZmMzYiIHhtcE1NOkRvY3VtZW50SUQ9ImFkb2JlOmRvY2lkOnBob3Rvc2hvcDpmYzU3ZGRhNC1hNTgxLWNlNDYtYTU5YS05ZGJmMmI5NmQ2OTMiIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDpkOWQ1Y2VkYy0zZjg3LTJkNDctOWIzYi01MDlkZWU5MTgxOTAiPiA8eG1wTU06SGlzdG9yeT4gPHJkZjpTZXE+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJjcmVhdGVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOmQ5ZDVjZWRjLTNmODctMmQ0Ny05YjNiLTUwOWRlZTkxODE5MCIgc3RFdnQ6d2hlbj0iMjAyMS0wNy0yMlQxNDoyNTo1OSswNTozMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgUGhvdG9zaG9wIDIyLjAgKFdpbmRvd3MpIi8+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJzYXZlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDpjZjM1NGNkMC0wNDU3LWRhNGUtYjk1OC0zODUyODE0NjZmMzYiIHN0RXZ0OndoZW49IjIwMjEtMDctMjJUMTQ6Mzk6MzgrMDU6MzAiIHN0RXZ0OnNvZnR3YXJlQWdlbnQ9IkFkb2JlIFBob3Rvc2hvcCAyMi4wIChXaW5kb3dzKSIgc3RFdnQ6Y2hhbmdlZD0iLyIvPiA8L3JkZjpTZXE+IDwveG1wTU06SGlzdG9yeT4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz51G4HIAAAB50lEQVRIia2VPbLqMAyFPzH3XTbFHrhL4S0qpUv6bCN0pgolXWyK84rYuc4PCY/hzDAZYulIio4sk0SJXXoq/YYXA77S0/ILKzm+sh/A7vF4sGhG+nNSAeAuabAcZ5ZYdgBmZiNus7/zGGVZZsblcsllCZBZX4PTBM45WZ/knG4H/MzSMhuyaTNNVVVazYrJwQGI3ntJUtd1cs4JqEf22amqqmniMwD18EnNrJO0X87lFyEE9vu95dbfthwAbrfbrKZ2LbWmaQQcRjUVOAKevlUd4MrDUiavY+JQO+fUdZ0kyXsvINK3YeZw36jjVDrUW33J0kASzs0U+KyZziQRQtB+v9lHzCysDdOSQz/w1+v1FXuAa9ZWlPRnzfLxePD9/f2Tv9KhaZqtgltg1IfTkuxjjL/GE4cMR68j0evqOCp8wWEdkpailDimqL6InNXs09nxmbPyWCwEOQFtVVWKMW6qJsaY5daSdboS5AC0W51ZQxqINnHNghyB+Ermr1RGP7LHaRCfr9FPIN0NXuWtY2bS/6pmA2aGJCuXbgghfCxA4gow3uzn8/n8sSCJqyfUWF31K1trC0nOdeZfmpMTcH9Hxkm+d4pZeRYk45Cyic45ee+HrSL1i9x7n5d5TLaHKYne2mlv4B/PvtrGfJq3hQAAAABJRU5ErkJggg==" /></a></label></td>
										<?php } ?>
									</tr>
									<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="common-repeat" style="margin-top: 28px; margin-bottom: 20px;">
				<div class="white-main">										
					<a href="<?php echo fdcrm_url('feedback/'.$urlForm); ?>" style="color: #fff;">
					<span class="heading-title" style="background-color: red;padding: 5px 16px;color: #fff;font-family: tahoma;font-size: 16px;"> Submit Feedback</span>
					</a>
				</div>
			</div>
			
</div>
</body>
</html>