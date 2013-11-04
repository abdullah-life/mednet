<div class="resubmissions form">
<?php echo $this->Form->create('Resubmission');?>
	<fieldset>
		<legend><?php echo __('Admin Add Resubmission'); ?></legend>
	<?php
		echo $this->Form->input('claim_id');
		echo $this->Form->input('Type');
		echo $this->Form->input('Comment');
		echo $this->Form->input('Attachment');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Resubmissions'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Claims'), array('controller' => 'claims', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Claim'), array('controller' => 'claims', 'action' => 'add')); ?> </li>
	</ul>
</div>
