<?php defined('BASEPATH') OR exit('No direct script access allowed');



include_once APPPATH.'/vendor/autoload.php';
use Aws\Sns\SnsClient;
use Aws\Sns\Exception\SnsException;

class AWS_SNS
{
	private $sns;
	
	private $sns_properties = array('region'=>'us-east-1','version'=>'latest','credentials' => array(
		'key' => 'AKIAJCUXIQE32HVETEOQ',
		'secret'  => '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',
	  ));
	public function __construct()
    {
        // Construct the parent class
        //parent::__construct();
		
		//echo "listAllBuckets";
			$this->sns = SnsClient::factory($this->sns_properties);
        $this->sendSMS();
		
    }
	
	public function sendSMS()
	{
		echo "SEND SMS CALLED";
		// $args = array(
			// "SenderID" => "TEMP",
			// "SMSType" => "Transactional",
			// "Message" => "Hi Rajasekar this is from AWS SNS service.",
			// "PhoneNumber" => "+917402014940"
		// );
		
		$args = array(
				"MessageAttributes" => [
							'AWS.SNS.SMS.SenderID' => [
								'DataType' => 'String',
								'StringValue' => 'SPARQ'
							],
							'AWS.SNS.SMS.SMSType' => [
								'DataType' => 'String',
								'StringValue' => 'Transactional'
							]
						],
				"Message" => "Hi Rajasekar this is from AWS SNS service.",
				"PhoneNumber" => "+917402014940"
			);

		$result = $this->sns->publish($args);
		echo "<pre>";
		var_dump($result);
		echo "</pre>";
			}
	
	
	
	
	
	
}

?>