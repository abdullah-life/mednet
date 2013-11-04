<div class="providerpricingfiles form">
<?php echo $this->Form->create('Providerpricingfile');?>
	<fieldset>
		<legend><?php echo __('Edit Providerpricingfile'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Providerpricing'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Provider Details'), array('controller'=>'providerpricings','action' => 'index')); ?></li>
	</ul>
</div>
