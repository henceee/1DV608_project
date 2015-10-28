<?php

require_once('view/LoginView.php');
require_once('model/Authenticate.php');

class LoginController
{

	private static $msgError 	= 'error';
	private static $msgSucess 	= 'sucess';
	private static $msgMessage	= 'message';
	private static $cookieName 	= 'LoginView::CookieName';
	private $loginView = null;
	private $isLoggedIn = false;

	/**
	 * @var null | \model\Login
	 */
	private $authenticate = null;

	function __construct(UserCatalog $users,NavigationView $nav)
	{	
		$this->authenticate = new Authentication($users);
		$this->loginView = new loginView($nav);		
		$this->users = $users;		
	}

	/**
	*	Gets required pass and username if posted, checks if user
	*	wants to login, tries to authenticate, or logs out if user wants
	*	to logout.
	* 	@param bool $isLoggedIn
	* 	@return  void
	*/
	public function doLogin()
	{

		$userNameCookie = $this->loginView->getUserNameCookie();
		$passwordCookie = $this->loginView->getPasswordCookie();

		
		if(isset($userNameCookie) && isset($passwordCookie))
		{
			$this->isLoggedIn=$this->authenticate->tryTologin($userNameCookie,$passwordCookie,true);
		}

		$reqUsername = $this->loginView->getRequestUserName();
		$reqPass = $this->loginView->getRequestPassword();

		if($this->loginView->userWantsToLogin())
		{
			$this->isLoggedIn=$this->authenticate->tryTologin($reqUsername,$reqPass);			
		}
		/* 	Since logout operation requires session variable to be set, after authenticating
		*	login details, It really should not matter if the message is still 'Bye bye'
		*/
		else if(isset($_SESSION['user']) && $this->loginView->userWantsToLogout())
		{
				$this->authenticate->logout();
				$this->isLoggedIn = false;				
		}
		return $this->isLoggedIn;
	}

	/**
	 * Create response by setting to session
	 *
	 * @return  LoginView
	 */
	public function getOutput() {
		
		$this->isLoggedIn = isset($_SESSION['user']);
		
		if($this->loginView->userWantsToSave())
		{
			$this->loginView->getUserNameCookie();
			$this->loginView->getPasswordCookie();
		}

		$reqPass 	 = $this->loginView->getRequestPassword();
		$reqUserName = $this->loginView->getRequestUserName();

		if(empty($Post))
		{			
			$_SESSION[self::$msgSucess]  ="";
			$_SESSION[self::$msgError] 	 ="";
			$_SESSION[self::$msgMessage] =""; 
		}
		if($this->loginView->userWantsToLogin() && !$this->isLoggedIn)
		{

			$_SESSION[self::$msgError] = "Wrong name or password";
			
		}
					
		if($this->loginView->userWantsToLogin())
		{

			if(empty($reqPass))
			{
				$_SESSION[self::$msgError] ='Password is missing';
			}
			if(empty($reqUserName))
			{
				$_SESSION[self::$msgError] = 'Username is missing';
			}	

			if(isset($_COOKIE[self::$cookieName]) && $this->isLoggedIn)
			{				
				$_SESSION[self::$msgSucess] ="Login with cookies. Hello again ".$_COOKIE[self::$cookieName].".";
			
			}

		}

		if($this->loginView->userHasInputtedName() && $this->loginView->userHasInputtedPassword())
		{
			if($this->loginView->userWantsToSave())
			{
				$this->loginView->getUserNameCookie();
			}
		}

		if($this->loginView->userWantsToLogin() && $this->isLoggedIn)
		{
			$_SESSION[self::$msgSucess] = 'Welcome';
		}

		if($this->loginView->userWantsToLogout())
		{			
			$_SESSION[self::$msgMessage] ="Bye bye!";
		}
		
		return $this->loginView;
	}
}