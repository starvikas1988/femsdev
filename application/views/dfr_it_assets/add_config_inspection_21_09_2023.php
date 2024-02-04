<div class="wrap">
  <div class="white_widget padding_3">
    <div class="row d_flex">
      <div class="col-sm-6">
        <h2 class="avail_title_heading">Manage  Configuration</h2>
      </div>
      <div class="col-sm-6">
        <div class="right_side">
          <a href="javascript:void(0);" class="btn btn_padding filter_btn" data-toggle="modal" data-target="#myModal">Add Configuration</a>
        </div>
      </div>
    </div>
    <hr class="sepration_border">
    <div class="table_widget common_table_widget">
      <table id="example" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>SL No</th>
            <th>Catagory Name</th>
            <th>Inspection Duration Day</th>
            <th>Status  </th>
            <th>Log  </th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          
              $i=1;
              foreach($it_enable_config as $year_config): 
              $id=$year_config['id'];
              $params= $year_config['catagory_id']."#".$year_config['inspection_dur_days']."#".$year_config['status']; 
            ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $year_config['name']; ?></td>
            <td><?php echo $year_config['inspection_dur_days']; ?></td>
            <td><?php echo $year_config['status_label']; ?></td>
            <td><?php echo $year_config['log']; ?></td>
            <td>
              <button title='Edit' cid='<?php echo $id;?>' params='<?php echo $params; ?>' type='button' class='editClient btn btn-xs'> <img src="<?php echo base_url(); ?>assets_home_v3/images/edit_icon.svg" alt=""></button>
              
              <?php if ($year_config['status'] == 1) { ?>
                          <button title='Unlock Edit Section' cid='<?php echo $id;?>' sid='0'   type='button' class='editItdcl left_margin btn-xs'>
                            <i class="fa fa-pause-circle" aria-hidden="true"></i>
                          </button>
                        <?php } else { ?>
                          <button title='Activate Edit Section' cid='<?php echo $id;?>' sid='1'   type='button' class='editItdcl left_margin btn-xs'>
                            <i class="fa fa-pause-circle" aria-hidden="true"></i>
                          </button>
                        <?php } ?>
            </td>

          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!--add financial year-->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <form class="frmAddClient" onsubmit="return false" method='POST'>

        <div class="modal-header">
        <button type="button" class="close close_new" data-dismiss="modal"></button>
        <h4 class="modal-title">Add Inspection Configuration</h4>
        </div>
        <div class="modal-body">
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="">Catagory Name <span style="color: red;">*</span> </label>
              <select class="form-control" name="catagory_id" id="catagory_id" required>
                    <option value=''>-- Select Catagory Name --</option>
                    <?php 
                    foreach ($catagory_name as $fy) : ?>
                      <option value="<?php echo $fy['id']; ?>"><?php echo $fy['name']; ?></option>
                    <?php endforeach; ?>

                  </select>
            </div>
          </div>
         
          <div class="col-sm-6">
            <div class="form-group">
              <label for="">Inspection Duration Days <span style="color: red;">*</span> </label>
              <input type="text" class="form-control " name="inspection_dur_days" id="inspection_dur_days">
            </div>
          </div>
        </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
        <button type="submit" id='btnAddClient' class="btn btn_padding filter_btn_blue save_common_btn">Add</button>
        </div>
      </form>
    </div>

  </div>
</div>
<!--end financial year-->

<!--edit financial year-->
<div class="modal fade" id="modalEditClient" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <form class="frmEditClient" onsubmit="return false" method='POST'>

        <div class="modal-header">
          <button type="button" class="close close_new" data-dismiss="modal"></button>
          <h4 class="modal-title">Edit Inspection Configuration</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" class="form-control" id="cid" name="cid">

          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="location">Catagory Name <span style="color: red;">*</span> </label>
                <select class="form-control" name="catagory_ids" id="catagory_ids" required>
                    <option value=''>-- Select a Catagory Name--</option>
                    <?php 
                    foreach ($catagory_name as $fy) : ?>
                      <option value="<?php echo $fy['id']; ?>"><?php echo $fy['name']; ?></option>
                    <?php endforeach; ?>

                  </select>
              </div>
            </div>
           
            <div class="col-sm-6">
              <div class="form-group">
                <label for="">Inspection Duration Days <span style="color: red;">*</span> </label>
              <input type="text" class="form-control " name="inspection_dura_days" id="inspection_dura_days">
              </div>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn_padding filter_btn save_common_btn" data-dismiss="modal">Close</button>
          <button type="submit" id='btnEditClient' class="btn btn_padding filter_btn_blue save_common_btn">Update</button>
        </div>
      </form>
    </div>

  </div>
