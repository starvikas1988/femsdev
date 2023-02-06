<?php
defined('BASEPATH') or exit('No direct script access allowed');
include_once "application/third_party/encdypt/encdypt.php";
use encryptionDecryption as ency;
class Api_zendesk extends CI_Controller
{
    /////////////////////////////////////////////////////////////////////////////////////////////
    // INDEX PAGE
    /////////////////////////////////////////////////////////////////////////////////////////////

    function __construct()
    {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->library('encrypt');
        $this->load->helper('url');
    }

    


    // public function get_data_csv()
    // { 
        
        
    //     $curl = curl_init();

    //     curl_setopt_array($curl, array(
    //     CURLOPT_URL => 'https://smartflatssupport.zendesk.com/api/v2/activities.json?Key=authorization&Value=Basic%20YWR1QHNtYXJ0ZmxhdHMuYmUvdG9rZW46alZRZXhob3dPUk5ZT3FBekhNcndMV1g0VXVIRkpJMUY1Y092MzlRRQ====',
    //     CURLOPT_RETURNTRANSFER => true,
    //     CURLOPT_ENCODING => '',
    //     CURLOPT_MAXREDIRS => 10,
    //     CURLOPT_TIMEOUT => 0,
    //     CURLOPT_FOLLOWLOCATION => true,
    //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //     CURLOPT_CUSTOMREQUEST => 'GET',
    //     CURLOPT_HTTPHEADER => array(
    //         'email_address: adu@smartflats.be',
    //         'token: jVQexhowORNYOqAzHMrwLWX4UuHFJI1F5cOv39QE',
    //         'authorization: Basic YWR1QHNtYXJ0ZmxhdHMuYmUvdG9rZW46alZRZXhob3dPUk5ZT3FBekhNcndMV1g0VXVIRkpJMUY1Y092MzlRRQ===='
            
    //     ),
    //     ));

    //     $response = curl_exec($curl);

    //     curl_close($curl);
    //     //echo $response;

    //     $data=json_decode($response);
    //     $res_data = $data;
    //     // echo '<pre>';print_r ($res_data);

    //     foreach($res_data as $key=>$value){
    //         // $url = $value['url'];
    //         foreach ($value as $key => $val) {
    //             //  $url=$val->url;die;
    //             //  $id=$val->id;
    //             //echo  $object=$val->id;die;
    //             //echo '<pre>';print_r ($val);die;

    //             foreach ($val->object as $key => $tar) {
    //                 //echo '<pre>';print_r($tar);die;

    //             }
    //         }
            
    //       }

    //     // foreach($res_data['activities'] as $res){
	// 	// 	$url = $res['url'];
			
			
			
			
		
	// 	// }
         

    //     // $data=json_decode($response);
    //     // $res=$data->data;
    //     // print_r($res);
            
        
    // }


