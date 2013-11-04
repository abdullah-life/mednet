
<div class="batches form">
<?php echo $this->Form->create('Batch');?>
	<fieldset>
		<legend><?php echo __('Assign To Medical Reviewer'); ?></legend>
	<?php
            	echo $this->Form->hidden('id',array('value'=>$batchdetails['Batch']['id']));
		echo $this->Form->input('User_id',array('type'=>'select','options'=>$medicalreceiver,'empty'=>'Select Medical Reviewer'));
	        echo $this->Form->hidden('MedicalreceiverBatch',array('value'=>$assineddetails['MedicalreceiverBatch']['id']));
                echo $this->Form->input('Batch Name',array('type'=>'text','disabled'=>"disabled",'value'=>$batchdetails['Batch']['name'])); 
		echo $this->Form->hidden('Assign_to',array('value'=>20)); 
    	?>
	</fieldset>
    <?php echo $this->Form->end(__('Click here to assign to medical Reviewer'));?>
    

</div>
<div class="actions">
	 <?php     echo $this->element('logo'); ?>
	
</div>
