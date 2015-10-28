<?php

class CommentDAL
{
	private static $commentTable = "contentcomments";
	private static $databaseName = "memegallery";
	private $database;

	function __construct(Database $db)
	{
		$this->database = $db;	
		
	}

	/**
	* add comment to the database
	* @param contentID - uniqe identifier for the content
	* @param string name 
	* @param string comment 
	* @return void
	*/
	public function addComment($contentID,$name, $comment)
	{
		//INSERT INTO `memegallery`.`contentcomments` (`contentID`, `name`, `comment`) VALUES ('1', 'as', 'as');
		$query = "INSERT INTO ".self::$commentTable." (`contentID`, `name`, `comment`) VALUES(?,?,?)";
		//echo $query;
		$params = array($contentID,$name,$comment);
		$this->database->ExecuteQuery($query,$params);
	}

	/**
	*	Acquire all comments for specific content from the database.
	*	@param ID - unique identifier for the content
	*	@return array -comments
	*/
	public function getComments($ID)
	{		
				//SELECT * FROM `contentcomments` WHERE contentID = 1
		$query = "SELECT * FROM " .self::$commentTable." WHERE contentID =".$ID." ORDER BY ID DESC";
		$params = array();
		$comments = $this->database->ExecuteSelectQueryAndFetchAll($query,$params);

		return  $comments;	
	}
	
}