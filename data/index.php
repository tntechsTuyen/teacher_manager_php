<?php 
	$files = array_diff(scandir("./"), array(".", ".."));

	$result = array();
	foreach ($files as $key => $file) {
		if(strpos($file, "data_") !== false){
			array_push($result, str_replace("data_", "", $file));
		}
	}
	echo "<pre>";
	var_dump($result);
	echo "</pre>";
?>