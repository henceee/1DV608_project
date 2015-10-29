<?php

require_once("content.php");

class ContentCatalog
{

	private $content = array();

	/**
	* Add user to user catalog.
	* @return void
	*/
	public function add(content $toBeAdded)
	{	
		if(!$this->contentExist($toBeAdded))
		{
			$key = $toBeAdded->getID();	
			$this->content[$key] = $toBeAdded;
		}	
		
	}

	/**
	 * Acquire users from user catalog.
	 * @return array of model\User
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	* Checks if a certain user exists
	* by comparing usernames.
	* @return bool
	*/
	public function contentExist($checkContent)
	{
		foreach ($this->content as $cont)
		{
			if ($cont->getID() === $checkContent->getID())
			{
				return true;
			}
		}

		return false;
	}
	
	/**
	* Checks if a certain user exists
	* by comparing usernames.
	* @return bool
	*/
	public function getContentImgByID($id)
	{
		//var_dump($this->content);
		foreach ($this->content as $cont)
		{
			$img =$cont->getImage();				
			
			if($img->getBaseName() == $id)
			{
				return $img;
			}			
		}
		return null;
		
	}

	/**
	*	Get identifier for specific content
	* @return identifier for specific content
	*/
	public function getContentByID($ID)
	{
		return isset($this->content[$ID])? $this->content[$ID] : null;
	}
}