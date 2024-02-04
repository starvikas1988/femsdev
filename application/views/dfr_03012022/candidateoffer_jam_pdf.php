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
		<br><br><br>
		<p style='text-align:right;'><?php echo date("F d, Y"); ?></p>
		<br/><br/><br/>
		<p>Dear : <?php echo $can_dtl_row['fname'].' '.$can_dtl_row['lname'] ?></p>
		
		<p>Fusion BPO Services Jamaica is pleased to extend this offer of employment for the position of <b><u><?php echo $can_dtl_row['position_name'];?><u></b>.</p>
		
		<p>If you accept this job offer you will start your new post on (<?php echo date( "F d, Y", strtotime($can_dtl_row['doj'])); ?>). The current gross monthly salary is ($<?php echo $can_dtl_row['gross_pay'] ?>) which will be subjected to the relevant Government taxes. </p>
		
		<p>Consequently, your contract signing will be on (<?php echo date( "F d, Y", strtotime($can_dtl_row['doj'])); ?>) at our Head Office at 15 Old Hope Road, Kingston 5. </p>
		
		<p>We would like a response to the job offer no later than (<?php echo date( "F d, Y", strtotime($can_dtl_row['doj'])); ?>) and in the meantime please feel free to contact the undersigned at email karen.adlam@fusionbposervices.com if you have any queries relating to this employment.</p>
		
		<p>We are looking forward to having you on our team.</p>
		
		<!--<p>Fusion BPO Services Jamaica would like welcome you to the Company as a (<?php echo $can_dtl_row['position_name'];?>). The salary being offered is (<?php echo ucwords(strtolower(numberTowords($can_dtl_row['gross_pay']))); ?> Dollars ($<?php echo $can_dtl_row['gross_pay'] ?>)) per month.  
		   You are to report for training and onboarding on( <?php echo date( "F d, Y", strtotime($can_dtl_row['doj'])); ?>) at our Head Office located at 15 Old Hope Road, Kingston 5.</p>
		<br/>
		<p>If for any reason you are unable to take up the offer above; please call 876-619-8000-1 or email the recruitment desk at fusionrecruitmentjamaica@gmail.com.</p>
		<br/>
		<p>We would like to welcome you to the Fusion BPO Services family.</p>
		-->
		<br/><br/>
		<p>Kind Regards.<br/>
		<strong>Karen Fyffe-Adlam<br/>
		HR Generalist<br/>
		Fusion BPO Services</strong></p>
		 
	</div>
		
</div>					
					
					