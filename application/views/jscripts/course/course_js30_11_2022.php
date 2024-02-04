
    <!-- Include all compiled plugins (below), or include individual files as needed -->

    <script src="<?php echo base_url(); ?>assets/js/jasny-bootstrap.min.js"></script>    
    <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>    

<script>
var URL = '<?php echo base_url(); ?>';
 
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	})


/* 
$(window).load(function(){
            // Bind normal buttons
			Ladda.bind( 'div:not(.progress-demo) button', { timeout: 1500 } );

			// Bind progress buttons and simulate loading progress
			Ladda.bind( '.progress-demo button', {
				callback: function( instance ) {
					var progress = 0;
					var interval = setInterval( function() {
						progress = Math.min( progress + Math.random() * 0.1, 1 );
						instance.setProgress( progress );

						if( progress === 1 ) {
							instance.stop();
							clearInterval( interval );
						}
					}, 200 );
				}
			} ); 

			// You can control loading explicitly using the JavaScript API
			// as outlined below:

			// var l = Ladda.create( document.querySelector( 'button' ) );
			// l.start();
			// l.stop();
			// l.toggle();
			// l.isLoading();
			// l.setProgress( 0-1 );
});

(function(t,e){"object"==typeof exports?module.exports=e():"function"==typeof define&&define.amd?define(e):t.Spinner=e()})(this,function(){"use strict";function t(t,e){var i,n=document.createElement(t||"div");for(i in e)n[i]=e[i];return n}function e(t){for(var e=1,i=arguments.length;i>e;e++)t.appendChild(arguments[e]);return t}function i(t,e,i,n){var o=["opacity",e,~~(100*t),i,n].join("-"),r=.01+100*(i/n),a=Math.max(1-(1-t)/e*(100-r),t),s=u.substring(0,u.indexOf("Animation")).toLowerCase(),l=s&&"-"+s+"-"||"";return f[o]||(c.insertRule("@"+l+"keyframes "+o+"{"+"0%{opacity:"+a+"}"+r+"%{opacity:"+t+"}"+(r+.01)+"%{opacity:1}"+(r+e)%100+"%{opacity:"+t+"}"+"100%{opacity:"+a+"}"+"}",c.cssRules.length),f[o]=1),o}function n(t,e){var i,n,o=t.style;if(void 0!==o[e])return e;for(e=e.charAt(0).toUpperCase()+e.slice(1),n=0;d.length>n;n++)if(i=d[n]+e,void 0!==o[i])return i}function o(t,e){for(var i in e)t.style[n(t,i)||i]=e[i];return t}function r(t){for(var e=1;arguments.length>e;e++){var i=arguments[e];for(var n in i)void 0===t[n]&&(t[n]=i[n])}return t}function a(t){for(var e={x:t.offsetLeft,y:t.offsetTop};t=t.offsetParent;)e.x+=t.offsetLeft,e.y+=t.offsetTop;return e}function s(t){return this===void 0?new s(t):(this.opts=r(t||{},s.defaults,p),void 0)}function l(){function i(e,i){return t("<"+e+' xmlns="urn:schemas-microsoft.com:vml" class="spin-vml">',i)}c.addRule(".spin-vml","behavior:url(#default#VML)"),s.prototype.lines=function(t,n){function r(){return o(i("group",{coordsize:u+" "+u,coordorigin:-l+" "+-l}),{width:u,height:u})}function a(t,a,s){e(f,e(o(r(),{rotation:360/n.lines*t+"deg",left:~~a}),e(o(i("roundrect",{arcsize:n.corners}),{width:l,height:n.width,left:n.radius,top:-n.width>>1,filter:s}),i("fill",{color:n.color,opacity:n.opacity}),i("stroke",{opacity:0}))))}var s,l=n.length+n.width,u=2*l,d=2*-(n.width+n.length)+"px",f=o(r(),{position:"absolute",top:d,left:d});if(n.shadow)for(s=1;n.lines>=s;s++)a(s,-2,"progid:DXImageTransform.Microsoft.Blur(pixelradius=2,makeshadow=1,shadowopacity=.3)");for(s=1;n.lines>=s;s++)a(s);return e(t,f)},s.prototype.opacity=function(t,e,i,n){var o=t.firstChild;n=n.shadow&&n.lines||0,o&&o.childNodes.length>e+n&&(o=o.childNodes[e+n],o=o&&o.firstChild,o=o&&o.firstChild,o&&(o.opacity=i))}}var u,d=["webkit","Moz","ms","O"],f={},c=function(){var i=t("style",{type:"text/css"});return e(document.getElementsByTagName("head")[0],i),i.sheet||i.styleSheet}(),p={lines:12,length:7,width:5,radius:10,rotate:0,corners:1,color:"#000",direction:1,speed:1,trail:100,opacity:.25,fps:20,zIndex:2e9,className:"spinner",top:"auto",left:"auto",position:"relative"};s.defaults={},r(s.prototype,{spin:function(e){this.stop();var i,n,r=this,s=r.opts,l=r.el=o(t(0,{className:s.className}),{position:s.position,width:0,zIndex:s.zIndex}),d=s.radius+s.length+s.width;if(e&&(e.insertBefore(l,e.firstChild||null),n=a(e),i=a(l),o(l,{left:("auto"==s.left?n.x-i.x+(e.offsetWidth>>1):parseInt(s.left,10)+d)+"px",top:("auto"==s.top?n.y-i.y+(e.offsetHeight>>1):parseInt(s.top,10)+d)+"px"})),l.setAttribute("role","progressbar"),r.lines(l,r.opts),!u){var f,c=0,p=(s.lines-1)*(1-s.direction)/2,h=s.fps,m=h/s.speed,g=(1-s.opacity)/(m*s.trail/100),v=m/s.lines;(function y(){c++;for(var t=0;s.lines>t;t++)f=Math.max(1-(c+(s.lines-t)*v)%m*g,s.opacity),r.opacity(l,t*s.direction+p,f,s);r.timeout=r.el&&setTimeout(y,~~(1e3/h))})()}return r},stop:function(){var t=this.el;return t&&(clearTimeout(this.timeout),t.parentNode&&t.parentNode.removeChild(t),this.el=void 0),this},lines:function(n,r){function a(e,i){return o(t(),{position:"absolute",width:r.length+r.width+"px",height:r.width+"px",background:e,boxShadow:i,transformOrigin:"left",transform:"rotate("+~~(360/r.lines*l+r.rotate)+"deg) translate("+r.radius+"px"+",0)",borderRadius:(r.corners*r.width>>1)+"px"})}for(var s,l=0,d=(r.lines-1)*(1-r.direction)/2;r.lines>l;l++)s=o(t(),{position:"absolute",top:1+~(r.width/2)+"px",transform:r.hwaccel?"translate3d(0,0,0)":"",opacity:r.opacity,animation:u&&i(r.opacity,r.trail,d+l*r.direction,r.lines)+" "+1/r.speed+"s linear infinite"}),r.shadow&&e(s,o(a("#000","0 0 4px #000"),{top:"2px"})),e(n,e(s,a(r.color,"0 0 1px rgba(0,0,0,.1)")));return n},opacity:function(t,e,i){t.childNodes.length>e&&(t.childNodes[e].style.opacity=i)}});var h=o(t("group"),{behavior:"url(#default#VML)"});return!n(h,"transform")&&h.adj?l():u=n(h,"animation"),s});

(function(t,e){"object"==typeof exports?module.exports=e():"function"==typeof define&&define.amd?define(["spin"],e):t.Ladda=e(t.Spinner)})(this,function(t){"use strict";function e(t){if(t===void 0)return console.warn("Ladda button target must be defined."),void 0;t.querySelector(".ladda-label")||(t.innerHTML='<span class="ladda-label">'+t.innerHTML+"</span>");var e=i(t),n=document.createElement("span");n.className="ladda-spinner",t.appendChild(n);var r,a={start:function(){return t.setAttribute("disabled",""),t.setAttribute("data-loading",""),clearTimeout(r),e.spin(n),this.setProgress(0),this},startAfter:function(t){return clearTimeout(r),r=setTimeout(function(){a.start()},t),this},stop:function(){return t.removeAttribute("disabled"),t.removeAttribute("data-loading"),clearTimeout(r),r=setTimeout(function(){e.stop()},1e3),this},toggle:function(){return this.isLoading()?this.stop():this.start(),this},setProgress:function(e){e=Math.max(Math.min(e,1),0);var n=t.querySelector(".ladda-progress");0===e&&n&&n.parentNode?n.parentNode.removeChild(n):(n||(n=document.createElement("div"),n.className="ladda-progress",t.appendChild(n)),n.style.width=(e||0)*t.offsetWidth+"px")},enable:function(){return this.stop(),this},disable:function(){return this.stop(),t.setAttribute("disabled",""),this},isLoading:function(){return t.hasAttribute("data-loading")}};return o.push(a),a}function n(t,n){n=n||{};var r=[];"string"==typeof t?r=a(document.querySelectorAll(t)):"object"==typeof t&&"string"==typeof t.nodeName&&(r=[t]);for(var i=0,o=r.length;o>i;i++)(function(){var t=r[i];if("function"==typeof t.addEventListener){var a=e(t),o=-1;t.addEventListener("click",function(){a.startAfter(1),"number"==typeof n.timeout&&(clearTimeout(o),o=setTimeout(a.stop,n.timeout)),"function"==typeof n.callback&&n.callback.apply(null,[a])},!1)}})()}function r(){for(var t=0,e=o.length;e>t;t++)o[t].stop()}function i(e){var n,r=e.offsetHeight;r>32&&(r*=.8),e.hasAttribute("data-spinner-size")&&(r=parseInt(e.getAttribute("data-spinner-size"),10)),e.hasAttribute("data-spinner-color")&&(n=e.getAttribute("data-spinner-color"));var i=12,a=.2*r,o=.6*a,s=7>a?2:3;return new t({color:n||"#fff",lines:i,radius:a,length:o,width:s,zIndex:"auto",top:"auto",left:"auto",className:""})}function a(t){for(var e=[],n=0;t.length>n;n++)e.push(t[n]);return e}var o=[];return{bind:n,create:e,stopAll:r}});
*/
/// play with images

