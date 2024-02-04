<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>
<script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<script type="text/javascript">

$("#process_id").select2();
$("#lob_id").select2();
$("#campaign_id").select2();
$("#audit_sheet").select2();


$(document).ready(function() {
    if($('#process_id').val() == 'ALL'){
    $("#lob_id").prop('disabled', true);
    $("#campaign_id").prop('disabled', true);
    $("#audit_sheet").prop('disabled', true);
    $('#audit_sheet').removeAttr('required');
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

const getLobsAsPerProcess = async(params) =>{

const {processId} = params;

try{
    await $.ajax({
        url:"<?php echo base_url("dyn_audit_report/get_lob_as_per_process")?>",
        type:"get",
        data:{ processId },
        dataType:"json",
        success:function(response){
            if(response.data?.length > 0){
                const {data} = response;
                const params = window.location.search;
                $("#lob_id").html("");
                $("#lob_id").html(`<option value="ALL" ${params.includes("campaign_id%5B%5D=ALL") || params.includes("campaign_id[]=ALL") || params.length == 0 ? 'selected' : ''}>ALL</option>`);
                data.map((lob, index)=>(
                    $("#lob_id").append(`<option value="${lob.id}" ${params.includes("lob_id%5B%5D="+lob.id) || params.includes("lob_id[]="+lob.id) ? 'selected' : ''}>${lob.name}</option>`)
                ))
            }
        }
    })
}catch(e){
    // console.log(e)
}
}

const getCampaignsAsPerLob = async(params) =>{

const {processId,lobId} = params;

try{
    await $.ajax({
        url:"<?php echo base_url("dyn_audit_report/get_campaign_as_per_lob")?>",
        type:"get",
        data:{ processId,lobId },
        dataType:"json",
        success:function(response){
            if(response.data?.length > 0){
                const {data} = response;
                const params = window.location.search;
                $("#campaign_id").html("");
                $("#campaign_id").html(`<option value="ALL" ${params.includes("campaign_id%5B%5D=ALL") || params.includes("campaign_id[]=ALL") || params.length == 0 ? 'selected' : ''}>Select Campaign</option>`);
                data.map((campaign, index)=>(
                    $("#campaign_id").append(`<option value="${campaign.id}" ${params.includes("campaign_id%5B%5D="+campaign.id) || params.includes("campaign_id[]="+campaign.id) ? 'selected' : ''}>${campaign.campaign}</option>`)
                ))
            }
        }
    })
}catch(e){
    // console.log(e)
}
}

const getAuditSheets = async(params) =>{

const {processId,lobId = 0,campaignId = 0} = params;

try{
    await $.ajax({
        url:"<?php echo base_url("dyn_audit_report/get_audit_sheets")?>",
        type:"get",
        data:{ processId,lobId,campaignId },
        dataType:"json",
        success:function(response){
            //console.log(response.data);
            $("#audit_sheet").empty();
            if(response.data?.length > 0){
                const {data} = response;
                const params = window.location.search;
                $("#audit_sheet").html("");
                $("#audit_sheet").html(`<option value="ALL" ${params.includes("audit_sheet%5B%5D=ALL") || params.includes("audit_sheet[]=ALL") || params.length == 0 ? 'selected' : ''}>ALL</option>`);
                data.map((audit, index)=>(
                    $("#audit_sheet").append(`<option value="${audit.qa_defect_id}" ${params.includes("audit_sheet%5B%5D="+audit.qa_defect_id) || params.includes("audit_sheet[]="+audit.qa_defect_id) ? 'selected' : ''}>${audit.audit_sheet_name}</option>`)
                ))
            }
        }
    })
}catch(e){
    // console.log(e)
}
}


$(document).on('change','#process_id',function(){
    let processId = $(this).val();
    if (processId == 'ALL') {
        $("#lob_id").prop('disabled', true);
        $("#campaign_id").prop('disabled', true);
        $("#audit_sheet").prop('disabled', true);
    }else{
        $("#lob_id").prop('disabled', false);
        $("#campaign_id").prop('disabled', false);
        $("#audit_sheet").prop('disabled', false);
    }
    <?php if($exist_process_lob_campaign['lob']==true){ ?>
    getLobsAsPerProcess({processId});
    <?php }else{ ?>
        getAuditSheets({processId});
    <?php } ?>
});
$(document).on('change','#lob_id',function(){
    let lobId = $(this).val();
    let processId = $("#process_id").val();
    if (lobId == 'ALL') {
        $("#campaign_id").prop('disabled', true);
        $("#audit_sheet").prop('disabled', true);
    }else{
        $("#campaign_id").prop('disabled', false);
        $("#audit_sheet").prop('disabled', false);
    }
    <?php if($exist_process_lob_campaign['campaign']==true){ ?>
        getCampaignsAsPerLob({processId,lobId});
        let campaignId = $("#campaign_id").val();
        getAuditSheets({processId,lobId,campaignId})
    <?php }else{ ?>
        getAuditSheets({processId,lobId});
    <?php } ?>
});
$(document).on('change','#campaign_id',function(){
    let campaign_id = $(this).val();
    let lobId = $("#lob_id").val();
    let processId = $("#process_id").val();
    if (campaign_id == 'ALL') {
        $("#audit_sheet").prop('disabled', true);
    }else{
        $("#audit_sheet").prop('disabled', false);
    }
        getAuditSheets({processId,lobId,campaignId})
});

var processId = $("#process_id").val();
var lobId = $("#lob_id").val();
var campaignId = $("#campaign_id").val();
if(processId!=''){
    if (processId == 'ALL') {
        $("#lob_id").prop('disabled', true);
        $("#campaign_id").prop('disabled', true);
        $("#audit_sheet").prop('disabled', true);
    }else{
        $("#lob_id").prop('disabled', false);
        $("#campaign_id").prop('disabled', false);
        $("#audit_sheet").prop('disabled', false);
    }
    <?php if($exist_process_lob_campaign['lob']==true){ ?>
    getLobsAsPerProcess({processId});
    <?php }else{ ?>
        getAuditSheets({processId});
    <?php } ?>
}
if(lobId!=''){
    if (lobId == 'ALL') {
        $("#campaign_id").prop('disabled', true);
        $("#audit_sheet").prop('disabled', true);
    }else{
        $("#campaign_id").prop('disabled', false);
        $("#audit_sheet").prop('disabled', false);
    }
    <?php if($exist_process_lob_campaign['campaign']==true){ ?>
        getCampaignsAsPerLob({processId,lobId});
        let campaignId = $("#campaign_id").val();
        getAuditSheets({processId,lobId,campaignId})
    <?php }else{ ?>
        getAuditSheets({processId,lobId});
    <?php } ?>
}
if(campaignId!=''){
    if (campaignId == 'ALL') {
        $("#audit_sheet").prop('disabled', true);
    }else{
        $("#audit_sheet").prop('disabled', false);
    }
        getAuditSheets({processId,lobId,campaignId})
}
});
</script>