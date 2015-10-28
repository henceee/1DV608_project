<?php

class CommentController
{

	private $view;
	private $DAL;

	function __construct(CommentView $view, CommentDAL $DAL)
	{
		$this->view = $view;
		$this->DAL = $DAL;
	}
	public function addComment()
	{
		$contentID = $this->view->ID;
		$name = $this->view->getName();
		$comment = $this->view->getComment();
		$this->DAL->addComment($contentID,$name, $comment);
	}
	
	public function doComment($ID)
	{
		if($this->view->userWantsToComment())
		{
			$this->addComment();
		}

		$comments = $this->DAL->getComments($ID);

		return $comments;
	}
}