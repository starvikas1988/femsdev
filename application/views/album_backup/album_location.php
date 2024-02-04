<!--<style>
.navbar-nav > li > a {
    line-height: 60px !important;
    padding: 0 16px !important;
    color: #c12222 !important;
}

</style>
			<div class="widget-body">
				<div class="parent">
					<?php $i=0; ?>
						 <div class="row">

							<?php foreach($location_list as $file )  : ?>
								<div class="column">
									<div class="img-wrap">
											<ol class="nav navbar-nav list-inline" style="line-height: 60px !important;padding: 0 16px !important;">
												<a href="<?php echo base_url();?>album/check_location?loc=<?php echo $file['abbr'];?>"><li><img src="<?php echo base_url() ?>main_img/building.png" width="50px" height="50px"><?php echo $file['office_name']; ?></li></a>
											</ol>
										
									</div>	
								</div>	
								
							<?php $i++; ?>
							<?php  endforeach;  ?>	
						</div> 
						

				</div>
			</div>

-->
<style>
.row {

    margin-left: -.4rem;
    margin-right: -.5rem;
    width: 90%;

}

	body {
	font-family: 'Montserrat', sans-serif;
	color: #333;
	line-height: 1.6;
}
.pt-100{
    padding-top:100px;
}
.pb-100{
    padding-top:100px;
}
.mb-60 {
	margin-bottom: 60px;
}
.section-title p {
	font-size: 24px;
	font-family: Oleo Script;
	margin-bottom: 0px;
	margin-top:50px;
}
.section-title h4 {
	font-size: 40px;
	text-transform: capitalize;
	color: #FF5E18;
	position: relative;
	display: inline-block;
	padding-bottom: 25px;
}
.section-title h4::before {
	width: 80px;
	height: 1.5px;
	bottom: 0;
	left: 50%;
	margin-left: -40px;
}
.section-title h4::before, .section-title h4::after {
	position: absolute;
	content: "";
	background-color: #FF5E18;
}
.single_menu_list img {
	max-width: 30%;
	position: absolute;
	left: 0px;
	top: 0;
	border: 1px solid #ddd;
	padding: 3px;
	border-radius: 50%;
	transition: .4s;
}
.menu_style1 .single_menu_list img {
	position: static;
	width: 100%;
	display: block;
	margin: 0 auto;
	margin-bottom: 45px;
}
.single_menu_list h4 {
	font-size: 20px;
	border-bottom: 1px dashed #333;
	padding-bottom: 15px;
	margin-bottom: 10px;
}
.single_menu_list h4 span {
	float: right;
	font-weight: bold;
	color: #FF5E18;
	font-style: italic;
}
p {
	font-weight: 300;
	font-size: 14px;
}
.menu_style1 .single_menu_list {
	text-align: center;
	-webkit-box-shadow: 8px 11px 18px -4px rgba(0,0,0,0.75);
	-moz-box-shadow: 8px 11px 18px -4px rgba(0,0,0,0.75);
	box-shadow: 8px 11px 18px -4px rgba(0,0,0,0.75);
}
.single_menu_list:hover img {
	border-radius: 0;
	transition: .4s;
	-webkit-box-shadow: 8px 11px 18px -4px rgba(0,0,0,0.75);
	-moz-box-shadow: 8px 11px 18px -4px rgba(0,0,0,0.75);
	box-shadow: 8px 11px 18px -4px rgba(0,0,0,0.75);
}





</style>

<!------ Include the above in your HEAD tag ---------->

<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,900" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Oleo+Script" rel="stylesheet">
      <body>
        <section class="about-area pt-60">
         <div class="container">
            <div class="row">
               <div class="col-xl-12 mb-60">
                  <div class="section-title text-center">
                     <p>Fusion Gallery</p>
                     <h4>Employee Engagement</h4>
                  </div>
               </div>
            </div>
            <div class="row menu_style1">
			<?php foreach($location_list as $file )  : ?>
				
               <div class="col-md-3">
                  <div class="single_menu_list">
                    <a href="<?php echo base_url();?>album/check_location?loc=<?php echo $file['abbr'];?>"> <img src="<?php echo base_url() ?>main_img/building.png" width="50px" height="50px">
                     <div class="menu_content">
                        <h4><?php echo $file['office_name']; ?></h4>
                     </div>
					</a>
                  </div>
			   </div>
			   
			<?php  endforeach;  ?>
			
               <div class="col-md-3">
                  <div class="single_menu_list">
                    <a href="<?php echo base_url();?>album/check_location?loc=OFF"> <img src="<?php echo base_url() ?>main_img/building.png" width="50px" height="50px">
                     <div class="menu_content">
                        <h4>OFF SITE(OTHERS)</h4>
                     </div>
					</a>
                  </div>
			   </div>	
            </div>
         </div>
      </section>
     </body>