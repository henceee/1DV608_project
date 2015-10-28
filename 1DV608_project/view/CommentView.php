<?php

class CommentView
{
	public static $name = "content::name";
	public static $comment = "content::comment";
	public static $submit = "content::submit";
	public $ID;


	/**
	*	Get the contentID from contentView
	*	@return void
	*/
	public function setID($ID)
	{
		$this->ID = $ID;
	}

	/**
	*	Get the inputted name
	*	@return string -name || null
	*/
	public function getName()
	{
		return isset($_POST[self::$name]) ? $_POST[self::$name] : null;
	}

	/**
	*	Get the inputted comment 
	*	@return string comment || null
	*/
	public function getComment()
	{
		return isset($_POST[self::$comment]) ? $_POST[self::$comment] : null;
	}

	/**
	*	Get the username if the user is logged in
	*	from session var.
	*	@return string name || empty str
	*/
	public function getSessionUserName()
	{	
		if(isset($_SESSION['user']))
		{
			return $_SESSION['user'];
		}
		return "";
	}

	/**
	*	render HTML for the form & comment input
	*	@return string -html
	*/
	public function renderCommentForm()
	{
		return '<h3>Comments</h3>
				<form method="post" > 										
					<label for="' . self::$name . '">Username :</label><br><br>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value ="'.$this->getSessionUserName().'
					" /><br><br>
					<textarea rows="10" cols="21" id='.self::$comment.' name='.self::$comment.'></textarea><br><br>					
					<input type="submit" name="' . self::$submit . '" value="submit" />				
				</form>	';
	}


	/**
	*	render all the comments
	*	@return string -html
	*/
	public function renderComments($comments)
	{
		$html ="";

		foreach ($comments as $comment)
		{
			$html.="<p><b>".$comment['name']."</b> said:</p>
					<p>".$comment['comment']."</p>";
			
		}

		return $html;
	}


	/**
	*	Check if submit has been pressed.
	*	@return bool
	*/
	public function userWantsToComment()
	{
		return isset($_POST[self::$submit]);
	}
}