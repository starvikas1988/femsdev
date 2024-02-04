<link href="<?php echo base_url() ?>assets/css/search-filter/css/custom.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap.min.css" rel="stylesheet">
<script src="<?php echo base_url() ?>assets/css/search-filter/js/jquery.dataTables.min.js"></script>
<link href="<?= base_url() ?>assets/css/search-filter/assets/css/simple-datatables-latest.css" rel="stylesheet" />
<style>
  .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
    top: -6px;
  }

  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
  }

  input:checked+.slider {
    background-color: #2196F3;
  }

  input:focus+.slider {
    box-shadow: 0 0 1px #2196F3;
  }

  input:checked+.slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
  }

  /* Rounded sliders */
  .slider.round {
    border-radius: 34px;
  }

  .slider.round:before {
    border-radius: 50%;
  }
</style>

<div class="wrap">
  <section class="app-content">
    <div class="white_widget padding_3">
      <div class="body_widget">
        <div class="row d_flex">
          <div class="col-sm-6">
            <h2 class="avail_title_heading">Vendor List</h2>
          </div>
          <div class="col-sm-6">
            <div class="right_side">
              <button type="button" class="btn btn_padding filter_btn" data-toggle="modal" data-target="#myModal">Add Vendor</button>
            </div>
          </div>
        </div>
        <hr class="sepration_border">
      </div>
      <div class="body_widget">
        <div class="table_scroll_new leave_table table-parent common_table_widget margin_3 manual_export_widget">
          <table id="datatablesSimple" class="table table-bordered table-responsive table-striped">
            <thead>
              <th class="table_width_sr">SL. No.</th>
              <th class="table_width1">Company Name</th>
              <th class="employee_adrs">Company address</th>
              <th class="table_width1">Location</th>
              <th class="employee_td">Company Registration No</th>
              <th class="table_width">GSTI No.</th>
              <th class="table_width1">Contact Name</th>
              <th class="employee_td">Primary Email address</th>
              <th class="employee_td">Secondary Email address</th>
              <th class="employee_td">Primary Phone No</th>
              <th class="employee_td">Secondary Phone No</th>
              <th class="table_width1">Website</th>
              <th class="employee_td">Company Description</th>
              <th class="table_width">Status</th>
              <th class="table_width leave_columns_fixed">Action</th>
            </thead>
            <tbody>
              <?php
              $c = 1;
              foreach ($vendor_list as $key => $value) {
              ?>
                <tr>
                  <td><?= $c ?></td>
                  <td><?= $value['vnd_name'] ?></td>
                  <td><?= $value['vnd_details'] ?></td>
                  <td><?= $value['vnd_location'] ?></td>
                  <td><?= $value['vnd_reg_no'] ?></td>
                  <td><?= $value['vnd_gst_no'] ?></td>
                  <td><?= $value['vnd_contact_name'] ?></td>
                  <td><?= $value['vnd_email'] ?></td>
                  <td><?= $value['vnd_secondary_email'] ?></td>
                  <td><?= $value['vnd_phone'] ?></td>
                  <td><?= $value['vnd_secondary_ph'] ?></td>
                  <td><?= $value['vnd_web_site'] ?></td>
                  <td><?= $value['vnd_com_description'] ?></td>
                  <td><?php
                      $_status = $value['is_active'];
                      if ($_status == 1) echo '<span class="">Active</span>';
                      else echo '<span class="">Deactive</span>';
                      $param = $value['vnd_name'] . "~#~" . $value['vnd_details'] . "~#~" . $value['vnd_reg_no'] . "~#~" . $value['vnd_contact_name'] . "~#~" . $value['vnd_email'] . "~#~" . $value['vnd_phone'] . "~#~" . $value['vnd_web_site'] . "~#~" . $value['vnd_com_description'] . "~#~" . $value['vnd_secondary_ph'] . "~#~" . $value['vnd_secondary_email'] . "~#~" . $value['vnd_location'] . "~#~" . $value['vnd_gst_no'];
                      ?></td>
                  <td class="edit_assets leave_columns_fixed action_column_right">
                    <a class="btn no_padding edit_assets_vendor" assets_details="<?= $param ?>" value="<?= $value['id'] ?>" style="cursor: pointer" title="Edit">
                      <img src="<?php echo base_url(); ?>assets_home_v3/images/edit_icon.svg" alt="">
                    </a>
                    <?php if ($_status == 1) : ?>
                      <a href="<?= base_url() ?>dfr_it_assets/add_vendor/disable/<?= $value['id'] ?>" class="btn btn no_padding btn_left" title="Deactive" onclick="return confirm('Make sure, Are you Deactive it?');"><img src="<?php echo base_url(); ?>assets_home_v3/images/deactive_user.svg" alt=""></a>
                    <?php else : ?>
                      <a href="<?= base_url() ?>dfr_it_assets/add_vendor/enable/<?= $value['id'] ?>" class="btn btn no_padding btn_left" title="Active" onclick="return confirm('Make sure, Are you Active it?');"><img src="<?php echo base_url(); ?>assets_home_v3/images/active_user.svg" alt=""></a>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php $c++;
              } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- Modal Add -->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close close_new" data-dismiss="modal"></button>
        <h4 class="modal-title">Add Vendors & Details</h4>
      </div>
      <form action="<?= base_url() ?>dfr_it_assets/add_vendor/add" method="POST">
        <div class="modal-body">
          <div class="filter-widget">
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Company Name <span class="red_bg">*</span></label>
                  <input type="text" oninput="this.value = this.value.toUpperCase()" minlength="3" maxlength="100" required name="vnd_name" class="form-control" placeholder="Enter Company Name">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Company Address <span class="red_bg">*</span></label>
                  <input type="text" oninput="this.value = this.value.toUpperCase()" minlength="3" maxlength="300" required name="vnd_details" class="form-control" placeholder="Enter Address">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Company Location <span class="red_bg">*</span> </label>
                  <input type="text" oninput="this.value = this.value.toUpperCase()" minlength="3" maxlength="100" required name="vnd_location" class="form-control" placeholder="Enter Location">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Company Registration No <span class="red_bg">*</span></label>
                  <input type="text" minlength="3" maxlength="200" required name="vnd_reg_no" class="form-control" placeholder="Enter Company Registration No">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Company GSTI No.</label>
                  <input type="text" minlength="3" maxlength="200" name="vnd_gst_no" class="form-control" placeholder="Enter Company GSTI No">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Contact Name <span class="red_bg">*</span> </label>
                  <input type="text" oninput="this.value = this.value.toUpperCase()" minlength="3" maxlength="100" required name="vnd_contact_name" class="form-control" placeholder="Enter Contact Name">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Primary Email Address <span class="red_bg">*</span> </label>
                  <input type="email" required name="vnd_email" class="form-control" placeholder="Enter Primary Email address">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Secondary Email Address </label>
                  <input type="email" name="vnd_secondary_email" class="form-control" placeholder="Enter Secondary Email address">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Primary Phone No <span class="red_bg">*</span></label>
                  <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" pattern="\d*" minlength="10" maxlength="13" required name="vnd_phone" class="form-control" placeholder="Enter Primary Phone No">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Secondary Phone No </label>
                  <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" pattern="\d*" minlength="10" maxlength="13" name="vnd_secondary_ph" class="form-control" placeholder="Enter Secondary Phone No">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Website <span class="red_bg">*</span></label>
                  <input type="url" required name="vnd_web_site" class="form-control" placeholder="Enter Website">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Company Description <span class="red_bg">*</span></label>
                  <input type="text" oninput="this.value = this.value.toUpperCase()" minlength="3" maxlength="500" required name="vnd_com_description" class="form-control" placeholder="Enter Company Description">
                </div>
              </div>

            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn_padding filter_btn_blue save_common_btn">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!--Category Update Model-->
