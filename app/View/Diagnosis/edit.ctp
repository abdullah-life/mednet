<div class="diagnosis form">
<?php echo $this->Form->create('Diagnosi');?>
	<fieldset>
		<legend><?php echo __('Edit Diagnosi'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('xmllisting_id');
		echo $this->Form->input('claim_id');
		echo $this->Form->input('Type');
		echo $this->Form->input('Code');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Diagnosi.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Diagnosi.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Diagnosis'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Xmllistings'), array('controller' => 'xmllistings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Xmllisting'), array('controller' => 'xmllistings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Claims'), array('controller' => 'claims', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Claim'), array('controller' => 'claims', 'action' => 'add')); ?> </li>
	</ul>
</div>
