<style>
.btn-sm{
	padding: 2px 5px;
}

.scrollheightdiv{
	max-height:600px;
	overflow-y:scroll;
}
.circleTab li a{
	background-color: #fff!important;
}
</style>


<div class="row">

<div class="col-md-12">
<b>Mail BOX : <span class="text-primary"><?php echo $resultDetails['email_name']; ?></span></b><br/>
<b>Category : <span class="text-primary"><?php echo $resultDetails['category_name']; ?></span></b><br/><br/>
</div>

<div class="col-md-12">
<b>Categroy Info : </b><br/><br/>
<?php echo $resultDetails['category_info']; ?>
<br/>
</div>

</div>