<?php defined('BASEPATH') OR exit('No direct script access allowed');



include_once APPPATH.'/vendor/autoload.php';
use Aws\Ses\SesClient;
use Aws\Ses\Exception\SesException;

class AWS_SES
{
	private $SES;
	private $name = "TEST";
	private $ses_properties = array('region'=>'us-east-1','version'=>'latest','credentials' => array(
		'key' => 'AKIAJCUXIQE32HVETEOQ',
		'secret'  => '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',
	  ));
	public function __construct()
    {
        // Construct the parent class
        //parent::__construct();
		
		//echo "listAllBuckets";
			$this->SES = SesClient::factory($this->ses_properties);
        $this->sendMail();
		
    }
	
	public function sendMail()
	{
		$sender_email = 'velmurugan.s@venbainfotech.com';

				// Replace these sample addresses with the addresses of your recipients. If
				// your account is still in the sandbox, these addresses must be verified.
				$recipient_emails = ['sanjeev.p@venbainfotech.com'];

				// Specify a configuration set. If you do not want to use a configuration
				// set, comment the following variable, and the
				// 'ConfigurationSetName' => $configuration_set argument below.
				//$configuration_set = 'ConfigSet';

				$subject = 'Amazon SES test (AWS SDK for PHP)';
				$plaintext_body = 'This email was sent with Amazon SES using the AWS SDK for PHP.' ;
				$html_body =  '<h1>AWS Amazon Simple Email Service Test Email</h1>'.
							  '<p>This email was sent with <a href="https://aws.amazon.com/ses/">'.
							  'Amazon SES</a> using the <a href="https://aws.amazon.com/sdk-for-php/">'.
							  'AWS SDK for PHP</a>.</p>';
				$char_set = 'UTF-8';

				try {
					$result = $this->SES->sendEmail([
						'Destination' => [
							'ToAddresses' => $recipient_emails,
						],
						'ReplyToAddresses' => [$sender_email],
						'Source' => $sender_email,
						'Message' => [
						  'Body' => [
							  'Html' => [
								  'Charset' => $char_set,
								  'Data' => $html_body,
							  ],
							  'Text' => [
								  'Charset' => $char_set,
								  'Data' => $plaintext_body,
							  ],
						  ],
						  'Subject' => [
							  'Charset' => $char_set,
							  'Data' => $subject,
						  ],
						],
						// If you aren't using a configuration set, comment or delete the
						// following line
						//'ConfigurationSetName' => $configuration_set,
					]);
					$messageId = $result['MessageId'];
					echo("Email sent! Message ID: $messageId"."\n");
				} catch (AwsException $e) {
					// output error message if fails
					echo $e->getMessage();
					echo("The email was not sent. Error message: ".$e->getAwsErrorMessage()."\n");
					echo "\n";
				}
	}
	
	
	
}

?>