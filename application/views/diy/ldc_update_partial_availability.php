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
.slotUI li{
	font-size:10px!important;
}
</style>

<div class="wrap">
<section class="app-content">
<div class="widget">
<div class="widget-body">	

  <h4>diy Partial Availability FORM 
  </h4>
  
  <h5><span style="color: red;"> * To apply for a leave, uncheck the default checked timeslot(s) as applicable and click on Submit </span>
  <hr/>
<?php if(!empty($success)){ ?> <script>alert('Partial Leave Applied Successfully')</script>; <?php } ?>
<form name="frm" id="frm" method="get" action="<?php echo base_url();?>diy/partical_leave_form">


<div class="panel panel-default">
  <div class="panel-heading"> Partial Leave</div>
  <div class="panel-body">

  <div class="row">	
  <div style="margin-bottom:.5rem;" class="col-md-6">
    <h5 style="margin-bottom:1rem;">Select Teacher</h5>
    <div class="col-md-12">
      <div class="form-group">
        <label for="case">Teacher List</label>
        <select id="teacher_id" name="teacher_id" class="form-control">
          <?php foreach($teachersList as $key=>$rows){?>
            <option value="<?php echo $rows['id'];?>" <?php echo ($rows['id']==$teacher_id)?'selected="selected"':'';?>><?php echo $rows['fname'].' '.$rows['lname'];?></option>
          <?php } ?>
        </select> 
      </div>
    </div>
    </div>
    <div style="margin-bottom:.5rem;" class="col-md-6">
    <h5 style="margin-bottom:1rem;">Select Partial Leave date</h5>
    <div class="col-md-12">
      <div class="form-group">
        <label for="case">Partial Leave Date :</label>
        <input type="text" class="form-control date_pic fromdateCheck" autocomplete="off" value="<?php echo $search_from;?>" placeholder="Select Date" name="select_from_date" required>
      </div>
    </div>
    <div class="col-md-6">
    <button  type="submit" style="height: 2.5rem;" name="submit" class="btn btn-success col-md-12"><i class="fa fa-save"></i> Search </button>
    </div>
    </div>
  </div>
  </form>
	
  
	<form name="frm" id="frm" method="post" action="<?php echo base_url();?>diy/apply_partical_leave">
	<div class="row">	
   
    <div class="col-md-4">
	<div class="form-group">
    <label for="case">Please select timings :</label>
	<div class="first_avi" id="bold">
	<ul class="slotUI">
	  <!-- <li class="li_first">Days</li> 
	  <li class="li_second">Not Aviliable</li>-->
	  <?php foreach($time_slots as $token){?>
	  <li><?php echo $token['slot_name']; ?></li>
	  <?php } ?>
	  <!--<li>11 AM</li>
	  <li>12 PM</li>
	  <li>1 PM</li>
	  <li>2 PM</li>
	  <li>3 PM</li>
	  <li>4 PM</li>
	  <li>5 PM</li>
	  <li>6 PM</li>
	  <li>7 PM</li>
	  <li>8 PM</li>
	  <li>9 PM</li>
    <li>10 PM</li>
	  <li>11 PM</li>
	  <li>12 AM</li>
	  <li>1 AM</li>
	  <li>2 AM</li>
	  <li>3 AM</li>
	  <li>4 AM</li>
	  <li>5 AM</li>
	  <li>6 AM</li>
	  <li>7 AM</li>
	  <li>8 AM</li>
	  <li>9 AM</li>
	  <li>10 AM</li>-->
	</ul>
    </div>
        
     <div class="first_avi">
        <ul>
          <!-- <li class="li_first">Monday</li> 
          <li  class="li_second"><div class="form-check">
            <input id="checkedli1" class="form-check-input" style="width: 1.5rem;" type="checkbox" value="" id="flexCheckDefault">
          </div>
          </li>-->
          <input type="hidden" name="pleave" id="pleave" value="">
          <input type="hidden" name="apply_date" value="<?php echo $search_from;?>">
          <input type="hidden" name="app_techer_id" id="app_teacher_id" value="<?php echo $teacher_id;?>">
          <?php 
          //echo'<pre>';print_r( $partical);
          foreach($time_slots as $token){
             $checkedName="";
             $ck="";
            if(in_array($token['id'], $availslot)){ $checkedName= "checked='checked'"; }else{ $checkedName="disabled='disabled'";}
            if($search_from==""){ $checkedName="disabled='disabled'";}
            if(in_array($token['id'], $partical)){ $ck="disabled='disabled'";}
            ?>           
          <li >
          <div class="form-check">
            <input class="uncheckedli1" class="form-check-input" style="width: 1.5rem; chk" name="leave[]" type="checkbox" value="<?php echo $token['id'];?>" onclick="checkval(this);" id="flexCheckDefault" <?php echo  $checkedName; ?> <?php echo $ck;?>>
          </div>
          </li>
          <?php } ?>
          
        </ul>
      </div>
	  
      
	  
     
 
	</div>
	</div>
	
	</div>
	
	
	
	<hr/>
	<?php if(!empty($teacher_id)){ ?>
	    <button  type="submit" style="height: 2.5rem;" name="submit" class="btn btn-success col-md-12" onclick="return confirm('Are you sure?')"><i class="fa fa-save"></i> Submit </button>
	 <? } ?>
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
<script>
function checkval(obj){
  var leave = $('#pleave').val();
    if ($(obj).prop('checked')==true){ 
     
    }
    else
    {
      var data = $(obj).val();
      if(leave!=''){
        leave=leave+','+data;
      }else{
        leave=data;
      }
      $('#pleave').val(leave);
    }
}

</script>