<script>
    let URL = "<?= base_url() ?>";
    function editnews(id) {
        if (id != '') {
            $('#sktPleaseWait').modal('show');
            $.post(URL + "news/geteditdata", {id: id}).done(function (data) {
                if (data != '0') {
                    $('#sktPleaseWait').modal('hide');
                    let dat = JSON.parse(data);
                    $("#id").val(dat.id);
                    $("#from_date").val(dat.from_date);
                    $("#to_date").val(dat.to_date);
                    $("#title").val(dat.title);
                    $("#priority"+dat.priority).attr('checked',true);
                    CKEDITOR.instances['message'].setData(dat.message);                  
                    $("#edit_news").modal('show');
                } else {
                    alert("Edit not Possible");
                }
            });
        }

    }
    function deletenews(id) {
        if (id != '') {
            $('#sktPleaseWait').modal('show');
            $.post(URL + "news/deletedata", {id: id}).done(function (data) {
                if (data != '0') {
                   location.reload();
                } else {
                    alert("Delete not Possible");
                }
            });
        }

    }
function changestatus(id,status){
     if (id != '') {
         $('#sktPleaseWait').modal('show');
            $.post(URL + "news/changestatus", {id: id,is_publish:status}).done(function (data) {
                if (data != '0') {
                   location.reload();
                } else {
                    alert("Can not Published");
                }
            });
        }
}
</script>    