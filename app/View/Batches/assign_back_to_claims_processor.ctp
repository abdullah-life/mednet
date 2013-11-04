<div class="batches form">
<?php echo $this->Form->create('Batch');

?>
	<fieldset>
		<legend><?php echo __('Assign To Claims Processor'); ?></legend>
	<?php
            	echo $this->Form->hidden('id',array('value'=>$id));
		echo $this->Form->input('comment',array('value'=> $comment['BatchComment']['comment']));
    	?>
           
	</fieldset>
    <?php echo $this->Form->end(__('Click here to assign back to claims Processor'));?>
    

</div>
<div class="actions">
	 <?php     echo $this->element('logo'); ?>
	
</div>
