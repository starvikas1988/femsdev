<footer id="footer" class="footer">
        <div class="container">
            <div class="body_widget text-center">
                <p>
					© <?php echo date("Y"); ?> Fusion BPO Services, All Rights Reserved. <br>
					Powered by: Omind Technologies
                </p>
            </div>
        </div>		
    </footer>

    <!--start chat window main-->
<div class="main_feedback">
    <div class="feedback_new position_relative">
        <a href="javascript:void(0);" id="window_open_bug">
            <div class="feedback_widget close_bug">
                <div class="addText">Report</div>
                <img src="<?php echo base_url() ?>assets_home_v3/images/bug.svg" class="feedback_right" alt="">                    
            </div>
        </a>
        <a id="small_cross_bug" class="small_cross"><i class="fa fa-times" aria-hidden="true"></i></a>
    </div>
    <div class="feedback_new position_relative">
        <a href="javascript:void(0);" id="window_open_feedback">
            <div class="feedback_widget close_feedback">
                <div class="addText">Feedback</div>
                <img src="<?php echo base_url() ?>assets_home_v3/images/feedback.svg" class="feedback_right" alt="">
            </div>
        </a>
        <a id="small_cross_feedback" class="small_cross_feedback"><i class="fa fa-times" aria-hidden="true"></i></a>
    </div>
</div>
<!--end chat window main-->

<!--start bug chat window-->
<div class="window_open_area_bug" style="display: none;">
        <div class="chat_header">
            <div class="right_side">
                <a href="javascript:void(0);" id="close_window_bug" class="close_new_white">
                    <img src="<?php echo base_url() ?>assets_home_v3/images/close_white.svg" alt="">
                </a>
            </div>
        </div>
        <div class="chat_widget_main chat_widget_main_iframe_bug">

        </div>
    </div>
    <!--end bug chat window-->

    <!--start feedback chat window-->
    <div class="window_open_area_feedback" style="display: none;">
        <div class="chat_header">
            <div class="right_side">
                <a href="javascript:void(0);" id="close_window_feedback" class="close_new_white">
                    <img src="<?php echo base_url() ?>assets_home_v3/images/close_white.svg" alt="">
                </a>
            </div>
        </div>
        <div class="chat_widget_main chat_widget_main_iframe_feedback">

        </div>
    </div>
    <!--end feedback chat window-->


    <!--start chat window-->
<script>
    $(document).ready(function () {

        $(document).on('click','#window_open_bug',function(){

            $.getScript("https://app-cdn.clickup.com/assets/js/forms-embed/v1.js", function() {

                let html_iframe_bug = `<iframe class="clickup-embed clickup-dynamic-height"
                    src="https://forms.clickup.com/9002033595/f/8c908dv-3104/447S1EJ1RS66XXVXYE" onwheel="" width="100%"
                    height="100%" style="background: transparent;"></iframe>`;

                $(".chat_widget_main_iframe_bug").html(html_iframe_bug);

                $(".window_open_area_bug").fadeIn("slow");
                $(".window_open_area_feedback").fadeOut("slow");
            });


        });


        $("#close_window_bug").click(function () {
            $(".window_open_area_bug").fadeOut("slow");
        });
        $("#small_cross_bug").click(function () {
            $(".close_bug").fadeOut("slow");
            $(".window_open_area_bug").fadeOut("slow");
            $(".small_cross").fadeOut("");
        });
    });

    $(document).ready(function () {
        
        $(document).on('click','#window_open_feedback',function(){

            $.getScript("https://app-cdn.clickup.com/assets/js/forms-embed/v1.js", function() {

                let html_iframe_feedback = `<iframe class="clickup-embed clickup-dynamic-height"
                    src="https://forms.clickup.com/9002033595/f/8c908dv-2944/9X9YMZ1FMFZ324HDHN" onwheel="" width="100%"
                    height="100%" style="background: transparent;"></iframe>`;            

                $(".chat_widget_main_iframe_feedback").html(html_iframe_feedback);

                $(".window_open_area_feedback").fadeIn("slow");
                $(".window_open_area_bug").fadeOut("slow");
            });
            

        });


        $("#close_window_feedback").click(function () {
            $(".window_open_area_feedback").fadeOut("slow");
        });
        $("#small_cross_feedback").click(function () {
            $(".close_feedback").fadeOut("slow");
            $(".window_open_area_feedback").fadeOut("slow");
            $(".small_cross_feedback").fadeOut("");
        });
    });
</script>
<!--end chat window-->

