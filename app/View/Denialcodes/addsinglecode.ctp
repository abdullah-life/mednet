<div class="denialcodes form">
<?php echo $this->Form->create('DenialCode'); ?>
	<fieldset>
		<legend><?php echo __('Add Denial Code'); ?></legend>
	<?php
                echo $this->Form->input('Code');
                echo $this->Form->input('Description');
                echo $this->Form->input('Exampledscr');
                echo $this->Form->input('Status');
                echo $this->Form->input('Type');
                echo $this->Form->input('Location',array('type' => 'select','options' => $locations));
                echo $this->Form->input('Effective',array('type' => 'date'));
                echo $this->Form->input('Expiry',array('type' => 'date'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Denialcodes'), array('action' => 'index')); ?></li>
	</ul>
</div>