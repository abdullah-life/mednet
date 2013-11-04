
	<table cellpadding="0" cellspacing="0">
	<tr>
                <th><?php echo $this->Paginator->sort('id');?></th>
                <th><?php echo $this->Paginator->sort('xmllisting_id');?></th>
                <th><?php echo $this->Paginator->sort('claim_id');?></th>
                <th><?php echo $this->Paginator->sort('activity_id');?></th>
                <th><?php echo $this->Paginator->sort('start');?></th>
                <th><?php echo $this->Paginator->sort('Type');?></th>
                <th><?php echo $this->Paginator->sort('Code');?></th>
                <th><?php echo $this->Paginator->sort('Quantity');?></th>
                <th><?php echo $this->Paginator->sort('Net');?></th>
                <th><?php echo $this->Paginator->sort('Clinician');?></th>
                <th><?php echo $this->Paginator->sort('PriorAuthorizationID');?></th>
                <th><?php echo $this->Paginator->sort('created');?></th>
                <th><?php echo $this->Paginator->sort('modified');?></th>
                <th><?php echo $this->Paginator->sort('status');?></th>
                <th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($activities as $activity): ?>
	<tr>
		<td><?php echo h($activity['Activity']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($activity['Xmllisting']['name'], array('controller' => 'xmllistings', 'action' => 'view', $activity['Xmllisting']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($activity['Claim']['id'], array('controller' => 'claims', 'action' => 'view', $activity['Claim']['id'])); ?>
		</td>
		<td><?php echo h($activity['Activity']['activity_id']); ?>&nbsp;</td>
		<td><?php echo h($activity['Activity']['start']); ?>&nbsp;</td>
		<td><?php echo h($activity['Activity']['Type']); ?>&nbsp;</td>
		<td><?php echo h($activity['Activity']['Code']); ?>&nbsp;</td>
		<td><?php echo h($activity['Activity']['Quantity']); ?>&nbsp;</td>
		<td><?php echo h($activity['Activity']['Net']); ?>&nbsp;</td>
		<td><?php echo h($activity['Activity']['Clinician']); ?>&nbsp;</td>
		<td><?php echo h($activity['Activity']['PriorAuthorizationID']); ?>&nbsp;</td>
		<td><?php echo h($activity['Activity']['created']); ?>&nbsp;</td>
		<td><?php echo h($activity['Activity']['modified']); ?>&nbsp;</td>
		<td><?php echo h($activity['Activity']['status']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $activity['Activity']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $activity['Activity']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $activity['Activity']['id']), null, __('Are you sure you want to delete # %s?', $activity['Activity']['id'])); ?>
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
	