<?php

class MYOCR
{
	

	
	// Create the logger
	public static function getOCRText()
	{
		include_once APPPATH.'/vendor/autoload.php';
		
		$ocr = new TesseractOCR();
		$ocr->image(APPPATH.'/docs/image.jpg');
		$ocr->run();
		
	}
	

}

?>