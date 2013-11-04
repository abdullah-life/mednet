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
              <td width="25%">
                    <div class="post-block">
                        <h1>
                             Assigned Batches
                        </h1>
                        <span class="count">  
                         <?php 
                             echo $batchcount;
                        ?>
                            </span>
                     <ul class="linkdash">
                            <?php echo $this->Html->link(__('List Batches'), array('controller'=>'batches','action' => 'list_batches_for_claimsprocessor'));?>
                     </ul>   
                     </div>
              </td>
              
              <td width="25%">
                    <div class="post-block">
                        <h1>
                             Assigned Claims
                        </h1>
                        <span class="count">  
                         <?php 
                             echo $batchclaimscount;
                        ?>
                            </span>
                        <ul class="linkdash">
                             <?php //echo $this->Html->link(__('List Claims'), array( 'controller'=>'Claims','action' => 'index'));?>
                            
                        </ul>   
                    </div>
              </td>

<!--              <td width="25%">
                   <div class="post-block">
                        <h1>
                             Batches
                        </h1>
                        <span class="count">  
                         <?php 
                             echo $batchcount2;
                        ?>
                            </span>
                     <ul class="linkdash">
                            <?php echo $this->Html->link(__('List Batches'), array('controller'=>'batches','action' => 'index'));?>
                     </ul>   
                     </div>    
              </td>
            </tr>   
             <tr>
              <td width="25%">
                   <div class="post-block">
                        <h1>
                             XMLS
                        </h1>
                        <span class="count">  
                         <?php 
                             echo $todaysxmlcount;
                        ?>
                            </span>
                        <ul class="linkdash">
                               <?php echo $this->Html->link(__('List xmls'), array('controller'=>'xmllistings','action' => 'index'));?>
                        </ul>   
                       
                       
                       
                     </div>
              </td>

          
          
         
                <td width="25%"> 
                    <div class="post-block">
                        <h1>
                             Claims
                        </h1>
                        <span class="count">  
                         <?php 
                             echo $claimscount;
                        ?>
                            </span>
                        <ul class="linkdash">
                               <?php echo $this->Html->link(__('List Claims'), array( 'controller'=>'Claims','action' => 'index'));?>
                        </ul>   
                    </div> 
                </td>
                
                <td width="25%">
                    <div class="post-block">
                        <h1>
                            DHA Files
                        </h1>
                        <span class="count">  
                         <?php 
                             echo $dhacount;
                        ?>
                            </span>
                     <ul class="linkdash">
                            <?php echo $this->Html->link(__('List DHA files'), array('controller'=>'Xmllistings','action' => 'DHA_index/1'));?>
                     </ul>   
                     </div>
                </td>
               </tr> 
               <tr>
                <td width="25%"> 
                    <div class="post-block">
                        <h1>
                            HAAD Files
                        </h1>
                        <span class="count">  
                         <?php 
                             echo $haadcount;
                        ?>
                            </span>
                        <ul class="linkdash">
                               <?php echo $this->Html->link(__('List HAAD files'), array('controller'=>'Xmllistings','action' => 'DHA_index/2'));?>
                        </ul>   
                     </div>
                </td>
                
                <td width="25%"> 
                    <div class="post-block">
                        <h1>
                            Other Files
                        </h1>
                        <span class="count">  
                         <?php 
                            echo $otherfiles;
                        ?>
                            </span>
                        <ul class="linkdash">
                               <?php echo $this->Html->link(__('List other files'), array( 'controller'=>'xmllistings','action' => 'otherfiles_index'));?>
                        </ul>   
                    </div>
                </td>
                <td width="25%"> 
                    <div class="post-block">
                        <h1>
                            Resubmission Claims
                        </h1>
                        <span class="count">  
                            <?php
                            echo $resubmission;
                            ?>
                        </span>
                        <ul class="linkdash">
                            <?php echo $this->Html->link(__('List Resubmission Claims'), array('controller' => 'Claims', 'action' => 'resubmission_index')); ?>
                        </ul>   
                    </div>
                </td>-->
                </tr>
                <tr>
                <td width="25%"> 
                    <div class="post-block">
                        <h1>
                            Onhold Batches
                        </h1>
                        <span class="count">  
                            <?php
                            echo $onhold;
                            ?>
                        </span>   
                    </div>
                </td>
                </tr>
          


          
        
      </table>
        
        
        
    </div>
    
    
	
   
</div>




<div class="actions">
	
       <?php     echo $this->element('logo'); ?>
    	
</div>
