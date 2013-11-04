<div class="denialcodes form">
<?php echo $this->Form->create('DenialCode',array('enctype' => "multipart/form-data")); ?>
	<fieldset>
		<legend><?php echo __('Add Denial Code'); ?></legend>
	<?php
		echo $this->Form->input('country',array('type' => 'select', 'options' => array(0 => 'HAAD', 1 => 'DHA'),'empty' => 'Select the Provider'));
                echo $this->Form->file('Codes',array('type'=>'file'));
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
