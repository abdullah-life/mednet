<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Edit User'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('group_id');
		echo $this->Form->input('fname');
		echo $this->Form->input('lname');
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->input('email');
		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<?php     echo $this->element('logo'); ?>
	<ul>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
		
	</ul>
</div>
