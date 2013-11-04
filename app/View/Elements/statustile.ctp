

        <table border="0">
            <tr>
                <td>
                    
                        <div class="tabbed_view">
                             <ul>  
                                    <li <?php if($item===null) echo 'class="active"'; else echo 'class="inactive"'; ?>><center> <?php echo '<div class="box"></div>'.$this->Html->link('List All Claims', array(''), array('title' => 'List All')); ?></center></li>  
                                    <?php
                                             if($this->Session->read('Auth.User.group_id')==15){
                                                 ?>
                                        <li <?php if($item==0 && $item!=null) echo 'class="active"'; else echo 'class="inactive"'; ?>>
                                            <?php
                                            echo '<div class="box" style="background-color:#F9F9F9"></div>'.$this->Html->link('Unnamed Batches', array('0'), array('title' => 'Unnamed batches'));
                                            ?>
                                        </li >
                                         <?php
                                            }
                                            ?>
                                        <?php
                                            if($this->Session->read('Auth.User.group_id')==15){
                                        ?>

                                        <?php
                                            }
                                        if($this->Session->read('Auth.User.group_id')==15 OR  $this->Session->read('Auth.User.group_id')==16){
                                        ?>
                                        <li <?php if($item==2) echo 'class="active"'; else echo 'class="inactive"';?>>
                                            <?php
                                            echo '<div class="box" style="background-color:#B6D0DD"></div>'.$this->Html->link('Assigned', array('2'), array('title' => 'Batch assigned to claims manager'));
                                            ?>
                                        </li >
                                        <?php
                                        }
                                        if($this->Session->read('Auth.User.group_id')==16 OR $this->Session->read('Auth.User.group_id')==17){
                                        ?>
                                        <li <?php if($item==3) echo 'class="active"'; else echo 'class="inactive"'; ?>>
                                            <?php
                                            echo '<div class="box" style="background-color:#FBD7FB"></div>'.$this->Html->link(' ClaimsProcessor', array('3'), array('title' => 'Batch assigned to Process manager'));
                                            ?>
                                        </li >
                                        <?php
                                        }
                                       if($this->Session->read('Auth.User.group_id')==16 OR $this->Session->read('Auth.User.group_id')==17){

                                        ?>
                                        <li <?php if($item==6) echo 'class="active"'; else echo 'class="inactive"'; ?>>
                                            <?php
                                            echo '<div class="box" style="background-color:#F5E5A9"></div>'.$this->Html->link('Successfully Processed', array('6'), array('title' => 'Successfully processed'));
                                            ?>
                                        </li>
                                        <?php
                                       }
                                        if($this->Session->read('Auth.User.group_id')==16 OR $this->Session->read('Auth.User.group_id')==17){

                                        ?>
                                        <li <?php if($item==5) echo 'class="active"'; else echo 'class="inactive"'; ?>>

                                            <?php
                                            echo '<div class="box" style="background-color: rgb(253,62,47)"></div>'.$this->Html->link('On Hold', array('5'), array('title' => 'On Hold'));
                                            ?>
                                        </li>
                                        <?php
                                        }
                                        if($this->Session->read('Auth.User.group_id')==17){
                                        ?>
                                        <li <?php if($item==7) echo 'class="active"'; else echo 'class="inactive"'; ?>>

                                            <?php
                                            echo '<div class="box" style="background-color:#E09485"></div>'.$this->Html->link('Downloaded for processing', array('7'), array('title' => 'Downloaded for processing'));
                                            ?>
                                        </li>
                                        <?php
                                         }
                                          if($this->Session->read('Auth.User.group_id')==17 OR $this->Session->read('Auth.User.group_id')==19 OR $this->Session->read('Auth.User.group_id')==16){
                                        ?>
                                        <li <?php if($item==4) echo 'class="active"'; else echo 'class="inactive"'; ?>>

                                            <?php
                                            echo '<div class="box" style="background-color:rgb(158,189,95)"></div>'.$this->Html->link('Medical Manager', array('4'), array('title' => 'Medical Manager'));
                                            ?>
                                        </li>
                                        <?php
                                          }
                                      if($this->Session->read('Auth.User.group_id')==17 OR $this->Session->read('Auth.User.group_id')==19 OR $this->Session->read('Auth.User.group_id')==16){

                                        ?>
                                        <li <?php if($item==8) echo 'class="active"'; else echo 'class="inactive"'; ?>>
                                            <?php
                                            echo '<div class="box" style="background-color:#EED8DA"></div>'.$this->Html->link('Medical Reviewer', array('8'), array('title' => 'Medical Receiver'));
                                            ?>
                                        </li>
                                        <?php
                                      }
                                      if($this->Session->read('Auth.User.group_id')==16){

                                        ?>
                                        <li <?php if($item==10) echo 'class="active"'; else echo 'class="inactive"'; ?>>
                                            <?php
                                            echo '<div class="box" style="background-color:#cfcfcf"></div>'.$this->Html->link('Reviewed by Medical Department', array('10'), array('title' => 'Assigned Back to Claimsmanager'));
                                            ?>
                                        </li>
                                        <?php

                                      }
                                      if($this->Session->read('Auth.User.group_id')==20){

                                        ?>
                                        <li <?php if($item==8) echo 'class="active"'; else echo 'class="inactive"'; ?>>
                                            <?php
                                            echo '<div class="box" style="background-color:#cfcfcf"></div>'.$this->Html->link('MedicalReviewer', array('8'), array('title' => 'MedicalReviewer'));
                                            ?>
                                        </li>
                                        <?php

                                      }
                                           ?>

                                </ul> 
                        </div>
                    
                    
                </td>
                
            </tr>
            
        </table>
