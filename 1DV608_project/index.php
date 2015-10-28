<?php

//start session
session_start();
ob_start();
//INCLUDE THE FILES NEEDED...


require_once('view/HTMLView.php'); 
require_once("controller/MasterController.php");



//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');
$HTMLView = new HTMLView();

//Create new master, which handles input & acquires view.
$master = new MasterController();
$master->handleInput();
$view = $master->generateOutPut();
$HTMLView->render($view, "utf-8");