    public function get_activities_data_csv()
    { 
        
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://smartflatssupport.zendesk.com/api/v2/activities.json?Key=authorization&Value=Basic%20YWR1QHNtYXJ0ZmxhdHMuYmUvdG9rZW46alZRZXhob3dPUk5ZT3FBekhNcndMV1g0VXVIRkpJMUY1Y092MzlRRQ====',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'email_address: adu@smartflats.be',
            'token: jVQexhowORNYOqAzHMrwLWX4UuHFJI1F5cOv39QE',
            'authorization: Basic YWR1QHNtYXJ0ZmxhdHMuYmUvdG9rZW46alZRZXhob3dPUk5ZT3FBekhNcndMV1g0VXVIRkpJMUY1Y092MzlRRQ===='
            
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        //echo $response;

         $data=json_decode($response);
         $res_data = $data;
        // //echo '<pre>';print_r ($res_data);exit();
        $delimiter = ",";
        $filename = 'activities_'.date('Ymd').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");
         //$header  = array( "URL", "ID", "TITLE", "VERB", "ACTION ID", "UPDATED AT","CREATED AT","OBJECT TICKET ID","OBJECT TICKET SUBJECT","USER NAME");
		// $filename = "dump-report.csv";
		// //$f = fopen('php://memory', 'w');
        $f = fopen('php://output', 'w');
	    $header = array( "url", "id", "title", "verb", "actor_id", "updated_at","user_id","created_at","object_ticket_id","object_ticket_subject","user_name","user_user_id","user_url","user_email","user_created_at","user_updated_at","user_time_zone","user_iana_time_zone","user_phone","user_shared_phone_number","user_photo_id","user_photo_file_name","user_photo_content_url","user_photo_mapped_content_url","user_photo_content_type","user_photo_size","user_photo_width","user_photo_height","user_photo_inline","user_photo_deleted","locale_id","locale","organization_id","role","verified","external_id","alias","active","shared","last_login_at","two_factor_auth_enabled","signature","details","notes","role_type","custom_role_id","moderator","ticket_restriction","only_private_comments","restricted_agent","suspended","default_group_id","report_csv","user_fields_at_risk","user_fields_phone_number","actor_1_id","actor_url","actor_name","actor_email","actor_created_at","actor_updated_at","actor_time_zone","actor_iana_time_zone","actor_phone","actor_shared_phone_number","actor_photo_url","actor_photo_id","actor_photo_file_name","actor_photo_mapped_content_url","actor_photo_content_type","actor_photo_size","actor_photo_width","actor_photo_height","actor_photo_inline","actor_photo_deleted","actor_photo_thumbnails_url","actor_photo_thumbnails_id","actor_photo_thumbnails_file_name","actor_photo_thumbnails_content_url","actor_photo_thumbnails_content_content_type","actor_photo_thumbnails_content_size","actor_photo_thumbnails_content_width","actor_photo_thumbnails_content_height","actor_photo_thumbnails_content_inline","actor_photo_thumbnails_content_deleted","actor_locale_id","actor_locale","actor_organization_id","actor_role","actor_verified","actor_external_id","actor_alias","actor_active","actor_shared_agent","actor_last_login_at","actor_two_factor_auth_enabled","actor_signature","actor_details","actor_notes","actor_notes","actor_signature","actor_role_type","actor_custom_role_id","actor_moderator","actor_ticket_restriction","actor_ticket_only_private_comments","actor_restricted_agent","actor_suspended","actor_default_group_id","actor_user_fields_at_risk","actor_user_fields_phone_number");
		// //$fields = array( "OLI ID", "Start Stamp");
		//fputcsv($f, $header, $delimiter);
        foreach($res_data as $key=>$value){
            // $url = $value['url'];
            //echo '<pre>';print_r ($value);die;
            foreach ($value as $key => $val) {
                 $url=$val->url;
                 $id=$val->id;
                 $title=$val->title;
                 $verb=$val->verb;
                 $user_id=$val->user_id;
                 $actor_id=$val->actor_id;
                 $updated_at=$val->updated_at;
                 $created_at=$val->created_at;
                 $object_ticket_id=$val->object->ticket->id ;
                 $object_ticket_subject=$val->object->ticket->subject;
                 $user_name=$val->user->name;
                 $user_user_id=$val->user->id;
                 $user_url=$val->user->url;
                 $user_email=$val->user->email;
                 $user_created_at=$val->user->created_at;
                 $user_updated_at=$val->user->updated_at;
                 $user_time_zone=$val->user->time_zone;
                 $user_iana_time_zone=$val->user->iana_time_zone;
                 $user_phone=$val->user->phone;
                 $user_shared_phone_number=$val->user->shared_phone_number;
                 $user_photo_url=$val->user->photo->url;
                 $user_photo_id=$val->user->photo->id;
                 $user_photo_file_name=$val->user->photo->file_name;
                 $user_photo_content_url=$val->user->photo->content_url;
                 $user_photo_mapped_content_url=$val->user->photo->mapped_content_url;
                 $user_photo_content_type=$val->user->photo->content_type;
                 $user_photo_size=$val->user->photo->size;
                 $user_photo_width=$val->user->photo->width;
                 $user_photo_height=$val->user->photo->height;
                 $user_photo_inline=$val->user->photo->inline;
                 $user_photo_deleted=$val->user->photo->deleted;
                 $user_photo_inline=$val->user->photo->inline;
                 $locale_id=$val->user->locale_id;
                 $locale=$val->user->locale;
                 $organization_id=$val->user->organization_id;
                 $role=$val->user->role;
                 $verified=$val->user->verified;
                 $external_id=$val->user->external_id;
                 $alias=$val->user->alias;
                 $active=$val->user->active;
                 $shared=$val->user->shared;
                 $last_login_at=$val->user->last_login_at;
                 $two_factor_auth_enabled=$val->user->two_factor_auth_enabled;
                 $signature=$val->user->signature;
                 $details=$val->user->details;
                 $notes=$val->user->notes;
                 $role_type=$val->user->role_type;
                 $custom_role_id=$val->user->custom_role_id;
                 $moderator=$val->user->moderator;
                 $ticket_restriction=$val->user->ticket_restriction;
                 $only_private_comments=$val->user->only_private_comments;
                 $restricted_agent=$val->user->restricted_agent;
                 $suspended=$val->user->suspended;
                 $default_group_id=$val->user->default_group_id;
                 $report_csv=$val->user->report_csv;
                 $user_fields_at_risk=$val->user->user_fields->at_risk;
                 $user_fields_phone_number=$val->user->user_fields->phone_number;
                 $actor_1_id=$val->actor->id;
                 $actor_url=$val->actor->url;
                 $actor_name=$val->actor->name;
                 $actor_email=$val->actor->email;
                 $actor_created_at=$val->actor->created_at;
                 $actor_updated_at=$val->actor->updated_at;
                 $actor_time_zone=$val->actor->time_zone;
                 $actor_iana_time_zone=$val->actor->iana_time_zone;
                 $actor_phone=$val->actor->phone;
                $actor_shared_phone_number=$val->actor->shared_phone_number;
                 $actor_photo_url=$val->actor->photo->url;
                 $actor_photo_id=$val->actor->photo->id;
                 $actor_photo_file_name=$val->actor->photo->file_name;
                $actor_photo_content_url=$val->actor->photo->content_url;
                 $actor_photo_mapped_content_url=$val->actor->photo->mapped_content_url;
                 $actor_photo_content_type=$val->actor->photo->content_type;
                 $actor_photo_size=$val->actor->photo->size;
                $actor_photo_width=$val->actor->photo->width;
                 $actor_photo_height=$val->actor->photo->height;
                $actor_photo_inline=$val->actor->photo->inline;
                 $actor_photo_deleted=$val->actor->photo->deleted;
                 $actor_photo_thumbnails_url=$val->actor->photo->thumbnails[0]->url;
                $actor_photo_thumbnails_id=$val->actor->photo->thumbnails[0]->id;
                 $actor_photo_thumbnails_file_name=$val->actor->photo->thumbnails[0]->file_name;
                 $actor_photo_thumbnails_content_url=$val->actor->photo->thumbnails[0]->content_url;
                 $actor_photo_thumbnails_mapped_content_url=$val->actor->photo->thumbnails[0]->mapped_content_url;
                 $actor_photo_thumbnails_content_content_type=$val->actor->photo->thumbnails[0]->content_type;
                 $actor_photo_thumbnails_content_size=$val->actor->photo->thumbnails[0]->size;
                 $actor_photo_thumbnails_content_width=$val->actor->photo->thumbnails[0]->width;
                 $actor_photo_thumbnails_content_height=$val->actor->photo->thumbnails[0]->height;
                 $actor_photo_thumbnails_content_inline=$val->actor->photo->thumbnails[0]->inline;
                 $actor_photo_thumbnails_content_deleted=$val->actor->photo->thumbnails[0]->deleted;
                 $actor_locale_id=$val->actor->locale_id;
                 $actor_locale=$val->actor->locale;
                 $actor_organization_id=$val->actor->organization_id;
                 $actor_role=$val->actor->role;
                 $actor_verified=$val->actor->verified;
                 $actor_external_id=$val->actor->external_id;
                 $actor_alias=$val->actor->alias;
                 $actor_active=$val->actor->active;
                 $actor_shared_agent=$val->actor->shared_agent;
                 $actor_last_login_at=$val->actor->last_login_at;
                 $actor_two_factor_auth_enabled=$val->actor->two_factor_auth_enabled;
                 $actor_signature=$val->actor->signature;
                 $actor_details=$val->actor->details;
                 $actor_notes=$val->actor->notes;
                 $actor_signature=$val->actor->signature;
                 $actor_role_type=$val->actor->role_type;
                 $actor_custom_role_id=$val->actor->custom_role_id;
                 $actor_moderator=$val->actor->moderator;
                 $actor_ticket_restriction=$val->actor->ticket_restriction;
                 $actor_ticket_only_private_comments=$val->actor->only_private_comments;
                 $actor_restricted_agent=$val->actor->restricted_agent;
                 $actor_suspended=$val->actor->suspended;
                 $actor_default_group_id=$val->actor->default_group_id;
                 $actor_user_fields_at_risk=$val->actor->user_fields->at_risk;
                 $actor_user_fields_phone_number=$val->actor->user_fields->phone_number;


                


                 //echo '<pre>';print_r ($val);die;

                
                 //$lineData = array ($url, $id, $title, $verb, $actor_id, $updated_at,$created_at, $object_ticket_subject,$object_ticket_subject,$user_name);
                 $lineData = array ($url, $id, $title, $verb, $actor_id, $updated_at,$user_id,$created_at,$object_ticket_id,$object_ticket_subject,$user_name,$user_id,$user_url,$user_email,$user_created_at,$user_updated_at,$user_time_zone,$user_iana_time_zone,$user_phone,$user_shared_phone_number,$user_photo_url,$user_photo_id,$user_photo_file_name,$user_photo_content_url,$user_photo_mapped_content_url,$user_photo_content_type,$user_photo_size,$user_photo_width,$user_photo_height,$user_photo_inline,$user_photo_deleted,$user_photo_inline,$locale_id,$locale,$organization_id,$role,$verified,$external_id,$alias,$active,$shared,$last_login_at,$two_factor_auth_enabled,$signature,$details,$notes,$role_type,$custom_role_id,$moderator,$ticket_restriction,$only_private_comments,$restricted_agent,$suspended,$default_group_id,$report_csv,$user_fields_at_risk,$user_fields_phone_number,$actor_id,$actor_url,$actor_name,$actor_email,$actor_created_at,$actor_updated_at,$actor_time_zone,$actor_iana_time_zone,$actor_phone,$actor_shared_phone_number,$actor_photo_url,$actor_photo_id,$actor_photo_file_name,$actor_photo_content_url,$actor_photo_mapped_content_url,$actor_photo_content_type,$actor_photo_size,$actor_photo_width,$actor_photo_height,$actor_photo_inline,$actor_photo_deleted,$actor_photo_thumbnails_url,$actor_photo_thumbnails_id,$actor_photo_thumbnails_file_name,$actor_photo_thumbnails_content_url,$actor_photo_thumbnails_mapped_content_url,$actor_photo_thumbnails_content_content_type,$actor_photo_thumbnails_content_size,$actor_photo_thumbnails_content_width,$actor_photo_thumbnails_content_height,$actor_photo_thumbnails_content_inline,$actor_photo_thumbnails_content_deleted,$actor_locale_id,$actor_locale,$actor_organization_id,$actor_role,$actor_verified,$actor_external_id,$actor_alias,$actor_active,$actor_shared_agent,$actor_last_login_at,$actor_two_factor_auth_enabled,$actor_signature,$actor_details,$actor_notes,$actor_signature,$actor_role_type,$actor_custom_role_id,$actor_moderator,$actor_ticket_restriction,$actor_ticket_only_private_comments,$actor_restricted_agent,$actor_suspended,$actor_default_group_id,$actor_user_fields_at_risk,$actor_user_fields_phone_number);

                //print_r($lineData);exit();
			    fputcsv($f, $lineData, $delimiter);
                //fputcsv($file,$line);
                 
                 
                //echo $iana_time_zone=$val->user->photo->url;exit();

                
            }
          
          }

          fclose($f); 
          exit; 

          
        
        
        
    }




