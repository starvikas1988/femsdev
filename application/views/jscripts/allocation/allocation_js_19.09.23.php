<script>
    setTimeout(function() {
        $(".alert").fadeOut("slow");
    }, 5000);
function changestatus(id) {    
    var status = $('#description_status'+ id).val();   
      swal({
           title: 'Are You Sure to change the status?',
            text: "",
            type: 'warning',
            showConfirmButton:false,
            confirmButtonText: 'Yes, delete it!'
  
        })
        .then((willDelete) => {
          if (willDelete) {
            $('#sktPleaseWait').modal('show');
                $.ajax({
                type: 'POST',
                url: "<?php echo base_url('allocation/change_status'); ?>",
                data: 'id=' + id + '&status=' + status,
                success: function(data) {   
                  if(data==1)
                  {
                    $('#cost_status').text('Active');
                  }
                  else{$('#cost_status').text('In-Active');}
                  $('#sktPleaseWait').modal('hide');
                  $("#sktPleaseWait").removeClass("show"); 
                  $('#description_status'+ id).val(data.trim());   
                  alert('Status updated successfully');
                },
                error: function() {                
                    alert('Something Went Wrong!');
                }
            }); 
          } 
        });    
  }
  function changesbustatus(id) {    
    var status = $('#sbu_status'+ id).val();   
      swal({
            title: 'Are You Sure to change the status?',
            text: "",
            type: 'warning',
            showConfirmButton:false,
            confirmButtonText: 'Yes, delete it!'
        })
        .then((willDelete) => {
          if (willDelete) {
            $('#sktPleaseWait').modal('show');
                $.ajax({
                type: 'POST',
                url: "<?php echo base_url('allocation/change_sbu_status'); ?>",
                data: 'id=' + id + '&status=' + status,
                success: function(data) { 
                    if(data==1)
                  {
                    $('#sbu_status').text('Active');
                  }
                  else{$('#sbu_status').text('In-Active');}  
                  $('#sktPleaseWait').modal('hide');
                  $("#sktPleaseWait").removeClass("show"); 
                  $('#sbu_status'+ id).val(data.trim());   
                  alert('Status updated successfully');
                },
                error: function() {                
                    alert('Something Went Wrong!');
                }
            }); 
          } 
        });    
  }

  function changeallostatus(id,status) { 
      swal({
           title: 'Are You Sure to change the status?',
            text: "",
            type: 'warning',
            showConfirmButton:false,
            confirmButtonText: 'Yes, delete it!'
  
        })
        .then((willDelete) => {
          if (willDelete) {
            $('#sktPleaseWait').modal('show');
                $.ajax({
                type: 'POST',
                url: "<?php echo base_url('allocation/change_allocation_status'); ?>",
                data: 'id=' + id + '&status=' + status,
                success: function(data) {  
                    //alert(data);
                  $('#sktPleaseWait').modal('hide');
                  $("#sktPleaseWait").removeClass("show"); 
                  $('#allocation_status'+ id).val(data.trim());   
                  alert('Status updated successfully');
                  location.reload();
                },
                error: function() {                
                    alert('Something Went Wrong!');
                }
            }); 
          } 
        });    
  }
























$(document).on('change','#gio_region',function(){
	var datas = {"regions_name": $(this).val()};
	var request_url = "<?php echo base_url('mwp_qa_dashboard/get_regions_location_list'); ?>";

	process_ajax(function(response)
	{
		var res = JSON.parse(response);
		if (res.stat==true) {
			//let options_html = "<option value=''>All</option>";
			let options_html = "";

			$('#office_location_filter').multiselect('clearSelection');
	    	$('#office_location_filter').multiselect('refresh');

            $.each(res.datas,function(index,element) {
                options_html += '<option value="'+element.abbr+'">'+element.office_name+'</option>';
            });

            $('#office_location_filter').html(options_html);
		}
		else {
			if (res.nothing_selected) { alert(res.errmsg); }
			$('#office_location_filter').html(''); 
		}

		$('#office_location_filter').multiselect('rebuild');

	},request_url, datas, 'text');
});




