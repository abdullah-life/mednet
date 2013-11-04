
<div class="newfiles index">
	<h2><?php echo __('Newfiles');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('FileID');?></th>
			<th><?php echo $this->Paginator->sort('FileName');?></th>
			<th><?php echo $this->Paginator->sort('SenderID');?></th>
			<th><?php echo $this->Paginator->sort('ReceiverID');?></th>
			<th><?php echo $this->Paginator->sort('TransactionDate');?></th>
			<th><?php echo $this->Paginator->sort('RecordCount');?></th>
			
			
	</tr>
	<?php
	foreach ($newfiles as $key => $newfile): ?>
	<tr>
		<td><?php echo h($key+1); ?>&nbsp;</td>
		<td><?php echo h($newfile['Newfile']['FileID']); ?>&nbsp;</td>
		<td><?php echo h($newfile['Newfile']['FileName']); ?>&nbsp;</td>
		<td><?php echo h($newfile['Newfile']['SenderID']); ?>&nbsp;</td>
		<td><?php echo h($newfile['Newfile']['ReceiverID']); ?>&nbsp;</td>
		<td><?php echo h($newfile['Newfile']['TransactionDate']); ?>&nbsp;</td>
		<td><?php echo h($newfile['Newfile']['RecordCount']); ?>&nbsp;</td>
		
		
		
		
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
		<li><?php echo $this->Html->link(__('New Newfile'), array('action' => 'add')); ?></li>
	</ul>
</div>
