<script type="text/javascript">
$(document).ready(function(){
	
	$("#audit_date").datepicker();
	$("#call_date").datepicker();
	$("#from_date").datepicker();
	$("#to_date").datepicker();
	
///////////////// Calibration - Auditor Type ///////////////////////	
	$('.auType').hide();
	
	$('#audit_type').on('change', function(){
		if($(this).val()=='Calibration'){
			$('.auType').show();
			$('#auditor_type').attr('required',true);
			$('#auditor_type').prop('disabled',false);
		}else{
			$('.auType').hide();
			$('#auditor_type').attr('required',false);
			$('#auditor_type').prop('disabled',true);
		}
	});
	
/////////////////PuppySpot PA//////////////////

	$('#probing_que_assist').on('change', function(){
		checkpoint_overall_score();
	});
	$('#probing_que_ticket').on('change', function(){
		checkpoint_overall_score();
	});
	$('#accuracy_info').on('change', function(){
		checkpoint_overall_score();
	});
	$('#more_concerns').on('change', function(){
		checkpoint_overall_score();
	});
	$('#review_conversation').on('change', function(){
		checkpoint_overall_score();
	});
	$('#resolution').on('change', function(){
		checkpoint_overall_score();
	});
	$('#offer_additional').on('change', function(){
		checkpoint_overall_score();
	});
	$('#empathy_enthusiasm').on('change', function(){
		checkpoint_overall_score();
	});
	$('#simplicity_politeness').on('change', function(){
		checkpoint_overall_score();
	});
	$('#grammar').on('change', function(){
		checkpoint_overall_score();
	});
	$('#instruction_email').on('change', function(){
		checkpoint_overall_score();
	});
	$('#salutation').on('change', function(){
		checkpoint_overall_score();
	});
	$('#closing').on('change', function(){
		checkpoint_overall_score();
	});
	$('#escalation').on('change', function(){
		checkpoint_overall_score();
	});
	$('#proper_tools').on('change', function(){
		checkpoint_overall_score();
	});
	$('#proper_tags').on('change', function(){
		checkpoint_overall_score();
	});
	$('#other_notes').on('change', function(){
		checkpoint_overall_score();
	});
	$('#timeliness_response').on('change', function(){
		checkpoint_overall_score();
	});
	$('#status').on('change', function(){
		checkpoint_overall_score();
	});
		checkpoint_overall_score();

	function docusign_calc(){

		// alert("hi");

		var cust_score = 0;
		var busi_score = 0;
		var comp_score = 0;
		var scoreable = 0;
		var cust_scoreable = 0;
		var busi_scoreable = 0;
		var comp_scoreable = 0;
		var quality_score_percent = 0;
		var score1 = 0;
		var scoreable1 = 0;
		var quality_score_percent1 = 0;
		
		

		$('.cust_score').each(function(index,element){
			var cust_score_type = $(element).children("option:selected").attr('ds_val');
			
			if(cust_score_type == 'Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('hval'));
				cust_score = cust_score + weightage;
				cust_scoreable = cust_scoreable + weightage;
			}else if(cust_score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('hval'));
				cust_scoreable = cust_scoreable + weightage;
			}else if(cust_score_type == 'NA'){
				var weightage = parseFloat($(element).children("option:selected").attr('hval'));
				cust_score = cust_score + weightage;
				cust_scoreable = cust_scoreable + weightage;
			}
		});

		$('.busi_score').each(function(index,element){
			var busi_score_type = $(element).children("option:selected").attr('ds_val');
			
			if(busi_score_type == 'Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('hval'));
				busi_score = busi_score + weightage;
				busi_scoreable = busi_scoreable + weightage;
			}else if(busi_score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('hval'));
				busi_scoreable = busi_scoreable + weightage;
			}else if(busi_score_type == 'NA'){
				var weightage = parseFloat($(element).children("option:selected").attr('hval'));
				busi_score = busi_score + weightage;
				busi_scoreable = busi_scoreable + weightage;
			}
		});

		$('.comp_score').each(function(index,element){
			var comp_score_type = $(element).children("option:selected").attr('ds_val');
			
			if(comp_score_type == 'Yes'){
				var weightage = parseFloat($(element).children("option:selected").attr('hval'));
				comp_score = comp_score + weightage;
				comp_scoreable = comp_scoreable + weightage;
			}else if(comp_score_type == 'No'){
				var weightage = parseFloat($(element).children("option:selected").attr('hval'));
				comp_scoreable = comp_scoreable + weightage;
			}else if(comp_score_type == 'NA'){
				var weightage = parseFloat($(element).children("option:selected").attr('hval'));
				comp_score = comp_score + weightage;
				comp_scoreable = comp_scoreable + weightage;
			}
		});

		var cust_quality_score_percent = ((cust_score*100)/cust_scoreable).toFixed(2);
		var busi_quality_score_percent = ((busi_score*100)/busi_scoreable).toFixed(2);
		var comp_quality_score_percent = ((comp_score*100)/comp_scoreable).toFixed(2);

		if(!isNaN(cust_quality_score_percent)){
			$('#custScore').val(cust_quality_score_percent+'%');
		}

		if(!isNaN(busi_quality_score_percent)){
			$('#busiScore').val(busi_quality_score_percent+'%');
		}

		if(!isNaN(comp_quality_score_percent)){
			$('#compScore').val(comp_quality_score_percent+'%');
		}			
	
	}
	
    docusign_calc();

    $(".cust_score").on("change",function(){
		docusign_calc();
	});

	$(".busi_score").on("change",function(){
		docusign_calc();
	});

	$(".comp_score").on("change",function(){
		docusign_calc();
	});

	docusign_calc();

	
	////// Possible and EarnScore calculation return value------
	function score_res(v,p){
		var x = 0;
		var y = 0;
		if(v == p & v >= 0){ // YES
			x = +p;
			y = +p;
			return [x, y];
		}
		else if(v == 0){ // NO
			x = +p;
			y = -0;
			return [x, y];
		}
		else if(v == -1){ // NA
			x = -0;
			y = -0;
			return [x, y];
		}		
		else{
			var x=0;
			var y=0;
			return [x, y];
		}
	}
	
	///////////////Check point email calculation////////////////////
	function checkpoint_overall_score(){
		var ps = 0; // possible_score
		var es = 0; // earned_score
		
		var a = parseInt($("#probing_que_assist").val());
		var ah = parseInt($("#probing_que_assist_hd").val());
		var b = parseInt($("#probing_que_ticket").val());
		var bh = parseInt($("#probing_que_ticket_hd").val());
		var c = parseInt($("#accuracy_info").val());
		var ch = parseInt($("#accuracy_info_hd").val());
		var d = parseInt($("#more_concerns").val());
		var dh = parseInt($("#more_concerns_hd").val());
		var e = parseInt($("#review_conversation").val());
		var eh = parseInt($("#review_conversation_hd").val());
		var f = parseInt($("#resolution").val());
		var fh = parseInt($("#resolution_hd").val());		
		var g = parseInt($("#offer_additional").val());
		var gh = parseInt($("#offer_additional_hd").val());
		var h = parseInt($("#empathy_enthusiasm").val());
		var hh = parseInt($("#empathy_enthusiasm_hd").val());
		var i = parseInt($("#simplicity_politeness").val());
		var ih = parseInt($("#simplicity_politeness_hd").val());
		var j = parseInt($("#grammar").val());
		var jh = parseInt($("#grammar_hd").val());
		var k = parseInt($("#instruction_email").val());
		var kh = parseInt($("#instruction_email_hd").val());
		var l = parseInt($("#salutation").val());
		var lh = parseInt($("#salutation_hd").val());
		var m = parseInt($("#closing").val());
		var mh = parseInt($("#closing_hd").val());
		var n = parseInt($("#escalation").val());
		var nh = parseInt($("#escalation_hd").val());
		var o = parseInt($("#proper_tools").val());
		var oh = parseInt($("#proper_tools_hd").val());
		var p = parseInt($("#proper_tags").val());
		var ph = parseInt($("#proper_tags_hd").val());
		var q = parseInt($("#other_notes").val());
		var qh = parseInt($("#other_notes_hd").val());
		var r = parseInt($("#timeliness_response").val());
		var rh = parseInt($("#timeliness_response_hd").val());
		var s = parseInt($("#status").val());
		var sh = parseInt($("#status_hd").val());
		
		if(!isNaN(a)) {
				var res = score_res(a,ah);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(b)) {
				var res = score_res(b,bh);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(c)) {
				var res = score_res(c,ch);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(d)) {
				var res = score_res(d,dh);
				ps = ps + res[0];
				es = es + res[1];
			}

		if(!isNaN(e)) {
				var res = score_res(e,eh);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(f)) {
				var res = score_res(f,fh);
				ps = ps + res[0];
				es = es + res[1];
			}	
		if(!isNaN(g)) {
				var res = score_res(g,gh);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(h)) {
				var res = score_res(h,hh);
				ps = ps + res[0];
				es = es + res[1];
			}
		
		if(!isNaN(i)) {
				var res = score_res(i,ih);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(j)) {
				var res = score_res(j,jh);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(k)) {
				var res = score_res(k,kh);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(l)) {
				var res = score_res(l,lh);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(m)) {
				var res = score_res(m,mh);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(n)) {
				var res = score_res(n,nh);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(o)) {
				var res = score_res(o,oh);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(p)) {
				var res = score_res(p,ph);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(q)) {
				var res = score_res(q,qh);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(r)) {
				var res = score_res(r,rh);
				ps = ps + res[0];
				es = es + res[1];
			}
		if(!isNaN(s)) {
				var res = score_res(s,sh);
				ps = ps + res[0];
				es = es + res[1];
			}	
		//var tot = a+b+c+d+e+f+g+h+i+j+k+l+m+n+o+p+q+r+s;
		//alert(ps);
		if(!isNaN(ps) && ps>0){
			document.getElementById("checkpoint_total_score").value= ((es/ps)*100).toFixed(2)+'%';
			//document.getElementById("checkpoint_total_score").value= ((tot/120)*100).toFixed(2)+'%';
		}
		else{
			document.getElementById("checkpoint_total_score").value= '0.00%';
		}
		//return tot;
	}
	////////////////////////////////////////////////////////
	
