<?php

class ImageText
{

	private static $fontPath ="content".DIRECTORY_SEPARATOR."fonts";

	function __construct($img)
	{
		$this->font = self::$fontPath.DIRECTORY_SEPARATOR.'Impact.ttf';
		$this->color = imagecolorallocate($img, 255, 255, 255);
		$this->image = $img;
	}
	


	public function calcFontSizeAddText($text,$parts,$whole,$angle=0)
	{
		$imgWidth 	= imagesx($this->image);
		$imgHeight = imagesy($this->image);

		if(strlen($text)>0)
		{
			$fontsize = ($imgWidth /strlen($text));
		
			$textBox = imagettfbbox($fontsize,0,$this->font,$text);
			/*
				[0] lower left X coordinate
				[1] lower left Y coordinate
				[2] lower right X coordinate
				[3] lower right Y coordinate
				[4] upper right X coordinate
				[5] upper right Y coordinate
				[6] upper left X coordinate
				[7] upper left Y coordinate
		   */

			$textBoxLowerLeftX = $textBox[0];
			$textBoxLowerRightX = $textBox[2];

			$textBoxLowerLeftY = $textBox[1];
			$textBoxUpperLeftY = $textBox[7];

			$textHeight = $textBoxUpperLeftY-$textBoxLowerLeftY;

			$x = ceil(($imgWidth - $textBoxLowerRightX -$textBoxLowerLeftX)/2);

			$y = (($imgHeight/$whole) - ($textHeight/$whole)) *$parts;

			imagettftext($this->image, $fontsize, $angle, $x, $y, $this->color, $this->font, $text);	
		}
		
	}
}