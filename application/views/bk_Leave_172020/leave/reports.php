<div class="wrap">
	<section class="app-content">
        <div class="row">
			<div class="col-md-12">
				<div class="widget">
					<header class="widget-header">
						<!--
						<h4 class="widget-title" style="display:inline-block; line-height:30px">Leave Reports</h4>
                        <a href="?status=1" class="btn btn-xs btn-success pull-right" type="button" style="margin-top: 6px">Approved</a>
                        <a href="?status=2" class="btn btn-xs btn-danger pull-right" type="button" style="margin-top: 6px; margin-right:5px;">Rejected</a>
                        <a href="?status=0" class="btn btn-xs btn-warning pull-right" type="button" style="margin-top: 6px; margin-right:5px;">Pending</a>
                       -->
                        <hr/>
                        <form method="post" action="">
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <label>Location</label>
                                    <select class="form-control" name="location_id" id="location_id">
                                        <option value="">--select--</option>
                                        <?php foreach($location_list as $location): ?>
                                            <option value="<?php print $location["abbr"] ?>"><?php print $location["abbr"] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>From Date</label>
                                    <input class="form-control" type="text" autocomplete="off"  name="from_date" id="from_date">
                                </div>
                                <div class="col-md-3">
                                    <label>To Date</label>
                                    <input class="form-control" type="text" autocomplete="off"  name="to_date" id="to_date">
                                </div>								
								<div class="col-md-3">
                                    <input type="submit" style='margin-top:25px;' class="btn btn-success btn-md" id='downloadReport' name='downloadReport' value="Download CSV">
                                </div>								
                            </div>                                                        
                        </form>
                    </header>
					<hr class="widget-separator"/>
					<div class="widget-body clearfix"></div>
                </div>
            </div>
        </div>
    </section>
</div>