function editcost(id){
	
  $('#editbtn').removeAttr("disabled");
  var params=$('#costedit'+id).attr("params");
  var rid=$('#costedit'+id).attr("rid");
  var arrPrams = params.split("#"); 
 // alert(arrPrams);
  $('#rid').val(rid);
  $('#edit_cost').val(arrPrams[0]);
  $('#edit_allocation').modal('show');
}


function editsbu(id){
	
    $('#editbtn').removeAttr("disabled");
    var params=$('#sbuedit'+id).attr("params");
    var rid=$('#sbuedit'+id).attr("rid");
    var arrPrams = params.split("#"); 
    $('#edit_sbu_val').val(rid);
    $('#edit_sbu').val(arrPrams[0]); 
    $('#edit_client_sbu').val(arrPrams[1]);
    $('#edit_allocation').modal('show');
  }

  $('#edit_client_sbu').change(function(){
    var client = $(this).val();
    $('#sktPleaseWait').modal('show');
                $.ajax({
                type: 'POST',
                url: "<?php echo base_url('allocation/check_client'); ?>",
                data: 'client_id=' + client,
                success: function(data) {   

                   // alert(data);
                  $('#sktPleaseWait').modal('hide');
                  $("#sktPleaseWait").removeClass("show"); 
                 if(data == 1) 
                 {
                    $('#error_msg').text('Please select another client');
                    $('#edit_client_sbu').val('');
                 }
                 else
                 {
                    $('#error_msg').text('');
                 }
                  
                },
                error: function() {                
                    alert('Something Went Wrong!');
                }
            }); 

});



