	<div class="wrap">
	<section class="app-content">
		<div class="row">
			<!-- END column -->
			<?php echo form_open('') ?>
			<input type="hidden" value="<?php echo $id; ?>" name="id" readonly>
			<div class="col-md-12">
				<!-- toolbar -->
				<div class="row">
					<div class="col-md-12">
						<div class="mail-toolbar m-b-md">								
							<div class="btn-group" role="group">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Add <span class="caret"></span></button>
								<ul class="dropdown-menu">
									<li><a href="#">Note</a></li>
									<li><a href="#">save</a></li>
								</ul>
							</div>

							<div class="btn-group" role="group">
								<a href="#" class="btn btn-default"><i class="fa fa-trash"></i></a>
								<a href="#" class="btn btn-default"><i class="fa fa-arrow-left"></i></a>
							</div>
							
							<div style="margin-top:10px;">
								<?php if($this->session->flashdata('error')!=''): ?>
								<?php echo $this->session->flashdata('error'); ?>
								<?php endif; ?>
							</div>
							
							
							
						</div>
					</div>
				</div><!-- END toolbar -->
				
				<div class="mail-view">
					<h4 class="m-0"><?php echo substr($subject,0,100); ?></h4>
					<div class="divid"></div>
					<div class="media">
						<div class="media-body">
							<div class="m-b-sm">
								<h4 class="m-0 inline-block m-r-lg">
									<a href="#"><span class="label label-success"><?php echo $campaign_name; ?></span></a>
									<a href="#"><span class="label label-primary"><?php echo $coach_name; ?></span></a>
								</h4>
							</div>
						</div>
					</div>
					<div class="divid"></div>
					
					<?php foreach($coach_notes_list as $clist): ?>
					<div class="mail-item">
						<table class="mail-container">
							<tr>
								<td class="mail-center">
									<div class="mail-item-header">
										<?php print $clist["notes"]; ?>	
									</div>
									
										<a href="#">
											<span class="label label-success" style="margin-right:3px;">
												<?php print $clist["inserter_name"]; ?>
											</span>
										</a>
								</td>
								<td class="mail-right" style="font-size:13px;">
									<p class="mail-item-date">
										<?php print $clist["date"]; ?>
									</p>
								</td>
							</tr>
						</table>
					</div>
					<?php endforeach; ?>
					
					<div class="divid"></div>
					<div class="row">
						
							<?php if($already_read_by_agent==1): ?>
								<input class="btn btn-sm btn-success" id="read_button" type="submit" value="Already Read" name="read" disabled>
							<?php else:?>
								<input class="btn btn-sm btn-success" id="read_button" type="submit" value="Read" name="read">
							<?php endif; ?>
							
							<input class="btn btn-sm btn-primary" id="add_note" type="button" value="Add Note" name="add_note">
							
					</div>
					<div class="divid"></div>
				</div>
				
				<div class="row show-editor" style="display:none;">
					<div class="col-md-12">
						<div class="panel panel-default new-message">
							<div class="panel-heading">
								<strong>Add a Note</strong>
							</div>								
							<div class="panel-body p-0">
								<textarea id="new-message-body" name="notes"><?php echo '' ?></textarea>
							</div>
							<div class="panel-footer">
								<input type="submit" class="btn btn-sm btn-primary" value="Save" name="save">
								<button type="button" class="btn btn-sm btn-danger" id="delete">Delete</button>
							</div>
						</div>
					</div>
				</div>	
				
				
				</form>
			</div><!-- END column -->
		</div><!-- .row -->
	</section><!-- .app-content -->
</div><!-- .wrap -->