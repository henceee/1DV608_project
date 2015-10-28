<?php

class Authentication
{
	/**
	 * @var null | array of \model\User objects.
	 */
	private $users = null;
	/**
	 * @var null | \view\LoginView
	 */

	/**
	*	Checks inputted login-data against /model/User object	
	*
	*	@param string $username
	* 	@param string $password
	* 	@return  void
	*/

	function __construct($users)
	{
		$this->users = $users;		
	}

	public function tryTologin($username, $password,$isCookie=false)
	{
		$users = $this->users->getUsers();

		foreach ($users as $user)
		{	
			if($isCookie)
			{
				
				if($user->getUsername() == $username && $user->getPassword() == $password)
				{
					$_SESSION['user'] = $username;
					return true;
				}
			}

			else if($user->getUsername() == $username && $user->getPassword() == md5($password))
			{
				if(!isset($_SESSION['user']))
				{
					$_SESSION['user'] = $user->getUsername();	
					
				}

				return true;
			} 
		}

		return false;
		
	}

	

	
	/**
	*	Unsets session index user, logging the user out.
	*
	*	@param string $username
	* 	@param string $password
	* 	@return  void
	*/
	public function logout()
	{					
			//unset the index 'user' of global arr. $_SESSION
			unset($_SESSION['user']);			
			//end session
			session_destroy();
			ob_end_flush();
	}
}


