
<div class="users index">
    <div class="table_top" >
        <span> <?php echo $this->Html->image('users.png'); ?></span><h2><?php echo __('Users'); ?></h2>
    </div>
	
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('group_id'); ?></th>
			<th><?php echo $this->Paginator->sort('fname'); ?></th>
			<th><?php echo $this->Paginator->sort('lname'); ?></th>
			<th><?php echo $this->Paginator->sort('username'); ?></th>
			
			<th><?php echo $this->Paginator->sort('email'); ?></th>
			
			<th class="actions"><?php echo __('View'); ?></th>
			<th class="actions"><?php echo __('Edit'); ?></th>
			<th class="actions"><?php echo __('Delete'); ?></th>
	</tr>
	<?php
        
        
	foreach ($users as $key=>$user): ?>
	<tr>
		<td><?php  echo $key+1; ?>&nbsp;</td>
		<td>
			<?PHP echo  $this->requestAction(array('controller' => 'groups','action' => 'getname',$user['User']['group_id'])); ?>
		</td>
		<td><?php echo h($user['User']['fname']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['lname']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['username']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['email']); ?>&nbsp;</td>
		
		<td><?php echo $this->Html->link($this->Html->image('view-icon.png'), array('action' => 'view', $user['User']['id']),array('escape'=>FALSE)); ?></td>
		<td><?php echo $this->Html->link($this->Html->image('edit.png'), array('action' => 'edit', $user['User']['id']),array('escape'=>FALSE)); ?></td>
                
		<td><?php echo $this->Form->postLink($this->Html->image('delete.png'), array('action' => 'delete', $user['User']['id']), array('escape'=>FALSE), __('Are you sure you want to delete # %s?', $user['User']['id'])); ?></td>
	</tr>
        
<?php endforeach; ?>
        <tr>
                <td colspan="10">
                <?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>
                </td>
        </tr>
       
        </table>
	
    <div style="width:100%;height:30px;margin:0 auto">
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
    </div>
</div>

<div class="actions id">
	
       <?php     echo $this->element('logo'); ?>
    
	<ul>
		<li>  <span> <?php echo $this->Html->image('users.png'); ?></span><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?></li>
		
		
	</ul>
</div>

