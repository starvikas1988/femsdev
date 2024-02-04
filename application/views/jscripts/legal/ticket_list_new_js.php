<script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/super-build/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap.min.js"></script>

<!--start data table library here-->
<script src="<?php echo base_url()?>assets/legal/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>assets/legal/js/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo base_url()?>assets/legal/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url()?>assets/legal/js/buttons.bootstrap5.min.js"></script>
<script src="<?php echo base_url()?>assets/legal/js/jszip.min.js"></script>
<script src="<?php echo base_url()?>assets/legal/js/vfs_fonts.js"></script>
<script src="<?php echo base_url()?>assets/legal/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url()?>assets/legal/js/buttons.print.min.js"></script>
<script src="<?php echo base_url()?>assets/legal/js/buttons.colVis.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<!--start muliselect checkbox here-->
<script src="<?php echo base_url() ?>assets/legal/js/bootstrap-multiselect.js"></script>
<script>
	$('#mytextarea_neww').summernote({
		placeholder: 'Enter Your Message',
		tabsize: 2,
		height: 120,
		toolbar: [
		['style', ['style']],
		['font', ['bold', 'underline', 'clear']],
		['color', ['color']],
		['para', ['ul', 'ol', 'paragraph']],
		['table', ['table']],
		['insert', ['link', 'picture', 'video']],
		['view', ['fullscreen', 'codeview', 'help']]
		]
	});
	
 $(document).ready(function() {
        $('.multi_select').multiselect({
            enableFiltering: true,
            includeSelectAllOption: true,
            maxHeight: 400,
            dropUp: true
        });
    });
</script>
<!--end muliselect checkbox here-->

<script>
            
            CKEDITOR.ClassicEditor.create(document.getElementById("editor"), {
                
                toolbar: {
                    items: [
                        'exportPDF','exportWord', '|',
                        'findAndReplace', 'selectAll', '|',
                        'heading', '|',
                        'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                        'bulletedList', 'numberedList', 'todoList', '|',
                        'outdent', 'indent', '|',
                        'undo', 'redo',
                        '-',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                        'alignment', '|',
                        'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
                        'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                        'textPartLanguage', '|',
                        'sourceEditing'
                    ],
                    shouldNotGroupWhenFull: true
                },

                list: {
                    properties: {
                        styles: true,
                        startIndex: true,
                        reversed: true
                    }
                },
               
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                        { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                        { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                    ]
                },
                
                placeholder: '',
                
                fontFamily: {
                    options: [
                        'default',
                        'Arial, Helvetica, sans-serif',
                        'Courier New, Courier, monospace',
                        'Georgia, serif',
                        'Lucida Sans Unicode, Lucida Grande, sans-serif',
                        'Tahoma, Geneva, sans-serif',
                        'Times New Roman, Times, serif',
                        'Trebuchet MS, Helvetica, sans-serif',
                        'Verdana, Geneva, sans-serif'
                    ],
                    supportAllValues: true
                },
                
                fontSize: {
                    options: [ 10, 12, 14, 'default', 18, 20, 22 ],
                    supportAllValues: true
                },
                
                htmlSupport: {
                    allow: [
                        {
                            name: /.*/,
                            attributes: true,
                            classes: true,
                            styles: true
                        }
                    ]
                },
                
                htmlEmbed: {
                    showPreviews: true
                },
                
                link: {
                    decorators: {
                        addTargetToExternalLinks: true,
                        defaultProtocol: 'https://',
                        toggleDownloadable: {
                            mode: 'manual',
                            label: 'Downloadable',
                            attributes: {
                                download: 'file'
                            }
                        }
                    }
                },
                
                mention: {
                    feeds: [
                        {
                            marker: '@',
                            feed: [
                                '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                                '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                                '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                                '@sugar', '@sweet', '@topping', '@wafer'
                            ],
                            minimumCharacters: 1
                        }
                    ]
                },
                
                removePlugins: [
                   
                    'CKBox',
                    'CKFinder',
                    'EasyImage',
                   
                    'RealTimeCollaborativeComments',
                    'RealTimeCollaborativeTrackChanges',
                    'RealTimeCollaborativeRevisionHistory',
                    'PresenceList',
                    'Comments',
                    'TrackChanges',
                    'TrackChangesData',
                    'RevisionHistory',
                    'Pagination',
                    'WProofreader',
                   
                    'MathType'
                ]
            });
        </script>	

