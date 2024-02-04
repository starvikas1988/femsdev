<?php
defined('BASEPATH') || exit('No direct script access allowed');
class Auth2lib {
    

    var $tenantID;
    var $clientID;
    var $clientSecret;
    var $Token;
    var $baseURL;

    public function __construct($sTenantID="", $sClientID="", $sClientSecret="") {
        $this->CI =& get_instance();
        if($sTenantID!=''&&$sClientID!=''&&$sClientSecret!=''){
            $this->tenantID = $sTenantID;
            $this->clientID = $sClientID;
            $this->clientSecret = $sClientSecret;
            $this->baseURL = 'https://graph.microsoft.com/v1.0/';
            $this->Token = $this->getToken();
        }    
    }

    public function getToken() {
        $oauthRequest = 'client_id=' . $this->clientID . '&scope=https%3A%2F%2Fgraph.microsoft.com%2F.default&client_secret=' . $this->clientSecret . '&grant_type=client_credentials';
        $reply = $this->sendPostRequest('https://login.microsoftonline.com/' . $this->tenantID . '/oauth2/v2.0/token', $oauthRequest);
        $reply = json_decode($reply['data']);
        return $reply->access_token;
    }


    public function sendMail($mailbox, $messageArgs ) {
        if (!$this->Token) {
            throw new Exception('No token defined');
        }

        foreach ($messageArgs['toRecipients'] as $recipient) {
            if ($recipient['name']) {
                $messageArray['toRecipients'][] = array('emailAddress' => array('name' => $recipient['name'], 'address' => $recipient['address']));
            } else {
                $messageArray['toRecipients'][] = array('emailAddress' => array('address' => $recipient['address']));
            }
        }
        foreach ($messageArgs['ccRecipients'] as $recipient) {
            if ($recipient['name']) {
                $messageArray['ccRecipients'][] = array('emailAddress' => array('name' => $recipient['name'], 'address' => $recipient['address']));
            } else {
                $messageArray['ccRecipients'][] = array('emailAddress' => array('address' => $recipient['address']));
            }
        }
        $messageArray['subject'] = $messageArgs['subject'];
        $messageArray['importance'] = ($messageArgs['importance'] ? $messageArgs['importance'] : 'normal');
        if (isset($messageArgs['replyTo'])) $messageArray['replyTo'] = array(array('emailAddress' => array('name' => $messageArgs['replyTo']['name'], 'address' => $messageArgs['replyTo']['address'])));
        $messageArray['body'] = array('contentType' => 'HTML', 'content' => $messageArgs['body']);
        $messageJSON = json_encode($messageArray);
        $response = $this->sendPostRequest($this->baseURL . 'users/' . $mailbox . '/messages', $messageJSON, array('Content-type: application/json'));

        //echo'<br>';print_r($response);
        $response = json_decode($response['data']);
        $messageID = $response->id;

        foreach ($messageArgs['images'] as $image) {
            $messageJSON = json_encode(array('@odata.type' => '#microsoft.graph.fileAttachment', 'name' => $image['Name'], 'contentBytes' => base64_encode($image['Content']), 'contentType' => $image['ContentType'], 'isInline' => true, 'contentId' => $image['ContentID']));
            $response = $this->sendPostRequest($this->baseURL . 'users/' . $mailbox . '/messages/' . $messageID . '/attachments', $messageJSON, array('Content-type: application/json'));
        }

        foreach ($messageArgs['attachments'] as $attachment) {
            $messageJSON = json_encode(array('@odata.type' => '#microsoft.graph.fileAttachment', 'name' => $attachment['Name'], 'contentBytes' => base64_encode($attachment['Content']), 'contentType' => $attachment['ContentType'], 'isInline' => false));
            $response = $this->sendPostRequest($this->baseURL . 'users/' . $mailbox . '/messages/' . $messageID . '/attachments', $messageJSON, array('Content-type: application/json'));
        }
        //Send
        $response = $this->sendPostRequest($this->baseURL . 'users/' . $mailbox . '/messages/' . $messageID . '/send', '', array('Content-Length: 0'));
        if ($response['code'] == '202') return true;
        return false;

    }

    public function basicAddress($addresses) {
        $ret = [];
        $i=0;
        foreach ($addresses as $address) {
            $ret[$i]['email'] = $address->emailAddress->address;
            $ret[$i]['name'] = $address->emailAddress->name;
            $i++;
        }
        return $ret;
    }

