	
	
	
	<div class="row">
		<div class="col-sm-6">
			<div class="form-group">
		    <label>Total Records</label>
		    <input type="hidden" class="form-control" name="record_id" value="<?php echo $record_id; ?>" readonly required>
		    <input type="text" class="form-control" name="total_record" value="<?php echo $records_total; ?>" readonly required>
		   </div>
		</div>
		
		<div class="col-sm-6">
			<div class="form-group">
		    <label>Assigned Records</label>
		    <input type="text" class="form-control" name="total_assigned" value="<?php echo $records_assigned; ?>" readonly required>
		   </div>
		</div>
	</div>
	
	<hr/>
	
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive" style="height:300px;">			
			
				<table id="default-datatable" data-plugin="DataTable" class="table skt-table" cellspacing="0" width="100%" style="margin-bottom:0px;">
					<thead>
						<tr class="bg-info">
							<th class="text-center"><input type="checkbox" id="selectAllCheckbox" name="selectAllChekcbox" class="selectAllChekcbox" value="<?php echo $valueTD['id']; ?>"></th>
							<th class="text-center">Sl</th>
							<th class="text-center">Fusion ID</th>
							<th>Agent Name</th>
							<th>Department</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>						
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
		    <input type="number" class="form-control" name="assign_record" id="assign_record" min="1" max="<?php echo $records_unassigned; ?>" value="" required>
		   </div>
		</div>
	</div>
	
	<hr/>
	
	<div class="row">
		<div class="col-sm-6">
			<div class="form-group">
		    <button type="button" id="assign_update" class="btn bg-success">Update</button>		 
		   </div>
		</div>
	</div>
<script>
	$(document).ready(function() {
    	$('#selectAllCheckbox').click(function() {
        	$('input[type="checkbox"]').prop('checked', $(this).prop('checked'));
		});

		$("input[type=checkbox]").click(function() {
			if (!$(this).prop("checked")) {
				$("#selectAllCheckbox").prop("checked", false);
			}
		});
	});

	var assign_record = document.querySelector("input[name='assign_record']");
	assign_record.addEventListener("change", function (event) {
		if (this.value < 1) this.value = 1; // minimum is 1
		else this.value = Math.floor(this.value); // only integers allowed
	})

	$("#assign_update").click(function() {
		var assign_record = $("#assign_record").val();
		if( $('.selectUserChekcbox').is(':checked') ){
			if(assign_record!=""){
				$("#assign_data_form").submit();
			}else{
				alert("Please Enter No Of Records");
			}
		}else{
			alert("Please assign an Agent");
		}
	});
</script>	
	