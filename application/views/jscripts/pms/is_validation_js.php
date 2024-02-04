<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.6.16/sweetalert2.css" integrity="sha512-JzSVRb7c802/njMbV97pjo1wuJAE/6v9CvthGTDxiaZij/TFpPQmQPTcdXyUVucsvLtJBT6YwRb5LhVxX3pQHQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.6.16/sweetalert2.min.js"></script>
<style>
    .swal2-show {
        opacity: 0.9;
    }
</style>

<script>
    function requiredValidation(e) {
        var error = false;
        // for multiselect
        $(e).find('select.pms_multiselect[required]').each(function (event) {
            var val = $(this).val();

            if (typeof (val) != 'object') {
                if (val.trim() == "") {

                    $(this).next("div.btn-group").find("button.multiselect").css(
                        "border", "1px solid red"
                    );
                    // popupErrorMsg($(this), "Select an option to proceed", 3);
                    error = true;
                } else {
                    $(this).next("div.btn-group").find("button.multiselect").css(
                        "border", "1px solid #ddd"
                    );
                }
            } else {
                if (val.length == "0") {
                    $(this).next("div.btn-group").find("button.multiselect").css(
                        "border", "1px solid red"
                    );
                    // popupErrorMsg($(this), "Select an option to proceed", 3);
                    error = true;
                } else {
                    $(this).next("div.btn-group").find("button.multiselect").css(
                        "border", "1px solid #ddd"
                    );
                }
            }
        });
        // end
        $(e).find('input[required]').each(function (event) {
            var val = $(this).val();
            if (val.trim() == "") {
                $(this).css({
                    "border": "1px solid red"
                });
                $(this).focus();
                popupErrorMsg($(this), "Fill the field to proceed", 3);
                error = true;

            } else {
                $(this).css({
                    "border": "1px solid #ddd"
                });

            }
        });
        $(e).find('input[number]').each(function (event) {
            var val = $(this).val();
            if (checkNonDec(val.trim()) == false) {
                $(this).css({
                    "border": "1px solid red"
                });
                $(this).focus();
                popupErrorMsg($(this), "Decimal value Not allowed", 3);
                error = true;

            } else {
                $(this).css({
                    "border": "1px solid #ddd"
                });

            }
        });
        $(e).find('textarea').each(function (event) {
            var val = $(this).val();
            if (checkNonDec(val.trim()) == false) {
                $(this).css({
                    "border": "1px solid red"
                });
                $(this).focus();
                popupErrorMsg($(this), "Fill the field to proceed", 3);
                error = true;

            } else {
                $(this).css({
                    "border": "1px solid #ddd"
                });

            }
        });
        $(e).find('select[required]').each(function (event) {
            var val = $(this).val();
            if (typeof (val) != 'object') {
                if (val.trim() == "") {
                    $(this).focus().css({
                        "border": "1px solid red"
                    });
                    popupErrorMsg($(this), "Select an option to proceed", 3);
                    error = true;
                } else {
                    $(this).css({
                        "border": "1px solid #ddd"
                    });
                }
            } else {
                if (val.length == "0") {
                    $(this).focus().css({
                        "border": "1px solid red"
                    });
                    popupErrorMsg($(this), "Select an option to proceed", 3);
                    error = true;
                } else {
                    $(this).css({
                        "border": "1px solid #ddd"
                    });
                }
            }
        });
        $(e).find('input[min]').each(function (event) {
            var val = $(this).val();
            var min = $(this).attr("min");
            if (val.trim() < Number(min)) {
                $(this).css({
                    "border": "1px solid red"
                });
                $(this).focus();
                popupErrorMsg($(this), `Value must be grater than or equal to ${min}`, 3);
                error = true;
            } else {
                $(this).css({
                    "border": "1px solid #ddd"
                });

            }
        });
        $(e).find('input[max]').each(function (event) {
            var val = $(this).val();
            var max = $(this).attr("max");
            if (val.trim() > Number(max)) {
                $(this).css({
                    "border": "1px solid red"
                });
                $(this).focus();
                popupErrorMsg($(this), `Value must be less than or equal to ${max}`, 3);
                error = true;
            } else {
                $(this).css({
                    "border": "1px solid #ddd"
                });

            }
        });

        return error;
    }

    function popupErrorMsg(e, msg, interval) {
        //$(".kmi-popup_error").remove();
        var div = $(e).closest("div");
        var offset = $(e).position();
        var close = document.createElement('div');
        $(close).addClass("kmi-popup_error")
                .html(msg)
                .css({
                    "position": "absolute",
                    "left": (offset.left),
                    "top": (offset.top - 30),
                    "z-index": "10999",
                    "color": "white",
                    "font-size": "14px",
                    "cursor": "pointer",
                    "background-color": "#dd4b39",
                    "border-radius": "3px",
                    "padding": "5px",
                    "width": "150px;",
                    "text-align": "center",
                    "display": "none"
                })
                .attr("id", "kmi-popup_error")
                .appendTo(div)
                .on("click", function () {
                    $(close).remove();
                });
        $(close).slideDown("slow");
        $(close).fadeOut(interval * 1000);
        setTimeout(function () {
            $(close).remove();
        }, interval * 1000);
    }

    function checkNonDec(val) {
        var ex = /^[0-9]*$/;
        if (val.match(ex) == false) {
            return false;
        } else {
            return true;
        }
    }
</script><!-- Validation code End Here -->

<script>
    function swal_confirm(title_val) {
     
        Swal.fire({
            title: title_val,
            text: "",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm'
        }).then((result) => {

           
           localStorage.setItem("confirmVal",result.isConfirmed);


        });
        
        let confirm=localStorage.getItem("confirmVal");
        if(confirm!=undefined){
            return confirm;
        }
    }
    
    function returnStu(vat)
    {
        return vat;
    }
    function popupMessage(text, color = '', icon) {
        toastMixin.fire({
            title: text,
            color: "#fff",
            background: color,
            icon: icon

        });
    }
    var toastMixin = Swal.mixin({
        toast: true,
        icon: 'success',
        title: 'General Title',
        position: 'top-right',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
</script>

<script>
    function validatefile(id, chkFile = 'Y') {
        dt = $(id).val();
        var size = id.files[0].size;
        if (size > 1048576) {
            popupMessage('The File size should not be greater than 1 MB ', "Goldenrod", "warning");
            $(id).val('');
            return false;
        }
        if (chkFile == 'Y') {
            var fileExtension = ['csv'];
            if ($.inArray($(id).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                popupMessage("We support only : CSV formats", "Goldenrod", "warning");
                $(id).val('');
            }
            return false;
    }

    }
</script>