<div class="payermappings form">
<?php echo $this->Form->create('Payermapping');?>
	<fieldset>
		<legend><?php echo __('Edit Payermapping'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('classification');
		echo $this->Form->input('auth_no_haad');
		echo $this->Form->input('company_name');
		echo $this->Form->input('auth_no_dubai');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Payermapping.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Payermapping.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Payermappings'), array('action' => 'index'));?></li>
	</ul>
</div>
