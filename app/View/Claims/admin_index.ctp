<div class="claims index">
	<h2><?php echo __('Claims');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('xmllisting_id');?></th>
			<th><?php echo $this->Paginator->sort('xmlclaimID');?></th>
			<th><?php echo $this->Paginator->sort('MemberID');?></th>
			<th><?php echo $this->Paginator->sort('PayerID');?></th>
			<th><?php echo $this->Paginator->sort('ProviderID');?></th>
			<th><?php echo $this->Paginator->sort('EmiratesIDNumber');?></th>
			<th><?php echo $this->Paginator->sort('Gross');?></th>
			<th><?php echo $this->Paginator->sort('PatientShare');?></th>
			<th><?php echo $this->Paginator->sort('Net');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('entry_status');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($claims as $claim): ?>
	<tr>
		<td><?php echo h($claim['Claim']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($claim['Xmllisting']['name'], array('controller' => 'xmllistings', 'action' => 'view', $claim['Xmllisting']['id'])); ?>
		</td>
		<td><?php echo h($claim['Claim']['xmlclaimID']); ?>&nbsp;</td>
		<td><?php echo h($claim['Claim']['MemberID']); ?>&nbsp;</td>
		<td><?php echo h($claim['Claim']['PayerID']); ?>&nbsp;</td>
		<td><?php echo h($claim['Claim']['ProviderID']); ?>&nbsp;</td>
		<td><?php echo h($claim['Claim']['EmiratesIDNumber']); ?>&nbsp;</td>
		<td><?php echo h($claim['Claim']['Gross']); ?>&nbsp;</td>
		<td><?php echo h($claim['Claim']['PatientShare']); ?>&nbsp;</td>
		<td><?php echo h($claim['Claim']['Net']); ?>&nbsp;</td>
		<td><?php echo h($claim['Claim']['created']); ?>&nbsp;</td>
		<td><?php echo h($claim['Claim']['modified']); ?>&nbsp;</td>
		<td><?php echo h($claim['Claim']['entry_status']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $claim['Claim']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $claim['Claim']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $claim['Claim']['id']), null, __('Are you sure you want to delete # %s?', $claim['Claim']['id'])); ?>
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
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Claim'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Xmllistings'), array('controller' => 'xmllistings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Xmllisting'), array('controller' => 'xmllistings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Activities'), array('controller' => 'activities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Activity'), array('controller' => 'activities', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Diagnosis'), array('controller' => 'diagnosis', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Diagnosi'), array('controller' => 'diagnosis', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Encounters'), array('controller' => 'encounters', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Encounter'), array('controller' => 'encounters', 'action' => 'add')); ?> </li>
	</ul>
</div>
