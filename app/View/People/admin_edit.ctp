<div class="people form">
<?php echo $this->Form->create('Person');?>
	<fieldset>
		<legend><?php echo __('Admin Edit Person'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('xmllisting_id');
		echo $this->Form->input('claim_id');
		echo $this->Form->input('nationality');
		echo $this->Form->input('birthdate');
		echo $this->Form->input('UUID');
		echo $this->Form->input('visafilenumber');
		echo $this->Form->input('n/a');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Person.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Person.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List People'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Xmllistings'), array('controller' => 'xmllistings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Xmllisting'), array('controller' => 'xmllistings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Claims'), array('controller' => 'claims', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Claim'), array('controller' => 'claims', 'action' => 'add')); ?> </li>
	</ul>
</div>
