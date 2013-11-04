<div class="xmls view">
<h2 style="width:100%;clear:right"><?php  echo __('Xml'); ?></h2>

<br/>
	<dl style="float:left;">
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($xmllisting['Xmllisting']['id']); ?>
			&nbsp;
		</dd>
		
		
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($xmllisting['Xmllisting']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Xmlstatus'); ?></dt>
		<dd>
			<?php if ($xml['Xmllisting']['xmlstatus']==0)
                             echo "Not Processed";
                             else if($xml['Xmllisting']['xmlstatus']==1)
                             echo "Under Proessing";   
                             else if($xml['Xmllisting']['xmlstatus']==2)
                             echo "Proessing Complete";   
                             else if($xml['Xmllisting']['xmlstatus']==3)
                             echo "Proessing Failed";   ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($xmllisting['Xmllisting']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($xmllisting['Xmllisting']['modified']); ?>
			&nbsp;
		</dd>
		
	</dl>
</div>
<div class="actions">
	<?php     echo $this->element('logo'); ?>
	<ul>
		<li><?php echo $this->Html->link(__('List Xmls'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Xml'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		
	</ul>
</div>
