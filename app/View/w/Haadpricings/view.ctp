<div class="haadpricings view">
<h2><?php  echo __('Haadpricing'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($haadpricing['Haadpricing']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Providerdetail Id'); ?></dt>
		<dd>
			<?php echo h($haadpricing['Haadpricing']['providerdetail_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Start Date'); ?></dt>
		<dd>
			<?php echo h($haadpricing['Haadpricing']['start_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($haadpricing['Haadpricing']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Url'); ?></dt>
		<dd>
			<?php echo h($haadpricing['Haadpricing']['url']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($haadpricing['Haadpricing']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($haadpricing['Haadpricing']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($haadpricing['Haadpricing']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Haadpricing'), array('action' => 'edit', $haadpricing['Haadpricing']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Haadpricing'), array('action' => 'delete', $haadpricing['Haadpricing']['id']), null, __('Are you sure you want to delete # %s?', $haadpricing['Haadpricing']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Haadpricings'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Haadpricing'), array('action' => 'add')); ?> </li>
	</ul>
</div>