</div>
<!--edit financial year-->


<script type="text/javascript">
  $("#btnAddClient").click(function(){
    var catagory_id=$('.frmAddClient #catagory_id').val();
    var inspection_dur_days=$('.frmAddClient #inspection_dur_days').val();
    
    //alert(fyear + location + from_date_time + baseURL+ to_date_time + enable_actual_field + enable_document_field + enable_stu_comment_field+ status);


    if (catagory_id!="" && inspection_dur_days!="" ) {
      $('#sktPleaseWait').modal('show');
      $.ajax({
        type: 'POST',
        url:baseURL+'dfr_it_assets/config_inspection_add',
        data: $('form.frmAddClient').serialize(),
        success: function(response) {

          $('#sktPleaseWait').modal('hide');
          $('#modalAddClient').modal('hide');
          let dat = JSON.parse(response);
                  if (dat.status == 'success') {
                    $('#sktPleaseWait').modal('hide');
                    popupMessage(dat.message, "green", "success");
                    location.reload();
                }else if(dat.status == 'duplicate') {
                    $('#sktPleaseWait').modal('hide');
                    popupMessage(dat.message, "red", "error");
                    location.reload();
                }else{
                  $('#sktPleaseWait').modal('hide');
                    popupMessage(dat.message, "red", "error");
                    location.reload();
                }
        }
      });
    } else {
      popupMessage("One or More Field(s) are Blank.", "red", "error");
    }

  });
</script>

<script type="text/javascript">
  $(".editClient").click(function(){
    var params=$(this).attr("params");
    var cid=$(this).attr("cid");  
    var arrPrams = params.split("#");
   // alert (arrPrams);
    $('.frmEditClient #cid').val(cid);
    $('.frmEditClient #catagory_ids').val(arrPrams[0]);
    $('.frmEditClient #inspection_dura_days').val(arrPrams[1]);
    $('.frmEditClient #status').val(arrPrams[2]);
    $('#modalEditClient').modal('show');
  });
  
  
  $("#btnEditClient").click(function(){
    var cid=$('.frmEditClient #cid').val();
    var catagory_ids=$('.frmEditClient #catagory_ids').val();
    var inspection_dura_days=$('.frmEditClient #inspection_dura_days').val();
    if (cid!="" && catagory_ids!="") {
      $('#sktPleaseWait').modal('show');
      $.ajax({
        type: 'POST',
        url: baseURL + 'dfr_it_assets/config_inspection_edit',
        data: $('form.frmEditClient').serialize(),
        success: function(response) {
          $('#sktPleaseWait').modal('hide');
          $('#modalEditClient').modal('hide');
          let dat = JSON.parse(response);
                  if (dat.status == 'success') {
                    $('#sktPleaseWait').modal('hide');
                    popupMessage(dat.message, "green", "success");
                    location.reload();
                }else if(dat.status == 'duplicate') {
                    $('#sktPleaseWait').modal('hide');
                    popupMessage(dat.message, "red", "error");
                    location.reload();
                }else{
                  $('#sktPleaseWait').modal('hide');
                    popupMessage(dat.message, "red", "error");
                    location.reload();
                }
        }
      });
    } else {
      popupMessage("One or More Field(s) are Blank.", "red", "error");
    }

  });

</script>
<script>
    $(".editItdcl").on('click', function(){
    var cid=$(this).attr("cid");
    var sid=$(this).attr("sid");
    var title=$(this).attr("title");
    var ans=confirm('Are you sure to '+title+"?");
    if(ans==true){
      $.ajax({
         type: 'POST',    
         url: '<?php echo base_url(); ?>dfr_it_assets/isstatusEdit',
         data:'cid='+ cid+'&sid='+ sid,
         success: function(response){
          location.reload();
           
        }
      });
    }
  });
</script>