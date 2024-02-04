<!DOCTYPE html>
<html lang="en">
    <head>
        <title>PDF Home Page</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">  
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
        <style>
            body {
                padding:0;
                margin:0;
            }
            #page-border{
                /*width: 100%;*/
                height: 100%;
                border:8px solid blue;
                /*margin:0 0 0 -74px;*/
                padding:50px;
                display:block;
            }
        </style>
    </head>
    <body>
        <div id="page-border">
            <div style="max-width:100%;margin:0px 0 0 0;display:block;">		
                <img src="assets/idcard/certificate/fusion-logo.png" style="height:100px;" alt="">
                <h2 style="font-family: 'Oswald', sans-serif;font-size:20px;padding:0 0 0 70px;margin:10px 0 0 0;color:#363636;letter-spacing:2px;text-transform:uppercase;display:block;">
                    Learning and development presents
                </h2>
                <h1 style="font-family: 'Oswald', sans-serif;font-size:50px;padding:0 0 0 70px;margin:-10px 0 0 0;color:#363636;letter-spacing:2px;text-transform:uppercase;display:block;">
                    Certification
                </h1>
                <h2 style="font-family: 'Source Sans Pro', sans-serif;font-size:21px;padding:0 0 0 70px;margin:30px 0 0 0;color:#363636;letter-spacing:2px;font-style:italic;font-weight:normal;">
                    to:
                </h2>
                <h1 style="font-family: 'Oswald', sans-serif;font-size:40px;padding:0 0 0 70px;margin:20px 0 0 0;color:#363636;letter-spacing:1px;display:block;">
                    <?php echo strtoupper(isset($certificate_user->name)?$certificate_user->name:'#CANDIDATE NAME'); ?>
                </h1>
                <p style="font-family: 'Source Sans Pro', sans-serif;font-size:30px;padding:0 50px 0 70px;margin:40px 0 0 0;color:#363636;font-weight:normal;font-style:italic;line-height:inherit;">
                        <!--has satisfactorily completed the <?php //echo !empty($batch_details['certification_days']) ? $batch_details['certification_days'] : "5-days";  ?> training and passed the exam for <br/><strong style="font-weight:bold;font-size:22px;text-decoration:underline;"><?php //echo !empty($batch_details['certification_name']) ? $batch_details['certification_name'] : $batch_details['course_name'];  ?></strong><br/> He/She is now a Certified <?php //echo !empty($batch_details['certification_to']) ? $batch_details['certification_to'] : "Team Leader/Supervisor";  ?>-->

                    This is to certify that <strong><?php echo strtoupper(isset($certificate_user->name)?$certificate_user->name:'#CANDIDATE NAME'); ?></strong> has successfully cleared the assessment for <strong><?php echo isset($certificate_details->course_name)?$certificate_details->course_name:'#COURSE NAME'; ?></strong> course with <strong><?php echo isset($certificate_score->marks)?$certificate_score->marks:''; ?> %</strong> marks.

                </p>


                <div style="margin:130px 0 0 0;">

                    <?php if ($certificate_details->third_signature != '') { ?>

                        <div style="width:33.3333%;float:left;display:inline-block;text-align:center;">
                            <img src="<?= $certificate_thd_sig->signature ?>" style="height:70px;margin:0 0 10px 0;object-fit:contain;display:block;" alt="">
                            <h2 style="font-family: 'Oswald', sans-serif;font-size:25px;margin:0 0 0 0;color:#363636;text-transform:uppercase;text-align:center;letter-spacing:1px;">
                                <?= $certificate_thd_sig->name ?>
                            </h2>
                            <p style="font-family: 'Source Sans Pro', sans-serif;font-size:18px;margin:0 0 0 0;color:#363636;font-weight:normal;text-align:center;text-transform:uppercase;letter-spacing:0.5px;">			
                                <?= $certificate_thd_sig->role_name ?>

                            </p>
                        </div>
                    <?php } if ($certificate_details->second_signature != '') { ?>
                        <div style="width:33.3333%;float:left;display:inline-block;text-align:center;">
                            <img src="<?= $certificate_sed_sig->signature ?>" style="height:70px;margin:0 0 10px 0;object-fit:contain;display:block;" alt="">
                            <h2 style="font-family: 'Oswald', sans-serif;font-size:25px;margin:0 0 0 0;color:#363636;text-transform:uppercase;text-align:center;letter-spacing:1px;">
                                <?= $certificate_sed_sig->name ?>
                            </h2>
                            <p style="font-family: 'Source Sans Pro', sans-serif;font-size:18px;margin:0 0 0 0;color:#363636;font-weight:normal;text-align:center;text-transform:uppercase;letter-spacing:0.5px;">			
                                <?= $certificate_sed_sig->role_name ?>

                            </p>
                        </div>
                    <?php } if ($certificate_details->first_signature != '') { ?>
                        <div style="width:33.3333%;float:left;display:inline-block;text-align:center;">
                            <img src="<?= $certificate_fst_sig->signature ?>" style="height:70px;margin:0 0 10px 0;object-fit:contain;display:block;" alt="">
                            <h2 style="font-family: 'Oswald', sans-serif;font-size:25px;margin:0 0 0 0;color:#363636;text-transform:uppercase;text-align:center;letter-spacing:1px;">
                                <?= $certificate_fst_sig->name ?>
                            </h2>
                            <p style="font-family: 'Source Sans Pro', sans-serif;font-size:18px;margin:0 0 0 0;color:#363636;font-weight:normal;text-align:center;text-transform:uppercase;letter-spacing:0.5px;">			
                                <?= $certificate_fst_sig->role_name ?>

                            </p>
                        </div>
                    <?php } ?>
                </div>

            </div>
        </div>

    </body>
</html>