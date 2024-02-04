<script>
    $(document).ready(function() {
        baseURL = "<?php echo base_url(); ?>";
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $("body").on("click", ".add-more-btn", function() {

            var html = $(".doc_div_html").first().clone();
            //  $(html).find(".change").prepend("<label for=''>&nbsp;</label><br/><a class='btn btn-danger remove'>- Remove</a>");

            $(html).find(".change").html("<a class='remove-btn'>- Remove</a>");
            $(".doc_div_html").last().after(html);

        });
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $("body").on("click", ".remove-btn", function() {
            $(this).parents(".doc_div_html").remove();
        });
 
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $(".submit_vendor_doc").submit(function(e) {

            //stop submitting the form to see the disabled button effect
            e.preventDefault();

            //disable the submit button
            $(".submit_vendor_doc").attr("disabled", true);
            $(".submit_vendor_doc").html("..Please Wait..");
            return true;

        });
   
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $(".statusChange").click(function() {

            var status = $(this).attr("status");
            var vendor_id = $(this).attr("vendor_id");
            swal({
                title: 'Are you sure to change status?',

                icon: 'warning',
                buttons: ["No, keep it", "Yes, Change!"],

            }).then((willDelete) => {
                if (willDelete) {

                    request_url = baseURL + 'proc_vendor/statusChange';
                    datas = {
                        'status': status,
                        'vendor_id': vendor_id
                    };
                    process_ajax(function(response) {

                        swal({
                            title: "Success!",
                            text: "Status has been changed successfully!",
                            icon: "success"
                        }).then(function() {
                            window.location.reload();
                        });

                    }, request_url, datas, 'text');

                }

            });

        });

        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $("#checkAll").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $(".userStatusChange").click(function() {

            var checkedValues = $('.user_check:checkbox:checked').map(function() {
                return this.value;
            }).get();

            if (checkedValues.length > 0) {

                var approve = $(this).attr("approve");

                if (approve == '1') {
                    var msg = "All users have been Approved successfully";
                    var warnmsg = "Are you sure to Approve?";
                } else {
                    var msg = "All users have been Declined successfully";
                    var warnmsg = "Are you sure to Decline?";
                }

                swal({
                    title: warnmsg,

                    icon: 'warning',
                    buttons: ["No", "Yes"],

                }).then((willDelete) => {
                    if (willDelete) {

                        request_url = baseURL + 'proc_vendor/userStatusChangeAll';
                        datas = {
                            'checkedValues': checkedValues,
                            'approve_status': approve,
                        };
                        process_ajax(function(response) {

                            swal({
                                title: "Success!",
                                text: msg,
                                icon: "success"
                            }).then(function() {
                                window.location.reload();
                            });


                        }, request_url, datas, 'text');

                    }

                });
            } else {

                swal({
                    title: "Warning!",
                    text: 'Please select users to make them Active/Inactive',
                    icon: "warning"
                });

            }

        });

        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $(".vndUserEditBtn").click(function() {

            var vendor_user_id = $(this).attr("vendor_user_id");

            request_url = baseURL + 'proc_vendor/editVendorUser';
            datas = {
                'vendor_user_id': vendor_user_id,
            };
            process_ajax(function(htmldata) {

                $('#vendorUserEditModal').html(htmldata);
                $("#vendorUserEditModal").modal('show');
            }, request_url, datas, 'text');

        });
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


    });
</script>

<script>
    function addAssets(data) {
        var vendor_id = data.getAttribute("vendor_id");
        var vendor_name = data.getAttribute('vendor_name');

        request_url = baseURL + 'proc_vendor/getVendorAssets';
        datas = {

            'vendor_id': vendor_id
        };
        process_ajax(function(response) {

            var res = JSON.parse(response);
            if (res.vendor_assets !== null) {
                var vendor_assets_array = res.vendor_assets.split(",");

                $('#vnd_asset_ids').val(vendor_assets_array);
                $("#vnd_asset_ids").selectpicker("refresh");
            }

            $('#vendorAssetsModalLabel').html(vendor_name);
            $('#assets_vendor_id').val(vendor_id);
            //$('#vnd_asset_ids').val(vendor_assets_array).trigger('change');

            $("#vendorAssetsModal").modal('show');

        }, request_url, datas, 'text');


    }    

    function upload_doc(data) {
        var vendor_id = data.getAttribute("vendor_id");
        var vendor_name = data.getAttribute('vendor_name');

        $('#vendor_doc_form #doc_vendor_id').val(vendor_id);
        $('#vendor_doc_form #vendor_name_html').html(vendor_name);
        $("#vendorDocumentUploadModal").modal('show');
    }


    function edit_vendor(data) {
        var vendor_id = data.getAttribute("vendor_id");
        var vendor_name = data.getAttribute('vendor_name');


        request_url = baseURL + 'proc_vendor/edit_vendor';
        datas = {
            'vendor_id': vendor_id,
            'vendor_name': vendor_name
        };
        process_ajax(function(htmldata) {

            $('#editVendorModel').html(htmldata);
            $("#editVendorModel").modal('show');
        }, request_url, datas, 'text');
    }


    function upload_doc_list(data) {
        var vendor_id = data.getAttribute("vendor_id");
        var vendor_name = data.getAttribute('vendor_name');

        request_url = baseURL + 'proc_vendor/get_vendor_doc';
        datas = {
            'vendor_id': vendor_id,
            'vendor_name': vendor_name
        };
        process_ajax(function(htmldata) {

            $('#vendorDocumentlistModal').html(htmldata);
            $("#vendorDocumentlistModal").modal('show');

        }, request_url, datas, 'text');


    }
</script>

<script>
    function DownloadFile(e) {

        //$('#sktPleaseWait').modal('show');
        var url = e.getAttribute('data-url');

        var fileName = url.match(/([^\/]*)\/*$/)[1];
        $.ajax({
            url: url,
            cache: false,
            xhr: function() {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 2) {
                        if (xhr.status == 200) {
                            xhr.responseType = "blob";
                        } else {
                            xhr.responseType = "text";
                        }
                    }
                };
                return xhr;
            },
            beforeSend: function() {

                $("#snackbar").remove();
                $("body").append('<div id="snackbar" style="display:none;min-width: 250px;margin-left: -125px;color: #4a4fb3;text-align: center;border-radius: 2px;padding: 16px;position: fixed;z-index: 10;left: 50%;bottom: 50%;font-size: 50px;">Loading Start.</div>');
                $('#snackbar').html('<i class="fa fa-spinner loader" aria-hidden="true"></i>');
                $('#snackbar').show('2000');
                $('.parent-div').css("opacity", "0.5");
            },
            success: function(data) {
                $('#snackbar').html('<i class="fa fa-spinner loader" aria-hidden="true"></i>');
                $('#snackbar').hide('5000');
                $('.parent-div').css("opacity", "1");


                var blob = new Blob([data], {
                    type: "application/octetstream"
                });


                var isIE = false || !!document.documentMode;
                if (isIE) {
                    window.navigator.msSaveBlob(blob, fileName);
                } else {
                    var url = window.URL || window.webkitURL;
                    link = url.createObjectURL(blob);
                    var a = $("<a />");
                    a.attr("download", fileName);
                    a.attr("href", link);
                    $("body").append(a);
                    a[0].click();
                    $("body").remove(a);
                }
            }
        });
    };

    function vendor_get_email(email) {
        $('#vnd_contact_email').val(email);
    }

    function vendor_get_phone(phone) {
        $('#vnd_contact_phone').val(phone);
    }
</script>