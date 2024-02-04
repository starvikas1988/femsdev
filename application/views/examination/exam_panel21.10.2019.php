<style>
	.option
	{
		cursor: pointer;
	}
	#option_selected
	{
		border: 1px dashed #01cc01;
	}
</style>
<?php
	/* echo '<pre>';
	print_r($exam_info);
	echo '</pre>'; */
	
	/* echo '<pre>';
	print_r($questions);
	echo '</pre>'; */
	
	
	
	$option_array = explode('###',$questions['option']);
	$option_id_array = explode('###',$questions['option_id']);
?>
<div class="wrap">
	<section class="app-content">
		<div class="row">
			<div class="col-md-2">
			
			</div>
			<div class="col-md-8">
				<div class="widget">					
					<header class="widget-header">
						<h4 class="widget-title" style="float:left;">Question</h4>
						<div class="form-group" id="count_down" style="float:right;">
							
						</div>
					</header> 
					<hr class="widget-separator">
					
					<div class="widget-body clearfix" id="question_container" data-question_id="<?php echo $questions['question_id'] ?>" data-exam_id="<?php echo $questions['exam_id'] ?>" data-set_id="<?php echo $questions['set_id'] ?>" data-no_of_ques="<?php echo $exam_info->no_of_question; ?>">
						<?php
							echo $questions['question'];
						?>
					</div>
					
				</div>
				<div class="widget">
					<header class="widget-header">
						<h4 class="widget-title" style="float:left;">Options</h4>
					</header>
					<hr class="widget-separator">
					<div class="widget-body clearfix" id="option_container">
						
					</div>
				</div>
			</div>
			<div class="col-md-2">
			
			</div>
		</div>
		<div class="row">
			<div class="col-md-2">
				
			</div>
			<div class="col-md-8">
				<div class="widget">					
					<header class="widget-header">
						<h4 class="widget-title" style="float:left;">Question</h4>
						<div class="form-group" id="count_down" style="float:right;">
							
						</div>
					</header> 
					<hr class="widget-separator">
					
					<div class="widget-body clearfix" id="question_container" data-question_id="<?php echo $questions['question_id'] ?>" data-exam_id="<?php echo $questions['exam_id'] ?>" data-set_id="<?php echo $questions['set_id'] ?>" data-no_of_ques="<?php echo $exam_info->no_of_question; ?>">
						<?php
							echo $questions['question'];
						?>
					</div>
					
				</div>
			</div>
			<div class="col-md-2">
			
			</div>
		</div>
		<div class="row">
			<div class="col-md-2">
			
			</div>
			<div class="col-md-8">
				<div class="widget option option1" data-option_id="<?php echo $option_id_array[0]; ?>">
					<div class="widget-body clearfix">
						<?php
							echo $option_array[0];
						?>
					</div>
				</div>
			</div>
			<div class="col-md-2">
			
			</div>
		</div>
		<div class="row">
			<div class="col-md-2">
			
			</div>
			<div class="col-md-8">
				<div class="widget option option2" data-option_id="<?php echo $option_id_array[1]; ?>">
					<div class="widget-body clearfix">
						<?php
							echo $option_array[1];
						?>
					</div>
				</div>
			</div>
			<div class="col-md-2">
			
			</div>
		</div>
		<div class="row">
			<div class="col-md-2">
			
			</div>
			<div class="col-md-8">
				<div class="widget option option3" data-option_id="<?php echo $option_id_array[2]; ?>">
					<div class="widget-body clearfix">
						<?php
							echo $option_array[2];
						?>
					</div>
				</div>
			</div>
			<div class="col-md-2">
			
			</div>
		</div>
		<div class="row">
			<div class="col-md-2">
			
			</div>
			<div class="col-md-8">
				<div class="widget option option4" data-option_id="<?php echo $option_id_array[3]; ?>">
					<div class="widget-body clearfix">
						<?php
							echo $option_array[3];
						?>
					</div>
				</div>
			</div>
			<div class="col-md-2">
			
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-2">
			
			</div>
			<div class="col-md-8">
				<div class="widget">
					<div class="widget-body clearfix">
						<div class="row">
							<div class="col-md-4">
								<button class="btn btn-block btn-success" data-review="<?php echo $questions['revise']; ?>" id="final_ans">Final answere</button>
							</div>
							<div class="col-md-4">
								<button class="btn btn-block btn-warning" data-review="<?php echo $questions['revise']; ?>" id="review_ans">Mark answere for review Later</button>
							</div>
							<div class="col-md-4">
								<button class="btn btn-block btn-danger" data-review="<?php echo $questions['revise']; ?>" id="skip_ans">Skip the Question</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-2">
			
			</div>
		</div>
	</section>
</div>