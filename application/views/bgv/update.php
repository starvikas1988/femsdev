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
	padding: 15px;
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
.filter-field input[type="file"] {
  border: 1px solid #ddd!important;
  padding-top: 8px;

}
.filter-field label {
 font-weight: 500!important;
  color: #323232!important;
}

/* only for omind-logo*/
.app-brand .brand-icon {
 
  margin-top: -18px;
}

	</style>

<div class="parent-div">


	<section class="main">
		 
         <section class="common-space">
         	<div class="main-content">
         		<div class="title">
										<h5>Background Verification</h5>
									</div>
         		<div class="row filter-field">
         			
         			<div class="col-sm-3">
         				<div class="form-group mb-3">
         					 <label for="exampleFormControlInput1" class="form-label">Fusion ID</label>
  									<input type="text" id="fusion_id" name="fusion_id" class="form-control" placeholder="Fusion ID">
         				</div>
         			</div>

         			<div class="col-sm-3 ">
         			<button class="btn btn-new" onclick="return getbgvdata();"><i class="fa fa-search mx-1" aria-hidden="true"></i>Search</button>
         			</div>
         		</div>
         	</div>
         </section>

         <section class="common-space" id="viewBgvDiv" style="display:none;">
                  <div class="main-content">
                    <div class="row filter-field">
                      <div class="col-sm-12">
                  <div class="title">
                    <h5 class="bgv_heading"></h5>
                  </div>
                  </div>
                </div>
              </div>
        </section>
       
								<section class="common-space" id="updateBgvDiv" style="display:none;">
									<div class="main-content">
										<div class="row filter-field">
											<div class="col-sm-12">
									<div class="title">
										<h5 class="bgv_title">Update Background Verification</h5>
									</div>
									</div>
									<div class="col-sm-12">
                    <form class="frmBGV" action="<?php echo base_url(); ?>bgv/updateBGV" data-toggle="validator" method='POST' enctype="multipart/form-data">
								<div class="row filter-field">


              <input type="hidden" id="user_id" name="user_id" class="form-control" required>
              <input type="hidden" id="dfr_id" name="dfr_id" class="form-control" >
              <input type="hidden" id="edit_id" name="edit_id" class="form-control" >

         			<div class="col-sm-6">
         				<div class="form-group mb-3">
                    <label>CRC Date <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>
                    <input type="text" id="crc_date" name="crc_date" class="form-control dobdatepicker" value="" required readonly>
         				</div>
         			</div>
         			<div class="col-sm-6">
         				<div class="form-group mb-3">
                    <label>CRC Document <i class="fa fa-asterisk" style="font-size:10px; color:red"></i></label>  <span style="display: none;" id="crc_span"> [Old File] <span id="crc_doc_view"></span></span>
                    <input type="file" id="uploadFile_1" name="crc_doc" class="form-control" value=""  required>
                     <input type="hidden" id="crc_doc_old" name="crc_doc_old" readonly class="form-control" value="" style="display: none;" >
                    <label><i class="fa fa-asterisk" style="font-size:10px; color:red"> File should be in .PDF format (5 MB)</i></label>
         				</div>
         			</div>

         				<div class="col-sm-6">
         				<div class="form-group mb-3">
                    <label>Address Verification Date <i class="fa fa-asterisk" style="font-size:6px; color:red"></i></label>

                    <input type="text" id="address_verification_date" name="address_verification_date" class="form-control dobdatepicker" value="" required readonly>
         				</div>
         			</div>

              <div class="col-sm-6">
                <div class="form-group mb-3">
                  <label>Address Verification Document <i class="fa fa-asterisk" style="font-size:10px; color:red"></i></label> <span style="display: none;" id="addr_span"> [Old File] <span id="address_verification_doc_view"></span></span>
                  <input type="file" id="uploadFile_2" name="address_verification_doc" class="form-control" value=""  required>
                  <input type="hidden" id="address_verification_doc_old" name="address_verification_doc_old" readonly class="form-control" value="" style="display: none;">
                  <label><i class="fa fa-asterisk" style="font-size:10px; color:red"> File should be in .PDF format (5 MB)</i></label>
                </div>
              </div>

             <div class="col-md-12">
                            <i class="fa fa-asterisk" style="font-size:12px; color:red">Note: All fields are mandatory.</i>
                            </div>
         	
         			
         			<div class="col-sm-3 ">
                <input type="submit" name="submit" class="btn btn-new frmSaveButton" value="Submit">
         			<!--<button class="btn btn-new"><i class="fa fa-paper-plane mx-1" aria-hidden="true"></i>Submit</button>-->
         			</div>
         		</div>

          </form>
									</div>
										</div>
									</div>
								</section>

   
      
		
	</section>

</div>

