<div >
	<h2><?php echo __('Observations');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
            <th><?php echo h("Claim ID")?></th>
            <th><?php echo h("Activity ID")?></th>
            <th><?php echo h("Type")?></th>
            <th><?php echo h("Code")?></th>
            <th><?php echo h("Value")?></th>
            <th><?php echo h("ValueType")?></th>
	</tr>
	<?php
        if(!isset($Observations['Activity']['Observation'][0]))
            $observationsarray[]  =   $Observations['Activity']['Observation'];
        else
            $observationsarray  =   $Observations['Activity']['Observation'];
        
	foreach ($observationsarray as $observation): ?>
        <tr>
            <td><?php echo $ClaimID;?></td>
            <td><?php echo $Observations['Activity']['Activity_id'] ?></td>
            <td><?php echo $observation['Type'] ?></td>
            <td><?php echo $observation['Code'] ?></td>
            <td><?php echo $observation['Value'] ?></td>
            <td><?php echo $observation['ValueType'] ?></td>
        </tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	
</div>