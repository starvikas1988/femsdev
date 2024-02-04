<script>
    $(document).ready(function(){
        $('.tooltip_fresh a').click(function(){            
            $('.tooltip_fresh a').removeClass("add_plus");
            $(this).addClass("add_plus");
        });
    });
    function open_sub(pms_id,user_id){
        var base_url='<?php echo base_url();?>';
        var loader='<img src="'+base_url+'assets/images/loader.gif" width="30" >';
        $('#demo'+pms_id+'_'+user_id).html(loader);
        var ts='<table class="table table-striped"><thead><tr><th></th><th>Name</th><th>MWP ID</th><th>Role</th><th>Department</th><th>Title</th><th>PMS Status</th><th>Start Date</th><th>Status</th><th>Action</th></tr></thead>';
       $.ajax({
            type:'POST',
            url:base_url+'pms/pms_hierarchy_list',
            data:'pms_id='+pms_id+'&user_id='+user_id,
            success:function(res){
                var obj = jQuery.parseJSON(res);
                $.each(obj, function(key,data) {
                    
                ts+='<tbody><tr class="common_table_widget"><td>';
                if(data['is_under']!='0'){
                ts+='<div class="tooltip_fresh"><a href="javascript:void(0);" onclick="open_sub('+data['pms_id']+','+data['user_id']+')" id="toggle_icon" class="view_btn_circle" data-toggle="collapse" data-target="#demo'+data['pms_id']+'_'+data['user_id']+'"><i class="fa fa-plus" aria-hidden="true"></i></a></div>';
                }
                ts+='</td><td>'+data['name']+'</td><td>'+data['mwp_id']+'</td><td>'+data['role_name']+'</td><td>'+data['dept_name']+'</td><td>'+data['pms_title']+'</td><td>'+data['pms_status']+'</td><td>'+data['start_date']+'</td><td><span class="badge bg-success">'+data['status']+'</span></td><td><div class="tooltip_fresh"><a href="'+base_url+'pms_assignment/teams_performance_sheet/'+btoa(data['pms_id'])+'/'+btoa(data['user_id'])+'"><img src="'+base_url+'/assets_home_v3/images/view.svg" alt=""></a><span class="tooltiptext">View</span></div></td></tr><tr class="common_table_widget_expand"><td colspan="12" class="hiddenRow"><div class="accordian-body collapse table_under" id="demo'+data['pms_id']+'_'+data['user_id']+'"></div></td></tr></tbody>';
                });
                ts+='</table>';
                $('#demo'+pms_id+'_'+user_id).html(ts);
            }
       });
    }
</script>
<script>
//CREATE PROCESS DROPDOWN
    $("#client_id").change(function () {
        $('#sktPleaseWait').modal('show');
        let client_id = $(this).val();
        $.post("<?= base_url() ?>pms_assignment/getProcessDropdown", {client_id: client_id}).done(function (data) {
            $('#sktPleaseWait').modal('hide');
            if (data != '') {
                $("#process").html(data);
                $("#process").selectpicker('refresh');
            }

        });
    });
</script>    