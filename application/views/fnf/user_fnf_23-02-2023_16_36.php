<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap.min.css">





<style>
  @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@300,400,500;1,900&display=swap');

  body {
    font-family: "Roboto", sans-serif !important;

  }

  .table>thead>tr>th,
  .table>thead>tr>td,
  .table>tbody>tr>th,
  .table>tbody>tr>td,
  .table>tfoot>tr>th,
  .table>tfoot>tr>td {
    padding: 2px;
    text-align: center;
  }

  #show {
    margin-top: 5px;
  }

  input[type="checkbox"][readonly] {
    pointer-events: none;
  }

  .imgView {
    display: block;
    margin-bottom: 10px;
  }



  .dataTables_length select {
    height: 40px !important;
    min-width: 60px !important;
    width: 60px !important;
  }

  .dataTables_filter input {
    height: 40px !important;
  }

  .dataTables_filter,
  .pagination {
    float: right;
    margin-right: 10px;
  }

  .new-table {
    overflow-x: hidden !important;
  }

  .new-table .col-sm-12 {
    overflow-x: auto !important;
  }

  td {
    font-size: 10px;
  }

  #default-datatable th {
    font-size: 11px;
  }

  #default-datatable th {
    font-size: 11px;
  }

  .table>thead>tr>th {
    vertical-align: top !important;
    text-align: center !important;
  }


  /*========tab css==================*/

  .tab-parent label,
  .tab-parent a {
    cursor: pointer;
    user-select: none;
    text-decoration: none;
    display: inline-block;
    color: inherit;
    transition: border 0.2s;

    padding: 3px 2px;
  }

  .tab-parent label:hover,
  .tab-parent a:hover {
    border-bottom-color: #9b59b6;
  }



  .tab-parent input[type=radio] {
    display: none;
  }

  .tab-parent label.nav {
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    border-bottom: 2px solid #188ae2;
    background: #ecf0f1;
    user-select: none;
    transition: background 0.4s, padding-left 0.2s;
    padding-left: 0;
    height: 35px;
  }

  .tab-parent input[type=radio]:checked+.page+label.nav {
    background: #188ae2;
    color: #ffffff;
    border-top-right-radius: 5px;
    border-top-left-radius: 5px;
    /*  padding-left: 20px;*/
  }

  .tab-parent input[type=radio]:checked+.page+label.nav span {
    /*  padding-left: 20px;*/
  }

  .tab-parent input[type=radio]:checked+.page+label.nav svg {
    opacity: 1;
  }

  .tab-parent label.nav span {
    padding-left: 0px;
    position: relative;
  }

  .tab-parent label.nav svg {
    left: 0;
    top: -3px;
    position: absolute;
    width: 15px;
    opacity: 0;
    transition: opacity 0.2s;
  }

  .tab-parent .layout {
    display: grid;
    height: 100%;
    width: 100%;
    overflow: hidden;
    grid-template-rows: 50px 1fr;
    grid-template-columns: repeat(6, 1fr);
  }

  .page {
    grid-column-start: 1;
    grid-row-start: 2;
    grid-column-end: span 6;
    padding: 10px;
    background: #fff;
  }

  .page-contents>* {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.2s, transform 0.2s;
  }

  .page-contents>*:nth-child(1) {
    transition-delay: 0.4s;
  }

  .page-contents>*:nth-child(2) {
    transition-delay: 0.6s;
  }

  .page-contents>*:nth-child(3) {
    transition-delay: 0.8s;
  }

  .page-contents>*:nth-child(4) {
    transition-delay: 1s;
  }

  .page-contents>*:nth-child(5) {
    transition-delay: 1.2s;
  }

  .page-contents>*:nth-child(6) {
    transition-delay: 1.4s;
  }

  .page-contents>*:nth-child(7) {
    transition-delay: 1.6s;
  }

  .page-contents>*:nth-child(8) {
    transition-delay: 1.8s;
  }

  .page-contents>*:nth-child(9) {
    transition-delay: 2s;
  }

  .page-contents>*:nth-child(10) {
    transition-delay: 2.2s;
  }

  .page-contents>*:nth-child(11) {
    transition-delay: 2.4s;
  }

  .page-contents>*:nth-child(12) {
    transition-delay: 2.6s;
  }

  .page-contents>*:nth-child(13) {
    transition-delay: 2.8s;
  }

  .page-contents>*:nth-child(14) {
    transition-delay: 3s;
  }

  .page-contents>*:nth-child(15) {
    transition-delay: 3.2s;
  }

  .page-contents>*:nth-child(16) {
    transition-delay: 3.4s;
  }

  .page-contents>*:nth-child(17) {
    transition-delay: 3.6s;
  }

  .page-contents>*:nth-child(18) {
    transition-delay: 3.8s;
  }

  .page-contents>*:nth-child(19) {
    transition-delay: 4s;
  }

  .page-contents>*:nth-child(20) {
    transition-delay: 4.2s;
  }

  .tab-parent input[type=radio]+.page {
    transition: transform 0.2s;
    transform: translateX(100%);
  }

  .tab-parent input[type=radio]:checked+.page {
    transform: translateX(0%);
  }

  .tab-parent input[type=radio]:checked+.page .page-contents>* {
    opacity: 1;
    transform: translateY(0px);
  }

  .page-contents {
    max-width: 100%;
    width: 100%;
    margin: 0 auto;
  }

  .table>thead>tr>th,
  .table>thead>tr>td,
  .table>tbody>tr>th,
  .table>tbody>tr>td,
  .table>tfoot>tr>th,
  .table>tfoot>tr>td {
    padding: 9px !important;
    font-size: 12px !important;
  }

  .new-btn {
    margin-top: 25px;
    padding: 10px !important;
  }

  .white-space {
    background: #fff;
    padding: 10px;
    margin-top: 10px;
    border-radius: 5px;
  }

  .new-section .nav-tabs>li.active>a,
  .new-section .nav-tabs>li.active>a:focus,
  .new-section .nav-tabs>li.active>a:hover {
    color: #fff !important;
    cursor: default;
    background-color: #35b8e0 !important;
    border: none !important;
    border-bottom-color: #2e7bdd;
    border-radius: 6px;
  }

  .new-section .nav-tabs {
    border-bottom: none !important;
    background: #fff !important;
    padding: 10px;
    border-radius: 6px;
  }

  .new-section .nav-tabs>li>a:hover,
  .new-section .nav-tabs>li>a:focus {
    border-color: none !important;
    color: #fff !important;
    cursor: default;
    background-color: #35b8e0 !important;
    border-radius: 6px;

  }

  .tab-group .nav-link,
  .nav-tabs>li>a {
    color: #35b8e0 !important;
    background: #e3f7f7;
    opacity: 5;
    border-radius: 6px;
    margin-bottom: 5px;
  }

  .loader {
    display: inline-block;
    border: 5px dotted lightgray;
    border-radius: 50%;
    border-top: 5px solid gray;
    border-bottom: 5px solid gray;
    width: 30px;
    height: 30px;
    -webkit-animation: spin 1s linear infinite;
    /* Safari */
    animation: spin 1s linear infinite;
  }

  .loader-symbol {
    text-align: center
  }

  @keyframes spin {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }



  .view-btn {
    color: #fff;
    background-color: #337ab7;
    border-color: #2e6da4;
    border: none;
    padding: 8px;
    width: 100px;
    border-radius: 3px;
  }

  .view-btn:hover,
  .view-btn:focus {
    color: #fff;
    background-color: #286090;
    border-color: #204d74;
  }

  .view-btn {
    margin-top: 23px;
  }

  .space-top {
    margin-top: 29px;
    margin-left: -12px;
  }

  .fixed_bottom {
    position: relative !important;
  }

  .new-row .form-control[disabled],
  .new-row .form-control[readonly],
  .new-row fieldset[disabled] .form-control {
    background: #fff !important;
  }

  .tab-parent {
    overflow: scroll;
    height: 400px;
  }

  .tab-parent thead {
    position: sticky;
    top: 0;
    left: 0;
  }
</style>

