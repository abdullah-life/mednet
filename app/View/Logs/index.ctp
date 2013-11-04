<div class="index">
	<h1>Logs</h1>
	<?php echo $this->Form->Create('logs');?>
		<table style="width:700px;" >
			<tr>
				<td width="30%">
					<?php echo $this->Form->input('user',array('class' => 'combo','type' => 'select','options' => $users,'default' => $this->Session->read('Log_user'),'empty' => 'Select User'));?>
				</td>
			</tr>
			<tr>
				<td><?php echo $this->Form->end('Submit'); ?>
</td>
			</tr>
		</table>	
	<table>
		<tr>
			<th>User</th>
			<th>Action</th>
			<th>Description</th>
		</tr>
		<?php foreach($logs as $log){ ?>
			<tr>
				<td><?php echo $this->requestAction(array('Controller' => "Logs","action" => "getUser/".$log['Log']['User']));?></td>
				<td><?php echo $log['Log']['Header'];?></td>
				<td><?php echo  $log['Log']['Desc'];?></td>
			</tr>
		<?php } ?>
	</table>
</div>
<div class="actions">
</div>
<style>
	.index h1{
		font-size:23px;
	}
</style>
