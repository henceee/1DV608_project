<?php

require_once('model/ImageGD.php');

class ImageController
{
	private static $galleryPath ="content".DIRECTORY_SEPARATOR."img";

	private $imgView;
	private $contentController;
	private $contentCatalog;
	private $cachePath;
	
											
	function __construct(ImageView $imgView,$contentCatalog)
	{
		$this->cachePath = "content".DIRECTORY_SEPARATOR."cache".DIRECTORY_SEPARATOR;
		$this->imgView = $imgView;
		$this->contentCatalog = $contentCatalog;
		
	}	

	public function getImage()
	{
		
		$ImgArgs = $this->imgView->getArgsFromURL();

		$check =self::$galleryPath.DIRECTORY_SEPARATOR.$ImgArgs['src'];
		if(is_file($check))
		{
			$img = $this->contentCatalog->getContentImgByID($ImgArgs['src']);

			$GD = new ImageGD();


			$headerInfo = $GD->getHeaderInfo($ImgArgs,$img);

			$this->imgView->renderHTML($headerInfo['header'], $headerInfo['cacheFileName']);

		}
		
		
	}


	
}