    public function get_tickets_data_csv()
    { 

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://smartflatssupport.zendesk.com/api/v2/tickets.json?Key=authorization&Value=Basic%20YWR1QHNtYXJ0ZmxhdHMuYmUvdG9rZW46alZRZXhob3dPUk5ZT3FBekhNcndMV1g0VXVIRkpJMUY1Y092MzlRRQ====',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'email_address: adu@smartflats.be',
            'token: jVQexhowORNYOqAzHMrwLWX4UuHFJI1F5cOv39QE',
            'authorization: Basic YWR1QHNtYXJ0ZmxhdHMuYmUvdG9rZW46alZRZXhob3dPUk5ZT3FBekhNcndMV1g0VXVIRkpJMUY1Y092MzlRRQ===='
            
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        //echo $response;
        $data=json_decode($response);
         $res_data = $data;
         //print_r($data);die;
         $delimiter = ",";
         $filename = 'tickets'.date('Ymd').'.csv'; 
         header("Content-Description: File Transfer"); 
         header("Content-Disposition: attachment; filename=$filename"); 
         header("Content-Type: application/csv; ");
         $f = fopen('php://output', 'w');
	    $header = array("url","id","external_id","via_from_address","via_from_name","via_to_address","via_to_name","via_rel","created_at","updated_at","type","subject","raw_subject","description","priority","status","recipient","requester_id","assignee_id","organization_id","group_id","collaborator_ids0","collaborator_ids1","collaborator_ids2","collaborator_ids3","email_cc_ids0","email_cc_ids1","email_cc_ids2","email_cc_ids3","forum_topic_id","problem_id","has_incidents","is_public","due_at","custom_fields_id","custom_fields_value","custom_fields_id1","custom_fields_id2","brand_id","allow_channelback","allow_attachments");
        fputcsv($f, $header, $delimiter);

        foreach($res_data as $key=>$value){
            // $url = $value['url'];
            //echo '<pre>';print_r ($value);die;
            foreach ($value as $key => $val) {
             //echo '<pre>';print_r ($val);die;
                 $url=$val->url;
                 $id=$val->id;
                 $external_id=$val->external_id;
                 $via_from_address=$val->via->source->from->address;
                 $via_from_name=$val->via->source->from->name;
                 $via_to_address=$val->via->source->to->address;
                 $via_to_name=$val->via->source->to->name;
                 $via_rel=$val->via->source->rel;
                 $created_at=$val->created_at;
                 $updated_at=$val->updated_at;
                 $type=$val->type;
                 $subject=$val->subject;
                 $raw_subject=$val->raw_subject;
                 $description=$val->description;
                 $priority=$val->priority;
                 $status=$val->status;
                 $recipient=$val->recipient;
                 $requester_id=$val->requester_id;
                 $assignee_id=$val->assignee_id;
                 $organization_id=$val->organization_id;
                 $group_id=$val->group_id;
                 $collaborator_ids0=$val->collaborator_ids[0];
                 $collaborator_ids1=$val->collaborator_ids[1];
                 $collaborator_ids2=$val->collaborator_ids[2];
                 $collaborator_ids3=$val->collaborator_ids[3];
                 $email_cc_ids0=$val->email_cc_ids[0];
                 $email_cc_ids1=$val->email_cc_ids[1];
                 $email_cc_ids2=$val->email_cc_ids[2];
                 $email_cc_ids3=$val->email_cc_ids[3];
                 $forum_topic_id=$val->forum_topic_id;
                 $problem_id=$val->problem_id;
                 $has_incidents=$val->has_incidents;
                 $is_public=$val->is_public;
                 $due_at=$val->due_at;
                 $custom_fields_id=$val->custom_fields[0]->id;
                 $custom_fields_value=$val->custom_fields[0]->value;
                 $custom_fields_id1=$val->custom_fields[1]->id;
                 $custom_fields_id2=$val->custom_fields[2]->id;
                 $brand_id=$val->brand_id;
                 $allow_channelback=$val->allow_channelback;
                 $allow_attachments=$val->allow_attachments;

                 $lineData = array ($url,$id,$external_id,$via_from_address,$via_from_name,$via_to_address,$via_to_name,$via_rel,$created_at,$updated_at,$type,$subject,$raw_subject,$description,$priority,$status,$recipient,$requester_id,$assignee_id,$organization_id,$group_id,$collaborator_ids0,$collaborator_ids1,$collaborator_ids2,$collaborator_ids3,$email_cc_ids0,$email_cc_ids1,$email_cc_ids2,$email_cc_ids3,$forum_topic_id,$problem_id,$has_incidents,$is_public,$due_at,$custom_fields_id,$custom_fields_value,$custom_fields_id1,$custom_fields_id2,$brand_id,$allow_channelback,$allow_attachments);
                 fputcsv($f, $lineData, $delimiter);
            }
         }
         fclose($f); 
         exit; 


    }



