<?php


class GalleryController
{
	private $galleryView;

	function __construct(GalleryView $GalleryView)
	{
		$this->galleryView = $GalleryView;
	}

	public function doGallery($contentCatalog)
	{		
		$GalleryView = new GalleryView();
		$this->galleryView->getGalleryHTML($contentCatalog);
	}


}