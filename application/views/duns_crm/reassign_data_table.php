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
</script>