    public function get_activities_data_insert()
    { 
        
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://smartflatssupport.zendesk.com/api/v2/activities.json?Key=authorization&Value=Basic%20YWR1QHNtYXJ0ZmxhdHMuYmUvdG9rZW46alZRZXhob3dPUk5ZT3FBekhNcndMV1g0VXVIRkpJMUY1Y092MzlRRQ====',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'email_address: adu@smartflats.be',
            'token: jVQexhowORNYOqAzHMrwLWX4UuHFJI1F5cOv39QE',
            'authorization: Basic YWR1QHNtYXJ0ZmxhdHMuYmUvdG9rZW46alZRZXhob3dPUk5ZT3FBekhNcndMV1g0VXVIRkpJMUY1Y092MzlRRQ===='
            
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        //echo $response;

         $data=json_decode($response);
         $res_data = $data;

        // echo '<pre>';print_r ($data);die;
        
        foreach($res_data as $key=>$value){
            // $url = $value['url'];
            // echo '<pre>';print_r ($value);die;
            foreach ($value as $key => $val) {

                
                //echo '<pre>';print_r ($val);die;
                 $ref_url=$val->url;
                 $ref_id=$val->id;
                 $title=$val->title;
                 $verb=$val->verb;
                 $user_id=$val->user_id;
                 $actor_id=$val->actor_id;
                 $updated_at=$val->updated_at;
                 $created_at=$val->created_at;
                 $object_ticket_id=$val->object->ticket->id ;
                 $object_ticket_subject=$val->object->ticket->subject;
                 $user_name=$val->user->name;
                 $user_user_id=$val->user->id;
                 $user_url=$val->user->url;
                 $user_email=$val->user->email;
                 $user_created_at=$val->user->created_at;
                 $user_updated_at=$val->user->updated_at;
                 $user_time_zone=$val->user->time_zone;
                 $user_iana_time_zone=$val->user->iana_time_zone;
                 $user_phone=$val->user->phone;
                 $user_shared_phone_number=$val->user->shared_phone_number;
                 $user_photo_url=$val->user->photo->url;
                 $user_photo_id=$val->user->photo->id;
                 $user_photo_file_name=$val->user->photo->file_name;
                 $user_photo_content_url=$val->user->photo->content_url;
                 $user_photo_mapped_content_url=$val->user->photo->mapped_content_url;
                 $user_photo_content_type=$val->user->photo->content_type;
                 $user_photo_size=$val->user->photo->size;
                 $user_photo_width=$val->user->photo->width;
                 $user_photo_height=$val->user->photo->height;
                 $user_photo_inline=$val->user->photo->inline;
                 $user_photo_deleted=$val->user->photo->deleted;
                 $user_photo_inline=$val->user->photo->inline;
                 $locale_id=$val->user->locale_id;
                 $locale=$val->user->locale;
                 $organization_id=$val->user->organization_id;
                 $role=$val->user->role;
                 $verified=$val->user->verified;
                 $external_id=$val->user->external_id;
                 $alias=$val->user->alias;
                 $active=$val->user->active;
                 $shared=$val->user->shared;
                 $last_login_at=$val->user->last_login_at;
                 $two_factor_auth_enabled=$val->user->two_factor_auth_enabled;
                 $signature=$val->user->signature;
                 $details=$val->user->details;
                 $notes=$val->user->notes;
                 $role_type=$val->user->role_type;
                 $custom_role_id=$val->user->custom_role_id;
                 $moderator=$val->user->moderator;
                 $ticket_restriction=$val->user->ticket_restriction;
                 $only_private_comments=$val->user->only_private_comments;
                 $restricted_agent=$val->user->restricted_agent;
                 $suspended=$val->user->suspended;
                 $default_group_id=$val->user->default_group_id;
                 $report_csv=$val->user->report_csv;
                 $user_fields_at_risk=$val->user->user_fields->at_risk;
                 $user_fields_phone_number=$val->user->user_fields->phone_number;
                 $actor_1_id=$val->actor->id;
                 $actor_url=$val->actor->url;
                 $actor_name=$val->actor->name;
                 $actor_email=$val->actor->email;
                 $actor_created_at=$val->actor->created_at;
                 $actor_updated_at=$val->actor->updated_at;
                 $actor_time_zone=$val->actor->time_zone;
                 $actor_iana_time_zone=$val->actor->iana_time_zone;
                 $actor_phone=$val->actor->phone;
                 $actor_shared_phone_number=$val->actor->shared_phone_number;
                 $actor_photo_url=$val->actor->photo->url;
                 $actor_photo_id=$val->actor->photo->id;
                 $actor_photo_file_name=$val->actor->photo->file_name;
                 $actor_photo_content_url=$val->actor->photo->content_url;
                 $actor_photo_mapped_content_url=$val->actor->photo->mapped_content_url;
                 $actor_photo_content_type=$val->actor->photo->content_type;
                 $actor_photo_size=$val->actor->photo->size;
                 $actor_photo_width=$val->actor->photo->width;
                 $actor_photo_height=$val->actor->photo->height;
                 $actor_photo_inline=$val->actor->photo->inline;
                 $actor_photo_deleted=$val->actor->photo->deleted;
                 $actor_photo_thumbnails_url=$val->actor->photo->thumbnails[0]->url;
                 $actor_photo_thumbnails_id=$val->actor->photo->thumbnails[0]->id;
                 $actor_photo_thumbnails_file_name=$val->actor->photo->thumbnails[0]->file_name;
                 $actor_photo_thumbnails_content_url=$val->actor->photo->thumbnails[0]->content_url;
                 $actor_photo_thumbnails_mapped_content_url=$val->actor->photo->thumbnails[0]->mapped_content_url;
                 $actor_photo_thumbnails_content_content_type=$val->actor->photo->thumbnails[0]->content_type;
                 $actor_photo_thumbnails_content_size=$val->actor->photo->thumbnails[0]->size;
                 $actor_photo_thumbnails_content_width=$val->actor->photo->thumbnails[0]->width;
                  $actor_photo_thumbnails_content_height=$val->actor->photo->thumbnails[0]->height;
                 $actor_photo_thumbnails_content_inline=$val->actor->photo->thumbnails[0]->inline;
                 $actor_photo_thumbnails_content_deleted=$val->actor->photo->thumbnails[0]->deleted;
                 $actor_locale_id=$val->actor->locale_id;
                 $actor_locale=$val->actor->locale;
                 $actor_organization_id=$val->actor->organization_id;
                 $actor_role=$val->actor->role;
                 $actor_verified=$val->actor->verified;
                 $actor_external_id=$val->actor->external_id;
                 $actor_alias=$val->actor->alias;
                 $actor_active=$val->actor->active;
                 $actor_shared_agent=$val->actor->shared_agent;
                 $actor_last_login_at=$val->actor->last_login_at;
                 $actor_two_factor_auth_enabled=$val->actor->two_factor_auth_enabled;
                 $actor_signature=$val->actor->signature;
                 $actor_details=$val->actor->details;
                 $actor_notes=$val->actor->notes;
                 $actor_signature=$val->actor->signature;
                 $actor_role_type=$val->actor->role_type;
                 $actor_custom_role_id=$val->actor->custom_role_id;
                 $actor_moderator=$val->actor->moderator;
                 $actor_ticket_restriction=$val->actor->ticket_restriction;
                 $actor_ticket_only_private_comments=$val->actor->only_private_comments;
                 $actor_restricted_agent=$val->actor->restricted_agent;
                 $actor_suspended=$val->actor->suspended;
                 $actor_default_group_id=$val->actor->default_group_id;
                 $actor_user_fields_at_risk=$val->actor->user_fields->at_risk;
                 $actor_user_fields_phone_number=$val->actor->user_fields->phone_number;

                 $user_photo_thumbnails_url=$val->user->photo->thumbnails[0]->url;
                 $user_photo_thumbnails_id=$val->user->photo->thumbnails[0]->id;
                 $user_photo_thumbnails_file_name=$val->user->photo->thumbnails[0]->file_name;
                 $user_photo_thumbnails_content_url=$val->user->photo->thumbnails[0]->content_url;
                 $user_photo_thumbnails_mapped_content_url=$val->user->photo->thumbnails[0]->mapped_content_url;
                 $user_photo_thumbnails_content_content_type=$val->user->photo->thumbnails[0]->content_type;
                 $user_photo_thumbnails_content_size=$val->user->photo->thumbnails[0]->size;
                 $user_photo_thumbnails_content_width=$val->user->photo->thumbnails[0]->width;
                 $user_photo_thumbnails_content_height=$val->user->photo->thumbnails[0]->height;
                 $user_photo_thumbnails_content_inline=$val->user->photo->thumbnails[0]->inline;
                 $user_photo_thumbnails_content_deleted=$val->user->photo->thumbnails[0]->deleted;
                



                 $data_array= array(
                    'ref_url' =>$ref_url,
                    'ref_id' =>$ref_id,
                    'title'=>$title,
                    'verb'=>$verb,
                    'actor_id'=>$actor_id,
                    'updated_at'=>$updated_at,
                    'created_at'=>$created_at,
                    'object_ticket_id'=>$object_ticket_id,
                    'object_ticket_subject'=>$object_ticket_subject,
                    'user_name'=>$user_name,
                    'user_user_id'=>$user_user_id,
                    'user_url'=>$user_url,
                    'user_email'=>$user_email,
                    'user_created_at'=>$user_created_at,
                    'user_updated_at'=>$user_updated_at,
                    'user_time_zone'=>$user_time_zone,
                    'user_iana_time_zone'=>$user_iana_time_zone,
                    'user_phone'=>$user_phone,
                    'user_shared_phone_number'=>$user_shared_phone_number,
                    'user_photo_url'=>$user_photo_url,
                    'user_photo_id'=>$user_photo_id,
                    'user_photo_file_name'=>$user_photo_file_name,
                    'user_photo_content_url'=>$user_photo_content_url,
                    'user_photo_mapped_content_url'=>$user_photo_mapped_content_url,
                    'user_photo_content_type'=>$user_photo_content_type,
                    'user_photo_size'=>$user_photo_size,
                    'user_photo_width'=>$user_photo_width,
                    'user_photo_height'=>$user_photo_height,
                    'user_photo_inline'=>$user_photo_inline,
                    'user_photo_deleted'=>$user_photo_deleted,
                    'locale_id'=>$locale_id,
                    'actor_locale'=>$actor_locale,
                    'actor_organization_id'=>$actor_organization_id,
                    'actor_role'=>$actor_role,
                    'actor_verified'=>$actor_verified,
                    'actor_external_id'=>$actor_external_id,
                    'actor_alias'=>$actor_alias,
                    'actor_active'=>$actor_active,
                    'actor_shared_agent'=>$actor_shared_agent,
                    'actor_last_login_at'=>$actor_last_login_at,
                    'actor_two_factor_auth_enabled'=>$actor_two_factor_auth_enabled,
                    'actor_signature'=>$actor_signature,
                    'actor_details'=>$actor_details,
                    'actor_notes'=>$actor_notes,
                    'actor_signature'=>$actor_signature,
                    'actor_role_type'=>$actor_role_type,
                    'actor_custom_role_id'=>$actor_custom_role_id,
                    'actor_moderator'=>$actor_moderator,
                    'actor_ticket_restriction'=>$actor_ticket_restriction,
                    'actor_ticket_only_private_comments'=>$actor_ticket_only_private_comments,
                    'actor_restricted_agent'=>$actor_restricted_agent,
                    'actor_suspended'=>$actor_suspended,
                    'actor_default_group_id'=>$actor_default_group_id,
                    'actor_user_fields_at_risk'=>$actor_user_fields_at_risk,
                    'actor_user_fields_phone_number'=>$actor_user_fields_phone_number,

                    'actor_photo_thumbnails_url'=>$actor_photo_thumbnails_url,
                    'actor_photo_thumbnails_id'=>$actor_photo_thumbnails_id,
                    'actor_photo_thumbnails_file_name'=>$actor_photo_thumbnails_file_name,
                    'actor_photo_thumbnails_content_url'=>$actor_photo_thumbnails_content_url,
                    'actor_photo_thumbnails_mapped_content_url'=>$actor_photo_thumbnails_mapped_content_url,
                    'actor_photo_thumbnails_content_content_type'=>$actor_photo_thumbnails_content_content_type,
                    'actor_photo_thumbnails_content_size'=>$actor_photo_thumbnails_content_size,
                    'actor_photo_thumbnails_content_width'=>$actor_photo_thumbnails_content_width,
                    'actor_photo_thumbnails_content_height'=>$actor_photo_thumbnails_content_height,
                    'actor_photo_thumbnails_content_inline'=>$actor_photo_thumbnails_content_inline,
                    'actor_photo_thumbnails_content_deleted'=>$actor_photo_thumbnails_content_deleted,

                    'user_photo_thumbnails_url'=>$user_photo_thumbnails_url,
                    'user_photo_thumbnails_id'=>$user_photo_thumbnails_id,
                    'user_photo_thumbnails_file_name'=>$user_photo_thumbnails_file_name,
                    'user_photo_thumbnails_content_url'=>$user_photo_thumbnails_content_url,
                    'user_photo_thumbnails_mapped_content_url'=>$user_photo_thumbnails_mapped_content_url,
                    'user_photo_thumbnails_content_content_type'=>$user_photo_thumbnails_content_content_type,
                    'user_photo_thumbnails_content_size'=>$user_photo_thumbnails_content_size,
                    'user_photo_thumbnails_content_width'=>$user_photo_thumbnails_content_width,
                    'user_photo_thumbnails_content_height'=>$user_photo_thumbnails_content_height,
                    'user_photo_thumbnails_content_inline'=>$user_photo_thumbnails_content_inline,
                    'user_photo_thumbnails_content_deleted'=>$user_photo_thumbnails_content_deleted,


                    );
                    data_inserter('zendesk_activities_details', $data_array);


                


                 //echo '<pre>';print_r ($val);die;

                
                 
            

                
            }
          
          }


          
        
        
        
    }