$(document).ready(function () {
	$('.imageid').hover(function() {
	  $(this).attr('class', 'fa fa-folder-open fa-5x faicon ');
	}, function() {
	  $(this).attr('class', 'fa fa-folder fa-5x faicon ');
	});
});

$(document).ready(function () {
	$('.imageid2').hover(function() {
	  $(this).attr('class', 'fa fa-folder-open fa-4x faicon ');
	}, function() {
	  $(this).attr('class', 'fa fa-folder fa-4x faicon ');
	});
});

$(document).ready(function () {
	$('.imageid1').hover(function() {
	  $(this).attr('class', 'fa fa-folder-open fa-1x faicon ');
	}, function() {
	  $(this).attr('class', 'fa fa-folder fa-1x faicon ');
	});
});
 

 $(function () {
	var inputFile = $('input#file');
	var uploadURI = $('#form-upload').attr('action');
	var progressBar = $('#progress-bar');
	
	
	//listFilesOnServer(); 

	$('#upload-btn').on('click', function(event) {
		var idcourse = $('#idcourse').val();
		var id_categ = $('#id_categ').val();
		var id_coursetitle = $('#course_title').val();
		//alert(id_coursetitle);
	
		var filesToUpload = inputFile[0].files;
		// make sure there is file(s) to upload
		if (filesToUpload.length > 0) {
			// provide the form data
			// that would be sent to sever through ajax
			var formData = new FormData();
 
			var errorCatch =0;
			var extension;
			var K;
			
			for (var j = 0; j < filesToUpload.length; j++) {
					var file = filesToUpload[j].name;
					extension = file.split('.'); 
					if((extension[1] == 'pdf' || extension[1] == 'docx' || extension[1] == 'pptx') && (j >= 1) ){
						 
							errorCatch = 1; 
						
					} 
			}
			
			if(errorCatch !== 1){
				for (var i = 0; i < filesToUpload.length; i++) {
					var file = filesToUpload[i];

					formData.append("file[]", file, file.name);				
				}
				
				
			
					formData.append("id_categ", id_categ);	
					formData.append("text", idcourse);
					formData.append("course_title", id_coursetitle);
					
					
			// now upload the file using $.ajax
			$.ajax({
				url: uploadURI,
				type: 'post',
				data: formData,
				processData: false,
				contentType: false,
				success: function() {
					listFilesOnServer();
				},
				xhr: function() {
					var xhr = new XMLHttpRequest();
					xhr.upload.addEventListener("progress", function(event) {
						if (event.lengthComputable) {
							var percentComplete = Math.round( (event.loaded / event.total) * 100 );
							// console.log(percentComplete);
							
							$('.progress').show();
							progressBar.css({width: percentComplete + "%"});
							progressBar.text(percentComplete + '%');
						};
					}, false);

					return xhr;
				}
			});
			}else{
				alert("Only One file is allowed to upload of this type.")
			}
		}
	});

	$('body').on('click', '.remove-file', function () {
		var me = $(this);

		$.ajax({
			url: uploadURI,
			type: 'post',
			data: {file_to_remove: me.attr('data-file')},
			success: function() {
				me.closest('li').remove();
			}
		});

	})

	function listFilesOnServer () {
		var items = [];
		var idcourse = $('#idcourse').val(); 
		var id_categ = $('#id_categ').val();
	    
		var URL = '<?php echo base_url(); ?>';
		alert("File Uploaded Sucessfully");
		/* $.ajax({
			url: URL+'course/listFiles',
			type: 'get',
			data: 'text='+idcourse,
			success: function(data) {
				
				alert(data);
				 var option_data = JSON.parse(data);
					
				$.each(option_data, function(index, element) {
					items.push('<li class="list-group-item">' + option_data[index].file_name  + '<div class="pull-right"><a href="#" data-file="' + option_data[index].file_id + '" class="remove-file"><i class="glyphicon glyphicon-remove"></i></a></div></li>');
				});
				$('.list-group').html("").html(items.join(""));
			} 
		}); */
	}

	$('body').on('change.bs.fileinput', function(e) {
		$('.progress').hide();
		progressBar.text("0%");
		progressBar.css({width: "0%"});
	});
});
 

  
</script>
		
		
		
		
		
		
<script>


	$(document).ready(function(){
		
		$('#save_category').on("click",function(e){
			
			var course_name  = $('#inputcategories option:selected').val(); 
			var description  = $('#inputdescription option:selected').val(); 
			
			if(course_name === '' && description === ''){
				e.preventDefault();
				alert("Please enter course name & Description.");
			}
		});
		
		
		$('#assign_category').on("click",function(e){
			
			var course_categories  = $('#course_categories').val();
			var user_list  = 		$('#user_list').val();
			
			if(course_categories === '' && user_list === ''){
				e.preventDefault();
				alert("Please select & assign from the Dropdown List.");
			}
		});
		
		
		
		$(document).on("change",'#course_categories',function(){
			
			var a = $('#course_categories option:selected').val();
			//alert(a);
			$('#table_body').empty();
			$("#user_list").empty();
			
			$.ajax({
				url: URL +'course/reload_cordinators', 
				type: 'GET',
				data: 'cat='+a,
					success	: function (data, status)
					{
						 var option_data = JSON.parse(data);
						 
						 if(option_data['error'] === undefined){
								var optiondata = $("#user_list");
								 $.each(option_data,function(i,j){
									optiondata.append($("<option/>").val(option_data[i].id).text(option_data[i].name + ' || '+ option_data[i].fusion_id));
								});
						 }else{ 
								var optiondata = $("#user_list");
								optiondata.append($("<option/>").val('').text("--Select--"));
									
						 }
						
					},
					error: function (error) {
						 alert('error' + (error));
					}
				});
			
			
			
			
			
			
			$.ajax({
				url: URL +'course/show_assigned_list', 
				type: 'GET',
				data: 'cat='+a,
					success	: function (data, status)
					{
						
						 var returnedData = JSON.parse(data);
						 if(returnedData['error'] === undefined){  
							 $.each(returnedData,function(i,j){
								// console.log(returnedData[i].cname);
									var row = $('<tr>');
										row.append($('<td id=' + returnedData[i].id + '>').html((i+1)));
										row.append($('<td>').html(returnedData[i].fusionid));
										row.append($('<td>').html(returnedData[i].cname));
										row.append($('<td><button type=button id=delete_' + returnedData[i].id + ' class="btn btn-success delete_user" value='+ returnedData[i].id +'><span class="fa fa-trash"/></button>'));
										$('</tr>');
										
										$('#table_body').append(row);
							});
						 }
					},
					error: function (error) {
						 alert('error' + (error));
					}
				});
		});
		
		
		
		$('#add_categories').on('click',function(){
			$('#cate_id').val("");
		}); 
		
		$('.edit_categories').on('click',function(){
			var cat_id  = $(this).val();
			$('#cate_id').val(cat_id);
			
			$.ajax({
				url: URL +'course/get_categories', 
				type: 'POST',
				data: 'id='+ cat_id,
					success	: function (data, status)
					{
						  var returnedData = JSON.parse(data);
						  
						  $('#inputcategories').val(returnedData[0].categories_name);
						  $('#inputdescription').val(returnedData[0].course_description);
						  $("#inputstatus").val(returnedData[0].course_status).change();
						  
					},
					error: function (error) {
						 alert('error' + (error));
					}
				});
			
		});
		
		
		
	});
	
	
	
	
    $(document).ready(function(){
		$(document).on("click",'.delete_user',function(){
			var abc = $(this).val(); 
			
			if(confirm("Are you sure you want to delete this?")){

				$.ajax({
					url: URL +'course/delete_cordinator', 
					type: 'GET',
					data: 'id='+abc,
						success	: function (data, status)
						{
							  var returnedData = JSON.parse(data);
							  
							  alert(returnedData['msg']);
							  window.location.reload(true);
						},
						error: function (error) {
							 alert('error' + (error));
						}
					});
					 
			}else{
				return false;
			}	
			
		});
	});
	
	
	$(document).ready(function(){
		$(document).on("click",'.trash_course',function(){
			var abc = $(this).val(); 
			var categ = $(this).attr('data-trashid');
			
			if(confirm("Are you sure you want to delete this?")){
				 
				$.ajax({
					url: URL +'course/delete_course', 
					type: 'POST',
					data: 'course_id='+abc+'&category_id='+categ,
						success	: function (data, status)
						{
							var returnedData = JSON.parse(data);
							  
							  alert(returnedData['msg']);
							  window.location.reload(true);
						},
						error: function (error) {
							 alert('error' + (error));
						}
					});
					
			}else{
				return false;
			}		
			
		});
		
		// DELETE COURSE CATEGORIES
		
		$(document).on("click",'.trash_categories',function(){
			var abc = $(this).val(); 
			 if(confirm("Are you sure you want to delete this?")){
				 
			 	$.ajax({
					url: URL +'course/delete_categories', 
					type: 'POST',
					data: 'categories_id='+abc,
						success	: function (data, status)
						{
							var returnedData = JSON.parse(data);
							  
							  alert(returnedData['msg']);
							  window.location.reload(true);
						},
						error: function (error) {
							 alert('error' + (error));
						}
					}); 
					
			}else{
				return false;
			} 		
			
		});
		
		
	});
	
	
	$(document).ready(function(){
		$(document).on("click",'.edit_course',function(){
			$('.spinner').css({'display':'block'});
			
			var course_id = $(this).val(); 
			var category_id = $(this).attr('data-category_id');
			$('#cid').val(course_id);
			$('#catid').val(category_id);
			
			$.ajax({
				url: URL +'course/edit_course', 
				type: 'POST',
				data: 'course_id='+course_id+'&category_id='+category_id,
					success	: function (data, status)
					{
						var returnedData = JSON.parse(data);

						$('#course_name').val(returnedData[0].course_name);
						$('#description').val(returnedData[0].course_desc);
						$("#global_field").val(returnedData[0].is_global).change();
						$("#is_active").val(returnedData[0].is_active).change();
						$('.spinner').css({'display':'none'});
					},
					error: function (error) {
						 alert('error' + (error));
					}
				});
			
		});
	});
	
	
	/////
	
	$(document).ready(function(){
		$(document).on("click",'.examination',function(){
			//alert($(this).val());
			//alert($(this).attr('data-category_id'));
			
			$('#btnSubmit').prop("disabled",true); 
			
			var course_id = $(this).val(); 
			var category_id = $(this).attr('data-category_id');
			
			$('#course_id').val(course_id);
			$('#categories_id').val(category_id);
			
			 $.ajax({
				url: URL +'course/get_course_examination', 
				type: 'POST',
				data: 'course_id='+course_id+'&category_id='+category_id,
					success	: function (data, status)
					{
						
					    var returnedData = JSON.parse(data);
						
						$("#exam_id").val(returnedData[0].exam_id).change();  
						$('#open_date').val(returnedData[0].open_date);
						$('#close_date').val(returnedData[0].close_date);
						$('#course_description').val(returnedData[0].description);
						$('#btnSubmit').prop("disabled",false); 
						
					},
					error: function (error) {
						 alert('error' + (error));
					}
				}); 
			
		});
	});
			
