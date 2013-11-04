
<div class="batches form">
<?php echo $this->Form->create('Batch');?>
	<fieldset>
		<legend><?php echo __('Assign To Claims Manager'); ?></legend>
	<?php
		echo $this->Form->hidden('id',array('value'=>$batchdetails['Batch']['id']));
		echo $this->Form->hidden('ClaimsmanagerBatchid',array('value'=>$assineddetails['ClaimsmanagerBatch']['id']));
                
                echo $this->Form->input('Batch Name',array('type'=>'text','disabled'=>"disabled",'value'=>$batchdetails['Batch']['name'])); 
		echo $this->Form->hidden('Assign_to',array('value'=>16)); 
    	?>
	</fieldset>
    <?php
        if(!$assineddetails['ClaimsmanagerBatch']['group_id']){
    ?>
<?php echo $this->Form->end(__('Click here to assign to claims manager'));?>
    
    <?php
        }else{
            
            echo $this->Form->end(__('Claim has already been assigned to claims Manager'));
            
        }
    ?>
</div>
<div class="actions">
	 <?php     echo $this->element('logo'); ?>
	
</div>
