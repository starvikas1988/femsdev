<div class="wrap">
	<section class="app-content">

        <div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Currency List						
						<?php if(get_login_type() == "client" && get_role()=='client'){ ?>
                        <button class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#myModal">Add Currency</button>
                        <?php } ?>
						
						</h4>
					</header>
					<hr class="widget-separator"/>
					<div class="widget-body clearfix">
						<div class="row">
                            <table class="table table-responsive table-bordered">
                            <thead>
                                <tr class="text-center bg-primary">
                                    <th style="border-bottom-width: 0px; border: 1px solid #ddd;" class="text-center">Sl</th>
                                    <th style="border-bottom-width: 0px; border: 1px solid #ddd;" class="text-center">Currency Name</th>
                                    <th style="border-bottom-width: 0px; border: 1px solid #ddd;" class="text-center">Currency Description</th>
                                    <th style="border-bottom-width: 0px; border: 1px solid #ddd;" class="text-center">Action</th>
                                </tr>
                            </thead>
							
                            <?php 
							$sl=0;
                            foreach($courseMaster as $key=>$course): 
								$sl++;
							?>
                                <tr>
                                    <td class="text-center"><?php echo $sl; ?></td>
                                    <td class="text-center"><?php echo $course['name']; ?></td>
                                    <td class="text-center"><?php echo $course['description']; ?></td>
                                    <td class="text-center">
                                    <?php /*if($course['is_active'] == '1'){?> 
                                    <a class="btn btn-danger btn-sm" href="updateCourseStatus?id=<?php echo $course['id'];?>">Deactivate</a>
                                    <?php }  else {?>
                                    <a class="btn btn-success btn-sm" href="updateCourseStatus?id=<?php echo $course['id'];?>">Activate</a>
                                    <?php }*/ ?>
                                        <?php
                                            $id=$course['id'];
                                            $params= $course['name']."#".$course['description'];     
											echo "<button title='Edit' rid='$id' params='$params' type='button' class='editCourseBtn btn btn-info btn-xs'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button>&nbsp;";
                                        ?>                                    
                                        <?php
                                            $id=$course['id'];
                                            
                                            // $params= $course['name']."#".$course['description'];     
											// echo "<button title='delete' rid='$id' params='$params' type='button' class='deleteCourseBtn btn btn-danger btn-xs'><i class='fa fa-trash-o' aria-hidden='true'></i></button>&nbsp;";
                                            ?>   
                                            <a href="delete_currency?id=<?php echo $id;?>" class="btn btn-danger" onclick="return confirm('Are you sure, you want to delete it?')"><i class='fa fa-trash-o' aria-hidden='true'></i></a>;
                                                                          
                                    </td>									
                                </tr>
                            <?php endforeach; ?>
							
                            <tfoot>
                                <tr class="text-center bg-primary">
                                    <th style="border-bottom-width: 0px; border: 1px solid #ddd;" class="text-center">Sl</th>
                                    <th style="border-bottom-width: 0px; border: 1px solid #ddd;" class="text-center">Currency Name</th>
                                    <th style="border-bottom-width: 0px; border: 1px solid #ddd;" class="text-center">Currency Description</th>
                                    <th style="border-bottom-width: 0px; border: 1px solid #ddd;" class="text-center">Action</th>
                                </tr>
                            </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </section>
</div>

<!-- Modal -->

<style>
label{ font-size:100%; font-weight:bold; }
</style>

<div id="myModal" class="modal fade" role="dialog" style="font-size:90%; ">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?php echo base_url('diy/add_currency'); ?>">
                <div class="modal-header" style="padding:8px 15px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Currency</h4>
                </div>
                <div class="modal-body">
                
                    <div class="row" style="padding:3px 0px;">
                        <div class="form-group">
                            <label class="col-md-4" style="line-height:37px;">Currency Name</label>
                            <div class="col-md-8">
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>
                    </div>
					
					<div class="row" style="padding:3px 0px;">
                        <div class="form-group">
                            <label class="col-md-4" style="line-height:37px;">Currency Description</label>
                            <div class="col-md-8">
                                <textarea type="text" name="description" class="form-control" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer" style="padding:8px 15px;">
                    <button id="sub_but" type="submit" class="btn btn-primary btn-sm">Save</button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- edit -->

<div id="myCourseModal" class="modal fade" role="dialog" style="font-size:90%; ">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?php echo base_url('diy/add_currency'); ?>">
                <div class="modal-header" style="padding:8px 15px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Currency</h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="padding:3px 0px;">
                        <div class="form-group">
                            <label class="col-md-4" style="line-height:37px;">Currency Name</label>
                            <div class="col-md-8">
                                <input type="hidden" name="edit_id"  class="form-control" value="" required>
                                <input type="text" name="name"  class="form-control" required>
                            </div>
                        </div>
                    </div>
					
					<div class="row" style="padding:3px 0px;">
                        <div class="form-group">
                            <label class="col-md-4" style="line-height:37px;">Currency Description</label>
                            <div class="col-md-8">
                                <textarea type="text" name="description" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="padding:8px 15px;">
                    <button id="sub_but" type="submit" class="btn btn-primary btn-sm">Update</button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>