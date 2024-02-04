<script>
$(document).ready(function(){});

function openreg_modal(user_id, reg_dt){
	$("#reg_dt").val(reg_dt);
	$("#user_id").val(user_id);
	
	$("#RegModal").modal("show");
}
</script>