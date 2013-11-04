<div class="claimsmanagerBatches index">
	<h2><?php echo __('Claimsmanager Batches');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('batch_id');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('status');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($claimsmanagerBatches as $claimsmanagerBatch): ?>
	<tr>
		<td><?php echo h($claimsmanagerBatch['ClaimsmanagerBatch']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($claimsmanagerBatch['Batch']['name'], array('controller' => 'batches', 'action' => 'view', $claimsmanagerBatch['Batch']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($claimsmanagerBatch['User']['id'], array('controller' => 'users', 'action' => 'view', $claimsmanagerBatch['User']['id'])); ?>
		</td>
		<td><?php echo h($claimsmanagerBatch['ClaimsmanagerBatch']['created']); ?>&nbsp;</td>
		<td><?php echo h($claimsmanagerBatch['ClaimsmanagerBatch']['modified']); ?>&nbsp;</td>
		<td><?php echo h($claimsmanagerBatch['ClaimsmanagerBatch']['status']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $claimsmanagerBatch['ClaimsmanagerBatch']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $claimsmanagerBatch['ClaimsmanagerBatch']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $claimsmanagerBatch['ClaimsmanagerBatch']['id']), null, __('Are you sure you want to delete # %s?', $claimsmanagerBatch['ClaimsmanagerBatch']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Claimsmanager Batch'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Batches'), array('controller' => 'batches', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Batch'), array('controller' => 'batches', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
