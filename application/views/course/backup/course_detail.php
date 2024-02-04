<style>
	td{
		font-size:11px;
	}
	
	#default-datatable th{
		font-size:12px;
	}
	#default-datatable th{
		font-size:12px;
	}
	
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:5px;
	}
	
	.modal-dialog{
		width:750px;
	}
	
	td.details-control {
	background: url('<?php echo base_url()?>assets/images/details_open.png') no-repeat center center;
	cursor: pointer;
}
	
tr.shown td.details-control {
	background: url('<?php echo base_url()?>assets/images/details_close.png') no-repeat center center;
	cursor: pointer;
}
		
.btn-label {position: relative;left: -12px;display: inline-block;padding: 6px 12px;background: rgba(0,0,0,0.15);border-radius: 3px 0 0 3px;}
.btn-labeled {padding-top: 0;padding-bottom: 0;}
.btn { margin-bottom:0px; }	

.label {position: relative;left: -12px;display: inline-block;padding: 6px 12px; border-radius: 3px 0 0 3px;}
/*	.labeled {padding-top: 0;padding-bottom: 0;} */
 
.ladda-button{position:relative}.ladda-button .ladda-spinner{position:absolute;z-index:2;display:inline-block;width:32px;height:32px;top:50%;margin-top:-16px;opacity:0;pointer-events:none}.ladda-button .ladda-label{position:relative;z-index:3}.ladda-button .ladda-progress{position:absolute;width:0;height:100%;left:0;top:0;background:rgba(0,0,0,0.2);visibility:hidden;opacity:0;-webkit-transition:0.1s linear all !important;-moz-transition:0.1s linear all !important;-ms-transition:0.1s linear all !important;-o-transition:0.1s linear all !important;transition:0.1s linear all !important}.ladda-button[data-loading] .ladda-progress{opacity:1;visibility:visible}.ladda-button,.ladda-button .ladda-spinner,.ladda-button .ladda-label{-webkit-transition:0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) all !important;-moz-transition:0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) all !important;-ms-transition:0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) all !important;-o-transition:0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) all !important;transition:0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) all !important}.ladda-button[data-style=zoom-in],.ladda-button[data-style=zoom-in] .ladda-spinner,.ladda-button[data-style=zoom-in] .ladda-label,.ladda-button[data-style=zoom-out],.ladda-button[data-style=zoom-out] .ladda-spinner,.ladda-button[data-style=zoom-out] .ladda-label{-webkit-transition:0.3s ease all !important;-moz-transition:0.3s ease all !important;-ms-transition:0.3s ease all !important;-o-transition:0.3s ease all !important;transition:0.3s ease all !important}.ladda-button[data-style=expand-right] .ladda-spinner{right:14px}.ladda-button[data-style=expand-right][data-size="s"] .ladda-spinner,.ladda-button[data-style=expand-right][data-size="xs"] .ladda-spinner{right:4px}.ladda-button[data-style=expand-right][data-loading]{padding-right:56px}.ladda-button[data-style=expand-right][data-loading] .ladda-spinner{opacity:1}.ladda-button[data-style=expand-right][data-loading][data-size="s"],.ladda-button[data-style=expand-right][data-loading][data-size="xs"]{padding-right:40px}.ladda-button[data-style=expand-left] .ladda-spinner{left:14px}.ladda-button[data-style=expand-left][data-size="s"] .ladda-spinner,.ladda-button[data-style=expand-left][data-size="xs"] .ladda-spinner{left:4px}.ladda-button[data-style=expand-left][data-loading]{padding-left:56px}.ladda-button[data-style=expand-left][data-loading] .ladda-spinner{opacity:1}.ladda-button[data-style=expand-left][data-loading][data-size="s"],.ladda-button[data-style=expand-left][data-loading][data-size="xs"]{padding-left:40px}.ladda-button[data-style=expand-up]{overflow:hidden}.ladda-button[data-style=expand-up] .ladda-spinner{top:-32px;left:50%;margin-left:-16px}.ladda-button[data-style=expand-up][data-loading]{padding-top:54px}.ladda-button[data-style=expand-up][data-loading] .ladda-spinner{opacity:1;top:14px;margin-top:0}.ladda-button[data-style=expand-up][data-loading][data-size="s"],.ladda-button[data-style=expand-up][data-loading][data-size="xs"]{padding-top:32px}.ladda-button[data-style=expand-up][data-loading][data-size="s"] .ladda-spinner,.ladda-button[data-style=expand-up][data-loading][data-size="xs"] .ladda-spinner{top:4px}.ladda-button[data-style=expand-down]{overflow:hidden}.ladda-button[data-style=expand-down] .ladda-spinner{top:62px;left:50%;margin-left:-16px}.ladda-button[data-style=expand-down][data-size="s"] .ladda-spinner,.ladda-button[data-style=expand-down][data-size="xs"] .ladda-spinner{top:40px}.ladda-button[data-style=expand-down][data-loading]{padding-bottom:54px}.ladda-button[data-style=expand-down][data-loading] .ladda-spinner{opacity:1}.ladda-button[data-style=expand-down][data-loading][data-size="s"],.ladda-button[data-style=expand-down][data-loading][data-size="xs"]{padding-bottom:32px}.ladda-button[data-style=slide-left]{overflow:hidden}.ladda-button[data-style=slide-left] .ladda-label{position:relative}.ladda-button[data-style=slide-left] .ladda-spinner{left:100%;margin-left:-16px}.ladda-button[data-style=slide-left][data-loading] .ladda-label{opacity:0;left:-100%}.ladda-button[data-style=slide-left][data-loading] .ladda-spinner{opacity:1;left:50%}.ladda-button[data-style=slide-right]{overflow:hidden}.ladda-button[data-style=slide-right] .ladda-label{position:relative}.ladda-button[data-style=slide-right] .ladda-spinner{right:100%;margin-left:-16px}.ladda-button[data-style=slide-right][data-loading] .ladda-label{opacity:0;left:100%}.ladda-button[data-style=slide-right][data-loading] .ladda-spinner{opacity:1;left:50%}.ladda-button[data-style=slide-up]{overflow:hidden}.ladda-button[data-style=slide-up] .ladda-label{position:relative}.ladda-button[data-style=slide-up] .ladda-spinner{left:50%;margin-left:-16px;margin-top:1em}.ladda-button[data-style=slide-up][data-loading] .ladda-label{opacity:0;top:-1em}.ladda-button[data-style=slide-up][data-loading] .ladda-spinner{opacity:1;margin-top:-16px}.ladda-button[data-style=slide-down]{overflow:hidden}.ladda-button[data-style=slide-down] .ladda-label{position:relative}.ladda-button[data-style=slide-down] .ladda-spinner{left:50%;margin-left:-16px;margin-top:-2em}.ladda-button[data-style=slide-down][data-loading] .ladda-label{opacity:0;top:1em}.ladda-button[data-style=slide-down][data-loading] .ladda-spinner{opacity:1;margin-top:-16px}.ladda-button[data-style=zoom-out]{overflow:hidden}.ladda-button[data-style=zoom-out] .ladda-spinner{left:50%;margin-left:-16px;-webkit-transform:scale(2.5);-moz-transform:scale(2.5);-ms-transform:scale(2.5);-o-transform:scale(2.5);transform:scale(2.5)}.ladda-button[data-style=zoom-out] .ladda-label{position:relative;display:inline-block}.ladda-button[data-style=zoom-out][data-loading] .ladda-label{opacity:0;-webkit-transform:scale(0.5);-moz-transform:scale(0.5);-ms-transform:scale(0.5);-o-transform:scale(0.5);transform:scale(0.5)}.ladda-button[data-style=zoom-out][data-loading] .ladda-spinner{opacity:1;-webkit-transform:none;-moz-transform:none;-ms-transform:none;-o-transform:none;transform:none}.ladda-button[data-style=zoom-in]{overflow:hidden}.ladda-button[data-style=zoom-in] .ladda-spinner{left:50%;margin-left:-16px;-webkit-transform:scale(0.2);-moz-transform:scale(0.2);-ms-transform:scale(0.2);-o-transform:scale(0.2);transform:scale(0.2)}.ladda-button[data-style=zoom-in] .ladda-label{position:relative;display:inline-block}.ladda-button[data-style=zoom-in][data-loading] .ladda-label{opacity:0;-webkit-transform:scale(2.2);-moz-transform:scale(2.2);-ms-transform:scale(2.2);-o-transform:scale(2.2);transform:scale(2.2)}.ladda-button[data-style=zoom-in][data-loading] .ladda-spinner{opacity:1;-webkit-transform:none;-moz-transform:none;-ms-transform:none;-o-transform:none;transform:none}.ladda-button[data-style=contract]{overflow:hidden;width:100px}.ladda-button[data-style=contract] .ladda-spinner{left:50%;margin-left:-16px}.ladda-button[data-style=contract][data-loading]{border-radius:50%;width:52px}.ladda-button[data-style=contract][data-loading] .ladda-label{opacity:0}.ladda-button[data-style=contract][data-loading] .ladda-spinner{opacity:1}.ladda-button[data-style=contract-overlay]{overflow:hidden;width:100px;box-shadow:0px 0px 0px 3000px rgba(0,0,0,0)}.ladda-button[data-style=contract-overlay] .ladda-spinner{left:50%;margin-left:-16px}.ladda-button[data-style=contract-overlay][data-loading]{border-radius:50%;width:52px;box-shadow:0px 0px 0px 3000px rgba(0,0,0,0.8)}.ladda-button[data-style=contract-overlay][data-loading] .ladda-label{opacity:0}.ladda-button[data-style=contract-overlay][data-loading] .ladda-spinner{opacity:1}
 

