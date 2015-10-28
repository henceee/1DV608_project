<?php

class AdminView
{

	private static $imageFile ="admin::imageFile";
	private static $submit ="admin::submit";
	private static $imageText1 ="admin::imgtext1";
	private static $imageText2 ="admin::imgtext2";
	private static $imageText3 ="admin::imgtext3";
	private static $preview ="admin::preview";
	private static $titleInput ="admin::title";
	private static $desc ="admin::desc";
	private static $save ="admin::save";
	private static $message ="admin::message";
	private static $msgMessage = "message";

	public $title="Upload Image";
	public $response ='';
	public $cachePath ='';

	/**
	*	Get the contnt description
	*	@return string description
	*/
	public function getDesc()
	{
		return isset($_POST[self::$desc])? $_POST[self::$desc] : "";
	}

	/**
	*	Get the content title
	*	@return string title
	*/
	public function getTitle()
	{
		return isset($_POST[self::$titleInput])? $_POST[self::$titleInput] : "";
	}

	/**
	*	
	*	@return bool
	*/
	public function userWantsToSave()
	{
		return isset($_POST[self::$save]);
	}

	public function ImageArgExist()
	{
		return isset($_GET['img']);
	}

	/**
	*	Get the image name and extension from
	*	the URL
	*	@return string -image path
	*/
	public function getImage()
	{
		return isset($_GET['img'])? $_GET['img']:"";
	}

	/**
	*	
	*	@return bool
	*/
	public function userWantsToPreview()
	{
		return isset($_POST[self::$preview]);
	}

	/**
	*	Get the first permitted string 
	*	to be added to the image
	*	@return string text
	*/
	public function getImgText1()
	{
		return isset($_POST[self::$imageText1])? $_POST[self::$imageText1] : "";
	}

	/**
	*	Get the second permitted string 
	*	to be added to the image
	*	@return string text
	*/
	public function getImgText2()
	{
		return isset($_POST[self::$imageText2])? $_POST[self::$imageText2] : "";
	}

	/**
	*	Get the third permitted string 
	*	to be added to the image
	*	@return string text
	*/
	public function getImgText3()
	{
		return isset($_POST[self::$imageText3])? $_POST[self::$imageText3] : "";
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

	public function getUploadedImage()
	{
		if($this->userHasSubmitted())
		{
			$allowedExt = array("png","jpg","jpeg");		
			$baseName = $_FILES[self::$imageFile]['name'];
			$extension = pathinfo($baseName)['extension'];
			if(in_array($extension, $allowedExt))
			{				
				return $_FILES[self::$imageFile];
			}
			

			$_SESSION[self::$msgMessage] = "Invalid file extension. Only png,jpg, jpeg allowed.";
			return null;
		}
		
	}
	/**
	*	If the user has uploaded a file
	*	@return bool
	*/
	public function userHasSubmitted()
	{
		return isset($_POST[self::$submit]);
	}


	/**
	*	Render the HTML depending on args in the URL
	*	@return void
	*/
	public function renderHTML()
	{
		if($this->ImageArgExist() && is_file($this->cachePath.$_GET['img']))
		{
			$imgHTML = "<img src=".$this->cachePath.$_GET['img'].">";

			if(isset($_GET['save']))
			{
				$this->title = "Save Content";

				$this->response="
				<form method='POST'>
				<label for='".self::$titleInput."'> Title </label><br>
				<input type='text' id='".self::$titleInput."' name='".self::$titleInput."'/><br><br>
				".$imgHTML."<br>
				<label for='".self::$desc."'> Description </label><br>
				<textarea rows='10' cols='50' id='".self::$desc."' name='".self::$desc."'></textarea><br><br>
				<input type='submit' value='Save' name='".self::$save."'>
				</form><br><br>";
			}
			else
			{
				$this->response.= $imgHTML."
				<form method='POST'>
			 	<legend>Add Text</legend>
				<fieldset id='imgText'>
					<label for='".self::$imageText1."'> Text 1 </label><br>
					<input type='text' id='".self::$imageText1."' name='".self::$imageText1."' />
					<br><br><br>
					<label for='".self::$imageText2."'> Text 2 </label><br>
					<input type='text' id='".self::$imageText2."' name='".self::$imageText2."' /><br>
					<label for='".self::$imageText3."'> Text 3 </label><br>
					<input type='text' id='".self::$imageText3."' name='".self::$imageText3."' /><br><br>
				</fieldset>
				<br>
				<input type='submit' value='Preview' name='".self::$preview."'><br>

				</form>";	
			}
			

		}

		//TODO: if GET var exists w. src, cached =>render text form.
		else
		{
			$this->response .= "
			 <form method='POST' enctype= 'multipart/form-data'>
			 <p id='". self::$message ."'>". $this->getMessage() ."</p>
			 <input type='file' name='".self::$imageFile."' id='".self::$imageFile."'><br><br>
			 
			 <br>
			<input type='submit' value='submit' name='".self::$submit."'><br>
			";
		}
		 
		$this->response .="<a href='?admin'>Cancel</a>";
	}

	/**
	*	
	*	@return string
	*/
	public function getResponse()
	{
		return $this->response;
	}
}