<script>

	

	// $(document).ready(function() {
	// 	var table = $('#example').DataTable({
	// 		lengthChange: false,
	// 		buttons: ['excel', '', '', '']
	// 	});

	// 	table.buttons().container()
	// 		.appendTo('#example_wrapper .col-md-6:eq(0)');
	// });
	// $(".alphanumeric_class").keyup(function (e) {
	// 		 var keyCode = e.keyCode || e.which;
 	// 		$(".fusion_id_validation").html("");
    //         var regex = /^[A-Za-z0-9]+$/;
	// 	    var isValid = regex.test(String.fromCharCode(keyCode));
    //         if (!isValid) {
    //             // $("#lblError").html("Only Alphabets and Numbers allowed.");
	// 			$(".fusion_id_validation").html("Only Alphabets and Numbers allowed");
	// 			$(".disable_btn").attr("disabled",true);
	// 			$(".submit_btn").removeClass("active_btn");
	// 			return false;
				
    //         }
	// 		else{ 
    //         return isValid;
	// 		}
    //     })


	$(document).ready(function() {
		$("#filter_view").click(function() {
			$(".right_panel").animate({
				width: "toggle"
			});
		});
		$(".close_ticket").click(function() {
			$(".right_panel").animate({
				width: "toggle"
			});
		});
		$(".back_btn").click(function() {
			$(".footer-new").addClass("footer_expand");
		});
	});
	note_section = () => {
		$("#note_div").show();
		$("#home").hide();
		$("#hold_div").hide();
		$("#reply_div").hide();
		$("#attachment_div").hide();
		$("#work_approal_div").hide();
		$("#file_uploaded_div").hide();
		$("#reject_approve_div").hide();


	}

	hold_section=() =>{
		$("#note_div").hide();
		$("#hold_div").show();
		$("#home").hide();
		$("#reply_div").hide();
		$("#attachment_div").hide();
		$("#work_approal_div").hide();
		$("#file_uploaded_div").hide();
		$("#reject_approve_div").hide();



	}

	work_approval_section=()=>{
		$("#note_div").hide();
		$("#hold_div").hide();
		$("#home").hide();
		$("#reply_div").hide();
		$("#attachment_div").hide();
		$("#work_approal_div").show();
		$("#file_uploaded_div").hide();
		$("#reject_approve_div").hide();



		
	}
	file_uploaded_section=()=>{
		$("#note_div").hide();
		$("#hold_div").hide();
		$("#home").hide();
		$("#reply_div").hide();
		$("#attachment_div").hide();
		$("#work_approal_div").hide();
		$("#file_uploaded_div").show();
		$("#reject_approve_div").hide();

		
	}
	approval_rejected_section=()=>{
		$("#note_div").hide();
		$("#hold_div").hide();
		$("#home").hide();
		$("#reply_div").hide();
		$("#attachment_div").hide();
		$("#work_approal_div").hide();
		$("#file_uploaded_div").hide();
		$("#reject_approve_div").show();
		
	}
	
	attachment_section	= () =>{
		$("#attachment_div").show();
		$("#home").hide();
		$("#reply_div").hide();
		$("#note_div").hide();
		$("#hold_div").hide();
		$("#work_approal_div").hide();
		$("#file_uploaded_div").hide();
		$("#reject_approve_div").hide();


	}


	approval_section = () =>{
		$("#modalapprovereject").show();
	}
	home_section = () => {
		$("#note_div").hide();
		$("#reply_div").hide();
		$("#attachment_div").hide();
		$("#home").show();
		$("#hold_div").hide();
		$("#work_approal_div").hide();
		$("#file_uploaded_div").hide();
		$("#reject_approve_div").hide();


	}
	master_access_add_section = () =>{
		$("#access_add_section").modal("show");
	}
	master_tl_access_add_section = () =>{
		$("#access_add_section_for_tl").modal("show");
	}
	reply_section = () => {
		$("#note_div").hide();
		$("#attachment_div").hide();
		$("#home").hide();
		$("#reply_div").show();
		$("#hold_div").hide();
		$("#work_approal_div").hide();
		$("#reject_approve_div").hide();

	}

	//goutam added for hold section
	

	$("#holdCallModalButton").click(function(e) {
		// e.preventDefault();
	    $("#holdCallModal").modal("show");
		
	});


	//goutam end here for hold section
	// $('.x_MsoNormal').click(function(){
	// 	src=$('.x_MsoNormal img').attr('id');
	// 	alert(src);
    // });

// 	$(".x_MsoNormal").click(function(){
//    alert($(this).attr('id'));
// });
function attachments_size(data="") {
	if(data == ""){
		var size=$('.attachments_work_reply')[0].files[0].size;
		// alert(size);
		const fileSize = size / 1024 / 1024; // in MiB
		if (fileSize > 5) {
			alert('File size exceeds 5 MB');
			$('.attachments_work_reply').val('');
		}
	}else{
		var size=$('.attachments_work_approval')[0].files[0].size;
		// alert(size);
		const fileSize = size / 1024 / 1024; // in MiB
		if (fileSize > 5) {
			alert('File size exceeds 5 MB');
			$('.attachments_work_approval').val('');
		}
	}
}
	