<div class="modal fade in" id="update_assets_vendor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <form id="chnage_assets_vandor" action="" data-toggle="validator" method="POST" novalidate="true">
        <div class="modal-header">
          <button type="button" class="close close_new" data-dismiss="modal" aria-label="Close"></button>
          <h4 class="modal-title" id="myModalLabel">Edit Vendor Details (<spna class="rename"></spna>)</h4>
        </div>
        <div class="modal-body">
          <div class="filter-widget">
            <div class="row">

            </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Company Name <span class="red_bg">*</span> </label>
                  <input type="text" oninput="this.value = this.value.toUpperCase()" minlength="3" maxlength="100" required name="vnd_name" class="form-control" placeholder="Enter Company Name">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Company Address <span class="red_bg">*</span></label>
                  <input type="text" oninput="this.value = this.value.toUpperCase()" minlength="3" maxlength="300" required name="vnd_details" class="form-control" placeholder="Enter Address">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Company Location <span class="red_bg">*</span> </label>
                  <input type="text" oninput="this.value = this.value.toUpperCase()" minlength="3" maxlength="100" required name="vnd_location" class="form-control" placeholder="Enter Location">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Company Registration No <span class="red_bg">*</span></label>
                  <input type="text" minlength="3" maxlength="200" required name="vnd_reg_no" class="form-control" placeholder="Enter Company Registration No">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Company GSTI No.</label>
                  <input type="text" minlength="3" maxlength="200" name="vnd_gst_no" class="form-control" placeholder="Enter Company GSTI No">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Contact Name <span class="red_bg">*</span> </label>
                  <input type="text" oninput="this.value = this.value.toUpperCase()" minlength="3" maxlength="100" required name="vnd_contact_name" class="form-control" placeholder="Enter Contact Name">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Primary Email Address <span class="red_bg">*</span> </label>
                  <input type="email" required name="vnd_email" class="form-control" placeholder="Enter Primary Email address">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Secondary Email Address </label>
                  <input type="email" name="vnd_secondary_email" class="form-control" placeholder="Enter Secondary Email address">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Primary Phone No <span class="red_bg">*</span></label>
                  <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" pattern="\d*" minlength="10" maxlength="12" required name="vnd_phone" class="form-control" placeholder="Enter Contact Phone No">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Secondary Phone No </label>
                  <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" pattern="\d*" minlength="10" maxlength="13" name="vnd_secondary_ph" class="form-control" placeholder="Enter Secondary Phone No">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Website <span class="red_bg">*</span></label>
                  <input type="url" required name="vnd_web_site" class="form-control" placeholder="Enter Website">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Company Description <span class="red_bg">*</span></label>
                  <input type="text" oninput="this.value = this.value.toUpperCase()" minlength="3" maxlength="500" required name="vnd_com_description" class="form-control" placeholder="Enter Company Description">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn_padding filter_btn save_common_btn" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn_padding filter_btn_blue save_common_btn">Submit</button>
        </div>

      </form>

    </div>
  </div>
