<?php 
     echo $this->Html->script(array('jquery.filedrop'));
?>


<div class="xmls form">
    
        
   
<?php echo $this->Form->create('Xmllisting',array('type'=>'file')); ?>
	<fieldset>
		
	<?php
		//echo $this->Form->input('name');
		//echo $this->Form->input('place',array('options'=>array( ''=>'Choose location', '1'=>'dubai','2'=>'abudabi')));
		//echo $this->Form->input('cron_time',array('label'=>'Process Time','options'=>array('0'=>'Now', '1'=>'2 hours from now','2'=>'4 hours from now','3'=>'6 hours from now','4'=>'8 hours from now' )));
		//echo $this->Form->input('xml_url',array('label'=>'Upload','type'=>'file'));
                
	?>
                
	</fieldset>
<?php echo $this->Form->end(__('PICK XML')); ?>
    
</div>
<div class="actions">
         <?php     echo $this->element('logo'); ?>
        <ul>

		<li><?php echo $this->Html->link(__('List Xmls'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
