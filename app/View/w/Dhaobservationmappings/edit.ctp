<div class="dhaobservationmappings form">
<?php echo $this->Form->create('Dhaobservationmapping'); ?>
	<fieldset>
		<legend><?php echo __('Edit Dhaobservationmapping'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('activity_type');
		echo $this->Form->input('activity_code');
		echo $this->Form->input('observation_code');
		echo $this->Form->input('gross_price');
		echo $this->Form->input('description');
		echo $this->Form->input('start_date');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Dhaobservationmapping.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Dhaobservationmapping.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Dhaobservationmappings'), array('action' => 'index')); ?></li>
	</ul>
</div>
