<script type="text/javascript">
    
$(document).ready(function(){
    
    $("#add_entry_campaign").change(function(){
        var camp_id = $(this).val();
        
        if(camp_id!='') fetch_agents_list(camp_id);    
        else $("#add_entry_agents").empty().append('<option value="">Select an Agent</option>');    
        
    });
    
    $("#start_coaching").click(function(){
        $("#coaching_notes").show();
    });
    
    $("#add_entry_agents").change(function(){
        var agent_id = $(this).val();
        
        alert(agent_id);
        
        if(agent_id!='') $("#start_coaching").prop("disabled",false);
        else $("#start_coaching").prop("disabled",true);
    });    
    
    
});


function fetch_agents_list(camp_id){
    $.post("<?php echo base_url() ?>coach/fetch-agents-list",{camp_id:camp_id},function(data){
        
        $("#add_entry_agents").empty().append('<option value="">Select an Agent</option>');
        
        if(data.length!=0)
        {
            $.each(data,function(index,value){
                $("#add_entry_agents").append('<option value="'+index+'">'+value+'</option>');
            }); 
        }
        
    },"json");
}
    
    
    
</script>