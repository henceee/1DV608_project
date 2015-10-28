<?php
require_once("model/User.php");
class UserCatalog
{	

	private $users = array();

	/**
	* Add user to user catalog.
	* @return void
	*/
	public function add(User $toBeAdded)
	{
		if(!$this->userExists($toBeAdded))
		{
			$key = $toBeAdded->getID();	
			$this->users[$key] = $toBeAdded;
		}	
		
	}

	/**
	 * Acquire users from user catalog.
	 * @return array of model\User
	 */
	public function getUsers() {
		return $this->users;
	}

	/**
	* Checks if a certain user exists
	* by comparing usernames.
	* @return bool
	*/
	public function userExists($checkUser)
	{
		foreach ($this->users as $user)
		{
			if ($user->getUsername() === $checkUser->getUsername())
			{
				return true;
			}
		}

		return false;
	}
	
	/**
	* Checks if a certain user exists
	* by comparing usernames.
	* @return User $user
	*/
	public function getUserByName($name)
	{
		foreach ($this->users as $user)
		{
			if($user->getUsername() == $name)
			{
				return $user;
			}
		}
	}
}