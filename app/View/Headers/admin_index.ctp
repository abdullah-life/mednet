<div class="headers index">
	<h2><?php echo __('Headers');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('xmllisting_id');?></th>
			<th><?php echo $this->Paginator->sort('SenderID');?></th>
			<th><?php echo $this->Paginator->sort('ReceiverID');?></th>
			<th><?php echo $this->Paginator->sort('TransactionDate');?></th>
			<th><?php echo $this->Paginator->sort('RecordCount');?></th>
			<th><?php echo $this->Paginator->sort('DispositionFlag');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('status');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($headers as $header): ?>
	<tr>
		<td><?php echo h($header['Header']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($header['Xmllisting']['name'], array('controller' => 'xmllistings', 'action' => 'view', $header['Xmllisting']['id'])); ?>
		</td>
		<td><?php echo h($header['Header']['SenderID']); ?>&nbsp;</td>
		<td><?php echo h($header['Header']['ReceiverID']); ?>&nbsp;</td>
		<td><?php echo h($header['Header']['TransactionDate']); ?>&nbsp;</td>
		<td><?php echo h($header['Header']['RecordCount']); ?>&nbsp;</td>
		<td><?php echo h($header['Header']['DispositionFlag']); ?>&nbsp;</td>
		<td><?php echo h($header['Header']['created']); ?>&nbsp;</td>
		<td><?php echo h($header['Header']['modified']); ?>&nbsp;</td>
		<td><?php echo h($header['Header']['status']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $header['Header']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $header['Header']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $header['Header']['id']), null, __('Are you sure you want to delete # %s?', $header['Header']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Header'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Xmllistings'), array('controller' => 'xmllistings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Xmllisting'), array('controller' => 'xmllistings', 'action' => 'add')); ?> </li>
	</ul>
</div>
