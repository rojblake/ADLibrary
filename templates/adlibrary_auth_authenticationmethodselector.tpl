{if $form_type eq 'loginblock'}
	<h4>{gt text="Active Directory"}</h4>
	<div id="users_login_fields">
		<div class="z-formrow">
			<label for="openid_identifier">{gt text='Username'}</label>
			<input id="users_loginblock_supplied_id_openid" name="authentication_info[login_id]" type="text" maxlength="255" value="" />
		</div>
		<div class="z-formrow">
			<label for="openid_identifier">{gt text='Password'}</label>
			<input id="users_loginblock_supplied_id_openid" name="authentication_info[pass]" type="password" maxlength="255" value="" />
		</div>
	</div>
{else}
	{gt text='Active Directory' assign='button_text'}
	<form id="authentication_select_method_form_{$authentication_method.modname|lower}_{$authentication_method.method|lower}" class="authentication_select_method" method="post" action="{$form_action}" enctype="application/x-www-form-urlencoded">
	<div>
		<input type="hidden" id="authentication_select_method_csrftoken_{$authentication_method.modname|lower}_{$authentication_method.method|lower}" name="csrftoken" value="{insert name='csrftoken'}" />
		<input type="hidden" id="authentication_select_method_selector_{$authentication_method.modname|lower}_{$authentication_method.method|lower}" name="authentication_method_selector" value="1" />
		<input type="hidden" id="authentication_select_method_module_{$authentication_method.modname|lower}_{$authentication_method.method|lower}" name="authentication_method[modname]" value="{$authentication_method.modname}" />
		<input type="hidden" id="authentication_select_method_method_{$authentication_method.modname|lower}_{$authentication_method.method|lower}" name="authentication_method[method]" value="{$authentication_method.method}" />
		<input type="submit" id="authentication_select_method_submit_{$authentication_method.modname|lower}_{$authentication_method.method|lower}" class="authentication_select_method_button{if $is_selected} authentication_select_method_selected{/if}" name="submit" value="{$button_text}" />
	</div>
	</form>
{/if}