<?php

class RegFacade {
	private $users;

	public function __construct( userDAL $dal) {
		$this->dal = $dal;
	
	}

	/**
	*	Adds user to database.
	*	@return void
	*/
	public function add(user $user) {
		
		$this->dal->add($user);	
	}

	/**
	*	Acquires users from database.
	*	@return UserCatalog
	*/
	public function getUsers() {
		return $this->dal->getUsers();
	}
}