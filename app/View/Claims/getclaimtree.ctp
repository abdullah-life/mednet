<style>
    #xmldetails{
        display: block;
    font-family: 'BenchNine',sans-serif;
    font-size: 15px;
    letter-spacing: 1px;
    line-height: 31px;
    list-style-type: none;
    text-align: left;
    text-transform: uppercase;
    white-space: nowrap;
  
    }
    
    
</style>
<?php 

    
?>
<link rel="stylesheet" href="<?php echo  Router::url('/', true) ?>/css/jquery.treeview.css" />
<link rel="stylesheet" href="<?php echo  Router::url('/', true) ?>/css/red-treeview.css" />
<link rel="stylesheet" href="<?php echo  Router::url('/', true) ?>/css/screen.css" />


<script src="<?php echo  Router::url('/', true) ?>js/cookie.js" type="text/javascript"></script>
<script src="<?php echo  Router::url('/', true) ?>js/treeview.js" type="text/javascript"></script>

<script type="text/javascript">
		$(function() {
			$("#tree").treeview({
				collapsed: true,
				animated: "medium",
				control:"#sidetreecontrol",
				persist: "location"
			});
		})
		
	</script>
<div class="xmls index">
    <div class="table_top" >
           <span> <?php echo $this->Html->image('users.png'); ?></span><h2><?php echo __('Claim Details'); ?></h2>
       </div>
    <ul id="xmldetails">
        <li><b>NAME&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;</b><?php echo $claims['Xmllisting']['name']; ?></li>
        <li style="cursor:pointer"> <b>DOWNLOAD&nbsp;:&nbsp;&nbsp;&nbsp;</b><?php  echo $claims['Xmllisting']['xml_url']; ?></li>
        <li><b>LOCATION&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;</b><?php   echo  ($claims['Xmllisting']['place']==1)?  "Dubai":  "Abudai" ;?></li>
    </ul>
    <div id="treediv">
        
        
        <?php
            $xmllistingid    =   $claims['Xmllisting']['id'];
            
        ?>
        
        
        
        <div id="sidetreecontrol"><a href="?#">Collapse All</a> | <a href="?#">Expand All</a></div>

                <ul id="tree">
                        <li><strong>Single Claim</strong></a>
                            <ul>
                          <?php
                                           $claimdetails     .=   $this->requestAction(array('controller' => 'claims','action' => 'generateclaims/'.$claims['Claim']['id']));
                            
                        $tree   =   $claimdetails;
                        echo $tree;
                        ?>
                            </ul> 
                            
                            
                            
                            

                </ul>
        
        
        
        
        
        
        
        
        
        
        
    </div>
        
           
    
</div>
<div class="actions">
	 <?php     echo $this->element('logo'); ?>
	<ul>
		<li><?php echo $this->Html->link(__('New Xml'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
