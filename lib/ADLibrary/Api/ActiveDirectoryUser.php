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
   
	public function getId()
	{
		echo 'got here 1'; die;
		$fb_id = $this->facebook->getUser();

		if ($fb_id) {
			try {
				$user_profile = $this->facebook->api('/me');		  	
			} catch (FacebookApiException $e) {
				$fb_id = null;
			}
		}

		return $fb_id;			
	}   
   	
	public function getPermissions()
	{
		echo 'got here 2'; die;

		return $this->facebook->api("/me/permissions");  
	}
   
	public function getMe()
	{
		echo 'got here 3'; die;

	return $this->facebook->api('/me');   
	}

	public function getEmail()
	{
		echo 'got here 4'; die;

		return $this->facebook->api('/me/email');   
	}

	public function getAvatar()
	{
		echo 'got here 5'; die;

		return $this->facebook->api('/me');   
	}

	public function getPages()
	{
		echo 'got here 5'; die;

		return $this->facebook->api('/me/accounts');	
	}
   
	public function get_uid($login_id)
	{
		$user = $this->adLDAP->user()->info($login_id, array('uidNumber'));
		return $user[0]['uidnumber'][0]; 
	}

	public function set_zuid($args = false)
	{
		echo 'got here 7'; die;

		$connection = new FConnect_Entity_Connections();
		
		$connection->setFb_id($args['fb_id']);
		
		if (is_numeric($args['z_uid'])){
		$connection->setUser_id($args['z_uid']);	
		}else{
		$connection->setUser_id(UserUtil::getVar('uid'));	
		}
		
		$this->entityManager->persist($connection);
		$this->entityManager->flush();	
		
		return true;
	}
}