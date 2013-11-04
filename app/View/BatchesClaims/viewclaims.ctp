<div class="batchesClaims index">
	<h2><?php echo __('Batches Claims');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('batch id');?></th>
			<th><?php echo $this->Paginator->sort('batch name');?></th>
			<th><?php echo $this->Paginator->sort('xmlclaimID');?></th>
			<th><?php echo $this->Paginator->sort('IDPayer');?></th>
			<th><?php echo $this->Paginator->sort('MemberID');?></th>
			<th><?php echo $this->Paginator->sort('PayerID');?></th>
			<th><?php echo $this->Paginator->sort('ProviderID');?></th>
			<th><?php echo $this->Paginator->sort('EmiratesIDNumber');?></th>
			<th><?php echo $this->Paginator->sort('Gross');?></th>
			<th><?php echo $this->Paginator->sort('PatientShare');?></th>
			<th><?php echo $this->Paginator->sort('Net');?></th>
			<th><?php echo $this->Paginator->sort('resubmission status');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($batchesClaims as $batchesClaim): ?>
	<tr>
		<td><?php echo h($batchesClaim['BatchesClaim']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($batchesClaim['Batch']['id'], array('controller' => 'batches', 'action' => 'view', $batchesClaim['Batch']['id'])); ?>
		</td>
		<td>
                    <?php 
                    if(!$batchesClaim['Batch']['name']){
                        $batchname      =   "No name assigned";
                    }else{
                        $batchname      = $batchesClaim['Batch']['name'];
                    }
                    
                    ?>
			<?php echo $this->Html->link($batchname, array('controller' => 'batches', 'action' => 'view', $batchesClaim['Batch']['id'])); ?>
		</td>
		
		<td><?php echo h($batchesClaim['Claim']['xmlclaimID']); ?>&nbsp;</td>
		<td><?php echo h($batchesClaim['Claim']['IDPayer']); ?>&nbsp;</td>
		<td><?php echo h($batchesClaim['Claim']['MemberID']); ?>&nbsp;</td>
		<td><?php echo h($batchesClaim['Claim']['PayerID']); ?>&nbsp;</td>
		<td><?php echo h($batchesClaim['Claim']['ProviderID']); ?>&nbsp;</td>
		<td><?php echo h($batchesClaim['Claim']['EmiratesIDNumber']); ?>&nbsp;</td>
		<td><?php echo h($batchesClaim['Claim']['Gross']); ?>&nbsp;</td>
		<td><?php echo h($batchesClaim['Claim']['PatientShare']); ?>&nbsp;</td>
		<td><?php echo h($batchesClaim['Claim']['Net']); ?>&nbsp;</td>
		<td><?php  if($batchesClaim['Claim']['resubmission']) echo "Resubmission"; else echo "not resubmission"; ?>&nbsp;</td>
		
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $batchesClaim['BatchesClaim']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $batchesClaim['BatchesClaim']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $batchesClaim['BatchesClaim']['id']), null, __('Are you sure you want to delete # %s?', $batchesClaim['BatchesClaim']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Batches Claim'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Batches'), array('controller' => 'batches', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Batch'), array('controller' => 'batches', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Xmllistings'), array('controller' => 'xmllistings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Xmllisting'), array('controller' => 'xmllistings', 'action' => 'add')); ?> </li>
	</ul>
</div>
