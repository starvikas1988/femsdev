<script src="<?php echo base_url('libs/bower/jquery-validate/jquery.validate.min.js')?>"></script>
<script src="<?php echo base_url('libs/bower/jquery-validate/additional-methods.min.js')?>"></script>
<script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script type="text/javascript">
    $( ".new-parameter-row-position" ).sortable({
    	items: '.sortable-field',
        delay: 150,
        stop: function() {
            var selectedData = new Array();
            $('.new-parameter-row-position .sortable-field').each(function() {
                selectedData.push($(this).attr("id"));
            });
            // updateMainMenuOrder(selectedData);
        }
    });
function change(sheet) {
   $('.sheetdiv').hide();
   $("div."+sheet).show();
};

$("#audit_date").datepicker();
$("#feedback_date").datepicker();
$("#audit_date_time").datetimepicker();
$("#call_date_time").datetimepicker();
$("#email_date_time").datetimepicker();
$("#from_date").datepicker();
$("#to_date").datepicker();
$("#call_duration").timepicker({
    timeFormat: 'HH:mm:ss'
});

$("#agent_disposition").select2();
$("#correct_disposition").select2();
$("#qa_id").select2();
$("#agent_id").select2();
$("#process").select2();
$("#campaign").select2();
$("#lob_camp_dispo").select2();
$("#lob_camp_sub_dispo").select2();
$("#audit_type").select2();

$("#process_id").select2();
$("#audit_sheet_process_id").select2();
$("#select_lob").select2();
$("#select_campaign").select2();

