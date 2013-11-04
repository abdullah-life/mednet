<style>

    #logout a{
        color: white;

    }
    #logout{
        color: white;
        float: right;
        font-weight: bold;
        height: 20px;
        margin-top: 10px;
        width: 53px;
    }
    #user_name{
        color: white;
        float: right;
        font-weight: bold;
        height: 20px;
        margin-top: 10px;
        width: 53px;
    }
</style>

<div id="user_name" style="margin-left:100px;width:156px;height:43px;float:left;">

    <?php
    echo $this->Session->read('Auth.User.username');
    ?>
</div>
<?php
if (trim($this->params['controller']) != "acos" && trim($this->params['controller']) != "aros") {
    ?>

    <div>
        <ul id="header_main_nav" >
            <li class="current">

                <?php
                if (($this->Session->read('Auth.User.group_id') == 1)) {
                    ?>
                    <?php echo $this->Html->link(__('Dashboard', true), array('controller' => 'users', 'action' => 'Dashboard')); ?> 
                    <?php
                }
                if (($this->Session->read('Auth.User.group_id') == 18)) {
                    ?>
                    <?php echo $this->Html->link(__('Dashboard', true), array('controller' => 'Providerpricings', 'action' => 'index')); ?> 
                    <?php
                }
                
                
                if (($this->Session->read('Auth.User.group_id') == 15))
                    echo $this->Html->link(__('Dashboard', true), array('controller' => 'users', 'action' => 'dashboardReciverunit'));

                if (($this->Session->read('Auth.User.group_id') == 16))
                    echo $this->Html->link(__('Dashboard', true), array('controller' => 'users', 'action' => 'dashboardClaimsmanager'));

                if (($this->Session->read('Auth.User.group_id') == 17))
                    echo $this->Html->link(__('Dashboard', true), array('controller' => 'users', 'action' => 'dashboardClaimsprocessor'));
                ?>
            </li>

    <?php
    if (($this->Session->read('Auth.User.group_id') == "admin")) {
        ?>
                <li>
                <?php echo $this->Html->link(__('XML', true), array('controller' => 'xmllistings', 'action' => 'index')); ?> 

                </li>
                <li class="current">
        <?php echo $this->Html->link(__('Users', true), array('controller' => 'users', 'action' => 'index')); ?> 
                </li>  
                <li class="current">
                    <?php echo $this->Html->link(__('Global Settings', true), array('controller' => 'globalsettings', 'action' => 'index')); ?> 
                </li>
                <li class="current">
                    <?php echo $this->Html->link(__('Global Settings', true), array('controller' => 'Users', 'action' => 'setpermission')); ?> 
                </li>
                    <?php
                }
                ?>

    <?php
            if(($this->Session->read('Auth.User.group_id') == 1)||($this->Session->read('Auth.User.group_id') == 18))
            {
    ?>
                <li class="current">
                     <?php echo $this->Html->link(__('Print providers', true), array('controller' => 'Claims', 'action' => 'findProviders')); ?> 
                </li>
               
   <?php
            }
            if(($this->Session->read('Auth.User.group_id') == 1)){
               ?>
                 <li class="current">
                     <?php echo $this->Html->link(__('New Files', true), array('controller' => 'Newfiles', 'action' => 'index')); ?> 
                </li>
                <?php
            }
   ?>
            <li class="current">
    <?php
    if ($this->Session->read('Auth.User.group_id') == 18) {
        echo $this->Html->link(__('Observation Mappings', true), array('controller' => 'ObservationMappings', 'action' => 'index'));
    }
    ?>
            </li>
 <li class="current">
    <?php
    if ($this->Session->read('Auth.User.group_id') == 1) {
        echo $this->Html->link(__('Users', true), array('controller' => 'Users', 'action' => 'index'));
    }
    ?>
            </li>
            <li class="current">
                <?php
                if (($this->Session->read('Auth.User.group_id') == 'admin')) {
                    ?>
                    <?php echo $this->Html->link(__('EOP Files', true), array('controller' => 'eopfiles', 'action' => 'index')); ?> 
                    <?php
                }
                ?>
            </li>

            <li class="current">
                <?php
                if ($this->Session->read('Auth.User.group_id') == 'admin') {
                    echo $this->Html->link(__('Benefits', true), array('controller' => 'benefits', 'action' => 'add'));
                }
                ?>
            </li>
        </ul>

                <?php
            }
            ?>
</div>
<div id="logout" style="float:right;margin-top:30px;">

    <a href="<?php echo Router::url('/', true); ?>users/logout">Logout</a>

</div>

    <?php
    if (trim($this->params['controller']) != "acos" AND trim($this->params['controller']) != "aros") {
        ?>

    <div id="calendar" style="float:right;margin-left:0px;margin-top:19px;" >
        
    <?php
        echo $this->Form->create('searchform', array('url' => array('controller' => 'xmllistings', 'action' => 'sel_date')));
    ?>

        <div class="input text">
            <input type="text" style="width:114px" id="from" name="data[User][from]" value="<?php if ($this->Session->read('from_date')) echo $this->Session->read('from_date');
    else echo ""; ?>">
            <span style="color:white">To &nbsp;</span>
            <input type="text" style="width:114px" id="to" name="data[User][to]" value="<?php if ($this->Session->read('to_date')) echo $this->Session->read('to_date');
    else echo ""; ?>">
        <?php
        $params = $this->params['pass'];
        $params = implode("/", $params);
        echo $this->Form->hidden('url', array('name' => 'controller', 'value' => $this->params['url']));
        echo $this->Form->hidden('controller', array('name' => 'controller', 'value' => $this->params['controller']));
        echo $this->Form->hidden('action', array('name' => 'action', 'value' => $this->params['action']));
        echo $this->Form->hidden('params', array('name' => 'params', 'value' => $params));
        echo $this->Form->end();
        ?>
            <input type="submit" value="Search" id="search">
        </div>
            <?
            ?>

    </div>  
<div style="float:right;margin-top:30px;margin-right:0px;" id="logout">
    <a href="#" id="reset">Reset</a>
</div>

    <?php
}
?>

<script type="text/javascript">

    $(document).ready(function() {
        
        $("#reset").click(function(){
            $.ajax({ 
                url: "<?php echo Router::url('/', true);?>"+"users/removedatesearch/",
                cache: false, 
               	dataType:'html',
		success: function(data) { 
                    location.reload(); 
                    
		 } 
            });
        })
        
        
        $("#from").datepicker({
            defaultDate: "+0w",
            changeMonth: true,
            numberOfMonths: 3,
            dateFormat: 'yy-mm-dd',
            onClose: function(selectedDate) {
                $("#to").datepicker("option", "minDate", selectedDate);
            }
        });
        $("#to").datepicker({
            defaultDate: "+0w",
            changeMonth: true,
            numberOfMonths: 3,
            dateFormat: 'yy-mm-dd',
            onClose: function(selectedDate) {
                $("#from").datepicker("option", "maxDate", selectedDate);
            }
        });
    })
</script>