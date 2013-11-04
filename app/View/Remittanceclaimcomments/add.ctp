<div class="remittanceclaimcomments form">
<?php echo $this->Form->create('Remittanceclaimcomment');?>
	<fieldset>
		<legend><?php echo __('Add Remittanceclaimcomment'); ?></legend>
	<?php
		echo $this->Form->input('comment');
		echo $this->Form->input('description');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Remittanceclaimcomments'), array('action' => 'index'));?></li>
	</ul>
</div>
