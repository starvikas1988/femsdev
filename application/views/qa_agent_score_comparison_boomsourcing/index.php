<style>
	.table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
		padding:2px;
		text-align: center;
		font-size:12px;
	}
	
	table.center {
		margin-left:auto; 
		margin-right:auto;
	}
    .btn.btn_submit{
        margin-top:21px;
    }
    .row{
        display:flex;
        margin: 10px 0 10px 0;
    }
    .col-12{
        width:100%;
    }
    .col-6{
        width:50%;
    }
    .col-8{
        width:66.67%
    }
    .col-10{
        width:83.34%;
    }
    .col-2{
        width:16.67%;
    }
    .col-4{
        width:33.34%;
    }
    .card{
        background-color:#fff;
        border-radius:10px;
    }
    .card-header{
        color:#000;
        background-color:#fff;
        border-bottom:1px solid #000;
        padding:8px;
        border-top-left-radius:10px;
        border-top-right-radius:10px;
    }
    .card-body{
        padding:10px;
    }
    .shadow{
        box-shadow:0 0 10px;
    }
    .result_box{
        display:none;
    }
    .search_inp{
        width: 30%;
        transition: ease-in-out 1s width;
        border-radius: 5px;
        border-color: #188ae2;
        padding: 5px 5px 5px 10px;
    }
    .search_inp:focus{
        width:100%;
        border-radius: 5px;
        border-color: #188ae2;
        outline:none;
    }
    .search_inp_box{
        width:100%;
        padding: 10px;
        text-align:right;
    }
	/*start custom 4.04.2022*/
	.select2-container {
		width:100%!important;
	}
	@media all and (max-width:768px){
		.col-6 {
			width:100%;
		}
		.row{
			display:block;        
		}
		.card {
			margin:0 0 15px 0;
		}
	}
	/*end custom 4.04.2022*/
</style>
<div class="wrap">
    <section class="app-content">
        <div class="row">
            <div class="col-12">
                <div class="widget">
                    <div class="widget-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="card shadow">
                                    <div class="card-header">
                                        <h4>Search Box 1</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="search_box search1">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for="box1_from_date">From Date</label>
                                                    <input type="date" id="box1_from_date" class="form-control from_date"/>
                                                </div>
                                                <div class="col-6">
                                                    <label for="box1_to_date">To Date</label>
                                                    <input type="date" id="box1_to_date" class="form-control to_date"/>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="box1_office">Office Location</label>
                                                    <select class="form-control office" name="office1[]" multiple id="box1_office">
                                                        <option value="">-- SELECT --</option>
                                                        <?php
                                                        foreach($office_location as $office){?>
                                                        <option value='<?php echo $office['abbr']?>'><?php echo $office['office_name']?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="box1_campaign">Campaign</label>
                                                    <select class="form-control campaign" id="box1_campaign">
                                                        <option value=''>-- SELECT --</option>
                                                        <?php
                                                        foreach ($campaign_list as $key => $value) {?>
                                                        <option value='<?= $value['table_name']?>'><?= ucwords(str_replace("_", " ", $value['table_name']))?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">
                                                    <button type="button" class="btn btn-success btn_submit">Search</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="result_box">
                                            <div class="search_inp_box">
                                                <input type="text" class="search_inp" placeholder="Type to search" />
                                            </div>
                                            <table class="table table-striped" width="100%" id="box1_table">
                                                <thead>
                                                    <tr>
                                                        <th>S. No.</th>
                                                        <th>Agent Name</th>
                                                        <th>Agent ID</th>
                                                        <th>Average Score</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="box1_result"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card shadow">
                                    <div class="card-header">
                                        <h4>Search Box 2</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="search_box search2">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for="box2_from_date">From Date</label>
                                                    <input type="date" id="box2_from_date" class="form-control from_date"/>
                                                </div>
                                                <div class="col-6">
                                                    <label for="box2_to_date">To Date</label>
                                                    <input type="date" id="box2_to_date" class="form-control to_date"/>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="box2_office">Office Location</label>
                                                    <select class="form-control office" name="office2[]" multiple id="box2_office">
                                                        <option value="">-- SELECT --</option>
                                                        <?php
                                                        foreach($office_location as $office){?>
                                                        <option value='<?php echo $office['abbr']?>'><?php echo $office['office_name']?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="box2_campaign">Campaign</label>
                                                    <select class="form-control campaign" id="box2_campaign">
                                                        <option value=''>-- SELECT --</option>
                                                        <?php
                                                        foreach ($campaign_list as $key => $value) {?>
                                                        <option value='<?= $value['table_name']?>'><?= ucwords(str_replace("_", " ", $value['table_name']))?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">
                                                    <button type="button" class="btn btn-success btn_submit">Search</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="result_box">
                                            <div class="search_inp_box">
                                                <input type="text" class="search_inp" placeholder="Type to search" />
                                            </div>
                                            <table class="table table-striped" width="100%" id="box2_table">
                                                <thead>
                                                    <tr>
                                                        <th>S. No.</th>
                                                        <th>Agent Name</th>
                                                        <th>Agent ID</th>
                                                        <th>Average Score</th>
                                                        <th>Difference</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="box2_result"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>