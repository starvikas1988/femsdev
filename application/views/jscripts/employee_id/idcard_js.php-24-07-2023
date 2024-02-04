<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
<script>
<?php //if(!empty($uploaded_file)){ ?>
var croppieDemo = $('#croppie-demo').croppie({
	enableOrientation: true,
	viewport: {
		width: 250,
		height: 250,
		type: 'square' // or 'square'
	},
	boundary: {
		width: 300,
		height: 300
	}
});

$('#croppie-input').on('change', function () { 
	var reader = new FileReader();
	reader.onload = function (e) {
		croppieDemo.croppie('bind', {
			url: e.target.result
		});
	}
	reader.readAsDataURL(this.files[0]);
});

$('.croppie-upload').on('click', function (ev) {
	croppieDemo.croppie('result', {
		type: 'canvas',
		size: 'viewport'
	}).then(function (image) {
		
		var fileName = $("#croppie-input").val();
		if(fileName){
		//console.log(image);
		$('#sktPleaseWait').modal('show');
		fusionID = $('#agent_profile').val();
		$.ajax({
			url: "<?php echo base_url('employee_id/imageCropping'); ?>",
			type: "POST",
			data: {
				"image" : image,
				"fusionid" : fusionID
			},
			success: function (data) {
				//console.log(data);
				html = '<img src="' + image + '" />';
				$("#croppie-view").html(html);
				$('.generateCard').show();
				$('#sktPleaseWait').modal('hide');
			},
			error: function (data) {
				console.log('Somethign Went Wrong!');
				$('#sktPleaseWait').modal('hide');
			}
		});
		} else {
			alert('Please Select a File!');
		}
	});
});

<?php //} ?>
</script>