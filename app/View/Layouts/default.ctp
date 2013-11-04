<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = __d('cake_dev', 'Process XML');
?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">

<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');

		echo $this->fetch('meta');
		//echo $this->fetch('css');
		echo $this->fetch('script');
		
                

	?>
<script src="http://code.jquery.com/jquery-1.8.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>			
<link href='http://fonts.googleapis.com/css?family=BenchNine' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
 <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />

    <?php
    echo $this->Html->script('messi');
    echo $this->Html->css('default_style');
    echo $this->Html->css('messi');
     //echo $this->Html->css('superfish');
?>
  <script src="<?php echo Router::url('/',true)?>js/tooltip.js"></script>
 <script src="<?php echo Router::url('/',true)?>js/popover.js"></script>

</head>
<body>
       
        
	<div id="container">
		<div id="header">
			<div id="top_menu">
                    <?php 
                    if($this->params['action']!="login")
                           echo $this->element('header');
                    else{
                        ?>
                     
                                <div style=" padding: 0px; width: auto;float:right">
         <a href="/xml/Users"><?php echo $this->Html->image('med-net-logo_new.png', array(
        'width'=>'221',
        'height'=>'49',
             
    ));?></a>
    </div>
                            
                     <?php
                    }
                        ?>
                    	
                   
                </div>
                
		</div>
           	<div id="content">
                       
                        <div id="loading">
                            
                                 <?php echo $this->Html->image('loading_dots.gif', array('id' => 'busy-indicator')); ?>

                        </div>
                       
			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
                </div>
		<div id="footer" style="background-color:white;height:42px;">
			<div id="footer_logo" style="height:42px;float: right; position: absolute; bottom: 0px; right: 0px;">
        
                            <?php 
                                 echo $this->Html->image('member.jpg', array(
                            'width'=>'200'
                        ));
                            ?>
                        </div>
		</div>
	</div>
        
	<?php echo $this->element('sql_dump'); ?>
  

</body>
<script>
    $(document).ready(function(){
        var margin_top = 100;
        var margin_left_right = 0;
        $('#loading').css("left",margin_left_right+"px");
    })
</script>
</html>
