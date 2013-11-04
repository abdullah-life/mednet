<script>
     
(function( $ ) {
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
<div class="denialcodes index">
    <div id="search" style="width:100%;height:auto;float:left;border: 1px solid #CDCDCD !important;">
        
        <h2><?php echo __('Search ');?></h2>
        <?php echo $this->Form->create('Denialcodes');?>
        <table style="width:700px;" >
            
            <tr>
                
                <td width="30%">
                    <?php
                       echo $this->Form->input('Denialcode',array('type' => 'select','class' => 'combo', 'options' => $denial_codes, 'empty' => 'Denial Code Search'));
                       echo $this->Form->input('DenialType',array('type' => 'select','class' => 'combo', 'options' => $denialtypes, 'empty' => 'Denial Type Search'));
                       echo $this->Form->input('EffectiveDate',array('type' => 'select','class' => 'combo', 'options' => $effectivedates, 'empty' => 'Effective Dates Search'));
                       echo $this->Form->input('ExpiryDate',array('type' => 'select','class' => 'combo', 'options' => $expirydate, 'empty' => 'Expiry Date Search'));
                       echo $this->Form->input('ProviderLocation',array('type' => 'select','class' => 'combo', 'options' => $locations, 'empty' => 'Location Search'));
                        //echo $this->Form->input('Activity code search',array('type' =>  'select','options'  =>  $providers,,'name' => 'activityid'));
                    ?>
                </td>
            </tr>
            <tr>
                <td> <?php echo $this->Form->end(__('Submit'));?></td>
            </tr>
            
        </table>
        
        
    </div>
	<h2><?php echo __('Denialcodes'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
            <th><?php echo $this->Paginator->sort('id'); ?></th>
            <th><?php echo $this->Paginator->sort('Code'); ?></th>
            <th><?php echo $this->Paginator->sort('Description'); ?></th>
            <th><?php echo $this->Paginator->sort('Status'); ?></th>
            <th><?php echo $this->Paginator->sort('Type'); ?></th>
            <th><?php echo $this->Paginator->sort('Effective'); ?></th>
            <th><?php echo $this->Paginator->sort('Expired'); ?></th>
            <th><?php echo $this->Paginator->sort('Location'); ?></th>
            <th><?php echo $this->Paginator->sort('Edit'); ?></th>
            <th><?php echo $this->Paginator->sort('delete'); ?></th>
	</tr>
	<?php
	foreach ($denialcodes as $key=>$denialcode): ?>
	<tr>
            <td><?php echo h($key+1); ?>&nbsp;</td>
            <td><?php echo h($denialcode['Denialcode']['Code']); ?>&nbsp;</td>
            <td><?php echo h($denialcode['Denialcode']['Description']); ?>&nbsp;</td>
            <td><?php echo h($denialcode['Denialcode']['Status']); ?>&nbsp;</td>
            <td><?php echo h($denialcode['Denialcode']['Type']); ?>&nbsp;</td>
	    <td><?php if($denialcode['Denialcode']['Effective']!=null) echo h(date('d/m/Y',$denialcode['Denialcode']['Effective']->sec)); ?>&nbsp;</td>  
            <td><?php if($denialcode['Denialcode']['Expired']!=null) echo h(date('d/m/Y',$denialcode['Denialcode']['Expired']->sec)); ?>&nbsp;</td>
            <td><?php  echo($denialcode['Denialcode']['location']==1)? "DHA": "HAAD"; ?>&nbsp;</td>
            <td><?php echo $this->Html->Link(__('Edit Denialcode'), array('action' => 'edit/'.$denialcode['Denialcode']['id']) ); ?> </td>
            <td><?php echo $this->Form->postLink(__('Delete Denialcode'), array('action' => 'delete', $denialcode['Denialcode']['id']), null, __('Are you sure you want to delete # %s?', $denialcode['Denialcode']['id'])); ?> </td>
	</tr>
        <?php endforeach; ?>
	</table>
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
		<li><?php echo $this->Html->link(__('Add Denialcode XLS'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Add Denialcode'), array('action' => 'addsinglecode')); ?></li>
	</ul>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('.combo').css('display','none');
        $('.combo').combobox();
    })
</script>
