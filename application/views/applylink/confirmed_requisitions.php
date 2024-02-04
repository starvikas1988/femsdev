<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Call Center Careers | BPO Jobs - Fusion BPO Services</title>
<meta name="description" content="Fusion is offering exciting career opportunities with an environment that encourages, rewards and creates real performers."/>
<meta name="keywords" content=""/>

<link rel="stylesheet" type="text/css" href="https://www.fusionbposervices.com/css/style.css" media="screen" />

<link href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css' />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>

<style type="text/css">
.img-left{float:left; margin:0 10px 0 0}
.img-right{float:right; margin:0 0 0 10px}
.accordionButton {	
width: 870px; padding:10px; float: left; background: #fff url(images/bg_bl) bottom left repeat-x; border-bottom: 1px solid #FFFFFF; cursor: pointer; margin-top:10px;
-moz-border-radius: 10px; /* firefox */   -webkit-border-radius: 10px; /* chrome and safari */   -o-border-radius: 10px; /* opera */   border-radius: 10px; behavior: url(./scripts/PIE.htc); font-size:150%;
}
.accordionContent {	
width: 870px; float: left; display: none; margin-bottom:10px;
}
.accordionContent .place {
float:left; margin:15px 15px;
}
</style>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}

button
{
	background: #00f900;
	line-height: 30px;
	cursor:pointer;
	width: 100%;
}
.complete
{
	display:none;
}


</style>
<script type="text/javascript">
$(document).ready(function() {
 
	//ACCORDION BUTTON ACTION	
	$('div.accordionButton').click(function() {
		$('div.accordionContent').slideUp('normal');	
		$(this).next().slideDown('normal');
	});
 
	//HIDE THE DIVS ON PAGE LOAD	
	$("div.accordionContent").hide();
 
});
</script>

<style type="text/css">

.accordionButton {	
width: 870px; padding:10px; float: left; background:#c9e6f8 url(images/bg_bl.jpeg) top left repeat-x; border-bottom: 1px solid #FFFFFF; cursor: pointer; margin-top:10px;
-moz-border-radius: 10px; /* firefox */   -webkit-border-radius: 10px; /* chrome and safari */   -o-border-radius: 10px; /* opera */   border-radius: 10px; behavior: url(./scripts/PIE.htc); border-color:#333333; font-size:25px; font-family:'Open Sans Condensed',Arial;
}
.accordionContent {	
width: 870px; float: left; display: none; margin-bottom:10px;
}
.accordionContent h2{ font-size:25px; font-family:'Open Sans Condensed',Arial; padding-bottom:15px;}
.accordionContent h3{ padding-bottom:15px;}

.accordionContent .place {
float:left; margin:15px 15px;
}

#top-part{
	width: 1100px;
}

#top-part{
	width: 1100px;
}

.red-part{
	width: 1100px;
}

#inner-body{
	width: 1020px;
}

#footer{
	width: 1100px;
}


</style>


</head>
<body>
<!--header part ends here-->
<!--for marketing trial--> 



<div id="top-part">

	<div class="logo"><a href="https://www.fusionbposervices.com/"><img src="<?php echo base_url('main_img/logo.png'); ?>" width="138" height="89" alt="Fusion BPO Services" /></a></div>

    <!--nav part starts here-->
   <div class="frflag">Registration Form</div>
 

  <!--nav part ends here-->

  <div class="clr"></div>

</div>

<!--top part ends here-->

<!--header part ends here-->

<!--main nav part starts here-->
<div class="red-part">
    <div class="left">"A career at Fusion is fulfilling, rewarding and enjoyable" – Human Resource Department</div>
  <div class="right"></div>
    <div class="clr"></div>
