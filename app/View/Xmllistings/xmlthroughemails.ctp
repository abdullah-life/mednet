
<div class="index">
    <?php echo $this->Form->create('emailxmls',array('type' => 'file'));?>
    <fieldset>
		<legend><?php echo __('Add received Email XML'); ?></legend>
	<?php
		echo $this->Form->input('Location',array('type' => 'select','options' => $place,'class' => 'providerids'));
		echo $this->Form->input('xmls',array('type'=>'file'));
                
	?>
	</fieldset>
    <?php echo $this->Form->end(__('Submit'));?>
</div>
