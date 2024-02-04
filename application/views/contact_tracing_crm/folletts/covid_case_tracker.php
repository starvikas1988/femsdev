<style>
.tracking-detail {
 padding:3rem 0
}
#tracking {
 margin-bottom:1rem
}
[class*=tracking-status-] p {
 margin:0;
 font-size:1.1rem;
 color:#fff;
 text-transform:uppercase;
 text-align:center
}
[class*=tracking-status-] {
 padding:1.6rem 0
}
.tracking-status-intransit {
 background-color:#65aee0
}
.tracking-status-outfordelivery {
 background-color:#f5a551
}
.tracking-status-deliveryoffice {
 background-color:#f7dc6f
}
.tracking-status-delivered {
 background-color:#4cbb87
}
.tracking-status-attemptfail {
 background-color:#b789c7
}
.tracking-status-error,.tracking-status-exception {
 background-color:#d26759
}
.tracking-status-expired {
 background-color:#616e7d
}
.tracking-status-pending {
 background-color:#ccc
}
.tracking-status-inforeceived {
 background-color:#214977
}
.tracking-list {
 border:1px solid #e5e5e5
}
.tracking-item {
 border-left:1px solid #e5e5e5;
 position:relative;
 padding:2rem 1.5rem .5rem 2.5rem;
 font-size:.9rem;
 margin-left:3rem;
 min-height:5rem
}
.tracking-item:last-child {
 padding-bottom:4rem
}
.tracking-item .tracking-date {
 margin-bottom:.5rem
}
.tracking-item .tracking-date span {
 color:#888;
 font-size:85%;
 padding-left:.4rem
}
.tracking-item .tracking-content {
 padding:.5rem .8rem;
 background-color:#f4f4f4;
 border-radius:.5rem
}
.tracking-item .tracking-content span {
 display:block;
 color:#888;
 font-size:85%
}
.tracking-item .tracking-icon {
 line-height:2.6rem;
 position:absolute;
 left:-1.3rem;
 width:2.6rem;
 height:2.6rem;
 text-align:center;
 border-radius:50%;
 font-size:1.1rem;
 background-color:#fff;
 color:#fff
}
.tracking-item .tracking-icon.status-sponsored {
 background-color:#f68
}
.tracking-item .tracking-icon.status-delivered {
 background-color:#4cbb87
}
.tracking-item .tracking-icon.status-outfordelivery {
 background-color:#f5a551
}
.tracking-item .tracking-icon.status-deliveryoffice {
 background-color:#f7dc6f
}
.tracking-item .tracking-icon.status-attemptfail {
 background-color:#b789c7
}
.tracking-item .tracking-icon.status-exception {
 background-color:#d26759
}
.tracking-item .tracking-icon.status-inforeceived {
 background-color:#214977
}
.tracking-item .tracking-icon.status-intransit {
 color:#e5e5e5;
 border:1px solid #e5e5e5;
 font-size:.6rem
}
@media(min-width:992px) {
 .tracking-item {
  margin-left:10rem
 }
 .tracking-item .tracking-date {
  position:absolute;
  left:-10rem;
  width:7.5rem;
  text-align:right
 }
 .tracking-item .tracking-date span {
  display:block
 }
 .tracking-item .tracking-content {
  padding:0;
  background-color:transparent
 }
}
</style>


<div class="wrap">
	<section class="app-content">
	
	
	<h2>Track Logs
	
	<a onclick="javascript:window.close()" style="cursor:pointer" class="pull-right btn btn primary"><i class="fa fa-arrow-left"></i> Go Back</a>	
	</h2>
	
	
	<div class="panel panel-default">
  <div class="panel-heading">Case Information</div>
  <div class="panel-body">
	
	
   <div class="row">
      
      <div class="col-md-12 col-lg-12">
         <div id="tracking-pre"></div>
         <div id="tracking">
            <div class="text-center tracking-status-intransit">
               <p class="tracking-status text-tight">
			   <b><?php echo $crmdetails['crm_id'] ." - " .$crmdetails['fname'] ." " .$crmdetails['lname']; ?></b>
			   <span style="font-size:15px;"><?php if(!empty($total_time_spent)){ ?><br/> <i class="fa fa-clock-o"></i> <?php echo $total_time_spent; ?><?php } ?></span>
			   </p>
            </div>
            <div class="tracking-list">
			<?php
			foreach($logdetails as $token){			
			?>
               <div class="tracking-item">
			   
                  <div class="tracking-icon status-intransit">
                     <svg class="svg-inline--fa fa-circle fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                        <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
                     </svg>
                  </div>
				  
                  <div class="tracking-date">
				  <?php echo date('M d, Y', strtotime($token['cl_date_added'])); ?>
				  <span><?php echo date('h:i A', strtotime($token['cl_date_added'])); ?></span>
				  </div>
				  
                  <div class="tracking-content">
				  <?php echo "Updated " .strtoupper($token['cl_section']); ?> Section
				  <span><?php echo $token['full_name']; ?> <?php if(!empty($token['cl_interval'])){ echo " | " .$token['cl_interval']; } ?></span> 
				  <font style="font-size:12px">Remarks : <?php echo $token['cl_comments']; ?></font>
				  </div>
				  
               </div>
			   
			<?php } ?>
			
            </div>
         </div>
      </div>
   </div>
	
	</div>
	
	</section>
</div>