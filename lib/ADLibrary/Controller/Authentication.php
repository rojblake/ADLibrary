<?php

/**
 * Provides access to administrative initiated actions for the ADLibrary module.
 */
class ADLibrary_Controller_Authentication extends Zikula_Controller_AbstractAuthentication
{
    /**
     * Post initialise.
     *
     * Run after construction.
     *
     * @return void
     */
    protected function postInitialize()
    {
        // Set caching to false by default.
        $this->view->setCaching(false);
    }

    /**
     * Renders the template that displays the input fields for the authentication module in the Users module's login block.
     *
     * Parameters sent in the $args array:
     * -----------------------------------
     * string $args['method']    The name of the authentication method for which the fields should be rendered.
     * string $args['form_type'] The type of form (or block, or plugin, etc.) on which the form fields will appear; used in
     *                                  computing the template name.
     *
     * @param array $args All parameters passed to this function.
     * 
     * @return string The rendered template.
     * 
     * @throws Zikula_Exception_Fatal If the $args array or any parameter it contains is invalid; or if a template cannot be found
     *                                      for the method and the specified form type.
     */
    public function getLoginFormFields(array $args)
    {
        // Parameter extraction and error checking
        $errorMessage = false;
        $genericErrorMessage = $this->__('An internal error has occurred while selecting a method of logging in.');
        $showDetailedErrorMessage = (System::getVar('development', false) || SecurityUtil::checkPermission($this->name . '::debug', '::', ACCESS_ADMIN));

        if (!isset($args)) {
            $errorMessage = $genericErrorMessage;
            if ($showDetailedErrorMessage) {
                $errorMessage .= ' ' . $this->__f('Error: The $args array was empty on a call to %1$s.', array(__METHOD__));
            }
            throw new Zikula_Exception_Fatal($errorMessage);
        } elseif (!is_array($args)) {
            $errorMessage = $genericErrorMessage;
            if ($showDetailedErrorMessage) {
                $errorMessage .= ' ' . $this->__f('Error: The $args parameter was not an array on a call to %1$s.', array(__METHOD__));
            }
            throw new Zikula_Exception_Fatal($errorMessage);
        }

        if (!isset($args['form_type']) || !is_string($args['form_type'])) {
            $errorMessage = $genericErrorMessage;
            if ($showDetailedErrorMessage) {
                $errorMessage .= ' ' . $this->__f('Error: An invalid form type (\'%1$s\') was received on a call to %2$s.', array(
                    isset($args['form_type']) ? $args['form_type'] : 'NULL',
                    __METHOD__));
            }
            throw new Zikula_Exception_Fatal($errorMessage);
        }

        if (!isset($args['method']) || !is_string($args['method']) || !$this->supportsAuthenticationMethod($args['method'])) {
            $errorMessage = $genericErrorMessage;
            if ($showDetailedErrorMessage) {
                $errorMessage .= ' ' . $this->__f('Error: An invalid method (\'%1$s\') was received on a call to %2$s.', array(
                    isset($args['form_type']) ? $args['form_type'] : 'NULL',
                    __METHOD__));
            }
            throw new Zikula_Exception_Fatal($errorMessage);
        }
        // End parameter extraction and error checking	

        if ($this->authenticationMethodIsEnabled($args['method'])) {
            $templateName = 'adlibrary_auth_loginformfields_' . mb_strtolower("{$args['form_type']}.tpl");
            if (!$this->view->template_exists($templateName)) {
				throw new Zikula_Exception_Fatal($this->__f('A form fields template (%1$s) was not found for the %2$s method using form type \'%3$s\'.', array($templateName, $args['method'], $args['form_type'])));
            }

            return $this->view->assign('authentication_method', $args['method'])
                              ->fetch($templateName);
        }

		return $this->view->assign('authentication_method', $args['method'])
						  ->fetch('adlibrary_auth_loginformfields.tpl');
    }

