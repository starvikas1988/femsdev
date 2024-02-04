<div class="wrap">
	<section class="app-content">
		<div class="row">
		
		<!-- DataTable -->
		<div class="col-md-12">
            <div class="widget">
                <header class="widget-header">
                    <h4 class="widget-title">Team Leave Balance</h4>
                </header><!-- .widget-header -->
                <hr class="widget-separator">
                <div class="widget-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" cellspacing="0" width="100%">
                            <tr style="background-color:#188ae2; color:#FFFFFF; font-weight:bold;">
                                <td>Employee</td>
                                <td>XPOID</td>
                                <td>FUSION ID</td>
                                <?php foreach($arr as $rec): ?>
                                    <td><?php echo $rec ?></td>
                                <?php endforeach; ?>
                            </tr>
                            <?php foreach($leave_balance as $bal): ?>
                                <tr>
                                    <td><?php echo ucwords(strtolower($bal["name"])) ?></td> 
                                    <td><?php echo strtoupper($bal["xpoid"]); ?></td> 
                                    <td><?php echo strtoupper($bal["fusion_id"]); ?></td> 
                                    <?php foreach($bal["leaves"] as $rec): ?>                              
                                        <td><?php echo $rec ?></td>                                
                                    <?php endforeach; ?>                                                              
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>