<?php

class RegisterController
{

	private $model;
	private $view;
	private static $msgMessage ="message";
	
	public function __construct(RegFacade $reg, RegView $regView)
	{
		$this->model = $reg;
		$this->view = $regView;

	}

	/**
	*	Adds user, if username does not contain
	* 	invalid chars, and input length is correct.
	*	@return void
	*/
	public function addUser()
	{		

		if ($this->view->wantsToCreateUser())
		{
			$username = $this->view->getUserName();	
			$password = $this->view->getPassword();
			
			if(!is_null($username) && !is_null($password))
			{
				$user = new User($username, $password);

				try
				{
					$this->model->add($user);
					$_SESSION[self::$msgMessage] = "Registered new user.";
					
				}
				catch (noUserNameException $e)
				{
					$_SESSION[self::$msgMessage] .= "Username has too few characters, at least 3 characters";		
				} 
				catch (noPassWordException $e)
				{
					$_SESSION[self::$msgMessage] .= "Password has too few characters, at least 6 characters.";		
				} 
				catch (Exception $e)
				{
					$this->view->setDuplicate();
				}

			}							
				
						
		}	
	}
}
	
