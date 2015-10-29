<?php

require_once("model/Image.php");
require_once("model/Content.php");

class ContentController
{
	private $DAL;
	private $contentCatalog;
	private static $galleryPath ="content".DIRECTORY_SEPARATOR."img";
						
	function __construct(ContentDAL $DAL, contentCatalog $contentCatalog)
	{	
		$this->DAL = $DAL;
		$this->contentCatalog = $contentCatalog;
	}

	/**
	*	Get all the content from the database,	
	*	Save it to the repository and return it.
	*	@return ContentCatalog contentCatalog
	*/
	public function getContent()
	{
		$allContent = $this->DAL->getContent();

		foreach ($allContent as $content)
		{	
			$file = self::$galleryPath.DIRECTORY_SEPARATOR.$content['ImgSrc'];
			// Get info on image
			$basename = basename($file);	
			$imgInfo = list($width, $height, $type, $attr) = getimagesize($file);
			//create image
			$image = new Image($width,$height,$basename);
			$id = $content['ID'];
			$title = $content['Title'];
			$description = $content['Description'];
			$cont = new Content($id,$title,$image,$description);
			$this->contentCatalog->add($cont);
		}
		return $this->contentCatalog;

	}

	/**
	*	Get a specific content by unique
	*	identifier.
	*	@return Content content
	*/

	public function getContentByID($id)
	{
		return $this->contentCatalog->getContentByID($id);
	}
}