<?php

/**
* Applied my code from previous class cImage from the course Databaser och Objekt Orienterad PHP, 7.5 hp,
* Blekinge Tekniska Högskola (VT 2015) for the class ImageGD.
* http://www.student.bth.se/~hega15/OOP/sourcecode.php?path=src/cImage.php
*/

class ImageGD
{
	private static $galleryPath ="content".DIRECTORY_SEPARATOR."img";

	private $cachePath;
	private	$src;
	private	$saveAs;
	private	$quality;
	private $newWidth; 
	private $newHeight;
	private $cropToFit;
	private $sharpen;
	private $ignoreCache;
	private $imgCatalog;
	private $imgInfo;
	private $pathToImage;
	private $cropWidth;

	function __construct()
	{
		$this->cachePath = "content".DIRECTORY_SEPARATOR."cache".DIRECTORY_SEPARATOR;
		
	}	


	public function getGalleryPath()
	{
		return self::$galleryPath;
	}

	public function getcachePath()
	{
		return $this->cachePath;
	}
	/**
	*	Get the header info after opening file, altering
	*	with GD, save to cache, output.
	*	@return array
	*/
	public function getHeaderInfo($ImgArgs,$img)
	{
		$this->src = $ImgArgs['src'];
		$this->saveAs = $ImgArgs['saveAs'];
		$this->quality = $ImgArgs['quality'];
		$this->newWidth = $ImgArgs['newWidth'];
		$this->newHeight = $ImgArgs['newHeight'];
		$this->cropToFit = $ImgArgs['cropToFit'];
		$this->sharpen = $ImgArgs['sharpen'];
		$this->ignoreCache = $ImgArgs['ignoreCache'];
				
		
		$this->width = $img->getWidth();
		
		$this->height= $img->getHeight();
		
		$this->pathToImage = realpath(self::$galleryPath .DIRECTORY_SEPARATOR. $this->src);
		$fileExtension  = pathinfo($this->pathToImage, PATHINFO_EXTENSION);
				
		$this->calcProportions();
		$header =$this->getCacheInfo();

		// Open up the image from file
		$image = $this->checkFileExtension($fileExtension,$this->pathToImage);
		
		// Resize the image if needed
		$image = $this->resize($this->newWidth,$this->width,$this->newHeight,$this->height,$image);
	
		// Apply filters and postprocessing of image
		if($this->sharpen)
		{
		  $image = $this->sharpenImage($image);
		}
	
		// Save the image
		$this-> checkSaveAs($this->saveAs,$img,$this->cacheFileName,$this->quality);
		
		return array("header"=>$header, "cacheFileName"=>$this->cacheFileName);
		
	}

	/**
	*	Calculate with & height for image.
	*	@return void
	*/
	private function calcProportions()
	{
		$width 		 = $this->width;
		$height 	 = $this->height;
		$newWidth	 = $this->newWidth;
		$newHeight	 = $this->newHeight;
		$cropToFit	 = $this->cropToFit;
		//
		// Calculate new width and height for the image
		//
		$aspectRatio = $width / $height;

		if($cropToFit && $newWidth && $newHeight)
		{
		  $targetRatio = $newWidth / $newHeight;
		  $this->cropWidth   = $targetRatio > $aspectRatio ? $width : round($height * $targetRatio);
		  $this->cropHeight  = $targetRatio > $aspectRatio ? round($width  / $targetRatio) : $height;	 
		}
		else  if($newWidth && !$newHeight)
		{
		  $this->newHeight = round($newWidth / $aspectRatio);
		}
		else if(!$newWidth && $newHeight)
		{
		  $this->newWidth = round($newHeight * $aspectRatio);
		}
		else if($newWidth && $newHeight)
		{
		  $ratioWidth  = $width  / $newWidth;
		  $ratioHeight = $height / $newHeight;
		  $ratio = ($ratioWidth > $ratioHeight) ? $ratioWidth : $ratioHeight;
		  $this->newWidth  = round($width  / $ratio);
		  $this->newHeight = round($height / $ratio);		  
		}
		else
		{
		  $this->newWidth = $width;
		  $this->newHeight = $height;	
		}		
		
	}

