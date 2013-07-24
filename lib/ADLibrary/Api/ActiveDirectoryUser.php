<?php
	
/**
 * User API functions.
 */
class ADLibrary_Api_ActiveDirectoryUser extends Zikula_AbstractApi
{
	private $adLDAP;
   
	protected function initialize()
	{
		$this->adLDAP = ModUtil::apiFunc($this->name, 'user', 'bindLDAP');
	}
   
	public function get_ad_id($login_id)
	{
		$user = $this->adLDAP->user()->info($login_id, array('cn'));
		return $user[0]['cn'][0]; 
	}

	public function get_ad_email($login_id)
	{
		$user = $this->adLDAP->user()->info($login_id, array('mail'));
		return $user[0]['mail'][0]; 
	}

	public function set_ad_id($args = false)
	{
		$connection = new ADLibrary_Entity_Connections();
		
		$connection->setad_id($args['ad_id']);
		
		if (is_numeric($args['ad_id'])){
			$connection->setUser_id($args['ad_id']);	
		} else {
			$connection->setUser_id(UserUtil::getVar('uid'));	
		}
		
		$this->entityManager->persist($connection);
		$this->entityManager->flush();	
		
		return true;
	}

	public function authenticate($args)
	{
		if (!isset($args['login_id']) || !isset($args['pass'])) {
			return false;
		}
		return $this->adLDAP->user()->authenticate($args['login_id'], $args['pass']);
	}
}