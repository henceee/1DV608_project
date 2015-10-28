<?php

require_once('model/ImageGD.php');
require_once('model/Image.php');
require_once('model/Content.php');
require_once('model/ImageText.php');

class UploadController
{
	private $view;
								
	

	function __construct($view,ContentDAL $DAL, UserCatalog $users)
	{
		$this->view = $view;
		$this->users = $users;
		$this->contentDAL = $DAL;
		$this->GD = new ImageGD();
		$this->galleryPath = $this->GD->getGalleryPath();
		$this->view->cachePath = $this->GD->getCachePath();
	}

	/**
	*	Get the uploaded image, cache it and output it.
	*	@return void
	*/
	public function saveCacheAndOutput($value='')
	{
		$this->image =$this->view->getUploadedImage();
		$baseName = preg_replace("( )", "_", $this->image['name']);				
		$this->extension = pathinfo($baseName)['extension'];
		$this->imgResource =$this->GD->checkFileExtension($this->extension,$this->image['tmp_name']);		
		$this->saveCache($baseName);
		header('location:?admin&img='.$baseName);
	}

	/**
	*	Add text to the image, cache it and output it.
	*	@return void
	*/
	public function addTextAndPreview($name)
	{
		$this->AddText();
		$this->saveCache($name);				
		header('location:?admin&img='.$name.'&save');
	}

	/**
	*	Add text to the image
	*	@return void
	*/
	public function AddText()
	{	
		if($this->image !=null)
		{		
			
			$text = $this->view->getImgText1();

			$imageTxt = new ImageText($this->imgResource);
												//1/6 of the image height
			$imageTxt->calcFontSizeAddText($text,1,6);
			
			$text2 = $this->view->getImgText2();
												//4,5 * (1/6) == 9/12 == 0.75 of height
			$imageTxt->calcFontSizeAddText($text2,4.5,6);
			
			$text3 = $this->view->getImgText3();
												//5/6 == 0.83333 of height
			$imageTxt->calcFontSizeAddText($text3,5,6);
			$name = basename($this->image);
		
		}
	}

	/**
	*	Save the image to gallery path, add content to database
	*	@return void
	*/
	public function saveContent($name)
	{
		$user = $this->users->getUserByName($_SESSION['user']);
				
				$ID =$user->getID();
				$title = $this->view->getTitle();
				$desc = $this->view->getDesc();
				if(!is_null($ID) && !empty($title) && !empty($desc))
				{
					$uniqeStamp = uniqid();
					$pathToSaveTo = $this->galleryPath.DIRECTORY_SEPARATOR.$uniqeStamp.$name;
					//Save to gallery path
					$this->GD->checkSaveAs($this->extension,$this->imgResource, $pathToSaveTo);

					$this->contentDAL->insertContent($ID,$title,$uniqeStamp.$name,$desc);
					header('location:?');
				}
	}

	/**
	*	Save the image to cache
	*	@return void
	*/
	public function saveCache($imgName)
	{
		//Save to cache
		$cacheFileName = $this->view->cachePath.$imgName;
		$this->GD->checkSaveAs($this->extension,$this->imgResource,$cacheFileName);
	
	}

	/**
	*	Handle upload
	*	@return void
	*/
	public function doUpload()
	{
		if($this->view->userHasSubmitted())
		{
			$this->saveCacheAndOutput();
		}
		else if($this->view->ImageArgExist())
		{
			$this->image = $this->view->getImage();
			$this->extension = pathinfo($this->image,PATHINFO_EXTENSION);
			$cachedFile = $this->view->cachePath.$this->image;
			$this->imgResource =$this->GD->checkFileExtension($this->extension, $cachedFile);		
			$name = basename($this->image);

			if($this->view->userWantsToPreview())
			{
				$this->addTextAndPreview($name);
			}	

			if($this->view->userWantsToSave())
			{
				$this->saveContent($name);					
			}
		}

		$this->view->renderHTML();		
	}

	

}