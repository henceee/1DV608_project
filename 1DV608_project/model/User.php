<?php

// Hacks for specialized exceptions
class noUserNameException extends Exception {};
class noPassWordException extends Exception {};


class User
{
	//private $content;
	private $username;

	private $password;

	private $id;

	function __construct($username,$password,$id=null)
	{			
		if(is_string($username) == false || strlen($username) < 3)
		{
			throw new noUserNameException();
		}
		if(is_string($password) == false || strlen($password) < 6)
		{
			throw new noPassWordException();
		}

		$this->username = $username;
		$this->password = $password;

		if(!isset($id))
		{
			$this->id = uniqid();

		}else{

			if(!empty($id))
			{
				$this->id = $id;
			}
		}
		
				
	}	

	/**
	*	Acquire username of the user.
	*	@return string - username
	*/
	public function getUsername()
	{
		return $this->username;
	}
	
	/**
	*	Acquire password of the user.
	*	@return string - password
	*/
	public function getPassword()
	{
		return $this->password;
	}
	
	/**
	*	Acquire uniqe identifier of the user.
	*	@return string - ID
	*/
	public function getID()
	{
		return $this->id;
	}

}