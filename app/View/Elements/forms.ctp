<li>
                <?php echo $this->Html->link(__('Forms', true), array('controller' => 'forms','action'=>'index')); ?>
		<ul>
                    <li><?php echo $this->Html->link(__('View', true), array('controller' => 'forms','action'=>'index')); ?></li>
                    <li><?php echo $this->Html->link(__('Add', true), array('controller' => 'forms','action'=>'add')); ?></li>
                    
                </ul>
              </li>    
              <li><?php echo $this->Html->link(__('Form Fields', true), array('controller' => 'form_fields','action'=>'index')); ?>
                    <ul>
                    
                    <li><?php echo $this->Html->link(__('Add', true), array('controller' => 'form_fields','action'=>'add')); ?></li>
                    
                </ul>
              </li>
              <li><?php echo $this->Html->link(__('Form Tabs', true), array('controller' => 'form_tabs','action'=>'index')); ?>
                    <ul>
                    <li><?php echo $this->Html->link(__('View', true), array('controller' => 'form_tabs','action'=>'index')); ?></li>
                    <li><?php echo $this->Html->link(__('Add', true), array('controller' => 'form_tabs','action'=>'add')); ?></li>
                   
                </ul>
              </li>
              
<!--               <li><?php echo $this->Html->link(__('State', true), array('controller' => 'states','action'=>'index')); ?></li>
                <li><?php echo $this->Html->link(__('City', true), array('controller' => 'cities','action'=>'index')); ?></li>
                
                <li>
			<?php echo $this->Html->link('Manage Users', array('controller' => 'Users','action'=>'index')); ?>
			<ul>
				<li><?php echo $this->Html->link('List All', array('controller' => 'Users','action'=>'index')); ?></li>
				<li><?php echo $this->Html->link('Add', array('controller' => 'Users','action'=>'add')); ?></li>
				
				
			</ul>
		</li>
                -->