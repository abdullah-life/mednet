<div class="mcodes index">
	<h2><?php echo __('Mcodes');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('codenumber');?></th>
			<th><?php echo $this->Paginator->sort('code_1');?></th>
			<th><?php echo $this->Paginator->sort('code_2');?></th>
			<th><?php echo $this->Paginator->sort('description_1');?></th>
			<th><?php echo $this->Paginator->sort('description_2');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('status');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($mcodes as $mcode): ?>
	<tr>
		<td><?php echo h($mcode['Mcode']['id']); ?>&nbsp;</td>
		<td><?php echo h($mcode['Mcode']['codenumber']); ?>&nbsp;</td>
		<td><?php echo h($mcode['Mcode']['code_1']); ?>&nbsp;</td>
		<td><?php echo h($mcode['Mcode']['code_2']); ?>&nbsp;</td>
		<td><?php echo h($mcode['Mcode']['description_1']); ?>&nbsp;</td>
		<td><?php echo h($mcode['Mcode']['description_2']); ?>&nbsp;</td>
		<td><?php echo h($mcode['Mcode']['created']); ?>&nbsp;</td>
		<td><?php echo h($mcode['Mcode']['modified']); ?>&nbsp;</td>
		<td><?php echo h($mcode['Mcode']['status']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $mcode['Mcode']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $mcode['Mcode']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $mcode['Mcode']['id']), null, __('Are you sure you want to delete # %s?', $mcode['Mcode']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Mcode'), array('action' => 'add')); ?></li>
	</ul>
</div>
