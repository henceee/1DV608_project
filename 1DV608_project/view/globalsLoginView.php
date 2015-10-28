<?php

class globalsLogin
{
	protected static $login			 = 'LoginView::Login';
	protected static $logout 		 = 'LoginView::Logout';
	protected static $name 			 = 'LoginView::UserName';
	protected static $password 		 = 'LoginView::Password';
	protected static $cookieName 	 = 'LoginView::CookieName';
	protected static $cookiePassword = 'LoginView::CookiePassword';
	protected static $keep 			 = 'LoginView::KeepMeLoggedIn';
	protected static $messageId 	 = 'LoginView::Message';
	protected static $msgError 		 = 'error';
	protected static $msgSucess 	 = 'sucess';
	protected static $msgMessage	 = 'message';

	/**
	*	Acquires the saved username for the
	*	according input. If not set, calls
	*	set function.
	*	@return string
	*/
	public function getUserNameSession()
	{
		
		$this->setUserNameSession();	
		
		return $_SESSION['un'];
	}

	/**
	*	Sets the saved username for acc.
	*	input	
	*	@return string
	*/
	public function setUserNameSession()
	{
		if($this->userHasInputtedName())
		{
			$_SESSION["un"] = $this->getRequestUserName();	
		}
		else
		{
			$_SESSION["un"]="";
		}
		
	}		


	/**
	*	Gets the username from cookie.	
	*	@return string
	*/
	public function getUserNameCookie()
	{		
			$name = $this->getRequestUserName();
			setcookie(self::$cookieName, $name, time() + 60*60*24*365);
			$_COOKIE[self::$cookieName] = $name;
									
			return $name;		
	}

	/**
	*	Gets the password from cookie.	
	*	@return string
	*/
	public function getPasswordCookie()
	{		
			$password = $this->getRequestPassword();
			$password = md5($password);
			setcookie(self::$cookieName, $password, time() + 60*60*24*365);	
			$_COOKIE[self::$cookiePassword] = $password;
			return $password;		
	}

	/**
	 *	Check if there has been a http post request to page by pressing 'login' button
	 *	@return  bool
	 */
	public function userWantsToLogin()
	{
		return (isset($_POST[self::$login]) ? true : false);
	}

	/**
	 *	Check if there has been a http post request to page by pressing 'log out' button
	 *	@return  bool
	 */
	public function userWantsToLogout()
	{
		return (isset($_POST[self::$logout]) ? true : false);
	}

	/**
	 *	Check if name is set in global array $_POST (from input for username)
	 *	@return  bool
	 */
	public function userHasInputtedName()
	{
		return (isset($_POST[self::$name]) ? true : false);
		
	}
	
	/**
	 *	Provides the username provided by the user
	 *	@return  string (Username)
	 */
	public function getRequestUserName() {
		
		if($this->userHasInputtedName())
		{			
			return $_POST[self::$name];
		}
	}
	
	/**
	 *	Check if password is set in global array $_POST (from input for password)
	 *	@return  bool
	 */
	public function userHasInputtedPassword()
	{
		return (isset($_POST[self::$password]) ? true : false);
		
	}

	/**
	 *	Provides the password provided by the user
	 *	@return  string (Password)
	 */
	public function getRequestPassword() {
		
		if($this->userHasInputtedPassword())
		{
			return $_POST[self::$password];
		}
	}

	/**
	 *	Check if keep is set in global array $_POST (from input 'keep me logged in')
	 *	@return  bool
	 */
	public function userWantsToSave()
	{
		return (isset($_POST[self::$keep]));
		
	}

	
}	