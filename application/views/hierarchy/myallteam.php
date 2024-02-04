<style>
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		vertical-align:middle;
		padding:2px 10px;
		font-size:11px;
		font-weight:600;
	}
	
	.table > thead > tr > th,.table > tfoot > tr > th{
			text-align:center;
	}

	.inputTable > tr > td{
		font-size:12px;
		padding:4px;
	}
	
	.hide{
	  disply:none;	  
	}
	
	.modal-dialog {
		width: 800px;
	}
	.modal
	{
		overflow:auto;
	}
	
	td a{
	   cursor:pointer;
	   font-size: 20px;
	}
	
	td img{
		display:none;
	}
	
	.initialtrmore{ background-color:#ddeff4; }
	.initialtr{ background-color:#edfbff; }
	.highlightedtr{ background-color:#ffe0e0!important; }
	.selectedtr{ background-color:#e8dfdf; }
	.finaltr{ background-color:#fbfbfb; }
	
	.selectedtr>td{
		margin-top:10px;
	}
	.increasesize{
		font-size:16px!important;
	}
	.increasesizetext{
		font-size:12px!important;
	}
	
	.bluritnow {
		color: transparent;
		text-shadow: 0 0 3px #aaa;
	}

	.blurremovenow {
		color: #444;
		text-shadow: 0 1px 0 #fff;
	}
	
</style>


<!-- Metrix -->



<div class="wrap">
<section class="app-content">
	
<div class="row">
<div class="col-md-12">
	
<div class="widget">
<header class="widget-header">
	<h4 class="widget-title"><i class="fa fa-user"></i> <?php echo $parentdetails['fullname']; ?> - <?php echo $parentdetails['rolename']; ?></h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">
	
<div class="table-responsive">
<table id="default-datatable" data-plugin="DataTable" class="table skt-table" width="100%" cellspacing="0">
	<thead>
		<tr class="bg-info">
			<td>#</td>
			<td>Photo</td>
			<td>Sl</td>
			<td>Fusion ID</td>
			<td>Name</td>
			<td>Designation</td>
			<td>Department</td>
			<td>Team (If Any)</td>
		</tr>
	</thead>
	<tbody>
	<?php 
	$sl = 0; 
	foreach($folder as $token){ 
	$mytr = "initialtr";
	if($token['team'] > 0){ $mytr = "initialtrmore"; }
	?>
	   <tr class="<?php echo $mytr; ?>">
		  <td>
		  <?php if($token['team'] > 0){ ?>
		  <a title="<?php echo $token['team']; ?> Team" id="moreteam<?php echo $token['id']; ?>" style="" parentid="<?php echo $token['id']; ?>" parentname="<?php echo $token['fullname']; ?>" onclick="displayteam(this,<?php echo $token['id']; ?>);">
		  <i class="fa fa-plus-circle"></i></a>
		  <?php } ?>
		  </td>
		  <td><img src="<?php echo $token['photo']; ?>" width="30" /></td>
		  <td><?php echo ++$sl; ?></td>
		  <td><?php echo $token['fusion_id']; ?></td>
		  <td class="increasesizetext"><?php echo $token['fullname']; ?></td>
		  <td><?php echo $token['rolename']; ?></td>
		  <td><?php echo $token['d_fullname']; ?></td>
		  <td class="increasesize"><?php echo $token['team'] > 0 ? $token['team'] : ""; ?></td>
	   </tr>
	   
	<?php } ?>
	</tbody>
</table>
</div>

</div>

</div>
</div>
</div>
		
		
</section>
</div>

