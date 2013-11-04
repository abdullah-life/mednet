<script>

    (function($) {
        $.widget("ui.combobox", {
            _create: function() {
                this.wrapper = $("<span>")
                        .addClass("ui-combobox")
                        .insertAfter(this.element);
                this._createAutocomplete();
                this._createShowAllButton();
            },
            _createAutocomplete: function() {
                var selected = this.element.children(":selected"),
                        value = selected.val() ? selected.text() : "";
                this.input = $("<input>")
                        .appendTo(this.wrapper)
                        .val(value)
                        .attr("title", "")
                        .addClass("ui-state-default ui-combobox-input ui-widget ui-widget-content ui-corner-left")
                        .autocomplete({
                    delay: 0,
                    minLength: 0,
                    source: $.proxy(this, "_source")
                })
                        .tooltip({
                    tooltipClass: "ui-state-highlight"
                });
                this._on(this.input, {
                    autocompleteselect: function(event, ui) {
                        ui.item.option.selected = true;
                        this._trigger("select", event, {
                            item: ui.item.option
                        });
                    },
                    autocompletechange: "_removeIfInvalid"
                });
            },
            _createShowAllButton: function() {
                return true;
                var wasOpen = true;
                $("<a>")
                        .attr("tabIndex", -1)
                        .attr("title", "Show All Items")
                        .tooltip()
                        .appendTo(this.wrapper)
                        .button({
                    icons: {
                        primary: "ui-icon-triangle-1-s"
                    },
                    text: false
                })
                        .removeClass("ui-corner-all")
                        .addClass("ui-corner-right ui-combobox-toggle")
                        .mousedown(function() {
                    wasOpen = input.autocomplete("widget").is(":visible");
                })
                        .click(function() {
                    input.focus();
// Close if already visible
                    if (wasOpen) {
                        return;
                    }
// Pass empty string as value to search for, displaying all results
                    input.autocomplete("search", "");
                });
            },
            _source: function(request, response) {
                var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
                response(this.element.children("option").map(function() {
                    var text = $(this).text();
                    if (this.value && (!request.term || matcher.test(text)))
                        return {
                            label: text,
                            value: text,
                            option: this
                        };
                }));
            },
            _removeIfInvalid: function(event, ui) {
// Selected an item, nothing to do
                if (ui.item) {
                    return;
                }
// Search for a match (case-insensitive)
                var value = this.input.val(),
                        valueLowerCase = value.toLowerCase(),
                        valid = false;
                this.element.children("option").each(function() {
                    if ($(this).text().toLowerCase() === valueLowerCase) {
                        this.selected = valid = true;
                        return false;
                    }
                });
// Found a match, nothing to do
                if (valid) {
                    return;
                }
// Remove invalid value
                this.input
                        .val("")
                        .attr("title", value + " didn't match any item")
                        .tooltip("open");
                this.element.val("");
                this._delay(function() {
                    this.input.tooltip("close").attr("title", "");
                }, 2500);
                this.input.data("ui-autocomplete").term = "";
            },
            _destroy: function() {
                this.wrapper.remove();
                this.element.show();
            }
        });
    })(jQuery);