.faicon{
	color:red;
	cursor:pointer;
}

.list-group-item{
    position: relative;
    display: block;
    padding: 10px 15px;
    margin-bottom: -1px;
    background-color: #fff;
	border: 0px;
}

.list-inline > li {
    display: inline-block;
    padding-left: 5px;
    padding-right: 50px;
}

.course_title{
	font-family:"Roboto";
	font-size:15px;
	font-weight:bold;
	color:black;
	
}

</style>

<?php $abc='' ?>
<div class="wrap">
	<section class="app-content">
		<div class="row">
		<input type="hidden" name="category" id="course_category" value="<?php echo $this->uri->segment(3); ?>" >
		
		<!-- DataTable -->
		<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<div class="row">
							<div class="col-sm-2 col-12 ">
								<h4 class="widget-title btn label labeled">Course categories List</h4>
							</div>
							<div class="col-sm-1 col-1 pull-right">
									<form action="<?php echo $_SERVER['REQUEST_URI']; ?>"><button type="submit" class="btn  btn-success"><i class="glyphicon glyphicon-arrow-left"></i> Back </form></button>
							</div>
						<?php if(get_role_dir() != 'agent'){  ?>
							<div class="col-sm-1 col-1 pull-right">
									<button  type="button" class="btn  btn-success"  data-toggle="modal" data-target="#exampleModal" width="100px"><i class="glyphicon glyphicon-plus"></i> Create </button>
							</div>
						<?php }      ?>	
						</div>
					</header><!-- .widget-header -->
					<hr class="widget-separator"> 
					<div class="widget-body">
						
					
						<table class="table table-responsive">
						  <thead>
							<tr>
							  <th scope="col">#</th>
							  <th scope="col"></th>
							  <th scope="col"></th>
							  <th scope="col"></th>
							  <th scope="col"></th>
							</tr>
						  </thead>
						  <tbody>
						  <?php $i=1; ?>
						  <?php foreach($course_details as $course) :?>
							
							<tr>
							  <th scope="row"><?php echo $i++?>#</th>
							  <td><a href="<?php echo base_url();?>course/view_courses/<?php echo $course['categories_id']; ?>/<?php echo $course['course_id']; ?>"><span class="fa fa-folder fa-4x faicon imageid2"  id='imageid1'/></span></a></td>
							  <td><?php echo $course['course_name']; ?></td>
						  <?php if(get_role_dir() != 'agent'){  ?>
							  <td class="pull-right"><button type="button" id="trash_course<?php echo $course['course_id']; ?>" value="<?php echo $course['course_id']; ?>" class="btn btn-success trash_course"><span class="fa fa-trash" /></button></td>
							  <td class="pull-right"><button type="button" data-dipcheck="<?php echo $course['course_id']; ?>" id="delete_<?php echo $course['course_id']; ?>" value="<?php echo $course['course_id']; ?>" class="btn btn-success edit_course" data-toggle="modal" data-target="#exampleModal" ><span class="fa fa-edit" /></button></td>
							  <td class="pull-right"><button type="button" data-category_id="<?php echo $course['course_id']; ?>" id="setrule_<?php echo $course['course_id']; ?>" value="<?php echo $course['course_id']; ?>" class="btn btn-success set_rule" data-toggle="modal" data-target="#setRuleModal" ><span class="fa fa-recycle" /></button></td>
							</tr>
						  <?php }else{  ?>
							<td class="pull-right"><button type="button" id="view_<?php echo $course['course_id']; ?>" value="<?php echo $course['course_id']; ?>" class="btn btn-success view_course"><span class="<?php echo $course['is_view'] == 0 ? 'fa fa-eye' : 'fa fa-eye-slash'?>" /></button></td>
							<?php if($course['is_view'] == 0){  ?>
								<td class="pull-right"><button disabled type="submit" title="Mark Complete" id="" value="" class="btn btn-success view_course"><span class="<?php echo $course['is_complete'] == 0 ? 'fa fa-clock-o' : 'fa fa-check'?>" /></button></td>
							<?php }else{  ?>
								<td class="pull-right"><form method="post" action="<?php echo base_url();?>course/mark_complete/<?php echo $course['categories_id']; ?>/<?php echo $course['course_id']; ?>"><button <?php echo $course['is_complete'] == 0 ? '' : 'disabled'?>  type="submit" title="Mark Complete" id="view_<?php echo $course['id']; ?>" value="<?php echo $course['id']; ?>" class="btn btn-success view_course"><span class="<?php echo $course['is_complete'] == 0 ? 'fa fa-clock-o' : 'fa fa-check'?>" /></form></button></td>
							<?php }   ?>	
						  <?php }   ?>	
						 <?php endforeach; ?>
						  </tbody>
						</table> 
					</div><!-- .widget-body -->
				</div><!-- .widget -->
			</div>
			<!-- END DataTable -->	
		</div><!-- .row -->
	</section>
 
