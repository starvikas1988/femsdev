<?php 
    include_once "encdypt.php";
    use encryptionDecryption as ency;
    
    $privateKey = 'AA74CDCC2BBRT935136HH7B63C27';
    $secretKey  = '5fgf5HJ5g27';
    $string     = '[
        {
            "name": "Nitish",
            "Roll": "25"
        },
        {
            "name": "Anand",
            "Roll": "24"
        },
        {
            "name": "Sanju",
            "Roll": "27"
        },
        {
            "name": "Shilpa",
            "Roll": "28"
        }]';
    
  
    $obj_ency = new ency\encdypt($privateKey,$secretKey,$string);
    echo 'Encrypted String';    
    echo $obj_ency->encrypt();
    echo '<br>';
    
    //===========================================
    $encrypted_string = $obj_ency->encrypt();
    $obj_ency1 = new ency\encdypt($privateKey,$secretKey,$encrypted_string);
    echo 'Eecrypted String';
    echo $obj_ency1->decrypt();
    
?>