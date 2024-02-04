<?php 
    namespace encryptionDecryption;
    class encdypt{
        private $privateKey;
        private $secretKey;
        private $string;

        function __construct($private, $secret,$str){
            $this->privateKey = $private; // user define key
            $this->secretKey  = $secret; // user define secret key
            $this->string     = $str; // user input text for encryption and decryption
        }

        function encrypt(){         
            $encryptMethod  = "AES-256-CBC";
            $key = hash('sha256', $this->privateKey);
            $ivalue = substr(hash('sha256', $this->secretKey), 0, 16); // sha256 is hash_hmac_algo
            $result = openssl_encrypt($this->string, $encryptMethod, $key, 0, $ivalue);
            return $output = base64_encode($result);  // output is a encripted value
        }


        function decrypt(){           
            $encryptMethod      = "AES-256-CBC";
            $key    = hash('sha256', $this->privateKey);
            $ivalue = substr(hash('sha256', $this->secretKey), 0, 16); // sha256 is hash_hmac_algo        
            return $output = openssl_decrypt(base64_decode($this->string), $encryptMethod, $key, 0, $ivalue);
        }

    }





?>