<div class="providerdetails form">
<?php echo $this->Form->create('Providerdetail');?>
	<fieldset>
		<legend><?php echo __('Add Providerdetail'); ?></legend>
	<?php
		echo $this->Form->input('provider_code');
		echo $this->Form->input('display_name');
		echo $this->Form->input('provider_status');
		echo $this->Form->input('facility_name');
		echo $this->Form->input('licence');
		echo $this->Form->input('city');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Providerdetails'), array('action' => 'index'));?></li>
	</ul>
</div>
