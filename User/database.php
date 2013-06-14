<?php

class database
{
	// Connect to server and select database.
	function connectToDB()
	{
		$link = mysql_connect('localhost', 'root', 'root');
		if (!$link) {
		    die('Could not connect: ' . mysql_error());
		}
		mysql_select_db("kb_viva_rouletta_fb")or die("cannot select DB");
		
		return $link;
	}
}
?>