<?php
/**
 * Copyright (c) 2012 Mark West
 *
 * @license http://www.gnu.org/licenses/lgpl-3.0.html GNU/LGPLv3 (or at your option any later version).
 * @package Legal
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */

/**
 * Installs, upgrades, and uninstalls the Legal module.
 */
class ADLibrary_Installer extends Zikula_AbstractInstaller
{
    private $_entities = array(
        'ADLibrary_Entity_Connections'
    );

    /**
     * Install the module.
     *
     * @return bool true if successful, false otherwise
     */
    function install()
    {
        try {
            DoctrineHelper::createSchema($this->entityManager, $this->_entities);
        } catch (Exception $e) {
            return LogUtil::registerError($e->getMessage());
        }
        // Initialization successful
        return true;
    }

    /**
     * Upgrade the module from a prior version.
     *
     * This function must consider all the released versions of the module!
     * If the upgrade fails at some point, it returns the last upgraded version.
     *
     * @param string $oldVersion The version number string from which the upgrade starting.
     *
     * @return boolean|string True if the module is successfully upgraded to the current version; last valid version string or false if the upgrade fails.
     */
    function upgrade($oldVersion)
    {
        // Update successful
        return true;
    }

    /**
     * Delete the module.
     *
     * @return bool True if successful; otherwise false.
     */
    function uninstall()
    {
        try {
            DoctrineHelper::dropSchema($this->entityManager, $this->_entities);
        } catch (Exception $e) {
          return LogUtil::registerError($e->getMessage());  
        }

        $this->delVars();

        // Deletion successful
        return true;
    }
}