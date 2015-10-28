<?php

class ContentDAL
{
	private static $contentTable = "content";
	private static $usersTable = "users";
	private static $databaseName = "memegallery";
	private $database;

	function __construct(Database $db)
	{
		$this->database = $db;	
		$this->database->setDSNAndCreate(self::$databaseName);
	}


	/**
	*	Acquire all users from the database.
	*	@return userCatalog
	*/
	public function getContent()
	{				
		$query = "SELECT * FROM ".self::$contentTable;
				
		$params = array();
		$content = $this->database->ExecuteSelectQueryAndFetchAll($query,$params);

		return  $content;	
	}

	/**
	*	Insert new content into database
	*	@return void
	*/
	public function insertContent($userID,$title,$ImgSrc,$Description)
	{
		//"INSERT INTO ".self::$commentTable." (`contentID`, `name`, `comment`) VALUES(?,?,?)";
		$query = "INSERT INTO ".self::$contentTable." (`userID`, `Title`, `ImgSrc`, `Description`) VALUES(?,?,?,?)";

		$params = array($userID,$title,$ImgSrc,$Description);

		$this->database->ExecuteQuery($query,$params);
	}
}