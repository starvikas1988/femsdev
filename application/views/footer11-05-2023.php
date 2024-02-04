<!--start footer elements-->
<footer id="footer" class="footer">
    <div class="container">
        <div class="body_widget text-center">
            <p>
                2023 © Omind Technologies.
            </p>
        </div>
    </div>
</footer>
<!--end footer elements-->

<!--start logout popup-->
<div class="modal fade" id="LogoutImgModel">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <!-- Modal body -->
            <div class="modal-body">
                <img src="<?php echo base_url() ?>assets/images/fems_logout_popup_2021.jpg" class="img-fluid" alt="">
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary save_btn" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="LogoutImgModelAd">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form class="frmAdLogoutAcknowledge" action="<?php echo base_url() ?>logout" data-bs-toggle="validator" method="POST">
                <!-- Modal body -->
                <div class="modal-body">
                    <img src="<?php echo base_url() ?>assets/images/ad_logout_img.png" class="img-fluid" alt="">
                    <div class="row">
                        <div class="col-md-12" style="color:darkgreen;font-weight:bold; font-size:16px;">
                            <input type="checkbox" id="is_acknowledge" name="is_acknowledge" value="1" required="">I acknowledge the same
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary save_btn" id="confirm">I acknowledge</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end Logout popup-->

<!-- alert section start -->
    <div id="alertContainer">
        
    </div>
<!-- alert section end -->

<!--start add referral popup-->
<div class="modal fade" id="add_referral">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="frmAddReferrals" class="frmAddReferrals" action="#" data-toggle="validator" method='POST' enctype="multipart/form-data">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Referral</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-2">
                                <label for="name" class="form-label">Full Name <span class="red-bg">*</span></label>
                                <!-- <input type="text" class="form-control" id="name" name="name" autocomplete="off" required onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)"> -->
                                <input type="text" class="form-control" id="name" name="name" autocomplete="off" required onkeypress="nameValidate(this)">
                                <span id="nameError" style="color: red;"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-2">
                                <label for="phone" class="form-label">Phone <span class="red-bg">*</span></label>
                                <input type="text" id="phone" name="phone" class="form-control" onfocusout="checkphone()" type="text" inputmode="numeric" pattern="[0-9]*" maxlength="6" required>
                                <span id="phone_status" style="color:red"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-2">
                                <label for="email" class="form-label">Email <span class="red-bg">*</span></label>
                                <input type="email" id="email" name="email" class="form-control" onfocusout="checkemail();" required>
                                <span id="email_status" style="color:red"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-2">
                                <label for="position" class="form-label">Position Referring For <span class="red-bg">*</span></label>
                                <select id="position" name="position" class="form-control" required>
                                    <option value="">--Select Position--</option>
                                    <option value="agent">CCE</option>
                                    <option value="tl">TL</option>
                                    <option value="qa">QA</option>
                                    <option value="manager">MANAGER</option>
                                    <option value="am">AM</option>
                                    <option value="trainer">TRAINER</option>
                                    <option value="support">OTHER SUPPORT</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="mb-2">
                                <label for="comment" class="form-label">Comment <span class="red-bg">*</span></label>
                                <textarea id="comment" name="comment" class="form-control" cols="3" rows="3" required onkeypress="commentValidate(this)"></textarea>
                                <span id="commentError" style="color: red;"></span>

                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="mb-2">
                                <label for="r_cv_attach" class="form-label">Attach CV <span class="red-bg">*</span></label>
                                <input type="file" class="form-control" name="userfile" id="r_cv_attach" accept=".pdf" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <!-- <button type="submit" class="btn btn-primary save_btn" data-bs-dismiss="modal" name="submit" id='addReferal' value="Save">Save</button> -->
                    <button type="submit" class="btn btn-primary save_btn" name="submit" id='addReferal' value="Save">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end add referral popup-->


<!--start holiday popup-->
<div class="modal fade" id="holidayListModel">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Holiday List <?php echo $currYear; ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="table-widget popup_scroll" id="holidayList">
                    <!-- <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Holiday For</th>
                                <th>Holiday Date</th>
                                <th>Day</th>
                                <th>No of Holiday</th>
                                <th>Nature of Holiday</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>New Year **</td>
                                <td>2023-01-01</td>
                                <td>Sunday</td>
                                <td>1</td>
                                <td>Festival</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>New Year **</td>
                                <td>2023-01-01</td>
                                <td>Sunday</td>
                                <td>1</td>
                                <td>Festival</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>New Year **</td>
                                <td>2023-01-01</td>
                                <td>Sunday</td>
                                <td>1</td>
                                <td>Festival</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>New Year **</td>
                                <td>2023-01-01</td>
                                <td>Sunday</td>
                                <td>1</td>
                                <td>Festival</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>New Year **</td>
                                <td>2023-01-01</td>
                                <td>Sunday</td>
                                <td>1</td>
                                <td>Festival</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>New Year **</td>
                                <td>2023-01-01</td>
                                <td>Sunday</td>
                                <td>1</td>
                                <td>Festival</td>
                            </tr>
                        </tbody>
                    </table> -->
                </div>
            </div>
        </div>
    </div>
</div>
<!--end holiday popup-->

<!-- validation -->
<script src="<?php echo base_url(); ?>assets_new_mwp_1.2/js/custom.js"></script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script src="<?php echo base_url() ?>assets_home_v3/js/bootstrap.bundle.min.js"></script>

<script src="<?php echo base_url() ?>assets_home_v3/js/highcharts.js"></script>

<!--start your adherence graph js code-->

<?php
include_once 'jscripts.php';
?>


<?php
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
        $("#autosuggest_input").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".mega-menu li").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
<!--end autosuggestion js code-->
<!--start Loader js code-->
<script>
    $(window).on("load", function() {
        $("#page_loader").fadeOut();
    });
</script>

<script>
    function nameValidate() {
        var name = $('.frmAddReferrals').find('input[name="name"]').val();
        console.log(name);
          if(name.trim().length == 0){
            $('#nameError').html("Please enter full name");
            return false;
          }else{
            $('#nameError').empty();
            return true;
          }
    }

    function commentValidate() {
        var comment = $('.frmAddReferrals').find('textarea[name="comment"]').val();
        console.log(comment);
          if(comment.trim().length == 0){
            $('#commentError').html("Comment filed can't be empty");
            return false;
          }else{
            $('#commentError').empty();
            return true;
          }
    }

</script>


<!--end Loader js code-->
<!-- <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script> -->
</body>

</html>