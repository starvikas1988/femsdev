<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<link rel="stylesheet" href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
<link rel="stylesheet" href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link rel="stylesheet" href="<?php echo base_url('libs/bower/font-awesome/css/font-awesome-all.css')?>">
<style>
     @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,500;1,900&display=swap');
    body {
        background: #eee;
          font-family: 'Roboto', sans-serif;
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
/* multistep indication   */

.indicator {
    text-align: center;
    position: relative;
    margin-top: 10px;
}
#progressbar {
    margin-bottom: 10px;
    overflow: hidden;
    counter-reset: step;
}

#progressbar li {
    list-style-type: none;
    color:#333333;
    text-transform: uppercase;
    font-size: 9px;
    width: 33.33%;
    float: left;
    position: relative;
    letter-spacing: 1px;
    font-weight: 600;
}

#progressbar li:before {
content: counter(step);
counter-increment: step;
width: 40px;
height: 39px;
line-height: 37px;
display: block;
font-size: 14px;
color: #333;
background: #99d1f7;
border-radius: 25px;
margin: 0 auto 10px auto;
font-weight: 600;
}


#progressbar li:after {
    content: '';
    width: 100%;
    height: 6px;
    background: #99d1f7;
    position: absolute;
    left: -50%;
    top: 17px;
    z-index: -1; 
}

#progressbar li:first-child:after {
    content: none;
}

#progressbar li.active:before, #progressbar li.active:after {
    background: #ee0979;
    color: #eaf0f4;
}
.card_widget-new{
    background: #6441A5;
}

.single-fixed-header-field{
    background-color: #333c68 !important;
}
.single-fixed-header-field input:checked+span {
    background-color: #333c68;
    border-radius: 5px;
}
</style>