</div>
<!--main nav part ends here-->
<!--inner body part starts here-->
<div id="inner-body">
    <?php
		
		
		
			// output data of each row
			echo '<table class="table table-bordered">';
				echo '<thead class="thead-light">';
					echo '<tr style=""><td colspan="4" style="border: none;"></td><td colspan="2" style="text-align:right;border: none;">Select Location::</td><td colspan="1" style="border: none;">';
						echo '<select id="location_filter" style="width: 100px;border: 1px solid #666;height: 30px;" >';
						    if($cookiename == 0){ $selectioni = "selected"; } 
							echo '<option value="" '.$selectioni.'>All</option>';
							foreach($location_list as $key=>$value)
							{
								if($value['abbr'] == $cookiename){ $selectioni = "selected"; } else { $selectioni = ""; }
								echo '<option shortname="'.$value['abbr'].'" value="'.$value['office_name'].'"' .$selectioni .'>'.$value['office_name'].'</option>';
							}
						echo '</select>';
					echo '</td><td colspan="3" style="border: none;"><input type="text" name="instant_search" id="instant_search" style="width: 100%;border: 1px solid #666;height: 30px;" placeholder="Search"></td></tr>';
					echo '<tr class="bg-info">';
						
						/* echo '<th>Due Date</th>'; */
						echo '<th>Requisition ID</th>';
						echo '<th>Due Date</th>';
						echo '<th>Location</th>';
						echo '<th>Department</th>';
						echo '<th>Client</th>';
						echo '<th>Process</th>';
						echo '<th>Position</th>';
						echo '<th width="20%">Batch No</th>';
						echo '<th width="40%">Job Description</th>';
						echo '<th style="width:10%;"></th>';
					echo '</tr>';
				echo '</thead>';
				echo '<tbody>';
				//echo '<pre>';
				//print_r($get_requisition);
				
				foreach($get_requisition as $key=>$value)
				{
					$date_array = explode('/',$value['dueDate']);
					
					//if($value['requisition_status'] == 'A' && strtotime('now') < strtotime($date_array[2].'-'.$date_array[0].'-'.$date_array[1]))
					if($value['requisition_status'] == 'A')
					{
						echo '<tr class="search_tr">';
							
							/* echo '<td>'.$value['dueDate'].'</td>'; */
							echo '<td>'.$value['requisition_id'].'</td>';
							echo '<td>'.$value['due_date'].'</td>';
							echo '<td class="office_location">'.$value['off_loc'].'</td>';
							echo '<td>'.$value['department_name'].'</td>';
							echo '<td>'.$value['client_name'].'</td>';
							echo '<td>'.$value['process_name'].'</td>';
							echo '<td>'.$value['role_name'].'</td>';
							
							echo '<td>'.$value['job_title'].'</td>';
							echo '<td><span class="teaser">'.substr($value['job_desc'],0,100).' </span><span class="complete">'.$value['job_desc'].'</span>';
							if(strlen($value['job_desc']) > 50)
							{
								echo '<span class="more" style="color:red; cursor:pointer;">more...</span></td>';
							}
							echo '<td><form action="'.base_url('apply/apply').'" method="POST"><input type="hidden" name="rq_id" value="'.$value['requisition_id'].'"><input type="hidden" name="r_id" value="'.$value['id'].'"> <input type="hidden" name="o_id" value="'.$value['location'].'"> <input type="hidden" name="job_title" value="'.str_replace('/',' ',$value['job_title']).'"><button type="submit" class="btn btn-block btn-success">Apply</button></form></td>';
						echo '</tr>';
					}
				}
				echo '</tbody>';
			echo '</table>';
		
	?> 
</div>
<!--inner body part ends here-->

<!--footer part ends here-->
<!--footer part starts here-->

<!--body part ends here-->

<!--footer part starts here-->
<div id="footer">
	<!--<div class="red"></div>-->
	
    <div class="copy">&copy; 2019 Fusion BPO Services. All Rights Reserved.</div>
    <div class="clr"></div>
    
   
</div>
<!--footer part ends here--><!--footer part ends here-->
<script>
	$(".more").toggle(function(){
    $(this).text("less..").siblings(".complete").show();    
    $(this).text("less..").siblings(".teaser").hide();    
}, function(){
    $(this).text("more..").siblings(".complete").hide();    
    $(this).text("more..").siblings(".teaser").show();    
});
</script>
<script>
	$('#instant_search').keyup(function(){
		var text = $(this).val().toLowerCase();
		var location_filter = $('#location_filter').val();
		
		var i = 1;
		$('.search_tr').each(function(index,element)
		{
			var str = $(element).text().toLowerCase();
			$(this).hide();
			var row_ofc_location = $(element).find('.office_location').text();
			if(str.search(text) != -1 && row_ofc_location.search(location_filter) != -1)
			{
				$(this).show();
				if(i % 2 == 0 )
				{
					$(this).css({'background-color':'#dddddd'});
				}
				else
				{
					$(this).css({'background-color':'white'});
				}
				i++;
			}
		});
	});
</script>
<script>
	// AUTO LOAD FILTER
	var textLocation = $('#location_filter').val().toLowerCase();
	initializeLocationFilter(textLocation);
	
	$('#location_filter').change(function()
	{
		var text = $(this).val().toLowerCase();
		var officeselected = $('#location_filter option:selected').attr('shortname');
		
		// SET COOKIE
		setcookie('dfrserachedlocation', officeselected, '2147483647');
		
		// FILER LOCATION
		initializeLocationFilter(text);
	});
	
	
	function setcookie(name, value, expiry)
	{
		var base_url = "<?php echo base_url(); ?>";
		var cookieset = "applicationform/set_cookie_search/" + name + "/" + value + "/" + expiry;
		var finalurl = base_url + cookieset;
		$.ajax({
			url: finalurl,
			success: function(data){
				//console.log(data);
			}
		});
	}
	
	
	function initializeLocationFilter(text)
	{
		$('#instant_search').val('');
		var i = 1;
		$('.office_location').each(function(index,element)
		{
			var str = $(element).text().toLowerCase();
			$(this).parent().hide();
			if(str.search(text) != -1)
			{
				$(this).parent().show();
				if(i % 2 == 0 )
				{
					$(this).parent().css({'background-color':'#dddddd'});
				}
				else
				{
					$(this).parent().css({'background-color':'white'});
				}
				i++;
			}
		});
	}
	
	
</script>
</body>
</html>