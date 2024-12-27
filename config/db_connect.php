<?php 

	// connect to the database
	$conn = mysqli_connect('localhost', 'root', '', 'ninja_pizza');

	// check connection
	if(!$conn){
		echo 'Connection error: '. mysqli_connect_error();
	}

?>