$(document).ready(function(){
	// alert(11);
	// var url = $(location).attr('href').split("/").splice(1, 5).join("/");
	// alert(url);
	
	$(".x_MsoNormal").wrap("<a href='test.html'></a>");



	var maxField = 20; 
    var addButton = $('.add_button'); 
    var wrapper = $('.field_wrapper'); 
	var fieldHTML = '<div class="mb-3"><input type="text" name="field_name[]" required class="form-control fusion_id_exists" id="exampleInputEmail1" aria-describedby="emailHelp"><a href="javascript:void(0);" class="remove_button" title="Remove field"><i class="fa fa-trash text-danger" aria-hidden="true"></i></a></div>'; 
    var x = 1;
    $(addButton).click(function(){
        if(x < maxField){ 
            x++; 
            $(wrapper).append(fieldHTML); 
        }
    });
    
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); 
        x--; 
    });
});
$(document).ready(function(){
	// alert(11);
	var maxField = 20; 
    var addButton = $('.add_button_tl'); 
    var wrapper = $('.field_wrapper_tl'); 
	var fieldHTML = '<div class="row remove_div"><div class="col-sm-6"><div class="mb-3"><input type="text" name="field_name[]" required class="form-control fusion_id_exists_for_tl" id="exampleInputEmail1" aria-describedby="emailHelp"><a href="javascript:void(0);" class="remove_button" title="Remove field"><i class="fa fa-trash text-danger" aria-hidden="true"></i></a></div></div><div class="col-sm-6"><select class="form-control select_box" name="type[]"><option value="1">Agent</option><option value="2">TL</option></select></div></div>'; 
    var x = 1;
    $(addButton).click(function(){
        if(x < maxField){ 
            x++; 
            $(wrapper).append(fieldHTML); 
        }
    });
    
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        // $(this).parent('div').remove(); 
		// $(this).parent().parent('div').remove();
		$(this).closest('.remove_div').remove();
        x--; 
    });
});







		access_remove=(val)=>{
		if (confirm("Do you want to remove access!") == true) {
				baseURL = "<?php echo base_url(); ?>";
				// alert(baseURL);
					$.ajax({
						url: "<?php echo base_url('legal_manual/remove_access'); ?>",
						type: "POST",
						data: {
							fusion_id: val						
						},
						dataType: "text",
						success: function(token) {

							notReply = 1;
							$('#sktPleaseWait').modal('hide');
							location.href = "<?php echo base_url()?>legal/master_access";
						},
						error: function(token) {
							notReply = 1;
							$('#sktPleaseWait').modal('hide');
						}
					});
				

					} else {
						alert('You pressed no');
					}
	}
	access_remove_for_tl=(val)=>{
		if (confirm("Do you want to remove access!") == true) {
				baseURL = "<?php echo base_url(); ?>";
				// alert(baseURL);
					$.ajax({
						url: "<?php echo base_url('legal_manual/remove_access_for_tl'); ?>",
						type: "POST",
						data: {
							fusion_id: val						
						},
						dataType: "text",
						success: function(token) {

							notReply = 1;
							$('#sktPleaseWait').modal('hide');
							location.href = "<?php echo base_url()?>legal/tl_access";
						},
						error: function(token) {
							notReply = 1;
							$('#sktPleaseWait').modal('hide');
						}
					});
				

					} else {
						alert('You pressed no');
					}
	}
       
		// 	$(document).on("keyup",".fusion_id_exists",function(){
		// 	$(".fusion_id_exist").text("");
		// 	srch = $(this).val();
		// 	if(srch.length>5){
        //     $.ajax({
        //         type: 'POST',
        //         url: '<?php echo base_url(); ?>legal_manual/validate_existest_accessid',
		// 		data: {
		// 					fusion_id: srch						
		// 				},
        //         success: function (response) {
        //             response = response.trim();
        //             if (response == "OK") {
        //                 $(".fusion_id_exist").text("");
		// 				$(".disable_btn").attr("disabled",false);
        //             } else {
        //                 $(".fusion_id_exist").text(response);
		// 				$(".disable_btn").attr("disabled",true);
        //             }
        //         }
        //     });
		// }
		// else{
		// 	$(".fusion_id_exist").text("You enter wrong Character");
		// 	$(".disable_btn").attr("disabled",true);
		// }

        // });
		$(document).on("keyup",".fusion_id_exists",function(e)
		{



		var keyCode = e.keyCode || e.which;
		$(".fusion_id_exist").text("");
		 var regex = /^[A-Za-z0-9]+$/;
		var isValid = regex.test(String.fromCharCode(keyCode));
		if (!isValid) {
	// $("#lblError").html("Only Alphabets and Numbers allowed.");
		$(".fusion_id_exist").text("Only Alphabets and Numbers allowed");
		$(".disable_btn").attr("disabled",true);  
		return false;
		
		}
		else
		{ 
		$(".fusion_id_exist").text("");
// return isValid;
		$(".fusion_id_exist").text("");
		srch = $(this).val();
		if(srch.length>5){
			$(".disable_btn").attr("disabled",true);
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url(); ?>legal_manual/validate_existest_accessid',
			data: {
						fusion_id: srch						
					},
			success: function (response) {
				response = response.trim();
				if (response == "OK") {
					$(".fusion_id_exist").text("");
					$(".disable_btn").attr("disabled",false);

				}
				else if(response == "error"){
					$(".fusion_id_exist").text("You are given wrong Character");
					$(".disable_btn").attr("disabled",true);
				}
				else if(response == "error1"){
					$(".fusion_id_exist").text("Atleast one character and one numeric value mandatory");
					$(".disable_btn").attr("disabled",true);
				}
				
				else {
					$(".fusion_id_exist").text(response);
					$(".disable_btn").attr("disabled",true);
				}
			}
		});
		}
		else
		{
		$(".fusion_id_exist").text("You enter wrong Character");
		$(".disable_btn").attr("disabled",true);
		}




		}
		});


		$(document).on("keyup",".fusion_id_exists_for_tl",function(e){



			var keyCode = e.keyCode || e.which;
 			$(".fusion_id_validation").text("");
            var regex = /^[A-Za-z0-9]+$/;
		    var isValid = regex.test(String.fromCharCode(keyCode));
            if (!isValid) {
                // $("#lblError").html("Only Alphabets and Numbers allowed.");
				$(".fusion_id_validation").text("Only Alphabets and Numbers allowed");
				$(".disable_btn").attr("disabled",true);
				 $(".submit_btn").removeClass("active_btn");
				return false;
				
            }
			else{ 
				$(".fusion_id_validation").text("");
            // return isValid;
			$(".fusion_id_exist").text("");
			srch = $(this).val();
			if(srch.length>5){
				$(".disable_btn").attr("disabled",true);
				 $(".submit_btn").removeClass("active_btn");
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>legal_manual/validate_existest_accessid_for_tl',
				data: {
							fusion_id: srch						
						},
                success: function (response) {
                    response = response.trim();
                    if (response == "OK") {
                        $(".fusion_id_exist").text("");
						$(".disable_btn").attr("disabled",false);
						$(".submit_btn").addClass("active_btn");

                    }
					else if(response == "error"){
						$(".fusion_id_exist").text("You are given wrong Character");
						$(".disable_btn").attr("disabled",true);
						$(".submit_btn").removeClass("active_btn");
					}
					else if(response == "error1"){
					$(".fusion_id_exist").text("Atleast one character and one numeric value mandatory");
					$(".disable_btn").attr("disabled",true);
				}
					
					else {
                        $(".fusion_id_exist").text(response);
						$(".disable_btn").attr("disabled",true);
						$(".submit_btn").removeClass("active_btn");
                    }
                }
            });
		}
		else{
			$(".fusion_id_exist").text("You enter wrong Character");
			$(".disable_btn").attr("disabled",true);
			$(".disable_btn").removeClass("active_btn");
		}




			}
		});
		function DownloadFile(e) {

            

           //var url = "<?php echo base_url(); ?>uploads/batch_attendance/sample/" + fileName;

//            var url = e.getAttribute('data-url');
           var url = e;

           

            var fileName = url.match(/([^\/]*)\/*$/)[1];

            $.ajax({

                url: url,

                cache: false,

                xhr: function () {

                    var xhr = new XMLHttpRequest();

                    xhr.onreadystatechange = function () {

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

                success: function (data) {

                   

                    var blob = new Blob([data], { type: "application/octetstream" });

 

                    

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

	$(".back_btn").click(function(e) {
		e.preventDefault();
		$(".main-content").toggleClass("toggled");
		$(".sidebar_menu").toggleClass("toggled");
	});

	modal_button_close = () => {

		$("#modalForwardEmail").modal("hide");
		$('#modalForwardEmail').data("modal", null);
	}
	note_submission = () => {
		$('#modalnoteEmail').modal('show');
	}
	modal_note_button_close = (val) => {
		// alert(val);
		if(val=='access_add'){
			$("#access_add_section").modal("hide");
			$('#access_add_section').data("modal", null);
		}
		else if(val=='note'){
			$("#modalnoteEmail").modal("hide");
			$('#modalnoteEmail').data("modal", null);
		}
		else if(val=='approval'){
			$("#modalapproval").modal("hide");
			$('#modalapproval').data("modal", null);
		}
		else if(val=='approve_reject'){
			$("#modalapprovereject").modal("hide");
			$('#modalapprovereject').data("modal", null);
		}
		else if(val=='access_add_tl'){
			$("#access_add_section_for_tl").modal("hide");
			$('#access_add_section_for_tl').data("modal", null);
		}
		
		else{
			$("#modalnoteEmail").modal("hide");
			$('#modalnoteEmail').data("modal", null);
		}

		
	}
	modal_reject_button_close = () =>{
		$("#modalreject").modal("hide");
		$("#modal_reject_button_close").data("modal",null);
	}
	$('#approval_accept_reject').click(function(){
		baseURL = "<?php echo base_url(); ?>";
		ticket_no = $('.reply_form input[name="ticket_no"]').val();
		subject =$(this).attr("data-subject");
		status =$(this).attr("data-status");
		accept_reject =$(this).attr("data-accept_reject");
		
		// alert(subject);
		if(status=='0' || (accept_reject==1 || accept_reject==2)){
			disabled='disabled';
			sending_status='No'; 
		}
		else{
			disabled='';
			sending_status='Yes';
		}
		if(accept_reject==1){
			$(".btn_value_accept").html("Already Accepted");
			$(".disabled_button").attr("disabled",true);
			 $(".disabled_button").css('cursor', 'no-drop');
		}
		else{
			$(".btn_value_accept").html("Accept");
			$(".disabled_button").attr("disabled",false);
			 $(".disabled_button").css('cursor', 'pointer');

		}  
		if(accept_reject==2){
			$(".btn_value_reject").html("Already Rejected");
			$(".disabled_button").attr("disabled",true);
			 $(".disabled_button").css('cursor', 'no-drop');
		}
		else{
			$(".btn_value_reject").html("Reject");
			$(".disabled_button").attr("disabled",false);
			 $(".disabled_button").css('cursor', 'pointer');

		}  
		$(".disabled_button").addClass(disabled);
		$("#t_no").html(ticket_no);
		$("#subject").html(subject);
		$("#status").html(sending_status);
		$("#modalapproval").modal('show');

	});

	$('#approval_button_required').click(function(){
		
		ticket_no = $('.reply_form input[name="ticket_no"]').val();
		subject =$(this).attr("data-subject");
		status =$(this).attr("data-status");
		accept_reject =$(this).attr("data-accept_reject");
		 
	
		$("#modalworkapproval").modal('show'); 

	});
	// $('#sent_button_required').click(function(){
		
	// 	ticket_no = $('.reply_form input[name="ticket_no"]').val();
	// 	subject =$(this).attr("data-subject");
	// 	status =$(this).attr("data-status");
	// 	accept_reject =$(this).attr("data-accept_reject");
		 
	
	// 	$("#modalsentapproval").modal('show');    

	// });
	accept_sending_approval=()=>{
		baseURL = "<?php echo base_url(); ?>";
		ticket_no = $('.reply_form input[name="ticket_no"]').val();
			$.ajax({
				url: "<?php echo base_url('legal_manual/approval_accept'); ?>",
				type: "POST",
				data: {
					ticket_no: ticket_no
				},
				dataType: "text",
				success: function(token) {

					notReply = 1;
					$('#sktPleaseWait').modal('hide');
					location.href = "<?php echo base_url()?>legal/ticket_view/" + ticket_no;
				},
				error: function(token) {
					notReply = 1;
					$('#sktPleaseWait').modal('hide');
				}
			});
		
	}

	reject_sending_approval=()=>{
		$("#modalreject").modal('show');
	}

	reject_approval_submit=()=>{
		ticket_no = $('.reply_form input[name="ticket_no"]').val();
		remarks = $('#modalreject #mytextarea_reject_remarks').val();
		// alert(ticket_no + remarks);

		if (remarks != "") {
			// $('#sktPleaseWait').modal('show');
			$.ajax({
				url: "<?php echo base_url('legal_manual/reject_approval_submit'); ?>",
				type: "POST",
				data: {
					ticket_no: ticket_no,
					remarks: remarks
				},
				dataType: "text",
				success: function(token) {

					notReply = 1;
					$('#sktPleaseWait').modal('hide');
					location.href = "<?php echo base_url()?>legal/ticket_view/" + ticket_no;
				},
				error: function(token) {
					notReply = 1;
					$('#sktPleaseWait').modal('hide');
				}
			});
		} else {
			alert('Please Fill Up the Remarks!');
		}
	}
	work_approval_submit=()=>{
	    ticket_no = $('.reply_form input[name="ticket_no"]').val();
		matter_of_approval = $('#modalworkapproval #matter_of_approval').val();
		comment = $('#modalworkapproval #comment').val();
		attachments_work=$('#modalworkapproval #attachments_work').val(); // added for file 

//alert(attachments_work); // file is cating here 



		higher_authority = $('#modalworkapproval #higher_authority').val();
		email = $('#modalworkapproval #email').val();
		baseURL = "<?php echo base_url(); ?>";
		email_base_encode=btoa(email);
		// email_base_decode=btoa(email);
		link_generated='Mater Of approval is: '+matter_of_approval+' URL is: '+baseURL+'legal_approve/work_approval_by_others/'+email_base_encode;
		// alert(link_generated);
		
		
		// alert(comment+ticket_no+matter_of_approval+higher_authority);
		// alert(ticket_no + remarks);

		if (higher_authority != "") {
			// $('#sktPleaseWait').modal('show');
			$.ajax({
				url: "<?php echo base_url('legal_manual/work_approval_submit'); ?>",
				type: "POST",
				data: {
					ticket_no: ticket_no,
					matter_of_approval: link_generated,
					comment:comment,
					higher_authority:higher_authority,
					email:email,
					attachments_work:attachments_work
				},
				dataType: "text",
				success: function(token) {

					notReply = 1;
					$('#sktPleaseWait').modal('hide');
				//	alert(link_generated); //original 

//alert(attachments_work);

					 location.href = "<?php echo base_url()?>legal/ticket_view/" + ticket_no;
				},
				error: function(token) {
					notReply = 1;
					$('#sktPleaseWait').modal('hide');
				}
			});
		} else {
			alert('Please Fill Up the Higher authority!');
		}
	}

	// sent_approval_submit=()=>{
	//     ticket_no = $('.reply_form input[name="ticket_no"]').val();
	// 	matter_of_approval = $('#modalsentapproval #matter_of_approval_uploading').val();
	// 	higher_authority = $('#modalsentapproval #higher_authority_uploading').val();
	// 	email = $('#modalsentapproval #email_uploading').val();
	// 	baseURL = "<?php echo base_url(); ?>";
	// 	email_base_encode=btoa(email);
	// 	console.log(ticket_no+matter_of_approval+higher_authority+email);
	// 	// email_base_decode=btoa(email);
	// 	link_generated=' URL is: '+baseURL+'legal_approve/file_uploading_by_admin/'+email_base_encode;
	// 	//  alert(link_generated);
		
		
	// 	// alert(comment+ticket_no+matter_of_approval+higher_authority);
	// 	// alert(ticket_no + remarks);

	// 	// if (higher_authority != "") {
	// 		// $('#sktPleaseWait').modal('show');
	// 		$.ajax({
	// 			url: "<?php echo base_url('legal_manual/sent_approval_submit_by_agent'); ?>",
	// 			type: "POST",
	// 			data: {
	// 				ticket_no: ticket_no,
	// 				matter_of_approval: matter_of_approval,
	// 				link: link_generated,
	// 				higher_authority:higher_authority,
	// 				email:email
	// 			},
	// 			dataType: "text",
	// 			success: function(token) {

	// 				notReply = 1;
	// 				$('#sktPleaseWait').modal('hide');
	// 				alert(link_generated);
	// 				 location.href = "<?php echo base_url()?>legal/ticket_view/" + ticket_no;
	// 			},
	// 			error: function(token) {
	// 				notReply = 1;
	// 				$('#sktPleaseWait').modal('hide');
	// 			}
	// 		});
	// 	// } else {
	// 	// 	alert('Please Fill Up the Higher authority!');
	// 	// }
	// }















	$('#sending_for_approval').click(function(){
		let text;
			if (confirm("Sending for a approval!") == true) {
				alert('After sending for approval can not get the work approval option.');
				baseURL = "<?php echo base_url(); ?>";
				// alert(baseURL);
				ticket_no = $('.reply_form input[name="ticket_no"]').val();
					$('#sktPleaseWait').modal('show');
					$.ajax({
						url: "<?php echo base_url('legal_manual/sending_for_approval'); ?>", 
						type: "POST",
						data: {
							ticket_no: ticket_no						
						},
						dataType: "text",
						success: function(token) {

							notReply = 1;
							$('#sktPleaseWait').modal('hide');
							location.href = "<?php echo base_url()?>legal/ticket_view/" + ticket_no;
						},
						error: function(token) {
							notReply = 1;
							$('#sktPleaseWait').modal('hide');
						}
					});
				

					} else {
						alert('You pressed no');
					}
			
	});

	function mailNoteSubmission() {
		baseURL = "<?php echo base_url(); ?>";
		// alert(baseURL);
		ticket_no = $('.reply_form input[name="ticket_no"]').val();
		mailing_text = $('#modalnoteEmail #mytextarea_neww').val();
		// alert(ticket_no + mailing_text);
		if (mailing_text != "") {
			$('#sktPleaseWait').modal('show');
			$.ajax({
				url: "<?php echo base_url('legal_manual/note_reply'); ?>",
				type: "POST",
				data: {
					ticket_no: ticket_no,
					note: mailing_text
				},
				dataType: "text",
				success: function(token) {

					notReply = 1;
					$('#sktPleaseWait').modal('hide');
					location.href = "<?php echo base_url()?>legal/ticket_view/" + ticket_no;
				},
				error: function(token) {
					notReply = 1;
					$('#sktPleaseWait').modal('hide');
				}
			});
		} else {
			alert('Please Fill Up the note!');
		}
	}
    // $('.forwardSubmission').click(function(){
// 	alert(11);
// 	$('#modalForwardEmail').modal('show');
// });
<?php if(!empty($showtimer)){ ?>
// STOPWATCH TIMER
startDateTimer = new Date();
startTimer();
function startTimer(){
	var total_seconds = (new Date() - startDateTimer) / 1000;   
	var newTime = new Date(null);
	newTime.setSeconds(total_seconds);
	var result = newTime.toISOString().substr(11, 8);
	$("#timeWatch").html(result);
	$("#time_interval").val(result);
	$("#time_interval_notes").val(result);
	$("#time_interval_update").val(result);
	setTimeout(function(){startTimer()}, 1000);
}

startDateTimerNew = new Date();
startTimerNew();
function startTimerNew(){
	var total_seconds = (new Date() - startDateTimerNew) / 1000;   
	var newTime = new Date(null);
	newTime.setSeconds(total_seconds);
	var result = newTime.toISOString().substr(11, 8);
	$("#timeWatchNew").html(result);
	setTimeout(function(){startTimerNew()}, 1000);
}



function startHoldNew(startDate){
	var total_seconds = (new Date() - startDate) / 1000;   
	var newTime = new Date(null);
	newTime.setSeconds(total_seconds);
	var result = newTime.toISOString().substr(11, 8);
	$("#timer_hold").val(result);
	//$('.inHold span').html(result);	
	timerHoldStatus = $("#timer_hold_status").val();
	if(timerHoldStatus == 'H'){
		//$('.inHold').show();
		//$('.inCall, .inWait').hide();
		$("#timer_start_status").val('H');
		timeOutVar = setTimeout(function(){startHoldNew(startDate)}, 1000);
		console.log('hi');
	} else {
		clearTimeout(timeOutVar);
		$("#timer_hold").val('');
		$("#timer_hold_status").val('H');	
		console.log('byee');
	}
}
var modal_val_final='';
function startHoldEnd(){
	holded = $("#timer_hold").val();
	holdedNo = $('#hold_reason_count').val();
	 
	  let madal_val=$("#modal_hold_reason").val();
	  let old_val = $("#hold_reason").val();
	  if(old_val!=''){
	  modal_val_final =old_val + ',' + madal_val;
	  }
	  else{
		modal_val_final =old_val  + madal_val;

	  }
	//$("#timeHolder").append('Hold ' + holdedNo + ' - ' + holded + '<br/>');
	pastHold = getSeconds($('#hold_interval').val());
	currentHold = getSeconds(holded);
	var newTime = new Date(null);
	newTime.setSeconds(Number(pastHold) + Number(currentHold));
	var result = newTime.toISOString().substr(11, 8);
	$('#hold_interval').val(result);
	$('#hold_interval_notes').val(result);
	$('#hold_reason_count').val(Number(holdedNo) + 1);
	$('#hold_reason_count_notes').val(Number(holdedNo) + 1);
	$("#timer_hold_status").val('U');
	$('#modal_hold_reason').val('');
	$("#hold_reason").val(modal_val_final);
	// $("#hold_reason").append(madal_val);
}

function getSeconds(time)
{
    var ts = time.split(':');
    return Date.UTC(1970, 0, 1, ts[0], ts[1], ts[2]) / 1000;
}


function callActionButton(current){
	callType = $(current).attr('btype');
	if(callType == 'hold'){
		reasonHold = $('#modal_hold_reason').val();
		// reasonOption = $('#modal_hold_option').val();
		if(reasonHold != ""){
			startHoldNew(new Date());
			$('#holdCallModal').modal('hide');
			$('#unholdCallModal').modal('show');
		} else {
			alert('Please Enter the Reason!');
		}
	}
	if(callType == 'unhold'){ 
		startHoldEnd(); 
		$('#unholdCallModal').modal('hide');
		$('#holdCallModal').modal('hide');
	}
}

<?php } ?>
function forward_submission(){
		// alert('ggg');
		$('#mytextarea_neww').summernote();
		$('#modalForwardEmail').modal('show');
	}
function mailForwardSubmission(){
	// alert('button hit');
	baseURL = "<?php echo base_url(); ?>";
	ticket_no = $('.reply_form input[name="ticket_no"]').val();
	forward_to = $('#modalForwardEmail input[name="forward_email_id"]').val();
	mailing_cc = $('#modalForwardEmail input[name="mailing_cc"]').val();
    mailing_text = $('#modalForwardEmail #mytextarea_neww').val();
	mailing_to = $('.reply_form input[name="mailing_to"]').val();
	mailing_subject=  $('#mailing_subject').val();   
	mailing_body=  $('#moreInfoEditor2').val(); 	
	if (typeof(forward_to) === "undefined") {
		forward_to=$('#forward_email_id option:selected').val();

	}
	
	if(forward_to != ""){
		$('#sktPleaseWait').modal('show');
		$.ajax({
			url: "<?php echo base_url('legal_manual/ticket_forward_reply'); ?>",
			type: "POST",
			data: { ticket_no : ticket_no, mailing_to : mailing_to, mailing_cc : mailing_cc, mailing_subject : mailing_subject, forward_to : forward_to,message_body_trail:mailing_body,mailing_text:mailing_text
			},
			dataType: "text",
			success : function(token){
				notReply = 1;
				$('#sktPleaseWait').modal('hide');
				alert('Mail forward successfully done');
				location.href = "<?php echo base_url()?>legal/ticket_view/" + ticket_no;

			},
			error : function(token){ 
				notReply = 1;
				$('#sktPleaseWait').modal('hide');
			}
		});
	} else {
		alert('Please Fill Up All Details!');
	}
}

function date_validation(val,type){ 
	// alert(val);
		$(".end_date_error").html("");
		$(".start_date_error").html("");
		if(type=='E'){
		var start_date=$(".start_date").val();
		if(val<start_date){
			$(".end_date_error").html("End Date must be greater or equal to Start Date");
			 $(".download_report").attr("disabled",true);
			 $(".download_report").css('cursor', 'no-drop');
		}
		else{
			 $(".download_report").attr("disabled",false);
			 $(".download_report").css('cursor', 'pointer');
			}
		}
		else{
			var end_date=$(".end_date").val();
		if(val>end_date && end_date!=''){
			$(".start_date_error").html("Start Date  must be less or equal to  End Date");
			 $(".download_report").attr("disabled",true);
			 $(".download_report").css('cursor', 'no-drop');
		}
		else{
			 $(".download_report").attr("disabled",false);
			 $(".download_report").css('cursor', 'pointer');
			}

		}
		
		
	}




</script>

<script type="text/javascript">
	
function forward_email_id() {
    var forward_email_id=$("#forward_email_id").val();
	//var pattern =  /^([_\-\.0-9a-zA-Z]+)@([_\-\.0-9a-zA-Z]+)\.([a-zA-Z]){2,7}$/;
	var pattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	//var matches = subject.match('/[^a-zA-Z0-9]/');
	//alert(matches);
	if(forward_email_id.length == ""){
		
		$("#msg-forward_email_id").html("<font color=red style='font-size:14px;'> Please Enter some Email ID Text  </font>");
		$("#mailforwardsubmission").attr("disabled",true);
		$("#mailforwardsubmission").css('cursor', 'no-drop');
	}else if(!pattern.test(forward_email_id)){
		
		$("#msg-forward_email_id").html("<font color=red style='font-size:14px;'>This Email ID  is not valid </font>");
		 $("#mailforwardsubmission").attr("disabled",true);
		 $("#mailforwardsubmission").css('cursor', 'no-drop');
		//validatesubject();
	}else{
		$("#msg-forward_email_id").html("");
		$("#mailforwardsubmission").attr("disabled",false);
		$("#mailforwardsubmission").css('cursor', 'pointer');
		//validatesubject();
	}
}

// mailing_cc_for_forward_mail


function mailing_cc_for_forward_mail() {
    var mailing_cc_for_forward_mail=$("#mailing_cc_for_forward_mail").val();
	//var pattern =  /^([_\-\.0-9a-zA-Z]+)@([_\-\.0-9a-zA-Z]+)\.([a-zA-Z]){2,7}$/;

	var pattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	//var matches = subject.match('/[^a-zA-Z0-9]/');
	//alert(matches);
	if(mailing_cc_for_forward_mail.length == ""){
		
		$("#msg-mailing_cc_for_forward_mail").html("<font color=red style='font-size:14px;'> Please Enter some CC Email ID   </font>");
		$("#mailforwardsubmission").attr("disabled",true);
		$("#mailforwardsubmission").css('cursor', 'no-drop');
	}else if(!pattern.test(mailing_cc_for_forward_mail)){
		
		$("#msg-mailing_cc_for_forward_mail").html("<font color=red style='font-size:14px;'>This CC Email Id is not valid </font>");
		 $("#mailforwardsubmission").attr("disabled",true);
		 $("#mailforwardsubmission").css('cursor', 'no-drop');
		//validatesubject();
	}else{
		$("#msg-mailing_cc_for_forward_mail").html("");
		$("#mailforwardsubmission").attr("disabled",false);
		$("#mailforwardsubmission").css('cursor', 'pointer');
		//validatesubject();
	}
}


function validatemailing_subject(mailing_subject) {
    var mailing_subject=$("#mailing_subject").val();
	//var pattern = /^[A-Za-z0-9]+$/;
	//var matches = subject.match('/[^a-zA-Z0-9]/');
	//alert(matches);
	var pattern =/\w+|\.\s|[!"#€%&/()=?`´^¨*'-_;:.,]/g; // search 
	if(mailing_subject.length == ""){
		$("#msg-mailing_subject").html("<font color=red style='font-size:14px;'> Please Enter some Text  </font>");
		$(".btn_widget").attr("disabled",true);
		$(".btn_widget").css('cursor', 'no-drop');
	}else if(!pattern.test(mailing_subject)){
		//var pattern ='/^[a-z\d\-_\s]+$/i';
		$("#msg-mailing_subject").html("<font color=red style='font-size:14px;'>This subject is not valid </font>");
		$(".btn_widget").attr("disabled",true);
		$(".btn_widget").css('cursor', 'no-drop');
	}else{
		$("#msg-mailing_subject").html("");
		$(".btn_widget").attr("disabled",false);
		$(".btn_widget").css('cursor', 'pointer');
	}
}





function mytextarea_neww(mytextarea_neww) {
	
    var mytextarea_neww=$("#mytextarea_neww").val();
	//var pattern = /^[A-Za-z0-9]+$/;
	//var matches = subject.match('/[^a-zA-Z0-9]/');
	//alert(mytextarea_newws);
	var pattern =/\w+|\.\s|[!"#€%&/()=?`´^¨*'-_;:.,]/g; // search 
	if(mytextarea_neww.length == ""){
		$("#msg-mytextarea_neww").html("<font color=red style='font-size:14px;'> Please Enter some Text  </font>");
		$("#mailNoteSubmission").attr("disabled",true);
		$("#mailNoteSubmission").css('cursor', 'no-drop');
	}else if(!pattern.test(mytextarea_neww)){
		//var pattern ='/^[a-z\d\-_\s]+$/i';
		$("#msg-mytextarea_neww").html("<font color=red style='font-size:14px;'>This subject is not valid </font>");
		$("#mailNoteSubmission").attr("disabled",true);
		$("#mailNoteSubmission").css('cursor', 'no-drop');
	}else{
		$("#msg-mytextarea_neww").html("");
		$("#mailNoteSubmission").attr("disabled",false);
		$("#mailNoteSubmission").css('cursor', 'pointer');
	}
}

</script>










<!--- ending of matter_of_approval--->
<!-- following cod eis working for email validation ---->




<script type="text/javascript">





////////////////////////////////////19/10/2022

function matter_of_approvalFunction(matter_of_approval){
	
	var matter_of_approval=$("#matter_of_approval").val();
	//var pattern = /^[A-Za-z0-9]+$/;
	//var matches = subject.match('/[^a-zA-Z0-9]/');
	//alert(mytextarea_newws);
	var pattern =/\w+|\.\s|[!"#€%&/()=?`´^¨*'-_;:.,]/g; // search 
	if(matter_of_approval.length <10){
	$("#msg-matter_of_approval").html("<font color=red style='font-size:14px;'> Please enter at least 10 characters inside the matter of approval. </font>");
	 $("#work_approval_section").attr("disabled",true);
	 $("#work_approval_section").css('cursor', 'no-drop');
	matter_of_approvalError=1;
	}else if(!pattern.test(matter_of_approval)){
	//var pattern ='/^[a-z\d\-_\s]+$/i';
	$("#msg-matter_of_approval").html("<font color=red style='font-size:14px;'>This matter of approval is not valid </font>");
	 $("#work_approval_section").attr("disabled",true);
	 $("#work_approval_section").css('cursor', 'no-drop');
	matter_of_approvalError=1;
	}else{
	$("#msg-matter_of_approval").html("");
	 $("#work_approval_section").attr("disabled",false);
	 $("#work_approval_section").css('cursor', 'pointer');
	//commentFunction();
	matter_of_approvalError=0;
	}

}







function emails(email) {
	//alert(2);
    var email=$("#email").val();
	$("#msg-email").html("");
	
	//var pattern =  /^([_\-\.0-9a-zA-Z]+)@([_\-\.0-9a-zA-Z]+)\.([a-zA-Z]){2,7}$/;
	var pattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	//var matches = subject.match('/[^a-zA-Z0-9]/');
	//alert(matches);
	if(email.length == ""){
		
		$("#msg-email").html("<font color=red style='font-size:14px;'> Please Enter an Email ID   </font>");
		$("#work_approval_section").attr("disabled",true);
		$("#work_approval_section").css('cursor', 'no-drop');
		return true;	

	}
	else if(!pattern.test(email)){
		
		$("#msg-email").html("<font color=red style='font-size:14px;'> This Email ID is not valid. </font>");
		$("#work_approval_section").attr("disabled",true);
		$("#work_approval_section").css('cursor', 'no-drop');
		return true;	
		
	}
	else{
		$("#msg-email").html("");
		 $("#work_approval_section").attr("disabled",false);
		 $("#work_approval_section").css('cursor', 'pointer');
		//matter_of_approvalFunction();
		return false;	
	}

}

function emails_keyup(email) {
	$("#msg-email").html("");
	
}
function commentFunction_keyup(email) {

    
	$("#msg-comment").html("");
	
}
function matter_of_approvalFunction_keyup(email) {

  
	$("#msg-matter_of_approval").html("");
	
}



  function commentFunction(comment){
	var comment=$("#comment").val();
	//var pattern = /^[A-Za-z0-9]+$/;
	//var matches = subject.match('/[^a-zA-Z0-9]/');
	//alert(mytextarea_newws);
	var pattern =/\w+|\.\s|[!"#€%&/()=?`´^¨*'-_;:.,]/g; // search 
	if(comment.length <10){
		$("#msg-comment").html("<font color=red style='font-size:14px;'>Please enter at least 10 characters inside the description. </font>");
		 $("#work_approval_section").attr("disabled",true);
		 $("#work_approval_section").css('cursor', 'no-drop');
		commentError =1;
	}else if(!pattern.test(comment)){
		//var pattern ='/^[a-z\d\-_\s]+$/i';
		$("#msg-comment").html("<font color=red style='font-size:14px;'>This description  is not valid </font>");
		 $("#work_approval_section").attr("disabled",true);
		 $("#work_approval_section").css('cursor', 'no-drop');
		commentError =1;
	}else{
		$("#msg-comment").html("");
		$("#work_approval_section").attr("disabled",false);
		$("#work_approval_section").css('cursor', 'pointer');
	commentError =0;
	}
  }





  $("#work_approval_section").click(function () {
    emails();
    matter_of_approvalFunction();
    commentFunction();
    
    if (
		commentError =='1'  &&
      matter_of_approvalError == '1' &&
      
      emailError == '1'
    ) {
      return false;
	  //	$("#work_approval_section").attr("disabled",true);
		//$("#work_approval_section").css('cursor', 'no-drop');

    } else {
      return true;
	  //	$("#work_approval_section").attr("disabled",false);
	//$("#work_approval_section").css('cursor', 'pointer');
    }
  });


















/////////////////////19/10/2022





















</script>

<script type="text/javascript">
		
		// window.setTimeout("document.getElementById('errorMessages').style.display='none';", 9000);
		// window.setTimeout("document.getElementById('errorMessage').style.display='none';", 9000);
	</script>


 