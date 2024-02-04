<style>

	/*-- HIERARCHY VIEW ---*/
	.hv-wrapper {
		display: flex;
	}

	.hv-wrapper .hv-item {
		display: flex;
		flex-direction: column;
		margin: auto;
	}

	.hv-wrapper .hv-item .hv-item-parent {
		margin-bottom: 50px;
		position: relative;
		display: flex;
		justify-content: center;
	}

	.hv-wrapper .hv-item .hv-item-parent:after {
		position: absolute;
		content: '';
		width: 2px;
		height: 25px;
		bottom: 0;
		left: 50%;
		background-color: #000;
		transform: translateY(100%);
	}

	.hv-wrapper .hv-item .hv-item-children {
		display: flex;
		justify-content: center;
	}

	.hv-wrapper .hv-item .hv-item-children .hv-item-child {
		padding: 0 2px;
		position: relative;
	}

	.hv-wrapper .hv-item .hv-item-children .hv-item-child:before,
	.hv-wrapper .hv-item .hv-item-children .hv-item-child:not(:only-child):after {
		content: '';
		position: absolute;
		background-color: #000;
		left: 0;
	}

	.hv-wrapper .hv-item .hv-item-children .hv-item-child:before {
		left: 50%;
		top: 0;
		transform: translateY(-100%);
		width: 2px;
		height: 25px;
	}

	.hv-wrapper .hv-item .hv-item-children .hv-item-child:after {
		top: -25px;
		transform: translateY(-100%);
		height: 2px;
		width: 100%;
	}

	.hv-wrapper .hv-item .hv-item-children .hv-item-child:first-child:after {
		left: 50%;
		width: 50%;
	}

	.hv-wrapper .hv-item .hv-item-children .hv-item-child:last-child:after {
		width: calc(50% + 1px);
	}

	/*--- MAIN CSS --------------*/		  
	@import url("https://fonts.googleapis.com/css?family=Poppins");


	html,
	body {
		height: 100%;
		font-family: 'Poppins', sans-serif;
		padding: 0;
		margin: 0;
	}

	section {
		min-height: 100%;
		display: flex;
		justify-content: center;
		flex-direction: column;
		padding: 10px 0;
		position: relative;
	}

	section .github-badge {
		position: absolute;
		top: 0;
		left: 0;
	}

	section h1 {
		text-align: center;
		margin-bottom: 70px;
	}

	section .hv-container {
		flex-grow: 1;
		overflow: auto;
		justify-content: center;
	}

	.basic-style {
		background-color: #EFE6E2;
	}

	.basic-style>h1 {
		color: #ac2222;
	}

	p.simple-card {
		margin: 0;
		background-color: #fff;
		color: #DE5454;
		padding: 30px;
		border-radius: 7px;
		min-width: 100px;
		text-align: center;
		box-shadow: 0 3px 6px rgba(204, 131, 103, 0.22);
	}

	.hv-item-parent p {
		font-weight: bold;
		color: #DE5454;
	}

	.management-hierarchy {
		background-color: #fff;
	}

	.management-hierarchy>h1 {
		color: #000;
	}

	.management-hierarchy .person {
		text-align: center;
	}

	.management-hierarchy .person>img {
		height: 60px;
		border: 5px solid #FFF;
		border-radius: 50%;
		overflow: hidden;
		background-color: #fff;
	}

	.management-hierarchy .person>p.name {
		background-color: #e3e0e0;
		padding: 5px 10px;
		border-radius: 5px;
		font-size: 12px;
		font-weight: normal;
		color: #3BAA9D;
		margin: 0;
		width: 180px;
		height: 65px;
		position: relative;
	}

	.management-hierarchy .person>p.name b {
		color: rgba(59, 170, 157, 0.8);
	}

	.management-hierarchy .person>p.name:before {
		content: '';
		position: absolute;
		width: 2px;
		height: 6px;
		background-color: #000;
		left: 50%;
		top: 0;
		transform: translateY(-100%);
	}
	
	/*----- MAKE DEPARTMENS ---------*/
	.dep1{ background-color: #e39c4e!important; color:#fff!important; font-weight:600; }
	.dep1 b{ color:#fff!important; font-weight:600; }
	.dep1 a{ color:#e6e349!important; font-weight:600; }
	
	.dep2{ background-color: #4e73e3!important; color:#fff!important; font-weight:600; }
	.dep2 b{ color:#fff!important; font-weight:600; }
	.dep2 a{ color:#e6e349!important; font-weight:600; }
	
	.overridesmall{ font-size:8px!important; width:100px!important; height:60px!important; letter-spacing:1px; }
	.overridetext{ font-size:8px!important; }

</style>

<div class="wrap">
<section class="app-content">
	
<div class="row">
<div class="col-md-12">
	
<div class="widget">
<header class="widget-header">
	<h4 class="widget-title"><i class="fa fa-user"></i> <?php echo $mydetails['fullname']; ?> - <?php echo $mydetails['rolename']; ?></h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">
	
    <!--Management Hierarchy-->
    <section class="management-hierarchy">
        <div class="hv-container">
            <div class="hv-wrapper">
			
			<div class="hv-item">
			
			
			<?php 
			$start = 0;
			foreach(array_reverse($teamdata) as $token){ 
			$start++;
			
			$gettype = "parent"; $getstyle=""; $getclass="";
			// GET CHILD OR PARENT
			if($start == $totallevels){ $gettype = "child"; $getstyle = "margin-bottom: 60px"; $getclass="dep1"; }
		    ?>
					<div class="hv-item-children">
                        <div class="hv-item-child">
                            <div class="hv-item">
                                <div class="hv-item-<?php echo $gettype; ?>" style="<?php echo $getstyle; ?>">
                                  <div class="person">
                                    <img src="<?php echo $token['photo']; ?>" alt="">
                                    <p class="name <?php echo $getclass; ?>" style="vertical-align: middle;display: table-cell;">
									<?php echo $token['fusion_id']; ?><br/>
									<a class='viewmodalclick' style="text-decoration:none;cursor:pointer" sourceid="<?php echo $token['id'] ?>"><?php echo $token['fullname']; ?>
									<br/><b><?php echo $token['rolename']; ?></b></a>
                                    </p>
                                 </div>
                                </div>
							</div>
						</div>
					</div>
			<?php } ?>
			</div>

            </div>
        </div>
    </section>
	

</div>
</div>

</div>
</div>
	
</section>
</div>








<div class="wrap">
<section class="app-content">
	
<div class="row">
<div class="col-md-12">

<div class="widget">
<header class="widget-header">
	<h4 class="widget-title"><i class="fa fa-user"></i> FULL DEPARTMENTAL VIEW</h4>
</header>
<hr class="widget-separator"/>
<div class="widget-body clearfix">
	
    <!--Management Hierarchy-->
    <section class="management-hierarchy">
        <div class="hv-container">
            <div class="hv-wrapper">
			
			<div class="hv-item">
			<?php 
			$start = $totallevels + 1;
			foreach(array_reverse($teamdata) as $token){ 
			$start--;
			
			$gettype = "parent"; $getstyle="";
			
		    ?>
			<div class="hv-item-children">
			<?php 
			foreach($leveldata[$start] as $tokenr){ 
			$getmyclass = "";
			$gettype = "child";
			if(array_key_exists($tokenr['id'],$teamdata)){ $gettype = "parent"; $getmyclass = "dep2"; }
			if($mydetails['id'] == $tokenr['id']){ $getmyclass = "dep1"; }
			
			// GET CHILD OR PARENT
			if($start == "1"){ $gettype = "child"; $getstyle = "margin-bottom: 60px"; }
			?>
			
			<?php //if($tokenr['assigned_to'] != "0" || $tokenr['id'] == "1"){ ?>
			
			<div class="hv-item-child" style="<?php echo $getstyle; ?>">
			<div class="hv-item">
				<div class="hv-item-<?php echo $gettype; ?>">
					<div class="person">
						<img src="<?php echo $tokenr['photo']; ?>" alt="">
						<p class="overridesmall name <?php echo $getmyclass; ?>">
							<a class='viewmodalclick' style="text-decoration:none;cursor:pointer" sourceid="<?php echo $tokenr['id'] ?>">
							<?php echo $tokenr['fullname']; ?> <br/><b><?php echo $tokenr['rolename']; ?></b></a>
						</p>
					</div>
				</div>
			</div>
			</div>
			
			<?php //} ?>
			
			<?php } ?>
			</div>
			<?php } ?>
			</div>

            </div>
        </div>
		
		<br/><br/><br/><br/><br/><br/>
    </section>
	

</div>
</div>

</div>
</div>
	
</section>
</div>










<div class="modal fade" id="modaldocview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width:85%">
    <div class="modal-content">
		
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">View Team</h4>
			</div>
			<div class="modal-body docbodymodal">
			
            </div>
	</div>
   </div>
</div>

