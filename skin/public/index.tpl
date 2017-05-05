{extends file="layout.tpl"}
{block name="title"}{seo_rewrite config_param=['level'=>'0','idmetas'=>'1','default'=>'Atos Test']}{/block}
{block name="description"}{seo_rewrite config_param=['level'=>'0','idmetas'=>'2','default'=>'Atos Test']}{/block}

{block name='body:id'}atos{/block}
{block name="webType"}{/block}
{block name="slider"}{/block}

{block name='article'}
<article id="article" class="col-xs-12">
{block name='article:content'}
    {if $smarty.post.brand}
        <pre>{$getItemData|print_r}</pre>
        <form method="post" action="{$getItemData.getSipsUri}">
            <input type="hidden" name="Data" value="{$getItemData.Data}">
            <input type="hidden" name="InterfaceVersion" value="{$getItemData.InterfaceVersion}">
            <input type="hidden" name="Seal" value="{$getItemData.Seal}">
            <input type="submit" class="btn btn-box btn-flat btn-main-theme" value="Proceed to payment">
        </form>
    {else}
        {if isset($smarty.post.Encode)}
            <pre>{$getPaymentResponse|print_r}</pre>
            {else}
            <pre>{$getPaymentBrand|print_r}</pre>
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
    {/if}
{/block}
</article>
{/block}
{block name="aside"}{/block}