////////////////////////////////////////////////////////////////	
	$( "#agent_id" ).on('change' , function() {	
		var aid = this.value;
		if(aid=="") alert("Please Select Agent")
		var URL='<?php echo base_url();?>qa_checkpoint_email/getTLname';
		$('#sktPleaseWait').modal('show');
		$.ajax({
			type: 'POST',    
			url:URL,
			data:'aid='+aid,
			success: function(aList){
				var json_obj = $.parseJSON(aList);
				$('#tl_name').empty();
				$('#tl_name').append($('#tl_name').val(''));	
				//for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));
				for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i].assigned_to));
				for (var i in json_obj) $('#fusion_id').append($('#fusion_id').val(json_obj[i].fusion_id));
				for (var i in json_obj) $('#campaign').append($('#campaign').val(json_obj[i].process_name));
				$('#sktPleaseWait').modal('hide');
			},
			error: function(){	
				alert('Fail!');
			}
		});
	});
	
/////////////////PuppySpot PC//////////////////

	
	
//////////////////////////////////////

		$("#form_audit_user").submit(function (e) {
			$('#qaformsubmit').prop('disabled',true);
		});
		
		$("#form_agent_user").submit(function(e){
			$('#btnagentSave').prop('disabled',true);
		});
		
		$("#form_mgnt_user").submit(function(e){
			$('#btnmgntSave').prop('disabled',true);
		});
		
		
