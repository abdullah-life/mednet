<?php
  $cakeDescription = __d('cake_dev', 'My CRM');
?>
<!DOCTYPE>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.8.22/jquery-ui.min.js" type="text/javascript"></script>
			


<?php

    echo $this->Html->css('default_style');
    echo $this->Html->css('superfish');
    echo $this->Html->script(array('hoverIntent'));
    echo $this->Html->script(array('superfish'));
 ?>

<script type="text/javascript">
    jQuery(function(){
            jQuery('ul.sf-menu').superfish();
    });
</script>
<link href="default_style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    *{
        margin-top:0px;
        margin-left: 0px;
        margin-right: 0px;
    }
</style>
</head>
<body>
    <div id="header">
		<div id="top_menu">
                    <?php 
                           echo $this->element('common/header');
                    ?>
                </div>
        </div> 
       
	<!--end of header-->
 <div id="wrapper">
        <div style="height:70px;">
            
        </div>
    <div id="main">
        <div id="content">
        <?php echo $this->fetch('content'); ?>
        </div>
    </div>
        <div id="footer">
            
        </div>

</div> <!--end of wrapper-->

</body>
</html>
