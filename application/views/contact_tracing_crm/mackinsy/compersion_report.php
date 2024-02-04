<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <title>Mckinsey Crm</title>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/mckinsey/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/mckinsey/css/style.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/mckinsey/css/custom.css">    
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/mckinsey/css/metisMenu.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">   
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&amp;display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/mckinsey/css/buttons.bootstrap5.min.css">
	
	<style>
		.footer-new {
			position:fixed;
		}
	</style>
	
</head>

<body>

<div id="page-container">
    <div class="header-area">
        <div class="header-area-left">
            <a href="<?php echo base_url() ?>/home" class="logo">
                <img src="<?php echo base_url() ?>assets/mckinsey/images/logo.png" class="logo" alt="">
            </a>
        </div>		
        <div class="row align-items-center header_right">           
               <?php include('menu.php');?>          
            </div>            
        </div>

    </div>
   
    <div class="main-content page-content">
        <div class="main-content-inner">			
			<div class="white-area">
				<h3 class="heading-small">
					Active North American Cases - by location
				</h3>
				<div class="top-filter">
					<form name="frm" id="frm" method="post" action="">
						<div class="row">
							<div class="col-sm-3">
								<div class="mb-2">
									<label>Date :</label>
									<input type="date" class="form-control" name="end_date" id="end_date" value="<?php echo $sdate;?>">
								</div>
							</div>
							<div class="col-sm-3">
								<div class="mb-2">
									<button type="submit" class="search-btn">
										<i class="fa fa-search" aria-hidden="true"></i>
									</button>
								</div>
							</div>						
						</div>					
					</form>
				</div>
				<table class="table table-striped">
					<thead>
					  <tr>		
						<th></th>
						<th>Symptomatic_1</th>
						<th>Suspect_1</th>
						<th>Confirmed_1</th>
						<th>Close contact_1</th>
						<th>Symptomatic_2</th>
						<th>Suspect_2</th>
						<th>Confirmed_2</th>
						<th>Close contact_2</th>
						<th>Change in symptomatic1</th>
						<th>Change in suspect</th>
						<th>Change in confirmed</th>
						<th>change Close contact2</th>
					  </tr>
					</thead>					
					<tbody>
					<?php 
					$Symptomatic=0;$Suspect=0;
					foreach($prev as $key=>$rws){
						//echo'<pre>';print_r($rws);
						$prevSymptomatic=$prevSymptomatic+$rws['Symptomatic'];$prevSuspect=$prevSuspect+$rws['Suspect'];$prevConfirmed=$prevConfirmed+$rws['Confirmed'];$prevclose=$prevclose+$rws['Close contact & what type'];

						$Symptomatic=$Symptomatic+$current[$key]['Symptomatic'];$Suspect=$Suspect+$current[$key]['Suspect'];$Confirmed=$Confirmed+$current[$key]['Confirmed'];$close=$close+$current[$key]['Close contact & what type'];

						$totSymptomatic=$totSymptomatic+($rws['Symptomatic']-$current[$key]['Symptomatic']);$totSuspect=$totSuspect+($rws['Suspect']-$current[$key]['Suspect']);$totConfirmed=$totConfirmed+($rws['Confirmed']-$current[$key]['Confirmed']);$totclose=$totclose+($rws['Close contact & what type']-$current[$key]['Close contact & what type']);

					?>	
					  <tr>
						<td><?php echo $key;?></td>
						<td><?php echo $rws['Symptomatic'];?></td>
						<td><?php echo $rws['Suspect'];?></td>
						<td><?php echo $rws['Confirmed'];?></td>
						<td><?php echo $rws['Close contact & what type'];?></td>
						<td><?php echo $current[$key]['Symptomatic'];?></td>
						<td><?php echo $current[$key]['Suspect'];?></td>
						<td><?php echo $current[$key]['Confirmed'];?></td>
						<td><?php echo $current[$key]['Close contact & what type'];?></td>
						<td><?php echo ($rws['Symptomatic']-$current[$key]['Symptomatic']);?></td>
						<td><?php echo ($rws['Suspect']-$current[$key]['Suspect']);?></td>
						<td><?php echo ($rws['Confirmed']-$current[$key]['Confirmed']);?></td>
						<td><?php echo ($rws['Close contact & what type']-$current[$key]['Close contact & what type']);?></td>
					  </tr>
					  <?php } ?>
					  
					</tbody>
					<tfoot>	
					<tr>
						<td><strong>Total</strong></td>
						<td><?php echo $prevSymptomatic;?></td>
						<td><strong><?php echo $prevSuspect;?></strong></td>
						<td><?php echo $prevConfirmed;?></td>
						<td><?php echo $prevclose;?></td>
						<td><?php echo $Symptomatic;?></td>
						<td><?php echo $Suspect;?></td>
						<td><?php echo $Confirmed;?></td>
						<td><?php echo $close;?></td>
						<td><?php echo $totSymptomatic;?></td>
						<td><?php echo $totSuspect;?></td>
						<td><?php echo $totConfirmed;?></td>
						<td><?php echo $totclose;?></td>
					  </tr>	
					</tfoot>
				</table>
			</div>
			<hr>
			<!--<div class="white-area">
				<div class="top-filter">
					<a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#myModal" class="mail-icon mail-icon1">
						<i class="fa fa-envelope-o" aria-hidden="true"></i>
					</a>
					<h3 class="heading-small">
						Active North American Cases - by location
					</h3>
					<table id="example" class="table table-striped">
						<thead>
						  <tr>
							<th>
								<select>
									<option>Canada</option>
									<option>Mexico</option>
									<option>United States</option>
								</select>
							</th>
							<th>Symptomatic</th>
							<th>Suspect</th>
							<th>Confirmed</th>
							<th>Change in symptomatic1</th>
							<th>Change in suspect</th>
							<th>Change in confirmed</th>
							<th>Close contact2</th>
							<th>Change in CC</th>
							<th>Confirmed</th>
							<th>Change in Confirmed</th>
						  </tr>
						</thead>
						<thead>						
							<tr class="country-bg">
								<td colspan="12">Canada</td>
							</tr>
						</thead>
						<tbody>
						  <tr>
							<td>CAL</td>
							<td>0</td>
							<td>1</td>
							<td>1</td>
							<td>-</td>
							<td>-</td>
							<td>-3</td>
							<td>0</td>
							<td>-</td>
							<td>56</td>
							<td>3</td>
						  </tr>
						  <tr>
							<td>MON</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>-</td>
							<td>-</td>
							<td>-3</td>
							<td>0</td>
							<td>-</td>
							<td>56</td>
							<td>3</td>
						  </tr>
						  <tr>
							<td>TOR</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>-</td>
							<td>-</td>
							<td>-3</td>
							<td>0</td>
							<td>-</td>
							<td>56</td>
							<td>3</td>
						  </tr>
						  <tr>
							<td>VAN</td>
							<td>0</td>
							<td>0</td>
							<td>0</td>
							<td>-</td>
							<td>-</td>
							<td>-3</td>
							<td>0</td>
							<td>-</td>
							<td>56</td>
							<td>3</td>
						  </tr>						  
						</tbody>
						<tfoot>	
						<tr>
							<td><strong>Total</strong></td>
							<td>0</td>
							<td><strong>30</strong></td>
							<td>0</td>
							<td>-</td>
							<td>-</td>
							<td>-3</td>
							<td>0</td>
							<td>-</td>
							<td>56</td>
							<td>3</td>
						  </tr>	
						</tfoot>	
					  </table>
				  </div>
			</div>-->
		</div>
		
	</div>

<div class="footer-new">
	© Copyright 2022. All right reserved.
</div>


<script src="<?php echo base_url() ?>assets/mckinsey/js/jquery.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/metisMenu.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url() ?>assets/mckinsey/js/main.js"></script>
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
        buttons: [ 'excel']
    } );
 
    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );
</script>
<?php
include_once 'application/views/jscripts/contact_tracing/mackinsy/ticket_list_js.php';
?>
<!--buttons: [ 'excel', 'pdf', '', '' ]-->
<!--end data table library here-->
</body>
</html>