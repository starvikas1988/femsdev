<!--start footer elements-->
<footer id="footer" class="footer">
    <div class="container">
        <div class="body_widget text-center">
            <p>
                <center> <span style="color:#000">&copy; <?php echo date("Y");?> Fusion BPO Services, All Rights Reserved.<br>Powered by: Omind Technologies</span></center>
            </p>
        </div>
    </div>
</footer>
<!--end footer elements-->

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

<!-- <script async src="https://app-cdn.clickup.com/assets/js/forms-embed/v1.js"></script> -->

<?php include_once('homev3/all_popup.php'); ?>
<?php include_once('homev3/acknowledge_popup.php'); ?>

<!-- validation -->
<!--<script src="<?php echo base_url(); ?>assets_home_v3/js/custom.js"></script>-->

<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script src="<?php echo base_url() ?>assets_home_v3/js/bootstrap.bundle.min.js"></script>

<script src="<?php echo base_url() ?>assets_home_v3/js/highcharts.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.cookie.js"></script>
<!--start your adherence graph js code-->
<!--<script src="<?php echo base_url(); ?>assets_home_v3/js/leave_work.js"></script>-->
<script src="<?php echo base_url(); ?>assets/clipboardjs-master/dist/clipboard.min.js"></script>

<script src="<?php echo base_url() ?>assets_inner_v3/fancybox/js/fancybox.umd.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets_inner_v3/fancybox/css/fancybox.css">

<?php
include_once 'jscripts.php';

if (isset($content_js) && !empty($content_js)) {
    if (is_array($content_js)) {
        foreach ($content_js as $key => $script_url) {
            if (!preg_match("/.php/", $script_url)) {
                if (preg_match("/\Ahttp/", $script_url)) {
                    echo '<script src="' . $script_url . '"></script>';
                } else {
                    echo '<script src="' . base_url('application/views/jscripts/' . $script_url) . '"></script>';
                }
            } else {
                include_once 'application/views/jscripts/' . $script_url;
            }
        }
    } else {
        if (!preg_match("/.php/", $content_js)) {
            if (preg_match("/\Ahttp/", $content_js)) {
                echo '<script src="' . $content_js . '"></script>';
            } else {
                echo '<script src="' . base_url('application/views/jscripts/' . $content_js) . '"></script>';
            }
        } else {
            include_once 'application/views/jscripts/' . $content_js;
        }
    }
}
?>
<?php 
    include_once('jscripts/home_additional_js.php');
?>
<?php
include_once 'application/views/homev3/add_referral.php';
?>
<!--start autosuggestion js code-->
<script>
    $(document).ready(function() {
        $("#autosuggest_input").click(function() {
            $(".autosuggest").fadeToggle("slow");
            $(".search").addClass("search_around");
        });
        $(".middle_area").click(function() {
            $(".autosuggest").fadeOut("");
        });
    });
</script>
<script>
    $(document).ready(function() {
        var clipboard = new ClipboardJS('.support_img');

        clipboard.on('success', function(e) {
            console.info('Action:', e.action);
            console.info('Text:', e.text);
            console.info('Trigger:', e.trigger);
            var cp_elm_id = e.trigger.dataset.clipboardTarget;
            $(`${cp_elm_id}_copied`).show();
            setTimeout( function(){ $(`${cp_elm_id}_copied`).hide();} , 2000);    
            console.log(e.trigger.dataset.clipboardTarget);
            e.clearSelection();
        });

        clipboard.on('error', function(e) {
            console.error('Action:', e.action);
            console.error('Trigger:', e.trigger);
        });
        
        $("#autosuggest_input").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".mega-menu li").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
<!--end autosuggestion js code-->

<script type="text/javascript">	

	function googleTranslateElementInit(){
		
		var tlang=$.cookie('tlang');
		if(tlang=="") tlang="en";
		var lang =tlang;
		new google.translate.TranslateElement({ pageLanguage: 'en', includedLanguages: 'en,fr' }, 'google_translate_element');
		var languageSelect = document.querySelector("select.goog-te-combo");
		languageSelect.value = lang; 
		languageSelect.dispatchEvent(new Event("change"));
	}

	var flags = document.getElementsByClassName('flag_link'); 
		
	Array.prototype.forEach.call(flags, function(e){
	  e.addEventListener('click', function(){
		var lang = e.getAttribute('data-lang'); 
		$.cookie('tlang', lang, { expires: 900, path: '/' });
		
		var languageSelect = document.querySelector("select.goog-te-combo");
		languageSelect.value = lang; 
		languageSelect.dispatchEvent(new Event("change"));
		
		
		
	  }); 
	});
	</script>
<!--start leave code---->
<script>
$(document).ready(function(){
		var baseURL = "<?php echo base_url();?>";
				
		$(".myLeaveModalBtn").click(function(){
			
			var fdate = $(this).attr('data-frmdate');
			var tdate = $(this).attr('data-todate');

            $("#form-leave_type option:contains('Paternity Leave')").hide();
			
			$("#myLeaveModal").modal('show');
            urls='<?php echo base_url();?>/home/check_holiday'
            if(fdate==tdate){
                $.ajax({
                        url : urls,
                        type: "GET",
                        data :'hdate='+fdate,
                        success: function(data, textStatus, jqXHR)
                        {
                            
                            if(data==0){
                                $("#form-leave_type option:contains('Holiday')").hide();
                                //$("#form-leave_type option[value=Holiday]").hide();

                            }else{
                                //alert('h');
                                $("#form-leave_type option:contains('Holiday')").show();
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                    
                        }
                });

                //Leave check for Comp off

                var datas = { 'from_date': fdate, 'to_date': tdate, 'deff_days': 1};
                var request_url = "<?=base_url()?>leave/check_com_off_date_apply";

                process_ajax(function(response)
                {
                    var res = JSON.parse(response);
                    if (res.stat == true) 
                    {
                        $("#form-leave_type option:contains('Comp Off')").show();
                    }
                    else {
                        $("#form-leave_type option:contains('Comp Off')").hide();
                    }                 
                },request_url, datas, 'text');

            }
			
			$("#leave_form #from_date").val(fdate);
			$("#leave_form #to_date").val(tdate);
			//$("#myLeaveModal").show();
						
		});	
			
	});	
</script>
<!--- end leave code--->
<!--start Loader js code-->
<script>
    $(window).on("load", function() {
        $("#page_loader").fadeOut();
    });
    $(window).on("load",function(){

        $(".trannslang li a").click(
            function(){ 
                googleTranslateElementInit();
                dt=$(this).text();
                if(dt=='Anglais')dt='English';
                $("#lang_disp").html(dt);
            }
        );
    });
     
</script>
<!--- Date Picker---->
<script>
    $(function() {
        $(".datepicker").datepicker();
    });
</script>
<!--end Loader js code-->
<!-- <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script> -->
<script>
window.addEventListener('load', function () {
 loadScript("//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit");
});

function loadScript(src)
{
  return new Promise(function (resolve, reject) {
	if ($("script[src='" + src + "']").length === 0) {
		var script = document.createElement('script');
		script.onload = function () {
			resolve();
		};
		script.onerror = function () {
			reject();
		};
		script.src = src;
		document.body.appendChild(script);
	} else {
		resolve();
	}
});

}

</script>

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

<?php 
    include_once('homev3/warning_popup.php'); 
?>
</body>

</html>