</div><!-- .wrap -->


	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	  <form id="form1" method="post">
	  
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
				<div class="container">
					<input type="hidden" id="cid"  name="cid" value="" >
					<input type="hidden" id="dipcheck"  name="dipcheck" value="" >
					<div class="row" style="padding-bottom:10px">
						<div class="col-sm-1">
							<label for="inputcourse">Course Name:</label> 
						</div>
						<div class="col-sm-4">
							<input type="inputcourse" name="course_name" class="form-control" id="course_name" aria-describedby="courseHelp" placeholder="Course Name" required>
						</div>
					</div>
					<div class="row" style="padding-bottom:10px">
						<div class="col-sm-1">
							<label for="inputdescription">Description:</label> 
						</div>
						<div class="col-sm-4">
							<input type="inputdescription" name="description" class="form-control" id="description" aria-describedby="descriptionHelp" placeholder="Course Description" required>
						</div> 
					</div>
					<div class="row" style="padding-bottom:10px">
						<div class="col-sm-1">
							<label for="inputdescription">Dipcheck:</label> 
						</div>
						<div class="col-sm-4">
							<select class="form-control" name="dip_check">
								<option></option>
								<?php foreach($dipcheck_list as $check_list) :?>
										<option value="<?php echo $check_list['id']; ?>"><?php echo $check_list['description']; ?>|Open:<?php echo $check_list['open_date']; ?>||Close:<?php echo $check_list['close_date']; ?></option>
								<?php endforeach; ?>
							</select>
						</div> 
					</div>
					<div class="row" style="padding-bottom:10px">
						<div class="col-sm-1">
							<label for="inputdescription">Status:</label> 
						</div>
						<div class="col-sm-4"#d9b2b2>
							<select class="form-control" name="status">
								<option value="1">Active</option>
								<option value="0">De-Active</option>
							</select>
						</div> 
					</div> 
				</div> 
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="submit" name="submit" value="SAVE" class="btn btn-primary" id="save_course">Save changes</button>
		  </div>
		</div>
		</form>
	  </div>
	</div>


