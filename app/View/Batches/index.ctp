<?php
   if($batches!="error"){
    $this->Paginator->options(array(
    'update' => '#content',
    'evalScripts' => true,
     'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
     'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),   
  ));
 }
?>
<style>
.searchbatch tr td
{
    background-color: #E9E9E9;
}
</style>

<div class="batches index">

   
	<h2><?php echo __('Batches');?></h2>
        <div>
             <div id="searchbox">
                <table cellpadding="0" cellspacing="0" class="searchbatch">
                    <tr>
                        <?php echo $this->Form->create('Search');?>
                                
			<td><php <?php echo $this->Form->input('provider_code',$this->Session->read('provider_code'));?></td>
			<td><?php echo $this->Form->input('License',$this->Session->read('License'));?></td>
			<td><?php echo $this->Form->input('Name',$this->Session->read('Name'));?></td>
                        <?php $this->Form->end('Submit')?>
                    </tr>
                    <tr>
                        <td colspan="3" style="background-color: ">
                            <?php echo $this->Form->end(__('Submit'));?>
                        </td>
                    </tr>
                </table>
                
            </div>
        <?php
              echo $this->element('statustile');
        ?>
        </div>
        <div class="batchestable">
           
	<table cellpadding="0" cellspacing="0">
        
        <tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
                        <th width="30%"><?php echo"MedNet Provider Code"?></th>
                        <th width="30%"><?php echo"Provider Name"?></th>
                        <th width="30%"><?php echo $this->Paginator->sort('provider_id','Provider License');?></th>
                        <th width="30%"><?php echo $this->Paginator->sort('name','Batch Number');?></th>
			<th width="30%"><?php echo"Claim Count"?></th>
                        <th width="30%"><?php echo $this->Paginator->sort('created','created');?></th>
			<?php
                         if($this->Session->read('Auth.User.group_id')==15){
                        ?>
			<th class="actions"><?php echo __('Assign to  Claims Manager');?></th>
		        <?php
                         }
			
                         if($this->Session->read('Auth.User.group_id')==16){
                        ?>
			<th class="actions"><?php echo __('Assign to  Claims Processor');?></th>
			
                        <?php
                         }
                         
                        if(!$this->Session->read('Auth.User.group_id')==5){
                        ?>
                        <th class="actions"><?php echo __('View XMLs');?></th>
                        <th class="actions"><?php echo __('Download XMl');?></th>
                        <?php
                         }
                        ?>
	</tr>
	<?php
	foreach ($batches as $key=>$batch): ?>
       
            <?php
            $batchstatus         =   $this->requestAction(array('controller'=>'batches','action'=>'getstatus', $batch['Batch']['id']));
            ?>
	<tr class="<?php echo  $batchstatus; ?>">
		<td><?php echo $key+1; ?>&nbsp;</td>

                <td>
                   <?php
                        echo $this->requestAction(array('controller' => 'Providerdetails','action' => 'getproidermednetcode',$batch['Batch']['provider_id']));
                   ?>
                </td>
                <td>
                   <?php
                        echo $this->requestAction(array('controller' => 'Providerdetails','action' => 'getproidername',$batch['Batch']['provider_id']));
                   ?>
                </td>
                <td><?php
                    if(isset($batch['Batch']['resubmission']))
                    {
                        echo h($batch['Batch']['provider_id'].' (R)');
                    }
                    else
                    {
                        echo h($batch['Batch']['provider_id']);
                    }
                ?>&nbsp;
                </td>
                <td><?php if(isset($batch['Batch']['name'])) echo h($batch['Batch']['name']);  else{ echo "batch not named";}?>&nbsp;</td>
		
		<td>
                   <?php
                        echo $this->requestAction(array('controller' => 'batches','action' => 'getclaimcountforbatch',$batch['Batch']['id']));
                   ?>
                </td>
                <td>
                    <?php echo date('Y-m-d H:i:s', $batch['Batch']['created']->sec); ?>&nbsp;
                    
                </td>
		<?php
                    if($this->Session->read('Auth.User.group_id')==15){
                   ?>
		<td>
                        <?php echo $this->requestAction(array('controller' => 'Batches','action'=> 'getStatusvalue',$batch['Batch']['status'],'assign.png','Batches','Assign_to_claims_manager/'.$batch['Batch']['id'],$batch['Batch']['id']));
                                   // echo $this->Html->link($this->Html->image('assign.png',array('title'=>'view xmldetails')), array('controller'=>'Batches','action' => 'Assign_to_claims_manager', $batch['Batch']['id']),array('escape'=>FALSE));
           
                        ?>
                </td> 
                 <?php
                    }
		
                    if($this->Session->read('Auth.User.group_id')==16){
                   ?>
		<td>
			<?php echo $this->Html->link($this->Html->image('assign.png',array('title'=>'view xmldetails')), array('controller'=>'Batches','action' => 'Assign_to_claims_processor', $batch['Batch']['id']),array('escape'=>FALSE)); ?>
                </td> 
                 <?php
                    }
                         
                         if(!$this->Session->read('Auth.User.group_id')==5){
                        ?>
                <td>
			<?php echo $this->Html->link($this->Html->image('view-icon.png',array('title'=>'view xmldetails')), array('controller'=>'BatchesClaims','action' => 'viewclaims', $batch['Batch']['id']),array('escape'=>FALSE)); ?>
                </td> 
                 <td>
                     <?php $trimmeddate              =         trim(date("Ymd"));?>
                     <a href="./files/batch/<?php echo $trimmeddate.'/batch_id_'.$batch['Batch']['provider_id'].'_files.zip'?>">Download</a>
                 </td>
                 <?php
                         }
                 ?>
                 
	</tr>
<?php endforeach; ?>
	</table>
        </div>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<script type="text/javascript" src="https://raw.github.com/webpop/jquery.pin/gh-pages/jquery.pin.js"></script>
<script type="text/javascript">
//     $(document).ready(function(){
//        $(".batchestable").scroll(function(e) {
//         
////         $('.batchestable tr').eq(0).css({
////              position:'absolute',
////              'background-color':'red',
////              'float':'left',
////          })
////            
//        });
//       
//     });

</script>

<div class="actions">
 <?php     echo $this->element('logo'); ?>
    <ul>
        <li><?php echo $this->Html->link('List Batches', array('controller'=>'Batches','action' => 'index')); ?> </li>
    </ul>
    
</div>

<?php
    echo $this->Js->writeBuffer();
?>
