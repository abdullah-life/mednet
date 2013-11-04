<div class="remittanceclaimcomments view">
<h2><?php  echo __('Remittanceclaimcomment');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($remittanceclaimcomment['Remittanceclaimcomment']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Comment'); ?></dt>
		<dd>
			<?php echo h($remittanceclaimcomment['Remittanceclaimcomment']['comment']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($remittanceclaimcomment['Remittanceclaimcomment']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($remittanceclaimcomment['Remittanceclaimcomment']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modfied'); ?></dt>
		<dd>
			<?php echo h($remittanceclaimcomment['Remittanceclaimcomment']['modfied']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($remittanceclaimcomment['Remittanceclaimcomment']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Remittanceclaimcomment'), array('action' => 'edit', $remittanceclaimcomment['Remittanceclaimcomment']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Remittanceclaimcomment'), array('action' => 'delete', $remittanceclaimcomment['Remittanceclaimcomment']['id']), null, __('Are you sure you want to delete # %s?', $remittanceclaimcomment['Remittanceclaimcomment']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Remittanceclaimcomments'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Remittanceclaimcomment'), array('action' => 'add')); ?> </li>
	</ul>
</div>
