<div class="observations form">
<?php echo $this->Form->create('Observation');?>
	<fieldset>
		<legend><?php echo __('Admin Edit Observation'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('xmllisting_id');
		echo $this->Form->input('claim_id');
		echo $this->Form->input('type');
		echo $this->Form->input('code');
		echo $this->Form->input('value');
		echo $this->Form->input('valuetype');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Observation.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Observation.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Observations'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Xmllistings'), array('controller' => 'xmllistings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Xmllisting'), array('controller' => 'xmllistings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Claims'), array('controller' => 'claims', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Claim'), array('controller' => 'claims', 'action' => 'add')); ?> </li>
	</ul>
</div>
