<div class="newfiles form">
<?php echo $this->Form->create('Newfile');?>
	<fieldset>
		<legend><?php echo __('Admin Add Newfile'); ?></legend>
	<?php
		echo $this->Form->input('FileID');
		echo $this->Form->input('FileName');
		echo $this->Form->input('SenderID');
		echo $this->Form->input('ReceiverID');
		echo $this->Form->input('TransactionDate');
		echo $this->Form->input('RecordCount');
		echo $this->Form->input('cron_status');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Newfiles'), array('action' => 'index'));?></li>
	</ul>
</div>
