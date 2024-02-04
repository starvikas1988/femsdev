<div class="wrap">
<section class="app-content">

<div class="widget">
<header class="widget-header">
	<h2 class="widget-title">Dynamic POP Up system</h2>
</header>
<hr class="widget-separator">


<div class="widget-body">
<div class="row">
<div class="col-md-12">

<table class="table table-sm">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Preferences</th>
      <th scope="col">Location</th>
      <th scope="col">Client</th>
      <th scope="col">Process</th>
      <th scope="col">Individual Id</th>
      <th scope="col">Team</th>
      <th scope="col">Image</th>
      <th scope="col">Start Time</th>
      <th scope="col">End Time</th>
      <th scope="col">Edit</th>
      <th scope="col">Delete</th>
    </tr>
  </thead>
  <tbody>
  <?php 
  $i=1;
  foreach ($list as $key => $value) {
?>
  <tr>
  <th scope="row"><?php echo $i; ?></th>
  <td><?php echo $value['preferances']; ?></td>
  <td><?php 
  if(!empty($value['location'])){
    $location = explode(",",$value['location']);
    // var_dump($client);
    foreach($location as $key=>$val){
       if($val!='ALL'){
        $fetched_data = get_location_by_abbr($val);
        echo $fetched_data,',';
       }else{
           echo $val;
       }
     } 
  }
    ?></td>
  <td><?php 
  if(!empty($value['client'])){
    $client = explode(",",$value['client']);
    // var_dump($client);
    foreach($client as $key=>$val){
       if($val!='ALL'){
        $fetched_data = get_client_name_by_id($val);
        echo $fetched_data,',';
       }else{
           echo $val;
       }
     } 
  }
    ?></td>
  <td><?php 
    if(!empty($value['process'])){
            $process = explode(",",$value['process']);
            // var_dump($process);
            foreach($process as $key=>$val){
                $fetched_data = get_process_name_by_id($val);
                echo $fetched_data,',';
             }
      }else if($value['process']=='0'){
        echo 'All Process';
      }
      ?></td>
  <td><?php 
    if(!empty($value['femsid'])){
        $femsid = explode(",",$value['femsid']);
        // var_dump($process);
        foreach($femsid as $key=>$val){
            
            $fetched_data = get_name_by_fems_id($val);
            echo $fetched_data,',';
         } 
      }?></td>
  <td><?php 
    if(!empty($value['team'])){
        $team = explode(",",$value['team']);
        // var_dump($process);
        foreach($team as $key=>$val){
            
            $fetched_data = get_name_by_user_id($val);
            echo $fetched_data,',';
         } 
      }?></td>
  <td><img src="<?php echo base_url(); ?>uploads/dynamic_pop_up/<?php echo $value['image_path']; ?>" style="width:50px;height:50px;border-radius:5px;"></td>
  <td><?php echo $value['start_time']; ?></td>
  <td><?php echo $value['end_time']; ?></td>
  <td>
  <?php if(get_global_access() || get_user_id() == $value['user_id']){ ?>
  <a href="<?php echo base_url(); ?>dynamic_pop_up/edit/<?php echo $value['id']; ?>"><i class="fa fa-edit"></i></a>
  <?php } ?>
  </td>
  <td>
  <?php if(get_global_access() || get_user_id() == $value['user_id']){ ?>
  <a href="<?php echo base_url(); ?>dynamic_pop_up/delete/<?php echo $value['id']; ?>"><i class="fa fa-trash"></i></a>
  <?php } ?>
  </td>
  
  </tr>
  <?php $i++;
   } ?>
  </tbody>
</table>

</div>
</div>

</div>
</div>
</section>
</div>