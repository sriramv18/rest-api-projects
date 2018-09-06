<?php
/**
 * Created by PhpStorm.
 * User: kms
 * Date: 11/13/17
 * Time: 7:40 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require_once APPPATH . '/libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author
 * @license         MIT
 * @link
 */
class Branch_Controller extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['getBranchDetails_post']['limit'] = 500; // 50 requests per hour per user/key
        $this->methods['uploadFiles_post']['limit'] = 500; // 50 requests per hour per user/key

        // load the model
        $this->load->model('Branch_model', 'branch_model');
		$this->load->library('AWS_S3');
		//$this->load->library('AWS_SNS');
		//$this->load->library('AWS_SES');
    }
    /*
     * get branch details
     * created by kms
     * */
	 
	 
    public function getBranchDetails_post()
    {
		$token = '1';
		//$tokens = AUTHORIZATION::validateToken($token);
		// print_r(getallheaders());
		// echo $token;die();
		//print_r($tokens);die;
        $requestedBy = $this->post('requestedBy');
            $getBranch = $this->branch_model->getBranch($requestedBy);
            if ($getBranch['branchStatus'])
            {
                // Set the response and exit
                $this->response($getBranch);
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'message' => 'No records found!',
                    'branchStatus' => false
                ]);
            }
    }
	
	public function testAWSS3_post()
	{
		/* CREATE NEW BUCKETS*/
		// $b = $this->aws_s3->createNewBucket('thecucumber');
		/* CREATE NEW BUCKETS*/
		
		/* LIST OF BUCKETS*/
		
		
		// $res = $this->aws_s3->listAllBuckets();
		
		// echo "All Buckets from Business Controller\n\n";
		// foreach ($res['Buckets'] as $bucket) {
			// echo $bucket['Name'];
			// echo "\n\n\n\n";
		// }
		
		/* LIST OF BUCKETS*/
		
		
		/* STORE FILE TO S3*/
		
		$file = $_FILES['myfile']['tmp_name'];
		$file2 = $_FILES['myfile']['name'];
		//print_r($file);
		//print_r($file2);
		
		$s3pathname = 'byapi/'.$file2;
		$data = array('bucket_name'=>'thecucumber','key'=>$s3pathname,'sourcefile'=>$file);
		$res = $this->aws_s3->uploadFileToS3Bucket($data);
		//print_r($res);
		echo is_object($res);
		echo is_array($res);
		echo "*********\n\n";
		echo $res['ObjectURL'];
		echo $res['@metadata']['statusCode'];
		// foreach($res as $key => $value)
		// {
			// echo $key."\n\n";
		// }
		
		/* STORE FILE TO S3*/
		
		/* GET FILE FROM S3*/
		// $res = $this->aws_s3->getSingleObjectInaBucket();
		// //print_r($res);
		// //echo "\n\n\n\n\n<br>";
		 // //header("Content-Type:{$res['ContentType']}");
		// header("Content-Disposition:attachment; filename='woodgrass1.jpg'");

		 // echo $res['Body'];
		
		/* GET FILE FROM S3*/
		
		/*
		$id = MYDB::saveRecords(array('city_name'=>'salem'),'t_city_master');
		print_r($id);
		*/
		
		/*
		$where_condition_array = array();
		$id = MYDB::selectRecords($where_condition_array,'t_city_master',$print_query = '');
		print_r($id);
		*/
		
		
		//$data = MYDB::updateRecords($record_data = array(),$table_name,$where_condition_array = array(),$print_query = '')
		
		/*
		$where= array('city_name'=>'chennai','fk_state_id'=>'1');
		
		$or_where = array('city_name'=>'salem','fk_state_id'=>'4');
		$or_where_total[] = $or_where;
		$or_where = array('city_name'=>'erode');
		$or_where_total[] = $or_where;
		
		$fields = array('city_name','fk_state_id');
		$id = MYDB::selectCustomRecords($fields , $where,$or_where_total,$table = 't_city_master', $limit = '', $order_by_colum_name = 'fk_state_id', $order_by = '',$group_by = 'fk_state_id',$print_query = '');
		print_r($id);
		*/
		
		/*
		$columns = array('city_name','state_name');
		$table = 't_states_master';
		$joins = array(
			array(
				'table' => 't_city_master',
				'condition' => 't_city_master.fk_state_id = t_states_master.state_id',
				'jointype' => 'INNER'
			),
		);
		$id = MYDB::getJoinRecords($columns,$table,$joins,$print_query = '');
		print_r($id);
		*/
	}
	
	public function testPDF_get()
	{
		// include_once APPPATH.'/vendor/autoload.php';
 
		// // Parse pdf file and build necessary objects.
		// $parser = new \Smalot\PdfParser\Parser();
		// $pdf    = $parser->parseFile(APPPATH.'/docs/sample.pdf');
		 
		// $text = $pdf->getText();
		// echo $text;
		
		// // $pages  = $pdf->getPages();
		// MYLOG::logFunction('testUser');
 
		// // Loop over each page to extract text.
		// foreach ($pages as $page) {
			// echo $page->getText();
		// }
		
		include_once APPPATH.'/vendor/autoload.php';
		// include_once thiagoalessio\TesseractOCR\TesseractOCR;
		// echo (new TesseractOCR(APPPATH.'/docs/image.jpg')->run();
			
				//echo APPPATH;
		//include_once APPPATH.'/vendor/thiagoalessio/tesseract_ocr/src/TesseractOCR.php';
		//$ocr = new \thiagoalessio\tesseract_ocr\TesseractOCR();
		// $ocr->image(APPPATH.'/docs/image.jpg');
		// $ocr->run();
		 // require_once APPPATH."vendor/autoload.php";
		 // echo (new \thiagoalessio\tesseract_ocr\TesseractOCR(APPPATH.'/docs/image.jpg'))->run();
		 
		 $tesseract = new \Ddeboer\Tesseract\Tesseract();
		 //$tesseract = new Tesseract();
		// print_r($tesseract);
		 // $version = $tesseract->getVersion();
		 // echo "version".$versions;
		 // $languages = $tesseract->getSupportedLanguages();
		 // echo "Lang";print_r($languages);
		 $text = $tesseract->recognize(APPPATH.'docs\image.jpg');
		 echo $text;

		  //$tesseract = new Tesseract();
	}
    // upload file details
	
	
	
     public function uploadFiles_post()
    {
        $req['doc_name'] = $_FILES['fileKey']['name'];
        $req['doc_size'] = $_FILES['fileKey']['size'];
        $req['doc_source'] = $_FILES['fileKey']['tmp_name'];
       $uploadDetails=$this->branch_model->uploadFiles($req);
       if ($uploadDetails['uploadStatus'])
       {
           // Set the response and exit
           $this->response($uploadDetails);
       }
       else
       {
           // Set the response and exit
           $this->response([
               'message' => 'Upload Faild!',
               'uploadStatus' => false
           ]);
       }
    }
}