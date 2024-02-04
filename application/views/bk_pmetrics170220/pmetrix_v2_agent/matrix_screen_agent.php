<div class="wrap">
	<section class="app-content">
		<div class="row">
			<div class="col-md-12">
				<div class="widget">
				<form id="search_metrix">
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-5">
									<header class="widget-header">
										<h4 class="widget-title">Search Metrix</h4>
									</header>
								</div>
								<div class="col-md-2">
								</div>
								<div class="col-md-2">
									<select name="performance_for_month" class="form-control" id="performance_for_month" style="margin-top: 7px;" required>
										<option value="">--Select Month--</option>
											<option value="01">Jan</option>
											<option value="02">Feb</option>
											<option value="03">Mar</option>
											<option value="04">Apr</option>
											<option value="05">May</option>
											<option value="06">June</option>
											<option value="07">July</option>
											<option value="08">Aug</option>
											<option value="09">Sept</option>
											<option value="10">Oct</option>
											<option value="11">Nov</option>
											<option value="12">Dec</option>
									</select>
								</div>
								<div class="col-md-2">
									<select name="performance_for_year" class="form-control" id="performance_for_year" style="margin-top: 7px;" required>
										<option value="">--Select Year--</option>
										<?php
											$firstYear = (int)date('Y') - 1;
											$lastYear = $firstYear + 1;
											for($i=$firstYear;$i<=$lastYear;$i++)
											{
												if($i == date('Y'))
												{
													echo '<option value="'.$i.'"  selected="selected">'.$i.'</option>';
												}
												else
												{
													echo '<option value="'.$i.'">'.$i.'</option>';
												}
											}
										?>
									</select>
								</div>
								<div class="col-md-1">
									<input type="submit" class="btn btn-block btn-success" value="Search" style="margin-top: 7px;">
								</div>
							</div>
						</div>
						
					</div>
				</form>
					
					<div class="widget-body">
						
					</div>
					
				</div>
				
			</div>
		</div>
		<div id="search_metrix_container">
		<?php
			echo $table;
		?>
		</div>
	</section>
</div>