<?php

class galleryView
{
	public $title="Meme Gallery";
	public $response ='';

	/**
	*
	*	@return string -HTML outupt
	*/
	public function getResponse()
	{
		return $this->response;
		
	}

	/**
	*	Create HTML for the gallery
	*	link to view content, image, content title
	*	@return void
	*/
	public function getGalleryHTML($contentCatalog)
	{
		$html ="";
		
		$contentCatalog =$contentCatalog->getContent();

		foreach ($contentCatalog as $content)
		{
			$image = $content->getImage();
			$contentID = $content->getID();
			$width 		 = $image->getWidth();
			$height 	 = $image->getHeight();
			$displayWidth  = "&amp;width=200";
			$displayHeight = "&amp;height=200";
			$href = $image->getBaseName();
			$title = $content->getTitle();
			$html .= "
			<a href='?content&ID={$contentID}'>
			<figure class='figure overview'>
			<p>
				<img src='?image&amp;src={$href}{$displayWidth}{$displayHeight}&amp;crop-to-fit' alt=''/>
			</p>
			</a>
			<figcaption>{$title}</figcaption>
			</figure>";
			
			
		}
				
		$this->response = $html;		
	}


}