<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css" />
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


.spinner {
   position: absolute;
   left: 50%;
   top: 50%;
   height:60px;
   width:60px;
   margin:0px auto;
   -webkit-animation: rotation .6s infinite linear;
   -moz-animation: rotation .6s infinite linear;
   -o-animation: rotation .6s infinite linear;
   animation: rotation .6s infinite linear;
   border-left:6px solid rgba(0,174,239,.15);
   border-right:6px solid rgba(0,174,239,.15);
   border-bottom:6px solid rgba(0,174,239,.15);
   border-top:6px solid rgba(0,174,239,.8);
   border-radius:100%;
}

    input[type='file'] {
        border: 1px solid #ddd;
    }

@-webkit-keyframes rotation {
   from {-webkit-transform: rotate(0deg);}
   to {-webkit-transform: rotate(359deg);}
}
@-moz-keyframes rotation {
   from {-moz-transform: rotate(0deg);}
   to {-moz-transform: rotate(359deg);}
}
@-o-keyframes rotation {
   from {-o-transform: rotate(0deg);}
   to {-o-transform: rotate(359deg);}
}
@keyframes rotation {
        from {
            transform: rotate(0deg);
}

        to {
            transform: rotate(359deg);
        }
    }

    .btn-new {
        width: 100px;
        padding: 8px;
    }

    textarea {

        width: 100%;
        max-width: 100%;
        min-height: 40px !important;
        max-height: 40px !important;
    }

    h4 {
        word-break: break-all;
    }

    /* .btn-mul .btn-group{
        width: 100% !important;
    } */
    .multiselect {
        width: 100%;
        text-align: left;
    }

    .checkbox input[type="checkbox"] {
        opacity: 1;
    }

    .multiselect-container {
        max-height: 170px;
        overflow: auto;
    }
</style>