    /**
     * Renders the template that displays the authentication module's icon in the Users module's login block.
     * 
     * Parameters sent in the $args array:
     * -----------------------------------
     * string $args['method']      The name of the authentication method for which a selector should be rendered.
     * string $args['is_selected'] True if the selector for this method is the currently selected selector; otherwise false.
     * string $args['form_type']   The type of form (or block, or plugin, etc.) on which the selector will appear; used in
     *                                  computing the template name.
     * string $args['form_action'] The URL to where the form should be posted when submitted.
     * 
     * @param array $args All parameters passed to this function.
     *
     * @return string The rendered template.
     * 
     * @throws Zikula_Exception_Fatal If the $args array or any parameter it contains is invalid; or if a template cannot be found
     *                                      for the method and the specified form type.
     */
    public function getAuthenticationMethodSelector(array $args)
    {
        // Parameter extraction and error checking
        if (!isset($args) || !is_array($args)) {
            throw new Zikula_Exception_Fatal($this->__('Error: an invalid \'$args\' parameter was received.'));
        }

        if (isset($args['form_type']) && is_string($args['form_type'])) {
            $formType = $args['form_type'];
        } else {
            throw new Zikula_Exception_Fatal($this->__f('Error: An invalid form type (\'%1$s\') was received.', array(
                    isset($args['form_type']) ? $args['form_type'] : 'NULL')));
        }

        if (isset($args['method']) && is_string($args['method']) && $this->supportsAuthenticationMethod($args['method'])) {
            $method = $args['method'];
        } else {
            throw new Zikula_Exception_Fatal($this->__f('Error: An invalid method (\'%1$s\') was received.', array(
                    isset($args['method']) ? $args['method'] : 'NULL')));
        }
        // End parameter extraction and error checking

        if ($this->authenticationMethodIsEnabled($method)) {
            $templateVars = array(
                'authentication_method' => array(
                    'modname'   => $this->name,
                    'method'    => $method,
                ),
                'is_selected'           => isset($args['is_selected']) && $args['is_selected'],
                'form_type'             => $formType,
                'form_action'           => $args['form_action'],
            );

            return $this->view->assign($templateVars)
                    ->fetch('adlibrary_auth_authenticationmethodselector.tpl');
        }
    }

    /**
     * Performs initial user-interface level validation on the user name and password received by the user from the login process.
     *
     * Parameters passed in the $args array:
     * -------------------------------------
     * - array $args['authenticationMethod'] The authentication method (selected either by the user or by the system) for which
     *                                          the credentials in $authenticationInfo were entered by the user. For the Users
     *                                          module, the 'modname' element should contain 'Users' and the 'method' element
     *                                          should contain either 'uname' or 'email'.
     * - array $args['authenticationInfo']   The user's credentials, as supplied by him on a log-in form on the log-in screen,
     *                                          log-in block, or some other equivalent control. For the Users module, it should
     *                                          contain the elements 'login_id' and 'pass'.
     *
     * @param array $args The parameters for this function.
     *
     * @return boolean True if the authentication information (the user's credentials) pass initial user-interface level validation;
     *                  otherwise false and an error status message is set.
     *
     * @throws Zikula_Exception_Fatal Thrown if no authentication module name or method is specified, or if the module name or method
     *                                  is invalid for this module.
     */
    public function validateAuthenticationInformation(array $args)
    {
        $validates = false;

        $authenticationMethod = isset($args['authenticationMethod']) ? $args['authenticationMethod'] : array();
        $authenticationInfo   = isset($args['authenticationInfo']) ? $args['authenticationInfo'] : array();
        if (!is_array($authenticationMethod) || empty($authenticationMethod) || !isset($authenticationMethod['modname'])) {
            throw new Zikula_Exception_Fatal($this->__('The authentication module name was not specified during an attempt to validate user authentication information.'));
        } elseif ($authenticationMethod['modname'] != 'ADLibrary') {
            throw new Zikula_Exception_Fatal($this->__f('Attempt to validate authentication information with incorrect authentication module. Credentials should be validated with the \'%1$s\' module instead.', array($authenticationMethod['modname'])));
        }
        if (!isset($authenticationMethod['method'])) {
            throw new Zikula_Exception_Fatal($this->__('The authentication method name was not specified during an attempt to validate user authentication information.'));
        } elseif (($authenticationMethod['method'] != 'ActiveDirectory')) {
            throw new Zikula_Exception_Fatal($this->__f('Unknown authentication method (\'%1$s\') while attempting to validate user authentication information in the Users module.', array($authenticationMethod['method'])));
        }
        if (!is_array($authenticationInfo) || empty($authenticationInfo) || !isset($authenticationInfo['login_id'])
                || !is_string($authenticationInfo['login_id'])
                ) {
            // This is an internal error that the user cannot recover from, and should not happen (it is an exceptional situation).
			throw new Zikula_Exception_Fatal($this->__('A user name was not specified, or the user name provided was invalid.'));
        }

        if (!isset($authenticationInfo['pass']) || !is_string($authenticationInfo['pass'])) {
            // This is an internal error that the user cannot recover from, and should not happen (it is an exceptional situation).
            throw new Zikula_Exception_Fatal($this->__('A password was not specified, or the password provided was invalid.'));
        }
        // No need to be too fancy or too specific here. If the login id (the uname or email) is not empty, then that's sufficient.
        // If we are too specific here, then we are giving a potential hacker too much information about how the authentication process
        // works and what is expected. Just validate it enough so that a lookup can be performed.
        if (!empty($authenticationInfo['login_id'])) {
            if (!empty($authenticationInfo['pass'])) {
                $validates = true;
            } else {
                $this->registerError($this->__('Please provide a password.'));
            }
        } elseif (empty($authenticationInfo['pass'])) {
			$this->registerError($this->__('Please provide a user name and password.'));
        } else {
			$this->registerError($this->__('Please provide a user name.'));
        }

        return $validates;
    }
}
