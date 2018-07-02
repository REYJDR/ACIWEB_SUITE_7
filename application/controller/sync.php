<?php


class sync extends Controller
{


	public function server($folder){

		require_once 'sync/src/Outlandish/Sync/AbstractSync.php'; 
		require_once 'sync/src/Outlandish/Sync/Server.php'; 

		define('SECRET', '5ecR3t'); //make this long and complicated
        define('PATH' , 'FISCAL/'); //sync all files and folders below this path

		$server = new \Outlandish\Sync\Server(SECRET, PATH);
		$server->run(); //process the request


	}



}

?>