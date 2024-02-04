  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <style>
  @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,500;1,900&display=swap');

body{
  background:#e7e7f4;
    font-family: 'Roboto', sans-serif;
}

/*section no 2*/
.common-space
{
  margin: 10px;
}
.main-content
{
  background: #fff;
  padding: 10px;
  border-radius: 10px;

}
.table th , .table td{
  padding: 3px;
  font-size: 12px!important;
}
thead{
  background: #9ea2fc;
color: #fff;
}
.table {
  border-radius: 5px 5px 0 0;
  overflow: hidden;
}
.table tbody tr:last-of-type
{
  border-bottom: 2px solid #9ea2fc;
}
 .page-item.active .page-link{
  background:#9ea2fc!important;
  border-color:#9ea2fc!important;
}
.title{
  padding: 10px 10px 10px 0px;
}
.title h5 {
  font-size: 16px;
  font-weight: bold;
  padding: 0px 10px 0px 10px;
  border-left: 5px solid red;
  color: #333333;
 
}
.filter-field .form-control,.filter-field .form-select
{
  height: 40px;
}
.filter-field .form-control:focus , .filter-field .form-select:focus{
  border-color: #9ea2fc!important;
  box-shadow: none!important;
}
.btn-new{
  background: #5156be;
color: #fff;
width: 150px;
margin-top: 21px;
padding: 9px;
font-size: 14px;
transition: all 0.5s ease-in-out 0s;
}

.btn-new .fa
{
  margin-right: 5px;
}
.btn-new:focus, .btn-new:hover {
  color: #333;
  text-decoration: none;
  background: #fff;
  border: 1px solid #5156be;
}
.filter-field th,.filter-field  td
{
  padding: 3px!important;
}
.dataTables_length select {
  
  border: none!important;
  background: #fff!important;
  border: 1px solid #ddd!important;
  height: 40px!important;
  border-radius: 5px!important;
}
.dataTables_filter input{
  height: 40px!important;
}
.btn-icon {
  background: #5156be;
  color: #fff;
  padding: 7px 11px 7px 11px;
  font-size: 12px;
   border-radius: 50%;
  transition: all 0.5s ease-in-out 0s;
 
}


.btn-icon:focus, .btn-icon:hover {
  color: #333;
  text-decoration: none;
  background: #fff;
  border: 1px solid #5156be;
}
.filter-field label {
 font-weight: 500!important;
  color: #323232!important;
}

/* only for omind-logo*/
.app-brand .brand-icon {
 
  margin-top: -18px;
}
.table-parent .col-sm-12 
{
  overflow-x: scroll;
}
.table > thead > tr > th {
  vertical-align: top!important;  
}
.table-parent .form-inline .form-control {
  min-width: 50px!important;
}
div.dataTables_wrapper div.dataTables_paginate {

  text-align: center!important;
  margin-left: 200px;
}
  </style>