<div class="spinner" style="display:none"></div>

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
                            <div class="pull-right">
                                <?php if ($gant_access == true) { ?>
                                    <a href="<?= $navigation ?>" type="button" class="btn  btn-success btn-new" title="Navigate Back"><i class="fa fa-arrow-left"></i> Back </a>
                                <?php } elseif ($gant_access == false) { ?>
                                    <a href="<?php echo base_url(); ?>home" type="button" class="btn  btn-success btn-new" title="Navigate Back"><i class="fa fa-arrow-left"></i> Back </a>
                                <?php } ?>
							</div>
						<?php if($gant_access == true){  ?>
							<div class="col-sm-1 col-1 pull-right">
									<button id="new_course" type="button" class="btn  btn-success"  data-toggle="modal" data-target="#exampleModal" width="100px" title="Create Course"><i class="glyphicon glyphicon-plus"></i> Create </button>
							</div>
						<?php }   ?>	
						</div>
					</header><!-- .widget-header -->
					<hr class="widget-separator"> 
					<div class="widget-body">
						
					
                        <table class="table table-responsive table-striped">
                            <thead style="border: none;">
							<tr>
							  <th scope="col">#</th>
							  <th scope="col"></th>
                                    <th scope="col">Course Name</th>
                                    <th scope="col">Rules Set</th>
                                    <th scope="col" style="float:right;margin-right: 78px;"><span>Action</span></th>
                                   
                                    <!--      <th scope="col"></th> -->
							</tr>
						  </thead>
						  <tbody>
						  
						   
                                <?php $i = 1; ?>
                                <?php
                                foreach ($course_details as $course) :
                                    if ($course['rule_set'] == 1 && $course['rules_type'] == 'R') :
                                        $set = $course['rules_type'] == 'R' ? date_format(date_create($course['assign_date']), 'd-m-Y') : '';
                                        //                                        $rules = $course['rule_name'] . ' ' . $set." (".$course['re_assign_after'].") Month";
                                        $rules = 'Assigned ' . $set;
                                    else :
                                        $rules = $course['rule_name'];
                                    endif;
                                    ?>
							<tr>
                                        <th scope="row"><?php echo $i++ ?></th>
                                        <?php if ($course['is_active'] == 0) { ?>
                                            <td><a href="javascript:void(0);" title="<?php echo $gant_access == true ? "Deactivated Course " . $course['course_name'] : "Deactivated Course " . $course['course_name']; ?>"><span class="fa fa-book" style="font-size:55px" id='imageid1' /></span></a></td>
                                        <?php } else { ?>
                                            <td><a href="<?php echo base_url(); ?>course/view_courses/<?php echo $course['categories_id']; ?>/<?php echo $course['course_id']; ?>/<?= $course['lnd'] ?>" title="<?php echo $gant_access == true ? "Click here to view Upload " . $course['course_name'] : "Click here to View " . $course['course_name']; ?>"><span class="fa fa-book" style="font-size:55px" id='imageid1' /></span></a></td>
							<?php } ?>  
							  <td><?php echo $course['course_name']; ?></td>
                                        <td><?php echo $rules; ?></td>
                                        <?php if ($gant_access == true) { ?>
						  
						  <!--<td class="pull-right"><form method="post" action="<?php echo base_url();?>course/remove_global" ><input type="hidden" name="cat_id" value="<?php echo $course['categories_id']; ?>"><input type="hidden" name="c_id" value="<?php echo $course['course_id']; ?>" ><button type="submit"  class="btn btn-success set_rule" title="<?php echo $course['is_global'] == 0 ? 'Mark Global' : 'Unmark Global'?>" ><span style="<?php echo $course['is_global'] == 0 ? 'color:white' : 'color:red'?>" class="<?php echo $course['is_global'] == 0 ? 'fa fa-map' : 'fa fa-asterisk '?>" /></button></form></td>-->
							  
							  
							  <!--<td class="pull-right"><form method="post" action="" ><button type="button" data-category_id="<?php echo $course['categories_id']; ?>" class="btn btn-success examination"  value="<?php echo $course['course_id']; ?>" data-toggle="modal" data-target="#create_dipcheck_modal" title="Create Examination"><span class="fa fa-graduation-cap" /></button></td>-->
                                                                                        <?php if ($course['is_active'] == 0) { ?>
                                                                                                <td class="pull-right"><button type="button" class="btn btn-danger" title="Deactivated Course"><span class="fa fa-power-off" /></button></td>
							  <?php } ?>
                                                                                        <td class="pull-right"><button type="button" id="trash_course<?php echo $course['course_id']; ?>" data-trashid="<?php echo $course['categories_id']; ?>" value="<?php echo $course['course_id']; ?>" class="btn btn-danger trash_course" title="Delete Course"><span class="fa fa-trash" /></button></td>
                                                                                        <td class="pull-right"><button type="button" id="cirtificate_course<?php echo $course['course_id']; ?>" data-catagory="<?php echo $course['categories_id']; ?>" data-course="<?php echo $course['course_id']; ?>" class="btn btn-primary certificate_course" title="Course Certificate"><span class="fa fa-id-card-o" /></button></td>
							  <td class="pull-right"><button type="button" data-category_id="<?php echo $course['categories_id']; ?>" id="delete_<?php echo $course['course_id']; ?>" value="<?php echo $course['course_id']; ?>" class="btn btn-success edit_course" data-toggle="modal" data-target="#exampleModal" title="Edit Course"><span class="fa fa-edit" /></button></td>
                                                                                        <td class="pull-right"><button type="button" data-categoryid="<?php echo $course['categories_id']; ?>" id="setrule_<?php echo $course['course_id']; ?>" value="<?php echo $course['course_id']; ?>" class="btn btn-warning set_rule" data-toggle="modal" data-target="#setRuleModal" title="Set Rules"><span class="fa fa-recycle" /></button></td>
<!--                                            <td class="pull-center">
							  
                                                <button type="button" data-categoryid="<?php echo $course['categories_id']; ?>" id="setrule_<?php echo $course['course_id']; ?>" value="<?php echo $course['course_id']; ?>" class="btn btn-warning set_rule" data-toggle="modal" data-target="#setRuleModal" title="Set Rules"><span class="fa fa-recycle" /></button>
                                                <button type="button" data-category_id="<?php echo $course['categories_id']; ?>" id="delete_<?php echo $course['course_id']; ?>" value="<?php echo $course['course_id']; ?>" class="btn btn-success edit_course" data-toggle="modal" data-target="#exampleModal" title="Edit Course"><span class="fa fa-edit" /></button>
                                                <button type="button" id="cirtificate_course<?php echo $course['course_id']; ?>" data-catagory="<?php echo $course['categories_id']; ?>" data-course="<?php echo $course['course_id']; ?>" class="btn btn-primary certificate_course" title="Course Certificate"><span class="fa fa-id-card-o" /></button>
                                                <button type="button" id="trash_course<?php echo $course['course_id']; ?>" data-trashid="<?php echo $course['categories_id']; ?>" value="<?php echo $course['course_id']; ?>" class="btn btn-danger trash_course" title="Delete Course"><span class="fa fa-trash" /></button>

                                                <?php if ($course['is_active'] == 0) { ?>
                                                    <button type="button" class="btn btn-danger" title="Deactivated Course"><span class="fa fa-power-off" /></button>
                                                <?php } ?>
                                            </td>-->
							</tr>
                                    <?php } else { ?>
                                    <td class="pull-right"><button type="button" id="view_<?php echo $course['course_id']; ?>" value="<?php echo $course['course_id']; ?>" class="btn btn-success view_course"><span class="<?php echo $course['is_view'] == 0 ? 'fa fa-eye' : 'fa fa-eye-slash' ?>" /></button></td>
                                    <?php if ($course['is_view'] == 0) { ?>
                                        <td class="pull-right"><button disabled type="submit" title="Pending Reading" id="" value="" class="btn btn-success view_course"><span class="<?php echo $course['is_complete'] == 0 ? 'fa fa-clock-o' : 'fa fa-check' ?>" /></button></td>
                                    <?php } else { ?>
                                        <td class="pull-right">
                                            <form method="post" action="<?php echo base_url(); ?>course/mark_complete/<?php echo $course['categories_id']; ?>/<?php echo $course['course_id']; ?>"><button <?php echo $course['is_complete'] == 0 ? '' : 'disabled' ?> type="submit" title="<?php echo $course['is_complete'] == 0 ? 'Mark Complete' : 'Completed' ?>" id="view_<?php echo $course['id']; ?>" value="<?php echo $course['id']; ?>" class="btn btn-success view_course"><span class="<?php echo $course['is_complete'] == 0 ? 'fa fa-clock-o' : 'fa fa-check' ?>" /></form></button>
                                        </td>
                                        <?php if ($course['is_complete'] == 1) { ?>
                                            <td class="pull-right"><input type="hidden" name="course_id" value="<?php echo $course['course_id']; ?>"><input type="hidden" name="categories_id" value="<?php echo $course['categories_id']; ?>"> <button type="submit" title="Proceed to Exam" idtrash_course="view_<?php echo $course['id']; ?>" value="<?php echo $course['id']; ?>" class="btn btn-success view_course"><span class="fa fa-graduation-cap" /></button></td>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
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
        <form id="form1" method="post" action="" enctype="multipart/form-data">
	  
		<div class="modal-content">
		  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Course </h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
				<div class="container"> 
					<input type="hidden" id="cid"  name="cid" value="" >
					<input type="hidden" id="catid"  name="catid" value="" >
					<div class="row" style="padding-bottom:10px">
						<div class="col-sm-1">
							<label for="inputcourse">Course Name:</label> 
						</div>
                            <div class="col-sm-5">
                                <input type="inputcourse" alphanumeric name="course_name" class="form-control" id="course_name" aria-describedby="courseHelp" placeholder="Course Name" required>
                                <small><b>( Maximum 50 character allowed)</b></small>
						</div>
					</div>
					<div class="row" style="padding-bottom:10px">
						<div class="col-sm-1">
							<label for="inputdescription">Description:</label> 
						</div>
                            <div class="col-sm-5">
                                <textarea type="inputdescription" name="description" class="form-control" id="description" aria-describedby="descriptionHelp" placeholder="Course Description" required></textarea>
                                <small><b>( Maximum 4000 character allowed)</b></small>
						</div> 
					</div>

					<div class="row" style="padding-bottom:10px">
                            <div class="col-sm-2">
                                <label for="inputdescription">Is Global:<span style="color:#ff0000;">*</span></label>
						</div>
                            <div class="col-sm-5">
                                <select class="form-control" name="global_field" id="global_field" required>
								<option value="">--Select--</option>
								<option value="1">Set Global</option>
								<option value="0">Set Restricted</option>
							</select>
						</div> 
					</div>
					<div class="row" style="padding-bottom:10px">
                            <div class="col-sm-2">
							<label for="inputdescription">Status:</label> 
						</div>
                            <div class="col-sm-5">
                                <select class="form-control" name="status" id="is_active">
								<option value="1">Active</option>
                                    <option value="0">In-Active</option>
							</select>
						</div> 
					</div> 
                        <!--                        <div class="row course_img" style="padding-bottom:10px;display:none;">
                                                    <div class="col-sm-2">Banner</div>
                                                    <div class="col-sm-5">
                                                        <img id="imgbanner" src="" title="" style="width:50%;height:50px">
				</div> 
                                                </div>-->
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
			<h5 class="modal-title" id="exampleModalLabel">Set Course Rules</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
            <form method="post" action="<?php echo base_url(); ?>course/set_rules">
                <input type="hidden" id="cid_rules" name="cid_rules" value="">
                <input type="hidden" id="catid_rules" name="catid_rules" value="">
					
					<div class="modal-body">
                    <input type="hidden" name="category" id="course_category" value="<?php echo $this->uri->segment(3); ?>">
						<section class="app-content">
									<div class="row">
										<div class="col-md-12">
											<div class="widget">

											<header class="widget-header">
												<h4 class="widget-title">Set Rules</h4>
											</header>
										
											<hr class="widget-separator"/>
											<div class="widget-body clearfix">
												<div class="row">
												
													<div class="col-md-4" id="expiry_rules" >
														<div class="form-group" >
															<label for="expiry">Rules Defined</label>
															<select class="form-control" name="expiry" id="expiry" >
																<option value=''>--Select--</option>
                                                        <?php
                                                        if (!empty($course_rules)) {
                                                            foreach ($course_rules as $rules) {
                                                                ?>
                                                                <option value='<?= $rules['rule_id'] ?>'><?= $rules['rule_name'] ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
															</select>
														</div>
													</div>
													
													<div class="col-md-2" id="month_period" style="display:none" >
														<div class="form-group">
															<label for="months">Select Months</label>
															<select class="form-control" name="months" id="months" disabled>
																<option value=''>--Select--</option>
																<option value='3'>3 Months</option>
																<option value='6'>6 Months</option>
																<option value='24'>1 Year</option>
															</select>
														</div>
													</div>
													
													
														
													<div class="col-md-3" id="prelim_period" style="display:none" >
														<div class="form-group">
															<label for="prelim">Prelim period</label>
															<select class="form-control" name="prelim" id="prelim" disabled>
																<option value=''>--Select--</option>
																<option value='15'>15 Days</option>
																<option value='60'>60 Days</option>
																<option value='45'>45 Days</option>
																<option value='90'>90 Days</option>
															</select>
														</div>
													<!-- .form-group -->
													</div>
                                            <div class="col-md-4 re_assign mandatory" style="display:none">
                                                <div class="form-group">
                                                    <label for="assign_date">Assign Date<sup><span style="color:red;">*</span></sup></label>
                                                    <input type="text" class="form-control date-picker" name="assign_date" id="assign_date" disabled placeholder="DD-MM-YYYY">
												</div>	
                                                <!-- .form-group -->
                                            </div>
                                            <div class="col-md-3 re_assign" style="display:none">
                                                <div class="form-group">
                                                    <label for="assign_date">Re-Assign After<sup><span style="color:red;">*</span></sup></label>
                                                    <input type="text" class="form-control" name="re_assign_after" id="re_assign_after" placeholder="Month">
                                                </div>
                                                <!-- .form-group -->
                                            </div>
                                            <div class="col-md-4 mandatory" style="display:none">
                                                <div class="form-group btn-mul">
                                                    <label>Employee Type<sup><span style="color:red;">*</span></sup></label>
                                                    <select class="form-control" id="employee_type" name="employee_type" autocomplete="off" placeholder="Select Type" required>
                                                        <option value="">Please Select</option>
                                                        <option value="1">All Employee</option>
                                                        <option value="2">Existing Employee</option>
                                                        <option value="3">New Employee</option>
                                                        <option value="4">Individual Employee</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mandatory individual_opp" style="display:none">
                                                <div class="form-group btn-mul">
                                                    <label>Location<sup><span style="color:red;">*</span></sup></label>
                                                    <select class="form-control" id="fdoffice_ids" name="office_id[]" autocomplete="off" placeholder="Select Location" multiple>
												
                                                        <?php foreach ($location_list as $loc) : ?>
                                                            <?php
                                                            $sCss = "";
                                                            if (in_array($loc['abbr'], $oValue))
                                                                $sCss = "selected";
                                                            ?>
                                                            <option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss; ?>><?php echo $loc['office_name']; ?></option>

                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mandatory individual_opp" style="display:none">
                                                <div class="form-group">
                                                    <label>Select Department<sup><span style="color:red;">*</span></sup></label>
                                                    <select id="select_department" class="form-control" name="department_id[]" autocomplete="off" placeholder="Select Department" multiple>
                                                        <?php
                                                        foreach ($department_list as $k => $dep) {
                                                            $sCss = "";
                                                            if (in_array($dep['id'], $o_department_id))
                                                                $sCss = "selected";
                                                            ?>
                                                            <option value="<?php echo $dep['id']; ?>" <?php echo $sCss; ?>><?php echo $dep['shname']; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mandatory individual_opp" style="display:none">
                                                <div class="form-group">
                                                    <label>Select Designation<sup><span style="color:red;">*</span></sup></label>
                                                    <select id="select_designation" class="form-control" name="designation_id[]" autocomplete="off" placeholder="Select Designation" multiple>
                                                        <?php
                                                        foreach ($designation_list as $k => $des) {
                                                            $sCss = "";
                                                            if (in_array($des['id'], $o_designation_id))
                                                                $sCss = "selected";
                                                            ?>
                                                            <option value="<?php echo $des['id']; ?>" <?php echo $sCss; ?>><?php echo $des['name']; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3" style="display:none"> 
                                                <!--<div class="col-md-3 mandatory" style="display:none">-->
                                                <div class="form-group">
                                                    <label for="skip_count">Skip Count</label>
                                                    <input type="number" class="form-control" name="skip_count" id="skip_count" placeholder="">
                                                    <b style="font-size: 10px;font-style:italic;">(Unlimited time skip left blank)</b>
                                                </div>
                                                <!-- .form-group -->
                                            </div>
                                            <div class="col-md-12 individual" style="display:none;">
                                                <div class="form-group">
                                                    <label for="individual_employee">MWP ID<sup><span style="color:red;">*</span></sup>
                                                        <b style="font-size: 10px;font-style:italic;">(Add Multiple by Separating with Comma(,))</b></label>
                                                    <textarea type="text" class="form-control" name="individual_employee" id="individual_employee" placeholder="" row="2" required></textarea>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

											</div><!-- .widget-body -->
											
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
												<button type="submit" name="submit" value="SAVE" class="btn btn-primary" id="save_course">Save changes</button>
											</div>
											
										</div><!-- .widget -->
									</div>
									<!-- END DataTable -->	
								</div><!-- .row -->
							</section>
						</div>
					</form>
			  </div>
			</div>
		</div>	
	
	
	<!----  CREATE EXAM -->

<div class="modal fade" id="create_dipcheck_modal" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Create Course Exam</h4>
			</div>
            <form id="create_dipcheck_form" action="<?php echo base_url(); ?>course/savedipcheck" method='POST'>
				<div class="modal-body">
					<input type="text" name="categories_id" value="<?php echo $course['categories_id']; ?>">
                    <input type="text" name="course_id" id="course_id" name="cid" value="">
					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Exam Question Paper</label>
								<select name="exam_id" id="exam_id" class="form-control" required>
									<option value="">--Select Exam Question Paper--</option>
                                    <?php foreach ($examination_list as $exam) : ?>
									<option value="<?php echo $exam['id']; ?>"><?php echo $exam['title']; ?></option>
                                    <?php endforeach; ?>
								</select>
							</div>	
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<div class="form-group">
									<label>Open Date:</label>
									<input type="date" id="open_date" class="form-control" name="open_date" required>
								</div>
							</div>	
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<div class="form-group">
									<label>Close Date:</label>
									<input type="date" id="close_date" class="form-control" name="close_date" required>
								</div>
							</div>	
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<div class="form-group">
									<label>Description:</label>
									<input type="text" class="form-control" id="course_description" name="description" required>
								</div>
							</div>	
						</div>
						
					</div>
					
				</div>
				<div class="modal-footer">
					<button type="submit" id='btnSubmit' class="btn btn-primary">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>
 
	
<div class="modal fade" id="ta_CertificateUpdate" role="dialog" aria-labelledby="ta_CertificateUpdate" aria-hidden="true">
	
</div>
<div class="modal fade" id="ta_Certificate_list" role="dialog" aria-labelledby="ta_Certificate_list" aria-hidden="true">

</div>
<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<script>
    $(function () {
        $('#multiselect').multiselect();
        $('select[multiple]').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        });
    });
    $("#employee_type").change(function () {
        let ind_type = $("#employee_type").val();
        if (ind_type === '4') {
            $("#fdoffice_ids").css('display', 'none');
            $("#fdoffice_ids").prop('required', false);
            $("#fdoffice_ids").prop('disabled', true);
            $("#select_department").css('display', 'none');
            $("#select_department").prop('required', false);
            $("#select_department").prop('disabled', true);

            $("#employee_type").prop('required', true);
            $("#individual_employee").prop('required', true);
            $("#individual_employee").prop('disabled', false);
            $(".individual").css('display', 'block');
            $(".individual_opp").css('display', 'none');
        } else {
            $("#fdoffice_ids").css('display', 'block');
            $("#fdoffice_ids").prop('required', true);
            $("#fdoffice_ids").prop('disabled', false);
            $("#select_department").css('display', 'block');
            $("#select_department").prop('required', true);
            $("#select_department").prop('disabled', false);

            $("#employee_type").prop('required', true);
            $("#individual_employee").prop('required', false);
            $("#individual_employee").prop('disabled', true);
            $(".individual").css('display', 'none');
            $(".individual_opp").css('display', 'block');

        }
    });
</script>
