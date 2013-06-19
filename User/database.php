<?php

class database {
	// Connect to server and select database.
	function connectToDB() {
		//$dbh = new PDO('mysql:host=localhost;port=3306;dbname=kb_viva_rouletta_fb', 'root', 'root', array(PDO::ATTR_PERSISTENT => false));
		$database = 'kb_viva_rouletta_fb';
		$username = 'root';
		$password = 'root';
		$dbo = new PDO('mysql:host=localhost;dbname='.$database, $username, $password);
		$dbo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT );  
		$dbo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );  
		$dbo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); 
		return $dbo;
	}

}
?>