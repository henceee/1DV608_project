<?php

class Image
{

	private $width;
	private $height;
	private $basename;


	function __construct($width,$height,$basename)
	{
		$this->width = $width;
		$this->height = $height;
		$this->basename = $basename;
	}


	/**
	*	Get the info height of the image
	*	@return array imgInfo
	*/
	public function getHeight()
	{
		return $this->height;
	}

	/**
	*	Get the info width of the image
	*	@return array imgInfo
	*/
	public function getWidth()
	{
		return $this->width;
	}

	/**
	*	
	*	@return string basename
	*/
	public function getBaseName()
	{
		return $this->basename;
	}


}