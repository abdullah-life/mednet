<div class="haadobservationmappings form">
<?php echo $this->Form->create('Haadobservationmapping',array('type' => 'file')); ?>
	<fieldset>
		<legend><?php echo __('Add Haadobservationmapping'); ?></legend>
	<?php
		echo $this->Form->input('start_date', array('type' => 'date'));
                echo $this->Form->file('Mapping',array('type'=>'file'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Haadobservationmappings'), array('action' => 'index')); ?></li>
	</ul>
</div>
