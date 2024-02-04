<!DOCTYPE html>
<html lang="en">

<head>
    <title>Certificate</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- <style>
        @font-face {
            font-family: 'naumanextrabold';
            src: url('<?php echo base_url();?>/assets/course/certificate/font/naumanextrabold.ttf') format('ttf');
            font-weight: bold;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'guesssanswooregular';
            src: url('<?php echo base_url('assets/course/certificate/font/guesssanswooregular.ttf')?>') format('ttf');
            font-weight: bold;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'retrokiacapsregular';
            src: url('https://10.80.51.10/femsdev/assets/course/certificate/font/retrokiacapsregular.ttf') format('ttf');
            font-weight: bold;
            font-style: normal;
            font-display: swap;
        }
    </style> -->
</head>

<body>
    <div style="width:100%;font-family: 'Roboto', sans-serif;padding-top: 0px;">
        
        <div style="width: 100%;">
            <div style="width: 50%;float: left;">
                <img src="assets/course/certificate/img/top-left.png" style="width: 100%; ;" alt="" />
            </div>
            <div style="width: 50%;float: right;vertical-align: top;">
                <img src="assets/course/certificate/img/down-bg.png" style="width: 100%;" alt="" />
            </div>
            
        </div>

        <div style="width:100%;text-align: center;float: left;margin: -420px 0 0 0;">
            <img src="assets_home_v3/brand_logo/fusion_logo.jpg" alt="" style="height: 100px;margin: auto;">
            <div style="width:100%;text-align: center;">
                <div style="color:#1c3452;font-size: 51px;letter-spacing: 0px;font-family: 'retrokiacapsregular';">
                    <strong>CERTIFICATE</strong>
                </div>
                <div style="color: #1a3250;font-size: 30px;font-weight: normal;margin-top: -10px;font-family: 'guesssanswooregular';letter-spacing: 0.2rem;">
                    OF ACHIEVEMENT
                </div>
            </div>
            <div style="width:100%; padding: 16px 0 0 0px;">
                <div style="text-align: center;">
                    <div style="color: #1f3753;font-size: 20px;letter-spacing: 1px; text-transform: uppercase;">
                        <strong>THIS CERTIFICATE IS PRESENTED TO</strong>
                    </div>
                </div>
            </div>
        </div>

        <div style="width:100%;">
            

            <div style="width: 100%;margin-top: -120px;">
                <div style="width:100%; padding: 0 0 10px 0px;float: left;">
                    <div style="background: #263d59;height: 2px;width: 600px;margin: auto;"></div>
                </div> 
                <div style="width:100%; padding: 16px 0 0 0px;text-align: center;margin-top: -160px;">
                    <div style="color: #263d59;font-size: 18px;letter-spacing: 0.1rem;padding-top: -9px; text-transform: uppercase;height:30px;">
                        <strong><?= @$certificate_user->name ?></strong>
                    </div>
                </div>               

                <div style="width:100%; padding: 16px 0 0 0px;text-align: center;margin-top: -1px;">
                    <div style="color: #263d59;font-size: 18px;letter-spacing: 0.1rem;font-style: italic;padding-top: 0;">
                        <strong>From Fusion BPO Services, Inc.</strong>
                    </div>
                </div>
                <div style="width:100%; padding: 10px 40px 0 40px;text-align: center;margin-top: -90px;">
                    <div style="color: #3f536c;letter-spacing: 0.1rem;line-height: 40px;font-family: 'robotolight';">
                        <strong style="font-weight:300;font-size: 25px;">In recognition of his/her efforts and
                            achievement in successful completion of the<br> <?= @$course_name ?></strong>
                    </div>
                </div>

                <div style="width:100%; padding: 80px 80px 0px 80px;">
                    <div style="width: 33%;float: left; text-align: center;margin-top: -40px;margin-right: 10px; height:100px;">
                        <?php if ($certificate_details->second_signature != '' && $certificate_sed_sig->signature != '') { ?>                    
                                <img src="<?= $certificate_sed_sig->signature ?>" style="height:70px;margin:0 0 10px 0;object-fit:contain;display:block;" alt="">
                                <div style="color: #263d59;font-size: 15px;letter-spacing: 0.1rem;padding-top: 4px;border-top: 1px solid #1e3653;display: inline-block;text-transform: uppercase;">
                                    <strong style=" font-family:'naumanextrabold';"><?= $certificate_sed_sig->name ?></strong>
                                </div>
                                <div style="color: #263d59;font-size: 15px;letter-spacing: 0.1rem;font-weight: 300;padding-top: 5px;">
                                    <strong style="font-weight:400;"><?= $certificate_sed_sig->role_name ?></strong>
                                </div>                    
                        <?php } ?>
                    </div>                   

                    <div style="width: 33%;float: left; text-align: center;">
                        <img src="assets/course/certificate/img/certificate-new.png" style="width: 100px;">
                    </div>

                    <div style="width: 33%;float: left; text-align: center;">
                        <?php if ($certificate_details->first_signature != '' && $certificate_fst_sig->signature != '') { ?>                    
                                <img src="<?= $certificate_fst_sig->signature ?>" style="height:70px;margin:0 0 10px 0;object-fit:contain;display:block;" alt="">
                                <div style="color: #263d59;font-size: 15px;letter-spacing: 0.1rem;padding-top: 4px;border-top: 1px solid #1e3653;display: inline-block;text-transform: uppercase;">
                                    <strong style=" font-family:'naumanextrabold';"><?= $certificate_fst_sig->name ?></strong>
                                </div>
                                <div style="color: #263d59;font-size: 15px;letter-spacing: 0.1rem;font-weight: 300;padding-top: 5px;">
                                    <strong style="font-weight:400;"><?= $certificate_fst_sig->role_name ?></strong>
                                </div>
                            
                        <?php } ?>
                    </div>
                   
                </div>
                 <div style="width: 100%;padding: 32px 0 0 0;float: left;">
                    <img src="assets/course/certificate/img/down-bg.png" style="width:400px;">
                </div> 

               


            </div>
        </div>
            
</body>

</html>