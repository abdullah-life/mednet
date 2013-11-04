<div class="observations index">
	<h2><?php echo __('Observations');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('xmllisting_id');?></th>
			<th><?php echo $this->Paginator->sort('claim_id');?></th>
			<th><?php echo $this->Paginator->sort('type');?></th>
			<th><?php echo $this->Paginator->sort('code');?></th>
			<th><?php echo $this->Paginator->sort('value');?></th>
			<th><?php echo $this->Paginator->sort('valuetype');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('status');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($observations as $observation): ?>
	<tr>
		<td><?php echo h($observation['Observation']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($observation['Xmllisting']['name'], array('controller' => 'xmllistings', 'action' => 'view', $observation['Xmllisting']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($observation['Claim']['id'], array('controller' => 'claims', 'action' => 'view', $observation['Claim']['id'])); ?>
		</td>
		<td><?php echo h($observation['Observation']['type']); ?>&nbsp;</td>
		<td><?php echo h($observation['Observation']['code']); ?>&nbsp;</td>
		<td><?php echo h($observation['Observation']['value']); ?>&nbsp;</td>
		<td><?php echo h($observation['Observation']['valuetype']); ?>&nbsp;</td>
		<td><?php echo h($observation['Observation']['created']); ?>&nbsp;</td>
		<td><?php echo h($observation['Observation']['modified']); ?>&nbsp;</td>
		<td><?php echo h($observation['Observation']['status']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $observation['Observation']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $observation['Observation']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $observation['Observation']['id']), null, __('Are you sure you want to delete # %s?', $observation['Observation']['id'])); ?>
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
	<ul>
		<li><?php echo $this->Html->link(__('New Observation'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Xmllistings'), array('controller' => 'xmllistings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Xmllisting'), array('controller' => 'xmllistings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Claims'), array('controller' => 'claims', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Claim'), array('controller' => 'claims', 'action' => 'add')); ?> </li>
	</ul>
</div>
