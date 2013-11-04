<div class="dhaobservationmappings form">
<?php echo $this->Form->create('Dhaobservationmapping',array('type' => 'file')); ?>
	<fieldset>
		<legend><?php echo __('Add Dhaobservationmapping'); ?></legend>
	<?php
		echo $this->Form->input('start_date', array('type' => 'date'));
                echo $this->Form->input('activity_type');
                echo $this->Form->input('activity_code');
                echo $this->Form->input('observation_code');
                echo $this->Form->input('gross_price');
                echo $this->Form->input('description');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Dhaobservationmappings'), array('action' => 'index')); ?></li>
	</ul>
</div>
