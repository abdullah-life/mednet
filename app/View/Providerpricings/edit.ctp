<div class="providerpricings form">
<?php echo $this->Form->create('Providerpricing');?>
	<fieldset>
		<legend><?php echo __('Edit Providerpricing'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('providerdetail_id');
		echo $this->Form->input('code');
		echo $this->Form->input('gross');
		echo $this->Form->input('servicedescription');
		echo $this->Form->input('discount');
		echo $this->Form->input('discountprice');
		echo $this->Form->input('start_date',array('type' => 'date'));
                
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Providerpricing.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Providerpricing.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Providerpricings'), array('action' => 'index'));?></li>
		
	</ul>
</div>
