<div class="mcodes view">
<h2><?php  echo __('Mcode');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($mcode['Mcode']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Codenumber'); ?></dt>
		<dd>
			<?php echo h($mcode['Mcode']['codenumber']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Code 1'); ?></dt>
		<dd>
			<?php echo h($mcode['Mcode']['code_1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Code 2'); ?></dt>
		<dd>
			<?php echo h($mcode['Mcode']['code_2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description 1'); ?></dt>
		<dd>
			<?php echo h($mcode['Mcode']['description_1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description 2'); ?></dt>
		<dd>
			<?php echo h($mcode['Mcode']['description_2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($mcode['Mcode']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($mcode['Mcode']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($mcode['Mcode']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Mcode'), array('action' => 'edit', $mcode['Mcode']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Mcode'), array('action' => 'delete', $mcode['Mcode']['id']), null, __('Are you sure you want to delete # %s?', $mcode['Mcode']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Mcodes'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Mcode'), array('action' => 'add')); ?> </li>
	</ul>
</div>
