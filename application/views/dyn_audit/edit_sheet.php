<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<link rel="stylesheet" href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
<link rel="stylesheet" href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link rel="stylesheet" href="<?php echo base_url('libs/bower/font-awesome/css/font-awesome-all.css')?>">
<style>
    body {
        background: #eee;
    }

    div label input {
        margin-right: 100px;
    }

    .cat {
        border: 1px solid #fff;
        overflow: hidden;
        /* float: left; */
/*        display: flex;*/
        flex-direction: column;
        margin: 0 0 0 0;
    }

    .cat label {
        float: left;
        line-height: 3.0em;
        width: 32.8%;
        background-color: #00BFFF;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.5s ease-in-out 0s;
        float: left;
        margin: 0 5px 5px 0;
    }

    .cat label:hover {
        background-color: #333c68;
        padding-left: 10px;
    }

    .cat label span {
        text-align: center;
        display: block;
    }

    .cat label input {
        position: absolute;
        display: none;
        color: #fff !important;
    }

    .cat label input+span {
        color: #fff;
    }

    .cat input:checked+span {
        color: #fff;
    }

    .action input:checked+span {
        background-color: #008000;
        border-radius: 5px;
    }

    .card_widget {
        background: #fff;
        padding: 10px;
        border-radius: 5px;
    }

    .my-3 {
        padding-top: 10px;
    }

    label {
        font-size: 14px;
        margin: 0 0 3px 0;
    }

    .form-control {
        color: #999;
    }

    .form-control:hover {
        border: 1px solid #00BFFF;
    }

    .form-control:focus {
        border: 1px solid #00BFFF;
        outline: none;
        box-shadow: none;
    }

    .repeatable {
        display: inline;
    }

    .add_btn {
        width: 35px;
        height: 35px;
        line-height: 30px;
        background: #00BFFF;
        border-radius: 50%;
        border: none;
        color: #fff;
        transition: all 0.5s ease-in-out 0s;
    }

    .add_btn:hover {
        background: #3a426a;
    }

    .clone_widget .col-sm-2 {
        width: 20%;
    }
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    /* Firefox */
    input[type=number] {
      -moz-appearance: textfield;
    }
    /*validation*/
    .invalid-feedback {
      display: none;
      width: 100%;
      margin-top: .25rem;
      font-size: .875em;
      color: #dc3545;
    }
    .form-control.is-invalid, .was-validated .form-control:invalid {
      border-color: #dc3545;
      padding-right: calc(1.5em + .75rem) !important;
/*      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");*/
      background-repeat: no-repeat;
      background-position: right calc(.375em + .1875rem) center;
      background-size: calc(.75em + .375rem) calc(.75em + .375rem);
    }
    .form-control.is-valid, .was-validated .form-control:valid {
      border-color: #28a745;
      padding-right: calc(1.5em + .75rem) !important;
/*      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");*/
      background-repeat: no-repeat;
      background-position: right calc(.375em + .1875rem) center;
      background-size: calc(.75em + .375rem) calc(.75em + .375rem);
    }
    .bootstrap-tagsinput{
          overflow: scroll;
          width: 225px;
    }
    .scenario-type ~ label {
        display: block;
    }
    .single-fixed-header-field input:checked+span {
        background-color: #333c68;
        border-radius: 5px;
    }
</style>

