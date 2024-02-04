<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sftplib
{
    public function __construct()
    {
		set_include_path(get_include_path() . PATH_SEPARATOR . APPPATH . 'third_party/phpseclib');
        require_once APPPATH.'third_party/phpseclib/Net/SSH2.php';
        require_once APPPATH.'third_party/phpseclib/Net/SFTP.php';
    }
}

?>