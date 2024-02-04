<div class="modal-dialog" role="document">
    <form id="form1" method="post" action="<?=base_url()?>course_modal_con/save_certificate" enctype="multipart/form-data">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Certificate List</h5> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">                
                <input type="hidden" id="course_id" name="course_id" value="<?= $course_id ?>" >
                <button type="button" id="createCertificate1" onclick="createCertificate('<?= $course_id ?>');" class="btn btn-primary" id="save_course">Create Certificate</button>
                <div class="row" style="padding-bottom:10px">
                    <div class="widget-body">
                        <table id="course_certificate_list" class="table datatable">
                            <thead style="border: none;">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col"></th>
                                    <th scope="col">Certificate Title</th>
                                    <th scope="col">CC Mail</th>                                    
                                    <th scope="col"></th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i=0;
                               // echo "<pre>";print_r($certificate_list);exit;
                                if(count($certificate_list)>0){
                                    foreach($certificate_list as $list){
                                        $cert_id=$list['certificate_id']!=''?'checked':'';
                                        $i++;
                                        ?>
                                    
                                <tr>
                                    <td><?=$i?></td>
                                    <td>
                                        <input type="radio" name="assign_list" value="<?=$list['id']?>" <?=$cert_id?>>
                                    </td>
                                    <td><?=$list['title']?></td>
                                    <td><?=$list['cc_email']?></td>
                                    <td>
                                        <button type="button" class="btn btn-xs success" id="view_certificate" onclick="viewCertificate('<?=$list['id']?>','<?= $course_id ?>');" title="View certificate"><i class="fa fa-eye"></i></button>
                                    </td>
                                </tr>
                                <?php
                                }
                                }
                                ?>
                            </tbody>
                        </table> 
                    </div>
                </div> 

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="view_certificate" class="btn btn-primary" id="save_course">Save</button>
            </div>
        </div>
    </form>
</div>