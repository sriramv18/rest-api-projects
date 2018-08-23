<?php

class MYLOG
{
	

	
	// Create the logger
	public static function logFunction($r)
	{
		include_once APPPATH.'/vendor/autoload.php';
		
		// use Monolog\Logger;
		// use Monolog\Handler\StreamHandler;
		// use Monolog\Handler\FirePHPHandler;
		
		$logger = new  \Monolog\Logger('my_logger');
		$streamHandler = new \Monolog\Handler\StreamHandler(APPPATH.'syslogs/my_app.log', $logger::DEBUG);
		$firePHPHandler = new \Monolog\Handler\FirePHPHandler();
		// $dateFormat = "Y n j, g:i a";
		// $output = "%datetime% > %level_name% > %message% %context% %extra%/n";
		// $formatter = new \Monolog\Formatter\LineFormatter($output,$dateFormat);
		
		
	    //$logger = new Logger('my_logger');
		// Now add some handlers
		$logger->pushHandler($streamHandler);
		$logger->pushHandler($firePHPHandler);

		// You can now use your logger
		$logger->info('Adding a new user', array('username' => $r));
	}
	

}

?>