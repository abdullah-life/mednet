<div class="people index">
	<h2><?php echo __('People');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('xmllisting_id');?></th>
			<th><?php echo $this->Paginator->sort('claim_id');?></th>
			<th><?php echo $this->Paginator->sort('nationality');?></th>
			<th><?php echo $this->Paginator->sort('birthdate');?></th>
			<th><?php echo $this->Paginator->sort('UUID');?></th>
			<th><?php echo $this->Paginator->sort('visafilenumber');?></th>
			<th><?php echo $this->Paginator->sort('n/a');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('status');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($people as $person): ?>
	<tr>
		<td><?php echo h($person['Person']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($person['Xmllisting']['name'], array('controller' => 'xmllistings', 'action' => 'view', $person['Xmllisting']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($person['Claim']['id'], array('controller' => 'claims', 'action' => 'view', $person['Claim']['id'])); ?>
		</td>
		<td><?php echo h($person['Person']['nationality']); ?>&nbsp;</td>
		<td><?php echo h($person['Person']['birthdate']); ?>&nbsp;</td>
		<td><?php echo h($person['Person']['UUID']); ?>&nbsp;</td>
		<td><?php echo h($person['Person']['visafilenumber']); ?>&nbsp;</td>
		<td><?php echo h($person['Person']['n/a']); ?>&nbsp;</td>
		<td><?php echo h($person['Person']['created']); ?>&nbsp;</td>
		<td><?php echo h($person['Person']['modified']); ?>&nbsp;</td>
		<td><?php echo h($person['Person']['status']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $person['Person']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $person['Person']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $person['Person']['id']), null, __('Are you sure you want to delete # %s?', $person['Person']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Person'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Xmllistings'), array('controller' => 'xmllistings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Xmllisting'), array('controller' => 'xmllistings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Claims'), array('controller' => 'claims', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Claim'), array('controller' => 'claims', 'action' => 'add')); ?> </li>
	</ul>
</div>
