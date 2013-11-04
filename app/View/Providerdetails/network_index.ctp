<div class="providerdetails index">
	<h2><?php echo __('Providerdetails');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('provider_code');?></th>
			<th><?php echo $this->Paginator->sort('display_name');?></th>
			<th><?php echo $this->Paginator->sort('provider_status');?></th>
			<th><?php echo $this->Paginator->sort('facility_name');?></th>
			<th><?php echo $this->Paginator->sort('licence');?></th>
			<th><?php echo $this->Paginator->sort('city');?></th>
			<th><?php echo $this->Paginator->sort('region');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($providerdetails as $providerdetail): ?>
	<tr>
		<td><?php echo h($providerdetail['Providerdetail']['provider_code']); ?>&nbsp;</td>
		<td><?php echo h($providerdetail['Providerdetail']['display_name']); ?>&nbsp;</td>
		<td><?php echo h($providerdetail['Providerdetail']['provider_status']); ?>&nbsp;</td>
		<td><?php echo h($providerdetail['Providerdetail']['facility_name']); ?>&nbsp;</td>
		<td><?php echo h($providerdetail['Providerdetail']['licence']); ?>&nbsp;</td>
		<td><?php echo h($providerdetail['Providerdetail']['city']); ?>&nbsp;</td>
		<td><?php echo h($providerdetail['Providerdetail']['region']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $providerdetail['Providerdetail']['region'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $providerdetail['Providerdetail']['region'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $providerdetail['Providerdetail']['region']), null, __('Are you sure you want to delete # %s?', $providerdetail['Providerdetail']['region'])); ?>
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
		<li><?php echo $this->Html->link(__('New Providerdetail'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Provider Pricing'), array('controller'=>'providerpricings','action' => 'index')); ?></li>
	</ul>
</div>
