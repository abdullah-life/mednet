<div class="eopfiles form">
<?php echo $this->Form->create('Eopfile',array('type' => 'file'));?>
	<fieldset>
            <legend><?php echo __('Add Eopfile'); ?></legend>
            <?php
                echo $this->Form->input('eop',array('type'=>'file','Upload Eop file'));
            ?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Eopfiles'), array('controller'=>'eopfiles','action' => 'index'));?></li>
	</ul>
</div>
