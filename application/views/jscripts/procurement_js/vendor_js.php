<script>
   
    $(document).ready(function() {
        baseURL = "<?php echo base_url(); ?>";

        $(".vendorResetPasswordbtn").on("click", function(e) {
            e.preventDefault();
            var form = $("#vendorResetPasswordForm");
            var url = form.attr('action');
            var password = $('#vendor_new_pass').val();
            var confirm = $('#vendor_con_pass').val();
            var old = $('#vendor_old_pass').val();
            var passregex = /(?=^.{8,}$)(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*[^A-Za-z0-9]).*/;

            if (password != '' && confirm != '' && old != '') {
                if (old != password) {
                    if (password.length > 7) {
                        if (passregex.test(password)) {
                            if (password == confirm) {

                                $('.vendorResetPasswordbtn').html('Please Wait...');
                                $('.vendorResetPasswordbtn').prop('disabled', true);
                                $.ajax({
                                    type: "POST",
                                    url: url,
                                    data: form.serialize(),
                                    success: function(data) {
                                        $('.vendorResetPasswordbtn').html('Update Password');
                                        $('.vendorResetPasswordbtn').prop('disabled', false);
                                        // Ajax call completed successfully
                                        swal({
                                            title: "Success!",
                                            text: "Your password has been updated successfully!",
                                            icon: "success"
                                        }).then(function() {
                                            window.location.reload();
                                        });
                                    },
                                });
                            } else {

                                swal({
                                    title: "Password Error!",
                                    text: 'Password and Confirm Password is not matched.',
                                    icon: "warning"
                                })

                                return false;
                            }

                        } else {

                            swal({
                                title: "Password Error!",
                                text: 'Password must contain at least one capital letter, one small letter, one digit, one special character.',
                                icon: "warning"
                            })

                            return false;

                        }
                    } else {

                        swal({
                            title: "Password Error!",
                            text: 'It must be minimum 8 characters.',
                            icon: "warning"
                        })

                        return false;
                    }
                } else {

                    swal({
                        title: "Old and New Password is same!",
                        text: 'It must not be same as previous password.',
                        icon: "warning"
                    })

                    return false;

                }

            } else {

                swal({
                    title: "Empty Fields Error!",
                    text: 'All inputs are required to reset your password',
                    icon: "warning"
                })

                return false;

            }

        });

        $(".viewDetails").on("click", function(e) {
            var assets_id = $(this).attr('assets_id');
            var vendor_id = $(this).attr('vendor_id');
            var req_id = $(this).attr('req_id');

            request_url = baseURL + 'proc_vendor/vendorUploadQuotationModal';
			datas = {
				'req_id': req_id,
                'vendor_id': vendor_id,
                'assets_id': assets_id,
			};
			process_ajax(function(htmldata) {

				$('#sendQuotation').html(htmldata);
				$("#sendQuotation").modal('show');
			}, request_url, datas, 'text');
        });

    }); // end of document ready function

    
</script>