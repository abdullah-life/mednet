
<div class="batches form">
<?php echo $this->Form->create('Batch');?>
	<fieldset>
		<legend><?php echo __('Assign To Claims Processor'); ?></legend>
	<?php
		echo $this->Form->hidden('id',array('value'=>$batchdetails['Batch']['id']));
		echo $this->Form->input('User_id',array('type'=>'select','options'=>$claimsProcessors,'empty'=>'Select Claim Processor','default'=>$selected));
	        echo $this->Form->hidden('ClaimsprocessorBatchid',array('value'=>$assineddetails['ClaimsprocessorBatch']['id']));
                echo $this->Form->input('Batch Name',array('type'=>'text','disabled'=>"disabled",'value'=>$batchdetails['Batch']['name'])); 
		echo $this->Form->hidden('Assign_to',array('value'=>17)); 
    	?>
	</fieldset>
    <?php
        if(!isset($assineddetails['ClaimsprocessorBatch']['group_id'])){
    ?>
<?php echo $this->Form->end(__('Click here to assign to claims Processor'));?>
    
    <?php
        }else{
            
            echo $this->Form->end(__('Claim has already been assigned to claims Processor'));
            
        }
    ?>
</div>
<div class="actions">
	 <?php     echo $this->element('logo'); ?>
	
</div>
