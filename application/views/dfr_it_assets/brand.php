<link href="<?php echo base_url() ?>assets/css/search-filter/css/custom.css" rel="stylesheet">
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
<div class="wrap">
  <section class="app-content">
    <div class="white_widget padding_3">
      <div class="body_widget">
        <div class="row d_flex">
          <div class="col-sm-6">
            <h2 class="avail_title_heading">Brand List</h2>
          </div>
          <div class="col-sm-6">
            <div class="right_side">
              <button type="button" class="btn btn_padding filter_btn" data-toggle="modal" data-target="#myModal">Add Brand</button>
            </div>
          </div>
        </div>
        <hr class="sepration_border">
      </div>
      <div class="body_widget">
        <div class="table_scroll_new leave_table common_table_widget table-parent">
          <table class="table table-bordered table-striped" id="example">
            <thead>
              <th class="table_width_sr">SL</th>
              <th class="employee_td">Name</th>
              <th class="table_width">Status</th>
              <th class="table_width">Action</th>
            </thead>
            <tbody>
              <?php
              $c = 1;
              foreach ($brand_list as $key => $value) {
              ?>
                <tr>
                  <td><?= $c ?></td>
                  <td><?= $value['name'] ?></td>
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
                      <a href="<?= base_url() ?>dfr_it_assets/add_assets_brand/disable/<?= $value['id'] ?>" class="btn btn no_padding btn_left" title="Deactive" onclick="return confirm('Make sure, Are you Deactive it?');"><img src="<?php echo base_url(); ?>assets_home_v3/images/deactive_user.svg" alt=""></a>
                    <?php else : ?>
                      <a href="<?= base_url() ?>dfr_it_assets/add_assets_brand/enable/<?= $value['id'] ?>" class="btn btn no_padding btn_left" title="Active" onclick="return confirm('Make sure, Are you Active it?');"><img src="<?php echo base_url(); ?>assets_home_v3/images/active_user.svg" alt=""></a>

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
        <button type="button" class="close close_new" data-dismiss="modal"></button>
        <h4 class="modal-title">Add Brand</h4>
      </div>
      <form action="<?= base_url() ?>dfr_it_assets/add_assets_brand/add" method="post">
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Enter Brand Name <span class="red_bg">*</span></label>
                <input type="text" oninput="this.value = this.value.toUpperCase()" required name="add_assets_brand" class="form-control" placeholder="Enter Name">
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

      <form id="chnage_assets_add_assets_brand" action="" data-toggle="validator" method="POST" novalidate="true">
        <div class="modal-header">
          <button type="button" class="close close_new" data-dismiss="modal" aria-label="Close"></button>
          <h4 class="modal-title" id="myModalLabel">Rename Brand (<spna class="rename"></spna>)</h4>
        </div>
        <div class="modal-body">
          <div class="filter-widget">
            <div class="row">

            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="form-check-label" for="subject">Change Name</label>
                  <input oninput="this.value = this.value.toUpperCase()" type="text" class="form-control" value="" id="assets_name" name="assets_name" placeholder="Write Here" required>
                </div>
              </div>
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