<div class="container">
    <section>
        <div class="my-3">
            <div class="indicator">
                <div class="row">
                    <div class="col-md-12">
                        <ul id="progressbar">
                            <li class="active">Choose Header</li>
                            <li>Create Parameters</li>
                            <li>Preview</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <form action="<?php echo base_url('audit_sheet_dyn/addAuditSheet');?>" method="POST" id="auditSheetCreateForm" onsubmit="return false">
        <input type="hidden" name="format_id" value="<?php echo $this->input->get('format_id', TRUE);?>">
        <section id="step-1">
            <div class="my-3">
                <div class="card_widget">
                    <div class="row">
                        <div class="col-sm-3">
                            <label>Audit Sheet Name</label>
                            <input type="text" class="form-control" name="audit_sheet_name" id="audit_sheet_name" />
                        </div>
                        <div class="col-sm-2">
                            <label>Client</label>
                            <select id="audit_sheet_client_id" class="form-control" name="audit_sheet_client_id">
                             <option value="" selected disabled>Select Client</option>

                             <?php foreach ($client_list as $client):?>

                                <option value="<?php echo $client['client_id'];?>"><?php echo $client['client_name'];?></option>

                            <?php endforeach;?>

                            </select>
                        </div>

                        <div class="col-sm-2">
                            <label>Process</label>
                            <select id="audit_sheet_process_id" class="form-control" name="audit_sheet_process_id[]" multiple>
                             <!-- <option value="">Select Process</option> -->

                             <?php foreach ($process_list as $process):?>

                                <option value="<?php echo $process['process_id'];?>"><?php echo $process['process_name'];?></option>

                            <?php endforeach;?>

                            </select>
                            <label id="audit_sheet_process_id-error" class="invalid-feedback" for="audit_sheet_process_id"></label>
                        </div>

                        <?php if(!empty($is_lob_exist) && $is_lob_exist == 1):?>
                        <div class="col-sm-2">
                            <label>LOB</label>
                            <select id="select_lob" class="form-control" name="select_lob[]" multiple>
                             <!-- <option value="" selected disabled>Select LOB</option> -->
                             <?php foreach ($lob_list as $lob):?>
                                <option value="<?php echo $lob['lob_id'];?>"><?php echo $lob['lob_name'];?></option>
                             <?php endforeach;?>
                            </select>
                        </div>
                        <?php endif;?>

                        <?php if(!empty($is_campaign_exist) && $is_campaign_exist == 1):?>
                        <div class="col-sm-2">
                            <label>Campaign</label>
                            <select id="select_campaign" class="form-control" name="select_campaign[]" multiple>
                             <!-- <option value="" selected disabled>Select Campaign</option> -->
                             <?php foreach ($campaign_list as $campaign):?>
                                <option value="<?php echo $campaign['campaign_id'];?>"><?php echo $campaign['campaign_name'];?></option>
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

                                <?php foreach($fixed_headers as $header):?>
                                <label style="display: <?php echo $header['input_type'] == 'hidden' ? 'none' : '' ?>;">
                                    <input type="checkbox" value="<?php echo $header['header_id'];?>" name="heading[<?php echo $header['column_name'];?>]"  <?php echo $header['is_mandatory'] == 1 ? ' checked onclick="return false"' : '' ?>><span><?php echo $header['header_name'];?></span>
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
                                <a class="btn btn-large btn-success" href="<?php echo base_url("qa_audit_dyn/header_info/add_header");?>" style="float: right;"><i class="fas fa-plus-circle"></i>&nbsp;Add Header</a>
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
       <!-- <div class="my-3">
            <div class="card_widget">
                <label>Enter Parameter Details</label>
                <table class="table table-bordered table-hover" id="participantTable">
                    <tr class="multi-field">
                        <td>
                            <label>Parameter Name</label>
                            <input name="parameter_name[0]" type="text" placeholder="Parameter Name" class="required-entry form-control" required>
                        </td>
                        <td>
                            <label>Sub Parameter Name</label>
                            <input name="sub_parameter_name[0]" type="text" placeholder="Sub Parameter Name" class="required-entry form-control" required>
                        </td>
                        <td>
                            <label>Weightage</label>
                            <input name="weightage[0]" type="number" min="0" max="100" placeholder="Weightage" class="required-entry form-control" required>
                        </td>
                        
                        <td>
                            <label>Comments</label>
                            <select name="is_comment_active[]" class="required-entry form-control">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
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
                    </tr>
                    <tr id="addButtonRow">
                        <td colspan="13">
                           <button class="btn btn-large btn-success add-field" type="button">Add</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div> -->
        <section id="step-2" style="display:none;">
            <div class="my-3" id="create-parameter-section">
                <div class="card_widget">
                    <label>Create Parameters</label>
                    <table class="table table-bordered table-hover" id="participantTable" style="white-space: nowrap;">
                        <tbody class="new-parameter-row-position">
                            <tr class="multi-field">
                                <td>
                                    <label>Parameter Name</label>
                                    <input name="parameter_name[0]" type="text" placeholder="Parameter Name" class="required-entry form-control" required>
                                </td>
                                <!-- pattern="^[a-zA-Z0-9 ]+$" -->
                                <td>
                                    <label>Sub Parameter Name</label>
                                    <input name="sub_parameter_name[0]" type="text" placeholder="Sub Parameter Name" class="required-entry form-control" required>
                                </td>
                                <td>
                                    <label>Weightage</label>
                                    <input name="weightage[0]" type="number" min="0" max="100" placeholder="Weightage" class="required-entry form-control" required>
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
                            </tr>
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

    const makeInputNameUnique = () => {
            
        $("input[name^='parameter_name']").each(function(key,value){
            
            $(this).attr('name', `parameter_name[${key}]`);
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

            $("#participantTable").find('tr:last').after($("#participantTable").find('tr:first').clone(true, true));
            $("#participantTable").find('tr:last').find('input').val('').focus();

            $("#participantTable").find('tr:last').find('td:last').prev().prev().attr('style','display:none')

            // $('label[for="parameter_name[]"]').remove();
            // $('label[for="sub_parameter_name[]"]').remove();
            // $('label[for="weightage[]"]').remove();
            // $('label[for="scenario_data[0]"]').remove();
            

            $('#tags-0').tagsinput('items');

            makeInputNameUnique();
        });

        $(document).on('click',".remove-field",function () {
               
            if ($(".multi-field").length > 1) $(this).closest("tr").remove();
        });

        
    });
</script>

    