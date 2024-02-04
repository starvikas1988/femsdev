<!--<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>-->
<!--<link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.6.16/sweetalert2.min.css" integrity="sha512-NvuRGlPf6cHpxQqBGnPe7fPoACpyrjhlSNeXVUY7BZAj1nNhuNpRBq3osC4yr2vswUEuHq2HtCsY2vfLNCndYA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.6.16/sweetalert2.all.min.js" integrity="sha512-4tvE14sHIcdIHl/dUdMHp733PI6MpYA7BDnDfndQmx7aIovEkW+LfkonVO9+NPWP1jYzmrqXJMIT2tECv1TsEQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!--<script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>-->

<script>
    function getDataList(URL) {
        if ($("#pms_data_list").length) {
            $('#pms_data_list').DataTable().clear().destroy();
            var dataTable = $('#pms_data_list').DataTable({
                "pageLength": '10',
                "lengthMenu": [
                    [10, 20, 50, 100, 150, 200, -1],
                    [10, 20, 50, 100, 150, 200, 'All'],
                ],
                "columnDefs": [{
                        "targets": [0, -1],
                        "searchable": false

                    }, // Disable search on first 
                    {
                        "targets": [0, -1],
                        "orderable": false

                    }
                ],
                'scrollCollapse': false,
                'processing': true,
                'serverSide': true,
                'responsive': true,
                'serverMethod': 'post',
                'searching': true, // Remove default Search Control
                'ajax': {
                    complete: function (data) {
                        console.log(data);
                    },
                    'url': URL,
                    'data': function (data) {
                        var $form = $("#report_hx_filter");
                        var fdata = $($form).serialize();
                        data.form_data = fdata;
                    }
                }
            });
        }
    }

    function getindvDataList(URL) {
        let start_date=$("#pms_start_date").val();
        // let brand=$("#brand").val();
        // let location=$("#location").val();
        // let process=$("#process").val();
        let mwp_id=$("#mwp_id").val();
       
        // if(start_date!='' || brand!='' || location!='' || process!='' ){
        if(start_date!='' || mwp_id!=''){
        
        if ($("#pms_indv_data_list").length) {
            $('#pms_indv_data_list').DataTable().clear().destroy();
            var dataTable = $('#pms_indv_data_list').DataTable({
                "pageLength": '10',
                "lengthMenu": [
                    [10, 20, 50, 100, 150, 200, -1],
                    [10, 20, 50, 100, 150, 200, 'All'],
                ],
                "columnDefs": [{
                        "targets": [0, -1],
                        "searchable": false

                    }, // Disable search on first 
                    {
                        "targets": [0, -1],
                        "orderable": false

                    }
                ],
                'scrollCollapse': false,
                'processing': true,
                'serverSide': true,
                'responsive': true,
                'serverMethod': 'post',
                'searching': true, // Remove default Search Control
                'ajax': {                  
                    complete: function (data) {
                        console.log(data);
                    },                   
                    'url': URL,
                    'data': function (data) {
                        var $form = $("#report_indv_filter");
                        var fdata = $($form).serialize();
                        data.form_data = fdata;
                    }
                }
            });
        }
    }else{
        swal.fire({icon: 'error',title: 'Please add some filter.'}); 
    }
    }
</script>
<script>
    $("#check_all").change(function () {
        if ($("#check_all").is(":checked")) {
            $(".check_ticket_approval").attr("checked", true);
        } else {
            $(".check_ticket_approval").attr("checked", false);
        }
    });

</script>




<script>
    function dateconvert(dat) {
        var todaydate = new Date(dat);  //pass val varible in Date(val)
        var dd = todaydate.getDate();
        var mm = todaydate.getMonth() + 1; //January is 0!
        var yyyy = todaydate.getFullYear();
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }
        var date = dd + '-' + mm + '-' + yyyy;
        return date;
    }

</script>


