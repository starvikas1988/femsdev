<script src="<?php echo base_url() ?>assets/css/search-filter/js/selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/selectize.bootstrap3.min.css"/>
<style>
    .table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
        padding:2px;
        text-align: center;
    }

    #show{
        margin-top:5px;
    }

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

    .largeModal .modal-dialog{
        width:800px;
    }
    .search_btn{
        margin-top: 6px;
    }
    /*start multiselect css here*/
	.common-top {
		width:100%;
		margin:10px 0 0 0;
	}
	.multiselect {
		width:100%;
		text-align:left;
	}	
	.checkbox input[type="checkbox"] {
		opacity:1;
	}
	.submit-btn {
		width:130px;
	}
	.pagination {
		display:flex;
		justify-content: end;
	}
	/*end multiselect css here*/
</style>

<div class="wrap">
    <section class="app-content">	

        <div class="widget">
            <header class="widget-header">
                <h4 class="widget-title">Non Applied Candidate List</h4>
            </header>
            <hr class="widget-separator">
            <div class="widget-body">
                <?php
//if(get_global_access()==true){
                ?>

                <form method="GET">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                            <select class="form-control" id="office_id" name="office_id[]" autocomplete="off1" placeholder="Select Assets" multiple >
			
			<?php foreach($locationList as $token){ 
			$selected = "";
			if(in_array($token['abbr'],$officeID)){ $selected = "selected"; }
			?>
			<option value="<?php echo $token['abbr']; ?>" <?php echo $selected; ?>><?php echo $token['office_name']; ?></option>
			<?php } ?>
		</select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">                                   
                                <input type="text" class="form-control" id="start_date" name="start_date" value="<?=$start_date?>" autocomplete="off" placeholder="MM/DD/YYYY">
                            </div>	
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <button class="btn btn-primary search_btn"><i class="fa fa-search"></i> Search</button>
                            </div>
                        </div>

                    </div>
                </form>
                <?php
//}
                ?>
            </div>
        </div>


        <div class="widget">	
            <header class="widget-header">
                <h4 class="widget-title">ID Card Not Applied List</h4>

                <div class='row'>	


                    <?php if (!empty($main)) {
                        if (!empty($download_link_pro)) {
                            ?>
                            <div style='float:right; margin-top:0px;' class="col-md-2">
                                <a id="download_pro" href='<?php echo $download_link_pro; ?>' target="_blank"><span style="padding:10px; float:right;" class="label label-success">Export Report</span></a>
                            </div>
                        <?php }
                    }
                    ?>

                </div>

            </header>

            <hr class="widget-separator">
            <div class="widget-body">

                <div class="table-responsive">
                    <table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%" style="margin-bottom:0px;">
                        <thead>
                            <tr class="bg-info">
                                <th>#</th>
                                <th>Fusion ID</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Role</th>
                                <th>Date of joining</th>
<!--				<th>Status</th>
                                <th>Action</th>-->
                            </tr>
                        </thead>
                        <tbody>						
                            <?php
                            $counter = 0;
                            if (!empty($main)) {
                                foreach ($main->result() as $value) {
                                    $counter++;
                                    ?>

                                    <tr>
                                        <td>					
        <?php echo $counter ?>	
                                        </td>
                                        <td><?php echo $value->fusion_id ?></td>
                                        <td><?php echo $value->name ?></td>
                                        <td><?php echo $value->shname ?></td>
                                        <td><?php echo $value->role_name ?></td>
                                        <td><?= $value->doj != '' ? date_format(date_create($value->doj), 'd-m-Y') : '' ?></td>


                                    </tr>	
                                    <?php
                                }
                            }
                            ?>						
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>
</div>
<script>
    $(function () {
        $('#multiselect').multiselect();       
        $('#office_id').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            filterPlaceholder: 'Search for something...'
        });
    });
</script>

