<div class="batchesClaims view">
<h2><?php  echo __('Batches Claim');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($batchesClaim['BatchesClaim']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Batch'); ?></dt>
		<dd>
			<?php echo $this->Html->link($batchesClaim['Batch']['name'], array('controller' => 'batches', 'action' => 'view', $batchesClaim['Batch']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Xmllisting'); ?></dt>
		<dd>
			<?php echo $this->Html->link($batchesClaim['Xmllisting']['name'], array('controller' => 'xmllistings', 'action' => 'view', $batchesClaim['Xmllisting']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($batchesClaim['BatchesClaim']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($batchesClaim['BatchesClaim']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($batchesClaim['BatchesClaim']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Batches Claim'), array('action' => 'edit', $batchesClaim['BatchesClaim']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Batches Claim'), array('action' => 'delete', $batchesClaim['BatchesClaim']['id']), null, __('Are you sure you want to delete # %s?', $batchesClaim['BatchesClaim']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Batches Claims'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Batches Claim'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Batches'), array('controller' => 'batches', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Batch'), array('controller' => 'batches', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Xmllistings'), array('controller' => 'xmllistings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Xmllisting'), array('controller' => 'xmllistings', 'action' => 'add')); ?> </li>
	</ul>
</div>
