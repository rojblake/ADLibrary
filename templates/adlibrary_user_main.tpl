{if !empty($selected_authentication_method)}
    {login_form_fields form_type='loginscreen' authentication_method=$selected_authentication_method assign='login_form_fields'}
{/if}

<form id="adlibrary_login_login_form" class="z-form z-gap z-clearer" action="{modurl modname="ADLibrary" type="user" func="login"}" method="post">
    <div>
        <input id="adlibrary_login_selected_authentication_module" type="hidden" name="authentication_method[modname]" value="{$selected_authentication_method.modname|default:''}" />
        <input id="adlibrary_login_selected_authentication_method" type="hidden" name="authentication_method[method]" value="{$selected_authentication_method.method|default:''}" />
        <input id="adlibrary_login_returnpage" type="hidden" name="returnpage" value="{$returnpage}" />
        <input id="adlibrary_login_csrftoken" type="hidden" name="csrftoken" value="{insert name='csrftoken'}" />
        <input id="adlibrary_login_event_type" type="hidden" name="event_type" value="login_screen" />
        {if ($modvars.ZConfig.seclevel|lower == 'high')}
        <input id="adlibrary_login_rememberme" type="hidden" name="rememberme" value="0" />
        {/if}
        <fieldset>
            <div id="users_login_fields">
                {$login_form_fields}
            </div>
            <div id="adlibrary_login_fields">
                <legend>{gt text="Username"}</legend>
                <div class="z-formrow">
                    <label for="ADLibrary_username">{gt text="Proxy User"}</label>
                    <input id="ADLibrary_username" name="username" type="text" />
                </div>
                <div class="z-formrow">
                    <label for="ADLibrary_password">{gt text="Password"}</label>
                    <input id="ADLibrary_password" name="password" type="password" />
                </div>
            </div>
            {if ($modvars.ZConfig.seclevel|lower != 'high')}
            <div class="z-formrow">
                <span class="z-formlist">
                    <input id="adlibrary_login_rememberme" type="checkbox" name="rememberme" value="1" />
                    <label for="users_login_rememberme">{gt text="Keep me logged in on this computer"}</label>
                </span>
            </div>
            {/if}
        </fieldset>
		{button src='button_ok.png' set='icons/extrasmall' __alt='Log in' __title='Log in' __text='Log in'}
        </div>
    </div>
</form>
