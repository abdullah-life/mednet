<div class="mcodes form">
<?php echo $this->Form->create('Mcode');?>
	<fieldset>
		<legend><?php echo __('Admin Edit Mcode'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('codenumber');
		echo $this->Form->input('code_1');
		echo $this->Form->input('code_2');
		echo $this->Form->input('description_1');
		echo $this->Form->input('description_2');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Mcode.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Mcode.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Mcodes'), array('action' => 'index'));?></li>
	</ul>
</div>
