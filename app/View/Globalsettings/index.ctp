<div class="globalsettings index">
	<h2><?php echo __('Globalsettings');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('ROUND_OFF_INTEGERS');?></th>
			<th><?php echo $this->Paginator->sort('TRUNCATE_MEMBER_ID');?></th>
			<th><?php echo $this->Paginator->sort('DIAGNOSTIC_CODE_MAPPING');?></th>
			<th><?php echo $this->Paginator->sort('DENTAL_CODE_MAPPING');?></th>
			<th><?php echo $this->Paginator->sort('DRUG_CODE_MAPPING');?></th>
			<th><?php echo $this->Paginator->sort('CLINICIAN_CODE_MAPPING');?></th>
			<th><?php echo $this->Paginator->sort('DENIAL_REASON');?></th>
			<th><?php echo $this->Paginator->sort('PAYER_CODE_MAPPING');?></th>
			<th><?php echo $this->Paginator->sort('PROVIDER_CODE_MAPPING');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($globalsettings as $globalsetting): ?>
	<tr>
		<td><?php echo h($globalsetting['Globalsetting']['id']); ?>&nbsp;</td>
		<td><?php if($globalsetting['Globalsetting']['ROUND_OFF_INTEGERS']) echo "Active"; else echo "Inactive";?>&nbsp;</td>
		<td><?php if($globalsetting['Globalsetting']['TRUNCATE_MEMBER_ID']) echo "Active"; else echo "Inactive"; ?>&nbsp;</td>
		<td><?php if($globalsetting['Globalsetting']['DIAGNOSTIC_CODE_MAPPING']) echo "Active"; else echo "Inactive"; ?>&nbsp;</td>
		<td><?php if($globalsetting['Globalsetting']['DENTAL_CODE_MAPPING'])echo "Active"; else echo "Inactive";  ?>&nbsp;</td>
		<td><?php if($globalsetting['Globalsetting']['DRUG_CODE_MAPPING'])echo "Active"; else echo "Inactive";  ?>&nbsp;</td>
		<td><?php if($globalsetting['Globalsetting']['CLINICIAN_CODE_MAPPING'])echo "Active"; else echo "Inactive";  ?>&nbsp;</td>
		<td><?php if($globalsetting['Globalsetting']['DENIAL_REASON'])echo "Active"; else echo "Inactive";  ?>&nbsp;</td>
		<td><?php if($globalsetting['Globalsetting']['PAYER_CODE_MAPPING'])echo "Active"; else echo "Inactive";  ?>&nbsp;</td>
		<td><?php if($globalsetting['Globalsetting']['PROVIDER_CODE_MAPPING'])echo "Active"; else echo "Inactive";  ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $globalsetting['Globalsetting']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $globalsetting['Globalsetting']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<?php     echo $this->element('logo'); ?>
</div>
