<?php
/**
 * FConnect
 */
	
/**
 * Facebook API functions.
 */
 

class ADLibrary_Api_ActiveDirectory extends Zikula_AbstractApi
{
   
	protected function initialize() 
	{
		echo 'got here 9'; die;				
		require_once 'modules/FConnect/lib/vendor/Facebook/facebook.php';				
		$settings = ModUtil::getVar($this->name);
		$this->_facebook = new Facebook(array(
				'appId' => $settings['appid'],
				'secret' => $settings['secretkey']
				));
	
	}
	
	public function app_id()
	{
		echo 'got here 10'; die;
		return $this->_facebook->getAppId();
	}

	public function logged_in()
	{
		echo 'got here 11'; die;
		return $this->_me != NULL;
	}

	public function user_id()
	{
		echo 'got here 12'; die;
		return $this->_facebook->getUser();
	}

	public function session()
	{
		echo 'got here 13'; die;
		return $this->_session;
	}

	public function account()
	{
		echo 'got here 14'; die;
		return $this->_me;
	}

	public function facebook()
	{
		echo 'got here 15'; die;
		return $this->_facebook;
	}
	
	public function logInUrl($args = null)
	{		
		echo 'got here 16'; die;
		if($args['gobackurl'] == null){			
			$args['gobackurl'] = ModUtil::url($this->name, 'user', 'main', $args = array(), $ssl = null, $fragment = null, $fqurl = true, $forcelongurl = false, $forcelang=false);				
		}
				
		if($args['scope'] == null){			
			$args['scope'] = 'email,read_stream';
		}		
		
		return $this->_facebook->getLoginUrl($params = array('scope' => $args['scope'],'redirect_uri' => $args['gobackurl']));						
	}
		
}