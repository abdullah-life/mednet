<div class="users index">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
	<legent>Logs</legent>
	</fieldset>
	<table>
		<tr>
			<th>User</th>
			<th>Action</th>
			<th>Description</th>
		</tr>
		<?php foreach($logs as $log) { ?>
			<tr>
				<td><?php echo $this->requestAction(array('controller' => 'Users','action' => 'getUser/'.$log['Log']['User'])) ?></td>
				<td><?php echo $log['Log']['Header'] ?></td>
				<td><?php echo $log['Log']['Desc'] ?></td>
			</tr>
		<?php } ?>
	</table>
</div>
<div class="actions">
	<?php     echo $this->element('logo'); ?>
    
	<ul>

		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Xmls'), array('controller' => 'xmllistings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Xml'), array('controller' => 'xmllistings', 'action' => 'add')); ?> </li>
	</ul>
</div>
<style>
	legent{
		font-size:22px;
	}
</style>
