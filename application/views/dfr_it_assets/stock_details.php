<link href="<?=base_url()?>assets/css/search-filter/assets/css/simple-datatables-latest.css" rel="stylesheet" />
<link href="<?=base_url()?>assets/css/search-filter/assets/css/custom.css" rel="stylesheet" />
<script src="<?=base_url()?>assets/css/search-filter/assets/js/all.min.js"></script>

<style>
.mb-1 {
    margin-bottom: 1.25rem !important;
}

.modal .close {
    color: #fff;
    text-shadow: none;
    opacity: 1;
    position: absolute;
    top: -15px;
    right: -14px;
    width: 35px;
    height: 35px;
    background: #0c6bb5;
    border-radius: 50%;
    transition: all 0.5s ease-in-out 0s;
}

.modal .modal-title {
    color: #fff;
}

.search-select label {
    display: block;
}

.search-select .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
    width: 100%;
   
}
.bootstrap-select > .dropdown-toggle {
  
  height: 40px;
}
.search-select ul{
max-height: 200px!important;

}
</style>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 d-flex flex-column text-dark fw-bolder fs-2 mb-4">Assets Stock Details</h1>
            <div class="card mb-4">
                <div class="card-header">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" style="float:right;"><i class="fas fa-plus" style="padding-right:5px;"></i>Add More</button>
                </div>
                <div class="card-body">
                    <div class="filter-widget">
                        <form>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="mb-1 search-select">
                                        <label for="exampleInputEmail1" class="form-label ">Demo:</label>
                                        <select class="selectpicker " data-show-subtext="true" data-live-search="true">
                                            <option value="">Select</option>
                                            <option value="">Computer</option>
                                            <option value="">Desktop</option>
                                            <option value="">Mouse</option>
                                            <option value="">CPU</option>
                                             <option value="">Computer</option>
                                            <option value="">Desktop</option>
                                            <option value="">Mouse</option>
                                            <option value="">CPU</option>
                                             <option value="">Computer</option>
                                            <option value="">Desktop</option>
                                            <option value="">Mouse</option>
                                            <option value="">CPU</option>
                                             <option value="">Computer</option>
                                            <option value="">Desktop</option>
                                            <option value="">Mouse</option>
                                            <option value="">CPU</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-1 search-select">
                                        <label for="exampleInputEmail1" class="form-label ">Demo:</label>
                                        <select class="selectpicker " data-show-subtext="true" data-live-search="true">
                                            <option value="">Select</option>
                                            <option value="">Computer</option>
                                            <option value="">Desktop</option>
                                            <option value="">Mouse</option>
                                            <option value="">CPU</option>
                                             <option value="">Computer</option>
                                            <option value="">Desktop</option>
                                            <option value="">Mouse</option>
                                            <option value="">CPU</option>
                                             <option value="">Computer</option>
                                            <option value="">Desktop</option>
                                            <option value="">Mouse</option>
                                            <option value="">CPU</option>
                                             <option value="">Computer</option>
                                            <option value="">Desktop</option>
                                            <option value="">Mouse</option>
                                            <option value="">CPU</option>
                                        </select>
                                    </div>
                                </div>
                                   <div class="col-sm-4">
                                    <div class="mb-1 search-select">
                                        <label for="exampleInputEmail1" class="form-label ">Demo:</label>
                                        <select class="selectpicker " data-show-subtext="true" data-live-search="true">
                                            <option value="">Select</option>
                                            <option value="">Computer</option>
                                            <option value="">Desktop</option>
                                            <option value="">Mouse</option>
                                            <option value="">CPU</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-1 search-select">
                                        <label for="exampleInputEmail1" class="form-label ">Demo:</label>
                                        <select class="selectpicker " data-show-subtext="true" data-live-search="true">
                                            <option value="">Select</option>
                                            <option value="">Computer</option>
                                            <option value="">Desktop</option>
                                            <option value="">Mouse</option>
                                            <option value="">CPU</option>
                                        </select>
                                    </div>
                                </div>
                                   <div class="col-sm-4">
                                    <div class="mb-1 search-select">
                                        <label for="exampleInputEmail1" class="form-label ">Demo:</label>
                                        <select class="selectpicker " data-show-subtext="true" data-live-search="true">
                                            <option value="">Select</option>
                                            <option value="">Computer</option>
                                            <option value="">Desktop</option>
                                            <option value="">Mouse</option>
                                            <option value="">CPU</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-1 search-select">
                                        <label for="exampleInputEmail1" class="form-label ">Demo:</label>
                                        <select class="selectpicker " data-show-subtext="true" data-live-search="true">
                                            <option value="">Select</option>
                                            <option value="">Computer</option>
                                            <option value="">Desktop</option>
                                            <option value="">Mouse</option>
                                            <option value="">CPU</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="mb-0">
                                        <button type="submit" class="blue-btn  mt-3"><i class="fa fa-search me-1" aria-hidden="true"></i>Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div> . </div>
            </div>
            <div class="card mb-4">
                <div class="card-header"> <i class="fas fa-table me-1"></i> List </div>
                <div class="card-body">
                    <table id="datatablesSimple" class="table table-striped">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Date of Request</th>
                                <th>Location</th>
                                <th>Request By</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Role</th>
                                <th>Remarks</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>SL No</th>
                                <th>Date of Request</th>
                                <th>Location</th>
                                <th>Request By</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Role</th>
                                <th>Remarks</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <tr>
                                <td>Demo</td>
                                <td>Demo</td>
                                <td>Demo</td>
                                <td>Demo</td>
                                <td>Demo</td>
                                <td>Demo</td>
                                <td>Demo</td>
                                <td>Demo</td>
                                <td>
                                    <label class="btn status_btn pb-1">Active</label>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal1"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>Deno</td>
                                <td>Demo</td>
                                <td>Demo</td>
                                <td>Demo</td>
                                <td>Demo</td>
                                <td>Demo</td>
                                <td>Demo</td>
                                <td>Demo</td>
                                <td>
                                    <label class="btn status_btn pb-1">Active</label>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal1"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>Deno</td>
                                <td>Demo</td>
                                <td>Demo</td>
                                <td>Demo</td>
                                <td>Demo</td>
                                <td>Demo</td>
                                <td>Demo</td>
                                <td>Demo</td>
                                <td>
                                    <label class="btn status_btn pb-1">Active</label>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal1"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title ">Modal Header</h4> </div>
            <div class="modal-body">
                <div class="filter-widget">
                    <form>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-1">
                                    <label for="exampleInputEmail1" class="form-label">Location:</label>
                                    <select class="form-control">
                                        <option value="">Select</option>
                                        <option value="">Demo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-1">
                                    <label for="exampleInputEmail1" class="form-label">Assets Name:</label>
                                    <select class="form-control">
                                        <option value="">Select</option>
                                        <option value="">Demo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-1">
                                    <label for="exampleInputEmail1" class="form-label">Select Brand:</label>
                                    <select class="form-control">
                                        <option value="">Select</option>
                                        <option value="">Demo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-1">
                                    <label for="exampleInputEmail1" class="form-label">Serial Number:</label>
                                    <input type="text" class="form-control" name=""> </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-1">
                                    <label for="exampleInputEmail1" class="form-label">Modal Number:</label>
                                    <input type="text" class="form-control" name=""> </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-1">
                                    <label for="exampleInputEmail1" class="form-label">Configuration:</label>
                                    <input type="text" class="form-control" name=""> </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-1">
                                    <label for="exampleInputEmail1" class="form-label">Remarks:</label>
                                    <input type="text" class="form-control" name=""> </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default default-btn" data-dismiss="modal" style="margin-top: -5px;padding: 11px;">Close</button>
                <button type="button" class="blue-btn width" style="display:inline-block;">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal 1-->
