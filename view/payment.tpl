{if $smarty.post.brand}
    <form method="post" action="{$getItemData.getSipsUri}">
        <input type="hidden" name="Data" value="{$getItemData.Data}">
        <input type="hidden" name="InterfaceVersion" value="{$getItemData.InterfaceVersion}">
        <input type="hidden" name="Seal" value="{$getItemData.Seal}">
        <input type="submit" class="btn btn-box btn-flat btn-main-theme" value="Proceed to payment">
    </form>
{else}
    {if is_array($getPaymentBrand) && !empty($getPaymentBrand)}
        <form method="post" action="{$smarty.server.REQUEST_URI}">
            <div class="row">
                <div class="form-group col-md-6">
                    <select class="form-control" id="brand" name="brand">
                        {foreach $getPaymentBrand as $key}
                            <option value="{$key.brand}">{$key.brand}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <input type="submit" class="btn btn-box btn-flat btn-main-theme" value="Continue">
        </form>
    {/if}
{/if}