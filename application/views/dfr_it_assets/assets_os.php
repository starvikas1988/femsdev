<link href="<?php echo base_url() ?>assets/css/search-filter/css/custom.css" rel="stylesheet">
<script src="<?php echo base_url() ?>assets/css/search-filter/js/jquery.dataTables.min.js"></script>
<div class="wrap">
  <section class="app-content">
    <div class="white_widget padding_3">
      <div class="body_widget">
        <div class="row d_flex">
          <div class="col-sm-6">
            <h2 class="avail_title_heading">Add Assets OS</h2>
          </div>
          <div class="col-sm-6">
            <div class="right_side">
              <button type="button" class="btn btn_padding filter_btn" data-toggle="modal" data-target="#myModal">Add OS</button>
            </div>
          </div>
        </div>
        <hr class="sepration_border">
      </div>
      <div class="body_widget">
        <div class="table_scroll_new leave_table common_table_widget">
          <table id="example" class="table table-bordered table-striped">
            <thead>
              <th>SL</th>
              <th>OS name</th>
              <th>Status</th>
              <th>Action</th>
            </thead>
            <tbody>
              <?php
              $c = 1;
              foreach ($os_list as $key => $value) {
              ?>
                <tr>
                  <td><?= $c ?></td>
                  <td><?= $value['os_name'] ?></td>
                  <td><?php
                      $_status = $value['is_active'];
                      if ($_status == 1) echo '<span class="">Active</span>';
                      else echo '<span class="">Deactive</span>';
                      ?></td>
                  <td class="edit_assets">
                    <a class="btn no_padding edit_assets_add_assets" assets_name="<?= $value['os_name'] ?>" value="<?= $value['id'] ?>" title="Edit">
                      <img src="<?php echo base_url(); ?>assets_home_v3/images/edit_icon.svg" alt="">
                    </a>
                    <?php if ($value['is_active'] == 1) : ?>
                      <a href="<?= base_url() ?>dfr_it_assets/add_os/disable/<?= $value['id'] ?>" class="btn btn no_padding btn_left" title="Deactive" onclick="return confirm('Make sure, Are you Deactive it?');"><img src="<?php echo base_url(); ?>assets_home_v3/images/deactive_user.svg" alt=""></a>
                    <?php else : ?>
                      <a href="<?= base_url() ?>dfr_it_assets/add_os/enable/<?= $value['id'] ?>" class="btn btn no_padding btn_left" title="Active" onclick="return confirm('Make sure, Are you Active it?');"><img src="<?php echo base_url(); ?>assets_home_v3/images/active_user.svg" alt=""></a>
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
        <h4 class="modal-title">Add Assets OS</h4>
      </div>
      <form action="<?= base_url() ?>dfr_it_assets/add_os/add" method="post">
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label>Enter OS Name <span class="red_bg">*</span></label>
                <input type="text" minlength="2" maxlength="100" required name="add_assets_os" class="form-control" placeholder="Enter OS Details">
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
      <form id="chnage_assets_add_assets_os" action="" data-toggle="validator" method="POST" novalidate="true">
        <div class="modal-header">
          <button type="button" class="close close_new" data-dismiss="modal" aria-label="Close"></button>
          <h4 class="modal-title" id="myModalLabel">Change Assets OS Deatils (<spna class="rename"></spna>)</h4>
        </div>
        <div class="modal-body">
          <div class="filter-widget">
            <div class="row">
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="form-check-label" for="subject">Change OS Name</label>
                  <input type="text" minlength="2" maxlength="100" id="assets_name" value="" required name="add_assets_os" class="form-control" placeholder="Enter OS Details">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
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