<?php
/**
 * Copyright (c) 2013 Mark West
 *
 * @license http://www.gnu.org/licenses/lgpl-3.0.html GNU/LGPLv3 (or at your option any later version).
 * @package JukeboxLib
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */


/**
 * Module controller for user-related operations.
 */
class ADLibrary_Controller_User extends Zikula_AbstractController
{
    public function main()
    {
		$settings = ModUtil::getVar($this->name);
		
		// check if our login type is enabled
        if (!isset($settings['isenabled'])) {
            throw new Zikula_Exception_Fatal($this->__('Active Directory login is not supported'));
		}

		return $this->view->fetch('adlibrary_user_main.tpl');
	}

    public function login()
    {
        // we shouldn't get here if logged in already....
        $this->redirectIf(UserUtil::isLoggedIn(), ModUtil::url($this->name, 'user', 'main'));

        $loggedIn = false;
        $isFunctionCall = false;
        $isReentry = false;

	}
}

