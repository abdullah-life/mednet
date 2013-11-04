<div class="providerpricingfiles form">
<?php echo $this->Form->create('Providerpricingfile');?>
	<fieldset>
		<legend><?php echo __('Add Providerpricingfile'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Providerpricingfiles'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Providerpricings'), array('controller' => 'providerpricings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Providerpricing'), array('controller' => 'providerpricings', 'action' => 'add')); ?> </li>
	</ul>
</div>
