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
 * Module-wide constants for the Legal module.
 *
 * NOTE: Do not define anything other than constants in this class!
 */
class ADLibrary_Constant
{
	    /**
     * The official internal module name.
     *
     * @var string
     */
    const MODNAME = 'ADLibrary';

	const MODVAR_ADDCS 			 = 'domainControllers';
	const MODVAR_ADACCOUNTSUFFIX = 'accountSuffix';
	const MODVAR_ADBASEDN 		 = 'baseDN';
	const MODVAR_ADPROXYUSERNAME = 'adminUsername';
	const MODVAR_ADPROXYPASSWORD = 'adminPassword';
	const MODVAR_ADENABLEAUTH 	 = 'isenabled';
}
