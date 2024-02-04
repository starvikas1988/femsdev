<!-- QA SRL IB Script -->
<script>
    $(document).ready(function(){
        $("#from_date").datepicker();
		$("#to_date").datepicker();
		$("#chat_date").datepicker();
		$("#call_date").datetimepicker({timeFormat : 'HH:mm:ss' });
		$("#call_duration").timepicker({timeFormat : 'HH:mm:ss' });
		$("#audit_date").datepicker();
		$("#mgnt_review_date").datepicker();
		$("#review_date").datepicker();
        $( "#agent_id" ).on('change' , function() {
			var aid = this.value;
			if(aid=="") alert("Please Select Agent")
			var URL='<?php echo base_url();?>qa_od/getTLname';
			$('#sktPleaseWait').modal('show');
			$.ajax({
				type: 'POST',
				url:URL,
				data:'aid='+aid,
				success: function(aList){
					var json_obj = $.parseJSON(aList);
					$('#tl_name').empty();
					$('#tl_name').append($('#tl_name').val(''));
					for (var i in json_obj) $('#tl_name').append($('#tl_name').val(json_obj[i].tl_name));
					for (var i in json_obj) $('#tl_id').append($('#tl_id').val(json_obj[i].assigned_to));
                    for (var i in json_obj) $('#fusion_id').append($('#fusion_id').val(json_obj[i].fusion_id));
					$('#sktPleaseWait').modal('hide');
				},
				error: function(){
					alert('Fail!');
				}
			});
		});
        loadScores();
        function loadScores(){
            var earned_score=0, possible_score=0, overall_score="";
            var check_fatal=false;
            $(".srl_inb_score").each(function(){
              var score=$(this).children("option:selected").attr("srl_inb");
              var max_score=$(this).children("option:selected").attr("srl_max");
                if($(this).val()==1){
                    earned_score+=parseInt(score);
                    possible_score+=parseInt(max_score);
                    $(this).closest("td").siblings(".earned_score").find("input").val(score);
                    $(this).closest("td").siblings(".possible_score").find("input").val(max_score);
                }else if($(this).val()==2){
                    earned_score+=parseInt(score);
                    possible_score+=parseInt(max_score);
                    $(this).closest("td").siblings(".earned_score").find("input").val(score);
                    $(this).closest("td").siblings(".possible_score").find("input").val(max_score);
                }else if($(this).val()==3){
                    earned_score+=parseInt(score);
                    possible_score+=parseInt(max_score);
                    $(this).closest("td").siblings(".earned_score").find("input").val(score);
                    $(this).closest("td").siblings(".possible_score").find("input").val(max_score);
                }else if($(this).val()==4){
                    earned_score+=parseInt(score);
                    possible_score+=parseInt(max_score);
                    $(this).closest("td").siblings(".earned_score").find("input").val(score);
                    $(this).closest("td").siblings(".possible_score").find("input").val(max_score);
                }else if($(this).val()==5){
                    earned_score+=0;
                    possible_score+=0;
                    $(this).closest("td").siblings(".earned_score").find("input").val("");
                    $(this).closest("td").siblings(".possible_score").find("input").val("");
                }
            });
            // $(".fatal").each(function(){
            //     if($(this).val()==1){
            //         check_fatal=true;
            //     }
            // });
            // if(!check_fatal){
            //     $("#srlOverallScore").val(parseFloat((earned_score/possible_score)*100).toFixed(2)+"%");
            //     $("#srlPossible").val(possible_score);
            //     $("#srlEarned").val(earned_score);
            // }else{
            //     $("#srlOverallScore").val("0.0%");
            //     $("#srlPossible").val(possible_score);
            //     $("#srlEarned").val("0");
            // }
        }
        $(document).on("change", ".srl_inb_score", function(){
            var earned_score=0, possible_score=0, overall_score="";
            var check_fatal=false;
            $(".srl_inb_score").each(function(){
              if($(this).hasClass("fatal")){
                if($(this).val()==1){
                    check_fatal=true;
                }
              }else{
                var score=$(this).children("option:selected").attr("srl_inb");
                var max_score=$(this).children("option:selected").attr("srl_max");
                if($(this).val()==1){
                    earned_score+=parseInt(score);
                    possible_score+=parseInt(max_score);
                    $(this).closest("td").siblings(".earned_score").find("input").val(score);
                    $(this).closest("td").siblings(".possible_score").find("input").val(max_score);
                }else if($(this).val()==2){
                    earned_score+=parseInt(score);
                    possible_score+=parseInt(max_score);
                    $(this).closest("td").siblings(".earned_score").find("input").val(score);
                    $(this).closest("td").siblings(".possible_score").find("input").val(max_score);
                }else if($(this).val()==3){
                    earned_score+=parseInt(score);
                    possible_score+=parseInt(max_score);
                    $(this).closest("td").siblings(".earned_score").find("input").val(score);
                    $(this).closest("td").siblings(".possible_score").find("input").val(max_score);
                }else if($(this).val()==4){
                    earned_score+=parseInt(score);
                    possible_score+=parseInt(max_score);
                    $(this).closest("td").siblings(".earned_score").find("input").val(score);
                    $(this).closest("td").siblings(".possible_score").find("input").val(max_score);
                }else if($(this).val()==5){
                    earned_score+=0;
                    possible_score+=0;
                    $(this).closest("td").siblings(".earned_score").find("input").val("");
                    $(this).closest("td").siblings(".possible_score").find("input").val("");
                }
              }
            });
            if(!check_fatal){
                $("#srlOverallScore").val(parseFloat((earned_score/possible_score)*100).toFixed(2)+"%");
                $("#srlPossible").val(possible_score);
                $("#srlEarned").val(earned_score);
            }else{
                $("#srlOverallScore").val("0.0%");
                $("#srlPossible").val(possible_score);
                $("#srlEarned").val("0");
            }
        });
    });
</script>