</script>
		
<script>
// AGENT PART
	
	
// THIS SECTION USED TO CLEAR THE TEXT FIELD IN COURSE SECTION

	$(document).ready(function(){
		
		$('#new_course').on('click',function(){
			$('#course_name').val('');
			$('#description').val('');
		});
		
	});
	
	$(document).ready(function(){
		
		$('#save_course').on("click",function(e){
			
			var course_name  = $('#course_name').val();
			var description  = $('#description').val();
			
			if(course_name === '' && description == ''){
				e.preventDefault();
				alert("Please enter course name & Description.");
			}
		});
		
		
		$('#assign_course').on("click",function(e){
			
			var course_id  = $('#course_id').val();
			var agent_list  = $('#agent_list').val();
			
			if(course_id === '' && agent_list == ''){
				e.preventDefault();
				alert("Please select & assign from the Dropdown List.");
			}
		});
		
		
		
		
		
	$(document).ready(function(){
		$(document).on("click",'.delete_user_agent',function(){
			var abc = $(this).val(); 
			$.ajax({
				url: URL +'course/delete_agents', 
				type: 'GET',
				data: 'id='+abc,
					success	: function (data, status)
					{
						var returnedData = JSON.parse(data);
						  
						  alert(returnedData['msg']);
						  window.location.reload(true);
						  
					},
					error: function (error) {
						 alert('error' + (error));
					}
				});
			
		});
	});
		
		
	$('').on('click',function(){
		agent_viewed_file($_agentID,$_category_id,$_course_id)
		
		$.ajax({
				url: URL +'course/agent_viewed_file', 
				type: 'GET',
				data: 'id='+abc,
					success	: function (data, status)
					{
						var returnedData = JSON.parse(data);
						  
						  alert(returnedData['msg']);
						  window.location.reload(true);
						  
					},
					error: function (error) {
						 alert('error' + (error));
					}
				});
		
	});
	
	
	$('#expiry').on('change',function(){ 
		var expiry = $('#expiry :selected').val();
		
		
		
		if(expiry == 'N'){
			$('#month_period').css({'display':'none'});
			$('#months').attr('disabled');
			
			$('#prelim_period').css({'display':'none'});
			$('#prelim').attr('disabled');
			
		}else if(expiry == 'M'){
			$('#month_period').css({'display':'block'});
			$('#months').removeAttr('disabled');
			
			$('#prelim_period').css({'display':'none'});
			$('#prelim').attr('disabled');
			
		}else if(expiry == 'C'){
			$('#month_period').css({'display':'none'});
			$('#months').attr('disabled');
			
			$('#prelim_period').css({'display':'none'});
			$('#prelim').attr('disabled');
			
		}else if(expiry == 'P'){
			$('#prelim_period').css({'display':'block'});
			$('#prelim').removeAttr('disabled');
			
			$('#month_period').css({'display':'none'});
			$('#months').attr('disabled');
		}
		 
	});
 
	$('.set_rule').on('click',function(){
		var course_id = $(this).val(); 
		var category_id = $(this).attr('data-categoryid');
		
		$('#cid_rules').val(course_id);
		$('#catid_rules').val(category_id);
		
	});
		
		
		
		
	$('.course_upload').on('click',function(){
		$('#course_title').val($(this).data('uploadid'));
	});	
	
	$('.course_content').on('click',function(){	
		$('#title_id').val('');
	});	
	
	$('.course_txt').on('click',function(){
		$('#txttitle_id').val($(this).data('uploadid'));
	});	
	
	$('.title_edit').on('click',function(){
		$('#title_id').val($(this).data('titleid'));
		
		var categid  = $('#categid').val();
		var courseid = $('#coursegid').val();
		var title_id = $('#title_id').val();
		
		var passdata = 'categid='+categid+'&courseid='+courseid+'&title_id='+title_id ;
		
			$.ajax({
				url: URL +'course/edit_title', 
				type: 'POST',
				data: passdata,
					success	: function (data, status)
					{
						 var returnedData = JSON.parse(data);
						
						 if(returnedData['msg'] === undefined){
							$('#content').val(returnedData['title']);
						 }
						  
					},
					error: function (error) {
						 alert('error' + (error));
					}
			});
	});		
	
	$(document).on("click",'.title_delete',function(){
		var title_id = $(this).attr('data-titleid'); 
		
		var course_id = $('#f1').serialize();
		//alert(course_id);
		
		 if(confirm("Are you sure you want to delete this?")){
			 
			$.ajax({
				url: URL +'course/delete_title', 
				type: 'POST',
				data: course_id+'&title_id='+title_id,
					success	: function (data, status)
					{
						var returnedData = JSON.parse(data);
						  
						  alert(returnedData['msg']);
						  window.location.reload(true);
					},
					error: function (error) {
						 alert('error' + (error));
					}
				}); 
				
		}else{
			return false;
		} 		
		
	});
	
	$('.assign_exam').on('click',function(){
		$('#titleid').val($(this).data('titleid'));
		
		var categid  = $('#categid').val();
		var courseid = $('#coursegid').val();
		var title_id = $('#titleid').val();
		
		var passdata = 'categid='+categid+'&courseid='+courseid+'&title_id='+title_id ;
		
			$.ajax({
				url: URL +'course/getassigned_exam', 
				type: 'POST',
				data: passdata,
					success	: function (data, status)
					{
						 var returnedData = JSON.parse(data);
						
						 if(returnedData['msg'] === undefined){
							  $("#exam_id").val(returnedData['exam_id']).attr("selected","selected");
							  $("#course_description").val(returnedData['description']);
							  $("#passmarks").val(returnedData['pass_marks']);
							  set_create(returnedData['exam_id']);
						 }else{
							 $("#exam_id").val("").attr("selected","selected");
						 }
						  
					},
					error: function (error) {
						 alert('error' + (error));
					}
			});
	});	
	
	
	$('.check_row').on('click',function(){
			var check_box 		= $(".check_row:checked").val();
			var uid             = $('#'+check_box).attr('id');
			
			var checkbox_length = $('input[type="checkbox"]:checked').length ;
		    console.log('length'+checkbox_length);
		  
				if(checkbox_length > 1){
					
					$('.assign').attr('disabled','true');
					$('.deletesingle').attr('disabled','true');
					
				}else{
					if ($("input[type=checkbox]").is(":checked")) { 
						$('#'+check_box).removeAttr('disabled');
						$('#btn_'+check_box).removeAttr('disabled');
					}else{
						$('.assign').attr('disabled','true');
						$('.deletesingle').attr('disabled','true');
					}
				}
	});	
	
	
	
	
		
});




	
	$('.close').on("click",function(){
		window.location.reload(true);
	});
	
	$('#AssignCordinatorModal').on('hide.bs.modal', function () { 
	//	window.location.reload(true);
	});

	
	
	 


