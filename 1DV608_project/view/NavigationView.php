<?php

class navigationView
{
	private static $loginURL ="login";
	private static $regURL ="register";
	private static $galleryURL ="gallery";
	private static $imgURL ="image";
	private static $contentURL ="content";
	private static $uploadUrl ="admin";


	/**
	*	
	*	@return void
	*/
	public function redirToAdmin()
	{
		header("location:?".self::$uploadUrl);
	}

	public function wantsToUpload()
	{
		return isset($_GET[self::$uploadUrl]);
	}
	/**
	*	Determines what view is to be used
	*	by checking url.
	*	@return bool
	*/
	public function wantsToViewContent()
	{
		return isset($_GET[self::$contentURL]);
	}

	/**
	*	Determines what view is to be used
	*	by checking url.
	*	@return bool
	*/
	public function wantsToViewImage()
	{
		return isset($_GET[self::$imgURL]);
	}

	/**
	*	Determines what view is to be used
	*	by checking url.
	*	@return bool
	*/
	public function wantsToReg()
	{
		return isset($_GET[self::$regURL]);
	}

	/**
	*	Determines what view is to be used
	*	by checking url.
	*	@return bool
	*/
	public function wantsToLogin()
	{
		return isset($_GET[self::$loginURL]);
	}

	/**
	*	Gets the link to return to login || register page
	*	@return string - HTML output
	*/
	public function getReturnURL()
	{

		if($this->wantsToLogin())
		{
			return "<a href='?register'>Register<a>";
		}
		if($this->wantsToReg())
		{
			return "<a href='?login'>Back To Login<a>";
		}
	}

}