    /////////////////////   group data  ////////////////////

    public function get_group_data_insert()
    { 
        
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://smartflatssupport.zendesk.com/api/v2/groups.json?Key=authorization&Value=Basic%20YWR1QHNtYXJ0ZmxhdHMuYmUvdG9rZW46alZRZXhob3dPUk5ZT3FBekhNcndMV1g0VXVIRkpJMUY1Y092MzlRRQ====',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'email_address: adu@smartflats.be',
            'token: jVQexhowORNYOqAzHMrwLWX4UuHFJI1F5cOv39QE',
            'authorization: Basic YWR1QHNtYXJ0ZmxhdHMuYmUvdG9rZW46alZRZXhob3dPUk5ZT3FBekhNcndMV1g0VXVIRkpJMUY1Y092MzlRRQ===='
            
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        //echo $response;

         $data=json_decode($response);
         $res_data = $data;

         //echo '<pre>';print_r ($data);die;
        
        foreach($res_data as $key=>$val){
            // $url = $value['url'];
             //echo '<pre>';print_r ($value);die;
             echo '<pre>';print_r ($val);die;
             echo $url=$val->url;die;
             $id=$val->id;
             $is_public=$val->is_public;
             $name=$val->name;
             $description=$val->description;
             $default=$val->default;
             $deleted=$val->deleted;
             $created_at=$val->created_at;
             $updated_at=$val->updated_at ;

             $data_array= array(
                'url' =>$url,
                'group_id' =>$id,
                'is_public'=>$is_public,
                'name'=>$name,
                'description'=>$description,
                'updated_at'=>$updated_at,
                'created_at'=>$created_at,
                'default_data'=>$default,
                'deleted'=>$deleted

                );
                data_inserter('zendesk_groups_details', $data_array);


            
          
          }


          
        
        
        
    }