</script>



  <script src="<?php echo base_url(); ?>course_uploads/loader/percircle.js"></script>
 
  
 <script type="text/javascript">
   var textpercent=0;
var valuepercent=0;	 

     $(document).ready(function (){ 
	 
		var checkbox_length   = $('.check:input:checkbox').length;
		var selectedcheckbox  = $('.check:input:checkbox:checked').length;

		var percent = parseInt(100/checkbox_length);
		//console.log(percent);
		
		var calculate = parseInt(percent * selectedcheckbox);
		
		if(calculate === 0){
			calculate = 1;
		}
			
		
		changeCircle((calculate),(calculate));
	 
		$("#redBecomesBlue").percircle({
			text: calculate,
			percent: calculate
	});
      

      /* $('#changeCircle').click(function (e) {
        e.preventDefault();
        changeCircle();
      });*/
      
    });  
 

	
    function changeCircle(textpercent,valuepercent) {
      $("#redBecomesBlue").percircle({
        text: textpercent,
        percent: valuepercent,
        progressBarColor: "#1252c0"
      });
    }

	$(document).ready(function(){  
		$('.check').on("click",function(){
			
			var checkbox_length  = $('input:checkbox.check').length;
			var selectedcheckbox  = $('input:checkbox:checked.check').length;
			 
			var percent = parseInt(100/checkbox_length);
			//console.log(percent);
			
			var calculate = parseInt(percent * selectedcheckbox);
			
			if(calculate === 0){
				calculate = 1;
			}
			
			changeCircle((calculate),(calculate));
			
			
			var id = $(this).attr('data-id');
			var examstatus 	= $('#view_'+id).attr('data-exam');
			
			var checkbox_val = $(this).val();
			var course_id = $('#courseid').val();
			var category_id = $('#categoryid').val();
			
			 
			if ($(this).is(':checked')) {
				
				var b=1;
				var a=0;
				a = $(this).attr('data-checkboxid');
				b = (parseInt(b) + parseInt(a));
				
				if(examstatus == 0){
					$(this).attr('disabled',false); 
				}else{
					$('#material'+b).removeAttr('disabled');
				}
				
				
				$.ajax({
					url: URL +'course/check_progression', 
					type: 'POST',
					data: 'course_id='+course_id+'&category_id='+category_id+'&checkbox='+checkbox_val+'&checkstatus='+1,
						success	: function (data, status)
						{  
							$('#checklabel_'+id).css({'color':'green'});
							
						},
						error: function (error) {
							 alert('error' + (error));
						}
				});
				
				
				
			}else{
				
				
				$.ajax({
					url: URL +'course/check_progression', 
					type: 'POST',
					data: 'course_id='+course_id+'&category_id='+category_id+'&checkbox='+checkbox_val+'&checkstatus='+0,
						success	: function (data, status)
						{ 
							
							$('#checklabel_'+id).css({'color':'black'});
							
						},
						error: function (error) {
							 alert('error' + (error));
						}
				});
				
				
			}
			
		});
		
		
		
		var totalCheckboxes = $('input:checkbox').length;
		var numberNotChecked = $('input:checkbox:not(":checked")').length;
		var numberOfChecked = $('input:checkbox:checked').length;
	
		var current = totalCheckboxes - (numberNotChecked - 1);
		
		var lastchkbox = $('#material'+numberOfChecked).attr('data-id');
		
		var examstatus 	= $('#view_'+lastchkbox).attr('data-exam');
		
		if(totalCheckboxes === numberNotChecked){ 
			$('.check').attr("disabled",true);
			$('#material1').attr("disabled",false);
		}else{ 
			if(examstatus == 0){
				$('#material'+current).attr("disabled",true);
			}else{
				$('#material'+current).attr("disabled",false);
			}
		}
 
		$('.check').on('click',function(){
			var id 			= $(this).attr('data-id'); 
			
			 if ($(this).is(':checked')) {
				  $('.course_section').css({'display':'none'});
				  $('#view_'+id).css({'display':'block'});
				  $('#partition_'+id).css({'display':'block'});
			  }else{
				  $('#view_'+id).css({'display':'none'});
				  $('.course_section').css({'display':'none'});
				  $('#partition_'+id).css({'display':'block'});
			  }
			
			
		});
			
    });
	

	
  </script>
  
  <script>
  $(document).on('change','.examid',function()
	{
		$('#set_id').empty('');
		var exam_id = $(this).val(); 
		set_create(exam_id);
	});
	
	
	function set_create(exam_id){
		$.ajax({
				url: URL +'course/set_selection', 
				type: 'POST',
				data: 'examid='+ exam_id,
					success	: function (data, status)
					{  
						var returnedData = JSON.parse(data);
						 if(returnedData.stat = true){
							$('#set_id').empty('');
							
							$('#set_id').append($("<option value=''>--Select Set--</option>"));
							$.each(returnedData, function (key, data) { 
								if(key !== 'stat'){ 
								    
								   $('#set_id').append($("<option></option>")
									 .attr("value", returnedData[key]['id'])
									 .attr("data-setcount", returnedData[key]['value'])
									 .text(returnedData[key]['title'])); 
									 
									 $('#set_id').val(returnedData[key]['id']).change();  
								};
							});
							
						 }else{
							 
						 }
						 
					},
					error: function (error) {
						 alert('error' + (error));
					}
		});
	}

	var no_question;
	
	$(document).on('change','#set_id',function(){
			
		no_question =  $("#set_id option:selected").attr("data-setcount"); 
		$('#no_question').val(no_question);
		
	});
	
	$(document).on('keyup','#set_no_question',function(){
	  
	  var set_no_question = $('#set_no_question').val();
	  
	  if(parseInt(set_no_question) <= parseInt(no_question)){
		  
	  }else{
		  $('#set_no_question').val('');
	  }
	  
	});
 
  </script>
  
  
