<?php echo $this->Session->flash(); ?>
<style>
    .input label {
     padding-left: 0px;

    }
    #footer{
        padding: 0px;

    }

</style>
<div class="mednetLogo" style="position: absolute; left: 0px; top: 0px; z-index: 2147483647;">
    <?php echo $this->Html->image('med-net-logo.png');?>
</div>

<div class="loginArea">

    <div id="login_form" class="formArea" style="margin:150px auto 0;" >
        <?php echo $this->Form->create('User', array('action' => 'login')); ?>
        <?php printf(__('', true)); ?>
        <div class="inputArea">
            <?php echo $this->Form->input('username'); ?>
        </div>
        <div class="inputArea">
            <?php
            echo $this->Form->input('password');
            ?>
        </div>
        <div class="inputArea">
            <?php
            echo $this->Form->end(__('SUBMIT', true));
            $this->Html->link('Forgot password ?', array('action' => 'forgot_password'), array('class' => "forgotPwd"));
            ?>
        </div>
    </div>
