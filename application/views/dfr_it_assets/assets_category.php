<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/search-filter/css/custom.css" />
<script src="<?php echo base_url() ?>assets/css/search-filter/js/jquery.dataTables.min.js"></script>
<style>
  .mT .multiselect {
    margin-top: -3px;
  }

  .bTon .btn-group {
    width: 100% !important;
  }
</style>
<?php $pattern = 'onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 32)"'; ?>
<div class="wrap">
  <section class="app-content">
    <div class="white_widget padding_3">
      <div class="body_widget">
        <div class="row d_flex">
          <div class="col-sm-6">
            <h2 class="avail_title_heading">IT Support Categorys</h2>
          </div>
          <div class="col-sm-6">
            <div class="right_side">
              <button type="button" class="btn btn_padding filter_btn" data-toggle="modal" data-target="#myModal">Add Category</button>
            </div>
          </div>
        </div>
        <hr class="sepration_border">

      </div>
      <div class="body_widget">
        <div class="common_table_widget report_hirarchy">
          <table class="table table-bordered table-striped">
            <thead>
              <th class="table_width_sr">SL. No.</th>
              <th class="table_width1">Category</th>
              <th class="employee_adrs">Assets Name</th>
              <th class="table_width1">Status</th>
              <th class="table_width1">Action</th>
            </thead>
            <tbody>
              <?php
              $c = 1;
              foreach ($assets_category_list as $key => $value) {
              ?>
                <tr>
                  <td><?= $c ?></td>
                  <td><?= $value['name'] ?></td>
                  <td><?= $value['assets_name'] ?></td>
                  <td><?php
                      $_status = $value['is_active'];
                      if ($_status == 1) echo '<span class="">Active</span>';
                      else echo '<span class="">Deactive</span>';
                      ?></td>
                  <td class="edit_assets">
                    <a class="btn no_padding edit_assets_add_assets" assets_category_names="<?= $value['assets_name'] ?>" assets_name="<?= $value['name'] ?>" value="<?= $value['id'] ?>" title="Edit">
                      <img src="<?php echo base_url(); ?>assets_home_v3/images/edit_icon.svg" alt="">
                    </a>
                    <?php if ($value['is_active'] == 1) : ?>
                      <a href="<?= base_url() ?>it_assets_support/add_sop_assets_category/disable/<?= $value['id'] ?>" class="btn btn no_padding btn_left" title="Deactive" onclick="return confirm('Make sure, Are you Deactive it?');"><img src="<?php echo base_url(); ?>assets_home_v3/images/deactive_user.svg" alt=""></a>
                    <?php else : ?>
                      <a href="<?= base_url() ?>it_assets_support/add_sop_assets_category/enable/<?= $value['id'] ?>" class="btn btn no_padding btn_left" title="Active" onclick="return confirm('Make sure, Are you Active it?');"><img src="<?php echo base_url(); ?>assets_home_v3/images/active_user.svg" alt=""></a>

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
      <form action="<?= base_url() ?>it_assets_support/add_sop_assets_category/add" method="post">
        <div class="modal-header">
          <button type="button" class="close close_new" data-dismiss="modal"></button>
          <h4 class="modal-title">Add Category</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label>Enter Assets Category Name <span class="red_bg">*</span></label>
                <input type="text" <?= $pattern ?> required name="add_assets_sop_name" class="form-control" placeholder="Enter Category">
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group filter-widget">
                <label>Assets Category <span class="red_bg">*</span></label>
                <select class="form-control" id="assets_ids_list_new" name="assets_ids[]" autocomplete="off" placeholder="Select Assets" multiple="multiple" required>
                  <?php foreach ($assets_id_list as $loc) : ?>
                    <option value="<?= $loc['id'] ?>"><?= $loc['name'] ?></option>
                  <?php endforeach; ?>
                </select>
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
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <form id="update_assets_category_sop" action="" data-toggle="validator" method="POST" novalidate="true">
        <div class="modal-header">
          <button type="button" class="close close_new" data-dismiss="modal" aria-label="Close"></button>
          <h4 class="modal-title" id="myModalLabel">Rename Category (<spna class="rename"></spna>)</h4>
        </div>
        <div class="modal-body">
          <div class="filter-widget">
            <div class="row">

            </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Enter Assets Category Name <span class="red_bg">*</span></label>
                  <input type="text" <?= $pattern ?> id="assets_name" required name="add_assets_sop_name" class="form-control" placeholder="Enter Category">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group bTon">
                  <label>Assets Category <span class="red_bg">*</span> <span id="assets_ids_list"></span></label><br>
                  <select class="form-control " id="xyz_multiselect" name="assets_ids[]" autocomplete="off" placeholder="Select Assets" multiple="multiple" required>
                    <?php foreach ($assets_id_list as $loc) : ?>
                      <option value="<?= $loc['id'] ?>"><?= $loc['name'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
          <button type="submit" id="submit_category_preassign" class="btn btn_padding filter_btn_blue save_common_btn">Submit</button>
        </div>

      </form>

    </div>
  </div>
</div>

<script>
  $(document).on('click', '.edit_assets_add_assets', function() {
    var params = $(this).attr("assets_category_names");
    $('#assets_ids_list').text('(' + params + ')');
  });
</script>

<script>
  $(document).ready(function() {
    $('.select-box').selectize({
      sortField: 'text'
    });
  });
</script>
<script>
  $(function() {
    $('#multiselect').multiselect();

    $('#assets_id_list').multiselect({
      includeSelectAllOption: true,
      enableFiltering: true,
      enableCaseInsensitiveFiltering: true,
      filterPlaceholder: 'Search for something...'
    });
  });
</script>
<script>
  $(function() {
    $('#multiselect').multiselect();

    $('#xyz_multiselect').multiselect({
      includeSelectAllOption: true,
      enableFiltering: true,
      enableCaseInsensitiveFiltering: true,
      filterPlaceholder: 'Search for something...'
    });
  });
</script>
<script>
  $(function() {
    $('#multiselect').multiselect();

    $('#assets_ids_list_new').multiselect({
      includeSelectAllOption: true,
      enableFiltering: true,
      enableCaseInsensitiveFiltering: true,
      filterPlaceholder: 'Search for something...'
    });
  });
</script>