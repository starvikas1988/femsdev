<style>
.btn-sm{
	padding: 2px 5px;
}

.scrollheightdiv{
	max-height:600px;
	overflow-y:scroll;
}
</style>




<div class="wrap">
<section class="app-content">

<div class="row">

<div class="col-md-8">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title"><i class="fa fa-search"></i> Search Ticket</h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">
<form autocomplete="off" method="GET" action="<?php echo base_url('emat/search_ticket'); ?>" enctype="multipart/form-data">				
	<div class="row">
	
	
	<div class="col-md-6">
	<div class="form-group">
		<label for="process_id">Ticket ID</label>
		<input type="text" class="form-control" name="ticket_id" value="<?php echo $ticket_no; ?>" required>
	</div>
	</div>
		
			
	</div>	
	<div class="row">
	<div class="col-md-12">
	<div class="form-group">
		<button type="submit" name="search" class="btn btn-primary">Search</button>
	</div>
	</div>
	</div>
</form>
</div>
</div>
</div>

<?php if(!empty($ticket_no)){ ?>

<div class="col-md-12">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title"><i class="fa fa-bar-chart"></i> Search Result</h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">

<div class="row">

<div class="col-md-4">		
<div class="table-responsive">
  <table id="default-datatable" class="table table-bordered mb-0 table table-striped skt-table" data-plugin="DataTable">  
      <tr>
	    <th class="bg-primary text-white">Mail Box</th>
        <td><?php echo $ticketInfo[0]['ticket_email']; ?></td>
      </tr>
	  <tr>
	    <th class="bg-primary text-white">Category</th>
        <td><?php echo $ticketInfo[0]['category_name']; ?></td>
      </tr>
	  <tr>
	    <th class="bg-primary text-white">Status</th>
        <td><?php echo !empty($ticketInfo[0]['is_open']) ? "<span class='text-danger'><b>Open</b></span>" : "<span class='text-danger'><b>Closed</b></span>" ; ?></td>
      </tr>
  </table>	
</div>
</div>


<div class="col-md-4">		
<div class="table-responsive">
  <table id="default-datatable" class="table table-bordered mb-0 table table-striped skt-table" data-plugin="DataTable">  
      <tr>
	    <th class="bg-primary text-white">Ticket Created</th>
        <td><?php echo $ticketInfo[0]['date_added']; ?></td>
      </tr>
	  <tr>
	    <th class="bg-primary text-white">Ticket Assigned</th>
        <td><?php echo $ticketAssign[0]['date_assigned']; ?></td>
      </tr>
	  <tr>
	    <th class="bg-primary text-white">Ticket Completed</th>
        <td>-</td>
      </tr>
  </table>	
</div>
</div>
</div>


</div>
</div>
</div>
<?php } ?>


</div>

<br/><br/><br/><br/><br/><br/><br/>

</section>
</div>