</div>

<!--start data table with export button-->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/data-table/css/dataTables.bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/data-table/css/buttons.bootstrap.min.css" />
<script src="<?php echo base_url() ?>assets/css/data-table/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table/js/buttons.bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table/js/jszip.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table/js/vfs_fonts.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table/js/buttons.print.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table/js/buttons.colVis.min.js"></script>
<script>
  $(document).ready(function() {
    var table = $('#datatablesSimple').DataTable({
      lengthChange: false,
      buttons: [{
        extend: 'excel',
        split: ['', ''],
      }]      
    });

    table.buttons().container()
      .appendTo('#datatablesSimple_wrapper .col-sm-6:eq(0)');
  });
</script>
<!--end data table with export button-->

<script>
  $(document).on('click', '.edit_assets_vendor', function() {

    var assets_id = $(this).attr('value');
    var params = $(this).attr("assets_details");
    var arrPrams = params.split("~#~");
    var url = "<?= base_url() ?>dfr_it_assets/add_vendor/change_name/" + assets_id + "";
    $('#chnage_assets_vandor .rename').html(arrPrams[0]);
    $('#update_assets_vendor #chnage_assets_vandor').attr({
      action: url
    });

    $("#update_assets_vendor #chnage_assets_vandor input[name=vnd_name]").val(arrPrams[0]);
    $("#update_assets_vendor #chnage_assets_vandor input[name=vnd_details]").val(arrPrams[1]);
    $("#update_assets_vendor #chnage_assets_vandor input[name=vnd_reg_no]").val(arrPrams[2]);
    $("#update_assets_vendor #chnage_assets_vandor input[name=vnd_contact_name]").val(arrPrams[3]);
    $("#update_assets_vendor #chnage_assets_vandor input[name=vnd_email]").val(arrPrams[4]);
    $("#update_assets_vendor #chnage_assets_vandor input[name=vnd_phone]").val(arrPrams[5]);
    $("#update_assets_vendor #chnage_assets_vandor input[name=vnd_web_site]").val(arrPrams[6]);
    $("#update_assets_vendor #chnage_assets_vandor input[name=vnd_com_description]").val(arrPrams[7]);
    $("#update_assets_vendor #chnage_assets_vandor input[name=vnd_secondary_ph]").val(arrPrams[8]);
    $("#update_assets_vendor #chnage_assets_vandor input[name=vnd_secondary_email]").val(arrPrams[9]);
    $("#update_assets_vendor #chnage_assets_vandor input[name=vnd_location]").val(arrPrams[10]);
    $("#update_assets_vendor #chnage_assets_vandor input[name=vnd_gst_no]").val(arrPrams[11]);

    $('#update_assets_vendor').modal('show');
  });
</script>