    public function sendPostRequest($URL, $Fields, $Headers = false) {
        $ch = curl_init($URL);
        curl_setopt($ch, CURLOPT_POST, 1);
        if ($Fields) curl_setopt($ch, CURLOPT_POSTFIELDS, $Fields);
        if ($Headers) {
            $Headers[] = 'Authorization: Bearer ' . $this->Token;
            curl_setopt($ch, CURLOPT_HTTPHEADER, $Headers);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $responseCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);
        return array('code' => $responseCode, 'data' => $response);
    }

    public function sendGetRequest($URL) {
        $ch = curl_init($URL);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $this->Token, 'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
       
    }
    public function getMessages($mailbox,$search="") {
        if (!$this->Token) {
            throw new Exception('No token defined');
        }
        
        if($search!=""){
            $url=$this->baseURL . 'users/' . $mailbox . '/mailFolders/Inbox/Messages?$filter='.$search;
            $messageList = json_decode($this->sendGetRequest($url));
        }else{
            $messageList = json_decode($this->sendGetRequest($this->baseURL . 'users/' . $mailbox . '/mailFolders/Inbox/Messages?$top=50&$expand=attachments&$filter=isRead+ne+true&$skip=0&$count=true'));
        }
        if (isset($messageList->error)) {
            throw new Exception($messageList->error->code . ' ' . $messageList->error->message);
        }
        $messageArray = array();

       //echo'<pre>';print_r($messageList);die();

        foreach ($messageList->value as $mailItem) {
            $attachments = (json_decode($this->sendGetRequest($this->baseURL . 'users/' . $mailbox . '/messages/' . $mailItem->id . '/attachments')))->value;
            if (count($attachments) < 1) {
                unset($attachments);
            } else {
                $attachments_file=array();
                $i=0;
                foreach ($attachments as $attachment) {
                    
                    if ($attachment->{'@odata.type'} == '#microsoft.graph.referenceAttachment') {
                        $attachment->contentBytes = base64_encode('This is a link to a SharePoint online file, not yet supported');
                        $attachment->isInline = 0;
                    }
                    if($attachment->isInline==1){
                         $imageContentIDToReplace = "cid:" . $attachment->contentId;
                         $contents =$attachment->contentBytes;
                         $body=$mailItem->body->content;
                         $mailItem->body->content=str_replace($imageContentIDToReplace,"data:image/gif;base64,$contents",$body);
                    }else{
                        if($attachment->contentType!='message/rfc822'){
                            $name=$attachment->name;
                            $contentBytes=$attachment->contentBytes;
                            $contentType=$attachment->contentType;
                            $mailbox;
                            $attachments_file[$i]=$attachment;
                            $i++;
                            //$this->attachment_save($name,$contentBytes,$contentType,$mailbox);
                        }
                    }
                }
            }
            //echo'<pre>';print_r($this->basicAddress($mailItem->toRecipients));
            $messageArray[] = array('id' => $mailItem->id,
                        'sentDateTime' => $mailItem->sentDateTime,
                        'subject' => $mailItem->subject,
                        'bodyPreview' => $mailItem->bodyPreview,
                        'importance' => $mailItem->importance,
                        'flag'=>$mailItem->flag->flagStatus,
                        'conversationId' => $mailItem->conversationId,
                        'categories' =>$mailItem->categories,
                        'hasAttachments'=>$mailItem->hasAttachments,
                        'parentFolderId'=>$mailItem->parentFolderId,
                        'isRead' => $mailItem->isRead,
                        'isDraft'=>$mailItem->isDraft,
                        'webLink'=>$mailItem->webLink,
                        'inferenceClassification'=>$mailItem->inferenceClassification,
                        'from_name'=>$mailItem->from->emailAddress->name,
                        'from_email'=>$mailItem->from->emailAddress->address,
                        'body' => $mailItem->body->content,
                        'sender' => $mailItem->sender,
                        'toRecipients' => $mailItem->toRecipients,
                        'ccRecipients' => $mailItem->ccRecipients,
                        'toRecipientsBasic' => $this->basicAddress($mailItem->toRecipients),
                        'ccRecipientsBasic' => $this->basicAddress($mailItem->ccRecipients),
                        'bccRecipients' => $this->basicAddress($mailItem->bccRecipients),
                        'replyTo' => $this->basicAddress($mailItem->replyTo),
                        'attachments' => isset($attachments) ? $attachments : null,
                        'attachments_file'=>isset($attachments_file)? $attachments_file : null);

        }
        return $messageArray;
    }
    public function deleteEmail($mailbox, $id, $moveToDeletedItems = true) {
        switch ($moveToDeletedItems) {
            case true:
                $this->sendPostRequest($this->baseURL . 'users/' . $mailbox . '/messages/' . $id . '/move', '{ "destinationId": "deleteditems" }', array('Content-type: application/json'));
                break;
            case false:
                $this->sendDeleteRequest($this->baseURL . 'users/' . $mailbox . '/messages/' . $id);
                break;
        }
    }
    public function sendDeleteRequest($URL) {
        $ch = curl_init($URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $this->Token, 'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
    }
    public function markRead($ids,$mailbox){
        $Headers= array('Content-type: application/json');
        $fields=json_encode(array('IsRead'=>true));
        $URL=$this->baseURL.'users/'.$mailbox.'/messages/'.$ids;
        
        $ch = curl_init($URL);
        curl_setopt($ch, CURLOPT_POST, 1);
        if ($fields) curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        if ($Headers) {
            $Headers[] = 'Authorization: Bearer ' . $this->Token;
            curl_setopt($ch, CURLOPT_HTTPHEADER, $Headers);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"PATCH");
        $response = curl_exec($ch);
        $responseCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);
        return array('code' => $responseCode, 'data' => $response);
       // echo'<pre>';print_r($response);
        //echo'<pre>';print_r($responseCode);

    }
    public function folder_list($mailbox){
        $FolderList=array();
        if (!$this->Token) {
            throw new Exception('No token defined');
        }
       // $FolderList = json_decode($this->sendGetRequest($this->baseURL . 'users/' . $mailbox . '/mailFolders/AAMkAGYwMTUxNWI3LTdiNzctNDZhMS1hMTBjLTc5N2NjNjQxMTA0OAAuAAAAAAB3buFFNGqxT5wQLMvCQw8fAQCtmd0Il0ztSItb178AU4kXAAAAAAEIAAA=/childFolders?$top=25'));
       $Folder = json_decode($this->sendGetRequest($this->baseURL . 'users/' . $mailbox . '/mailFolders/?$top=25'));
      
       $list=$Folder->value;
       foreach($list as $key=>$dts){
            $fname=str_replace(" ","_",$dts->displayName);
            $FolderList[$fname]=$dts;
            
            if($dts->childFolderCount!=0){
                //$FolderList[]=
                $CFolder=$this->child_folder_list($mailbox,$dts->id,$fname);
                if(sizeof($CFolder)!=0){
                    foreach($CFolder as $key=>$vl){
                        $FolderList[$key]=$vl;
                    }
                }
            }
       }
       return $FolderList;
        
    }
    public function child_folder_list($mailbox,$ids,$fname){
        if (!$this->Token) {
            throw new Exception('No token defined');
        }
        $FolderList=array();
       // $FolderList = json_decode($this->sendGetRequest($this->baseURL . 'users/' . $mailbox . '/mailFolders/AAMkAGYwMTUxNWI3LTdiNzctNDZhMS1hMTBjLTc5N2NjNjQxMTA0OAAuAAAAAAB3buFFNGqxT5wQLMvCQw8fAQCtmd0Il0ztSItb178AU4kXAAAAAAEIAAA=/childFolders?$top=25'));
       $Folder = json_decode($this->sendGetRequest($this->baseURL . 'users/' . $mailbox . '/mailFolders/'.$ids.'/childFolders?$top=25'));
       $list=$Folder->value;
       foreach($list as $key=>$dts){
        $cname=$fname.'/'.str_replace(" ","_",$dts->displayName);
        $FolderList[$cname]=$dts;
        
        if($dts->childFolderCount!=0){
            //$cname=$fname.'/'.str_replace(" ","_",$dts->displayName);$FolderList[]=
            $hFolder=$this->child_folder_list($mailbox,$dts->id,$cname);
            if(sizeof($hFolder)!=0){
                    foreach($hFolder as $key=>$vl){
                        $FolderList[$key]=$vl;
                    }
                }
            }
        }
        return $FolderList;
    }
    public function attachment_save($fileName,$contents_bytes,$contentType,$email_id,$file_path){
        //
		$fileName = $fileName;
		$contentType=$contentType;
		$contents = base64_decode($contents_bytes);

		//header("Content-type:".$contentType);
		//header("Content-Disposition: attachment; filename=".$fileName);
		//print $contents;
		file_put_contents('./'.$file_path.'/attachments/'.$email_id.'/'.$fileName,$contents);
		//exit();
    }
    public function attch_file(){
       $mailbox='emat@omindtech.com';
        $mailItem->id='AAMkAGYwMTUxNWI3LTdiNzctNDZhMS1hMTBjLTc5N2NjNjQxMTA0OABGAAAAAAB3buFFNGqxT5wQLMvCQw8fBwCtmd0Il0ztSItb178AU4kXAAAAAAEMAACtmd0Il0ztSItb178AU4kXAAGOczg8AAA=';
        //$filesave=(json_decode($this->sendGetRequest($this->baseURL . 'users/' . $mailbox . '/messages/' . $mailItem->id . '/attachments/AAMkAGYwMTUxNWI3LTdiNzctNDZhMS1hMTBjLTc5N2NjNjQxMTA0OABGAAAAAAB3buFFNGqxT5wQLMvCQw8fBwCtmd0Il0ztSItb178AU4kXAAAAAAEMAACtmd0Il0ztSItb178AU4kXAAGOczg4AAABEgAQALIMMeGGTJlPkfInfZCR_Lw=')));
        //echo'<pre>';print_r($filesave);echo'</pre>';

        $fileName = 'finger_print_icon_2x (1).png';
		$contentType='image/png';
		$contents = base64_decode('CQo8ZGl2IHN0eWxlPSJib3JkZXI6MXB4IHNvbGlkICM5OTAwMDA7cGFkZGluZy1sZWZ0OjIwcHg7bWFyZ2luOjAgMCAxMHB4IDA7Ij4KCjxoND5BIFBIUCBFcnJvciB3YXMgZW5jb3VudGVyZWQ8L2g0PgoKPHA+U2V2ZXJpdHk6IFdhcm5pbmc8L3A+CjxwPk1lc3NhZ2U6ICBDcmVhdGluZyBkZWZhdWx0IG9iamVjdCBmcm9tIGVtcHR5IHZhbHVlPC9wPgo8cD5GaWxlbmFtZTogbGlicmFyaWVzL0F1dGgybGliLnBocDwvcD4KPHA+TGluZSBOdW1iZXI6IDIzMDwvcD4KCgoJPHA+QmFja3RyYWNlOjwvcD4KCQoJCQoJCgkJCgkKCQkKCQkJPHAgc3R5bGU9Im1hcmdpbi1sZWZ0OjEwcHgiPgoJCQlGaWxlOiAvb3B0L2xhbXBwL2h0ZG9jcy9mZW1zZGV2L2FwcGxpY2F0aW9uL2xpYnJhcmllcy9BdXRoMmxpYi5waHA8YnIgLz4KCQkJTGluZTogMjMwPGJyIC8+CgkJCUZ1bmN0aW9uOiBfZXJyb3JfaGFuZGxlcgkJCTwvcD4KCgkJCgkKCQkKCQkJPHAgc3R5bGU9Im1hcmdpbi1sZWZ0OjEwcHgiPgoJCQlGaWxlOiAvb3B0L2xhbXBwL2h0ZG9jcy9mZW1zZGV2L2FwcGxpY2F0aW9uL2NvbnRyb2xsZXJzL0F1dGhfbWFpbC5waHA8YnIgLz4KCQkJTGluZTogOTA8YnIgLz4KCQkJRnVuY3Rpb246IGF0dGNoX2ZpbGUJCQk8L3A+CgoJCQoJCgkJCgkKCQkKCQkJPHAgc3R5bGU9Im1hcmdpbi1sZWZ0OjEwcHgiPgoJCQlGaWxlOiAvb3B0L2xhbXBwL2h0ZG9jcy9mZW1zZGV2L2luZGV4LnBocDxiciAvPgoJCQlMaW5lOiAyOTI8YnIgLz4KCQkJRnVuY3Rpb246IHJlcXVpcmVfb25jZQkJCTwvcD4KCgkJCgkKCjwvZGl2Pgk=');

		header("Content-type:".$contentType);
		header("Content-Disposition: attachment; filename=".$fileName);
		print $contents;
        exit();
    }
    public function move($id,$folder,$mailbox){
         return   $this->sendPostRequest($this->baseURL . 'users/' . $mailbox . '/messages/' . $id . '/move', '{ "destinationId":"'.$folder.'"}', array('Content-type: application/json'));
    }
    public function search_folder_id($email,$str){
        $ids="";
        $list=$this->folder_list($email);
        foreach($list as $key=>$cval){
            if(strtoupper($cval->displayName)==strtoupper($str)){
                $ids=$cval->id;
            }
        }
        return $ids;
    }

}
?>