<div class="dhapricings form">
<?php echo $this->Form->create('Dhapricing'); ?>
	<fieldset>
		<legend><?php echo __('Edit Dhapricing'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('providerdetail_id');
		echo $this->Form->input('start_date');
		echo $this->Form->input('name');
		echo $this->Form->input('url');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Dhapricing.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Dhapricing.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Dhapricings'), array('action' => 'index')); ?></li>
	</ul>
</div>
