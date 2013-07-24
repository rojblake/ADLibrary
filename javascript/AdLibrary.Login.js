// Copyright Zikula Foundation 2011 - license GNU/LGPLv3 (or at your option, any later version).

if (typeof(ADLibrary) == 'undefined') {
    ADLibrary = {};
}

ADLibrary.Login =
{
    init: function()
    {
        if ($('users_login_select_authentication_form_adlibrary_activedirectory') != null) {
            $('users_login_select_authentication_form_adlibrary_activedirectory').observe('submit', function(event) { Zikula.Users.Login.onSubmitSelectAuthenticationMethod(event, 'users_login_select_authentication_form_adlibrary_activedirectory'); });
        }
    }

}

// Load and execute the initialization when the DOM is ready.
// This must be below the definition of the init function!
document.observe("dom:loaded", ADLibrary.Login.init);
