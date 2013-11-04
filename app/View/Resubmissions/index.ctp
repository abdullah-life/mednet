<div class="resubmissions index">
	<h2><?php echo __('Resubmissions');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('claim_id');?></th>
			<th><?php echo $this->Paginator->sort('Type');?></th>
			<th><?php echo $this->Paginator->sort('Comment');?></th>
			<th><?php echo $this->Paginator->sort('Attachment');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('status');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($resubmissions as $resubmission): ?>
	<tr>
		<td><?php echo h($resubmission['Resubmission']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($resubmission['Claim']['id'], array('controller' => 'claims', 'action' => 'view', $resubmission['Claim']['id'])); ?>
		</td>
		<td><?php echo h($resubmission['Resubmission']['Type']); ?>&nbsp;</td>
		<td><?php echo h($resubmission['Resubmission']['Comment']); ?>&nbsp;</td>
		<td><?php echo h($resubmission['Resubmission']['Attachment']); ?>&nbsp;</td>
		<td><?php echo h($resubmission['Resubmission']['created']); ?>&nbsp;</td>
		<td><?php echo h($resubmission['Resubmission']['modified']); ?>&nbsp;</td>
		<td><?php echo h($resubmission['Resubmission']['status']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $resubmission['Resubmission']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $resubmission['Resubmission']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $resubmission['Resubmission']['id']), null, __('Are you sure you want to delete # %s?', $resubmission['Resubmission']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Resubmission'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Claims'), array('controller' => 'claims', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Claim'), array('controller' => 'claims', 'action' => 'add')); ?> </li>
	</ul>
</div>