<div class="parent-div">


  <section class="main">
     
         <section class="common-space">
          <div class="main-content">
            <div class="title">
                    <h5>Background Verification List</h5>
                  </div>
            <form data-toggle="validator" method='GET' action="" enctype="multipart/form-data">   
            <div class="row filter-field">
              <div class="col-sm-3">
                <div class="form-group mb-3">
                   <label for="exampleFormControlInput1" class="form-label">Start Date</label>
                    <input type="text" class="form-control" id="from_date" name="from_date" value="<?php if($from_date != ''){ echo $from_date; } else{ echo date('m/d/Y', strtotime('-15 days'));} ?>" autocomplete="off" readonly>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group mb-3">
                   <label for="exampleFormControlInput1" class="form-label">End Date</label>
                    <input type="text" class="form-control" id="to_date" name="to_date" value="<?php if($to_date != ''){ echo $to_date; } else{ echo date('m/d/Y');} ?>" autocomplete="off" readonly>
                </div>
              </div>

              <div class="col-sm-3">
                <div class="form-group mb-3">
                   <label for="exampleFormControlInput1" class="form-label">Fusion ID</label>
                    <input type="text" id="fusion_id" name="fusion_id" class="form-control" placeholder="Fusion ID" value="<?php echo $fusion_id; ?>">
                </div>
              </div>            
              
              <div class="col-sm-3 ">
              <button type="submit" name="search" id="search" value="Search" class="btn btn-new">
                <i class="fa fa-search mx-1" aria-hidden="true"></i>
                Search
              </button>
              <!--<button class="btn btn-new"><i class="fa fa-search mx-1" aria-hidden="true"></i>Search</button>-->
              </div>
            </div>

          </form>
          </div>
         </section>
       
                <section class="common-space">
                  <div class="main-content  ">
                    <div class="row filter-field">
                      <div class="col-sm-12">
                  <div class="title">
                    <h5>Background Verification List</h5>
                  </div>
                  </div>
                  <div class="col-sm-12 table-parent">
                    <table class="table table-striped" id="example">
                      <thead>
                        <th>Sr</th>
                        <th>Fusion Id</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>CRC Date</th>
                        <th>CRC Current Document</th>
                        <th>CRC Old Document</th>
                        <th>Address Verification Date</th>
                        <th>Address Verification Current Document</th>
                        <th>Address Verification Old Document</th>
                        <th>Added Date</th>
                        <th>Added By</th>
                        <th>Modified Date</th>
                        <th>Modified By</th>
                        
                      </thead>
                      <tbody>

                        <?php 
                        $c = 0;
                        if(!empty($user_bgvs)){
                        foreach ($user_bgvs as $key => $value) { $c++;
                          
                          if($value['c_id'] != ''){
                            $c_id = $value['c_id'];
                          }else{
                            $c_id = $value['user_id'];
                          }

                          $crc_doc = $value['crc_doc'];
                          if($crc_doc!='') $bgv_crc_doc = '<a href="'.base_url().'uploads/bgv_doc/'.$crc_doc.'" target="_blank">View</a>';
                          else $bgv_crc_doc = 'No Document Found';

                          $crc_doc_old = $value['crc_doc_old'];
                          if($crc_doc_old!='') $bgv_crc_doc_old = '<a href="'.base_url().'uploads/bgv_doc/'.$crc_doc_old.'" target="_blank">View</a>';
                          else $bgv_crc_doc_old = 'No Document Found';

                          $address_verification_doc = $value['address_verification_doc'];
                          if($address_verification_doc!='') $bgv_address_verification_doc = '<a href="'.base_url().'uploads/bgv_doc/'.$address_verification_doc.'" target="_blank">View</a>';
                        else $bgv_address_verification_doc = 'No Document Found';

                        $address_verification_doc_old = $value['address_verification_doc_old'];
                          if($address_verification_doc_old!='') $bgv_address_verification_doc_old = '<a href="'.base_url().'uploads/bgv_doc/'.$address_verification_doc_old.'" target="_blank">View</a>';
                        else $bgv_address_verification_doc_old = 'No Document Found';
                          
                          
                          $fname = $value['fusion_fname'];                         
                          $lname = $value['fusion_lname'];
                          $phone = $value['fusion_phone'];                          
                          $gender = $value['sex'];

                          $added_date = date('d-m-Y',strtotime($value['added_date']));
                          
                          if($value['modified_date'] != '0000-00-00 00:00:00'){
                            $modified_date = date('d-m-Y',strtotime($value['modified_date']));
                          }else{
                            $modified_date = '-';
                          }
                          $addedby_name = $value['addedby_name'];
                          $modified_name = $value['modified_name'];

                         ?>
                        <tr>
                          <td><?=$c?></td>
                          <td><?=$value['fusion_id']?></td>
                          <td><?=$fname . " " . $lname?></td>
                          <td><?=$gender?></td>
                          <td><?=$phone?></td>
                          <td><?=date('d-m-Y',strtotime($value['crc_date']))?></td>
                          <td><?=$bgv_crc_doc?></td>
                          <td><?=$bgv_crc_doc_old?></td>
                          <td><?=date('d-m-Y',strtotime($value['address_verification_date']))?></td>
                          <td><?=$bgv_address_verification_doc?></td>
                          <td><?=$bgv_address_verification_doc_old?></td>

                          <td><?=$added_date?></td>
                          <td><?=$addedby_name?></td>
                          <td><?=$modified_date?></td>
                          <td><?=$modified_name?></td>

                          <!--<td><a class="btn btn-icon btn-sm viewbgv" c_id='<?=$c_id?>' r_id='' title="Click to View BGV"><i class="fa fa-eye" aria-hidden="true"></i></a>
                          </td>-->
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

   
      
    
  </section>
    <!-- Modal -->
  <div class="modal fade" id="updateCandidateBGVModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <form class="frmBGVCandidate" data-toggle="validator" method='POST' enctype="multipart/form-data">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">View BGV</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" id="r_id" name="r_id" class="form-control" required>
          <input type="hidden" id="c_id" name="c_id" class="form-control" required>
          <div class="row" id="bgvdat">
                        <div class="col-md-6">
                            <div class="form-group">                                
                                   <label>CRC Date <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                                <input type="text" id="crc_date" name="crc_date" class="form-control dobdatepicker" value="" >
                            </div>
                            </div>
                              <div class="col-md-6">
                                <div class="form-group">

                                    <label>CRC Document</label> <span id="crc_doc_view"></span>
                                    <input type="file" id="uploadFile_1" name="crc_doc" class="form-control" value="" onchange="Filevalidation()" >
                                    <input type="text" id="crc_doc" readonly class="form-control" value="" style="display: none;">
                                    <label><i class="fa fa-asterisk" style="font-size:10px; color:red"> File should be in .PDF format</i></label>
                                </div>
                            </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Address Verification Date <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>                                
                                <input type="text" id="address_verification_date" name="address_verification_date" class="form-control dobdatepicker" value="" >
                            </div>
                            </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                    <label>Address Verification Document</label> <span id="address_verification_doc_view"></span>
                                    <input type="file" id="uploadFile_2" name="address_verification_doc" class="form-control" value="" onchange="Filevalidation()" >
                                    <input type="text" id="address_verification_doc" readonly class="form-control" value="" style="display: none;">
                                    <label><i class="fa fa-asterisk" style="font-size:10px; color:red"> File should be in .PDF format</i></label>
                                </div>
                            </div>
                        
                    </div>
      </div>
           <div class="modal-footer">       
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <input type="submit" name="submit" class="btn btn-primary frmSaveButton" value="Save">
      </div>
      </form>
      </div>
      
    </div>
  </div>



</div>

    
    

<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/buttons.bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/jszip.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/vfs_fonts.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/buttons.print.min.js"></script>
<script src="<?php echo base_url() ?>assets/css/data-table-export/js/buttons.colVis.min.js"></script>

<script>
//   $(document).ready(function() {
//     var table = $('#example').DataTable( {
//         lengthChange: false
//     } );
// } );
  $(document).ready(function () {
    $('#example').DataTable();
});
</script>

