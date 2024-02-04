	
	
	
	<div class="row">
	<!--<div class="col-sm-6">
			<div class="form-group">-->
		    <!--<label>Total Records</label>-->
		    <input type="hidden" class="form-control" name="record_id" id="record_id" value="<?php echo $record_id; ?>" readonly required>
		    <!--<input type="text" class="form-control" name="total_record" value="<?php echo $records_total; ?>" readonly required>
		   </div>
		</div>-->
		
		<div class="col-sm-6">
			<div class="form-group">
		    <label>Assigned Records</label>
		    <input type="text" class="form-control" name="total_assigned" id="total_assigned" value="<?php echo $records_assigned; ?>" readonly required>
		   </div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
		    <label>Assigned To</label>



			<select class="form-control" id="reassignList" name="assigned_to" required>
				<?php echo duns_dropdown_assigned_to($duns_assigned_clients_list, 'id', 'name', '1', $assigned_user); ?>
			</select>
			<input type="hidden" class="form-control" name="assignedAgentCnt" id="assignedAgentCnt" value="<?php echo $assignedAgentCnt ?>">
			<input type="hidden" class="form-control" name="" id="client_id_hidden" value="<?php echo $client_id ?>">
		   </div>
		</div>
	</div>
	
	<hr/>
	
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive" style="height:300px;" id="table_data">			
			
				<table id="default-datatable" data-plugin="DataTable" class="table skt-table" cellspacing="0" width="100%" style="margin-bottom:0px;">
					<thead>
						<tr class="bg-info">
							<th class="text-center"><input type="checkbox" id="selectAllChekcbox" name="selectAllChekcbox" class="selectAllChekcbox reassign" value="1"></th>
							<th class="text-center">Sl</th>
							<th class="text-center">Fusion ID</th>
							<th>Agent Name</th>
							<th>Department</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="tableBody">						
						<?php 
						$counter = 0;
						foreach($agent_list as $valueTD){ 
							$counter++;
						?>				
							<tr class="tableHead">
								<td class="text-center">
								<input type="checkbox" name="select_agent[]" class="selectUserChekcbox" value="<?php echo $valueTD['id']; ?>">
								</td>
								<td class="text-center"><?php echo $counter; ?></td>
								<td class="text-center"><?php echo $valueTD['fusion_id']; ?></td>
								<td><?php echo $valueTD['fullname']; ?></td>
								<td><?php echo $valueTD['department_name']; ?></td>
								<td>					
								</td>
							</tr>
						<?php } ?>						
					</tbody>
				</table>
	
			</div>
		</div>
	</div>
	
	
	<hr/>
	
	<div class="row">
		<div class="col-sm-6">
			<div class="form-group">
		    <label>Unassigned Records</label>
		    <input type="text" class="form-control"  name="total_unassigned" value="<?php echo $records_unassigned; ?>" readonly required>
		   </div>
		</div>
		
		<div class="col-sm-6">
			<div class="form-group">
		    <label>Enter No Of Records</label>
		    <input type="number" class="form-control" name="reassign_record" id="reassign_record" min="1" max="<?php echo $records_assigned; ?>" value="" required>
		   </div>
		</div>
	</div>
	
	<hr/>
	
	<div class="row">
		<div class="col-sm-6">
			<div class="form-group">
		    <button type="button" id="reassign_update" class="btn bg-success">Update</button>		 
		   </div>
		</div>
	</div>
	
	<script>
		$(document).ready(function() {
			$('#selectAllChekcbox').click(function() {
				$('input[type="checkbox"]').prop('checked', $(this).prop('checked'));
			});

			$("input[type=checkbox]").click(function() {
				if (!$(this).prop("checked")) {
					$("#selectAllChekcbox").prop("checked", false);
				}
			});
		});

		var reassign_record = document.querySelector("input[name='reassign_record']");
		reassign_record.addEventListener("change", function (event) {
			if (this.value < 1) this.value = 1; // minimum is 1
			else this.value = Math.floor(this.value); // only integers allowed
		})

		$("#reassign_update").click(function() { 
			var reassignList = $("#reassignList").val();
			var reassign_record = $("#reassign_record").val();
			var assign_agent_cnt = $("#assignedAgentCnt").val();
			if( $('.selectUserChekcbox').is(':checked') ){
				if(reassignList!=""){
					if(reassign_record!=""){
						if(parseInt(assign_agent_cnt) >= parseInt(reassign_record)){
							$("#reassign_data_form").submit();
						}else{
							alert("Maximum No Of Records exceeds");
						}
					}else{
						alert("Please enter No Of Records");
					}
				}else{
					alert("Please select Assigned To");
				}
			}else{
				alert("Please assign an Agent");
			}
		});
	</script>
	