$(function(){
    
    var ignoreInput = [];

    $(document).on('click','.go-to-step-2',function(){
        if($('#audit_sheet_name,#audit_sheet_client_id,#audit_sheet_process_id').valid()){

            params = {
                btnCount: 2,
                btnText:['<i class="fas fa-chevron-left"></i>&nbsp;Previous','Preview&nbsp;<i class="fas fa-chevron-right"></i>'],
                btnClass: ["btn btn-warning go-to-step-1",'btn btn-success go-to-step-3'],
                attribute:['type="button"','type="submit"']
            }
            next_previous_button(params);

            $('#step-2').show();
            $('#step-1').hide();

            // $('.previous-btn').show();
            // $(this).hide();
            // $(this).attr('type','button');
            // $('.preview-btn').show();
            // $('.preview-btn').attr('type','submit');
        }
    });

    $(document).on('click','.go-to-step-1',function(){
        $('#step-2').hide();
        $('#step-1').show();

        params = {
                btnCount: 1,
                btnText:['Next&nbsp;<i class="fas fa-chevron-right"></i>'],
                btnClass: ["btn btn-success go-to-step-2"],
                attribute:['type="submit"']
            }
        next_previous_button(params);

        // $(this).hide();
        // $('.next-btn').removeAttr('type');

        // $('.next-btn').show();
        // $('.preview-btn').hide();
    });

    $(document).on('click','.back-from-preview',function(){

        $(".ui-sortable").sortable("enable");
        $('#choose-header-section').show();
        $('#addButtonRow .add-field').show();

        $('.remove-field').each(function(key,value){
            $(this).show();
        });

        e = document.forms["auditSheetCreateForm"].querySelectorAll('input,select,textarea');
        for (var i = 0; i < e.length; i++) {
            $('#auditSheetCreateForm input,select,textarea').prop("disabled", false);
        }

        $("select[name^='edit_comment_type']").each(function(key,value){
            
            $(this).val() == '0' ? $(this).prop('disabled',true) : '';
        });

        $("#audit_sheet_process_id").prop('disabled',true);
        $("#select_lob").prop('disabled',true);
        $("#select_campaign").prop('disabled',true);
    });

    $(document).on('click','.go-to-step-3',function(){
        if($("#auditSheetCreateForm").valid()){

            $(".ui-sortable").sortable("disable");

            params = {
                btnCount: 2,
                btnText:['<i class="fas fa-edit"></i>&nbsp;Edit','<i class="fas fa-pencil-alt"></i>&nbsp;Save Changes'],
                btnClass: ["btn btn-warning back-from-preview go-to-step-2","btn btn-success"],
                attribute:['type="button"','type="submit"']
            }
            next_previous_button(params);

            $('#participantTable > tbody').removeClass('new-parameter-row-position')
            $('.remove-field').each(function(key,value){
                $(this).hide();
            })
            e = document.forms["auditSheetCreateForm"].querySelectorAll('input,select,textarea');
            for (var i = 0; i < e.length; i++) {
                $('#auditSheetCreateForm input,select,textarea').prop("disabled", true);
            }
            $('#step-1').show();
            $('#choose-header-section').hide();
            $('#addButtonRow .add-field').hide();
        }
    });

    const next_previous_button = (params) => {
        
        const {btnCount,btnText,btnClass,attribute} = params;
        let html = ``;
        for (let i = 0; i < btnCount; i++) {
            
            html += `<button class="${btnClass[i]}" ${attribute[i]}>${btnText[i]}</button>&nbsp;`;
        }
        $('#next-back-previous-btns').html(html);
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

    
    $(document).on('change','.comment_type',function(){
        let comment_type = $(this).val();
        let scenarioId = '';
        if(comment_type==1){

            $(this).closest('td').next('td').show();

            scenarioId = `input[name^='${$(this).closest('td').next('td').find('.scenario-type').attr('name')}']`;
            ignoreInput.push(scenarioId);

            $( scenarioId ).rules( "add", { required: true });
        }else{
            
            scenarioId = `input[name^='${$(this).closest('td').next('td').find('.scenario-type').attr('name')}']`;
            ignoreInput = ignoreInput.filter(val => val !== scenarioId);
            $( scenarioId ).rules( "remove");
            $(this).closest('td').next('td').hide();
        }
    });

    $.validator.setDefaults({
        ignore: ignoreInput
    });

    $.validator.setDefaults({
        errorClass: 'invalid-feedback',
        highlight: function(element) {
          $(element)
            $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
        },
        unhighlight: function(element) {
          $(element)
            $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
        },
        errorPlacement: function (error, element) {
          if (element.prop('type') === 'checkbox') {
            error.insertAfter(element.parent());
          } else {
            error.insertAfter(element);
          }
        }
      });

    $.extend( $.validator.prototype, {
      checkForm: function () {
        this.prepareForm();
        for (var i = 0, elements = (this.currentElements = this.elements()); elements[i]; i++) {

            $(".scenario-type").each(function(key,value){
                
                $(`#tags-0-error`).remove();
            });
            
          if (this.findByName(elements[i].name).length != undefined && this.findByName(elements[i].name).length > 1) {
            for (var cnt = 0; cnt < this.findByName(elements[i].name).length; cnt++) {
              this.check(this.findByName(elements[i].name)[cnt]);
            }
          } else {
            this.check(elements[i]);
          }
        }

        return this.valid();
      }
    });

    jQuery.validator.addMethod("specialChars", function( value, element ) {
        var regex = new RegExp("^[a-zA-Z ]+$");
        var key = value;

        if (!regex.test(key)) {
           return false;
        }
        return true;
    }, "Please use only alphabetic characters.");

    $("#auditSheetCreateForm").validate({
        rules: {
            audit_sheet_name: {
                 normalizer: function (value) {
                    return $.trim(value);
                },
                required: true,
                specialChars: true,
                minlength:3,
                // remote: {
                //     url: "<?php echo base_url('audit_sheet_dyn/check_audit_sheet_availability');?>",
                //     type: "POST"
                // }
            },
            "audit_sheet_process_id[]":{
                required: true
            },
            // "parameter_name[]":{
            //     required : true,
            // },
            // "sub_parameter_name[]":{
            //     required : true,
            // },
            // "weightage[]": {
            //     required : true,
            // },
            // "scenarioType[]": {
            //     required : true,
            // }
        },
        
        // errorPlacement: function(error, element) {
        //   var placement = $(element).data('error');
        //   if (placement) {
        //     $(placement).append(error)
        //   } else {
        //     error.insertAfter(element);
        //   }
        // },
        messages: {
            audit_sheet_name: {
                required: "Please enter your audit sheet name.",
                remote:"This audit sheet already exist."
            }
        },
        // showErrors: function(errorMap, errorList) {
        //     console.log(errorMap);
        //     console.log(errorList);
        //     $.each( this.successList , function(index, value) {
        //         $(value).popover('hide');
        //     });
        //     $.each( errorList , function(index, value) {

        //          var _popover = $(value.element).popover({
        //             trigger: 'manual',
        //             placement: 'top',
        //             content: value.message,
        //             template: '<div class="popover"><div class="arrow"></div><div class="popover-inner"><div class="popover-content"></div></div></div>'
        //         });
        //          _popover.data('bs.popover').options.content = value.message;
        //          $(value.element).popover('show');
        //     });
        // },
        submitHandler: function (form) {

            e = document.forms["auditSheetCreateForm"].querySelectorAll('input,select,textarea');
            for (var i = 0; i < e.length; i++) {
                $('#auditSheetCreateForm input,select,textarea').prop("disabled", false);
            }
            makeInputNameUnique();

            $.confirm({
                title: 'Alert',
                content: 'Are you sure, you want to create this audit sheet?',
                icon: 'fa fa-warning',
                animation: 'scale',
                type: 'red',
                closeAnimation: 'zoom',
                typeAnimated: true,
                buttons: {
                    confirm: {
                        text: 'Yes, sure!',
                        btnClass: 'btn-red',
                        action: function(){
                            form.submit();
                        }
                    },
                    cancel: function(){

                        for (var i = 0; i < e.length; i++) {
                            $('#auditSheetCreateForm input,select,textarea').prop("disabled", true);
                        }
                    }
                }
            });
        }
    });

    const makeEditInputNameUnique = () => {

        $("input[name^='edit_parameter_name']").each(function(key,value){
            
            $(this).rules("add", {
                normalizer: function (value) {
                    return $.trim(value);
                },
               required: true,
               // pattern:"^[a-zA-Z0-9 ]+$",
               // messages: {
               //   pattern:"Do not use any special characters",
               // }
             });
        });

        $("input[name^='edit_sub_parameter_name']").each(function(key,value){
            
           $(this).rules("add", {
                normalizer: function (value) {
                    return $.trim(value);
                },
               required: true,
               // pattern:"^[a-zA-Z0-9 ]+$",
               // messages: {
               //   pattern:"Do not use any special characters",
               // }
             });
        });

        // $("input[name^='edit_weightage']").each(function(key,value){
            
        //     $(this).attr('name', `edit_weightage[${key}]`);
        //     $(`label[for='edit_weightage[${key}]']`).remove();
        //     $(this).removeClass('is-invalid');
        //     $(this).removeClass('is-valid');
        // });

        $("input[name^='edit_scenario_data']").each(function(key,value){
            
            $(this).attr('id', `edit-scenario-tags-${key}`);
            $(this).attr('data-role', `tagsinput`);
            $(this).tagsinput('items');

            // $(this).attr('name', `edit_scenario_data[${key}]`);
            // $(`label[for='edit_scenario_data[${key}]']`).remove();
            // $(this).removeClass('is-invalid');
            // $(this).removeClass('is-valid');
        });
    }

    makeEditInputNameUnique();

    const getLobsAsPerProcess = async(params) =>{

        const {processId} = params;

        try{
            await $.ajax({
                url:"<?php echo base_url("audit_sheet_dyn/get_lob_as_per_process")?>",
                type:"get",
                data:{ processId },
                dataType:"json",
                success:function(response){
                    if(response.lobs?.length > 0){
                        const {lobs} = response;
                        $("#select_lob").html(`<option value="" selected disabled>Select LOB</option>`);
                        lobs.map((lob, index)=>(
                            $("#select_lob").append(`<option value="${lob.lob_id}">${lob.lob_name}</option>`)
                        ))
                    }
                }
            })
        }catch(e){
            // console.log(e)
        }
    }

    const getCampaignsAsPerLob = async(params) =>{

        const {lobId} = params;

        try{
            await $.ajax({
                url:"<?php echo base_url("audit_sheet_dyn/get_campaign_as_per_lob")?>",
                type:"get",
                data:{ lobId },
                dataType:"json",
                success:function(response){
                    if(response.campaigns?.length > 0){
                        const {campaigns} = response;
                        $("#select_campaign").html(`<option value="" selected disabled>Select Campaign</option>`);
                        campaigns.map((campaign, index)=>(
                            $("#select_campaign").append(`<option value="${campaign.campaign_id}">${campaign.locampaigname}</option>`)
                        ))
                    }
                }
            })
        }catch(e){
            // console.log(e)
        }
    }

    $(document).on('change','#audit_sheet_process_id',function(){

        let processId = $(this).val();
        getLobsAsPerProcess({processId});
    });


    $(document).on('click','#audit-sheet-list-show-btn',function(){

        getAllAuditSheetList();
    });

    const getAllAuditSheetList = async() =>{

       $.ajax({
            type: "GET",
            url: '<?php echo base_url("audit_sheet_dyn/get_all_audit_sheet_list");?>',
            dataType: "json",
            beforeSend: function(){
               $("#audit-sheet-list").html(`<tr><td colspan="7" class="text-center text-bold" style="text-align: center !important;"><i class="fas fa-spinner fa-spin"></i>&nbsp;Please Wait..</td></tr>`);
            },
            success: function (response) {
                let html = "";
                let row = 0;
                let basePath = '<?php echo base_url()?>';
                if (response.data.length != 0) {
                    for (const [key, item] of Object.entries(response.data)) {
                    
                        
                        row = parseInt(key) + 1;
                        html += `<tr> 
                                      <td>${row}</td>
                                      <td align="center">${item.audit_sheet_name}</td>
                                      <td align="center">${item.process_name !=null ? item.process_name : '-'}</td>
                                      <td align="center">${item.lob_name!=null ? item.lob_name : '-'}</td>
                                      <td align="center">${item.campaign_name!=null ? item.campaign_name : '-'}</td>
                                      <td align="center">${item.audit_sheet_created_by}</td>
                                      <td align="center">

                                            <a class="btn btn-info btn-sm" href="${basePath}audit_sheet_dyn/edit_sheet/${item.dpam_id}" ${item.qa_defect_id == 0 || item.format_id == 0 ? 'disabled onclick="return false;"' : ''}><i class="fas fa-edit"></i>&nbsp;Edit</a>

                                            <button class="btn btn-${item.qa_defect_is_active == 1 ? 'success' : 'danger'} btn-sm ${item.qa_defect_is_active == 1 ? 'make-in-active-auditsheet' : 'make-active-auditsheet'}" defectId="${item.qa_defect_id}">${item.is_active == 1 ? '<i class="fas fa-check"></i>&nbsp;Active' : '<i class="fas fa-ban"></i>&nbsp;Inactive'}</button>

                                            <a class="btn btn-warning btn-sm" href="${basePath}qa_audit_dyn/add_edit_audit/0/${item.qa_defect_id}"><i class="fas fa-eye"></i>&nbsp;View</a>

                                      </td>
                                  </tr>`;
                    }
                } else {

                    html = `<tr>
                              <td colspan="7" class="text-center text-bold" style="text-align: center !important;">No Data Available</td>
                            </tr>`;
                }

                $("#audit-sheet-list").html(html);
            }
        });
    }

    $(document).on('click','.make-in-active-auditsheet',function(){
        
        let defectId = $(this).attr('defectId');
        $(this).html(`<i class="fas fa-spinner fa-spin"></i>&nbsp;Wait..`);
        change_audit_sheet_active_in_active_status({defectId,status:0});
    });

    $(document).on('click','.make-active-auditsheet',function(){

        let defectId = $(this).attr('defectId');
        $(this).html(`<i class="fas fa-spinner fa-spin"></i>&nbsp;Wait..`)
        change_audit_sheet_active_in_active_status({defectId,status:1});
    });

    const change_audit_sheet_active_in_active_status = (params) =>{

        const {defectId,status} = params;

        $.ajax({
            url:"<?php echo base_url("audit_sheet_dyn/change_audit_sheet_active_in_active_status")?>",
            type:"POST",
            data:{ defectId,status },
            dataType:"json",
            success:function(response){
                if(response.success){

                    show_toast_notification({text:response.msg,heading:'Success',icon:'success',position:'bottom-right'});    
                }
                else
                {
                    show_toast_notification({text:response.msg,heading:'Error',icon:'error',position:'bottom-right'});
                }

                getAllAuditSheetList();
            }
        })
    }
});

</script>