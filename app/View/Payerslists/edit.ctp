<div class="payerslists form">
<?php echo $this->Form->create('Payerslist'); ?>
	<fieldset>
		<legend><?php echo __('Edit Payerslist'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('insurance_company');
		echo $this->Form->input('eclaimlinkid');
		echo $this->Form->input('haad');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Payerslist.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Payerslist.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Payerslists'), array('action' => 'index')); ?></li>
	</ul>
</div>
