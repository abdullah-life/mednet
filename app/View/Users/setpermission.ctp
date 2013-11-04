<div class="index">
    <?php 
        echo $this->Form->create('Permission');
        echo $this->Form->input('controller',array('type' => 'select','class' => 'controller','options' => $options,'empty' => 'Select the controller','default' => $this->Session->read('controller')));
        echo '<div class="method">'.$this->Form->input('actions',array('type' => 'select','class' => 'methods','options' => $methods,'empty' => 'Select the method'))."</div>";
        echo $this->Form->input('users',array('type' => 'select','options' => $users,'empty' => 'Select the user'));
        echo $this->Form->end(__('Submit')); 
    ?>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('.controller').change(function(){
            var controller = $(".controller option:selected").val();
            $.ajax({
                url:"<?php echo Router::url('/',true);?>Users/getmethods/"+controller
            }).done(function(data){
                $('.method').find('div').html(data);
            })
        });
    })
</script>