function DownloadFile(e) {
            var url = e.getAttribute('data-url');
        //    alert(url);
             var fileName = url.match(/([^\/]*)\/*$/)[1];
             $.ajax({
                 url: url,
                 cache: false,
                 xhr: function () {
                     var xhr = new XMLHttpRequest();
                     xhr.onreadystatechange = function () {
                         if (xhr.readyState == 2) {
                             if (xhr.status == 200) {
                                 xhr.responseType = "blob";
                             } else {
                                 xhr.responseType = "text";
                             }
                         }
                     };
                     return xhr;
                 },
                 success: function (data) {
                     var blob = new Blob([data], { type: "application/octetstream" });
                     var isIE = false || !!document.documentMode;
                     if (isIE) {
                         window.navigator.msSaveBlob(blob, fileName);
                     } else {
                         var url = window.URL || window.webkitURL;
                         link = url.createObjectURL(blob);
                         var a = $("<a />");
                         a.attr("download", fileName);
                         a.attr("href", link);
                         $("body").append(a);
                         a[0].click();
                         $("body").remove(a);
                   }
                 }
             });
         };




    const realFileBtn = document.getElementById("real-file");
    const customBtn = document.getElementById("custom-button");
    const customTxt = document.getElementById("custom-text");

    customBtn.addEventListener("click", function() {
        realFileBtn.click();
    });

    realFileBtn.addEventListener("change", function() {
        $("#submit").removeAttr("style");
        if (realFileBtn.value) {
            customTxt.innerHTML = realFileBtn.value.match(
                /[\/\\]([\w\d\s\.\-\(\)]+)$/
            )[1];
        } else {
            customTxt.innerHTML = "No file chosen, yet.";
        }
    });



    $( "#transfer_submit" ).on( "click", function() {
        var fusion_id= $('#fusion_id').val();
        $('#trns_fusion_id').val(fusion_id);  
    $('#sktPleaseWait').modal('show');
                $.ajax({
                type: 'POST',
                url: "<?php echo base_url('allocation/check_tranfer_fusion_id'); ?>",
                data: 'fusion_id=' + fusion_id,
                success: function(data) {   
                    //alert(data);
                $("#tranfer_div").removeAttr("style");
                 $('#sktPleaseWait').modal('hide');
                  $("#sktPleaseWait").removeClass("show"); 
                  $('#oh_cogs').css('pointer-events','none'); 
                  $('#oh_non_cogs').css('pointer-events','none'); 
                 if(data == 1) 
                 {
                    $('#oh_cogs').val('1');
                    $('#oh_non_cogs').val('2');
                    $('#error_msg').text("");
                 }
                 else if(data == 3)
                 {
                    
                    $("#fusion_id").val('');
                    $("#tranfer_div").hide();
                    $('#error_msg').text("Enter valid Fusion ID");

                 }
                 else if(data == 0)
                 {
                    
                    $("#fusion_id").val('');
                    $("#tranfer_div").hide();
                    $('#error_msg').text("Fusion ID not Transferable");

                 }
                 else
                 {
                    $('#oh_cogs').val('2');
                    $('#oh_non_cogs').val('1');
                    $('#error_msg').text("");
                 }
                  
                 },
                error: function() {                
                    alert('Something Went Wrong!');
                }
            }); 
} );

    //billable non-billable start

    function get_employee_data(){
        var fusion_id= $('#fusion_id').val(); 
        $('#fusion_id').css('border-color', ''); 
        if(fusion_id != ''){
            $.post("<?php echo base_url('allocation/check_fusion_id_for_billable_non_billable'); ?>", {
                fusion_id: fusion_id
                }).done(function (res) {
                        $('#billable_non_billable_transfer_datatable').html(res);                    
                });
        }else{
            $('#fusion_id').css('border-color', 'red'); 
        }
    }

    function indivitual_data_transfer(user_id){
            $(".after_success").hide();
            $(".modal-footer").show();
            $(".before_success").show();          
            $('#myModal').modal('show');
            // Iterate through all checkboxes with the "checkbox" class
            var checkedValues = [];            
            checkedValues.push(user_id); // Push the data into the array
            
            $("#confimationclick").click(function () {
                $(".before_success").hide();                
                $.post("<?php echo base_url('allocation/insert_transfer_for_billable_non_billable'); ?>", {
                    user_ids: checkedValues
                }).done(function (res) {                                  
                    $(".after_success").show();                 
                        if(res != ''){
                            get_employee_data();
                            checkedValues = [];
                        } 
                });              
                $(".modal-footer").hide();
            });                  
    } 


    function clear_row(remove_id){        
        var fusion_id= $('#fusion_id').val(); 
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('allocation/clear_billable_non_billable_indiviual_row'); ?>",
            data: { input_string: fusion_id, remove_id: remove_id },
            success: function(response) { 
                if(response.trim() != 0){                       
                    $("#fusion_id").val(response.trim());
                    get_employee_data();
                }else if(response.trim() == ''){                    
                    $("#fusion_id").val(response.trim());
                    $.post("<?php echo base_url('allocation/check_fusion_id_for_billable_non_billable'); ?>", {
                    fusion_id: ',,'
                    }).done(function (res) {
                            $('#billable_non_billable_transfer_datatable').html(res);                    
                    });
                }              
            }
        });
    }

    function multiple_data_transfer(){
            $(".after_success").hide();
            $(".modal-footer").show();
            $(".before_success").show();          
            $('#myModal').modal('show');
            // Iterate through all checkboxes with the "checkbox" class
            var checkedValues = [];
            $(".checkbox:checked").each(function() {
                var checkboxDataValue = $(this).val(); // Get the value
                checkedValues.push(checkboxDataValue); // Push the data into the array
            });
            
            $("#confimationclick").click(function () {
                $(".before_success").hide();                
                $.post("<?php echo base_url('allocation/insert_transfer_for_billable_non_billable'); ?>", {
                    user_ids: checkedValues
                }).done(function (res) {                                  
                    $(".after_success").show();                 
                        if(res != ''){
                            get_employee_data();
                            $("#show_all_transfer").hide();
                            checkedValues = [];
                        } 
                });              
                $(".modal-footer").hide();
            });                  
    }     

    //billable non-billable end

//cogs non cogs
function clear_row_cogs(remove_id){        
        var fusion_id= $('#fusion_id').val(); 
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('Allocation_humayun/clear_cogs_non_cogs_indiviual_row'); ?>",
            data: { input_string: fusion_id, remove_id: remove_id },
            success: function(response) { 
                if(response.trim() != 0){                       
                    $("#fusion_id").val(response.trim());
                    get_employee_data();
                }else if(response.trim() == ''){                    
                    $("#fusion_id").val(response.trim());
                    $.post("<?php echo base_url('Allocation_humayun/check_fusion_id_for_cogs_non_cogs'); ?>", {
                    fusion_id: ',,'
                    }).done(function (res) {
                        $('#cogs_non_cogs_transfer_datatable').html(res);                 
                    });
                }              
            }
        });
    }




    

</script>