<?php
/**

 * User: velz
 * This Controller deals with PD Related CRUD Operations
 */

defined('BASEPATH') OR exit('No direct script access allowed');


require_once APPPATH . '/libraries/REST_Controller.php';


class Dash_Board_Controller extends REST_Controller { 

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
		$this->load->model('Dash_Board_Model');
		   
    }
	
	public function getDashBoardDetailsOfPDTypeAndPDStatusWithDayWeekMonth_get()
	{
		$res = $this->Dash_Board_Model->getDetailsOfPDTypeAndPDStatusWithDayWeekMonth();
						
		$data['dataStatus'] = true;
		$data['status'] = REST_Controller::HTTP_OK;
		$data['records'] = $res;
		$this->response($data,REST_Controller::HTTP_OK);
	}

	public function getDashBoardDetails_post()
	{
		$fdate = '';
		$tdate = '';
		$cityarr = '';
		$lenderarr = '';

		if($this->post('fromdate')) { $fdate = $this->post('fromdate'); }
		if($this->post('todate')){ $tdate = $this->post('todate'); }
		if($this->post('cityarr')) { $cityarr = $this->post('cityarr'); }
		if($this->post('lenderarr')) { $lenderarr = $this->post('lenderarr'); }
			
		// echo $from_date;
		// echo $to_date;
		// print_r($city_arr);
		// print_r($lender_arr);
		// die();
		$res = $this->Dash_Board_Model->getDetailsOfPDType($fdate,$tdate,$lenderarr,$cityarr);
		
						
		$data['dataStatus'] = true;
		$data['status'] = REST_Controller::HTTP_OK;
		$data['records'] = $res;
		$this->response($data,REST_Controller::HTTP_OK);
	}
	
	public function getDashBoardDetailsOfLenderAndCitywise_get()
	{
		$res = $this->Dash_Board_Model->getDetailsOfLenderAndCitywise();
		
		$data['dataStatus'] = true;
		$data['status'] = REST_Controller::HTTP_OK;
		$data['records'] = $res;
		$this->response($data,REST_Controller::HTTP_OK);
	}
	
	public function getDashBoardDetailsOfCitywise_get()
	{
		$res = $this->Dash_Board_Model->getDashBoardDetailsOfCitywise();
						
		$data['dataStatus'] = true;
		$data['status'] = REST_Controller::HTTP_OK;
		$data['records'] = $res;
		$this->response($data,REST_Controller::HTTP_OK);
	}
	public function getDashBoardDetailsOfAlert_get(){
		
		$res = $this->Dash_Board_Model->getDashBoardDetailsOfAlert();
						
		$data['dataStatus'] = true;
		$data['status'] = REST_Controller::HTTP_OK;
		$data['records'] = $res;
		$this->response($data,REST_Controller::HTTP_OK);
	
	}
    
}	