///////////////////////////
});
</script>


<script type="text/javascript">
///////////////PuppySpot PA////////////////////
	/*function checkpoint_overall_score(){
		var a = parseInt($("#probing_que_assist").val());
		var ah = parseInt($("#probing_que_assist_hd").val());
		var b = parseInt($("#probing_que_ticket").val());
		var bh = parseInt($("#probing_que_ticket_hd").val());
		var c = parseInt($("#accuracy_info").val());
		var ch = parseInt($("#accuracy_info_hd").val());
		var d = parseInt($("#more_concerns").val());
		var e = parseInt($("#review_conversation").val());
		var f = parseInt($("#resolution").val());
		var g = parseInt($("#offer_additional").val());
		var h = parseInt($("#empathy_enthusiasm").val());
		var i = parseInt($("#simplicity_politeness").val());
		var j = parseInt($("#grammar").val());
		var k = parseInt($("#instruction_email").val());
		var l = parseInt($("#salutation").val());
		var m = parseInt($("#closing").val());
		var n = parseInt($("#escalation").val());
		var o = parseInt($("#proper_tools").val());
		var p = parseInt($("#proper_tags").val());
		var q = parseInt($("#other_notes").val());
		var r = parseInt($("#timeliness_response").val());
		var s = parseInt($("#status").val());
		
		var tot = a+b+c+d+e+f+g+h+i+j+k+l+m+n+o+p+q+r+s;
		
		if(!isNaN(tot)){
			document.getElementById("checkpoint_total_score").value= ((tot/120)*100).toFixed(2)+'%';
		}
		return tot;
	}
	*/
///////////////PuppySpot PC////////////////////
	function pc_overall_score(){
		var a = parseInt($("#pc_correct_greeting").val());
		var b = parseInt($("#pc_customer_greeting").val());
		var c = parseInt($("#pc_reached_greeting").val());
		var d = parseInt($("#pc_rapport_greeting").val());
		var e = parseInt($("#pc_website_handle").val());
		var f = parseInt($("#pc_choice_handle").val());
		var g = parseInt($("#pc_excitement_sales").val());
		var h = parseInt($("#pc_objection_sales").val());
		var i = parseInt($("#pc_call_skill").val());
		var j = parseInt($("#pc_professional_skill").val());
		var k = parseInt($("#pc_clear_skill").val());
		var l = parseInt($("#pc_listening_skill").val());
		var m = parseInt($("#pc_sales_closing").val());
		var n = parseInt($("#pc_cost_closing").val());
		var o = parseInt($("#pc_travel_closing").val());
		var p = parseInt($("#pc_screening_closing").val());
		var q = parseInt($("#pc_pup_closing").val());
		var r = parseInt($("#pc_vca_closing").val());
		var s = parseInt($("#pc_pcdefine_closing").val());
		var t = parseInt($("#pc_contact_notation").val());
		
		var tot = a+b+c+d+e+f+g+h+i+j+k+l+m+n+o+p+q+r+s+t;
		
		if(!isNaN(tot)){
			document.getElementById("pc_total_score").value= tot+'%';
		}
		return tot;
	}
	
</script>

 
 <script>
	function checkDec(el){
		var ex = /^[0-9]+\.?[0-9]*$/;
		if(ex.test(el.value)==false){
			el.value = el.value.substring(0,el.value.length - 1);
		}
	}
 </script>