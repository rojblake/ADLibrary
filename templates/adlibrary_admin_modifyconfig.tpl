{adminheader}
<div class="z-admin-content-pagetitle">
    {icon type="view" size="small"}
    <h3>{gt text="Settings"}</h3>
</div>

    <form id="ADLibrary_config" class="z-form" action="{modurl modname="ADLibrary" type="admin" func="updateconfig"}" method="post" enctype="application/x-www-form-urlencoded">
        <div>
            <input type="hidden" name="csrftoken" value="{insert name='csrftoken'}" />
            <fieldset>
                <legend>{gt text="Domain Controllers"}</legend>
                <div class="z-formrow">
                    {assign var='fieldName' value='ADLibrary_Constant::MODVAR_ADDCS'|constant}
                    <label for="ADLibrary_{$fieldName}">{gt text="Domain Controllers"}</label>
                    <textarea id="ADLibrary_{$fieldName}" name="{$fieldName}">{$modvars.ADLibrary.$fieldName}</textarea>
                </div>
			</fieldset>
            <fieldset>
                <legend>{gt text="Proxy User"}</legend>
                <div class="z-formrow">
                    {assign var='fieldName' value='ADLibrary_Constant::MODVAR_ADPROXYUSERNAME'|constant}
                    <label for="ADLibrary_{$fieldName}">{gt text="Proxy User"}</label>
                    <input id="ADLibrary_{$fieldName}" name="{$fieldName}" type="text" value="{$modvars.ADLibrary.$fieldName}" />
                </div>
                <div class="z-formrow">
                    {assign var='fieldName' value='ADLibrary_Constant::MODVAR_ADPROXYPASSWORD'|constant}
                    <label for="ADLibrary_{$fieldName}">{gt text="Proxy Password"}</label>
                    <input id="ADLibrary_{$fieldName}" name="{$fieldName}" type="password" value="{$modvars.ADLibrary.$fieldName}" />
                </div>
			</fieldset>
            <fieldset>
                <legend>{gt text="Account Filter"}</legend>
                <div class="z-formrow">
                    {assign var='fieldName' value='ADLibrary_Constant::MODVAR_ADACCOUNTSUFFIX'|constant}
                    <label for="ADLibrary_{$fieldName}">{gt text="Account Suffiix"}</label>
                    <input id="ADLibrary_{$fieldName}" name="{$fieldName}" type="text" value="{$modvars.ADLibrary.$fieldName}" />
                </div>
                <div class="z-formrow">
                    {assign var='fieldName' value='ADLibrary_Constant::MODVAR_ADBASEDN'|constant}
                    <label for="ADLibrary_{$fieldName}">{gt text="Base Search Location"}</label>
                    <input id="ADLibrary_{$fieldName}" name="{$fieldName}" type="text" value="{$modvars.ADLibrary.$fieldName}" />
                </div>
			</fieldset>
            <fieldset>
                <legend>{gt text="Authentication"}</legend>
                <div class="z-formrow">
                    {assign var='fieldName' value='ADLibrary_Constant::MODVAR_ADENABLEAUTH'|constant}
                    <label for="ADLibrary_{$fieldName}">{gt text="Enable user authentication to AD"}</label>
                    <input id="ADLibrary_{$fieldName}" name="{$fieldName}" type="checkbox" value="1"{if $modvars.ADLibrary.$fieldName} checked="checked"{/if} />
                </div>
			</fieldset>

            <div class="z-formbuttons z-buttons">
                {button src='button_ok.png' set='icons/extrasmall' __alt='Save' __title='Save' __text='Save'}
                <a href="{modurl modname='ADLibrary' type='admin' func='main'}" title="{gt text='Cancel'}">{img modname='core' src='button_cancel.png' set='icons/extrasmall' __alt='Cancel' __title='Cancel'} {gt text='Cancel'}</a>
            </div>
        </div>
    </form>

{adminfooter}