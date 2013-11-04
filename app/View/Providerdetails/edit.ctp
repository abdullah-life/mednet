<div class="providerdetails form">
<?php echo $this->Form->create('Providerdetail');?>
	<fieldset>
		<legend><?php echo __('Edit Providerdetail'); ?></legend>
	<?php
		echo $this->Form->input('code');
		echo $this->Form->input('display_name');
		
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

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Providerdetail.region')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Providerdetail.region'))); ?></li>
		<li><?php echo $this->Html->link(__('List Providerdetails'), array('action' => 'index'));?></li>
	</ul>
</div>
