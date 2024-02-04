<script src="<?php echo base_url('libs/bower/jquery-validate/jquery.validate.min.js')?>"></script>
<script src="<?php echo base_url('libs/bower/jquery-validate/additional-methods.min.js')?>"></script>
<script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('libs/bower/jquery-toast-plugin/js/jquery.toast.js');?>"></script>
<script type="text/javascript">

$(document).ready(function() {
    if (window.location.href.indexOf("add_header") > -1) {
        $('#addheaderModel').modal('show');
    }
    const show_toast_notification = (params) =>{

const { text,heading,icon,position } = params;

$.toast({
    text: text, // Text that is to be shown in the toast
    heading: heading, // Optional heading to be shown on the toast
    icon: icon, // Type of toast icon
    showHideTransition: 'fade', // fade, slide or plain
    allowToastClose: true, // Boolean value true or false
    hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
    stack: 1, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
    position: position, // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
    textAlign: 'left',  // Text alignment i.e. left, right or center
    loader: true,  // Whether to show loader or not. True by default
    loaderBg: '#9EC600',  // Background color of the toast loader
    beforeShow: function () {}, // will be triggered before the toast is shown
    afterShown: function () {}, // will be triggered after the toat has been shown
    beforeHide: function () {}, // will be triggered before the toast gets hidden
    afterHidden: function () {}  // will be triggered after the toast has been hidden
});
}

const getHeaderTable = () =>{
        $.ajax({
            type: "GET",
            url: '<?php echo base_url("qa_audit_dyn/get_header_table_data");?>',
            dataType: "json",
            beforeSend: function(){
               $("#header_data_list").html(`<tr><td colspan="15" class="text-center text-bold" style="text-align: center !important;"><i class="fas fa-spinner fa-spin"></i>&nbsp;Please Wait..</td></tr>`);
            },
            success: function (response) {
                let html = "";
                let row = 0;

                if (response.data.length != 0) {
                    for (const [key, item] of Object.entries(response.data)) {
                    
                        
                        row = parseInt(key) + 1;
                        html += `<tr> 
                                      <td>${row}</td>
                                      <td align="center">${item.name}</td>
                                      <td align="center">${item.field_type}</td>
                                      <td align="center">${item.input_type}</td>
                                      <td align="center">${item.dropdown_values!=null ? item.dropdown_values : '-'}</td>
                                      <td align="center">${item.id_string}</td>
                                      <td align="center">${item.value_variable}</td>
                                      <td align="center">
                                      <span style='margin-left:5px; font-size:10px;' class='btn btn-${item.is_disabled == 1 ? 'dark' : 'primary'} btn-sm'>${item.is_disabled == 1 ? '<i class="fas fa-check"></i>&nbsp;Yes' : '<i class="fas fa-ban"></i>&nbsp;No'}</span></td>
                                      <td align="center">
                                      <button class="btn btn-${item.is_required_field == 1 ? 'success' : 'danger'} btn-sm is_required" pid="${item.id}" req_stat="${item.is_required_field}">${item.is_required_field == 1 ? '<i class="fas fa-check"></i>&nbsp;Required' : '<i class="fas fa-ban"></i>&nbsp;Not Required'}</button></td>
                                      <td align="center">
                                      <span style='margin-left:5px; font-size:10px;' class='btn btn-${item.is_create_header_column == 1 ? 'warning' : 'info'} btn-sm'>${item.is_create_header_column == 1 ? '<i class="fas fa-check"></i>&nbsp;Yes' : '<i class="fas fa-ban"></i>&nbsp;No'}</span></td>
                                      <td align="center">${item.column_name!=null ? item.column_name : '-'}</td>
                                      <td align="center">${item.column_type!=null ? item.column_type : '-'}</td>
                                      <td align="center">
                                      <button class="btn btn-${item.is_active == 1 ? 'success' : 'danger'} btn-sm active_inactive" pid="${item.id}" current_stat="${item.is_active}">${item.is_active == 1 ? '<i class="fas fa-check"></i>&nbsp;Active' : '<i class="fas fa-ban"></i>&nbsp;Inactive'}</button>
                                      </td>
                                      
                                      <td width="200px" align="center">
                                            <button class="btn btn-info edit_header" pid="${item.id}" ><i class="fas fa-edit"></i>&nbsp;Edit Header</button>

                                            <button class="btn btn-danger btn-sm headerDelete" title="Delete header" pid="${item.id}" disabled><i class='fa fa-trash' aria-hidden='true'></i></i>&nbsp;Delete</button>

                                      </td>
                                  </tr>`;
                    }
                } else {

                    html = `<tr>
                              <td colspan="7" class="text-center text-bold" style="text-align: center !important;">No Data Available</td>
                            </tr>`;
                }

                $("#header_data_list").html(html);
            }
        });
    }
    getHeaderTable();

 //////////////////// Delete Audit ////////////////////////////
    $(document).on('click','.headerDelete',function(){
        $(this).html(`<i class="fas fa-spinner fa-spin"></i>&nbsp;Wait..`)
        var pid = $(this).attr("pid");
        var title = $(this).attr("title");
        var URL = '<?php echo base_url();?>qa_audit_dyn/header_delete';
        var ans = confirm('Are you sure to ' + title + " ?");
        if (ans == true) {
            $.ajax({
                type: 'POST',
                url: URL,
                data: 'pid=' + pid,
                dataType:"json",
                success:function(response){
                if(response.success){

                    show_toast_notification({text:response.msg,heading:'Success',icon:'success',position:'bottom-right'});    
                }
                else
                {
                    show_toast_notification({text:response.msg,heading:'Error',icon:'error',position:'bottom-right'});
                }

                getHeaderTable();
            }
            });
        }
    });

    //////////////////// Active Inactive ////////////////////////////
    $(document).on('click','.active_inactive',function(){
        $(this).html(`<i class="fas fa-spinner fa-spin"></i>&nbsp;Wait..`)
        let pid = $(this).attr("pid");
        let current_stat = $(this).attr("current_stat");
        var URL = '<?php echo base_url();?>qa_audit_dyn/InactiveHeader';
            $.ajax({
                type: 'POST',
                url: URL,
                data: { pid,current_stat},
                dataType:"json",
                success:function(response){
                if(response.success){

                    show_toast_notification({text:response.msg,heading:'Success',icon:'success',position:'bottom-right'});    
                }
                else
                {
                    show_toast_notification({text:response.msg,heading:'Error',icon:'error',position:'bottom-right'});
                }

                getHeaderTable();
            }
            });
    });
     //////////////////// Mandatory ////////////////////////////
    $(document).on('click','.is_mandatory',function(){
        $(this).html(`<i class="fas fa-spinner fa-spin"></i>&nbsp;Wait..`)
        var pid = $(this).attr("pid");
        var mand_stat = $(this).attr("mand_stat");
        var URL = '<?php echo base_url();?>qa_audit_dyn/mandatory';
            $.ajax({
                type: 'POST',
                url: URL,
                data: { pid,mand_stat },
                dataType:"json",
                success:function(response){
                if(response.success){

                    show_toast_notification({text:response.msg,heading:'Success',icon:'success',position:'bottom-right'});    
                }
                else
                {
                    show_toast_notification({text:response.msg,heading:'Error',icon:'error',position:'bottom-right'});
                }

                getHeaderTable();
            }
            });
    });
     //////////////////// Required field ////////////////////////////
    $(document).on('click','.is_required',function(){
        $(this).html(`<i class="fas fa-spinner fa-spin"></i>&nbsp;Wait..`)
        var pid = $(this).attr("pid");
        var req_stat = $(this).attr("req_stat");
        var URL = '<?php echo base_url();?>qa_audit_dyn/required_field';
        $.ajax({
            type: 'POST',
            url: URL,
            data: { pid,req_stat },
            dataType:"json",
            success:function(response){
            if(response.success){

                show_toast_notification({text:response.msg,heading:'Success',icon:'success',position:'bottom-right'});    
            }
            else
            {
                show_toast_notification({text:response.msg,heading:'Error',icon:'error',position:'bottom-right'});
            }

            getHeaderTable();
        }
            });
    });
    $('.dr_value').hide();
    
    $('.db_column_name').hide();
    $('.db_column_type').hide();
    $('#field_type').on('change', function() {
        if ($(this).val() == 'dropdown') {
            $('.dr_value').show();
            $('#dropdown_values').attr('required', true);
        } else {
            $('.dr_value').hide();
            $('#dropdown_values').attr('required', false);
        }
    });
    $('#auditor_type').attr('required', false);
    $('#is_create_header_column').on('change', function() {
        if ($(this).val() == 1) {
            $('.db_column_name').show();
            $('.db_column_type').show();
        } else {
            $('.db_column_name').hide();
            $('.db_column_type').hide();
        }
    });

     //////////////////// Edit header ////////////////////////////
    $(document).on('click','.edit_header',function(){
    $('#addheaderModel').modal('show');
        var pid = $(this).attr("pid");
        $('#header_id').val(pid);
        var URL = '<?php echo base_url();?>qa_audit_dyn/edit_header';
            $.ajax({
                type: 'POST',
                url: URL,
                data: 'pid=' + pid,
                success: function(data) {
                    const obj = JSON.parse(data);
                    $("#client_id").val(obj.client_id);
                    $("#header_name").val(obj.name);
                    $('#field_type').val(obj.field_type);
                    if (obj.field_type == 'dropdown') {
                        $('.dr_value').show();
                        $('#dropdown_values').attr('required', true);
                    } else {
                        $('.dr_value').hide();
                        $('#dropdown_values').attr('required', false);
                    }
                    $('#input_type').val(obj.input_type);
                    $('.dr_value input').val(obj.dropdown_values);
                    //$('#dropdown_values').val(obj.dropdown_values);
                    $('#id_string').val(obj.id_string);
                    $('#value_variable').val(obj.value_variable);
                    $('#is_mandatory').val(obj.is_mandatory);
                    $('#is_required_field').val(obj.is_required_field);
                    $('#is_disabled').val(obj.is_disabled);
                    $('#is_create_header_column').val(obj.is_create_header_column);
                    $('#column_name').val(obj.column_name);
                    $('#column_type').val(obj.column_type);
                    $('#is_active').val(obj.is_active);
                    //console.log(obj.name);
                }
            });
    });

$('#addheaderModel').on('hidden.bs.modal', function(e) {
  $(this).find('#headerform')[0].reset();
});

const checkDuplicateValue = async(params) =>{

const {headerName} = params;


try{
    await $.ajax({
        url:"<?php echo base_url("qa_audit_dyn/chkDuplicateHeader")?>",
        type: 'POST',
        data:{ headerName },
        dataType:"json",
        success:function(response){
            const {data} = response;
            if(data > 0){
                //show_toast_notification({text:'This header is already exists',heading:'Error',icon:'error',position:'bottom-right'});
                alert("This header is already exists")
                $('#addheaderModel').find('#headerform')[0].reset();
                return false;
            }else{
                return true;
            }
        }
    })
}catch(e){
    // console.log(e)
}
}

$('#header_name').blur(function() {
  let headerString = $(this).val();
  let headerNamelc = headerString.toLowerCase();
  let headerName = headerNamelc.replaceAll(" ", "_");
  checkDuplicateValue({ headerName })
  $('#id_string').val(headerName)
  $('#value_variable').val(headerName)
  $('#is_create_header_column').val('1')
  $('.db_column_name').show();
  $('.db_column_type').show();
  $('#column_name').val(headerName)
  $('#column_type').val('varchar(255) DEFAULT NULL')
  $('#is_active').val('1')
  $('#is_disabled').val('0')
  $('#is_mandatory').val('0')
});


});
function blockSpecialChar(e){
    var k;
    document.all ? k = e.keyCode : k = e.which;
    return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
    }
</script>