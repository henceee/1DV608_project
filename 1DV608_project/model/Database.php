<?php

class Database
{
	/**
   * Members
   */
	
 
  private $dsn = "mysql:host=localhost;dbname=";
  private $username = "root";
  private $password ="";
  private $driver_options;
  private $fetchMode;
  private $db   = null;               // The PDO object
  private $stmt = null;               // The latest statement used to execute a query

  /**
   * Constructor creating a PDO object connecting to a choosen database.
   *
   * @param array $options containing details for connecting to the database.
   *
   */
  public function __construct($databaseName='')
  {
  	$this->fetchMode = PDO::FETCH_ASSOC;
  	$this->driver_options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");
  	//$anax['database']['dsn']            = 'mysql:host=localhost:3305;dbname=';
   
    $this->dsn.= $databaseName;      

    $this->createDB();    

  }


  /**
  *	set DSN by adding database name, create the PDO object and set fetchmode
  * @return void
  */
  public function setDSNAndCreate($databaseName)
  {
  	$this->dsn.=$databaseName;
  	$this->createDB();
  }

  /**
  *	create the PDO object and set fetchmode
  * @return void
  */
  public function createDB()
  {
  	$this->db = new PDO($this->dsn, $this->username, $this->password, $this->driver_options);
    
    $this->db->SetAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, $this->fetchMode); 
  }

   /**
   * Execute a select-query with arguments and return the resultset.
   * 
   * @param string $query the SQL query with ?.
   * @param array $params array which contains the argument to replace ?.
   * @return array with resultset.
   */
  public function ExecuteSelectQueryAndFetchAll($query, $params=array())
  {
    // Make the query
    $stmt = $this->db->prepare($query);
    if ($stmt === FALSE)
    {
		throw new Exception($this->database->error);
	}
    $stmt->execute($params);
    $res = $stmt->fetchAll();
   
    return $res;
  }

   /**
   * Execute a SQL-query and ignore the resultset.
   *
   * @param string $query the SQL query with ?.
   * @param array $params array which contains the argument to replace ?.
   * @param boolean $debug defaults to false, set to true to print out the sql query before executing it.
   * @return boolean returns TRUE on success or FALSE on failure. 
   */
  public function ExecuteQuery($query, $params = array())
  {
    // Make the query
    $stmt = $this->db->prepare($query);
    if ($stmt === FALSE)
    {
		  throw new Exception($this->database->error);
	  }
    $res = $stmt->execute($params);
   
    return $res;
  }
}