<!-- Modal -->
	<div class="modal fade" id="setRuleModal" tabindex="-1" role="dialog" aria-labelledby="setRuleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
				<section class="app-content">
					<div class="row">
					<input type="hidden" name="category" id="course_category" value="<?php echo $this->uri->segment(3); ?>" >
					
					<!-- DataTable -->
					<div class="col-md-12">
							<div class="widget">
								<header class="widget-header">
									<div class="row">
										<div class="col-sm-2 col-12 ">
											<h4 class="widget-title btn label labeled">Course Rules</h4>
										</div>
									</div>
								</header><!-- .widget-header -->
								<hr class="widget-separator"> 
								<div class="widget-body">
									<div class="row">
										<div class="col-md-2">
											<div class="form-group" >
												<label for="office_id">Location</label>
												<select class="form-control" name="office_id" id="foffice_id" >
													<option value='ALL'>ALL</option>
													<?php foreach($location_list as $loc): ?>
														
													<option value="<?php echo $loc['abbr']; ?>" ><?php echo $loc['office_name']; ?></option>
														
													<?php endforeach; ?>
																							
												</select>
											</div>
											
										<!-- .form-group -->
										</div>
									</div>
									
									
									<div class="row">
										<div class="col-md-2">
											<div class="form-group" >
												<label for="office_id">Location</label>
												<select class="form-control" name="office_id" id="foffice_id" >
													<option value='ALL'>ALL</option>
													<?php foreach($location_list as $loc): ?>
														
													<option value="<?php echo $loc['abbr']; ?>" ><?php echo $loc['office_name']; ?></option>
														
													<?php endforeach; ?>
																							
												</select>
											</div>
											
										<!-- .form-group -->
										</div>
										
										
										
										<div class="col-md-3">
											<div class="form-group">
												<label for="dept_id">Select a Department</label>
												<select class="form-control" name="dept_id" id="dept_id" >
													<option value='ALL'>ALL</option>
													<?php foreach($department_list as $dept): ?>
														<?php
														$sCss="";
														if($dept['id']==$dValue) $sCss="selected";
														?>
														<option value="<?php echo $dept['id']; ?>" <?php echo $sCss;?>><?php echo $dept['description']; ?></option>
														
													<?php endforeach; ?>
																							
												</select>
											</div>
														
										<!-- .form-group -->
										</div>
										
										<div class="col-md-3">
											<div class="form-group">
												<label for="sub_dept_id">Select a Sub Department</label>
												<select class="form-control" name="sub_dept_id" id="sub_dept_id" >
													<option value='ALL'>ALL</option>
													<?php foreach($sub_department_list as $sub_dept): ?>
														<?php
														$sCss="";
														if($sub_dept['id']==$sdValue) $sCss="selected";
														?>
														<option value="<?php echo $sub_dept['id']; ?>" <?php echo $sCss;?>><?php echo $sub_dept['name']; ?></option>
														
													<?php endforeach; ?>
																							
												</select>
											</div>
														
										<!-- .form-group -->
										</div>
										
										<div class="col-md-3">
											<div class="form-group">
												<label for="client_id">Select a Client</label>
												<select class="form-control" name="client_id" id="fclient_id" >
													<option value='ALL'>ALL</option>
													<?php foreach($client_list as $client): ?>
														<?php
														$sCss="";
														if($client->id==$cValue) $sCss="selected";
														?>
														<option value="<?php echo $client->id; ?>" <?php echo $sCss;?>><?php echo $client->shname; ?></option>
														
													<?php endforeach; ?>
																							
												</select>
											</div>
										<!-- .form-group -->
										</div>
										
										</div>			
								</div><!-- .widget-body -->
							</div><!-- .widget -->
						</div>
						<!-- END DataTable -->	
					</div><!-- .row -->
				</section>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary">Save changes</button>
		  </div>
		</div>
	  </div>
	</div>