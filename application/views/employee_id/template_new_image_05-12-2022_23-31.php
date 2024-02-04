<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title><?php echo $agent_details['fusion_id']; ?></title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 
</head>
<body>
    <div class="container" id="dwn_image">       

        <div id="prnt" style="width: 100%;display: flex;justify-content: center; margin: 15px 0 0 0;">
            <div style="width: 300px;float:left;max-width: 100%;display: inline-block;vertical-align: top;margin: 0 30px 0 0;">
                <div style="width: 100%;padding: 10px;">
                    <img src="<?=FCPATH?><?php echo $id_card; ?>" style="max-width: 60%;margin: 0 0 0 10px;object-fit: cover;" alt="">
                    <img src="<?=FCPATH?>assets/idcard/images/card_bg.png" style="margin: -260px 0 0 0;display:inline-block;object-fit: cover;" alt="">
                    <div style="padding: 10px 20px;width:auto;text-align:center;background-image: linear-gradient(to right, #49bb7c, #12c19f, #00c4be, #00c6d8, #40c6ea);margin: -30px 30px 0 30px;position: relative;z-index: 99;">
                        <h2 style="font-size: 14px;padding: 0;margin: 0;color: #fff;font-family: 'Open Sans', sans-serif;letter-spacing: 0.5px;">
                            <?php echo $agent_details['fname'].' '.$agent_details['lname']; ?>
                        </h2>
                    </div>
                    <?php 
                        if($agent_details['brand']!='3'){
                            ?> 
                    <div style="padding: 10px 30px;text-align:center;background-image: linear-gradient(to right, #ed4e28, #ed5926, #ed6325, #ed6c24, #ec7524);display: inline-block;margin: 0 0 0 60px;position: relative;z-index: 99;">
                        <h2 style="font-size: 14px;padding: 0;margin: 0;color: #fff;font-family: 'Open Sans', sans-serif;text-transform: uppercase;letter-spacing: 0.5px;"><?php echo $agent_details['fusion_id']; ?></h2>
                    </div>
                    <?php }else{ ?>
                    <div style="padding: 10px 30px;text-align:center;background-image: linear-gradient(to right,#282e91, #283491, #282e91,#004eff);display: inline-block;margin: 0 0 0 60px;position: relative;z-index: 99;">
                        <h2 style="font-size: 14px;padding: 0;margin: 0;color: #fff;font-family: 'Open Sans', sans-serif;text-transform: uppercase;letter-spacing: 0.5px;"><?php echo $agent_details['fusion_id']; ?></h2>
                    </div>
                    <?php } ?>
                    <div style="text-align:center;margin-top:-20px;">
                    <?php 
                        if($agent_details['brand']!='3'){
                            ?>                        
                        <img src="<?=FCPATH?>assets/idcard/images/fusion-logo.jpg" style="max-width: 100%;height: 60px;margin: 100px auto 0 auto;display: block;" alt="">
                        <?php }else{ ?>
                        <img src="<?=FCPATH?>assets/images/omind-new-logo.png" style="max-width: 100%;height: 60px;margin: 100px auto 0 auto;display: block;" alt="">
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div style="width: 300px;float:left;max-width: 100%;display: inline-block;vertical-align: top;margin: 0 0 0 15px;">
                <div style="width: 100%;padding: 10px;text-align:center;">
                <h2 style="font-size: 16px; padding: 0 0 0px 0; margin: 0 0 0px 0;display:block;color: #000;font-family: 'Open Sans', sans-serif;"><?=$company_details['name']?></h2> 
                <h3 style="font-size: 12px;padding: 0px 0 1px 0;margin:0 0 0 0;color: rgba(0, 0, 0, 0.7);font-family: 'Open Sans', sans-serif;"> <?=$company_details['title']?></h3>
                <div style="list-style: none;margin-top: 100px;">
                    <div style="float:left;margin:10px 10px 20px 0;">
                   
                        
                      
                    </div>
                    <div style="">
                        <div style="text-align: left;padding: 30px 0 0 0;font-family: 'Open Sans', sans-serif;font-size: 13px;font-weight:bold;line-height: inherit;display:inline-block;">
                            
                            <div style="width:30px;float:left; display:inline-block;">
                                <img src="<?=FCPATH?>assets/idcard/images/map.png" style="max-width: 100%;height: 20px;display: block;" alt="">
                            </div>    

                            <div style="width:auto;float:left; display:inline-block;">
                                <strong>
                                    <?=$company_details['address']?>
                                </strong>
                            </div>
                            

                          
                                
                        </div>
                        <div style="text-align: left;margin: 0 0 20px 30px;font-family: 'Open Sans', sans-serif;font-size: 13px;line-height: inherit;" class="address-bg">
                        <?=$company_details['website']?>
                        </div>
                    </div>

                    <div style="width:30px;float:left">
                        <img src="<?=FCPATH?>assets/idcard/images/phone1.png" style="max-width: 100%;height: 15px;display: block;" alt="">
                    </div>
                    <div style="">
                        <div style="text-align: left;margin: 0 0 20px 0;font-family: 'Open Sans', sans-serif;font-size: 13px;line-height: inherit;" class="address-bg">
                            <?=$agent_details['phone']?>
                        </div>
                    </div>

                    <!-- <div style="width:30px;float:left">
                         <img src="<?=FCPATH?>assets/idcard/images/phone1-red.png" style="max-width: 100%;height: 15px;display: block;" alt="">
                    </div> -->
                    <div style="">
                        <div style="text-align: left;margin: 0 0 20px 0;font-family: 'Open Sans', sans-serif;font-size: 13px;line-height: inherit;" class="address-bg">
                        <?=$agent_details['phone_emar']?>
                        </div>
                    </div>
                
                </div>
                <?php 
                        if($agent_details['brand']!='3'){
                            ?>  
                    <img src="<?=FCPATH?>assets/idcard/images/bottom.jpg" style="width: 100%;margin: 160px 0 -5px 0;" alt="">
                    <?php }else{ ?>
                    <img src="<?=FCPATH?>assets/idcard/images/bottom-image2.png" style="width: 100%;margin: 160px 0 -5px 0;" alt="">
                    <?php } ?>
                </div>
            </div>
        </div>

    </div>
</body>
</html>