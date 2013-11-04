<div class="benefits view">
<h2><?php  echo __('Benefit');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($benefit['Benefit']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('CRITERION NBR'); ?></dt>
		<dd>
			<?php echo h($benefit['Benefit']['CRITERION_NBR']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('LOCAL DESCRIPTION'); ?></dt>
		<dd>
			<?php echo h($benefit['Benefit']['LOCAL_DESCRIPTION']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('BENEFIT'); ?></dt>
		<dd>
			<?php echo h($benefit['Benefit']['BENEFIT']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('TYPE'); ?></dt>
		<dd>
			<?php echo h($benefit['Benefit']['TYPE']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('CODE'); ?></dt>
		<dd>
			<?php echo h($benefit['Benefit']['CODE']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('LOCAL DESCRIPTION 1'); ?></dt>
		<dd>
			<?php echo h($benefit['Benefit']['LOCAL_DESCRIPTION_1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($benefit['Benefit']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($benefit['Benefit']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Benefit'), array('action' => 'edit', $benefit['Benefit']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Benefit'), array('action' => 'delete', $benefit['Benefit']['id']), null, __('Are you sure you want to delete # %s?', $benefit['Benefit']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Benefits'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Benefit'), array('action' => 'add')); ?> </li>
	</ul>
</div>
