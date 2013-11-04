<div class="simpletypes index">
	<h2><?php echo __('Simpletypes');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('xmllisting_id');?></th>
			<th><?php echo $this->Paginator->sort('claim_id');?></th>
			<th><?php echo $this->Paginator->sort('datefrom');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('deleted');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($simpletypes as $simpletype): ?>
	<tr>
		<td><?php echo h($simpletype['Simpletype']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($simpletype['Xmllisting']['name'], array('controller' => 'xmllistings', 'action' => 'view', $simpletype['Xmllisting']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($simpletype['Claim']['id'], array('controller' => 'claims', 'action' => 'view', $simpletype['Claim']['id'])); ?>
		</td>
		<td><?php echo h($simpletype['Simpletype']['datefrom']); ?>&nbsp;</td>
		<td><?php echo h($simpletype['Simpletype']['created']); ?>&nbsp;</td>
		<td><?php echo h($simpletype['Simpletype']['modified']); ?>&nbsp;</td>
		<td><?php echo h($simpletype['Simpletype']['deleted']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $simpletype['Simpletype']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $simpletype['Simpletype']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $simpletype['Simpletype']['id']), null, __('Are you sure you want to delete # %s?', $simpletype['Simpletype']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Simpletype'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Xmllistings'), array('controller' => 'xmllistings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Xmllisting'), array('controller' => 'xmllistings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Claims'), array('controller' => 'claims', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Claim'), array('controller' => 'claims', 'action' => 'add')); ?> </li>
	</ul>
</div>