<div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title ">Modal Header</h4> </div>
            <div class="modal-body">
                <div class="filter-widget">
                    <form>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-1">
                                    <label for="exampleInputEmail1" class="form-label">Location:</label>
                                    <select class="form-control">
                                        <option value="">Select</option>
                                        <option value="">Demo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-1">
                                    <label for="exampleInputEmail1" class="form-label">Assets Name:</label>
                                    <select class="form-control">
                                        <option value="">Select</option>
                                        <option value="">Demo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-1">
                                    <label for="exampleInputEmail1" class="form-label">Select Brand:</label>
                                    <select class="form-control">
                                        <option value="">Select</option>
                                        <option value="">Demo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-1">
                                    <label for="exampleInputEmail1" class="form-label">Serial Number:</label>
                                    <input type="text" class="form-control" name=""> </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-1">
                                    <label for="exampleInputEmail1" class="form-label">Modal Number:</label>
                                    <input type="text" class="form-control" name=""> </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-1">
                                    <label for="exampleInputEmail1" class="form-label">Configuration:</label>
                                    <input type="text" class="form-control" name=""> </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-1">
                                    <label for="exampleInputEmail1" class="form-label">Remarks:</label>
                                    <input type="text" class="form-control" name=""> </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default default-btn" data-dismiss="modal" style="margin-top: -5px;padding: 11px;">Close</button>
                <button type="button" class="blue-btn width" style="display:inline-block;">Save</button>
            </div>
        </div>
    </div>
</div>
<script src="<?=base_url()?>assets/css/search-filter/assets/js/scripts.js"></script>
<script src="<?=base_url()?>assets/css/search-filter/assets/js/simple-datatables-latest.js"></script>
<script src="<?=base_url()?>assets/css/search-filter/assets/js/datatables-simple-demo.js"></script>
