<!DOCTYPE html>
<html lang="en">
<head>
  <title>Quiz PDF</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <script src="<?php echo base_url();?>assets/canvas_js/jquery.canvasjs.min.js"></script>
  <!--<script src="https://cdn.syncfusion.com/ej2/dist/ej2.min.js" type="text/javascript"></script>-->
  <script src="<?php echo base_url();?>assets/script/ej2.min.js" type="text/javascript"></script>
</head>
<body>
	<section id="superthotics-results" style="padding:2em 0;">
		<div style="width:770px;max-width:100%;margin:0 auto;">
			<!-- DataTable -->
			<div class="col-md-12">
				<header class="widget-header" style="background-color:yellow">
					<div class="row">
						<div class="col-sm-1 col-1">
							<a href="<?php echo base_url();?>course/view_subject_list/<?php echo $categ_id ;?>" class="btn  btn-success" title="Navigate Back"><i class="fa fa-arrow-left"></i> Back </a>
						</div>
					</div>
				</header><!-- .widget-header -->
			</div><!-- .widget -->
		
			<div style="text-align:center;font-family: 'Poppins', sans-serif; letter-spacing:0.5px;">
				<h2><?php echo $course_name['course_name']; ?></h2>
			</div>
			
			<div style="width:100%;margin:40px 0 0 0;">
				<div style="width:32.3333%;display:inline-block;">
					<div style="width:100%;text-align:center;font-family: 'Poppins', sans-serif;font-size:14px; letter-spacing:0.5px;">
						<strong>Average</strong> <br>
						70 / 100 points
					</div>
				</div>
				<div style="width:32.3333%;display:inline-block;">
					<div style="width:100%;text-align:center;font-family: 'Poppins', sans-serif;font-size:14px; letter-spacing:0.5px;">
						<strong>Median</strong> <br>
						65 / 100 points
					</div>
				</div>
				<div style="width:32.3333%;display:inline-block;">
					<div style="width:100%;text-align:center;font-family: 'Poppins', sans-serif;font-size:14px; letter-spacing:0.5px;">
						<strong>Range</strong> <br>
						45 - 85 points
					</div>
				</div>
			</div>
			
			<div style="width:100%;margin:40px 0 0 0;font-family: 'Poppins', sans-serif;font-size:14px;text-align:center;letter-spacing:0.5px;">
				<strong>Total points distribution</strong>
			</div>
			
			<div id="rating_score" style="width:100%;margin:20px 0 0 0;">
				
			</div>
			
			<script>
					
				 var b = '<?php  echo json_encode($analytics_report); ?>';
					
					var c =	JSON.parse(b);
				 console.log(c);

					var chart = new ej.charts.Chart({
					//Initializing Primary X Axis
					primaryXAxis: {
						valueType: "Category",
						labelFormat: 'n1',
						title: "Scores"
					},
					//Initializing Primary Y Axis
					primaryYAxis: {
						title: "Number of Responses",
						labelFormat: 'n1'
					},
					//Initializing Chart Series
					series: [
						{
							type: "Column",
							dataSource: c,
							xName: "scored", 
							yName: "score_1"
						}
					]
				});
				
				chart.appendTo('#rating_score');

										
				</script>
			
			
			<div style="width:100%;margin:40px 0 0 0;">
				<div style="width:49.5%;display:inline-block;">
					<div style="width:100%;font-family: 'Poppins', sans-serif;font-size:15px;color:#6b6b6e;">
						Questions
					</div>
					<div style="width:100%;font-family: 'Poppins', sans-serif;font-size:15px;color:#6b6b6e;margin:10px 0 0 0;">
						
					</div>
					<div style="width:100%;font-family: 'Poppins', sans-serif;font-size:15px;color:#6b6b6e;margin:10px 0 0 0;">
						
					</div>
				</div>
			</div>
			<?php $old_ques_id='';
                  $i=1;
				  $no=1;
			?>
			<?php if(!empty($course_analytics)){ ?>
				<div style="width:100%;margin:0 0 0 0;">
				
				<?php foreach($course_analytics as $analytics){ ?> 
				<?php  $total_ans=0;
					   $total_correct_ans=0;
				?>
					<?php foreach($analytics as $analytics_ques){ ?>  
					
						<?php 
						
						$total_ans = $total_ans + $analytics_ques['total_ans'];
						$total_correct_ans = $total_correct_ans + $analytics_ques['total_correct_ans'];
						
						if($analytics_ques['ques_ids'] != $old_ques_id){ 
								 $old_ques_id = $analytics_ques['ques_ids'];
						?> 
						<div style="width:49.5%;display:inline-block;font-family: 'Poppins', sans-serif;color:#606469;padding-top:20px">
							<?php echo $no ?>. <?php echo  $c_question[$analytics_ques['ques_ids']]; ?>
						</div>
						
						
						
					<?php } //else{ ?>
					
					<?php //}   ?>
					 
					<?php $i=$i+1;
					
					 if($analytics_ques['correct_answer'] == 1) echo "<span class='fa fa-check'> ". $analytics_ques['text']  ."</span>"; 
					  
					 } ?>
					
					<div style="width:100%;margin:5px 0 0 0;font-family: 'Poppins', sans-serif;color:#606469;font-size:14px;">
							 <?php echo $total_correct_ans ; ?> / <?php echo $total_ans; ?> correct responses  
					</div>
					<div id="chartContainer_<?php echo $i;?>" style="height:150px;background:#bdbdbd;margin:20px 0 0 0;"></div> 
					 
						
				<script>
					
					var a = '<?php echo json_encode($analytics); ?>';
					
					var j =	JSON.parse(a);
				var chart_id = '<?php  echo 'chartContainer_'.$i;?>';
				
					var chart = new ej.charts.Chart({
					//Initializing Primary X Axis
					primaryXAxis: {
						valueType: "Category",
						title: "Options"
					},
					//Initializing Primary Y Axis
					primaryYAxis: {
						title: "Number of Responses"
					},
					//Initializing Chart Series
					series: [
						{
							type: "Bar",
							dataSource: j,
							xName: "text",
							yName: "total_ans"
						}
					]
				});
				chart.appendTo('#'+chart_id);

										
				</script>
					
					<?php //echo "<pre>";  print_r($arr); ?> 
					
				<?php $no= $no + 1;
					
					} ?>
					
				</div>
			<?php } ?>
		</div>
	</section>
	
	<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.min.js"></script>
	<script src="<?php echo base_url();?>assets/canvas_js/jquery.canvasjs.min.js"></script>-->
</body>
</html>