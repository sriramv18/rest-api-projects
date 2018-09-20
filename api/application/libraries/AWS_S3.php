<?php defined('BASEPATH') OR exit('No direct script access allowed');



include_once APPPATH.'/vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\Exception\AwsException;

class AWS_S3
{
	private $S3;
	private $name = "TEST";
	private $s3_properties = array('region'=>'ap-south-1','version'=>'latest','credentials' => array(
		'key' => 'AKIAJCUXIQE32HVETEOQ',
		'secret'  => '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',
	  ));
	public function __construct()
    {
        // Construct the parent class
        //parent::__construct();
		
		//echo "listAllBuckets";
			$this->S3 = S3Client::factory($this->s3_properties);
        //$this->getAllObjectsInaBucket();
		
    }
	
	public function listAllBuckets()
	{
		
		$buckets = array();
	try{
			$buckets = $this->S3->listBuckets();
	   
	   } catch(AwsException $e){ 
			// echo $e->getMessage();
			// echo "\n"; .
			}
		
		return $buckets;
	}
	
	public function createNewBucket($BUCKET_NAME)
	{
		
		try {
				$result = $this->S3->createBucket(['Bucket' => $BUCKET_NAME,'ACL' => 'authenticated-read']);
				
				//print_r($result);
			} catch (AwsException $e) {
				// output error message if fails
				echo $e->getMessage();
				echo "\n";
			}
	}
	
	public function uploadFileToS3Bucket($data)
	{
		$result = "";
		try {
			
				$result = $this->S3->putObject([
				'Bucket'     => $data['bucket_name'],
				'Key'        => $data['key'],
				'SourceFile' => $data['sourcefile'],
				'ContentType' => '*/*',
				'StorageClass' => 'STANDARD',
				'ACL'=>'authenticated-read'
				]);
			
			} catch (AwsException $e) 
			{
				$result =  false;;
			}
			
		return $result;	
	}
	
	/* This Function return signed URI of single S3 Object*/
	public function getSingleObjectInaBucketAsSignedURI($bucket_name,$folder_name,$time = '+5 minutes')//get as singed url
	{
		$result = array();
		
		try {
			
		// $result = $this->S3->getObject([
        // 'Bucket' => 'thecucumber',
        // 'Key'    => 'byapi/woodgrass1.jpg'
		// //'ResponseContentType'        => 'image/png'
		// //'ResponseContentDisposition' => 'attachment; woodgrass1.jpg',
			// ]);
			
						$cmd = $this->S3->getCommand('GetObject', [
							'Bucket' => $bucket_name,
							'Key'    => $folder_name
						]);

				$request = $this->S3->createPresignedRequest($cmd, $time);
				$presignedUrl = (string) $request->getUri();
		}
		catch(AwsException $e)
		{
			return $e->getMessage();
		}
		
			return $presignedUrl;
			

	}
	
	public function getAllObjectsInaBucket($bucket_name,$folder_name)
	{
		$objects = array();
				try {
						$objects = $this->S3->getIterator('ListObjects', [
							'Bucket' => $bucket_name,
							'Prefix' => $folder_name
						]);

						// echo "Keys retrieved!" ;
						// //print_r($objects);
						// foreach ($objects as $object) {
							// print_r($object) ;
					// }
		} catch (S3Exception $e) {
			echo $e->getMessage() . PHP_EOL;
		}
		
		return $objects;

	}
	
	
	
}

?>