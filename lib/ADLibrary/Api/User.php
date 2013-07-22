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
 * User API functions.
 */
class ADLibrary_Api_User extends Zikula_AbstractApi
{

	function bindLDAP()
	{
        // Security check
        if (!SecurityUtil::checkPermission($this->name . '::', '::', ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }

		$modVars = ModUtil::getVar('ADLibrary');

		$domain_controllers = str_getcsv($modVars['domainControllers']);
		$options = array('domain_controllers' 	=> $domain_controllers,
						 'account_suffix' 		=> $modVars['accountSuffix'],
						 'base_dn' 				=> $modVars['baseDN'],
						 'admin_username' 		=> $modVars['adminUsername'],
						 'admin_password' 		=> $modVars['adminPassword']
						);

		$includeFile = dirname(__FILE__) . '/../../vendor/adLDAP.php';
		if (!file_exists($includeFile)) {
			throw new Zikula_Exception_Forbidden();
		} 
		include_once $includeFile;
		
		try {
			$serverBind = new adLDAP($options);
		}
		catch (adLDAPException $e) {
			echo $e;
			exit();   
		}
		return $serverBind;
	}

	function getGroup($args)
	{
        // Security check
        if (!SecurityUtil::checkPermission($this->name . '::', '::', ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }

        if (!isset($args['groupName'])) {
            return LogUtil::registerArgsError();
        }

		$serverBind = ModUtil::apiFunc('ADLibrary', 'user', 'bindLDAP');
		return $serverBind->group()->info($args['groupName'], array('*'));
	}

	function getGroups($args)
	{
        // Security check
        if (!SecurityUtil::checkPermission($this->name . '::', '::', ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }

		if (!isset($args['includeDescription'])) {
			$args['includeDescription'] = false;
		}
		if (!isset($args['search'])) {
			$args['search'] = '*';
		}
		if (!isset($args['sorted'])) {
			$args['sorted'] = true;
		}
		$serverBind = ModUtil::apiFunc('ADLibrary', 'user', 'bindLDAP');
		return $serverBind->groups()->all($args['includeDescription'], $args['search'], $args['sorted']);
	}

	function getGroupsForUser($args)
	{
        // Security check
        if (!SecurityUtil::checkPermission($this->name . '::', '::', ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }

        if (!isset($args['userName'])) {
            return LogUtil::registerArgsError();
        }

		$serverBind = ModUtil::apiFunc('ADLibrary', 'user', 'bindLDAP');
		return $serverBind->user()->groups($args['userName']);
	}

	function searchGroups($args)
	{
        // Security check
        if (!SecurityUtil::checkPermission($this->name . '::', '::', ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }

		if (!isset($args['samAccountType'])) {
			$args['samAccountType'] = adLDAP::ADLDAP_SECURITY_GLOBAL_GROUP;
		}
		if (!isset($args['includeDescription'])) {
			$args['includeDescription'] = false;
		}
		if (!isset($args['search'])) {
			$args['search'] = '*';
		}
		if (!isset($args['sorted'])) {
			$args['sorted'] = true;
		}
		$serverBind = ModUtil::apiFunc('ADLibrary', 'user', 'bindLDAP');
		return $serverBind->user()->search($args['samAccountType'], $args['includeDescription'], $args['search'], $args['sorted']);
	}

	function getUser($args)
	{
        // Security check
        if (!SecurityUtil::checkPermission($this->name . '::', '::', ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }

        if (!isset($args['userName'])) {
            return LogUtil::registerArgsError();
        }

		$serverBind = ModUtil::apiFunc('ADLibrary', 'user', 'bindLDAP');
		return $serverBind->user()->info($args['userName'], array('*'));
	}

	function getComputer($args)
	{
        // Security check
        if (!SecurityUtil::checkPermission($this->name . '::', '::', ACCESS_READ)) {
            throw new Zikula_Exception_Forbidden();
        }

        if (!isset($args['computerName'])) {
            return LogUtil::registerArgsError();
        }

		$serverBind = ModUtil::apiFunc('ADLibrary', 'user', 'bindLDAP');
		return $serverBind->computer()->info($args['computerName'], array('*'));
	}
}
