<div class="dhapricings form">
<?php echo $this->Form->create('Dhapricing',array('type' => 'file')); ?>
	<fieldset>
		<legend><?php echo __('Add Dhapricing'); ?></legend>
	<?php
		echo $this->Form->input('start_date', array('type' => 'date'));
		echo $this->Form->input('activity_type');
		echo $this->Form->input('code');
		echo $this->Form->input('gross');
		echo $this->Form->input('discount');
		echo $this->Form->input('discountprice');
                
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Dhapricings'), array('action' => 'index')); ?></li>
	</ul>
</div>