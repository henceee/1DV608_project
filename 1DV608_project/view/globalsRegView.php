<?php

class globalsRegView
{
	protected static $userPostID 	 = "RegView::Username";
	protected static $passPostID 	 = "RegView::Password";
	protected static $pass2PostID 	 = "RegView::Password2";
	protected static $submitPostID 	 = "RegView::submit";

	/**
	*	Checks if user has submitted
	*	and wishes to create new user.
	*	@return bool
	*/
	public function wantsToCreateUser()
	{
		
		return isset($_POST[self::$submitPostID]);
	}

	/**
	*	Acquires the inputted username 
	*	@return string
	*/
	public function getUserName()
	{
		if(isset($_POST[self::$userPostID]))
		{
			return $_POST[self::$userPostID];
		}
		return "";
	}
	/**
	*	Acquires the inputted password 
	*	@return string
	*/
	public function getPass()
	{
		if(isset($_POST[self::$passPostID]))
		{
			return $_POST[self::$userPostID];
		}
		return "";
	}
	/**
	*	Acquires the inputted password which was
	*	repeated.
	*	@return string
	*/
	public function getPass2()
	{
		if(isset($_POST[self::$pass2PostID]))
		{
			return $_POST[self::$pass2PostID];
		}
		return "";
	}
	/**
	*	Acquires the saved username for the
	*	according input. If not set, calls
	*	set function.
	*	@return string
	*/
	public function getUserNameSession()
	{	
		$this->setUserNameSession();
		
		return $_SESSION['unReg'];	
	}

	/**
	*	Sets the saved username for acc.
	*	input	
	*	@return string
	*/
	public function setUserNameSession()
	{
		if($this->wantsToCreateUser())
		{
			$_SESSION["unReg"] = $this->getUserName();	
		}
		else
		{
			$_SESSION["unReg"]="";
		}
		
	}

}