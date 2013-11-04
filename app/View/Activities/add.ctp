<div class="activities form">
<?php echo $this->Form->create('Activity');?>
	<fieldset>
		<legend><?php echo __('Add Activity'); ?></legend>
	<?php
		echo $this->Form->input('xmllisting_id');
		echo $this->Form->input('claim_id');
		echo $this->Form->input('activity_id');
		echo $this->Form->input('start');
		echo $this->Form->input('Type');
		echo $this->Form->input('Code');
		echo $this->Form->input('Quantity');
		echo $this->Form->input('Net');
		echo $this->Form->input('Clinician');
		echo $this->Form->input('PriorAuthorizationID');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Activities'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Xmllistings'), array('controller' => 'xmllistings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Xmllisting'), array('controller' => 'xmllistings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Claims'), array('controller' => 'claims', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Claim'), array('controller' => 'claims', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Observations'), array('controller' => 'observations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Observation'), array('controller' => 'observations', 'action' => 'add')); ?> </li>
	</ul>
</div>
