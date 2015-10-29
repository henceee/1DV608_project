<?php

class ImageView
{
	public $title ="";
	public $response ="";
	private $viewImgHTML;
	public $message="";
	/**
	*	Access all the argumentrs in the URL
	*	@return array - arguments from the URL
	*/
	public function getArgsFromURL()
	{
		// Get the incoming arguments
		$src     	= isset($_GET['src'])			? $_GET['src']      : null;
		$saveAs   	= isset($_GET['save-as'])		? $_GET['save-as']  : null;
		$quality  	= isset($_GET['quality'])		? $_GET['quality']  : 60;
		$newWidth   = isset($_GET['width'])			? $_GET['width']	: null;
		$newHeight  = isset($_GET['height'])		? $_GET['height']  	: null;
		$cropToFit  = isset($_GET['crop-to-fit'])	? true 				: null;
		$sharpen    = isset($_GET['sharpen']) 		? true 				: null;
		$ignoreCache = isset($_GET['no-cache']) 	? true          	: null;
		$this->viewImgHTML = isset($_GET['view']) 	? true          	: null;
		return array("src"		=>	$src ,
					 "saveAs"	=>  $saveAs,
					 "quality"	=>  $quality ,
					 "newWidth"	=>	$newWidth ,
					 "newHeight"=> 	$newHeight ,
					 "cropToFit"=> 	$cropToFit,
					 "sharpen"	=>	$sharpen,
					 "ignoreCache" => $ignoreCache);
		
	}

	/**
	*	Get HTML response
	*	@return string -HTML outupt
	*/
	public function getResponse()
	{
		return $this->response;
	}


	/**
	*	Create HTML response
	*	@return image || string -HTML outupt
	*/
	public function renderHTML($header,$path)
	{		
			header($header);
			readfile($path);			
			$this->response = $this->message."<img src='$path'/>";			
	}
	
}