<script>
$(document).ready(function(){
  
var elem;
	$('.pdf_file').on('click',function(){
		var a = $(this).val();
		var b = 'pdf_file_'+a;
		
		elem = document.getElementById(b);
		
		  if (elem.requestFullscreen) {
			elem.requestFullscreen();
		  } else if (elem.mozRequestFullScreen) { /* Firefox */
			elem.mozRequestFullScreen();
		  } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari & Opera */
			elem.webkitRequestFullscreen();
		  } else if (elem.msRequestFullscreen) { /* IE/Edge */
			elem.msRequestFullscreen();
		  }
		
		  
	});
	  
	 
// Show More Less Description //	
	
 	var showChar = 80;
	var ellipsestext = "...";
	var moretext = "more";
	var lesstext = "less";
	$('.more').each(function() {
		var content = $(this).html();

		if(content.length > showChar) {

			var c = content.substr(0, showChar);
			var h = content.substr(showChar-1, content.length - showChar);

			var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink" title="click for full description">' + moretext + '</a></span>';

			$(this).html(html);
		}

	});

	$(".morelink").click(function(){
		if($(this).hasClass("less")) {
			$(this).removeClass("less");
			$(this).attr('title','click for full description');
			$(this).html(moretext);
		} else {
			$(this).addClass("less");
			$(this).attr('title','click to shrink');
			$(this).html(lesstext);
		}
		$(this).parent().prev().toggle();
		$(this).prev().toggle();
		return false;
	});
    
	
});
</script> 