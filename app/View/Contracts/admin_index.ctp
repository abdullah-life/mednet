<div class="contracts index">
	<h2><?php echo __('Contracts');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('xmllisting_id');?></th>
			<th><?php echo $this->Paginator->sort('claim_id');?></th>
			<th><?php echo $this->Paginator->sort('renewaldate');?></th>
			<th><?php echo $this->Paginator->sort('startdate');?></th>
			<th><?php echo $this->Paginator->sort('expirydate');?></th>
			<th><?php echo $this->Paginator->sort('grosspremium');?></th>
			<th><?php echo $this->Paginator->sort('packagename');?></th>
			<th><?php echo $this->Paginator->sort('starttype');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('status');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($contracts as $contract): ?>
	<tr>
		<td><?php echo h($contract['Contract']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($contract['Xmllisting']['name'], array('controller' => 'xmllistings', 'action' => 'view', $contract['Xmllisting']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($contract['Claim']['id'], array('controller' => 'claims', 'action' => 'view', $contract['Claim']['id'])); ?>
		</td>
		<td><?php echo h($contract['Contract']['renewaldate']); ?>&nbsp;</td>
		<td><?php echo h($contract['Contract']['startdate']); ?>&nbsp;</td>
		<td><?php echo h($contract['Contract']['expirydate']); ?>&nbsp;</td>
		<td><?php echo h($contract['Contract']['grosspremium']); ?>&nbsp;</td>
		<td><?php echo h($contract['Contract']['packagename']); ?>&nbsp;</td>
		<td><?php echo h($contract['Contract']['starttype']); ?>&nbsp;</td>
		<td><?php echo h($contract['Contract']['created']); ?>&nbsp;</td>
		<td><?php echo h($contract['Contract']['modified']); ?>&nbsp;</td>
		<td><?php echo h($contract['Contract']['status']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $contract['Contract']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $contract['Contract']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $contract['Contract']['id']), null, __('Are you sure you want to delete # %s?', $contract['Contract']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Contract'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Xmllistings'), array('controller' => 'xmllistings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Xmllisting'), array('controller' => 'xmllistings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Claims'), array('controller' => 'claims', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Claim'), array('controller' => 'claims', 'action' => 'add')); ?> </li>
	</ul>
</div>
