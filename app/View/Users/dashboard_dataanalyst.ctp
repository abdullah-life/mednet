<style>
    .table_holder table tr td{
        border: none !important;
        background: none;
        
    }
    
</style>
<div class="users index">
    <div class="table_top" >
        <span> <?php echo $this->Html->image('users.png'); ?></span><h2><?php echo __('Dashboard'); ?></h2>
    </div>
    <div class="table_holder">
      <table cellpadding="0" cellspacing="0">
           <?php      echo  $this->requestAction(array('controller' => 'batches','action' => 'getpiechart'),array('return')); ?>
          <tr>
              <td width="33%">
                    <div class="post-block">
                        <h1>
                             Batches
                        </h1>
                        <span class="count">  
                         <?php 
                             echo $batchcount;
                        ?>
                            </span>
                     <ul class="linkdash">
                            <?php echo $this->Html->link(__('List Batches'), array('controller'=>'batches','action' => 'listbatchesforDataanalyst'));?>
                     </ul>   
                     </div>
              </td>
              <td width="33%">
                    <div class="post-block">
                        <h1>
                             Claims
                        </h1>
                        <span class="count">  
                         <?php 
                             echo $claimscount;
                        ?>
                            </span>

              </td>
              
              
             
          </tr>  
         
       
      </table>
        
        
        
    </div>
    
    
	
   
</div>

<div class="actions">
	
       <?php     echo $this->element('logo'); ?>
    
	
</div>


