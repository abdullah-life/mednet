<div class="providerpricings form" >
<?php echo $this->Form->create('Providerpricing' ,array('type' => 'file'));?>
	<fieldset>
		<legend><?php echo __('Add Provider details'); ?></legend>
	<?php
		echo $this->Form->input('details',array('type'=>'file'));
                
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<!--<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Providerpricings'), array('action' => 'index'));?></li>
		
	</ul>
</div>-->
