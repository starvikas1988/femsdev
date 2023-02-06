<script>
    $(document).ready(function(){
        $("#box1_office, #box2_office").select2({
            placeholder:"Select Office",
            allowClear:true
        });
        //Campaign selection
        $(document).on("change", ".campaign", function(){
            if($(this).closest(".search_box").hasClass("search1")){
                $(".search2").find(".campaign").val($(this).val());
            }else{
                $(".search1").find(".campaign").val($(this).val());
            }
        });
        $(document).on("change", ".office", function(){
            console.log($(this).val())
            if($(this).closest(".search_box").hasClass("search1")){
                $(".search2").find(".office").val($(this).val())
            }else{
                $(".search1").find(".office").val($(this).val())
            }
        });
        $(document).on("change", ".vertical", function(){
            if($(this).closest(".search_box").hasClass("search1")){
                $(".search2").find(".vertical").val($(this).val())
            }else{
                $(".search1").find(".vertical").val($(this).val())
            }
        })
        $(document).on("change", ".channel", function(){
            if($(this).closest(".search_box").hasClass("search1")){
                $(".search2").find(".channel").val($(this).val())
            }else{
                $(".search1").find(".channel").val($(this).val())
            }
        })
        var backup_data_set1 = "", backup_data_set2 = "";
        //Search Input Scripts
        $(document).on("keyup", ".search_inp", function(){
            var search_input = $(this);
            if(search_input.closest(".result_box").siblings(".search_box").hasClass("search1")){
                if(backup_data_set1 == "") backup_data_set1 = search_input.closest(".result_box").find("tbody")[0].innerHTML;
            }else{
                if(backup_data_set2 == "") backup_data_set2 = search_input.closest(".result_box").find("tbody")[0].innerHTML;
            }
            console.table(backup_data_set1, backup_data_set2)
            if(search_input.val()!=""){
                var input_text = search_input.val().toUpperCase();
                var tr = search_input.closest(".result_box").find("tr");
                for(let i = 0; i < tr.length; i++){
                    td_agent = tr[i].getElementsByClassName("agent_name")[0]
                    td_xpo = tr[i].getElementsByClassName("agent_xpo")[0]
                    if(td_agent || td_xpo){
                        let agentText = td_agent.textContent || td_agent.innerText
                        let xpoText = td_xpo.textContent || td_xpo.innerText
                        if((agentText.toUpperCase().indexOf(input_text) > -1) || (xpoText.toUpperCase().indexOf(input_text) > -1)){
                            tr[i].style.display="";
                        }else{
                            tr[i].style.display="none";
                        }
                    }
                }
            }else{
                if(search_input.closest(".result_box").siblings(".search_box").hasClass("search1")){
                    search_input.closest(".result_box").find("tbody")[0].innerHTML = backup_data_set1
                }else{
                    search_input.closest(".result_box").find("tbody")[0].innerHTML = backup_data_set2
                }
            }
        });
        //Search box scripts
        $(document).on("click", ".btn_submit", function(){
            var submit_button = $(this);
            var search_box="";
            if(submit_button.closest(".search_box").hasClass("search1")){
                search_box="1";
            }else{
                search_box="2";
            }
            var formData = new FormData();
            formData.append("campaign", submit_button.closest(".search_box").find(".campaign").val());
            formData.append("from_date", submit_button.closest(".search_box").find(".from_date").val());
            formData.append("to_date", submit_button.closest(".search_box").find(".to_date").val());
            formData.append("office", submit_button.closest(".search_box").find(".office").val());
            // formData.append("vertical", submit_button.closest(".search_box").find(".vertical").val())
            // formData.append("channel", submit_button.closest(".search_box").find(".channel").val())
            formData.append("search_box", search_box);
            if(search_box==2){
                formData.append("campaign1", $(".search1").find(".campaign").val());
                formData.append("from_date1", $(".search1").find(".from_date").val());
                formData.append("to_date1", $(".search1").find(".to_date").val());
                formData.append("office1", $(".search1").find(".office").val());
                // formData.append("vertical1", $(".search1").find(".vertical").val())
                // formData.append("channel1", $(".search1").find(".channel").val())
            }
            $.ajax({
                url:"<?= base_url("Qa_agent_score_comparison_boomsourcing/search")?>",
                type:"POST",
                processData:false,
                data:formData,
                contentType:false,
                dataType:"json",
                success:function(result){
                    console.log(result.sql_1)
                    console.log(result.sql_2)
                    if(result.data_set1?.length == 0){
                        submit_button.closest(".search_box").siblings(".result_box").show()
                        result_text = `<tr><td colspan='4'>NO Data Found</td></tr>`
                        $(`#box${search_box}_result`).html(result_text);
                    }
                    if(result.data_set2?.length == 0){
                        result_text = `<tr><td colspan='5'>No Data Found</td></tr>`
                        $(`#box${search_box}_result`).html(result_text);
                    }
                    if(result.data_set1.length > 0){
                        submit_button.closest(".search_box").siblings(".result_box").show();
                        var result_text="";
                        var data_set1 = result.data_set1;
                        var data_set2 = (result.data_set_count==2) ? result.data_set2 : [];
                        if(search_box==1){
                            localStorage.setItem("data_set1", result.data_set1);
                            for (let index = 0; index < data_set1.length; index++) {
                                result_text += `<tr><td>${index+1}</td><td class="agent_name">${data_set1[index].agent_name}</td><td class="agent_xpo">${data_set1[index].xpoid}</td><td>${parseFloat(data_set1[index].average_score).toFixed(2)}</td></tr>`;
                            }
                        }else{
                            console.log(result.sql_1)
                            console.log(result.sql_2)
                            var stored_set = localStorage.getItem("data_set1");
                            var difference = [];
                            if(result.data_set2.length > 0){
                                for (let index = 0; index < data_set2.length; index++) {
                                    var diff_value = 0;
                                    var diff_offset = ""
                                    result_text += `<tr>`;
                                    result_text += `<td>${index+1}</td>`;
                                    result_text += `<td class="agent_name">${data_set2[index].agent_name}</td>`;
                                    result_text += `<td class="agent_xpo">${data_set2[index].xpoid}</td>`;
                                    result_text += `<td>${parseFloat(data_set2[index].average_score).toFixed(2)}</td>`;
                                    for (let sub_index = 0; sub_index < data_set1.length; sub_index++) {
                                        if(parseInt(data_set1[sub_index].agent_id) == parseInt(data_set2[index].agent_id)){
                                            diff_value = parseFloat(data_set2[index].average_score).toFixed(2) - parseFloat(data_set1[sub_index].average_score).toFixed(2);
                                            if(data_set2[index].agent_id == '24097'){
                                                console.log(`First ${parseFloat(data_set1[sub_index].average_score).toFixed(2) > parseFloat(data_set2[index].average_score).toFixed(2)}`)
                                            }
                                            if(diff_value < 0){
                                                difference.push({
                                                    agent_id: data_set1[sub_index].agent_id,
                                                    diff: diff_value,
                                                    diff_offset:"Deteriorate"
                                                })
                                                diff_offset = "Deteriorate"
                                                break
                                            }else if(diff_value > 0){
                                                difference.push({
                                                    agent_id: data_set1[sub_index].agent_id,
                                                    diff: diff_value,
                                                    diff_offset:"Improved"
                                                })
                                                diff_offset = "Improved"
                                                break
                                            }else{
                                                difference.push({
                                                    agent_id: data_set1[sub_index].agent_id,
                                                    diff: diff_value,
                                                    diff_offset:"No Change"
                                                })
                                                diff_offset = "No Change"
                                                break
                                            }
                                        }else{
                                            difference.push({agent_id: 0})
                                            diff_value = "N/A";
                                        }
                                    }
                                    result_text += `<td>${(diff_value != "N/A") ? `${parseFloat(diff_value).toFixed(2)}` : `${diff_value}`} ${(diff_value!="N/A") ? `- (<strong>${diff_offset}</strong>)` :""}</td>`;
                                    result_text += `</tr>`;
                                }
                            }
                        }
                        $(`#box${search_box}_result`).html("");
                        $(`#box${search_box}_result`).append(result_text);
                    }
                }
            });
        });
    });
</script>