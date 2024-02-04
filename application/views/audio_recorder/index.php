<style>
    .add_new_box{
        text-align:right;
    }
    .btn-add{
        background-color:#188ae2;
        color:#fff;
    }
    .btn-add>i.fa{
        margin-right:5px;
    }
    .recorder{
        display:flex;
        flex-direction:column;
        justify-content:center;
        min-height:20vh;
        align-items:center;
    }
    .timer{
        margin:6px 0 0 0;
        font-size:1rem;
        font-weight:bold;
    }
    #stop_rec{
        display:none;
    }
    .recordActions{
        display:flex;
    }
</style>
<div class="wrap">
    <section class="app-content">
        <div class="row">
            <div class="col-12">
                <div class="widget">
                    <div class="widget-body">
                        <div class="add_new_box">
                            <button type="button" class="btn btn-add" data-toggle="modal">
                                <i class="fa fa-plus"></i>Add New
                            </button>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <!-- <th>S.No.</th> -->
                                    <th>Audio File Name</th>
                                    <!-- <th>Date Created</th> -->
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="recordingList"></tbody>
                        </table>
                    </div>
                    <div class="modal" id="add_new_box">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Record New Audio</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="recorder">
                                        <button class="btn rounded" id="start_rec">
                                            <i class="fa fa-microphone fa-2x"></i>
                                        </button>
                                        <button class="btn rounded" id="stop_rec">
                                            <i class="fa fa-microphone-slash fa-2x"></i>
                                        </button>
                                        <span class="timer"></span>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                    <!-- <button class="btn btn-success">Save Recording</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
