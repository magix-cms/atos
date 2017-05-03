<form id="forms_plugins_atos_payementbrand" method="post" action="{$smarty.server.REQUEST_URI}">
    <div class="alert alert-warning clearfix">
        <span class="fa fa-warning"></span> Vous devez sélectionner minimum 1 mode de paiement
    </div>
    <div class="row">
        <div class="form-group">
            {if isset($getItems) && is_array($getItems)}
            {foreach $getItems as $item}
                <label class="col-sm-2 control-label toggle-label">{$item.brand}</label>
                <div class="col-sm-2">
                    <div class="checkbox">
                        <label>
                            <input{if $item.status eq '1'} checked{/if} name="brands[{$item.brand}]" data-toggle="toggle" type="checkbox" data-on="oui" data-off="non" data-onstyle="primary" data-offstyle="default" >
                        </label>
                    </div>
                </div>
            {/foreach}
            {/if}
        </div>
    </div>
    <div class="btn-row">
        <input type="submit" id="btn-brands" class="btn btn-primary" value="{#save#|ucfirst}" />
    </div>
</form>