</script>
<div class="benefits index">
    <div id="search" style="width:100%;height:auto;float:left;border: 1px solid #CDCDCD !important;">
        
        <h2><?php echo __('Search ');?></h2>
        <?php echo $this->Form->create('Benefits' ,array('type' => 'file'));?>
        <table style="width:700px;" >
		<tr>
                
                <td width="30%"><?php echo $this->Form->input('CriterionNBR',array('type'=>'select','class' => 'search','options' => $criteriannbr,'selected'=>$this->Session->read('nbr'),'empty'=>'select Criterion NBR','fields'=>$list)); ?></td>
            </tr>
            <tr>
                
                <td width="30%"><?php echo $this->Form->input('BENEFIT',array('type'=>'select','class' => 'search','options' => $benefit,'selected'=>$this->Session->read('BENEFIT'),'empty'=>'select Benefit','fields'=>$list)); ?></td>
            </tr>
            <tr>
                
                <td width="30%"><?php echo $this->Form->input('TYPE',array('type'=>'select','class' => 'search','options' => $type,'selected'=>$this->Session->read('type'),'empty'=>'select Type','fields'=>$list)); ?></td>
            </tr>
            <tr>
                
                <td width="30%"><?php echo $this->Form->input('CODE',array('type'=>'select','class' => 'search','options' => $code,'selected'=>$this->Session->read('code'),'empty'=>'select Code','fields'=>$list)); ?></td>
            </tr>
            <tr>
                <td> <?php echo $this->Form->end(__('Submit'));?></td>
            </tr>
            <tr>
                <td> 
                    <?php echo $this->Html->link($this->Html->image('export.png',array('title'=>'download')), array('controller'=>'Benefits','action' => 'createtxt'),array('escape'=>FALSE)); ?>
                </td>
            </tr>
        </table>
        
        
    </div>
	<h2><?php echo __('Benefits');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('CRITERION_NBR');?></th>
			<th><?php echo $this->Paginator->sort('LOCAL_DESCRIPTION');?></th>
			<th><?php echo $this->Paginator->sort('BENEFIT');?></th>
			<th><?php echo $this->Paginator->sort('TYPE');?></th>
			<th><?php echo $this->Paginator->sort('CODE');?></th>
			<th><?php echo $this->Paginator->sort('LOCAL_DESCRIPTION_1');?></th>
			<th><?php echo $this->Paginator->sort('ADDITIONAL CRITERIA');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($benefits as $key => $benefit): ?>
	<tr>
		<td><?php echo h($key+1); ?>&nbsp;</td>
		<td><?php echo h($benefit['Benefit']['CRITERION_NBR']); ?>&nbsp;</td>
		<td><?php echo h($benefit['Benefit']['LOCAL_DESCRIPTION']); ?>&nbsp;</td>
		<td><?php echo h($benefit['Benefit']['BENEFIT']); ?>&nbsp;</td>
		<td><?php echo h($benefit['Benefit']['TYPE']); ?>&nbsp;</td>
		<td><?php echo h($benefit['Benefit']['CODE']); ?>&nbsp;</td>
		<td><?php echo h($benefit['Benefit']['LOCAL_DESCRIPTION_1']); ?>&nbsp;</td>
		<td><?php echo h($benefit['Benefit']['ADDITIONAL CRITERIA']); ?>&nbsp;</td>
		<td><?php echo h($benefit['Benefit']['created']); ?>&nbsp;</td>
		<td><?php echo h($benefit['Benefit']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $benefit['Benefit']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $benefit['Benefit']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $benefit['Benefit']['id']), null, __('Are you sure you want to delete # %s?', $benefit['Benefit']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	 <?php
            if(!isset($benefits[0])){
        ?>
        <table border="0">
            <tr>
                <td><input class="addbenefit" type="submit" value="Add new Benefit" /></td>
            </tr>
        </table>
            <?php } ?>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Add New Benefit'), array('action' => 'add')); ?></li>
	</ul>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('.search').css('display','none');
        $('.search').combobox();
    })
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".addbenefit").live("click",function(){
			$.ajax({ 
                		url: "<?php echo Router::url('/', true);?>"+"Benefits/benefitaddajax",
                		cache: false, 
               			dataType:'html',
				success: function(data) { 
                    			if(data){
						new Messi(data,{title:'Add Benefit',titleClass:'success'});
					}
		 		} 
            		});
		})
	})
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.actions ul li a').click(function(e){
			e.preventDefault();
			$.ajax({ 
                                url: "<?php echo Router::url('/', true);?>"+"Benefits/benefitaddajax",
                                cache: false, 
                                dataType:'html',
                                success: function(data) { 
                                        if(data){
                                                new Messi(data,{title:'Add Benefit',titleClass:'success'});
                                        }
                                } 
                        });

		})
	})
</script>
