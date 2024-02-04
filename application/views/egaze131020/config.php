<style>
.btn-sm{
	padding: 2px 5px;
}

.scrollheightdiv{
	max-height:500px;
	overflow-y:scroll;
}
</style>




<div class="wrap">
<section class="app-content">

<div class="row">

<div class="col-md-6">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title">Productive Apps <a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#papp"><i class="fa fa-plus"></i> Add New</a></h4>
</header>
<hr class="widget-separator"/>

	<div class="widget-body clearfix">
					
	<div class="scrollheightdiv">
	
	<table class="table table-bordered mb-0">
  
    <thead>
      <tr class="bg-primary text-white">
	    <th scope="col">#</th>
        <th scope="col">App</th>
		<th scope="col">Action</th>
      </tr>
    </thead>
	
    <tbody>
	
	<?php
	$countc = 0;
	foreach($myapp as $token){ 
		$countc++;
	?>
	
      <tr>
        <th scope="row"><?php echo $countc; ?></th>
        <th scope="row"><?php echo $token['app_name']; ?></th>
		<th scope="row"><a onclick="return confirm('Do you really want to delete?')" href="<?php echo base_url() ."activities/config?type=papp&did=" .$token['id'] ."&del=1"; ?>" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></a></th>
      </tr>
	<?php } ?>
	
    </tbody>
  </table>
		
		
	</div>
	
	
	</div>

</div>
</div>



<div class="col-md-6">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title">Productive Links <a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#plink"><i class="fa fa-plus"></i> Add New</a></h4>
</header>
<hr class="widget-separator"/>

<div class="widget-body clearfix">
				
<div class="scrollheightdiv">

  <table class="table table-bordered mb-0">
  
    <thead>
      <tr class="bg-primary text-white">
	    <th scope="col">#</th>
        <th scope="col">Url</th>
		<th scope="col">Action</th>
      </tr>
    </thead>
	
    <tbody>
	
	<?php
	$countc = 0;
	foreach($mylink as $token){ 
		$countc++;
	?>
	
      <tr>
        <th scope="row"><?php echo $countc; ?></th>
        <th scope="row"><?php echo $token['url']; ?></th>
		<th scope="row"><a onclick="return confirm('Do you really want to delete?')" href="<?php echo base_url() ."activities/config?type=plink&did=" .$token['id'] ."&del=1"; ?>" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></a></th>
      </tr>
	<?php } ?>
	
    </tbody>
  </table>

</div>

</div>

</div>
</div>


</div>





<div class="row">

<div class="col-md-6">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title">Unproductive Apps <a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#uapp"><i class="fa fa-plus"></i> Add New</a></h4>
</header>
<hr class="widget-separator"/>

	<div class="widget-body clearfix">
					
	<div class="scrollheightdiv">

   <table class="table table-bordered mb-0">
  
    <thead>
      <tr class="bg-primary text-white">
	    <th scope="col">#</th>
        <th scope="col">Apps</th>
		<th scope="col">Action</th>
      </tr>
    </thead>
	
    <tbody>
	
	<?php
	$counta = 0;
	foreach($myuapp as $token){ 
		$counta++;
	?>
	
      <tr>
        <th scope="row"><?php echo $counta; ?></th>
        <th scope="row"><?php echo $token['app_name']; ?></th>
		<th scope="row"><a onclick="return confirm('Do you really want to delete?')" href="<?php echo base_url() ."activities/config?type=uapp&did=" .$token['id'] ."&del=1"; ?>" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></a></th>
      </tr>
	<?php } ?>
	
	</tbody>	
	</table>
	
	</div>
	
	
	</div>

</div>
</div>



<div class="col-md-6">
<div class="widget">
<header class="widget-header">
<h4 class="widget-title">Unproductive Links <a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#ulink"><i class="fa fa-plus"></i> Add New</a></h4>
</header>
<hr class="widget-separator"/>

<div class="widget-body clearfix">
				
<div class="scrollheightdiv">

  <table class="table table-bordered mb-0">
  
    <thead>
      <tr class="bg-primary text-white">
	    <th scope="col">#</th>
        <th scope="col">Url</th>
		<th scope="col">Action</th>
      </tr>
    </thead>
	
    <tbody>
	
	<?php
	$countc = 0;
	foreach($myulink as $token){ 
		$countc++;
	?>
	
      <tr>
        <th scope="row"><?php echo $countc; ?></th>
        <th scope="row"><?php echo $token['url']; ?></th>
		<th scope="row"><a onclick="return confirm('Do you really want to delete?')" href="<?php echo base_url() ."activities/config?type=ulink&did=" .$token['id'] ."&del=1"; ?>" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></a></th>
      </tr>
	<?php } ?>
	
    </tbody>
  </table>

</div>

</div>

</div>
</div>


</div>




<div class="modal" id="papp" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
	<form method="POST">
      <div class="modal-header">
        <h5 class="modal-title"><b>Productive App</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
			<label for="productive_app">App Name</label>
			<input type="text" class="form-control" id="productive_app" name="productive_app"  placeholder="Enter App Name" required>
		  </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
	</form>
    </div>
  </div>
</div>



<div class="modal" id="plink" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
	<form method="POST">
      <div class="modal-header">
        <h5 class="modal-title"><b>Productive Link</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
			<label for="productive_link">URL Link</label>
			<input type="text" class="form-control" id="productive_link" name="productive_link"  placeholder="Enter URL" required>
		  </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
	</form>
    </div>
  </div>
</div>


<div class="modal" id="uapp" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
	<form method="POST">
      <div class="modal-header">
        <h5 class="modal-title"><b>Unproductive App</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
			<label for="unproductive_app">App Name</label>
			<input type="text" class="form-control" id="unproductive_app" name="unproductive_app"  placeholder="Enter App Name" required>
		  </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
	</form>
    </div>
  </div>
</div>


<div class="modal" id="ulink" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
	<form method="POST">
      <div class="modal-header">
        <h5 class="modal-title"><b>Unproductive URL</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
			<label for="unproductive_link">URL Link</label>
			<input type="text" class="form-control" id="unproductive_link" name="unproductive_link"  placeholder="Enter URL" required>
		  </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
	</form>
    </div>
  </div>
</div>


</section>
</div>
