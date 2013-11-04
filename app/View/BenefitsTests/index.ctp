<div class="benefitsTests index">
	<h2><?php echo __('Benefits Tests');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('CRITERION_NBR');?></th>
			<th><?php echo $this->Paginator->sort('LOCAL_DESCRIPTION');?></th>
			<th><?php echo $this->Paginator->sort('BENEFIT');?></th>
			<th><?php echo $this->Paginator->sort('TYPE');?></th>
			<th><?php echo $this->Paginator->sort('CODE');?></th>
			<th><?php echo $this->Paginator->sort('LOCAL_DESCRIPTION_1');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($benefitsTests as $benefitsTest): ?>
	<tr>
		<td><?php echo h($benefitsTest['BenefitsTest']['CRITERION_NBR']); ?>&nbsp;</td>
		<td><?php echo h($benefitsTest['BenefitsTest']['LOCAL_DESCRIPTION']); ?>&nbsp;</td>
		<td><?php echo h($benefitsTest['BenefitsTest']['BENEFIT']); ?>&nbsp;</td>
		<td><?php echo h($benefitsTest['BenefitsTest']['TYPE']); ?>&nbsp;</td>
		<td><?php echo h($benefitsTest['BenefitsTest']['CODE']); ?>&nbsp;</td>
		<td><?php echo h($benefitsTest['BenefitsTest']['LOCAL_DESCRIPTION_1']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $benefitsTest['BenefitsTest']['LOCAL_DESCRIPTION_1'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $benefitsTest['BenefitsTest']['LOCAL_DESCRIPTION_1'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $benefitsTest['BenefitsTest']['LOCAL_DESCRIPTION_1']), null, __('Are you sure you want to delete # %s?', $benefitsTest['BenefitsTest']['LOCAL_DESCRIPTION_1'])); ?>
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
		<li><?php echo $this->Html->link(__('New Benefits Test'), array('action' => 'add')); ?></li>
	</ul>
</div>