    /////////////////////  group data  //////////////////////


    public function get_tickets_data_insert()
    {


        
        
         for($i = 724; $i <=752; $i++) {

            $curl = curl_init();
        

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://smartflatssupport.zendesk.com/api/v2/tickets.json?page='.$i,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'email_address: adu@smartflats.be',
                'token: jVQexhowORNYOqAzHMrwLWX4UuHFJI1F5cOv39QE',
                'authorization: Basic YWR1QHNtYXJ0ZmxhdHMuYmUvdG9rZW46alZRZXhob3dPUk5ZT3FBekhNcndMV1g0VXVIRkpJMUY1Y092MzlRRQ===='
                
            ),
            ));
    
            $response = curl_exec($curl);
    
            curl_close($curl);
            //echo $response;
    
             $data=json_decode($response);
             $res_data = $data;

             //echo '<pre>';print_r ($res_data);die;
    
            $next_page = $res_data->next_page;

            

            if ($next_page=='null'){
                break;
             }
             else{

                foreach($res_data as $key=>$value){
                    // $url = $value['url'];
                   //echo '<pre>';print_r ($value);die;
                    foreach ($value as $key => $val) {

                        //echo '<pre>';print_r ($value);die;
        
                        $url=$val->url;
                        $ref_id=$val->id;
                        $external_id=$val->external_id;
                        $via_from_address=$val->via->source->from->address;
                        $via_from_name=$val->via->source->from->name;
                        $via_to_address=$val->via->source->to->address;
                        $via_to_name=$val->via->source->to->name;
                        $via_rel=$val->via->source->rel;
                        $created_at=$val->created_at;
                        $updated_at=$val->updated_at;
                        $type=$val->type;
                        $subject=$val->subject;
                        $raw_subject=$val->raw_subject;
                        $description=$val->description;
                        $priority=$val->priority;
                        $status=$val->status;
                        $recipient=$val->recipient;
                        $requester_id=$val->requester_id;
                        $assignee_id=$val->assignee_id;
                        $organization_id=$val->organization_id;
                        $group_id=$val->group_id;
                        $collaborator_ids0=$val->collaborator_ids[0];
                        $collaborator_ids1=$val->collaborator_ids[1];
                        $collaborator_ids2=$val->collaborator_ids[2];
                        $collaborator_ids3=$val->collaborator_ids[3];
                        $email_cc_ids0=$val->email_cc_ids[0];
                        $email_cc_ids1=$val->email_cc_ids[1];
                        $email_cc_ids2=$val->email_cc_ids[2];
                        $email_cc_ids3=$val->email_cc_ids[3];
                        $forum_topic_id=$val->forum_topic_id;
                        $problem_id=$val->problem_id;
                        $has_incidents=$val->has_incidents;
                        $is_public=$val->is_public;
                        $due_at=$val->due_at;
                        $custom_status_id=$val->custom_status_id;
                        $custom_fields_id=$val->custom_fields[0]->id;
                        $custom_fields_value=$val->custom_fields[0]->value;
                        $custom_fields_id1=$val->custom_fields[1]->id;
                        $custom_fields_id2=$val->custom_fields[2]->id;
                        $brand_id=$val->brand_id;
                        $allow_channelback=$val->allow_channelback;
                        $allow_attachments=$val->allow_attachments;
        
        
        
                        $data_array= array(
                            'url' =>$url,
                            'ref_id' =>$ref_id,
                            'external_id'=>$external_id,
                            'via_from_address'=>$via_from_address,
                            'via_from_name'=>$via_from_name,
                            'via_to_address'=>$via_to_address,
                            'via_to_name'=>$via_to_name,
                            'via_rel'=>$via_rel,
                            'created_at'=>$created_at,
                            'updated_at'=>$updated_at,
                            'type'=>$type,
                            'subject'=>$subject,
                            'raw_subject'=>$raw_subject,
                            'description'=>$description,
                            'priority'=>$priority,
                            'status'=>$status,
                            'recipient'=>$recipient,
                            'requester_id'=>$requester_id,
                            'assignee_id'=>$assignee_id,
                            'organization_id'=>$organization_id,
                            'group_id'=>$group_id,
                            'collaborator_ids0'=>$collaborator_ids0,
                            'collaborator_ids1'=>$collaborator_ids1,
                            'collaborator_ids2'=>$collaborator_ids2,
                            'collaborator_ids3'=>$collaborator_ids3,
                            'email_cc_ids0'=>$email_cc_ids0,
                            'email_cc_ids1'=>$email_cc_ids1,
                            'email_cc_ids2'=>$email_cc_ids2,
                            'email_cc_ids3'=>$email_cc_ids3,
                            'forum_topic_id'=>$forum_topic_id,
                            'problem_id'=>$problem_id,
                            'has_incidents'=>$has_incidents,
                            'is_public'=>$is_public,
                            'due_at'=>$due_at,
                            'custom_status_id'=>$custom_status_id,
                            'custom_fields_id'=>$custom_fields_id,
                            'custom_fields_value'=>$custom_fields_value,
                            'custom_fields_id1'=>$custom_fields_id1,
                            'custom_fields_id2'=>$custom_fields_id2,
                            'brand_id'=>$brand_id,
                            'allow_channelback'=>$allow_channelback,
                            'allow_attachments'=>$allow_attachments
                        
        
                            );
                            data_inserter('zendesk_tickets_details', $data_array);
        
        
                        
        
                        
        
        
                         //echo '<pre>';print_r ($val);die;
        
                        
                         
                    
        
                        
                    }
                  
                  }
                
             }

             echo $next_page;

            
           

         }
       


          
        
        
        
    }




    ////////////////////////////////////////////////////////////////////////////////////////////////////////


    public function get_tickets_cur_data_insert()
    {
  
         for($i = 1; $i <=50; $i++) {
            //$date= date('Y-m-d');
            $date= '2022-10-21';
            $url="https://smartflatssupport.zendesk.com/api/v2/search.json?page=".$i." &&query=type:ticket created>=".$date;
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'email_address: adu@smartflats.be',
                'token: jVQexhowORNYOqAzHMrwLWX4UuHFJI1F5cOv39QE',
                'authorization: Basic YWR1QHNtYXJ0ZmxhdHMuYmUvdG9rZW46alZRZXhob3dPUk5ZT3FBekhNcndMV1g0VXVIRkpJMUY1Y092MzlRRQ===='
                
            ),
            ));
    
            $response = curl_exec($curl);
    
            curl_close($curl);
            //echo $response;
    
             $data=json_decode($response);
             $res_data = $data;

             //echo '<pre>';print_r ($res_data);die;
    
            $next_page = $res_data->next_page;

            //echo $next_page;die;

            

            if ($next_page=='null'){
                break;
             }
             else{

                foreach($res_data as $key=>$value){
                    // $url = $value['url'];
                   //echo '<pre>';print_r ($value);die;
                    foreach ($value as $key => $val) {

                        //echo '<pre>';print_r ($value);die;
        
                        $url=$val->url;
                        $ref_id=$val->id;
                        $external_id=$val->external_id;
                        $via_from_address=$val->via->source->from->address;
                        $via_from_name=$val->via->source->from->name;
                        $via_to_address=$val->via->source->to->address;
                        $via_to_name=$val->via->source->to->name;
                        $via_rel=$val->via->source->rel;
                        $created_at=$val->created_at;
                        $updated_at=$val->updated_at;
                        $type=$val->type;
                        $subject=$val->subject;
                        $raw_subject=$val->raw_subject;
                        $description=$val->description;
                        $priority=$val->priority;
                        $status=$val->status;
                        $recipient=$val->recipient;
                        $requester_id=$val->requester_id;
                        $assignee_id=$val->assignee_id;
                        $organization_id=$val->organization_id;
                        $group_id=$val->group_id;
                        $collaborator_ids0=$val->collaborator_ids[0];
                        $collaborator_ids1=$val->collaborator_ids[1];
                        $collaborator_ids2=$val->collaborator_ids[2];
                        $collaborator_ids3=$val->collaborator_ids[3];
                        $email_cc_ids0=$val->email_cc_ids[0];
                        $email_cc_ids1=$val->email_cc_ids[1];
                        $email_cc_ids2=$val->email_cc_ids[2];
                        $email_cc_ids3=$val->email_cc_ids[3];
                        $forum_topic_id=$val->forum_topic_id;
                        $problem_id=$val->problem_id;
                        $has_incidents=$val->has_incidents;
                        $is_public=$val->is_public;
                        $due_at=$val->due_at;
                        $custom_status_id=$val->custom_status_id;
                        $custom_fields_id=$val->custom_fields[0]->id;
                        $custom_fields_value=$val->custom_fields[0]->value;
                        $custom_fields_id1=$val->custom_fields[1]->id;
                        $custom_fields_id2=$val->custom_fields[2]->id;
                        $brand_id=$val->brand_id;
                        $allow_channelback=$val->allow_channelback;
                        $allow_attachments=$val->allow_attachments;
        
        
        
                        $data_array= array(
                            'url' =>$url,
                            'ref_id' =>$ref_id,
                            'external_id'=>$external_id,
                            'via_from_address'=>$via_from_address,
                            'via_from_name'=>$via_from_name,
                            'via_to_address'=>$via_to_address,
                            'via_to_name'=>$via_to_name,
                            'via_rel'=>$via_rel,
                            'created_at'=>$created_at,
                            'updated_at'=>$updated_at,
                            'type'=>$type,
                            'subject'=>$subject,
                            'raw_subject'=>$raw_subject,
                            'description'=>$description,
                            'priority'=>$priority,
                            'status'=>$status,
                            'recipient'=>$recipient,
                            'requester_id'=>$requester_id,
                            'assignee_id'=>$assignee_id,
                            'organization_id'=>$organization_id,
                            'group_id'=>$group_id,
                            'collaborator_ids0'=>$collaborator_ids0,
                            'collaborator_ids1'=>$collaborator_ids1,
                            'collaborator_ids2'=>$collaborator_ids2,
                            'collaborator_ids3'=>$collaborator_ids3,
                            'email_cc_ids0'=>$email_cc_ids0,
                            'email_cc_ids1'=>$email_cc_ids1,
                            'email_cc_ids2'=>$email_cc_ids2,
                            'email_cc_ids3'=>$email_cc_ids3,
                            'forum_topic_id'=>$forum_topic_id,
                            'problem_id'=>$problem_id,
                            'has_incidents'=>$has_incidents,
                            'is_public'=>$is_public,
                            'due_at'=>$due_at,
                            'custom_status_id'=>$custom_status_id,
                            'custom_fields_id'=>$custom_fields_id,
                            'custom_fields_value'=>$custom_fields_value,
                            'custom_fields_id1'=>$custom_fields_id1,
                            'custom_fields_id2'=>$custom_fields_id2,
                            'brand_id'=>$brand_id,
                            'allow_channelback'=>$allow_channelback,
                            'allow_attachments'=>$allow_attachments
                        
        
                            );
                            data_inserter('zendesk_tickets_details', $data_array);
        
        
                        
        
                        
        
        
                         //echo '<pre>';print_r ($val);die;
        
                        
                         
                    
        
                        
                    }
                  
                  }
                
             }

             echo $next_page;

            
           

         }
       


          
        
        
        
    }


    //////////////////////// insert single ticket ////////////////////////

    public function get_tickets_single_data_insert()
    {
  
         
            $date= date('Y-m-d');
            $url="https://smartflatssupport.zendesk.com/api/v2/tickets/109475";
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'email_address: adu@smartflats.be',
                'token: jVQexhowORNYOqAzHMrwLWX4UuHFJI1F5cOv39QE',
                'authorization: Basic YWR1QHNtYXJ0ZmxhdHMuYmUvdG9rZW46alZRZXhob3dPUk5ZT3FBekhNcndMV1g0VXVIRkpJMUY1Y092MzlRRQ===='
                
            ),
            ));
    
            $response = curl_exec($curl);
    
            curl_close($curl);
            //echo $response;
    
             $data=json_decode($response);
             $res_data = $data;

             //echo '<pre>';print_r ($res_data);die;
    
            //$next_page = $res_data->next_page;

            //echo $next_page;die;

            

           

                foreach($res_data as $key=>$val){
                    // $url = $value['url'];
                   //echo '<pre>';print_r ($value);die;
                    //foreach ($value as $key => $val) {

                        //echo '<pre>';print_r ($value);die;
        
                        $url=$val->url;
                        $ref_id=$val->id;
                        $external_id=$val->external_id;
                        $via_from_address=$val->via->source->from->address;
                        $via_from_name=$val->via->source->from->name;
                        $via_to_address=$val->via->source->to->address;
                        $via_to_name=$val->via->source->to->name;
                        $via_rel=$val->via->source->rel;
                        $created_at=$val->created_at;
                        $updated_at=$val->updated_at;
                        $type=$val->type;
                        $subject=$val->subject;
                        $raw_subject=$val->raw_subject;
                        $description=$val->description;
                        $priority=$val->priority;
                        $status=$val->status;
                        $recipient=$val->recipient;
                        $requester_id=$val->requester_id;
                        $assignee_id=$val->assignee_id;
                        $organization_id=$val->organization_id;
                        $group_id=$val->group_id;
                        $collaborator_ids0=$val->collaborator_ids[0];
                        $collaborator_ids1=$val->collaborator_ids[1];
                        $collaborator_ids2=$val->collaborator_ids[2];
                        $collaborator_ids3=$val->collaborator_ids[3];
                        $email_cc_ids0=$val->email_cc_ids[0];
                        $email_cc_ids1=$val->email_cc_ids[1];
                        $email_cc_ids2=$val->email_cc_ids[2];
                        $email_cc_ids3=$val->email_cc_ids[3];
                        $forum_topic_id=$val->forum_topic_id;
                        $problem_id=$val->problem_id;
                        $has_incidents=$val->has_incidents;
                        $is_public=$val->is_public;
                        $due_at=$val->due_at;
                        $custom_status_id=$val->custom_status_id;
                        $custom_fields_id=$val->custom_fields[0]->id;
                        $custom_fields_value=$val->custom_fields[0]->value;
                        $custom_fields_id1=$val->custom_fields[1]->id;
                        $custom_fields_id2=$val->custom_fields[2]->id;
                        $brand_id=$val->brand_id;
                        $allow_channelback=$val->allow_channelback;
                        $allow_attachments=$val->allow_attachments;
        
        
        
                        $data_array= array(
                            'url' =>$url,
                            'ref_id' =>$ref_id,
                            'external_id'=>$external_id,
                            'via_from_address'=>$via_from_address,
                            'via_from_name'=>$via_from_name,
                            'via_to_address'=>$via_to_address,
                            'via_to_name'=>$via_to_name,
                            'via_rel'=>$via_rel,
                            'created_at'=>$created_at,
                            'updated_at'=>$updated_at,
                            'type'=>$type,
                            'subject'=>$subject,
                            'raw_subject'=>$raw_subject,
                            'description'=>$description,
                            'priority'=>$priority,
                            'status'=>$status,
                            'recipient'=>$recipient,
                            'requester_id'=>$requester_id,
                            'assignee_id'=>$assignee_id,
                            'organization_id'=>$organization_id,
                            'group_id'=>$group_id,
                            'collaborator_ids0'=>$collaborator_ids0,
                            'collaborator_ids1'=>$collaborator_ids1,
                            'collaborator_ids2'=>$collaborator_ids2,
                            'collaborator_ids3'=>$collaborator_ids3,
                            'email_cc_ids0'=>$email_cc_ids0,
                            'email_cc_ids1'=>$email_cc_ids1,
                            'email_cc_ids2'=>$email_cc_ids2,
                            'email_cc_ids3'=>$email_cc_ids3,
                            'forum_topic_id'=>$forum_topic_id,
                            'problem_id'=>$problem_id,
                            'has_incidents'=>$has_incidents,
                            'is_public'=>$is_public,
                            'due_at'=>$due_at,
                            'custom_status_id'=>$custom_status_id,
                            'custom_fields_id'=>$custom_fields_id,
                            'custom_fields_value'=>$custom_fields_value,
                            'custom_fields_id1'=>$custom_fields_id1,
                            'custom_fields_id2'=>$custom_fields_id2,
                            'brand_id'=>$brand_id,
                            'allow_channelback'=>$allow_channelback,
                            'allow_attachments'=>$allow_attachments
                        
        
                            );
                            data_inserter('zendesk_tickets_details', $data_array);die;

                            


        
        
                        
        
                        
        
        
                         //echo '<pre>';print_r ($val);die;
        
                        
                         
                    
        
                        
                    //}
                  
                  }

                  //print_r($data_array);die;
                
             

           
       


          
        
        
        
    //}


    
   }

}

?>
