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
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.8.22/jquery-ui.min.js" type="text/javascript"></script>			
<link href='http://fonts.googleapis.com/css?family=BenchNine' rel='stylesheet' type='text/css'>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
 <script>
     $(function() {
       $( "#datepicker" ).datepicker({ dateFormat: "yy-mm-dd" });
     });
 </script>

<?php

    echo $this->Html->css('default_style');
    echo $this->Html->css('superfish');
    echo $this->Html->css('widgets');
    echo $this->Html->script(array('hoverIntent'));
    echo $this->Html->script(array('superfish'));
 ?>

</head>
<body>
	<div id="container">
		<div id="header">
			<div id="top_menu">
                    <?php 
                    
                    if($this->params['action']!="login")
                    
                           echo $this->element('header');
                    ?>
            </div>
            
            <!-- Widgets -->
            <?php 
                 $url = $this->Html->url( array(
                                                      "controller" => "xmllistings",
                                                      "action" => "index"
                                              ));  
            ?> 
			<div id="calendar">
				 <form action="<?=$url?>" method="post">
                   <span id="date_disp">Date </span>
                   <input type="text" id="datepicker" name="date" value="<?=$date?>"/>
                   <input type="submit" value="submit"/> 
                 </form>   
			</div>    

		</div>
		<div id="content">

			

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			all rights reserver@sparksupport.com
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
