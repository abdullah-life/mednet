<div class="benefitsTests form">
<?php echo $this->Form->create('BenefitsTest');?>
	<fieldset>
		<legend><?php echo __('Add Benefits Test'); ?></legend>
	<?php
		echo $this->Form->input('CRITERION_NBR');
		echo $this->Form->input('LOCAL_DESCRIPTION');
		echo $this->Form->input('BENEFIT');
		echo $this->Form->input('TYPE');
		echo $this->Form->input('CODE');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Benefits Tests'), array('action' => 'index'));?></li>
	</ul>
</div>
