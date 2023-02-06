 public function qa_agent_upload_feedback(){
        if(check_logged_in()){
            $up_date = $this->input->get('up_date');

            $current_user = get_user_id(); 
            $user_office = get_user_office_id(); 
            $data["aside_template"] = "qa/aside.php";
            $data["content_template"] = "qa_agent_coaching/qa_agent_upload_feedback.php";
            $data["content_js"] = "qa_raw_upload_js.php";

            $from_date = $this->input->get('from_date');
            $to_date = $this->input->get('to_date');

            // if($from_date==""){
            //     $from_date=CurrDate();
            // }else{
            //     $from_date = mmddyy2mysql($from_date);
            // }

            // if($to_date==""){
            //     $to_date=CurrDate();
            // }else{
            //     $to_date = mmddyy2mysql($to_date);
            // }

            if($from_date!='' && $to_date!=''){
                $from_date = mmddyy2mysql($from_date);
                $to_date = mmddyy2mysql($to_date);
            }

            $cond = '';
            $cond1 = '';
            if($from_date!="" && $to_date!==""){
                $cond1 .= "  and (audit_date >= '$from_date' and audit_date <= '$to_date')";
            }else{
                $cond1 .="";
            }

            
            if($up_date !=""){
               $cond= " and  (audit_date = '$up_date')";
            }  

            $qSql = "SELECT * from (Select *, (select concat(fname, ' ', lname) as name from signin s where s.id=entry_by) as auditor_name, (select fullname as name from client sc where sc.id=42) as client_name, (select concat(fname, ' ', lname) as name from signin s where s.id=tl_id) as tl_name from qa_coaching_raw_feedback WHERE audit_status = 0 $cond $cond1) xx Left Join (Select id as sid,concat(fname, ' ', lname) as agent_name, fusion_id, get_process_names(id) as campaign, assigned_to from signin) yy on (xx.agent_id=yy.sid) order by audit_date";
            $data["agent_upload"] = $this->Common_model->get_query_result_array($qSql);
            //die();
            $data['from_date'] = $from_date;
            $data['to_date'] =  $to_date;
            $this->load->view("dashboard",$data);
        }
    }