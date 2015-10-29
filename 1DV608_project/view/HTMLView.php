<?php

class HTMLView
{

	/**
	*	@param view
	*	@param string charSet
	*	@param string $title
	*	@return void
	*/
	public function render($view, $charSet)
	{
    $title =$view->title;
    $content =$view->getResponse();
		echo '
<!DOCTYPE html>
      <html>
        <head>
         <link href="content/css/style.css" rel="stylesheet">
         <link href="content/css/gallery.css" rel="stylesheet">
          <meta charset='.$charSet.'>
          <a href="?login">'.$this->renderLoginLogout().'</a>
          <a href="?register">Register</a>
          <a href="?gallery">Gallery</a>
          '.$this->renderUploadLink().'
          <title>'.$title.'</title>
        </head>
        <body>
          <h1>'.$title.'</h1>
          '.$content.'
         </body>
      </html>';
	}

  /**
  * Generate HTML code depending on login-status
  * @param bool $isLoggedIn
  * @return  void
  */
  private function renderUploadLink()
  {
    
      return ($this->isLoggedIn()) ? "<a href='?admin'>Upload content</a>" :"";
    
  }

	/**
  * Generate HTML code depending on login-status
  * @param bool $isLoggedIn
  * @return  void
  */
  private function renderLoginLogout()
  {
    
      return ($this->isLoggedIn()) ?'Logout' :'Login';
    
  }

  /**
  * Helper function to determine if user is logged in.
  * @return bool
  */
  private function isLoggedIn()
  {
    return isset($_SESSION['user']);      
  }

  

}