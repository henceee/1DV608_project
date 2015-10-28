<?php

require_once('view/globalsLoginView.php');

class LoginView extends globalsLogin
{		

	public $response ="";
	public $title ="";
	private $nav;
	
	function __construct($nav)
	{
		$this->nav = $nav;
		//$this->title = $this->getTitle();
	}

	public function getTitle()
	{
		return isset($_SESSION['user']) ? "Logout" :"Login";
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	public function generateLogoutButtonHTML() {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $this->getMessages() .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	public function generateLoginFormHTML() 
	{
		return '			
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $this->getMessages() . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value ="'.$this->getUserNameSession().'" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}
	
	/**
	*	Accsesses message from session variable, saves in local var, unsets the index
	*	and gives the message to be presented
	* 	@return  string $msg
	*/
	public function getMessages()
	{
		$types = array(self::$msgError,self::$msgMessage, self::$msgSucess);
		foreach ($types as $type)
		{
			if(isset($_SESSION[$type]) && !empty($_SESSION[$type]))
			{
					$msg = $_SESSION[$type];
					unset($_SESSION[$type]);
					return $msg;					
				
			}
		}
		
	}

	/**
	*	Get html response
	* 	@return  string -HTML output
	*/
	public function getResponse()
	{
		return (isset($_SESSION['user'])) ?
			$this->generateLogoutButtonHTML() : $this->generateLoginFormHTML();
	}
}