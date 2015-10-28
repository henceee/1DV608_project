<?php

class ContentView
{
	public $title ="";
	public $response ="";
	private $contentCatalog;
	

	function __construct(commentView $commentView)
	{
		$this->commentView = $commentView;
		$id =$this->getID();
		$this->commentView->setID($id);
	}
	

	/**
	*	Get the HTML response.
	*	@return string -HTML outupt
	*/
	public function getResponse()
	{	
		return $this->response;
	}
	
	/**
	*	Get the content ID
	*	@return id of the content||null
	*/
	public function getID()
	{
		return $id= isset($_GET['ID'])? $_GET['ID']: null;
	}

	/**
	*	create HTML response
	*	@return void
	*/
	public function createHTML($content,$comments)
	{
		if(!is_null($content))
		{	
			$title 		 = $content->getTitle();
			$image		 = $content->getImage();
			$description = $content->getDescription();
			
			$width 		 = $image->getWidth();
			$height 	 = $image->getHeight();
			$href 		 = $image->getBaseName();
			$title 		 = $content->getTitle();

			$html = "
			<h1>{$title}</h1>
			<p>
				<a href='?image&src={$href}'><img src='?image&amp;src={$href}&width=500' alt=''/></a>
			</p>
			<p><i>{$description}</i></p>";

			$html .= $this->commentView->renderCommentForm();
			$html .= $this->commentView->renderComments($comments);

			$this->response = $html;	
		
		}else{

			$this->response="<p>Oops, something went wrong.This content does not seem to exist<p>";
		}
	}

	
}