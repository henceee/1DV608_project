<?php

class Content
{
	private $id;
	private $title;
	private $image;
	private $description;


	function __construct($id,$title,Image $image, $description)
	{
		$this->id =$id;
		$this->title =$title;
		$this->image =$image;
		$this->description =$description;
	}

	/**
	* Get the identifer for the content 
	* @return identifer for the content
	*/
	public function getID()
	{
		return $this->id;
	}

	/**
	* Get title of the content.
	* @return string Title
	*/
	public function getTitle()
	{
		return $this->title;
	}

	/**
	* Get the image of the content
	* @return Image reference
	*/
	public function getImage()
	{
		return $this->image;
	}


	/**
	* Get the description of the content.
	* @return string Description
	*/
	public function getDescription()
	{
		return $this->description;
	}

}