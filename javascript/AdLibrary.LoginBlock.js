// Copyright Zikula Foundation 2011 - license GNU/LGPLv3 (or at your option, any later version).

if (typeof(ADLibrary) == 'undefined') {
    ADLibrary = {};
}

ADLibrary.LoginBlock =
{
    init: function()
    {
        if ($('authentication_select_method_form_adlibrary_activedirectory') != null) {
            $('authentication_select_method_form_adlibrary_activedirectory').observe('submit', function(event) { Zikula.Users.LoginBlock.onSubmitSelectAuthenticationMethod(event, 'authentication_select_method_form_adlibrary_activedirectory'); });
        }
    }

}

// Load and execute the initialization when the DOM is ready.
// This must be below the definition of the init function!
document.observe("dom:loaded", ADLibrary.LoginBlock.init);
