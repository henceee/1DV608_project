<?php
require_once("model/UserCatalog.php");
class UserDAL
{
	private static $table = "users";
	private static $databaseName = "memegallery";
	private $database;
	private $userCatalog;

	function __construct(Database $db)
	{
		$this->database = $db;	
		$this->userCatalog = new UserCatalog();		
		$this->database->setDSNAndCreate(self::$databaseName);
	}

	/**
	*	Acquire all users from the database.
	*	@return userCatalog
	*/
	public function getUsers()
	{			
		$query = "SELECT * FROM " . self::$table;
		$params = array();
		$users = $this->database->ExecuteSelectQueryAndFetchAll($query,$params);

		foreach ($users as $user)
		{
			$user = new User($user['Username'], $user['Password'],$user['ID']);	
			$this->userCatalog->add($user);
			
		}
		return  $this->userCatalog;	
	}

	/**
	*	Add username of the database.
	*	@return void
	*/
	public function add(User $toBeAdded)
	{	

		$this->userCatalog = $this->getUsers();
		
		//Check if exists before inserting into database.
		if(!$this->userCatalog->userExists($toBeAdded))
		{	
			$query = "INSERT INTO  `".self::$table."`(
				`ID` , `Username` , `Password`)
					VALUES (?, ?, ?)";
			
			$id = $toBeAdded->getID();
			$username = $toBeAdded->getUsername();
			$password = md5($toBeAdded->getPassword());
			
			$params = array($id,$username,$password);

			$this->database->ExecuteQuery($query,$params);
		}
		else
		{
			throw new  Exception("User with this userName already exists.");
			
		}
	}
}


