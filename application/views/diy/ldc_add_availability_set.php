<style>
p.chatquote{
	background-color: #fbfbfb;
    font-size: 12px;
    padding: 5px 14px;
    line-height: 1.3em;
}
p.chatimp{
	background-color:#f3e8e8;
}
.first_avi>ul{
  display:flex;
  align-items:center;
  /* border:1px solid black; */
  width: 75vw;
  justify-content:space-between;
  margin-top: .5rem;
  background-color:#f1f1f1;
  height: 2rem;
  padding: 0 0.5rem;

}
.first_avi>ul>.li_first{
  border-right:1px solid black;
  width: 5rem;
}
.first_avi>ul>.li_second{
  width: 5rem;
  /* border:1px solid black; */
  display:flex;
  align-items:center;
  justify-content:center;
}
#bold>ul>li{
  font-weight:700;
  color:black;
}
.table-striped > tbody > tr:nth-of-type(odd) {
    background-color: #dbe1ea;
}
</style>
<link rel="stylesheet" href="<?php echo base_url();?>assets/diy/avail/css/custom.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/diy/avail/css/os-theme-round-dark.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/diy/avail/css/OverlayScrollbars.css">

<div class="wrap">
<section class="app-content">
<div class="widget">
<div class="widget-body">	

  <h4>diy Availability Form </h4>
  <?php if(get_role()=='teacher'){?>
  <h4><span style="color:red">*updateing availability are 
  subject to approvable from admin and need to be done in advance</span></h4>
  <?php }?>
  <hr/>
  
<form name="frm" id="frm" method="post" action="<?php echo base_url();?>diy/modify_add_set_availability">


<div class="panel panel-default">
  <div class="panel-heading"> Availability</div>
  <div class="panel-body">

  <div class="row">	
    <h5 style="margin-bottom:1rem;">Select Teacher</h5>
    <div class="col-md-6">
      <div class="form-group">
        <label for="case">Teacher List</label>
        <select id="teacher_id" name="teacher_id" class="form-control">
          <?php foreach($teachersgroup as $key=>$rows){?>
            <option value="<?php echo $rows['id'];?>" <?php echo ($rows['id']==$teacher_id)?'selected="selected"':'';?>><?php echo $rows['fname'].' '.$rows['lname'];?></option>
          <?php } ?>
        </select> 
      </div>
    </div>
    <div class="col-md-6">
    </div>
  </div>
	
	
    <div class="row">	
    <h5 style="margin-bottom:1rem;">Select Date</h5>
    <div class="col-md-6">
      <div class="form-group">
        <label for="case">Select Date : </label>
        <input type="text" class="form-control date_pic fromdateCheck" autocomplete="off" value="<?php echo $search_from;?>" placeholder="Select Date" id="select_from_date" name="select_from_date" required readonly>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="case">Select Date To: </label>
        <input type="text" class="form-control date_pic fromdateCheck" autocomplete="off" value="<?php echo $search_to;?>" placeholder="Select Date" id="select_to_date" name="select_to_date" required readonly>
      </div>
    </div>
    </div>
	
	
	<div class="row allData">	
	
	</div>
	
	
	
	<hr/>
	
    </div>
    
	</div>
	</div>
	
	</div>
	</div>
	</form>

</div>
</div>
<section>
</div>
<script src="<?php echo base_url();?>assets/diy/avail/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/diy/avail/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/diy/avail/js/jquery.overlayScrollbars.js"></script>
<script>
//var j = jQuery.noConflict();
$('.box').overlayScrollbars({className       : "os-theme-round-dark",resize          : "both",
  sizeAutoCapable : true,
  paddingAbsolute : true}); 
  </script>