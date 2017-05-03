{extends file="layout.tpl"}
{block name="styleSheet" append}
{headlink rel="stylesheet" href="/{baseadmin}/min/?f=plugins/{$pluginName}/css/admin.css" concat={$concat} media="screen"}
{/block}
{block name='body:id'}plugins-{$pluginName}{/block}
{block name="article:content"}
    {include file="tabs.tpl"}
    <h1><span class="fa fa-credit-card"></span> Atos Worldline</h1>
    <div class="mc-message clearfix"></div>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="config">
            <h2>Configuration</h2>
            <p>Indiquer les données de votre compte Atos</p>
            {include file="forms/edit.tpl"}
        </div>
        <div role="tabpanel" class="tab-pane" id="payementbrand">
            <h2>Les Modes de paiements</h2>
            <p>Sélectionnez les modes de paiements de votre compte Atos</p>
            {include file="forms/brands.tpl" getItems=$getItems}
        </div>
    </div>
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
    {include file="js.tpl"}
{/block}