<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/

// $hook['pre_controller'] = array(
//     'class'    => 'ExceptionHook',
//     'function' => 'SetExceptionHandler',
//     'filename' => 'ExceptionHook.php',
//     'filepath' => 'hooks'
// );

  
// $hook['pre_controller'] = array(  
//         'class' => 'Exm',  
//         'function' => 'tut',  
//         'filename' => 'exm.php',  
//         'filepath' => 'hooks',  
//         );  
// echo "gdgdsgdgd";die;
$hook['pre_controller'] = array(  
    'class' => 'Legal_crm_check',  
    'function' => 'index1',  
    'filename' => 'Legal_crm_check.php',  
    'filepath' => 'hooks' ,
    // 'filepath' => 'hooks',  
    // 'params' => array('element1', 'element2', 'element3')  
    );  
 

