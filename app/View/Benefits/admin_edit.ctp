<div class="benefits form">
<?php echo $this->Form->create('Benefit');?>
	<fieldset>
		<legend><?php echo __('Admin Edit Benefit'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('CRITERION_NBR');
		echo $this->Form->input('LOCAL_DESCRIPTION');
		echo $this->Form->input('BENEFIT');
		echo $this->Form->input('TYPE');
		echo $this->Form->input('CODE');
		echo $this->Form->input('LOCAL_DESCRIPTION_1');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Benefit.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Benefit.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Benefits'), array('action' => 'index'));?></li>
	</ul>
</div>