<div class="container">

    <form action="<?php echo base_url('audit_sheet_dyn/updateAuditSheet');?>" method="POST" id="auditSheetCreateForm" onsubmit="return false">
        <input type="hidden" name="format_id" value="<?php echo $format_id;?>">
        <input type="hidden" name="qa_defect_id" value="<?php echo $qa_defect_id;?>">
        <input type="hidden" name="existing_headers" value="<?php echo $existing_headers;?>">
        <section id="step-1">
            <div class="my-3">
                <div class="card_widget">
                    <div class="row">
                        <div class="col-sm-3">
                            <label>Audit Sheet Name</label>
                            <input type="text" class="form-control" name="audit_sheet_name" id="audit_sheet_name" value="<?php echo $dpam_data['audit_sheet_name'];?>" readonly/>
                        </div>

                        <div class="col-sm-2">
                            <label>Client</label>
                            <select id="audit_sheet_client_id" class="form-control" name="audit_sheet_client_id" readonly>
                             <option value="" selected disabled>Select Client</option>

                             <?php foreach ($client_list as $client):?>

                                <option value="<?php echo $client['client_id'];?>" <?php echo $dpam_data['client_id'] == $dpam_data['client_id'] ? 'selected' : '' ?>><?php echo $client['client_name'];?></option>

                            <?php endforeach;?>

                            </select>
                        </div>

                        <div class="col-sm-3">
                            <label>Process</label>
                            <select id="audit_sheet_process_id" class="form-control" name="audit_sheet_process_id[]" disabled multiple>
                             <?php 
                             $extracted_selected_process_id  = explode(',',$selected_process_id);
                             foreach ($process_list as $process):?>

                                <option value="<?php echo $process['process_id'];?>" <?php echo in_array($process['process_id'],$extracted_selected_process_id) ? 'selected' : '' ?>><?php echo $process['process_name'];?></option>

                            <?php endforeach;?>

                            </select>
                            <label id="audit_sheet_process_id-error" class="invalid-feedback" for="audit_sheet_process_id"></label>
                        </div>

                        <?php if(!empty($is_lob_exist) && $is_lob_exist == 1):

                                $extracted_selected_lob_id  = explode(',',$selected_lob_id);
                            ?>
                        <div class="col-sm-2">
                            <label>LOB</label>
                            <select id="select_lob" class="form-control" name="select_lob[]" disabled multiple>
                             <?php foreach ($lob_list as $lob):?>
                                <option value="<?php echo $lob['lob_id'];?>" <?php echo in_array($lob['lob_id'],$extracted_selected_lob_id) ? 'selected' : '' ?>><?php echo $lob['lob_name'];?></option>
                             <?php endforeach;?>
                            </select>
                        </div>
                        <?php endif;?>

                        <?php if(!empty($is_campaign_exist) && $is_campaign_exist == 1):

                                $extracted_selected_campaign_id  = explode(',',$selected_campaign_id);
                            ?>
                        <div class="col-sm-2">
                            <label>Campaign</label>
                            <select id="select_campaign" class="form-control" disabled name="select_campaign[]" multiple>
                             <?php foreach ($campaign_list as $campaign):?>
                                <option value="<?php echo $campaign['campaign_id'];?>" <?php echo in_array($campaign['campaign_id'],$extracted_selected_campaign_id) ? 'selected' : '' ?>><?php echo $campaign['campaign_name'];?></option>
                             <?php endforeach;?>
                            </select>
                        </div>
                        <?php endif;?>

                    </div>
                </div>
            </div>

            <div class="my-3">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card_widget">
                            <label>Fixed Header Field(Can't be changed)</label>
                            <div class="cat action fixed-header-field-area">

                                <?php foreach($headers as $header):?>
                                <label style="display: <?php echo $header['input_type'] == 'hidden' ? 'none' : '' ?>;" class="<?php echo $header['is_mandatory'] == 0 ? 'single-fixed-header-field' : '' ?>">
                                    <input type="checkbox" value="<?php echo $header['header_id'];?>" name="heading[<?php echo $header['column_name'];?>]"  <?php echo $header['is_mandatory'] == 1 || $header['is_mandatory'] == 0 ? ' checked onclick="return false"' : '' ?>><span><?php echo $header['header_name'];?></span>
                                </label>

                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="my-3">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card_widget">
                            <label>Fixed Footer Field(Can't be changed)</label>
                            <div class="cat action">
                                <label>
                                    <input type="checkbox" onclick="return false;" checked><span>Call Summary</span>
                                </label>
                                <label>
                                    <input type="checkbox" onclick="return false;" checked><span>Feedback</span>
                                </label>
                                <label>
                                    <input type="checkbox" onclick="return false;" checked><span>Upload Audio Files</span>
                                </label>
                                <label>
                                    <input type="checkbox" onclick="return false;" checked><span>Upload Screenshot Files</span>
                                </label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="my-3" id="choose-header-section">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card_widget">
                        <div class="col-sm-6">
                            <label>Choose Header Field</label>
                        </div>
                            <div class="col-sm-6">
                                <a class="btn btn-large btn-success" href="<?php echo base_url("qa_audit_dyn/header_info");?>" style="float: right;"><i class="fas fa-plus-circle"></i>&nbsp;Edit Header</a>
                            </div>
                            <div class="cat action choose-header-field-area" style="margin-top: 32px;">

                                <?php foreach($choose_headers as $header):?>
                                <label class="single-choose-header-field">
                                    <input type="checkbox" value="<?php echo $header['header_id'];?>" name="heading[<?php echo $header['column_name'];?>]"  <?php echo $header['is_mandatory'] == 1 ? ' checked onclick="return false"' : '' ?>><span><?php echo $header['header_name'];?></span>
                                </label>

                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
       
        <section id="step-2" style="display:none;">
            <div class="my-3" id="create-parameter-section">
                <div class="card_widget">
                    <label>Create Parameters</label>
                    <table class="table table-bordered table-hover" id="participantTable" style="white-space: nowrap;">
                        <tbody class="new-parameter-row-position">

                            <?php foreach ($parameters as $key => $parameter):?>

                                <tr>
                                    <td>
                                        <label>Parameter Name</label>
                                        <input name="edit_parameter_name[<?php echo $parameter['short_name'];?>]" type="text" placeholder="Parameter Name" class="required-entry form-control" value="<?php echo $parameter['parameter_name'];?>" required>
                                    </td>
                                    <td>
                                        <label>Sub Parameter Name</label>
                                        <input name="edit_sub_parameter_name[<?php echo $parameter['short_name'];?>]" type="text" placeholder="Sub Parameter Name" class="required-entry form-control" value="<?php echo $parameter['sub_parameter_name'];?>" required>
                                    </td>
                                    <td>
                                        <label>Weightage</label>
                                        <input name="edit_weightage[<?php echo $parameter['short_name'];?>]" type="number" min="0" max="100" placeholder="Weightage" class="required-entry form-control" value="<?php echo $parameter['weightage'];?>" required>
                                    </td>
                                    <td>
                                        <!-- is_scenario_active -->
                                        <label>Remarks</label>
                                        <select name="edit_comment_type[<?php echo $parameter['short_name'];?>]" class="required-entry form-control comment_type" <?php echo $parameter['comment_type'] == 0 && empty($parameter['scenario_data']) ? 'disabled' : '';?>>
                                            <option value="0" <?php echo $parameter['comment_type'] == 0 ? 'selected' : '';?>>N/A</option>
                                            <option value="1" <?php echo $parameter['comment_type'] == 1 ? 'selected' : '';?>>Dropdown Field</option>
                                            <option value="2" <?php echo $parameter['comment_type'] == 2 ? 'selected' : '';?>>Input Field</option>
                                        </select>
                                    </td>
                                    <td style="display:<?php echo $parameter['comment_type'] == 1 ? 'block' : 'none';?>;">
                                        <label>Enter Scenarion</label><br>
                                        <input type="text" name="edit_scenario_data[<?php echo $parameter['short_name'];?>]" class="form-control scenario-type" value="<?php echo $parameter['comment_type'] == 1 || !empty($parameter['scenario_data']) ? $parameter['scenario_data'] : NULL;?>">
                                    </td>

                                    <td>
                                        <label>Is Fatal Parameter</label>
                                        <select name="edit_is_fatal[<?php echo $parameter['short_name'];?>]" class="required-entry form-control">
                                            <option value="0" <?php echo $parameter['is_fatal'] == 1 ? 'selected' : '';?>>No</option>
                                            <option value="1" <?php echo $parameter['is_fatal'] == 1 ? 'selected' : '';?>>Yes</option>
                                        </select>
                                    </td>
                                    <td>
                                        <label>Status</label>
                                        <select name="is_active[<?php echo $parameter['short_name'];?>]" class="required-entry form-control">
                                            <option value="0" <?php echo $parameter['is_active'] == 1 ? 'selected' : '';?>>Inactive</option>
                                            <option value="1" <?php echo $parameter['is_active'] == 1 ? 'selected' : '';?>>Active</option>
                                        </select>
                                    </td>
                                </tr>

                            <?php endforeach;?>
                                
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-sm-12" id="addButtonRow">
                            <button class="btn btn-large btn-success add-field" type="button"><i class="fas fa-plus-circle"></i>&nbsp;Add</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="my-3">
            <div class="card_widget">
                <div class="row">
                    <div class="col-sm-12" id="next-back-previous-btns">
                        <button class="btn btn-success go-to-step-2">Next &nbsp;<i class="fas fa-chevron-right"></i></button>
                    </div>
                    
                </div>
            </div>
        </div>

    </form>

</div>

<script type="text/javascript">
    // window.onbeforeunload = function() { console.log('Back') };
    
    const makeInputNameUnique = () => {
            
        $("input[name^='parameter_name']").each(function(key,value){
            
            $(this).attr('name', `parameter_name[${key}]`);
            $(this).attr('required', true);
            $(`label[for='parameter_name[${key}]']`).remove();
            $(this).removeClass('is-invalid');
            $(this).removeClass('is-valid');

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

        $("input[name^='sub_parameter_name']").each(function(key,value){
            
            $(this).attr('name', `sub_parameter_name[${key}]`);
            $(this).attr('required', true);
            $(`label[for='sub_parameter_name[${key}]']`).remove();
            $(this).removeClass('is-invalid');
            $(this).removeClass('is-valid');

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

        $("input[name^='weightage']").each(function(key,value){
            
            $(this).attr('name', `weightage[${key}]`);
            $(this).attr('required', true);
            $(`label[for='weightage[${key}]']`).remove();
            $(this).removeClass('is-invalid');
            $(this).removeClass('is-valid');
        });

        $("input[name^='scenario_data']").each(function(key,value){
            
            $(this).attr('id', `tags-${key}`);
            $(this).attr('data-role', `tagsinput`);
            $(this).tagsinput('items');
            $(this).attr('name', `scenario_data[${key}]`);
            $(`label[for='scenario_data[${key}]']`).remove();
            $(this).removeClass('is-invalid');
            $(this).removeClass('is-valid');
        });
    }

    $(function(){

        $(document).on('click','.single-choose-header-field input',function(e){
            $(this).attr('checked',true);
            let { outerHTML } = $(this)[0];
            $('.fixed-header-field-area').append(`<label class="single-fixed-header-field"> ${ outerHTML } <span>${$(this).next('span').text()}</span></label>`);
            $(this).parent().remove();
            
            if($(".choose-header-field-area").find("*").length == 0 ) $('#choose-header-section').hide();
        });

        $(document).on('click','.single-fixed-header-field input',function(e){
            $(this).attr('checked',false);
            let { outerHTML } = $(this)[0];
            $('.choose-header-field-area').append(`<label class="single-choose-header-field"> ${ outerHTML } <span>${$(this).next('span').text()}</span></label>`);
            $(this).parent('.single-fixed-header-field').remove();

            if($(".choose-header-field-area").find("*").length != 0 ) $('#choose-header-section').show();
        });

        $('#tags-0').tagsinput('destroy');

        $(document).on('click','.add-field',function(){
            
            $('#tags-0').tagsinput('destroy');

            /*$("#participantTable").find('tr:last').after($("#participantTable").find('.multi-field:first').clone(true, true));
            $("#participantTable").find('tr:last').find('input').val('').focus();

            $("#participantTable").find('tr:last').find('td:last').prev().prev().attr('style','display:none');*/

            $("#participantTable").find('tr:last').after(get_new_param_row());
            
            $('#tags-0').tagsinput('items');

            makeInputNameUnique();
        });

        $(document).on('click',".remove-field",function () {
            $(this).closest("tr").remove();  
           /* if ($(".multi-field").length > 1) $(this).closest("tr").remove();*/
        });

        const get_new_param_row = () => {

            return `<tr class="multi-field sortable-field">
                    <td>
                        <label>Parameter Name</label>
                        <input name="parameter_name[0]" type="text" placeholder="Parameter Name" class="required-entry form-control">
                    </td>
                    <td>
                        <label>Sub Parameter Name</label>
                        <input name="sub_parameter_name[0]" type="text" placeholder="Sub Parameter Name" class="required-entry form-control">
                    </td>
                    <td>
                        <label>Weightage</label>
                        <input name="weightage[0]" type="number" min="0" max="100" placeholder="Weightage" class="required-entry form-control">
                    </td>
                    <td>
                        <label>Remarks</label>
                        <select name="comment_type[]" class="required-entry form-control comment_type">
                            <option value="0">N/A</option>
                            <option value="1">Dropdown Field</option>
                            <option value="2">Input Field</option>
                        </select>
                    </td>
                    <td style="display:none;">
                        <label>Enter Scenarion</label><br>
                        <input type="text" name="scenario_data[0]" value="" class="form-control scenario-type" id="tags-0">
                    </td>

                    <td>
                        <label>Is Fatal Parameter</label>
                        <select name="is_fatal[]" class="required-entry form-control">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </td>
                    <td>
                        <button class="btn btn-danger remove-field" type="button" style="margin-top: 24px;">Remove</button>
                    </td>
                </tr>`;
        }
    });
</script>
