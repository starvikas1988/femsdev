<?php

	/*$gross_pay = $can_dtl_row['gross_pay'];
	$location = $can_dtl_row['location'];
	if($location=="") $location = $can_dtl_row['pool_location'];
	
	$basic = get_basic($gross_pay, $location);
	$hra =  get_hra($basic, $location);
	
	$conveyance = get_conveyance($gross_pay, $location);
	$other_allowance = get_allowance($gross_pay, $basic, $hra,$conveyance, $location);
	
	$pf = get_pf($gross_pay, $location);
	$ptax = get_ptax($gross_pay, $location);
	
	$esi_employer = get_esi_employer($gross_pay, $location);
	$esi_employee = get_esi_employee($gross_pay, $location);
	
	$ctc = $gross_pay + $esi_employer + $pf;
	$tk_home = round($gross_pay - ($pf + $esi_employee + $pf ));
	*/
?>
			
	<div style="margin:1px;">	
	
	<div id="body1" style='width:100%;'>
		<br><br>
		<p style='text-align:right;'>San Salvador, <?php echo date("F d, Y"); ?></p>
		<br/><br/><br/>
		<p>Dear : <?php echo $can_dtl_row['fname'].' '.$can_dtl_row['lname'] ?></p><br/>
							
		<p>FUSION BPO Services S.A de C.V is excited to bring you on board.</p>
		
		<p>FUSION BPO Services S.A de C.V is offering a full time position for you as <b><?php echo $can_dtl_row['position_name'];?></b>, starting on <b><?php echo date( "F d, Y", strtotime($can_dtl_row['doj'])); ?></b> at Colonia San Francisco Calle los Abetos casa # 6 San Salvador. </p>
		
		<p>In this position FUSION BPO Services. S.A de C.V is pleased to offer you a pay rate of <b>$<?php echo $can_dtl_row['gross_pay'] ?></b>. You will be paid on a basis, starting <b><?php echo date("F d, Y", strtotime($can_dtl_row['doj'])); ?></b>. </p>
		
		<p>Please indicate your agreement with these terms and accept this offer by signing and dating this agreement on <b><?php echo date("F d, Y"); ?></b>.</p>
		
		<p>We are looking forward to having you on our team.</p>
		<br/>
		<p>Sincerely.
		<br/><br/><br/>
		<b>Human Resources<br/>
		FUSION BPO Services S.A de C.
		</b></p>
		 
	</div>
		
</div>					
					
					