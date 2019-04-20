<?php
	if ($server_name == $enviro_prod){
	    define ("DB_SERVER", "107.180.40.120");
		define ("DB_USER", "jt");
	    define ("DB_PASS", "1q2w3e4r5t");
	    define ("DB_NAME", "lorem_test_db");
	} else {
		define ("DB_SERVER", "localhost");
		define ("DB_USER", "root");
		define ("DB_PASS", "root");
		define ("DB_NAME", "lorem_test_db");
	}
?>
