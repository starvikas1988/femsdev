<style>
	.option
	{
		cursor: pointer;
	}
	#option_select
	{
		border: 1px dashed #01cc01;
	}
	[data-question_id][not_ans="true"] {
		display: inline-block;
		width: 35px;
		height: 35px;
		text-align: center;
		background: white;
		border-radius: 50%;
		margin: 2px 4px;
		font-size: 12px;
		line-height: 35px;
		cursor: pointer;
	}
	[data-question_id][review="true"] {
		display: inline-block;
		width: 35px;
		height: 35px;
		text-align: center;
		background: orange;
		border-radius: 50%;
		margin: 2px 4px;
		font-size: 12px;
		line-height: 35px;
		cursor: pointer;
		color:white;
	}
	[data-question_id][select="true"] {
		display: inline-block;
		width: 35px;
		height: 35px;
		text-align: center;
		background: green;
		border-radius: 50%;
		margin: 2px 4px;
		font-size: 12px;
		line-height: 35px;
		cursor: pointer;
		color:white;
	}
	.q_color_stat{
	    display: inline-block;
		width: 29px;
		height: 29px;
		line-height: 29px;
		text-align: center;
		border-radius: 50%;
		font-size: 11px;
		margin-right: 5px;
		margin-bottom: 5px;
		margin-top: 5px;
	}
	.q_color_stat[select="true"]
	{
		background: green;
		color:white;
	}
	.q_color_stat[review="true"]
	{
		background: orange;
	}
	.q_color_stat[not_ans="true"]
	{
		background: white;
	}
	#question_no_container {
		min-height: 400px;
		overflow-y: auto;
	}
	.correct_option_container
	{
		margin-bottom:15px;
	}

</style>
<?php
	/* echo '<pre>';
	print_r($exam_info);
	echo '</pre>'; */
	
	/* echo '<pre>';
	print_r($questions);
	echo '</pre>'; */
	
	
	
?>
<div class="wrap">
	<section class="app-content">
		<div class="row">
			<div class="col-md-2">
				<ul id="question_no_container">
				<?php
					foreach($questions['question_id'] as $key=>$value)
					{
						if($questions['question_status'][$key] == '1')
						{
							echo '<li data-question_id="'.$value.'" select="true">'.($key+1).'</li>';
						}
						else if($questions['question_status'][$key] == '2')
						{
							echo '<li data-question_id="'.$value.'" review="true">'.($key+1).'</li>';
						}
						else if($questions['question_status'][$key] == '0')
						{
							echo '<li data-question_id="'.$value.'" not_ans="true">'.($key+1).'</li>';
						}
					}
				?>
				</ul>
				<div class="row">
					<div class="col-md-12">
						<ul>
							<li><span class="q_color_stat" select="true">Q.</span>Marked as Ans</li>
							<!--<li><span class="q_color_stat" review="true">Q.</span>Marked as Review & Ans</li>-->
							<li><span class="q_color_stat" not_ans="true">Q.</span>Unattempted Question</li>
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<!--<button class="btn btn-info btn-block">Submit Exam</button>-->
					</div>
				</div>
			</div>
			<div class="col-md-10">
				<div class="widget">					
					<header class="widget-header">
						<h4 class="widget-title" style="float:left;">Question</h4>
						<div class="form-group" id="count_down" style="float:right;font-size:20px;color:white; background:red;padding: 1px 10px;">
							
						</div>
					</header> 
					<hr class="widget-separator">
					
					<div class="widget-body clearfix" id="question_container" data-current_question_id="" data-exam_schedule_id="<?php echo $exam_schedule_id; ?>">
					
					</div>
					
				</div>
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title" style="float:left;">Options</h4>
					</header>
					<hr class="widget-separator">
					<div class="widget-body clearfix">
						<ul id="option_container">
							
						</ul>
					</div>
				</div>
				<div class="widget">
					<div class="widget-body clearfix">
						<div class="row">
							<div class="col-md-4">
								<button class="btn btn-block btn-success" id="next">Next</button>
							</div>
							<div class="col-md-4">
								<button class="btn btn-block btn-info" id="previous">Previous</button>
							</div>
							<div class="col-md-4">
								<button class="btn btn-block btn-default" id="finish">Finish Exam</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</section>
</div>