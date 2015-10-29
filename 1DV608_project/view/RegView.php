<?php
require_once('view/globalsRegView.php');


/*
*	OBS: Inherits from helpclass globalRegView
*	which handles global vars.
*/
class RegView extends globalsRegView
{
	protected static $msgMessage	 = 'message';
	public $title ="Register";

	/**
	 * @ null || navigationView
	 */
	private $nav =null;

	function __construct($nav)
	{
		$this->nav = $nav;
		
	}

	/**
	*	Renders HTML output for the registration form.
	*	@return string
	*/
	public function getResponse()
	{
		$message = $this->getMessage();	
		return $this->nav->getReturnURL()."
		<p>".$message."</p>
		<form method='post'>
		<fieldset>
		<legend>Register</legend>
		<label for='".self::$userPostID."'>Username</label><br>
		<input id='".self::$userPostID."' type='text' name='".self::$userPostID."' value ='".$this->getUserNameSession()."'/><br>
		<label for='".self::$passPostID."'>Password</label><br>
		<input id='".self::$passPostID."' type='password' name='".self::$passPostID."'></input><br>
		<label for='".self::$pass2PostID."2'>Repeat your password</label><br>
		<input id='".self::$pass2PostID."' type='password' name='".self::$pass2PostID."'></input></p>
		<p><input type='submit' name='".self::$submitPostID."'></p>
		</fieldset>
		</form>
		";
	}

	/**
	*	Get message to be outputted	
	*	@return string message
	*/
	public function getMessage()
	{
		$message = isset($_SESSION[self::$msgMessage])? $_SESSION[self::$msgMessage] : $_SESSION[self::$msgMessage]="";
		unset($_SESSION[self::$msgMessage]);
		return $message;
	}


	/**
	*	Get the inputted passwords, validate and return.
	*	@return string password ||  null
	*/
	public function getPassword()
	{
		$password = $_POST[self::$passPostID]; 
		$password2 = $_POST[self::$pass2PostID]; 

		if($password ==$password2)
		{
			if(strlen($password) < 6)
			{
			@$_SESSION[self::$msgMessage] .= "Password has too few characters, at least 6 characters.";
			}
			else
			{
			return $password;
			}	
		}
		
		@$_SESSION[self::$msgMessage]  .= "Passwords do not match";

		return null;
	}
	/**
	*	Gets the user information
	*	from the user input
	*	@return array || null
	*/
	public function getUserName()
	{
		$username = $_POST[self::$userPostID];

		
			if(preg_match("/(\W)(\D)(\S)/", $username))
			{
				@$_SESSION[self::$msgMessage]  .="Username contains invalid characters";
			}
			else
			{			
				if(strlen($username) < 3)
				{
					
					@$_SESSION[self::$msgMessage] .= "Username has too few characters, at least 3 characters.";
				}
				else
				{
					return $username;
				}				
			}
	}

	/**
	*	Generates message for duplicate usernames
	*	@return void
	*/
	public function setDuplicate() {
		@$_SESSION[self::$msgMessage]  .= "User exists, pick another username.";
	}

	

}
	