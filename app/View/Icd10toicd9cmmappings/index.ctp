<div class="icd10toicd9cmmappings index">
	<h2><?php echo __('Icd10toicd9cmmappings');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('icd_10');?></th>
			<th><?php echo $this->Paginator->sort('icd9_cm');?></th>
			<th><?php echo $this->Paginator->sort('status_code');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('status');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($icd10toicd9cmmappings as $icd10toicd9cmmapping): ?>
	<tr>
		<td><?php echo h($icd10toicd9cmmapping['Icd10toicd9cmmapping']['id']); ?>&nbsp;</td>
		<td><?php echo h($icd10toicd9cmmapping['Icd10toicd9cmmapping']['icd_10']); ?>&nbsp;</td>
		<td><?php echo h($icd10toicd9cmmapping['Icd10toicd9cmmapping']['icd9_cm']); ?>&nbsp;</td>
		<td><?php echo h($icd10toicd9cmmapping['Icd10toicd9cmmapping']['status_code']); ?>&nbsp;</td>
		<td><?php echo h($icd10toicd9cmmapping['Icd10toicd9cmmapping']['created']); ?>&nbsp;</td>
		<td><?php echo h($icd10toicd9cmmapping['Icd10toicd9cmmapping']['modified']); ?>&nbsp;</td>
		<td><?php echo h($icd10toicd9cmmapping['Icd10toicd9cmmapping']['status']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $icd10toicd9cmmapping['Icd10toicd9cmmapping']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $icd10toicd9cmmapping['Icd10toicd9cmmapping']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $icd10toicd9cmmapping['Icd10toicd9cmmapping']['id']), null, __('Are you sure you want to delete # %s?', $icd10toicd9cmmapping['Icd10toicd9cmmapping']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Icd10toicd9cmmapping'), array('action' => 'add')); ?></li>
	</ul>
</div>
