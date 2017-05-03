{assign var="collectionAccountType" value=[
    "TEST"=>"Test",
    "SIMU"=>"Simulation",
    "PRODUCTION"=>"Production"
]}
<form id="forms_plugins_atos" method="post" action="">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="merchandId">merchandId* :</label>
                <input type="text" class="form-control" id="merchandId" name="merchandId" value="{$getItemData.merchandId}" size="50" />
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
            <label for="secureKey">secureKey* :</label>
            <input type="text" class="form-control" id="secureKey" name="secureKey" value="{$getItemData.secureKey}" size="50" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="accountType">accountType* :</label>
                <select class="form-control" id="accountType" name="accountType">
                    <option value="">Sélectionner une action</option>
                    {foreach $collectionAccountType as $key => $value}
                        {$selected  =   ''}
                        {if $getItemData.accountType == $key}
                            {$selected  =   ' selected'}
                        {/if}
                        <option{$selected} value="{$key}">{$value}</option>
                    {/foreach}
                </select>
            </div>
        </div>
    </div>
    <div class="btn-row">
        <input type="submit" class="btn btn-primary" value="{#save#|ucfirst}" />
    </div>
</form>