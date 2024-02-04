<script type="text/javascript" src="<?php echo base_url() ?>assets/css/search-filter/css/custom.css"></script>
<script src="<?php echo base_url() ?>assets/css/search-filter/js/jquery.dataTables.min.js"></script>
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
<?php $pattern = 'onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 32) || (event.charCode == 45)"'; ?>
<div class="wrap">
  <section class="app-content">
    <div class="white_widget padding_3">
      <div class="body_widget">
        <div class="row d_flex">
          <div class="col-sm-6">
            <h2 class="avail_title_heading">Assets List</h2>
          </div>
          <div class="col-sm-6">
            <div class="right_side">
              <button type="button" class="btn btn_padding filter_btn" data-toggle="modal" data-target="#myModal">Add</button>
            </div>
          </div>
        </div>
        <hr class="sepration_border">
      </div>
      <div class="body_widget">
        <div class="table_scroll_new leave_table table-parent common_table_widget">
          <table class="table table-bordered table-responsive table-striped" id="example">
            <thead>
              <th class="table_width_sr">SL</th>
              <th>Assets Name</th>
              <th class="table_width1">Show in Inventory</th>
              <th class="table_width">Status</th>
              <th class="table_width">Action</th>
            </thead>
            <tbody>
              <?php
              $c = 1;
              foreach ($category_data as $key => $value) {
              ?>
                <tr>
                  <td><?= $c ?></td>
                  <td><?= $value['name'] ?></td>
                  <td><?php
                      if ($value['is_inv'] == 1) echo "Yes";
                      else echo "No";
                      ?></td>
                  <td><?php
                      $_status = $value['status'];
                      if ($_status == 1) echo '<span class="">Active</span>';
                      else echo '<span class="">Deactive</span>';
                      ?></td>
                  <td class="edit_assets">
                    <a class="btn no_padding edit_assets_add_assets" assets_name="<?= $value['name'] ?>" value="<?= $value['id'] ?>" title="Edit">
                      <img src="<?php echo base_url(); ?>assets_home_v3/images/edit_icon.svg" alt="">
                    </a>
                    <?php if ($value['status'] == 1) : ?>
                      <a href="<?= base_url() ?>dfr_it_assets/add_assets/disable/<?= $value['id'] ?>" class="btn btn no_padding btn_left" title="Deactive" onclick="return confirm('Make sure, Are you Deactive it?');"><img src="<?php echo base_url(); ?>assets_home_v3/images/deactive_user.svg" alt=""></a>
                    <?php else : ?>
                      <a href="<?= base_url() ?>dfr_it_assets/add_assets/enable/<?= $value['id'] ?>" class="btn btn no_padding btn_left" title="Active" onclick="return confirm('Make sure, Are you Active it?');"><img src="<?php echo base_url(); ?>assets_home_v3/images/active_user.svg" alt=""></a>

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
  <div class="modal-dialog modal-sm small_modal_new">
    <div class="modal-content">
      <div class="modal-header">
        <form action="<?= base_url() ?>dfr_it_assets/add_assets/add" method="post">
          <button type="button" class="close close_new" data-dismiss="modal"></button>
          <h4 class="modal-title">Add Asset</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group">
              <label>1. Enter Assets Name <span class="red_bg">*</span></label>
              <input type="text" <?= $pattern ?> required name="add_assets" class="form-control" placeholder="Enter Name">
            </div>
          </div>
          <div class="col-sm-12">
            <div class="form-group">
              <label style="margin-right: 17px;">2. Is Show in Assets Management? <span class="red_bg">*</span></label>
              <input type="checkbox" id="assets_manage" name="is_ast_manage" value="1" required>
              <label for="assets_manage" style="margin-right: 7px;">Yes</label>
              <input type="checkbox" id="assets_manage" name="is_ast_manage" value="2" required>
              <label for="assets_manage">No</label>

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
<div class="modal fade in" id="update_assets_add_assets" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg small_modal_new">
    <div class="modal-content">

      <form id="chnage_assets_add_assets" action="" data-toggle="validator" method="POST" novalidate="true">
        <div class="modal-header">
          <button type="button" class="close close_new" data-dismiss="modal" aria-label="Close"></button>
          <h4 class="modal-title" id="myModalLabel">Rename Asset (<spna class="rename"></spna>)</h4>
        </div>
        <div class="modal-body">
          <div class="filter-widget">
            <div class="row">

            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="form-check-label" for="subject">Change Name</label>
                  <input <?= $pattern ?> type="text" class="form-control" value="" id="assets_name" name="assets_name" placeholder="Write Here" required>
                </div>
              </div>
              <!--<div class="col-sm-12">
          <div class="form-group">
            <label style="margin-right: 17px;">Is Show in Assets Management? <span style="color: red;">*</span></label>
            <input type="checkbox" id="assets_manage" name="is_ast_manage" value="1" required>
            <label for="assets_manage" style="margin-right: 7px;">Yes</label>
            <input type="checkbox" id="assets_manage" name="is_ast_manage" value="2" required>
            <label for="assets_manage">No</label>
        </div>
      </div>-->
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn_padding filter_btn save_common_btn" data-dismiss="modal">Cancel</button>
          <button type="submit" id="submit_category_preassign" class="btn btn_padding filter_btn_blue save_common_btn">Submit</button>
        </div>

      </form>

    </div>
  </div>
</div>

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script>

<script>
  var table = $('#example').DataTable({
    lengthChange: false,
    fixedColumns: {
      left: 0,
      right: 1
    },
  });
  new $.fn.dataTable.Buttons(table, {
    buttons: [{
      extend: 'excelHtml5',
      text: 'Export to Excel'     
    }, ]
  });
  table.buttons().container()
    .appendTo($('.col-sm-6:eq(0)', table.table().container()))
</script>

<script>
  // the selector will match all input controls of type :checkbox
  // and attach a click event handler 
  $("input:checkbox").on('click', function() {
    // in the handler, 'this' refers to the box clicked on
    var $box = $(this);
    if ($box.is(":checked")) {
      // the name of the box is retrieved using the .attr() method
      // as it is assumed and expected to be immutable
      var group = "input:checkbox[name='" + $box.attr("name") + "']";
      // the checked state of the group/box on the other hand will change
      // and the current value is retrieved using .prop() method
      $(group).prop("checked", false);
      $box.prop("checked", true);
      $("input:checkbox").attr("required", false);
    } else {
      $box.prop("checked", false);
      $("input:checkbox").attr("required", true);
    }
  });
</script>