<div class="wrap" id="target_div">
  <section class="app-content new-section">
    <div class="tab-group">
      <ul class="nav nav-tabs">
	      <?php if(isAccessFNFHr()==true){ ?>	

        <li class="active"><a data-toggle="tab" onclick="get_list('hr_fnf')" ; href="#one">HR FNF Checklist</a></li>

        <?php  } ?>

        <?php if(isAccessFNFITHelpdesk()==true){ ?>	

        <li><a data-toggle="tab" href="#two" onclick="get_list('local_it')" ; class="nav-link">Local IT Team</a></li>

        <?php  }  ?>

		    <?php if(isAccessFNFITNetwork()==true){ ?>	

        <li><a data-toggle="tab" href="#three" onclick="get_list('it_network')" ; class="nav-link"> IT Network Team</a></li>

        <?php }  ?>
		    <?php if(isAccessFNFITGlobalHelpdesk()==true){ ?>	

        <li><a data-toggle="tab" href="#four" onclick="get_list('it_global')" ; class="nav-link">IT Global Help Desk</a></li>

        <?php } ?>
        <!-- <li><a data-toggle="tab" href="#five" onclick="get_list('it_security')" ; class="nav-link">IT Security Team</a></li> -->
		<?php if(isAccessFNFprocurement()==true){ ?>	

        <li><a data-toggle="tab" href="#six" onclick="get_list('procurement')" ; class="nav-link">Procurement Team</a></li>
        <?php } ?>
		<?php if(isAccessFNFHr()==true){ ?>	

        <li><a data-toggle="tab" href="#seven" onclick="get_list('hr_acceptance')" ; class="nav-link">HR Acceptence</a></li>
        <?php } ?>

      </ul>
    </div>

    <div class="tab-content">
      <div class="white-space">
        <div class="row new-row">
          <form id="report_indv_filter" method="get">
            <div class="filter-widget">

              <div class="col-md-9">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Search By Location</label>
                      <select class="form-control foffice_id" name="office_id" id="foffice_id" data-live-search="true" data-actions-box="true" required>
                        <?php
                        if (get_global_access() == 1 || get_role_dir() == "super") // echo "<option value='ALL'>ALL</option>";
                        ?>
                        <option value="">Select Location </option>
                        <?php foreach ($location_list as $loc) : ?>
                          <?php
                          $sCss = "";
                          if ($loc['abbr'] == $getOffice) $sCss = "selected";
                          ?>
                          <option value="<?php echo $loc['abbr']; ?>" <?php echo $sCss; ?>><?php echo $loc['office_name']; ?></option>

                        <?php endforeach; ?>

                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>From Date</label>
                      <input readonly type="text" class="form-control form_date" value="<?php echo $date_from; ?>" name="date_from" id="date_from" placeholder="From Date">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>To Date</label>
                      <input readonly type="text" class="form-control to_date" value="<?php echo $date_to; ?>" name="date_to" id="date_to" placeholder="To Date">
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label>MWP ID</label>
                      <!-- <label>MWP ID (Comma Separator for Multiple)</label> -->
                      <input type="text" class="form-control mwp_ids" onkeyup="location_reset();" name="mwp_ids" id="mwp_ids" value="<?php echo $mwp_ids; ?>">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label></label>
                      <button type="button" class="view-btn fnf_type" onclick="get_list(this.value)" ;>View</button>
                    </div>
                  </div>
                  <div class="col-md-6"> <?php if ($status == "1") { ?>
                      <div class="form-group space-top">
                        <a href='?status=2' <span style="padding:12px;" class="label label-primary">View Upcoming</span></a>
                      </div>

                    <?php } else { ?>
                      <div class="form-group space-top">
                        <a href='?status=1' <span style="padding:12px;" class="label label-primary"> View Pending</span></a>
                      </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
            <input type="hidden" name="page_open" id="page_open">
            <!-- <input type="hidden" name="page_offset" id="page_offset"> -->


          </form>
        </div>
      </div>
      <?php if(isAccessFNFHr()==true){ ?>	

      <div id="one" class="tab-pane fade in active">
        <div class="white-space">


          <div class="row">
            <div class="col-md-4 a_id">
              <!-- <a href="<?php echo base_url('fnf/fnf_export_report_excel'); ?>?office=<?php echo $getOffice; ?>&type=7&excel=1" class="btn btn-primary btn-sm pull-right"> <i class="fa fa-download"></i> Download Excel</a> -->
              <!-- <a  class="btn btn-primary btn-sm pull-right a_id"> <i class="fa fa-download"></i> Download Excel</a> -->

            </div>
            <div class="col-md-4">
              <button type="submit" class="send_mails btn btn-primary btn-sm pull-right" style="margin-right: 10px;" title="Click on the checkbox to resend multiple Mails"> <i class="fa fa-envelop"></i> Re-Send Mails</button>&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            <div class="col-md-4">
              <button type="button" class="check_complete_fnf btn btn-primary btn-sm pull-right" style="margin-right: 10px;" title="Click to Complete All FNF"> <i class="fa fa-envelop"></i> Complete All FNF</button>&nbsp;&nbsp;&nbsp;&nbsp;
            </div>

          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="tab-parent">
                <!-- <table data-plugin="DataTable" id="get_data_set" class="table table-striped skt-table" cellspacing="0" width="100%"> -->

                <table data-plugin="DataTable" class="table table-striped skt-table " cellspacing="0" width="100%">
                  <thead>
                    <tr class='bg-info'>
                      <th><input type="checkbox" class="check_all" name="check"></th>
                      <!-- <th>SL</th> -->
                      <th>Name</th>
                      <th>Fusion ID</th>
                      <th>Email</th>
                      <th>Phone</th>

                      <th>Office</th>
                      <th>Resign/Term Date</th>
                      <th>Release Date/LWD</th>
                      <th>IT Local</th>
                      <th>IT Network</th>
                      <th>IT Helpdesk</th>
                      <th>Procurement Team</th>
                      <th>HR Acceptance</th>
                      <?php $off_arr = array('CEB', 'MAN');
                      if (in_array(get_user_office_id(), $off_arr)) { ?>
                        <th>Process</th>
                        <th>Department</th>
                      <?php } ?>
                      <th>FNF Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody class="table_data_val"><span class="no_data"></span>
                  <tr>

<center><img class="loading-image" src="assets/loader.png" style="display:none;"/></center>
      </tr>
                  </tbody>
                </table>
                <div class="load-more" style="display: block;">
                  <!-- <img src="<?php echo base_url('assets/images/loading.gif'); ?>"/> Loading more Data... -->
                </div>
                <input type="hidden" name="fnfAllHRCheck" value="<?php echo !empty($confirmFNF) ? implode(',', $confirmFNF) : ""; ?>">

              </div>
            </div>
          </div>
        </div>

      </div>
      <!-- tab content 2 start here -->
      <?php } ?>

      <div id="two" class="tab-pane fade">
        <div class="white-space">

          <div class="row a_id">
            <!-- <a href="<?php echo base_url('fnf/fnf_export_report_excel'); ?>?office=<?php echo $getOffice; ?>&type=1&excel=1" class="btn btn-primary btn-sm pull-right"> <i class="fa fa-download"></i> Download Excel</a></h4> -->
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="tab-parent">
                <table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">

                  <thead>
                    <tr class='bg-info'>
                      <!-- <th>SL</th> -->
                      <th>Name</th>
                      <th>Fusion ID</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Office</th>
                      <th>Resign/Term Date</th>
                      <th>Release Date/ LWD</th>
                      <th>FNF Status</th>
                      <?php $off_arr = array('CEB', 'MAN');
                      if (in_array(get_user_office_id(), $off_arr)) { ?>
                        <th>Process</th>
                        <th>Department</th>
                      <?php } ?>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody class="table_data_val"><span class="no_data"></span>

                  <tr>

<center><img class="loading-image" src="assets/loader.png" style="display:none;"/></center>
      </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>


      </div>


      <!-- tab content 2 closed here -->
      <div id="three" class="tab-pane fade">
        <div class="white-space">


          <div class="row a_id">
            <!-- <a href="<?php echo base_url('fnf/fnf_export_report_excel'); ?>?office=<?php echo $getOffice; ?>&type=2&excel=1" class="btn btn-primary btn-sm pull-right"> <i class="fa fa-download"></i> Download Excel</a></h4> -->
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="tab-parent">
                <table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">

                  <thead>
                    <tr class='bg-info'>
                      <!-- <th>SL</th> -->
                      <th>Name</th>
                      <th>Fusion ID</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Office</th>
                      <th>Resign/Term Date</th>
                      <th>Release Date/ LWD</th>
                      <th>FNF Status</th>
                      <?php $off_arr = array('CEB', 'MAN');
                      if (in_array(get_user_office_id(), $off_arr)) { ?>
                        <th>Process</th>
                        <th>Department</th>
                      <?php } ?>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody class="table_data_val"><span class="no_data"></span>
                  <tr>

<center><img class="loading-image" src="assets/loader.png" style="display:none;"/></center>
      </tr>
                  </tbody>

                </table>
              </div>
            </div>
          </div>
        </div>


      </div>
      <div id="four" class="tab-pane fade">
        <div class="white-space">

          <div class="row a_id">
            <!-- <a href="<?php echo base_url('fnf/fnf_export_report_excel'); ?>?office=<?php echo $getOffice; ?>&type=3&excel=1" class="btn btn-primary btn-sm pull-right"> <i class="fa fa-download"></i> Download Excel</a></h4> -->
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="tab-parent">
                <table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">

                  <thead>
                    <tr class='bg-info'>
                      <!-- <th>SL</th> -->
                      <th>Name</th>
                      <th>Fusion ID</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Office</th>
                      <th>Resign/Term Date</th>
                      <th>Release Date/ LWD</th>
                      <th>FNF Status</th>
                      <?php $off_arr = array('CEB', 'MAN');
                      if (in_array(get_user_office_id(), $off_arr)) { ?>
                        <th>Process</th>
                        <th>Department</th>
                      <?php } ?>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody class="table_data_val"><span class="no_data"></span>
                  <tr>

<center><img class="loading-image" src="assets/loader.png" style="display:none;"/></center>
      </tr>
                  </tbody>

                </table>
              </div>
            </div>
          </div>
        </div>


      </div>
      <div id="five" class="tab-pane fade">
        <div class="white-space">

          <div class="row">
            <a href="<?php echo base_url('fnf/fnf_export_report_excel'); ?>?office=<?php echo $getOffice; ?>&type=5&excel=1" class="btn btn-primary btn-sm pull-right"> <i class="fa fa-download"></i> Download Excel</a></h4>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="tab-parent">
                <table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">

                  <thead>
                    <tr class='bg-info'>
                      <!-- <th>SL</th> -->
                      <th>Name</th>
                      <th>Fusion ID</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Office</th>
                      <th>Resign/Term Date</th>
                      <th>Release Date/ LWD</th>
                      <th>FNF Status</th>
                      <?php $off_arr = array('CEB', 'MAN');
                      if (in_array(get_user_office_id(), $off_arr)) { ?>
                        <th>Process</th>
                        <th>Department</th>
                      <?php } ?>
                    </tr>
                  </thead>
                  <tbody class="table_data_val"><span class="no_data"></span>
                  <tr>

<center><img class="loading-image" src="assets/loader.png" style="display:none;"/></center>
      </tr>
                  </tbody>

                </table>
              </div>
            </div>
          </div>
        </div>


      </div>
      <div id="six" class="tab-pane fade">
        <div class="white-space">

          <div class="row a_id">
            <!-- <a href="<?php echo base_url('fnf/fnf_asset_export_report_excel'); ?>?office=<?php echo $getOffice; ?>&type=1&excel=1" class="btn btn-primary btn-sm pull-right"> <i class="fa fa-download"></i> Download Excel</a></h4> -->
          </div>

          <div class="row">

            <div class="col-md-12">
              <div class="tab-parent">
                <table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">

                  <thead>
                    <tr class='bg-info'>
                      <!-- <th>SL</th> -->
                      <th>Name</th>
                      <th>Fusion ID</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Office</th>
                      <th>Resign/Term Date</th>
                      <th>Release Date/ LWD</th>
                      <th>FNF Status</th>
                      <th>IT Local Acceptance Status</th>
                      <th>HR Acceptance Status</th>
                      <?php $off_arr = array('CEB', 'MAN');
                      if (in_array(get_user_office_id(), $off_arr)) { ?>
                        <th>Process</th>
                        <th>Department</th>
                      <?php } ?>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody class="table_data_val"><span class="no_data"></span>
                  <tr>

                <center><img class="loading-image" src="assets/loader.png" style="display:none;"/></center>
                      </tr>

                  </tbody>

                </table>
              </div>
            </div>
          </div>
        </div>


      </div>
      <div id="seven" class="tab-pane fade">
        <div class="white-space">
          <div class="row a_id">

            <!-- <a href="<?php echo base_url('fnf/fnf_asset_export_report_excel'); ?>?office=<?php echo $getOffice; ?>&type=2&excel=1" class="btn btn-primary btn-sm pull-right"> <i class="fa fa-download"></i> Download Excel</a> -->


          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="tab-parent">
                <table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">

                  <thead>
                    <tr class='bg-info'>
                      <!-- <th>SL</th> -->
                      <th>Name</th>
                      <th>Fusion ID</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Office</th>
                      <th>Resign/Term Date</th>
                      <th>Release Date/ LWD</th>
                      <th>FNF Status</th>
                      <th>IT Local Status</th>
                      <th>Procurement Status</th>
                      <?php $off_arr = array('CEB', 'MAN');
                      if (in_array(get_user_office_id(), $off_arr)) { ?>
                        <th>Process</th>
                        <th>Department</th>
                      <?php } ?>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody class="table_data_val"><span class="no_data"></span>
                  <tr>

              <center><img class="loading-image" src="assets/loader.png" style="display:none;"/></center>
      </tr>
                  </tbody>

                </table>
              </div>
            </div>
          </div>
        </div>


      </div>
    </div>
    <div class="">
      <div class="layout">

        <?php if (isAccessFNFHr() == true) {
          // echo isAccessFNFITGlobalHelpdesk();die;

        ?>


          <!--   <input name="nav" type="radio" class="nav home-radio" id="home" checked="checked" />
  <div class="page home-page">
    <div class="page-contents">
   
    </div>
  </div>
  <label class="nav" for="home">
    <span>
     
      HR FNF Checklist 
    </span>
  </label> -->

        <?php  } ?>

        <?php if (isAccessFNFITHelpdesk() == true) { ?>

          <!--   <input name="nav" type="radio" class="about-radio" id="about" />
  <div class="page about-page">
    <div class="page-contents">
     
    </div>
  </div>
  <label class="nav" for="about">
    <span>
    
    Local IT Team

      </span>
    </label> -->

        <?php  } ?>

        <?php if (isAccessFNFITNetwork() == false) { ?>

          <!-- 
   <input name="nav" type="radio" class="contact-radio" id="contact" />
  <div class="page contact-page">
    <div class="page-contents">
    
    </div>
  </div>
  <label class="nav" for="contact">
    <span>
   
    IT Network Team
      </span>
    
  </label> -->
        <?php  } ?>



        <?php if (isAccessFNFITGlobalHelpdesk() == false) { ?>


          <!-- <input name="nav" type="radio" class="contact-radio" id="it_global" />
<div class="page contact-page">
 <div class="page-contents">

 </div>
</div>
<label class="nav" for="it_global">
 <span>

 IT Global Helpdesk
   </span>
 
</label> -->
        <?php  } ?>


        <?php if (isAccessFNFITSecurity() == true) { ?>

          <!-- <input name="nav" type="radio" class="contact-radio" id="it_security" />
<div class="page contact-page">
 <div class="page-contents">
    
 </div>
</div>
<label class="nav" for="it_security">
 <span>

 IT Security Team
   </span>
 
</label> -->
        <?php  } ?>




        <?php if (isAccessFNFprocurement() == true) { ?>
          <!-- 
<input name="nav" type="radio" class="contact-radio" id="procurement_team" />
<div class="page contact-page">
 <div class="page-contents">
    
 </div>
</div>
<label class="nav" for="procurement_team">
 <span>

 Procurement Team
   </span>
 
</label> -->
        <?php  } ?>



        <?php if (isAccessFNFHr() == true) { ?>

          <!-- <input name="nav" type="radio" class="contact-radio" id="hr_team" />
<div class="page contact-page">
 <div class="page-contents">
   
 </div>
</div>
<label class="nav" for="hr_team">
 <span>

 HR Acceptance
   </span>
 
</label> -->
        <?php  } ?>










      </div>
    </div>





    <!-- =================================================== -->
    <!-- <div style='float:right; margin-top:2px;background: #fff;padding: 15px 10px 7px 10px;' class="col-md-12 new-btn-group new-content">
        <?php if ($status == "1") { ?>       
          <div class="form-group" style='float:right; padding-right:5px;'>
            <a href='?status=2' <span style="padding:12px;" class="label label-primary">View Upcoming</span></a>  
          </div>
                                    
        <?php } else { ?>
          <div class="form-group" style='float:right; padding-right:10px;'>
            <a href='?status=1' <span style="padding:12px;" class="label label-primary"> View Pending</span></a>  
          </div>
        <?php } ?>
    </div> -->















  </section>
</div>


<?php
//======================== IT HOLD MODAL ===========================================//
?>
<div class="modal fade" id="fnfITHoldModalTeam" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <form class="frmITHoldTeam" id="frmITHoldTeam" onsubmit="return false" method='POST' enctype="multipart/form-data">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">HOLD FNF</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" class="form-control" id="user_id" name="user_id">
          <input type="hidden" class="form-control" id="fnf_id" name="fnf_id">
          <input type="hidden" class="form-control" id="resign_id" name="resign_id">
          <input type="hidden" class="form-control" id="f_type" name="f_type">

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Status</label>
                <select class="form-control" name="it_hold_status" required>
                  <option value="1">Hold</option>
                  <option value="0">Unold</option>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Any Remarks (Optional)</label>
                <textarea class="form-control" name="it_hold_remarks" required></textarea>
              </div>
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" id='fnfITHoldTeamSave' class="btn btn-primary">Save changes</button>
        </div>

      </form>

    </div>
  </div>
</div>



<?php
//======================== IT SECURITY MODAL ===========================================//
?>
<div class="modal fade" id="fnfITSecurityTeam" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <form class="frmITSecurityTeam" id="frmITSecurityTeam" onsubmit="return false" method='POST' enctype="multipart/form-data">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">IT Security Checkout Completion</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" class="form-control" id="user_id" name="user_id">
          <input type="hidden" class="form-control" id="fnf_id" name="fnf_id">
          <input type="hidden" class="form-control" id="resign_id" name="resign_id">
          <input type="hidden" class="form-control" id="f_type" name="f_type">

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Any Remarks (Optional)</label>
                <textarea class="form-control" name="it_security_remarks" required></textarea>
              </div>
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" id='fnfITSecurityTeamSave' class="btn btn-primary">Save changes</button>
        </div>

      </form>

    </div>
  </div>
</div>


<?php
//======================== LOCAL IT MODAL ===========================================//
?>
<div class="modal fade" id="fnfITLocalTeam" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <form class="frmITLocalTeam" id="frmITLocalTeam" onsubmit="return false" method='POST' enctype="multipart/form-data">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">IT Local Team FNF</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" class="form-control" id="user_id" name="user_id">
          <input type="hidden" class="form-control" id="fnf_id" name="fnf_id">
          <input type="hidden" class="form-control" id="resign_id" name="resign_id">
          <input type="hidden" class="form-control" id="f_type" name="f_type">

          <div class="row" id="assets_maintanance_div">

            <div class="table-responsive">
              <h4>Active Assets</h4>
              <table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
                <thead>
                  <tr class='bg-info'>
                    <th>Name(Fusion ID)</th>
                    <th>Assets</th>
                    <th>Serial Number</th>
                    <th>Model Number</th>
                    <th>Assign Date</th>
                    <th>Select Date</th>
                    <th>Select Document <span style="color:green">(PDF File allowed, Max size 5 MB)</span></th>
                    <th>Comments</th>
                    <th>Release</th>
                  </tr>
                </thead>
                <tbody id="it_local_user_assets_details"></tbody>
              </table>
              <h4>Released Assets</h4>
              <table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
                <thead>
                  <tr class='bg-info'>
                    <th>Name(Fusion ID)</th>
                    <th>Assets</th>
                    <th>Serial Number</th>
                    <th>Model Number</th>
                    <th>Assign Date</th>
                    <th>Release Date</th>
                    <th>View Document</th>
                    <th>Released by</th>
                  </tr>
                </thead>
                <tbody id="it_local_user_assets_details_returned"></tbody>
              </table>
            </div>
            <input type="checkbox" name="it_local_com_fnf" id="it_local_com_fnf" required> Complete FNF

          </div>

          <hr /><br />
          <div class="row">
            <h4>Return Date of : </h4>
            <br />

            <div class="col-md-12">
              <div class="form-group row">
                <div class="col-md-12">
                  <label>Computer/Laptop & Accessories</label>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-3">
                  <select class="form-control yesNoSelection" name="is_return_computer_date">
                    <option value="">-- Select --</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                    <option value="N/A">Not Applicable</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <input type="text" class="form-control datePicker" name="return_computer_date" placeholder="Enter Return Date">
                </div>
                <div class="col-md-5">
                  <span class="imgView"></span>
                  <input type="file" class="form-control" name="return_computer_date_file">
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group row">
                <div class="col-md-12">
                  <label>Headset</label>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-3">
                  <select class="form-control yesNoSelection" name="is_return_computer_headset">
                    <option value="">-- Select --</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                    <option value="N/A">Not Applicable</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <input type="text" class="form-control datePicker" name="return_computer_headset" placeholder="Enter Return Date">
                </div>
                <div class="col-md-5">
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group row">
                <div class="col-md-12">
                  <label>Any Other Tools/Accessories</label>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-3">
                  <select class="form-control yesNoSelection" name="is_return_computer_tools">
                    <option value="">-- Select --</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                    <option value="N/A">Not Applicable</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <input type="text" class="form-control datePicker" name="return_computer_tools" placeholder="Enter Return Date">
                </div>
                <div class="col-md-5">
                </div>
              </div>
            </div>
          </div>

          <hr /><br />

          <div class="row">
            <h4>Disablement Date of : </h4>
            <br />

            <div class="col-md-12">
              <div class="form-group row">
                <div class="col-md-12">
                  <label>Dialer ID</label>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-3">
                  <select class="form-control yesNoSelection" name="is_disable_dialer_id">
                    <option value="">-- Select --</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                    <option value="N/A">Not Applicable</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <input type="text" class="form-control datePicker" name="disable_dialer_id" placeholder="Enter Disbalement Date">
                </div>
                <div class="col-md-5">
                  <span class="imgView"></span>
                  <input type="file" class="form-control" name="disable_dialer_id_file">
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group row">
                <div class="col-md-12">
                  <label>Client/Fusion CRM ID</label>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-3">
                  <select class="form-control yesNoSelection" name="is_disable_crm_id">
                    <option value="">-- Select --</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                    <option value="N/A">Not Applicable</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <input type="text" class="form-control datePicker" name="disable_crm_id" placeholder="Enter Disbalement Date">
                </div>
                <div class="col-md-5">
                  <span style="display:none" class="imgView"></span>
                  <input type="file" class="form-control" name="disable_crm_id_file">
                </div>
              </div>
            </div>

            <hr />

            <div class="col-md-12">
              <div class="form-group row">
                <div class="col-md-12">
                  <label>IT Local Comments</label>
                  <textarea class="form-control" name="it_local_comments" required></textarea>
                </div>
              </div>
            </div>


          </div>

          <hr /><br />

          <div class="row securityRemarks" style="display:none">
            <div class="col-md-12">
              <div class="form-group">
                <label>IT Security Remarks</label>
                <textarea class="form-control" name="security_remarks" required></textarea>
              </div>
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" id='fnfITLocalSave' class="btn btn-primary">Save changes</button>

        </div>

      </form>

    </div>
  </div>
</div>



<?php
//======================== NETWORK MODAL ===========================================//
?>
<div class="modal fade" id="fnfITNetworkTeam" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <form class="frmITNetworkTeam" id="frmITNetworkTeam" onsubmit="return false" method='POST' enctype="multipart/form-data">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">IT Network Team FNF</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" class="form-control" id="user_id" name="user_id">
          <input type="hidden" class="form-control" id="fnf_id" name="fnf_id">
          <input type="hidden" class="form-control" id="resign_id" name="resign_id">
          <input type="hidden" class="form-control" id="f_type" name="f_type">

          <div class="row">
            <h4>Disablement Date of : </h4>
            <br />

            <div class="col-md-12">
              <div class="form-group row">
                <div class="col-md-12">
                  <label>Client/Fusion VPN ID</label>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-3">
                  <select class="form-control yesNoSelection" name="is_disablement_date_vpn">
                    <option value="">-- Select --</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                    <option value="N/A">Not Applicable</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <input type="text" class="form-control datePicker" name="disablement_date_vpn" placeholder="Enter Disbalement Date">
                </div>
                <div class="col-md-5">
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group row">
                <div class="col-md-12">
                  <label>Firewall Access List </label>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-3">
                  <select class="form-control yesNoSelection" name="is_disablement_date_firewall">
                    <option value="">-- Select --</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                    <option value="N/A">Not Applicable</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <input type="text" class="form-control datePicker" name="disablement_date_firewall" placeholder="Enter Disbalement Date">
                </div>
                <div class="col-md-5">
                  <span style="display:none" class="imgView"></span>
                  <input type="file" class="form-control" name="disablement_date_firewall_file">
                </div>
              </div>
            </div>
          </div>

          <hr /><br />

          <div class="row securityRemarks" style="display:none">
            <div class="col-md-12">
              <div class="form-group">
                <label>IT Security Remarks</label>
                <textarea class="form-control" name="security_remarks" required></textarea>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" id='fnfITNetworkSave' class="btn btn-primary">Save changes</button>
        </div>

      </form>

    </div>
  </div>
</div>


<?php
//======================== IT GLOBAL HELPDESK MODAL ===========================================//
?>
<div class="modal fade" id="fnfITGlobalHelpdeskTeam" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <form class="frmITGlobalHelpdeskTeam" id="frmITGlobalHelpdeskTeam" onsubmit="return false" method='POST' enctype="multipart/form-data">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">IT Global Helpdesk Team FNF</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" class="form-control" id="user_id" name="user_id">
          <input type="hidden" class="form-control" id="fnf_id" name="fnf_id">
          <input type="hidden" class="form-control" id="resign_id" name="resign_id">
          <input type="hidden" class="form-control" id="f_type" name="f_type">

          <div class="row">
            <h4>Disablement Date of : </h4>
            <br />

            <div class="col-md-12">
              <div class="form-group row">
                <div class="col-md-12">
                  <label>Domain ID</label>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-3">
                  <select class="form-control yesNoSelection" name="is_disablement_date_domain">
                    <option value="">-- Select --</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                    <option value="N/A">Not Applicable</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <input type="text" class="form-control datePicker" name="disablement_date_domain" placeholder="Enter Disbalement Date">
                </div>
                <div class="col-md-5">
                  <span style="display:none" class="imgView"></span>
                  <input type="file" class="form-control" name="disablement_date_domain_file">
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group row">
                <div class="col-md-12">
                  <label>Email ID</label>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-3">
                  <select class="form-control yesNoSelection" name="is_disablement_date_email">
                    <option value="">-- Select --</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                    <option value="N/A">Not Applicable</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <input type="text" class="form-control datePicker" name="disablement_date_email" placeholder="Enter Disbalement Date">
                </div>
                <div class="col-md-5">
                  <span style="display:none" class="imgView"></span>
                  <input type="file" class="form-control" name="disablement_date_email_file">
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group row">
                <div class="col-md-12">
                  <label>Ticketing Portal ID</label>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-3">
                  <select class="form-control yesNoSelection" name="is_disablement_date_ticket">
                    <option value="">-- Select --</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                    <option value="N/A">Not Applicable</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <input type="text" class="form-control datePicker" name="disablement_date_ticket" placeholder="Enter Disbalement Date">
                </div>
                <div class="col-md-5">
                  <span style="display:none" class="imgView"></span>
                  <input type="file" class="form-control" name="disablement_date_ticket_file">
                </div>
              </div>
            </div>
          </div>

          <hr /><br />

          <div class="row securityRemarks" style="display:none">
            <div class="col-md-12">
              <div class="form-group">
                <label>IT Security Remarks</label>
                <textarea class="form-control" name="security_remarks" required></textarea>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" id='fnfITGlobalHelpdeskSave' class="btn btn-primary">Save changes</button>
        </div>

      </form>

    </div>
  </div>
</div>






<?php
//======================== PAYROLL TEAM ===========================================//
?>
<div class="modal fade" id="fnfPayrollTeam" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <form class="frmPayrollTeam" id="frmPayrollTeam" onsubmit="return false" method='POST' autocomplete="off" enctype="multipart/form-data">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" data-toggle="validator" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Payroll Team FNF</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" class="form-control" id="user_id" name="user_id">
          <input type="hidden" class="form-control" id="fnf_id" name="fnf_id">
          <input type="hidden" class="form-control" id="resign_id" name="resign_id">
          <input type="hidden" class="form-control" id="f_type" name="f_type">

          <div class="row payrollTeamGross">

            <div class="col-md-12">
              <div class="form-group">
                <label>Last Month Unpaid Gross Salary</label>
                <input class="form-control" name="last_month_unpaid" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="last_month_unpaid" required>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label>Leave Encashment (If Applicable)</label>
                <input class="form-control" name="leave_encashment" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="leave_encashment" required>
              </div>
            </div>

            <hr />

            <div class="col-md-12">
              <div class="form-group">
                <label>Notice Pay-Out (If Applicable)</label>
                <input class="form-control" name="notice_pay" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="notice_pay" required>
              </div>
            </div>

            <hr />

            <div class="col-md-6">
              <div class="form-group">
                <label>PF (If Applicable)</label>
                <input class="form-control" name="pf_deduction" onkeyup="this.value=this.value.replace(/[^\d]/,'')" id="pf_deduction" required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>ESIC (If Applicable)</label>
                <input class="form-control" name="esic_deduction" onkeyup="this.value=this.value.replace(/[^\d]/,'')" id="esic_deduction" required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>P.TAX (If Applicable)</label>
                <input class="form-control" name="ptax_deduction" onkeyup="this.value=this.value.replace(/[^\d]/,'')" id="ptax_deduction" required>
              </div>
            </div>

            <hr />

            <div class="col-md-6">
              <div class="form-group">
                <label>TDS (If Applicable)</label>
                <input class="form-control" name="tds_deductions" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="tds_deductions" required>
              </div>
            </div>

            <hr />

            <!--<div class="col-md-12">
          <div class="form-group">                    
            <label>Other Pay</label>
            <input class="form-control" name="others_pay" id="others_pay"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
          </div>
        </div>-->

            <hr />

            <div class="col-md-12">
              <div class="form-group">
                <label>Loan/Joining Bonus (If Applicable)</label>
                <input class="form-control" name="loan_recovery" id="loan_recovery" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label>Total Deduction</label>
                <input class="form-control" name="total_deduction" id="total_deduction" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label>Net Payment</label>
                <input class="form-control" name="net_payment" id="net_payment" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
              </div>
            </div>

          </div>

          <hr /><br />

          <div class="row payrollTeamBioMetric">
            <div class="col-md-12">
              <div class="form-group row">
                <div class="col-md-12">
                  <label>Bio-Metric Access revocation Confirmation</label>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-4">
                  <select class="form-control" name="biometric_access_revocation">
                    <option value="">-- Select Option --</option>
                    <option value="No">No</option>
                    <option value="Yes">Yes</option>
                  </select>
                </div>
                <div class="col-md-8">
                  <span style="display:none" class="imgView"></span>
                  <input type="file" class="form-control" name="biometric_access_revocation_file">
                </div>
              </div>
            </div>
          </div>


          <hr /><br />

          <div class="row securityRemarks" style="display:none">
            <div class="col-md-12">
              <div class="form-group">
                <label>IT Security Remarks</label>
                <textarea class="form-control" name="security_remarks" required></textarea>
              </div>
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" id='fnfPayrollTeamSave' class="btn btn-primary">Save changes</button>
        </div>

      </form>

    </div>
  </div>
</div>



<?php
//======================== ACCOUNTS TEAM ===========================================//
?>
<div class="modal fade" id="fnfAccountsTeam" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <form class="frmAccountsTeam" id="frmAccountsTeam" onsubmit="return false" method='POST'>

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" data-toggle="validator" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Accounts Team FNF</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" class="form-control" id="user_id" name="user_id">
          <input type="hidden" class="form-control" id="fnf_id" name="fnf_id">
          <input type="hidden" class="form-control" id="payment_id" name="payment_id">
          <input type="hidden" class="form-control" id="resign_id" name="resign_id">

          <div class="row">

            <div class="col-md-12">
              <div class="form-group">
                <label>Last Month Unpaid Gross Salary</label>
                <input class="form-control" name="last_month_unpaid" readonly required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Leave Encashment</label>
                <input class="form-control" name="leave_encashment" readonly required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Notice Pay-Out</label>
                <input class="form-control" name="notice_pay" readonly required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>PF (If Applicable)</label>
                <input class="form-control" name="pf_deduction" readonly required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>ESIC (If Applicable)</label>
                <input class="form-control" name="esic_deduction" readonly required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>P.TAX (If Applicable)</label>
                <input class="form-control" name="ptax_deduction" readonly required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>TDS Deduction (If Applicable)</label>
                <input class="form-control" name="tds_deductions" readonly>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Loan Recovery/Joining Bonus Recovery</label>
                <input class="form-control" name="loan_recovery" readonly>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Total Deduction</label>
                <input class="form-control" name="total_deduction" readonly required>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label>Net Payment</label>
                <input class="form-control" name="net_payment" readonly required>
              </div>
            </div>

          </div>

          <hr />

          <div class="row" id="accountSubmissionStatus">

            <div class="col-md-6">
              <div class="form-group">
                <label>Salary Advance/ Loan Status</label>
                <textarea class="form-control" name="status_salary_loan"></textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Corporate Credit Card Status</label>
                <textarea class="form-control" name="status_credit_card"></textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Company Gift Card status</label>
                <textarea class="form-control" name="status_gift_card"></textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Reimbursement status</label>
                <textarea class="form-control" name="status_reimbursement"></textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Incentive / Bonus Status</label>
                <textarea class="form-control" name="status_incentive"></textarea>
              </div>
            </div>

          </div>

          <hr />
          <div class="row" id="accountSubmission">
            <div class="col-md-6">
              <div class="form-group">
                <label>Account Status</label>
                <select class="form-control" name="account_status" id="account_status" required>
                  <option value="C">Accept</option>
                  <option value="R">Reject</option>
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Enter Remarks</label>
                <textarea class="form-control" name="account_remarks" id="account_remarks" required></textarea>
              </div>
            </div>

          </div>


        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" id='fnfAccountsTeamSave' class="btn btn-primary">Save changes</button>
        </div>

      </form>

    </div>
  </div>
</div>



<?php //================================= HR FINAL ACTION ===============================// 
?>

<!-------------------------------------------------------------------------->
<!-------------HR List------------------>
<div class="modal fade" id="fnfFinalHRModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <form class="frmfnfFinalHR" onsubmit="return false" method='POST'>

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Submit Final FNF By HR</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" class="form-control" id="fnfid" name="fnfid">

          <div class="row">

            <div class="col-md-12">
              <div class="form-group">
                <label for="name">Comments **</label>
                <textarea class="form-control" row='6' id="final_comments" name="final_comments"></textarea>
              </div>
            </div>

          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" id='fnfFinalHRSave' class="btn btn-primary">Save changes</button>
        </div>

      </form>

    </div>
  </div>
</div>


<div class="modal fade" id="fnfFinalHRModelBulk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width:80%">
    <div class="modal-content">

      <form class="frmfnfFinalHRBulk" action="<?php echo base_url('fnf/bulk_fnf_hr_submission'); ?>" method='POST'>

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Bulk FNF By HR</h4>
        </div>
        <div class="modal-body">

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>

      </form>

    </div>
  </div>
</div>


<div class="modal fade" id="procurement_fnf_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width:70%">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Procurement Team FNF</h4>
      </div>
      <form method="post" action="<?= base_url() ?>fnf/procrument_fnf_submit" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="widget-body">
            <div class="table-responsive">
              <h4>Active Assets</h4>
              <table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
                <thead>
                  <tr class='bg-info'>
                    <th>Name(Fusion ID)</th>
                    <th>Assets</th>
                    <th>Serial Number</th>
                    <th>Model Number</th>
                    <th>Assign Date</th>
                    <th>IT Release Date</th>
                    <th>IT Document</th>
                    <th>IT Comments</th>
                    <th>Select Date</th>
                    <th>Select Document <span style="color:green">(PDF File allowed, Max size 5 MB)</span></th>
                    <th>Comments</th>
                    <th>Release</th>
                  </tr>
                </thead>
                <tbody id="user_assets_details"></tbody>
              </table>
              <h4>Released Assets</h4>
              <table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
                <thead>
                  <tr class='bg-info'>
                    <th>Name(Fusion ID)</th>
                    <th>Assets</th>
                    <th>Serial Number</th>
                    <th>Model Number</th>
                    <th>Assign Date</th>
                    <th>IT Release Date</th>
                    <th>IT Document</th>
                    <th>IT Comments</th>
                    <th>Release Date</th>
                    <th>View Document</th>
                    <th>Comments</th>
                    <th>Released by</th>
                  </tr>
                </thead>
                <tbody id="user_assets_details_returned"></tbody>
              </table>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="name">HR Comments **</label>
                <textarea class="form-control" row='6' id="hr_acc_comment" name="hr_acc_comment" disabled="disabled"></textarea>
              </div>
            </div>
            <input type="checkbox" name="com_fnf" id="com_fnf" required> Complete FNF
          </div>





        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success" id="assets_fnf_submit_btn">Save</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="acceptance_fnf_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width:70%">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">HR Acceptance FNF</h4>
      </div>
      <form method="post" action="<?= base_url() ?>fnf/acceptance_fnf_submit" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="widget-body">
            <div class="table-responsive">
              <h4>Active Assets</h4>
              <table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
                <thead>
                  <tr class='bg-info'>
                    <th>Name(Fusion ID)</th>
                    <th>Assets</th>
                    <th>Serial Number</th>
                    <th>Model Number</th>
                    <th>Assign Date</th>
                    <th>IT Release Date</th>
                    <th>IT Document</th>
                    <th>IT Comments</th>
                    <th>Comments</th>
                    <th>Select Date</th>
                    <th>Release</th>
                  </tr>
                </thead>
                <tbody id="user_assets_details"></tbody>
              </table>
              <h4>Released Assets</h4>
              <table id="default-datatable" data-plugin="DataTable" class="table table-striped skt-table" cellspacing="0" width="100%">
                <thead>
                  <tr class='bg-info'>
                    <th>Name(Fusion ID)</th>
                    <th>Assets</th>
                    <th>Serial Number</th>
                    <th>Model Number</th>
                    <th>Assign Date</th>
                    <th>IT Release Date</th>
                    <th>IT Document</th>
                    <th>IT Comments</th>
                    <th>Release Date</th>
                    <th>View Document</th>
                    <th>Comments</th>
                    <th>Released by</th>
                  </tr>
                </thead>
                <tbody id="user_assets_details_returned"></tbody>
              </table>
            </div>


            <div class="col-md-12">
              <div class="form-group">
                <label for="name">Comments **</label>
                <textarea class="form-control" row='6' id="hr_acceptance_comment" name="hr_acceptance_comment" required></textarea>
              </div>
            </div>
            <input type="checkbox" name="hr_acceptance_com_fnf" id="hr_acceptance_com_fnf" required> Complete FNF
          </div>

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success" id="acceptance_fnf_submit_btn" disabled>Save</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- <script type="text/javascript" src="https://10.80.51.10/femsdev/assets/css/search-filter/js/bootstrap-multiselect.js"></script> -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap.min.js"></script>




<!-- <link rel="stylesheet" href="https://10.80.51.10/femsdev/assets/css/search-filter/css/selectize.bootstrap3.min.css" /> -->

<script>
  $(document).ready(function() {
    $('#show_datatable').DataTable();
  });
</script>
<script>
  $(function() {
    $('#multiselect').multiselect();

    $('#foffice_id').multiselect({
      includeSelectAllOption: true,
      enableFiltering: true,
      enableCaseInsensitiveFiltering: true,
      filterPlaceholder: 'Search for something...'
    });
  });



  get_list = (val) => {
    // alert(val);
    var cn = 1;

    // dettachScrollEvent();
    // $("#page_offset").val("");
    $(".no_data").html("");
    $('.table_data_val').html("");

    // $(".fnf_type").attr("data-fnf_status",val); //setter 
    $(".fnf_type").val(val); //setter 

    URL = '<?php echo base_url('fnf/fetch_data_according_category') ?>';

    let foffice_id = $(".foffice_id").val();
    //  alert(foffice_id);
    let form_date = $(".form_date").val();
    let to_date = $(".to_date").val();
    let mwp_ids = $(".mwp_ids").val();
    $("#page_open").val(val);
    // $("#page_offset").val(offset);

    // if (type == 'N') {
    //   $('.table_data_val').html("");
    // }
    $.ajax({
      url: URL,
      type: "GET",
      data: {
        office_id: foffice_id,
        form_date: form_date,
        to_date: to_date,
        mwp_ids: mwp_ids,
        val: val
      },
      beforeSend: function() {
              $(".loading-image").show();
           },
      // data: { eid : eidVal },
      dataType: "text",
      success: function(json_obj) {
        // console.log(json_obj);
        $(".loading-image").hide();
        var alrt = JSON.parse(json_obj);
        console.log(alrt.hr_checklist);

        // console.log(alrt.date_res);
        $(".onload_tr_value").hide();
        // <a  class="btn btn-primary btn-sm pull-right a_id"> <i class="fa fa-download"></i> Download Excel</a>
        if (val == 'hr_fnf') {
          var URL_new = '<?php echo base_url('fnf/fnf_export_report_excel') ?>';
          // $('.a_id').html("<a class='btn btn-primary btn-sm pull-right' href=" + URL_new + "?office=" + foffice_id + "&type=7&excel=1><i class='fa fa-download'></i> Download Excel</a>");
          $('.a_id').html("<a class='btn btn-primary btn-sm pull-right' href=" + URL_new + "?office=" + foffice_id + "&f_date=" 
          +form_date+"&t_date="+to_date+"&type=7&excel=1><i class='fa fa-download'></i> Download Excel</a>");
        }
        if (val == 'local_it') {
          var URL_new = '<?php echo base_url('fnf/fnf_export_report_excel') ?>';

          $('.a_id').html("<a class='btn btn-primary btn-sm pull-right' href=" + URL_new + "?office=" + foffice_id + "&f_date=" 
          + form_date +"&t_date=" + to_date +"&type=1&excel=1><i class='fa fa-download'></i> Download Excel</a>");
        }
        if (val == 'it_network') {
          var URL_new = '<?php echo base_url('fnf/fnf_export_report_excel') ?>';


          $('.a_id').html("<a class='btn btn-primary btn-sm pull-right' href=" + URL_new + "?office=" + foffice_id + "&f_date=" 
          + form_date + "&t_date=" + to_date + "&type=2&excel=1><i class='fa fa-download'></i> Download Excel</a>");
        }
        if (val == 'it_global') {
          var URL_new = '<?php echo base_url('fnf/fnf_export_report_excel') ?>';



          $('.a_id').html("<a class='btn btn-primary btn-sm pull-right' href=" + URL_new + "?office=" + foffice_id + "&f_date=" 
          + form_date + "&t_date=" + to_date + "&type=3&excel=1><i class='fa fa-download'></i> Download Excel</a>");
        }

        if (val == 'procurement') {
          var URL_new = '<?php echo base_url('fnf/fnf_asset_export_report_excel') ?>';



          $('.a_id').html("<a class='btn btn-primary btn-sm pull-right' href=" + URL_new + "?office=" + foffice_id + "&f_date=" 
          + form_date + "&t_date=" + to_date + "&type=1&excel=1><i class='fa fa-download'></i> Download Excel</a>");
        }

        if (val == 'hr_acceptance') {
          var URL_new = '<?php echo base_url('fnf/fnf_asset_export_report_excel') ?>';


          $('.a_id').html("<a class='btn btn-primary btn-sm pull-right' href=" + URL_new + "?office=" + foffice_id + "&f_date=" 
          + form_date + "&t_date=" + to_date + "&type=2&excel=1><i class='fa fa-download'></i> Download Excel</a>");
        }


        var html = '';

        if (alrt.hr_checklist.length > 0) {

          for (var i in alrt.hr_checklist) {
            var starclass = '';
            html += `<tr >`;

            // hr fnf start here
            if (val == 'hr_fnf') {


              var td_val = `<input type="checkbox" class="check" name="check_box[]" value="` + fnfid + `">`;
              var isOpenFNFBtn = true;
              var fnfid = alrt.hr_checklist[i].id;
              // var user_id=alrt.hr_checklist[i].user_id;
              // IT LOCAL    
              var local_status = "<span class='text-danger font-weight-bold'><i class='fa fa-circle'></i> Pending</span>";
              if (alrt.hr_checklist[i].it_local_status == 'C') {
                local_status = "<span class='text-success font-weight-bold'><i class='fa fa-circle'></i> Completed</span>";
              } else isOpenFNFBtn = false;


              // IT NETWORK    
              var network_status = "<span class='text-danger font-weight-bold'><i class='fa fa-circle'></i> Pending</span>";
              if (alrt.hr_checklist[i].it_network_status == 'C') {
                network_status = "<span class='text-success font-weight-bold'><i class='fa fa-circle'></i> Completed</span>";
              } else isOpenFNFBtn = false;


              // IT HELPDESK    
              var helpdesk_status = "<span class='text-danger font-weight-bold'><i class='fa fa-circle'></i> Pending</span>";
              if (alrt.hr_checklist[i].it_global_helpdesk_status == 'C') {
                helpdesk_status = "<span class='text-success font-weight-bold'><i class='fa fa-circle'></i> Completed</span>";
              } else isOpenFNFBtn = false;

              // Procurement Team 
              // alert(alrt.hr_checklist[i].stock_history);    
              if (alrt.hr_checklist[i].stock_history != null) {
                var procurement_status = "<span class='text-danger font-weight-bold'><i class='fa fa-circle'></i> Pending</span>";
                if (alrt.hr_checklist[i].it_procurement_status == '1') {
                  procurement_status = "<span class='text-success font-weight-bold'><i class='fa fa-circle'></i> Completed</span>";
                } else isOpenFNFBtn = false;
              } else {
                procurement_status = '-';
              }

              // HR Acceptance       
              if (alrt.hr_checklist[i].stock_history != null) {
                var hr_acceptance_status = "<span class='text-danger font-weight-bold'><i class='fa fa-circle'></i> Pending</span>";
                if (alrt.hr_checklist[i].hr_acceptance_status == '1') {
                  hr_acceptance_status = "<span class='text-success font-weight-bold'><i class='fa fa-circle'></i> Completed</span>";
                } else isOpenFNFBtn = false;
              } else {
                hr_acceptance_status = '-';
              }






              var display_email = 'Hide';

              if (alrt.hr_checklist[i].it_local_status == 'C' && alrt.hr_checklist[i].it_network_status == 'C' && alrt.hr_checklist[i].it_global_helpdesk_status == 'C') {

                display_email = 'Show';

              }




              var rnt_date = alrt.hr_checklist[i].resign_date;
              if (rnt_date == "") rnt_date = alrt.hr_checklist[i].terms_date;

              var lwd_date = alrt.hr_checklist[i].dol;
              if (lwd_date == "") lwd_date = alrt.hr_checklist[i].accepted_released_date;
              if (lwd_date == "") lwd_date = alrt.hr_checklist[i].lwd;




              var holdStatus = alrt.hr_checklist[i].is_hold;
              var holdName = "Hold";
              var classbtn7 = "primary";
              if (holdStatus == 1) {
                holdName = "Unhold";
                classbtn7 = "danger";
              }







              html += `<td>` + td_val + `` + `</td>`;
              html += `<td>` + alrt.hr_checklist[i].fullname + `</td>
                        <td>` + alrt.hr_checklist[i].fusion_id + `</td>
                        <td>` + alrt.hr_checklist[i].user_email + `</td>
                        <td>` + alrt.hr_checklist[i].user_phone + `</td>
                        <td>` + alrt.hr_checklist[i].office_id + `</td>
                        <td>` + rnt_date + `</td>
                        <td>` + lwd_date + `</td>`;
              html += `<td>` + local_status + `` + `</td>`;
              html += `<td>` + network_status + `` + `</td>`;
              html += `<td>` + helpdesk_status + `` + `</td>`;
              html += `<td>` + procurement_status + `` + `</td>`;
              html += `<td>` + hr_acceptance_status + `` + `</td>`;

              var off_arr = ["CEB", "MAN"];
              // alert(off_arr.includes(alrt.get_user_office_id));
              if (off_arr.includes(alrt.get_user_office_id)) {
                html += `<td>` + alrt.hr_checklist[i].process_names + `` + `</td>`;
                html += `<td>` + alrt.hr_checklist[i].dept_name + `` + `</td>`;

              }



              // alert(get_user_office_id());
              html += `<td>` + alrt.hr_checklist[i].fnf_status + `` + `</td>`;


              var holdStatus = alrt.hr_checklist[i].is_hold;
              var holdName = "Hold";
              var classbtn7 = "primary";
              if (holdStatus == 1) {
                holdName = "Unhold";
                classbtn7 = "danger";
              }

              if (holdStatus == 0) {
                if (isOpenFNFBtn == true) {
                  html += `<td><button title='FNF compilation' fnfid="` + fnfid + `" type='button' class='complete_FNF btn btn-danger btn-xs' style='font-size:10px'>Complete FNF</button>`;

                } else {
                  html += `<td><button title='Button will activate after FNF compilation' disabled fnfid="` + fnfid + `" type='button' class='complete_FNF btn btn-danger btn-xs' style='font-size:10px'>Complete FNF</button>`;
                }
              } else {
                html += `<td><span class="text-warning"><b>ON HOLD</b></span>`;
              }

              if (alrt.hr_checklist[i].resign_id != "") {

                html += `	<a class="btn btn-success btn-xs" href="<?php echo base_url(); ?>fnf/send_release_letter/` + fnfid + `/D" target="_blank" title="Click to View Release_letter " style="font-size:12px"><i class="fa fa-print"></i></a>`;
                if (display_email == 'Show') {
                  html += `	<a class="btn btn-success btn-xs" onclick="return confirm('Are you sure you want to resend the release letter?')" href="<?php echo base_url(); ?>fnf/send_release_letter/` + fnfid + `/Y/Y" title="Click to Resend Release_letter " style="font-size:12px"><i class="fa fa-envelope"></i></a>`;

                }
              }

            }
            //hr fnf end here
            //local it start here
            if (val == 'local_it') {


              var extrapar = alrt.hr_checklist[i].user_id + "#" + alrt.hr_checklist[i].resign_id + "#" + alrt.hr_checklist[i].id + "#" + alrt.hr_checklist[i].term_id;

              var btn_disabled = "";
              var ustatus = "<span class='text-danger font-weight-bold'>Pending</span>";
              var classbtn = "danger";
              if (alrt.hr_checklist[i].it_local_status == 'C') {

                ustatus = "<span class='text-success font-weight-bold'>Completed</span>";
                classbtn = "success";
                btn_disabled = "disabled";
              }




              var rnt_date = alrt.hr_checklist[i].resign_date;
              if (rnt_date == "") rnt_date = alrt.hr_checklist[i].terms_date;
              var lwd_date = alrt.hr_checklist[i].dol;
              if (lwd_date == "") lwd_date = alrt.hr_checklist[i].accepted_released_date;
              if (lwd_date == "") lwd_date = alrt.hr_checklist[i].lwd;





              var holdStatus = alrt.hr_checklist[i].is_hold;
              var holdName = "Hold";
              var classbtn7 = "primary";
              if (holdStatus == 1) {
                holdName = "Unhold";
                classbtn7 = "warning";
              }



              html += `<td>` + alrt.hr_checklist[i].fullname + `</td>
                            <td>` + alrt.hr_checklist[i].fusion_id + `</td>
                            <td>` + alrt.hr_checklist[i].user_email + `</td>
                            <td>` + alrt.hr_checklist[i].user_phone + `</td>
                            <td>` + alrt.hr_checklist[i].office_id + `</td>
                            <td>` + rnt_date + `</td>
                            <td>` + lwd_date + `</td>`;
              html += `<td>` + ustatus + `` + `</td>`;

              var off_arr = ["CEB", "MAN"];
              // alert(off_arr.includes(alrt.get_user_office_id));
              if (off_arr.includes(alrt.get_user_office_id)) {
                html += `<td>` + alrt.hr_checklist[i].process_names + `` + `</td>`;
                html += `<td>` + alrt.hr_checklist[i].dept_name + `` + `</td>`;

              }


              html += `<td>`;


              if (holdStatus == 0) {
                html += `<button title='Submit FNF' type='button' pstatus="` + alrt.hr_checklist[i].it_local_status + `" extrapar="` + extrapar + `" ftype="1" class='btn btn-` + classbtn + ` btn-xs editfnfITLocalTeam' style='font-size:12px'>
										<i class='fa fa-check-square'></i></button>`;
              }

              html += `<button ` + btn_disabled + ` title=` + holdName + ` FNF' type='button' extrapar="` + extrapar + `" ftype="7" class='btn btn-` + classbtn7 + ` btn-xs editfnfHoldTeam' style='font-size:12px'><i class='fa fa-clock-o'></i> ` + holdName + `</button></td>`;



            }
            ////////////////////it network

            if (val == 'it_network') {

              var extrapar = alrt.hr_checklist[i].user_id + "#" + alrt.hr_checklist[i].resign_id + "#" + alrt.hr_checklist[i].id + "#" + alrt.hr_checklist[i].term_id;

              var ustatus = "<span class='text-danger font-weight-bold'>Pending</span>";
              var classbtn = "danger";
              if (alrt.hr_checklist[i].it_network_status == 'C') {
                ustatus = "<span class='text-success font-weight-bold'>Completed</span>";
                classbtn = "success";

              }
              var rnt_date = alrt.hr_checklist[i].resign_date;
              if (rnt_date == "") rnt_date = alrt.hr_checklist[i].terms_date;

              var lwd_date = alrt.hr_checklist[i].dol;
              if (lwd_date == "") lwd_date = alrt.hr_checklist[i].accepted_released_date;
              if (lwd_date == "") lwd_date = alrt.hr_checklist[i].lwd;

              var holdStatus = alrt.hr_checklist[i].is_hold;
              var holdName = "Hold";
              var classbtn7 = "primary";
              if (holdStatus == 1) {
                holdName = "Unhold";
                classbtn7 = "warning";
              }



              html += `<td>` + alrt.hr_checklist[i].fullname + `</td>
                            <td>` + alrt.hr_checklist[i].fusion_id + `</td>
                            <td>` + alrt.hr_checklist[i].user_email + `</td>
                            <td>` + alrt.hr_checklist[i].user_phone + `</td>
                            <td>` + alrt.hr_checklist[i].office_id + `</td>
                            <td>` + rnt_date + `</td>
                            <td>` + lwd_date + `</td>`;
              html += `<td>` + ustatus + `` + `</td>`;

              var off_arr = ["CEB", "MAN"];
              // alert(off_arr.includes(alrt.get_user_office_id));
              if (off_arr.includes(alrt.get_user_office_id)) {
                html += `<td>` + alrt.hr_checklist[i].process_names + `` + `</td>`;
                html += `<td>` + alrt.hr_checklist[i].dept_name + `` + `</td>`;

              }


              html += `<td>`;

              if (holdStatus == 0) {
                html += `<button title='Submit FNF' type='button' extrapar="` + extrapar + `" ftype="1" class='btn btn-` + classbtn + ` btn-xs editfnfITNetworkTeam' style='font-size:12px'>
									<i class='fa fa-check-square'></i></button></td>`;
              } else {
                // echo '<span class="text-warning"><b>ON HOLD</b></span>';
                html += `<td><span class="text-warning"><b>ON HOLD</b></span></td>`;
              }
            }



            //////////////////it network closed here//////////////

            ///////////////IT global start here//////////////////


            if (val == 'it_global') {


              var extrapar = alrt.hr_checklist[i].user_id + "#" + alrt.hr_checklist[i].resign_id + "#" + alrt.hr_checklist[i].id + "#" + alrt.hr_checklist[i].term_id;
              var ustatus = "<span class='text-danger font-weight-bold'>Pending</span>";
              var classbtn = "danger";

              if (alrt.hr_checklist[i].it_global_helpdesk_status == 'C') {
                ustatus = "<span class='text-success font-weight-bold'>Completed</span>";
                classbtn = "success";

              }

              var rnt_date = alrt.hr_checklist[i].resign_date;
              if (rnt_date == "") rnt_date = alrt.hr_checklist[i].terms_date;

              var lwd_date = alrt.hr_checklist[i].dol;
              if (lwd_date == "") lwd_date = alrt.hr_checklist[i].accepted_released_date;
              if (lwd_date == "") lwd_date = alrt.hr_checklist[i].lwd;

              var holdStatus = alrt.hr_checklist[i].is_hold;
              var holdName = "Hold";
              var classbtn7 = "primary";
              if (holdStatus == 1) {
                holdName = "Unhold";
                classbtn7 = "warning";
              }


              html += `<td>` + alrt.hr_checklist[i].fullname + `</td>
                            <td>` + alrt.hr_checklist[i].fusion_id + `</td>
                            <td>` + alrt.hr_checklist[i].user_email + `</td>
                            <td>` + alrt.hr_checklist[i].user_phone + `</td>
                            <td>` + alrt.hr_checklist[i].office_id + `</td>
                            <td>` + rnt_date + `</td>
                            <td>` + lwd_date + `</td>`;
              html += `<td>` + ustatus + `` + `</td>`;

              var off_arr = ["CEB", "MAN"];
              // alert(off_arr.includes(alrt.get_user_office_id));
              if (off_arr.includes(alrt.get_user_office_id)) {
                html += `<td>` + alrt.hr_checklist[i].process_names + `` + `</td>`;
                html += `<td>` + alrt.hr_checklist[i].dept_name + `` + `</td>`;

              }


              html += `<td>`;


              if (holdStatus == 0) {
                html += `<button title='Submit FNF' type='button' extrapar="` + extrapar + `" ftype="1" class='btn btn-` + classbtn + ` btn-xs editfnfITGlobalHelpdeskTeam' style='font-size:12px'>
                  <i class='fa fa-check-square'></i></button></td>`;
              } else {
                // echo '<span class="text-warning"><b>ON HOLD</b></span>';
                html += `<td><span class="text-warning"><b>ON HOLD</b></span></td>`;
              }
            }







            //////////////IT Global end here///////////////////////


            ////IT security start here///////////

            // if (val == 'it_security') {

            //   var extrapar = alrt.hr_checklist[i].user_id + "#" + alrt.hr_checklist[i].resign_id + "#" + alrt.hr_checklist[i].id + "#" + alrt.hr_checklist[i].term_id;
            //   var ustatus5 = "<span class='text-danger font-weight-bold'>Pending</span>";
            //   var classbtn5 = "primary";


            //   if (alrt.hr_checklist[i].it_security_status == 'C') {
            //     ustatus5 = "<span class='text-success font-weight-bold'>Completed</span>";
            //     classbtn5 = "success";

            //   }

            //   var showCheckOutButton = 0;
            //   if (alrt.hr_checklist[i].it_global_helpdesk_remarks != "" && alrt.hr_checklist[i].it_local_remarks != "" && alrt.hr_checklist[i].it_network_remarks != "") {
            //     showCheckOutButton = 1;

            //   }







            //   var rnt_date = alrt.hr_checklist[i].resign_date;
            //   if (rnt_date == "") rnt_date = alrt.hr_checklist[i].terms_date;

            //   var lwd_date = alrt.hr_checklist[i].dol;
            //   if (lwd_date == "") lwd_date = alrt.hr_checklist[i].accepted_released_date;
            //   if (lwd_date == "") lwd_date = alrt.hr_checklist[i].lwd;

            //   var holdStatus = alrt.hr_checklist[i].is_hold;
            //   var holdName = "Hold";
            //   var classbtn7 = "primary";
            //   if (holdStatus == 1) {
            //     holdName = "Unhold";
            //     classbtn7 = "warning";
            //   }



            //   html += `<td>` + alrt.hr_checklist[i].fullname + `</td>
            //                 <td>` + alrt.hr_checklist[i].fusion_id + `</td>
            //                 <td>` + alrt.hr_checklist[i].user_email + `</td>
            //                 <td>` + alrt.hr_checklist[i].user_phone + `</td>
            //                 <td>` + alrt.hr_checklist[i].office_id + `</td>
            //                 <td>` + rnt_date + `</td>
            //                 <td>` + lwd_date + `</td>`;

            //   html += ` <td>` + ustatus5 + `</td>`;

            //   var off_arr = ["CEB", "MAN"];
            //   // alert(off_arr.includes(alrt.get_user_office_id));
            //   if(off_arr.includes(alrt.get_user_office_id)){
            //   html += `<td>` + alrt.hr_checklist[i].process_names + `` + `</td>`;
            //   html += `<td>` + alrt.hr_checklist[i].dept_name + `` + `</td>`;

            //   }

            // }

            //it security end here

            // it procurement start here

            if (val == 'procurement') {


              var extrapar = alrt.hr_checklist[i].user_id + "#" + alrt.hr_checklist[i].resign_id + "#" + alrt.hr_checklist[i].id + "#" + alrt.hr_checklist[i].term_id;

              var ustatus = "<span class='text-danger font-weight-bold'>Pending</span>";
              var classbtn = "danger";

              var itLocalaccstatus = "<span class='text-danger font-weight-bold'>Pending</span>";

              var hr_status = "<span class='text-danger font-weight-bold'>Pending</span>";




              if (alrt.hr_checklist[i].it_procurement_status == '1') {


                ustatus = "<span class='text-success font-weight-bold'>Completed</span>";
                classbtn = "success";

              }

              if (alrt.hr_checklist[i].it_local_acceptance_status == '1' || alrt.hr_checklist[i].it_local_status == 'C')

              {

                itLocalaccstatus = "<span class='text-success font-weight-bold'>Completed</span>";

              }

              if (alrt.hr_checklist[i].hr_acceptance_status == '1') {
                hr_status = "<span class='text-success font-weight-bold'>Completed</span>";
              }


              var rnt_date = alrt.hr_checklist[i].resign_date;
              if (rnt_date == "") rnt_date = alrt.hr_checklist[i].terms_date;

              var lwd_date = alrt.hr_checklist[i].dol;
              if (lwd_date == "") lwd_date = alrt.hr_checklist[i].accepted_released_date;
              if (lwd_date == "") lwd_date = alrt.hr_checklist[i].lwd;
              var holdStatus = alrt.hr_checklist[i].is_hold;
              var holdName = "Hold";
              var classbtn7 = "primary";
              if (holdStatus == 1) {
                holdName = "Unhold";
                classbtn7 = "warning";
              }



              html += `<td>` + alrt.hr_checklist[i].fullname + `</td>
                            <td>` + alrt.hr_checklist[i].fusion_id + `</td>
                            <td>` + alrt.hr_checklist[i].user_email + `</td>
                            <td>` + alrt.hr_checklist[i].user_phone + `</td>
                            <td>` + alrt.hr_checklist[i].office_id + `</td>
                            <td>` + rnt_date + `</td>
                            <td>` + lwd_date + `</td>`;

              html += ` <td>` + ustatus + `</td>`;
              html += ` <td>` + itLocalaccstatus + `</td>`;
              html += ` <td>` + hr_status + `</td>`;

              var off_arr = ["CEB", "MAN"];
              // alert(off_arr.includes(alrt.get_user_office_id));
              if (off_arr.includes(alrt.get_user_office_id)) {
                html += `<td>` + alrt.hr_checklist[i].process_names + `` + `</td>`;
                html += `<td>` + alrt.hr_checklist[i].dept_name + `` + `</td>`;

              }


              html += `<td>`;



              if (alrt.hr_checklist[i].it_local_acceptance_status == '1' || alrt.hr_checklist[i].it_local_status == 'C') {
                var disabled = '';
              } else {
                var disabled = 'disabled';
              }

              html += ` <button title='Submit FNF' type='button'  ` + disabled + ` pstatus= "` + alrt.hr_checklist[i].it_procurement_status + `" hrcomment= "` + alrt.hr_checklist[i].hr_acceptance_comment + `" extrapar="` + extrapar + `" ftype="1" class='btn btn-` + classbtn + ` btn-xs procrument_fnf_save' style='font-size:12px'>
                    <i class='fa fa-check-square'></i></button></td>`;
            }



            // it procurement end here






            if (val == 'hr_acceptance') {


              var extrapar = alrt.hr_checklist[i].user_id + "#" + alrt.hr_checklist[i].resign_id + "#" + alrt.hr_checklist[i].id + "#" + alrt.hr_checklist[i].term_id;

              var ustatus = "<span class='text-danger font-weight-bold'>Pending</span>";
              var classbtn = "danger";


              if (alrt.hr_checklist[i].hr_acceptance_status == '1') {
                ustatus = "<span class='text-success font-weight-bold'>Completed</span>";
                classbtn = "success";
              }

              var itLocalaccstatus = "<span class='text-danger font-weight-bold'>Pending</span>";
              var procurementstatus = "<span class='text-danger font-weight-bold'>Pending</span>";



              if (alrt.hr_checklist[i].it_local_acceptance_status == '1' || alrt.hr_checklist[i].it_local_status == 'C') {
                itLocalaccstatus = "<span class='text-success font-weight-bold'>Completed</span>";
              }

              if (alrt.hr_checklist[i].it_procurement_status == '1') {
                procurementstatus = "<span class='text-success font-weight-bold'>Completed</span>";
              }


              var rnt_date = alrt.hr_checklist[i].resign_date;
              if (rnt_date == "") rnt_date = alrt.hr_checklist[i].terms_date;


              var lwd_date = alrt.hr_checklist[i].dol;
              if (lwd_date == "") lwd_date = alrt.hr_checklist[i].accepted_released_date;
              if (lwd_date == "") lwd_date = alrt.hr_checklist[i].lwd;


              var holdStatus = alrt.hr_checklist[i].is_hold;
              var holdName = "Hold";
              var classbtn7 = "primary";
              if (holdStatus == 1) {
                holdName = "Unhold";
                classbtn7 = "warning";
              }


              html += `<td>` + alrt.hr_checklist[i].fullname + `</td>
                            <td>` + alrt.hr_checklist[i].fusion_id + `</td>
                            <td>` + alrt.hr_checklist[i].user_email + `</td>
                            <td>` + alrt.hr_checklist[i].user_phone + `</td>
                            <td>` + alrt.hr_checklist[i].office_id + `</td>
                            <td>` + rnt_date + `</td>
                            <td>` + lwd_date + `</td>`;

              html += ` <td>` + ustatus + `</td>`;
              html += ` <td>` + itLocalaccstatus + `</td>`;
              html += ` <td>` + procurementstatus + `</td>`;

              var off_arr = ["CEB", "MAN"];
              // alert(off_arr.includes(alrt.get_user_office_id));
              if (off_arr.includes(alrt.get_user_office_id)) {
                html += `<td>` + alrt.hr_checklist[i].process_names + `` + `</td>`;
                html += `<td>` + alrt.hr_checklist[i].dept_name + `` + `</td>`;

              }


              html += `<td>`;





              // if (alrt.hr_checklist[i].it_local_acceptance_status == '1' || alrt.hr_checklist[i].it_local_status == 'C') {
                // alert(alrt.hr_checklist[i].it_procurement_status);
              if (alrt.hr_checklist[i].it_procurement_status =='1') {
                
                var disabled = '';
              } else {
                var disabled = 'disabled';
              }












              html += ` <button title='Submit FNF' type='button'  ` + disabled + ` pstatus= "` + alrt.hr_checklist[i].hr_acceptance_status + `" hrcomment= "` + alrt.hr_checklist[i].hr_acceptance_comment + `" extrapar="` + extrapar + `" ftype="1" class='btn btn- ` + classbtn + ` btn-xs acceptance_fnf_save' style='font-size:12px'>
                    <i class='fa fa-check-square'></i></button></td>`;
            }




            html += `</tr>`;

            cn++;




          }
          // console.log(html);
          // $('.table_data_val').append(html + '<br />');
          $('.table_data_val').html(html + '<br />');

        } else {
          $('.no_data').html("No Data Available");
          return false;
        }

        // alert(html);

      },
      error: function(json_obj) {
        // $('#sktPleaseWait').modal('hide');
        alert('Something Went Wrong!');
      }

    });


  }





  $(document).ready(function() {

    get_list('hr_fnf');

    $("#date_from").datepicker({
      dateFormat: 'yy/mm/dd'
    });
    $("#date_to").datepicker({
      dateFormat: 'yy/mm/dd'
    });

    $(document).on('change', '#date_from', function() {
      var search_from_date = $(this).val();
      var search_to_date = $("#date_to").val();
      search_from_date = new Date(search_from_date);
      search_to_date = new Date(search_to_date);
      if (search_from_date > search_to_date) {
        alert("From Date can't be grater than To Date");
        $(".fnf_search_btn").prop("disabled", true);
      } else {
        $(".fnf_search_btn").prop("disabled", false);
      }

    });

    $(document).on('change', '#date_to', function() {
      var search_from_date = $('#date_from').val();
      var search_to_date = $(this).val();
      search_from_date = new Date(search_from_date);
      search_to_date = new Date(search_to_date);
      if (search_from_date > search_to_date) {
        alert("To Date can't be less than From Date");
        $(".fnf_search_btn").prop("disabled", true);
      } else {
        $(".fnf_search_btn").prop("disabled", false);
      }

    });

  });

  $(document).on('change', '.file_validation', function() {
    var fileName = $(this).val();
    const fileSize = this.files[0].size / 1024 / 1024; // in MiB
    if (fileSize > 5) {
      alert('File size exceeds 5 MB');
      this.value = '';
    } else {
      var ext = fileName.substring(fileName.lastIndexOf(".") + 1, fileName.length);
      ext = ext.toLowerCase();
      switch (ext) {
        case 'pdf':
          break;
        default:
          alert('This is not an allowed file type.');
          this.value = '';
      }
    }
  });






  //////////////////////////////////////////////////////////////

  $(document).on('click', '.complete_FNF', function() {

    var fnfid = $(this).attr("fnfid");
    $('.frmfnfFinalHR #fnfid').val(fnfid);
    $("#fnfFinalHRModel").modal('show');
  });

  $(document).on('click', '#fnfFinalHRSave', function() {

    var postURL = "<?php echo base_url(); ?>fnf/hr_final_status";

    var fnfid = $('.frmfnfFinalHR #fnfid').val();
    var final_comments = $('.frmfnfFinalHR #final_comments').val().trim();

    //alert(fnfid);
    //alert(final_comments);

    if (fnfid != "" && final_comments != "") {
      $('#sktPleaseWait').modal('show');
      $.ajax({
        type: 'GET',
        url: postURL,
        data: $('form.frmfnfFinalHR').serialize(),
        success: function(msg) {
          $('#sktPleaseWait').modal('hide');
          $('#fnfFinalHRModel').modal('hide');
          location.reload();
        }
      });
    } else {
      alert("One or More field's are blank");
    }
  });



  //==========================================================================================================	
  //  1. IT LOCAL TEAM 
  //==========================================================================================================

  $(document).on('click', '.editfnfITLocalTeam', function() {

    var extrapar = $(this).attr("extrapar");
    var pstatus = $(this).attr("pstatus");
    //alert(pstatus);

    fnfd = extrapar.split('#');
    $('.frmITLocalTeam #user_id').val(fnfd[0]);
    $('.frmITLocalTeam #fnf_id').val(fnfd[2]);
    $('.frmITLocalTeam #resign_id').val(fnfd[1]);

    // SECURITY REMARKS					
    var ftype = $(this).attr("ftype");
    $('.frmITLocalTeam #f_type').val(ftype);
    $('.securityRemarks').hide();
    $('.frmITLocalTeam textarea[name="security_remarks"]').removeAttr('required');
    $(".frmITLocalTeam :input").removeAttr("disabled", "disabled");
    $('.frmITLocalTeam textarea[name="security_remarks"]').removeAttr("disabled", "disabled");
    if (ftype == 2) {
      $(".frmITLocalTeam :input").prop("disabled", true);
      $('.frmITLocalTeam textarea[name="security_remarks"]').attr('required', 'required');
      $('.frmITLocalTeam textarea[name="security_remarks"]').removeAttr('disabled', 'disabled');
      $('.frmITLocalTeam input[name="user_id"]').removeAttr('disabled', 'disabled');
      $('.frmITLocalTeam input[name="fnf_id"]').removeAttr('disabled', 'disabled');
      $('.frmITLocalTeam input[name="resign_id"]').removeAttr('disabled', 'disabled');
      $('.frmITLocalTeam input[name="f_type"]').removeAttr('disabled', 'disabled');
      $('.frmITLocalTeam button[type="submit"]').removeAttr('disabled', 'disabled');
      $('.frmITLocalTeam button[type="button"]').removeAttr('disabled', 'disabled');
      $('.securityRemarks').show();
    }

    // GET FNF DETAILS
    baseURL = "<?php echo base_url(); ?>";
    $.ajax({
      type: 'POST',
      url: baseURL + 'fnf/fnf_details_ajax',
      data: "fnf_id=" + fnfd[2],
      dataType: "json",
      success: function(result) {
        $('.frmITLocalTeam input[name="return_computer_date"]').val(result.return_date_computer);
        $('.frmITLocalTeam input[name="return_computer_headset"]').val(result.return_date_headset);
        $('.frmITLocalTeam input[name="return_computer_tools"]').val(result.return_date_accessories);
        $('.frmITLocalTeam input[name="disable_dialer_id"]').val(result.disablement_date_dialer);
        $('.frmITLocalTeam input[name="disable_crm_id"]').val(result.disablement_date_crm);
        $('.frmITLocalTeam textarea[name="security_remarks"]').val(result.it_local_remarks);
        $('.frmITLocalTeam textarea[name="it_local_comments"]').val(result.it_local_comments);

        $('.frmITLocalTeam select[name="is_return_computer_date"]').val(result.is_return_date_computer);
        $('.frmITLocalTeam select[name="is_return_computer_headset"]').val(result.is_return_date_headset);
        $('.frmITLocalTeam select[name="is_return_computer_tools"]').val(result.is_return_date_accessories);
        $('.frmITLocalTeam select[name="is_disable_dialer_id"]').val(result.is_disablement_date_dialer);
        $('.frmITLocalTeam select[name="is_disable_crm_id"]').val(result.is_disablement_date_crm);

        requiredUpdationYesNo('.frmITLocalTeam');



        $('.imgView').hide();
        imgVal = result.return_date_computer_file;
        if (imgVal !== "" && imgVal !== null && imgVal !== undefined) {
          imgURL = baseURL + 'uploads/user_fnf/' + result.fusion_id + '/' + imgVal;
          imgViewSpan = "<a class='btn btn-success btn-xs' target='_blank' href='" + imgURL + "'><i class='fa fa-download'></i> " + imgVal + "</a>";
          $('input[name="return_computer_date_file"]').closest('div').children('span.imgView').html(imgViewSpan);
          $('input[name="return_computer_date_file"]').closest('div').children('span.imgView').show();
        }
        imgVal = result.disablement_date_crm_file;
        if (imgVal !== "" && imgVal !== null && imgVal !== undefined) {
          imgURL = baseURL + 'uploads/user_fnf/' + result.fusion_id + '/' + imgVal;
          imgViewSpan = "<a class='btn btn-success btn-xs' target='_blank' href='" + imgURL + "'><i class='fa fa-download'></i> " + imgVal + "</a>";
          $('input[name="disable_crm_id_file"]').closest('div').children('span.imgView').html(imgViewSpan);
          $('input[name="disable_crm_id_file"]').closest('div').children('span.imgView').show();
        }
        imgVal = result.disablement_date_dialer_file;
        if (imgVal !== "" && imgVal !== null && imgVal !== undefined) {
          imgURL = baseURL + 'uploads/user_fnf/' + result.fusion_id + '/' + imgVal;
          imgViewSpan = "<a class='btn btn-success btn-xs' target='_blank' href='" + imgURL + "'><i class='fa fa-download'></i> " + imgVal + "</a>";
          $('input[name="disable_dialer_id_file"]').closest('div').children('span.imgView').html(imgViewSpan);
          $('input[name="disable_dialer_id_file"]').closest('div').children('span.imgView').show();
        }

        $("#fnfITLocalTeam").modal('show');
      }



    });


    // GET IT Assets DETAILS
    var datas = {
      'user_id': fnfd[0]
    };
    var request_url = "<?php echo base_url('fnf/get_assest_assignment_details'); ?>";
    process_ajax(function(response) {
      var res = JSON.parse(response);
      if (res.stat == true) {
        if (res.active_ast == true) {
          var assets_details = "";
          var fnf_it_doc = "";

          $.each(res.datas_active, function(index, element) {
            if (element.fnf_it_local_status != '1') {
              assets_details += '<tr><td>' + element.user_name + '</td><td>' + element.assets_name + '</td><td>' + element.serial_number + '</td><td>' + element.model_number + '</td><td>' + element.raised_date + '</td><td><input class="form-control" type="date" name="it_local_release_date[]" value="<?= date("Y-m-d") ?>" required></td><td><input class="form-control file_validation" type="file" name="it_local_doc_file[]" required></td><td><input class="form-control" type="text" name="fnf_it_local_comment[]" required></td><td><input style="width: 18px;margin-left: 13px;" class="form-control" type="checkbox" name="it_local_is_release[]" value="' + element.id + '" required></td></tr>';
            } else {

              if (element.fnf_it_doc != null) fnf_it_doc = '<a href="<?= base_url() ?>it_assets_import/fnf_doc/' + element.fnf_it_doc + '" target="_blank">View</a>';
              else fnf_it_doc = 'No Document Found';

              assets_details += '<tr><td>' + element.user_name + '</td><td>' + element.assets_name + '</td><td>' + element.serial_number + '</td><td>' + element.model_number + '</td><td>' + element.raised_date + '</td><td>' + element.fnf_it_local_return_date + '</td><td>' + fnf_it_doc + '</td><td>' + element.fnf_it_local_comment + '</td><td>Completed</td></tr>';

            }

          });

          $('#assets_maintanance_div #it_local_user_assets_details').html(assets_details);
          $('#assets_maintanance_div #it_local_com_fnf').val(fnfd[2]);

          if (pstatus == 'C') {
            $('#assets_maintanance_div #it_local_com_fnf').hide();
            //$('#assets_maintanance_div #assets_fnf_submit_btn').attr('disabled',false);
          } else {
            $('#assets_maintanance_div #it_local_com_fnf').show();
            $('#assets_maintanance_div #it_local_com_fnf').val(fnfd[2]);
            //$('#assets_maintanance_div #assets_fnf_submit_btn').removeAttr('disabled');		
          }

        } else {
          $('#assets_maintanance_div #it_local_user_assets_details').html('');

          if (pstatus == 'C') {
            $('#assets_maintanance_div #it_local_com_fnf').hide();
            //$('#assets_maintanance_div #assets_fnf_submit_btn').attr('disabled',true);
          } else {
            $('#assets_maintanance_div #it_local_com_fnf').show();
            $('#assets_maintanance_div #it_local_com_fnf').val(fnfd[2]);
            //$('#assets_maintanance_div #assets_fnf_submit_btn').removeAttr('disabled');					
          }
        }
        if (res.release_ast == true) {
          var assets_details_release = "";
          var fnf_doc = "";
          $.each(res.datas_release, function(index, element) {
            if (element.fnf_doc != null) fnf_doc = '<a href="<?= base_url() ?>it_assets_import/fnf_doc/' + element.fnf_doc + '" target="_blank">View</a>';
            else fnf_doc = 'No Document Found';

            assets_details_release += '<tr><td>' + element.user_name + '</td><td>' + element.assets_name + '</td><td>' + element.serial_number + '</td><td>' + element.model_number + '</td><td>' + element.raised_date + '</td><td>' + element.return_date + '</td><td>' + fnf_doc + '</td><td>' + element.return_by_name + '</td></tr>';
          });
          $('#assets_maintanance_div #it_local_user_assets_details_returned').html(assets_details_release);
        } else {
          $('#assets_maintanance_div #it_local_user_assets_details_returned').html('');
        }
      } else {
        alert(res.errmsg);
      }

    }, request_url, datas, 'text');


    if (pstatus == "C") {
      $('#fnfITLocalSave').attr("disabled", true);
    } else {
      $('#fnfITLocalSave').attr("disabled", false);
    }

    $('#fnfITLocalTeam').modal('show');
  });


  //////////////////////////////
  $(document).on('click', '.editfnfHoldTeam', function() {

    var extrapar = $(this).attr("extrapar");
    fnfd = extrapar.split('#');
    $('.frmITHoldTeam #user_id').val(fnfd[0]);
    $('.frmITHoldTeam #fnf_id').val(fnfd[2]);
    $('.frmITHoldTeam #resign_id').val(fnfd[1]);

    // GET FNF DETAILS
    baseURL = "<?php echo base_url(); ?>";
    $.ajax({
      type: 'POST',
      url: baseURL + 'fnf/fnf_details_ajax',
      data: "fnf_id=" + fnfd[2],
      dataType: "json",
      success: function(result) {
        holdVal = result.is_hold;
        showVal = 0;
        if (holdVal == 0) {
          showVal = 1;
        }
        $('.frmITHoldTeam select[name="it_hold_status"]').val(showVal);
        $('.frmITHoldTeam select[name="it_hold_status"]').attr("style", "pointer-events: none;");
        $("#fnfITHoldModalTeam").modal('show');
      }
    });
  });



  //==========================================================================================================	
  //  2. IT NETWORK TEAM 
  //==========================================================================================================

  $(document).on('click', '.editfnfITNetworkTeam', function() {


    var extrapar = $(this).attr("extrapar");
    fnfd = extrapar.split('#');
    $('.frmITNetworkTeam #user_id').val(fnfd[0]);
    $('.frmITNetworkTeam #fnf_id').val(fnfd[2]);
    $('.frmITNetworkTeam #resign_id').val(fnfd[1]);

    // SECURITY REMARKS					
    var ftype = $(this).attr("ftype");
    $('.frmITNetworkTeam #f_type').val(ftype);
    $('.securityRemarks').hide();
    $('.frmITNetworkTeam textarea[name="security_remarks"]').removeAttr('required');
    $(".frmITNetworkTeam :input").removeAttr("disabled", "disabled");
    if (ftype == 2) {
      $(".frmITNetworkTeam :input").prop("disabled", true);
      $('.frmITNetworkTeam textarea[name="security_remarks"]').attr('required', 'required');
      $('.frmITNetworkTeam textarea[name="security_remarks"]').removeAttr('disabled', 'disabled');
      $('.frmITNetworkTeam input[name="user_id"]').removeAttr('disabled', 'disabled');
      $('.frmITNetworkTeam input[name="fnf_id"]').removeAttr('disabled', 'disabled');
      $('.frmITNetworkTeam input[name="f_type"]').removeAttr('disabled', 'disabled');
      $('.frmITNetworkTeam input[name="resign_id"]').removeAttr('disabled', 'disabled');
      $('.frmITNetworkTeam button[type="submit"]').removeAttr('disabled', 'disabled');
      $('.frmITNetworkTeam button[type="button"]').removeAttr('disabled', 'disabled');
      $('.securityRemarks').show();
    }

    // GET FNF DETAILS
    baseURL = "<?php echo base_url(); ?>";
    $.ajax({
      type: 'POST',
      url: baseURL + 'fnf/fnf_details_ajax',
      data: "fnf_id=" + fnfd[2],
      dataType: "json",
      success: function(result) {
        $('.frmITNetworkTeam input[name="disablement_date_vpn"]').val(result.disablement_date_vpn);
        $('.frmITNetworkTeam input[name="disablement_date_firewall"]').val(result.disablement_date_firewall);
        $('.frmITNetworkTeam textarea[name="security_remarks"]').val(result.it_network_remarks);

        $('.frmITNetworkTeam select[name="is_disablement_date_vpn"]').val(result.is_disablement_date_vpn);
        $('.frmITNetworkTeam select[name="is_disablement_date_firewall"]').val(result.is_disablement_date_firewall);

        requiredUpdationYesNo('.frmITNetworkTeam');

        $('.imgView').hide();
        imgVal = result.disablement_date_firewall_file;
        if (imgVal !== "" && imgVal !== null && imgVal !== undefined) {
          imgURL = baseURL + 'uploads/user_fnf/' + result.fusion_id + '/' + imgVal;
          imgViewSpan = "<a class='btn btn-success btn-xs' target='_blank' href='" + imgURL + "'><i class='fa fa-download'></i> " + imgVal + "</a>";
          $('input[name="disablement_date_firewall_file"]').closest('div').children('span.imgView').html(imgViewSpan);
          $('input[name="disablement_date_firewall_file"]').closest('div').children('span.imgView').show();
        }

        $("#fnfITNetworkTeam").modal('show');
      }
    });
  });


  //==========================================================================================================	
  //  3. IT GLOBAL HELPDESK
  //==========================================================================================================

  $(document).on('click', '.editfnfITGlobalHelpdeskTeam', function() {


    var extrapar = $(this).attr("extrapar");
    fnfd = extrapar.split('#');
    $('.frmITGlobalHelpdeskTeam #user_id').val(fnfd[0]);
    $('.frmITGlobalHelpdeskTeam #fnf_id').val(fnfd[2]);
    $('.frmITGlobalHelpdeskTeam #resign_id').val(fnfd[1]);


    // SECURITY REMARKS					
    var ftype = $(this).attr("ftype");
    $('.frmITGlobalHelpdeskTeam #f_type').val(ftype);
    $('.securityRemarks').hide();
    $('.frmITGlobalHelpdeskTeam textarea[name="security_remarks"]').removeAttr('required');
    $(".frmITGlobalHelpdeskTeam :input").removeAttr("disabled", "disabled");
    if (ftype == 2) {
      $(".frmITGlobalHelpdeskTeam :input").prop("disabled", true);
      $('.frmITGlobalHelpdeskTeam textarea[name="security_remarks"]').attr('required', 'required');
      $('.frmITGlobalHelpdeskTeam textarea[name="security_remarks"]').removeAttr('disabled', 'disabled');
      $('.frmITGlobalHelpdeskTeam input[name="user_id"]').removeAttr('disabled', 'disabled');
      $('.frmITGlobalHelpdeskTeam input[name="fnf_id"]').removeAttr('disabled', 'disabled');
      $('.frmITGlobalHelpdeskTeam input[name="f_type"]').removeAttr('disabled', 'disabled');
      $('.frmITGlobalHelpdeskTeam input[name="resign_id"]').removeAttr('disabled', 'disabled');
      $('.frmITGlobalHelpdeskTeam button[type="submit"]').removeAttr('disabled', 'disabled');
      $('.frmITGlobalHelpdeskTeam button[type="button"]').removeAttr('disabled', 'disabled');
      $('.securityRemarks').show();
    }

    // GET FNF DETAILS
    baseURL = "<?php echo base_url(); ?>";
    $.ajax({
      type: 'POST',
      url: baseURL + 'fnf/fnf_details_ajax',
      data: "fnf_id=" + fnfd[2],
      dataType: "json",
      success: function(result) {

        $('.frmITGlobalHelpdeskTeam input[name="disablement_date_domain"]').val(result.disablement_date_domain);
        $('.frmITGlobalHelpdeskTeam input[name="disablement_date_email"]').val(result.disablement_date_email);
        $('.frmITGlobalHelpdeskTeam input[name="disablement_date_ticket"]').val(result.disablement_date_ticket);
        $('.frmITGlobalHelpdeskTeam textarea[name="security_remarks"]').val(result.it_global_helpdesk_remarks);

        $('.frmITGlobalHelpdeskTeam select[name="is_disablement_date_domain"]').val(result.is_disablement_date_domain);
        $('.frmITGlobalHelpdeskTeam select[name="is_disablement_date_email"]').val(result.is_disablement_date_email);
        $('.frmITGlobalHelpdeskTeam select[name="is_disablement_date_ticket"]').val(result.is_disablement_date_ticket);

        requiredUpdationYesNo('.frmITGlobalHelpdeskTeam');

        $('.imgView').hide();
        imgVal = result.disablement_date_domain_file;
        if (imgVal !== "" && imgVal !== null && imgVal !== undefined) {
          imgURL = baseURL + 'uploads/user_fnf/' + result.fusion_id + '/' + imgVal;
          imgViewSpan = "<a class='btn btn-success btn-xs' target='_blank' href='" + imgURL + "'><i class='fa fa-download'></i> " + imgVal + "</a>";
          $('input[name="disablement_date_domain_file"]').closest('div').children('span.imgView').html(imgViewSpan);
          $('input[name="disablement_date_domain_file"]').closest('div').children('span.imgView').show();
        }
        imgVal = result.disablement_date_email_file;
        if (imgVal !== "" && imgVal !== null && imgVal !== undefined) {
          imgURL = baseURL + 'uploads/user_fnf/' + result.fusion_id + '/' + imgVal;
          imgViewSpan = "<a class='btn btn-success btn-xs' target='_blank' href='" + imgURL + "'><i class='fa fa-download'></i> " + imgVal + "</a>";
          $('input[name="disablement_date_email_file"]').closest('div').children('span.imgView').html(imgViewSpan);
          $('input[name="disablement_date_email_file"]').closest('div').children('span.imgView').show();
        }
        imgVal = result.disablement_date_ticket_file;
        if (imgVal !== "" && imgVal !== null && imgVal !== undefined) {
          imgURL = baseURL + 'uploads/user_fnf/' + result.fusion_id + '/' + imgVal;
          imgViewSpan = "<a class='btn btn-success btn-xs' target='_blank' href='" + imgURL + "'><i class='fa fa-download'></i> " + imgVal + "</a>";
          $('input[name="disablement_date_ticket_file"]').closest('div').children('span.imgView').html(imgViewSpan);
          $('input[name="disablement_date_ticket_file"]').closest('div').children('span.imgView').show();
        }
        $("#fnfITGlobalHelpdeskTeam").modal('show');
      }
    });
  });

  $(document).on('click', '.procrument_fnf_save', function() {
    var params = $(this).attr("extrapar");
    var pstatus = $(this).attr("pstatus");

    var arrPrams = params.split("#");

    var datas = {
      'user_id': arrPrams[0]
    };
    var fnf_id = arrPrams[2];

    var hrcomment = $(this).attr("hrcomment");
    $('#procurement_fnf_model #hr_acc_comment').text(hrcomment);

    var request_url = "<?php echo base_url('fnf/get_assest_assignment_details'); ?>";
    process_ajax(function(response) {
      var res = JSON.parse(response);
      if (res.stat == true) {
        if (res.active_ast == true) {
          var assets_details = "";
          var fnf_it_doc = "";
          var it_local_return_date = "";
          var fnf_it_local_comment = "";
          $.each(res.datas_active, function(index, element) {
            if (element.fnf_it_doc != null) fnf_it_doc = '<a href="<?= base_url() ?>it_assets_import/fnf_doc/' + element.fnf_it_doc + '" target="_blank">View</a>';
            else fnf_it_doc = 'No Document Found';

            if (element.fnf_it_local_return_date == null) {
              it_local_return_date = '-';
            } else {
              it_local_return_date = element.fnf_it_local_return_date;
            }

            if (element.fnf_it_local_comment == null) {
              fnf_it_local_comment = '-';
            } else {
              fnf_it_local_comment = element.fnf_it_local_comment;
            }

            assets_details += '<tr><td>' + element.user_name + '</td><td>' + element.assets_name + '</td><td>' + element.serial_number + '</td><td>' + element.model_number + '</td><td>' + element.raised_date + '</td><td>' + it_local_return_date + '</td><td>' + fnf_it_doc + '</td><td>' + fnf_it_local_comment + '</td><td><input class="form-control" type="date" name="release_date[]" value="<?= date("Y-m-d") ?>" required></td><td><input class="form-control file_validation" type="file" name="doc_file[]" required></td><td><input class="form-control" type="text" name="fnf_return_comment[]" required></td><td><input style="width: 18px;margin-left: 13px;" class="form-control" type="checkbox" name="is_release[]" value="' + element.id + '" required></td></tr>';
          });

          $('#procurement_fnf_model #user_assets_details').html(assets_details);
          $('#procurement_fnf_model #com_fnf').val(fnf_id);

          if (pstatus == 1) {
            $('#procurement_fnf_model #com_fnf').hide();
            $('#procurement_fnf_model #assets_fnf_submit_btn').attr('disabled', false);
          } else {
            $('#procurement_fnf_model #com_fnf').show();
            $('#procurement_fnf_model #com_fnf').val(fnf_id);
            $('#procurement_fnf_model #assets_fnf_submit_btn').removeAttr('disabled');
          }

        } else {
          $('#procurement_fnf_model #user_assets_details').html(' ');

          if (pstatus == 1) {
            $('#procurement_fnf_model #com_fnf').hide();
            $('#procurement_fnf_model #assets_fnf_submit_btn').attr('disabled', true);
          } else {
            $('#procurement_fnf_model #com_fnf').show();
            $('#procurement_fnf_model #com_fnf').val(fnf_id);
            $('#procurement_fnf_model #assets_fnf_submit_btn').removeAttr('disabled');
          }
        }
        if (res.release_ast == true) {
          var assets_details_release = "";
          var fnf_doc = "";
          var fnf_it_doc = "";
          var it_local_return_date = '';
          var fnf_it_local_comment = '';
          var fnf_return_comment = '';
          $.each(res.datas_release, function(index, element) {
            if (element.fnf_doc != null) fnf_doc = '<a href="<?= base_url() ?>it_assets_import/fnf_doc/' + element.fnf_doc + '" target="_blank">View</a>';
            else fnf_doc = 'No Document Found';

            if (element.fnf_it_doc != null) fnf_it_doc = '<a href="<?= base_url() ?>it_assets_import/fnf_doc/' + element.fnf_it_doc + '" target="_blank">View</a>';
            else fnf_it_doc = 'No Document Found';

            if (element.fnf_it_local_return_date == null) {
              it_local_return_date = '-';
            } else {
              it_local_return_date = element.fnf_it_local_return_date;
            }

            if (element.fnf_it_local_comment == null) {
              fnf_it_local_comment = '-';
            } else {
              fnf_it_local_comment = element.fnf_it_local_comment;
            }

            if (element.fnf_return_comment == null) {
              fnf_return_comment = '-';
            } else {
              fnf_return_comment = element.fnf_return_comment;
            }

            assets_details_release += '<tr><td>' + element.user_name + '</td><td>' + element.assets_name + '</td><td>' + element.serial_number + '</td><td>' + element.model_number + '</td><td>' + element.raised_date + '</td><td>' + it_local_return_date + '</td><td>' + fnf_it_doc + '</td><td>' + fnf_it_local_comment + '</td><td>' + element.return_date + '</td><td>' + fnf_doc + '</td><td>' + fnf_return_comment + '</td><td>' + element.return_by_name + '</td></tr>';
          });
          $('#procurement_fnf_model #user_assets_details_returned').html(assets_details_release);
        } else {
          $('#procurement_fnf_model #user_assets_details_returned').html('');
        }
      } else {
        alert(res.errmsg);
      }
    }, request_url, datas, 'text');



    $('#procurement_fnf_model').modal('show');

    // var req_id=$(this).attr("value");
    // var req_number=$(this).attr("r_id");
    // var req_assets=$(this).attr("assets_name");
    // var req_total=$(this).attr("request_total");
    // var assets_id=$(this).attr("assets_id");
    // var location_name=$(this).attr("location_name");
    // $('#myModal_assets_movement_history_details #req_location').text(location_name);
    // $('#myModal_assets_movement_history_details .assets_name_hod').text(req_assets);
    // $('#myModal_assets_movement_history_details #req_id_hod').text(req_number);
    // var datas = {'req_id': req_id};
    // var request_url = "<?php echo base_url('dfr_it_assets/get_assets_movement_history'); ?>";
    // process_ajax(function(response)
    // {
    // 	var res = JSON.parse(response);
    // 	if (res.stat == true) {
    // 		var tr_details = ''; var c=1;
    // 		$.each(res.datas,function(index,element)
    // 		{
    // 			tr_details += '<tr><td>'+c+'</td><td>'+element.serial_number+'</td><td>'+element.reference_id+'</td><td>'+element.brand_name+'</td><td>'+element.configuration+'</td><td>'+element.model_number+'</td><td>'+element.raised_date+'</td></tr>';
    // 			c++;
    // 		});
    // 		$('#myModal_assets_movement_history_details #move_assets_history_tr').html(tr_details);
    // 	}
    // 	else {
    // 		alert('Something is wrong');
    // 	}
    // },request_url, datas, 'text');

  });



  $(document).on('click', '.acceptance_fnf_save', function() {
    var params = $(this).attr("extrapar");
    var pstatus = $(this).attr("pstatus");
    var hrcomment = $(this).attr("hrcomment");
    $('#acceptance_fnf_model #hr_acceptance_comment').text(hrcomment);

    var arrPrams = params.split("#");

    var datas = {
      'user_id': arrPrams[0]
    };
    var fnf_id = arrPrams[2];

    var request_url = "<?php echo base_url('fnf/get_assest_assignment_details'); ?>";
    process_ajax(function(response) {
      var res = JSON.parse(response);
      if (res.stat == true) {
        if (res.active_ast == true) {
          var assets_details = "";
          var fnf_it_doc = "";
          var it_local_return_date = '';
          var fnf_return_comment = '';
          var fnf_it_local_comment = '';

          $.each(res.datas_active, function(index, element) {

            if (element.fnf_it_doc != null) fnf_it_doc = '<a href="<?= base_url() ?>it_assets_import/fnf_doc/' + element.fnf_it_doc + '" target="_blank">View</a>';
            else fnf_it_doc = 'No Document Found';

            if (element.fnf_it_local_return_date == null) {
              it_local_return_date = '-';
            } else {
              it_local_return_date = element.fnf_it_local_return_date;
            }

            if (element.fnf_return_comment == null) {
              fnf_return_comment = '-';
            } else {
              fnf_return_comment = element.fnf_return_comment;
            }

            if (element.fnf_it_local_comment == null) {
              fnf_it_local_comment = '-';
            } else {
              fnf_it_local_comment = element.fnf_it_local_comment;
            }
            //alert(element.fnf_hr_status);
            if (element.fnf_hr_status != '1') {
              assets_details += '<tr><td>' + element.user_name + '</td><td>' + element.assets_name + '</td><td>' + element.serial_number + '</td><td>' + element.model_number + '</td><td>' + element.raised_date + '</td><td>' + it_local_return_date + '</td><td>' + fnf_it_doc + '</td><td>' + fnf_it_local_comment + '</td><td>' + fnf_return_comment + '</td><td><input class="form-control" type="date" name="hr_acceptance_date[]" value="<?= date("Y-m-d") ?>" required></td><td><input style="width: 18px;margin-left: 13px;" class="form-control" type="checkbox" name="is_hr_acceptance[]" value="' + element.id + '" required></td></tr>';
            } else {
              assets_details += '<tr><td>' + element.user_name + '</td><td>' + element.assets_name + '</td><td>' + element.serial_number + '</td><td>' + element.model_number + '</td><td>' + element.raised_date + '</td><td>' + it_local_return_date + '</td><td>' + fnf_it_doc + '</td><td>' + fnf_it_local_comment + '</td><td>' + element.fnf_hr + '</td><td>' + fnf_return_comment + '</td><td>Completed</td></tr>';
            }

          });

          $('#acceptance_fnf_model #user_assets_details').html(assets_details);
          $('#acceptance_fnf_model #hr_acceptance_com_fnf').val(fnf_id);

          if (pstatus == 1) {
            $('#acceptance_fnf_model #hr_acceptance_com_fnf').hide();
            $('#acceptance_fnf_model #acceptance_fnf_submit_btn').attr('disabled', 'disabled');
            $('#acceptance_fnf_model #hr_acceptance_comment').attr('disabled', 'disabled');
          } else {
            $('#acceptance_fnf_model #hr_acceptance_com_fnf').show();
            $('#acceptance_fnf_model #hr_acceptance_com_fnf').val(fnf_id);
            $('#acceptance_fnf_model #acceptance_fnf_submit_btn').removeAttr('disabled');
            $('#acceptance_fnf_model #hr_acceptance_comment').removeAttr('disabled');
          }

        } else {
          $('#acceptance_fnf_model #user_assets_details').html('');

          if (pstatus == 1) {
            $('#acceptance_fnf_model #hr_acceptance_com_fnf').hide();
            $('#acceptance_fnf_model #acceptance_fnf_submit_btn').attr('disabled', 'disabled');
            $('#acceptance_fnf_model #hr_acceptance_comment').attr('disabled', 'disabled');
          } else {
            $('#acceptance_fnf_model #hr_acceptance_com_fnf').show();
            $('#acceptance_fnf_model #hr_acceptance_com_fnf').val(fnf_id);
            $('#acceptance_fnf_model #acceptance_fnf_submit_btn').removeAttr('disabled');
            $('#acceptance_fnf_model #hr_acceptance_comment').removeAttr('disabled');
          }
        }

        if (res.release_ast == true) {
          var assets_details_release = "";
          var fnf_doc = "";
          var fnf_it_doc = "";
          var it_local_return_date = '';
          var fnf_it_local_comment = '';
          var fnf_return_comment = '';

          $.each(res.datas_release, function(index, element) {
            if (element.fnf_doc != null) fnf_doc = '<a href="<?= base_url() ?>it_assets_import/fnf_doc/' + element.fnf_doc + '" target="_blank">View</a>';
            else fnf_doc = 'No Document Found';

            if (element.fnf_it_doc != null) fnf_it_doc = '<a href="<?= base_url() ?>it_assets_import/fnf_doc/' + element.fnf_it_doc + '" target="_blank">View</a>';
            else fnf_it_doc = 'No Document Found';

            if (element.fnf_it_local_return_date == null) {
              it_local_return_date = '-';
            } else {
              it_local_return_date = element.fnf_it_local_return_date;
            }

            if (element.fnf_it_local_comment == null) {
              fnf_it_local_comment = '-';
            } else {
              fnf_it_local_comment = element.fnf_it_local_comment;
            }

            if (element.fnf_return_comment == null) {
              fnf_return_comment = '-';
            } else {
              fnf_return_comment = element.fnf_return_comment;
            }



            assets_details_release += '<tr><td>' + element.user_name + '</td><td>' + element.assets_name + '</td><td>' + element.serial_number + '</td><td>' + element.model_number + '</td><td>' + element.raised_date + '</td><td>' + it_local_return_date + '</td><td>' + fnf_it_doc + '</td><td>' + fnf_it_local_comment + '</td><td>' + element.return_date + '</td><td>' + fnf_doc + '</td><td>' + fnf_return_comment + '</td><td>' + element.return_by_name + '</td></tr>';
          });
          $('#acceptance_fnf_model #user_assets_details_returned').html(assets_details_release);
        } else {
          $('#acceptance_fnf_model #user_assets_details_returned').html('');
        }
      } else {
        alert(res.errmsg);
      }
    }, request_url, datas, 'text');
    $('#acceptance_fnf_model').modal('show');

  });

  $(document).ready(function() {

    $(".check_all").on("click", function() {
      $('input:checkbox').not(this).prop('checked', this.checked);
    });



    $('.send_mails').on("click", function() {
      // alert('hit');

      var baseURL = "<?php echo base_url(); ?>";
      var cnt = 0;

      $(':checkbox:checked').each(function(i, e) {

        var fnfid = $(e).attr('value');
        $.get(baseURL + "fnf/send_release_letter/" + fnfid + "/Y");
        cnt++;

      });

      if (cnt > 0) alert('Send');
      else alert('Select checkbox');

    });

  });

  // CHECK ALL FNF COMPLETION

  $(document).on('click', '.check_complete_fnf', function() {

    baseURL = "<?php echo base_url(); ?>";
    $('#sktPleaseWait').modal('show');
    fnfCompleteIDs = $("input[name='fnfAllHRCheck']").val();
    fnfOfficeID = $("select[name='office_id']").val();
    $.ajax({
      type: 'GET',
      url: baseURL + 'fnf/bulk_fnf_hr',
      data: {
        "fnfID": fnfCompleteIDs,
        "office_id": fnfOfficeID
      },
      success: function(msg) {
        $('#sktPleaseWait').modal('hide');
        $('#fnfFinalHRModelBulk .modal-body').html(msg);
        $('#fnfFinalHRModelBulk').modal('show');
      },
      error: function(msg) {
        $('#sktPleaseWait').modal('hide');
      }
    });

  });

  location_reset = () => {
    // alert('11');
    $("#foffice_id").val("");
  }
</script>