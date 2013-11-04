<div class="newfiles view">
<h2><?php  echo __('Newfile');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($newfile['Newfile']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('FileID'); ?></dt>
		<dd>
			<?php echo h($newfile['Newfile']['FileID']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('FileName'); ?></dt>
		<dd>
			<?php echo h($newfile['Newfile']['FileName']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('SenderID'); ?></dt>
		<dd>
			<?php echo h($newfile['Newfile']['SenderID']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('ReceiverID'); ?></dt>
		<dd>
			<?php echo h($newfile['Newfile']['ReceiverID']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('TransactionDate'); ?></dt>
		<dd>
			<?php echo h($newfile['Newfile']['TransactionDate']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('RecordCount'); ?></dt>
		<dd>
			<?php echo h($newfile['Newfile']['RecordCount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cron Status'); ?></dt>
		<dd>
			<?php echo h($newfile['Newfile']['cron_status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($newfile['Newfile']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($newfile['Newfile']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($newfile['Newfile']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Newfile'), array('action' => 'edit', $newfile['Newfile']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Newfile'), array('action' => 'delete', $newfile['Newfile']['id']), null, __('Are you sure you want to delete # %s?', $newfile['Newfile']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Newfiles'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Newfile'), array('action' => 'add')); ?> </li>
	</ul>
</div>
