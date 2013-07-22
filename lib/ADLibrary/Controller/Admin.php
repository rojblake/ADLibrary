<?php
/**
 * Copyright (c) 2001-2012 Zikula Foundation
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license http://www.gnu.org/licenses/lgpl-3.0.html GNU/LGPLv3 (or at your option any later version).
 * @package Legal
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */

/**
 * Administrator-initiated actions for the Legal module.
 */
class ADLibrary_Controller_Admin extends Zikula_AbstractController
{
    /**
     * The main administration entry point.
     *
     * Redirects to the {@link modifyConfig()} function.
     *
     * @return void
     */
    public function main()
    {
        $this->redirect(ModUtil::url($this->name, 'admin', 'modifyconfig'));
    }

    /**
     * Modify configuration.
     *
     * Modify the configuration parameters of the module.
     *
     * @return string The rendered output of the modifyconfig template.
     *
     * @throws Zikula_Exception_Forbidden Thrown if the user does not have the appropriate access level for the function.
     */
    public function modifyconfig()
    {
        // Security check
        if (!SecurityUtil::checkPermission($this->name . '::', '::', ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }

        // Assign all the module vars
        return $this->view->assign(ModUtil::getVar('ADLibrary'))
            ->fetch('adlibrary_admin_modifyconfig.tpl');
    }

    /**
     * Update the configuration.
     *
     * Save the results of modifying the configuration parameters of the module. Redirects to the module's main page
     * when completed.
     *
     * @return void
     *
     * @throws Zikula_Exception_Forbidden Thrown if the user does not have the appropriate access level for the function.
     */
    public function updateconfig()
    {
        // Security check
        if (!SecurityUtil::checkPermission($this->name . '::', '::', ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }

        // Confirm the forms authorisation key
        $this->checkCsrfToken();

        $domainControllers = $this->request->getPost()->get(ADLibrary_Constant::MODVAR_ADDCS, false);
        $this->setVar(ADLibrary_Constant::MODVAR_ADDCS, $domainControllers);

        $accountSuffix = $this->request->getPost()->get(ADLibrary_Constant::MODVAR_ADACCOUNTSUFFIX, false);
        $this->setVar(ADLibrary_Constant::MODVAR_ADACCOUNTSUFFIX, $accountSuffix);

        $baseDN = $this->request->getPost()->get(ADLibrary_Constant::MODVAR_ADBASEDN, false);
        $this->setVar(ADLibrary_Constant::MODVAR_ADBASEDN, $baseDN);

        $adminUsername = $this->request->getPost()->get(ADLibrary_Constant::MODVAR_ADPROXYUSERNAME, false);
        $this->setVar(ADLibrary_Constant::MODVAR_ADPROXYUSERNAME, $adminUsername);

        $adminPassword = $this->request->getPost()->get(ADLibrary_Constant::MODVAR_ADPROXYPASSWORD, false);
        $this->setVar(ADLibrary_Constant::MODVAR_ADPROXYPASSWORD, $adminPassword);

        $isEnabled = $this->request->getPost()->get(ADLibrary_Constant::MODVAR_ADENABLEAUTH, false);
        $this->setVar(ADLibrary_Constant::MODVAR_ADENABLEAUTH, $isEnabled);
	
        // the module configuration has been updated successfuly
        $this->registerStatus($this->__('Done! Saved module configuration.'));

        // This function generated no output, and so now it is complete we redirect
        // the user to an appropriate page for them to carry on their work
        $this->redirect(ModUtil::url($this->name, 'admin', 'main'));
    }

	function testldap()
	{
        // Security check
        if (!SecurityUtil::checkPermission($this->name . '::', '::', ACCESS_ADMIN)) {
            throw new Zikula_Exception_Forbidden();
        }

		$serverBind = ModUtil::apiFunc('ADLibrary', 'user', 'bindLDAP');
		if ($serverBind) {
			$this->registerStatus($this->__('LDAP Bind Successful'));
		}

        // This function generated no output, and so now it is complete we redirect
        // the user to an appropriate page for them to carry on their work
        $this->redirect(ModUtil::url($this->name, 'admin', 'main'));
	}
}