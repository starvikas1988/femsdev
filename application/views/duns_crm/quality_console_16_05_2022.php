<style>
    .btn-sm{
        padding: 2px 5px;
    }
    .scrollheightdiv{
        max-height:600px;
        overflow-y:scroll;
    }
    #table-responsive{
        overflow:auto;
    }
    .tab_hed{
        color:#000;
    }
</style>

<div class="wrap">
    <section class="app-content">

        <div class="row">
            <div class="col-md-12">
                <?php if (!empty($this->input->get('elog')) && $this->input->get('elog') == "error") { ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="fa fa-warning"></i> Record Already Exist!
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="row">

            <div class="col-md-12">
                <div class="widget">
                    <header class="widget-header">
                        <h4 class="widget-title"><i class="fa fa-calendar"></i> All Record Data</h4>
                    </header>
                    <hr class="widget-separator"/>
                    <div class="widget-body clearfix">
                        			
                            <div class="row">	
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Client</label>
                                        <select class="form-control" name="client_id" id="client_id">
                                            <option value="">Please Select</option>
                                            <?php echo duns_dropdown_3d_options($duns_clients_list, 'id', 'name', $client_id, ''); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>From Date</label>
                                        <input type="text" class="form-control oldDatePick" name="search_from" id="search_from" value="" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>To Date</label>
                                        <input type="text" class="form-control oldDatePick" name="search_to" id="search_to" value="" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Assign To</label>
                                        <select class="form-control" name="assign_to" id="assign_to">
                                            <option value="">Please Select</option>
                                        </select>
                                    </div>
                                </div>	

                                <hr/>	
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="button" id="serchBtn" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                                        </div>
                                    </div>
                                </div>
                      
                    </div>
                </div>
            </div>


            <?php // if(!empty($client_id)){ ?>

            <div class="col-md-12">
                <div class="widget">
                    <header class="widget-header">
                        <h4 class="widget-title"><i class="fa fa-database"></i> All Data List</h4>
                    </header>
                    <hr class="widget-separator"/>
                    <div class="widget-body clearfix">					
                        <div class="table-responsive">

                            <table id="default_datatable" class="table table-bordered mb-0 table table-striped skt-table" data-plugin="DataTable">  
                                <thead id="dat_header">

                                </thead>

                                <tbody>	
                                    <?php
                                    $countc = 0;
                                    foreach ($duns_data_list as $token) {
                                        $countc++;
                                        ?>	
                                        <tr>
                                            <td scope="row" class="text-center"><?php echo $countc; ?></td>
                                            <td scope="row"  class="text-center"><b><?php echo $token['client_name']; ?></b></td>
                                            <td scope="row" class="text-center"><b><?php echo $token['upload_date']; ?></b></td>
                                            <td scope="row" class="text-center"><b><?php echo $token['assigned_to_name']; ?></b></td>
                                            <td scope="row" class="text-center"><b><?php echo $token['assigned_date']; ?></b></td>


                                        </tr>
                                    <?php } ?>	
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>
            </div>

            <?php // } ?>


        </div>

        <br/><br/><br/><br/><br/><br/><br/>

    </section>
</div>


<script>
    $(document).on("click", "#serchBtn", function () {
       var client_id=$("#client_id").val();
       var client_id=$("#client_id").val();
       var client_id=$("#client_id").val();
       var client_id=$("#client_id").val();
        var table = $("#default_datatable").DataTable({
            destroy: true,
            "ajax": {
                url: "<?php echo base_url(); ?>Duns_crm/getDyanamicTablesData/" + encodeURIComponent(1) + "/" + 2,
                 type : 'GET'
                //data : { "month" : "10", "academic_year_id" : "1" }
            },
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            //searching: true,
            deferRender: true,
            "search": {"regex": true},
            dom: 'Blfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "aLengthMenu": [[25, 50, 75, -1], [25, 50, 75, "All"]],
            "iDisplayLength": 50,
            "bSort": false,
            initComplete: function () {
                this.api().columns('.select-filter').every(function () {
                    var column = this;
                    var select = $('<select><option value=""></option></select>')
                            .appendTo($(column.footer()).empty())
                            .on('change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                        );

                                column
                                        .search(val ? '^' + val + '$' : '', true, false)
                                        .draw();
                            });

                    column.data().unique().each(function (d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>')
                    });
                });
            },
        });
        // Apply the search
       table.columns().every( function () {
           var that = this;
    
           $( 'input', this.footer() ).on( 'keyup change clear', function () {
               if ( that.search() !== this.value ) {
                   that
                       .search( this.value )
                       .draw();
               }
           } );
       } );
    });
</script>            