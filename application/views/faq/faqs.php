<style>
.collapsible {
  background-color: #777;
  color: white;
  cursor: pointer;
  padding: 18px;
  width: 100%;
  border: none;
  text-align: left;
  outline: none;
  font-size: 15px;
}

.active, .collapsible:hover {
  background-color: #555;
}

.collapsible:after {
  content: '\002B';
  color: white;
  font-weight: bold;
  float: right;
  margin-left: 5px;
}

.active:after {
  content: "\2212";
}

.content {
  padding: 0 18px;
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.2s ease-out;
  background-color: #f1f1f1;
}
.text_area
{
	border: 1px solid #f68a8a;
	border-radius: 2px;
}
.copy_container
{
	position: absolute;
	display: inline;
	cursor: pointer;
	right: 0px;
}
.collapsible {
    height: 40px;
    line-height: 30px;
    padding: 0px 18px;
    border-radius: 4px 4px 0px 0px;
	background-color: #ff5b5b;
}
.fixed_bottom
{
	z-index:-1;
}
.active_back
{
	background-color: #41414199;
}
</style>


<div class="wrap">
	<section class="app-content">
	
	<div class="row">
		<div class="col-md-12">
			<div class="widget">
				<header class="widget-header">
					<h4 class="widget-title">FAQ's</h4>
				</header><!-- .widget-header -->
				<hr class="widget-separator">
				<div class="widget-body"> 
					<?php
					//echo '<pre>';
						//print_r($faqs);
						$faq_array = array();
						foreach($faqs as $key=>$value)
						{
							$faq_array[$value->name]['title'][] = $value->title;
							$faq_array[$value->name]['text'][] = $value->text;
					?>
					
					<?php
						}
						//echo '<pre>';
						//print_r($faq_array);
						if(empty($faq_array))
						{
							echo '<h3 class="text-center">No FAQ Found</h3>';
						}
						$i=1;
						foreach($faq_array as $key=>$value)
						{
						
					?>
						<button class="collapsible"><?php echo $key; ?></button>
						<div class="content" style="padding-bottom: 10px;margin-bottom: 5px;">
						<?php
							foreach($value['title'] as $ke=>$val)
							{
						?>
							<div>
								
								<div style="position:relative;padding: 6px 0px;"><b><?php echo $val; ?></b><p class="copy_container" onclick="myFunction('selection_<?php echo $i; ?>')"><i class="fa fa-clipboard"></i></p></div>
								
								<textarea class="text_area form-control" id="selection_<?php echo $i; ?>" readonly><?php echo $value['text'][$ke]; ?></textarea>
							</div>
						<?php
								$i++;
							}
						?>
						</div>
					<?php
					
						}
					?>
				</div>
			</div>
		</div>
	</div>
	</section>
</div>



