<?php include_once("controllers/ClassRoomController.php");?>
<?php 
	error_reporting(E_ERROR | E_PARSE);
	session_start();
	$m = (isset($_GET['m'])) ? $_GET['m'] : "goList"; //method
	$controller = new ClassRoomController();
	$controller->$m();
?>