<script type="text/javascript">
  function getbgvdata(){
    var fusion_id = $('#fusion_id').val();
    // alert(fusion_id);
    if(fusion_id != ''){
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('bgv/getAllBgvData'); ?>",
            data: 'fusion_id=' + fusion_id,
            success: function(offList) {  
              //alert(offList);
              var json_obj = $.parseJSON(offList);
              console.log(json_obj.add_user_id);
              
//json_obj.add_user_id != ''  
              if(json_obj.hasOwnProperty('add_user_id') == true){
                
                  if(json_obj.add_user_id.trim() == 'nodata'){
                        $('#updateBgvDiv').hide();
                        $('#viewBgvDiv').show();
                        $(".bgv_heading").text("No data found.");
                        
                        //alert('No Fusion ID found');

                  }else if(json_obj.add_user_id.trim() == 'bgvdone'){
                        //$('#updateBgvDiv').hide();                        
                        //$('#viewBgvDiv').show();
                      $(".bgv_title").text("Update Background Verification [Background verification done , document not found]");
                      $('.frmBGV #edit_id').val('');
                      $('.frmBGV #user_id').val(json_obj.add_userr_id.trim());                  
                      $('.frmBGV #crc_date').val('').removeAttr("disabled");
                      $('.frmBGV #address_verification_date').val('').removeAttr("disabled");

                      $('.frmBGV #uploadFile_1').css("display", "block");
                      $('.frmBGV #uploadFile_2').css("display", "block");

                      $('.frmBGV #address_verification_doc_old').val('').css("display", "none");
                      $('.frmBGV #crc_doc_old').val('').css("display", "none");

                      $('.frmBGV #crc_span').hide(); 
                      $('.frmBGV #addr_span').hide(); 
                      $('#updateBgvDiv').show();
                      $('#viewBgvDiv').hide();

                  }else{

                      $(".bgv_title").text("Update Background Verification");
                      $('.frmBGV #edit_id').val('');
                      $('.frmBGV #user_id').val(json_obj.add_user_id.trim());                  
                      $('.frmBGV #crc_date').val('').removeAttr("disabled");
                      $('.frmBGV #address_verification_date').val('').removeAttr("disabled");

                      $('.frmBGV #uploadFile_1').css("display", "block");
                      $('.frmBGV #uploadFile_2').css("display", "block");

                      $('.frmBGV #address_verification_doc_old').val('').css("display", "none");
                      $('.frmBGV #crc_doc_old').val('').css("display", "none");

                      $('.frmBGV #crc_span').hide(); 
                      $('.frmBGV #addr_span').hide(); 
                      $('#updateBgvDiv').show();
                      $('#viewBgvDiv').hide();

                  }
                  


                }else{
                  // alert('hi');
                  $('#viewBgvDiv').hide();
                  $('#updateBgvDiv').show();
                  $(".bgv_title").text("Update Background Verification");
                  for (var i in json_obj) {
                        

                        $('.frmBGV #edit_id').val(json_obj[i].id);
                        $('.frmBGV #crc_date').val(json_obj[i].crc_date);
                        $('.frmBGV #address_verification_date').val(json_obj[i].address_verification_date);
                        
                        $('.frmBGV #address_verification_doc_old').val(json_obj[i].address_verification_doc).css("display", "block").prop("readonly", true);
                        $('.frmBGV #crc_doc_old').val(json_obj[i].crc_doc).css("display", "block").prop("readonly", true);

                        var url_address_verification_doc = '<?php echo base_url()."uploads/bgv_doc/" ?>'+json_obj[i].address_verification_doc;
                        var url_crc_doc = '<?php echo base_url()."uploads/bgv_doc/" ?>'+json_obj[i].crc_doc;

                        /*var link_crc_doc = '<a onclick=window.open("'+url_crc_doc+'"),"popUpWindow","height=500,width=400,left=100,top=100,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes"><i class="fa fa-share-square-o"></i></a>'; 

                        var link_address_verification_doc = '<a onclick=window.open("'+url_address_verification_doc+'"),"popUpWindow","height=500,width=400,left=100,top=100,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes"><i class="fa fa-share-square-o"></i></a>'; */
                        //alert(url_address_verification_doc);

                        $('.frmBGV #crc_span').show(); 
                        $('.frmBGV #addr_span').show(); 

                        $('.frmBGV #crc_doc_view').html('<a onclick=window.open("'+url_crc_doc+'"),"popUpWindow","height=500,width=400,left=100,top=100,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes"><i class="fa fa-eye"></i></a>');

                        $('.frmBGV #address_verification_doc_view').html('<a onclick=window.open("'+url_address_verification_doc+'"),"popUpWindow","height=500,width=400,left=100,top=100,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes"><i class="fa fa-eye"></i></a>');
                        
                    } 

                }
                       
                
                
            },
            error: function() {
                //$('#sktPleaseWait').modal('hide');
                //alert('Something Went Wrong!');
            }
        });
    }else{
      alert('Please enter Fusion ID');
    }
  }



    
</script>



