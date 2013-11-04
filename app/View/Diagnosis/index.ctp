<div class="diagnosis index">
	<h2><?php echo __('Diagnosis');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('xmllisting_id');?></th>
			<th><?php echo $this->Paginator->sort('claim_id');?></th>
			<th><?php echo $this->Paginator->sort('Type');?></th>
			<th><?php echo $this->Paginator->sort('Code');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('status');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($diagnosis as $diagnosi): ?>
	<tr>
		<td><?php echo h($diagnosi['Diagnosi']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($diagnosi['Xmllisting']['name'], array('controller' => 'xmllistings', 'action' => 'view', $diagnosi['Xmllisting']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($diagnosi['Claim']['id'], array('controller' => 'claims', 'action' => 'view', $diagnosi['Claim']['id'])); ?>
		</td>
		<td><?php echo h($diagnosi['Diagnosi']['Type']); ?>&nbsp;</td>
		<td><?php echo h($diagnosi['Diagnosi']['Code']); ?>&nbsp;</td>
		<td><?php echo h($diagnosi['Diagnosi']['created']); ?>&nbsp;</td>
		<td><?php echo h($diagnosi['Diagnosi']['modified']); ?>&nbsp;</td>
		<td><?php echo h($diagnosi['Diagnosi']['status']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $diagnosi['Diagnosi']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $diagnosi['Diagnosi']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $diagnosi['Diagnosi']['id']), null, __('Are you sure you want to delete # %s?', $diagnosi['Diagnosi']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Diagnosi'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Xmllistings'), array('controller' => 'xmllistings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Xmllisting'), array('controller' => 'xmllistings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Claims'), array('controller' => 'claims', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Claim'), array('controller' => 'claims', 'action' => 'add')); ?> </li>
	</ul>
</div>
