
<div class="wrap">
	<section class="app-content">
		<div class="row">
		
		<!-- DataTable -->
		<div class="col-md-12">
            <div class="widget">
                <header class="widget-header">
                    <h4 class="widget-title">Location Leave Access</h4>
                </header><!-- .widget-header -->
                <hr class="widget-separator">
                <div class="widget-body">
                    <div class="table-responsive">
                        <table id="default-datatable" data-plugin="DataTable" class="table table-bordered" cellspacing="0" width="100%">
                            <thead style="background-color:#eee">
                                <tr>
                                    <th class="text-center">Location</th>    
                                    <th class="text-center">Leave Types</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tfoot style="background-color:#eee">
                                <tr>
                                    <th class="text-center">Location</th>  
                                    <th class="text-center">Leave Types</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php foreach($arr as $_key => $_val): ?>
                                    <tr>
                                        <td><?php print_r($_key); ?></td>
                                        <td>
                                            <?php foreach($_val["leave_criteria"] as $_rec): ?>
                                                <p style="padding:0px; margin:0px;"><?php echo $_rec ?></p>
                                            <?php endforeach; ?>
                                        </td>
                                        <td width="130px" class="text-center">
                                            <?php if(!$arr[$_key]["status"]): ?>
                                                <button class="btn btn-xs btn-success" onclick="access_open('<?php echo $arr[$_key]['abbr'] ?>', 1)">Open</button>
                                            <?php else: ?>
                                                <button class="btn btn-xs btn-danger" onclick="access_open('<?php echo $arr[$_key]['abbr'] ?>', 0)">Close</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>