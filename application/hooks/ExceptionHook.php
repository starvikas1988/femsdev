<?php 
defined('BASEPATH') OR exit('No direct script access allowed');


class ExceptionHook {

     public function SetExceptionHandler()
     {
          set_exception_handler(array($this, 'HandelException'));
     }

     public function HandelException($exception)
     {
         $msg = "Exception hriday ----------------------------------- occured ". $exception->getMessage();

         log_message('error', $msg);
     }

}