<style>
	td{
		font-size:10px;
	}
	
	#default-datatable th{
		font-size:11px;
	}
	#default-datatable th{
		font-size:11px;
	}
	
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:3px;
	}
	
</style>

<div class="wrap">
	<section class="app-content">
		<div class="row">
		
		<!-- DataTable -->
		<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title">Howard School List</h4>
					</header><!-- .widget-header -->
					<hr class="widget-separator">
				
						<div style='float:right; margin-top:-35px; margin-right:10px;' class="col-md-4">
							<div class="form-group" style='float:right;'>
							<span style="cursor:pointer;padding:10px;" id='add_school' class="label label-primary">Add School</span>
							</div>
						</div>
													
					<div class="widget-body">
					
						<div class="table-responsive">
							<table id="default-datatable" data-plugin="DataTable" class="table table-striped" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>SL</th>
										<th>School Name</th>
										<th>Grades</th>
										<th>Address</th>
										<th>County</th>
										<th>City</th>
										<th>Action</th>
									</tr>
								</thead>
								
								<tfoot>
									<tr>
                                        <th>SL</th>
										<th>School Name</th>
										<th>Grades</th>
										<th>Address</th>
										<th>County</th>
										<th>City</th>
										<th>Action</th>
									</tr>
								</tfoot>
	
								<tbody>
                                <?php
                                $i = 0;
                                // var_dump($mission_list);
                                foreach ($school_list as $key => $value) {
                                    $i++;?>
                                    <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $value['name'] ?></td>
                                    <td><?php echo $value['grades'] ?></td>
                                    <td><?php echo $value['address'] ?></td>
                                    <td><?php echo $value['county'] ?></td>
                                    <td><?php echo $value['city'] ?></td>
                                    <td>
                                    <?php
                                        $id=$value['id'];
                                        
                                        $params= $value['name']."#".$value['grades']."#".$value['address']."#".$value['county']."#".$value['city'];
                                        if($value['is_active']==0){
                                            echo "<button title='Edit' id='$id' params='$params' type='button' class='editschool btn btn-info btn-xs'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button>&nbsp;";
                                        }
                                        // if($value['is_active']!=2){
                                        // echo "<button title='Change Status' id='$id' params='$params'  type='button' class='editstat btn btn-info btn-xs'><i class='fa fa-check-square' aria-hidden='true'></i></button>&nbsp;";
                                        // }
                                    ?>
                                </td>
                                    </tr>

                                    
                                <?php }
                                
                                ?>
								
							
								</tbody>
							</table>
						</div>
					</div><!-- .widget-body -->
				</div><!-- .widget -->
			</div>
			<!-- END DataTable -->	
		</div><!-- .row -->
	</section>
	
</div><!-- .wrap -->


<div class="modal fade" id="modalAddMsn" tabindex="-1" role="dialog" aria-labelledby="addStockLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="width: 1000px; margin-left: -200px;">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="addStockLabel">School</h4>
		</div>
		<div class="modal-body">
            <form id="frmAddSchool" onsubmit="return false" method='POST'>
                <input type="hidden" id="sid" val="" name="sid">
				<div class="row">
					<div class="form-group col-md-6">
						<label for="name">School Name</label>
						<input class="form-control" type="text" name="sname" id="name" required="">
					</div>
                    <div class="form-group col-md-6">
						<label for="name">Address</label>
						<input class="form-control" type="text" name="address" id="address" required="">
					</div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
						<label for="name">Grades</label>
						<input class="form-control" type="text" name="grades" id="grades" required="">
					</div>
                    
                    <div class="form-group col-md-4">
						<label for="name">County</label>
						<input class="form-control" type="text" name="county" id="county" required="">
					</div>
                    <div class="form-group col-md-4">
						<label for="name">City</label>
						<input class="form-control" type="text" name="city" id="city" required="">
					</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id='btnAddSchool' class="btn btn-primary">Save</button>
                </div>
		    </form>	
	    </div>
     </div>
    </div>
</div>