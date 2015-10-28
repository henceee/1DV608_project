<?php

require_once("view/galleryView.php");
require_once("view/NavigationView.php");
require_once("view/ContentView.php");
require_once("view/NavigationView.php");
require_once("view/RegView.php");
require_once('view/LoginView.php');
require_once('view/ImageView.php');
require_once('view/CommentView.php');
require_once('view/UploadView.php');
require_once("controller/ImageController.php");
require_once("controller/LoginController.php");
require_once("controller/RegisterController.php");
require_once("controller/GalleryController.php");
require_once("controller/ContentController.php");
require_once("controller/CommentController.php");
require_once("controller/uploadController.php");
require_once("model/UserCatalog.php");
require_once("model/RegFacade.php");
require_once("model/UserDAL.php");
require_once("model/Database.php");
require_once("model/contentDAL.php");
require_once("model/commentDAL.php");
require_once("model/contentCatalog.php");


class MasterController
{
	private $view;
	private $navigationView;
	private $userController;
	private $userDAL;
	private $IsLoggedIn;

	function __construct()
	{
		$this->db = new Database();		
		$this->userDAL = new UserDAL($this->db);
		$this->users = $this->userDAL->getUsers();
		$this->navigationView = new navigationView();
	}

	/**
	*	Handles input, by calling according controller,
	*	an sets view depending on url.
	*	@return void
	*/
	public function handleInput()
	{
		//Create database, get content catalog
		$db = new Database();
		$contentDAL = new contentDAL($db);
		$Catalog = new contentCatalog();
		$contentController = new ContentController($contentDAL,$Catalog);
		$contentCatalog = $contentController->getContent();
		
		//Handle login
		if($this->navigationView->wantsToLogin())
		{
			$login = new LoginController($this->users,$this->navigationView);
			$this->IsLoggedIn = $login->doLogin();
			
			if($this->IsLoggedIn)
			{
				$this->navigationView->redirToAdmin();
			}
			else
			{
				$this->view = $login->getOutPut();				
			}
			
		}
		//Upload content
		else if($this->navigationView->wantsToUpload() && isset($_SESSION['user']))
		{	
			$this->view= new AdminView();
			$uploadController = new uploadController($this->view,$contentDAL,$this->users);
			$uploadController->doUpload();
		}
		//Handle registration
		else if ($this->navigationView->wantsToReg())
		{
			$model = new RegFacade($this->userDAL);
			$this->view = new RegView($this->navigationView);	
			$regControl = new RegisterController($model,$this->view);
			$regControl->addUser();
			$this->view = new RegView($this->navigationView);

		} 
		//View image
		else if($this->navigationView->wantsToViewImage())
		{	
			$this->view = new ImageView();	
			$imgController = new ImageController($this->view,$contentCatalog);
			$imgController->getImage();
			
		}
		//View Content
		else if($this->navigationView->wantsToViewContent())
		{
			$commentView = new commentView();
			$this->view = new ContentView($commentView);	
			$id = $this->view->getID();
			$commentDAL = new commentDAL($db);
			$commentController = new CommentController($commentView,$commentDAL);
			$comments = $commentController->doComment($id);
			$content = $contentController->getContentByID($id);
			$this->view->createHTML($content,$comments);
		}
		//Standard is to view all the content in gallery
		else
		{	
			$this->view = new galleryView();		
			$galController = new GalleryController($this->view);
			$galController->doGallery($contentCatalog);
			
		}
	}

	/**
	*	Returns the applicable view.
	*	@return LoginView || RegView || GalleryView ||ImageView
	*/
	public function generateOutPut()
	{
		//var_dump($this->view->response);
		return $this->view;
	}
}