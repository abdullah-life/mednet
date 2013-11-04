<div class="headers form">
<?php echo $this->Form->create('Header');?>
	<fieldset>
		<legend><?php echo __('Edit Header'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('xmllisting_id');
		echo $this->Form->input('SenderID');
		echo $this->Form->input('ReceiverID');
		echo $this->Form->input('TransactionDate');
		echo $this->Form->input('RecordCount');
		echo $this->Form->input('DispositionFlag');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Header.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Header.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Headers'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Xmllistings'), array('controller' => 'xmllistings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Xmllisting'), array('controller' => 'xmllistings', 'action' => 'add')); ?> </li>
	</ul>
</div>
