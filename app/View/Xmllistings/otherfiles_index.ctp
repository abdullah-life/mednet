<div class="xmls index">
        <div class="table_top" >
           <span> <?php echo $this->Html->image('users.png'); ?></span><h2><?php echo __('Xmls'); ?></h2>
       </div>
	
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('place'); ?></th>
			<th><?php echo $this->Paginator->sort('xmlstatus'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			
	</tr>
	<?php
        
	foreach ($xmllistings as $xml): ?>
	<tr>
		<td><?php echo h($xml['Xmllisting']['id']); ?>&nbsp;</td>
		<td><?php echo h($xml['Xmllisting']['name']); ?>&nbsp;</td>
		<td><?php  if($xml['Xmllisting']['place']==1) echo "Dubai"; if($xml['Xmllisting']['place']==2) echo "Abu Dhabi"; ?>&nbsp;</td>
		<td><?php if ($xml['Xmllisting']['xmlstatus']==0)
                             echo "Not Processed";
                             else if($xml['Xmllisting']['xmlstatus']==1)
                             echo "Parsed and Saved";   
                             else if($xml['Xmllisting']['xmlstatus']==2)
                             echo "Proessing Complete";   
                             else if($xml['Xmllisting']['xmlstatus']==3)
                             echo "Proessing Failed";   
             
?>&nbsp;</td>
               
		
		<td><?php echo h($xml['Xmllisting']['created']); ?>&nbsp;</td>
		
                
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
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	 <?php     echo $this->element('logo'); ?>
	<ul>
		<li><?php echo $this->Html->link(__('New Xml'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
