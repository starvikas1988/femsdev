<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| Email configuration
| -------------------------------------------------------------------
|
*/
 ///'172.23.1.52'; ///10.100.10.111 10.29.0.65 , smtp.office365.com
 //25 // 10025/ 587

$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.office365.com';
$config['smtp_port'] = 587;  
$config['smtp_user'] = 'noreply.fems@fusionbposervices.com'; // change it to yours
$config['smtp_pass'] = 'Qwert@123$%'; // change it to yours
//$config['smtp_user'] = 'noreply.mwp@omindtech.com'; // change it to yours
//$config['smtp_pass'] = 'skt.mwp@omindtech12#$'; // change it to yours
$config['smtp_crypto'] = 'tls';
$config['mailtype'] = 'html';
$config['charset'] = 'iso-8859-1';
$config['wordwrap'] = TRUE;
$config['useragent'] = 'MWP-LIVE';
$config['newline'] = "\r\n"; //use double quotes to comply with RFC 8
$config['crlf'] = "\r\n"; //use double quotes to comply with RFC 8

//$config['_bit_depths'] = array('7bit', '8bit', 'base64');
//$config['_encoding'] = 'base64';
