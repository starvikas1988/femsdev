<style>
    .datepicker-modal {
        position: absolute !important;
        top: auto !important;
        left: auto !important;
    }
</style>
<script type="text/javascript">

   $(function() {
   			$( "#from_date" ).datepicker({  maxDate: new Date() });
   			$( "#to_date" ).datepicker({  maxDate: new Date() });
   			$( ".dobdatepicker" ).datepicker({  maxDate: new Date() });                     
    });

    $(".viewbgv").click(function() {
        var r_id = $(this).attr("r_id");
        var c_id = $(this).attr("c_id");
        //var bgv = $(this).attr("bgv");

        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('bgv/getBgvData'); ?>",
            data: 'c_id=' + c_id + '&r_id=' + r_id,
            success: function(offList) {  

            var json_obj = $.parseJSON(offList);                      
                
                if(json_obj.hasOwnProperty('add_user_id') == true){
                    /*if(json_obj.add_user_id.trim() == 'bgvdone'){
                            $("#updateCandidateBGVModal .frmSaveButton").hide();
                            $(".frmBGVCandidate #bgvdat").html("<p>Background Verification done , document not found.</p>");
                        }else{*/

                            $('.frmBGVCandidate #crc_date').val('').removeAttr("disabled");
                            $('.frmBGVCandidate #address_verification_date').val('').removeAttr("disabled");

                            $('.frmBGVCandidate #uploadFile_1').css("display", "block");
                            $('.frmBGVCandidate #uploadFile_2').css("display", "block");

                            $('.frmBGVCandidate #address_verification_doc').val('').css("display", "none");
                            $('.frmBGVCandidate #crc_doc').val('').css("display", "none");

                            $('.frmBGVCandidate #crc_doc_view').hide();
                            $('.frmBGVCandidate #address_verification_doc_view').hide();
                            
                            $("#updateCandidateBGVModal .frmSaveButton").show();

                            

                        //}

                   
                }else{

                     for (var i in json_obj) {

                        
                        $('.frmBGVCandidate #crc_date').val(json_obj[i].crc_date).prop( "disabled", true);
                        $('.frmBGVCandidate #address_verification_date').val(json_obj[i].address_verification_date).prop( "disabled", true);

                        $('.frmBGVCandidate #uploadFile_1').css("display", "none");
                        $('.frmBGVCandidate #uploadFile_2').css("display", "none");
                        
                        $('.frmBGVCandidate #address_verification_doc').val(json_obj[i].address_verification_doc).css("display", "block");
                        $('.frmBGVCandidate #crc_doc').val(json_obj[i].crc_doc).css("display", "block");

                        var url_address_verification_doc = '<?php echo base_url()."uploads/bgv_doc/" ?>'+json_obj[i].address_verification_doc;
                        var url_crc_doc = '<?php echo base_url()."uploads/bgv_doc/" ?>'+json_obj[i].crc_doc;

                        /*var link_crc_doc = '<a onclick=window.open("'+url_crc_doc+'"),"popUpWindow","height=500,width=400,left=100,top=100,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes"><i class="fa fa-share-square-o"></i></a>'; 

                        var link_address_verification_doc = '<a onclick=window.open("'+url_address_verification_doc+'"),"popUpWindow","height=500,width=400,left=100,top=100,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes"><i class="fa fa-share-square-o"></i></a>'; */
                        //alert(url_address_verification_doc); 

                        $('.frmBGVCandidate #crc_doc_view').show();
                        $('.frmBGVCandidate #address_verification_doc_view').show();

                        $('.frmBGVCandidate #crc_doc_view').html('<a onclick=window.open("'+url_crc_doc+'"),"popUpWindow","height=500,width=400,left=100,top=100,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes"><i class="fa fa-eye"></i></a>');

                        $('.frmBGVCandidate #address_verification_doc_view').html('<a onclick=window.open("'+url_address_verification_doc+'"),"popUpWindow","height=500,width=400,left=100,top=100,resizable=no,scrollbars=no,toolbar=no,menubar=no,location=no,directories=no,status=yes"><i class="fa fa-eye"></i></a>');

                        $("#updateCandidateBGVModal .frmSaveButton").hide();
                    } 

                        
                    
                        

                }
            },
            error: function() {
                //$('#sktPleaseWait').modal('hide');
                //alert('Something Went Wrong!');
            }
        });
        /*if (bgv == '1') {
            var bgv_by = $(this).attr("bgv_by");
            var bgv_date = $(this).attr("bgv_date");
            $("#updateCandidateBGVModal .frmSaveButton").hide();
            $(".frmBGVCandidate #bgvdat").html("<p><b>BGV</b> completed, update by " + bgv_by + " and dated " + bgv_date + "</p>");

        } else {
            $(".frmBGVCandidate #bgvdat").html('<div class="col-md-6">\
                                        <div class="form-group">\
                                                <label>Is BGV?</label>\
                                                <select class="form-control" id="is_bgv_verify" name="is_bgv_verify" required>\
                                                        <option value="">-Select-</option>\
                                                        <option value="1">Yes</option>\
                                                        <option value="2">No</option>\
                                                </select>\
                                        </div>\
                                </div>');*/

            $('.frmBGVCandidate #r_id').val(r_id);
            $('.frmBGVCandidate #c_id').val(c_id);
            //$("#updateCandidateBGVModal .frmSaveButton").show();
        //}
        $("#updateCandidateBGVModal").modal('show');
    });




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


$('#uploadFile_1').change(function () {    
            //var ext = this.value.match(/\.(.+)$/)[1];
            var fileName = $(this).val();
            const fileSize = this.files[0].size / 1024 / 1024; // in MiB
            if (fileSize > 5) {
                alert('File size exceeds 5 MB');
                this.value = '';
            }
              else {
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

        $('#uploadFile_2').change(function () {    
            //var ext = this.value.match(/\.(.+)$/)[1];
            var fileName = $(this).val();
            const fileSize = this.files[0].size / 1024 / 1024; // in MiB
            if (fileSize > 5) {
                alert('File size exceeds 5 MB');
                this.value = '';
            }
              else {
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
    
    

</script>
