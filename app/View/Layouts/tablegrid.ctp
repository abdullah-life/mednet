<!DOCTYPE html>
<html>
<head>
  <title>Sample table</title>
      <?php echo $this->Html->script( 'jquery');?>
      <?php echo $this->Html->script( 'dataTables'); ?>
      <?php echo $this->Html->css( 'demo_page'); ?>
      <?php echo $this->Html->css( 'demo_table'); ?>
      
</head>
<body>
    
    <?php echo $this->fetch('content'); ?>
    
</body>
</html>