	/*
	* Get the attributes of the cached file.
	* @return array 	- array containing the header to 
	* be output before rendering img & the filename of the
	* cached file.
	*/
	private function getCacheInfo()
	{			
		$width 		 = $this->width;
		$height 	 = $this->height;
		$newWidth	 = $this->newWidth;
		$newHeight	 = $this->newHeight;
		$quality	 = $this->quality;
		$sharpen	 = $this->sharpen;
			
		// Creating a filename for the cache
		$fileExtension  = pathinfo($this->pathToImage, PATHINFO_EXTENSION);
		$parts      	= pathinfo($this->pathToImage);
		$saveAs     	= is_null($this->saveAs) ? $fileExtension : $this->saveAs;
		$quality_   	= is_null($quality) ? null : "_q{$quality}";
		$dirName    	= preg_replace('/\//', '-', dirname($this->src));
		$cropToFit_     = is_null($this->cropToFit) ? null : "_cf";
		$sharpen_       = is_null($sharpen) ? null : "_s";
		$this->cacheFileName = $this->cachePath . "-{$dirName}-{$parts['filename']}_{$newWidth}_{$newHeight}{$quality_}{$cropToFit_}{$sharpen_}.{$saveAs}";
		$this->cacheFileName = preg_replace('/^a-zA-Z0-9\.-_/', '', $this->cacheFileName);
				
		// Open up the image from file
		$image = $this->checkFileExtension($fileExtension);
		
		// Resize the image if needed
		$image = $this->resize($newWidth,$width,$newHeight,$height,$image);
		
		// Apply filters and postprocessing of image
		if($sharpen)
		{
		  $image = $this->sharpenImage($image);
		}
		
		// Save the image
		$this->checkSaveAs($saveAs,$image,$this->cacheFileName,$quality);

		//get header
		$header = $this->checkValidChachedImg($this->cacheFileName);		
		return $header;

	}

	/**
	* Check the file-extension and create img of that type.
	* @param fileExtension (jpg || jpgeg || png)
	* @return resource $image
	*/
	public function checkFileExtension($fileExtension,$src=null)
	{	
		if(!is_null($src))
		{
			$this->pathToImage = $src;
		}

		$image = null;
		switch($fileExtension) {  

		case 'jpg':

		case 'jpeg': 
		$image = imagecreatefromjpeg($this->pathToImage);
		break;  

		case 'png':  
		$image = imagecreatefrompng($this->pathToImage); 
		break;  
		}
		
		return $image;
	}


	/**
	* Resize the image
	* @param $newWidth,$width,$newHeight,$height,$image
	* @return resource $image
	*/
	private function resize($newWidth,$width,$newHeight,$height,$image)
	{			
		$cropToFit 	= $this->cropToFit;
				
		if($cropToFit)
		{
			$cropWidth 	= $this->cropWidth;
			$cropHeight = $this->cropHeight;

			$cropX = round(($width - $cropWidth) / 2);  
			$cropY = round(($height - $cropHeight) / 2);    
			$imageResized = imagecreatetruecolor($newWidth, $newHeight);
			imagecopyresampled($imageResized, $image, 0, 0, $cropX, $cropY, $newWidth, $newHeight, $cropWidth, $cropHeight);
			$image = $imageResized;
			$width = $newWidth;
			$height = $newHeight;
		}
		else if(!($newWidth == $width && $newHeight == $height))
		{
			$imageResized = imagecreatetruecolor($newWidth, $newHeight);
			imagecopyresampled($imageResized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
			$image  = $imageResized;
			$width  = $newWidth;
			$height = $newHeight;
		}
		
		return $image;
		
	}
	
	
	/**
	* Save the image
	* @param $saveAs,$image,$cacheFileName,$quality
	* @return void
	*/
	public function checkSaveAs($saveAs,$image,$cacheFileName,$quality=100)
	{	
			switch($saveAs) {
			case 'jpeg':
			case 'jpg':
			imagejpeg($image, $cacheFileName, $quality);
			break;  

			case 'png':  
			imagepng($image, $cacheFileName);  
			break;  
			}
	}
	
	/**
	* Check if the cached img is valid, do most of the
	* work for outputing by calling private method outputImage
	* @param string cachefilename
	* @return string $header -header to be set externally before reading file.
	*/
	private function checkValidChachedImg($cacheFileName)
	{
		//
		// Is there already a valid image in the cache directory, then use it and exit
		//		
		$imageModifiedTime = filemtime($this->pathToImage);
		$cacheModifiedTime = is_file($cacheFileName) ? filemtime($cacheFileName) : null;
		
		$header = null;
		// If cached image is valid, output it.
		if(!$this->ignoreCache && is_file($cacheFileName) && $imageModifiedTime < $cacheModifiedTime)
		{
			
			$header = self::outputImage($cacheFileName);
			
		}		
		
		return $header;
		
	}
	
	/**
	* Output an image together with last modified header.
	*
	* @param string $file as path to the image.
	* @param boolean $verbose if verbose mode is on or off.
	*/
	private function outputImage($file)
	{		
		
		$info = getimagesize($file);
		!empty($info) or self::errorMessage("The file doesn't seem to be an image.");
		$mime   = $info['mime'];

		$lastModified = filemtime($file);  
		$gmdate = gmdate("D, d M Y H:i:s", $lastModified);
		

		if(isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $lastModified)
		{			
			$header='HTTP/1.0 304 Not Modified';
		} else {  
			
			$header='Content-type: ' . $mime;  
			
		}
		
		return $header;
		
	}
}