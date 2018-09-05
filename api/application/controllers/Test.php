<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 require_once APPPATH . '/libraries/REST_Controller.php';
class Test extends REST_Controller {
 
        /**
         * load list modal, library and helpers
         */
         function __Construct(){
           parent::__Construct();
           $this->load->helper(array('form', 'url'));
           //$this->load->model('test_model');
           $this->load->library('asynclibrary');
          
         }
          
        /**
         *  @desc : Function to perform multiple task in background
         *  @param :void
         *  @return : void
         */
         public  function ind_get(){
				//echo base_url();
				print_r(getallheaders());
               $url = base_url()."test/sendmail";
               $urls = base_url()."test/insert";
             
               $param = array('email' => "jagroop@gmail.com" );
               $param1 = array('name' => "Jagroop Singh",
                               'email' => "jagroop@gmail.com" );
 
               // $async1 = $this->asynclibrary->do_in_background($url, $param);
               // $async2 = $this->asynclibrary->do_in_background($urls, $param1);
			   // print_r($async1);
			   // print_r($async2);
			   
             
        }
         
        /**
         *  @desc : Function to send mail
         *  @param :void
         *  @return : void
         */
        public function sendmail_post(){
 
            // $this->load->library('email');
             $user_email  = $_POST['email'];
            // $message     = "Testing";
          
            // $this->email->from('wolfy@gmail.com', 'Wolfy Singh');
            // $this->email->to($user_email);
            // $this->email->subject("test");
            // $this->email->message($message); 
            // $this->email->send();
			$id = $this->db->insert('t_city_master',array('city_name'=> $user_email));
			// echo $user_email;
			// print_r($id);
         }
         
         /**
         *  @desc : Function to call insert() method
         *  of test_model to insert data in database
         *  @param :void
         *  @return : void
         */
       public function insert_post(){
		    $user_email  = $_POST['name'];
		$this->db->insert('t_city_master',array('city_name'=>$user_email));
           // $email = $this->input->post('email');
           // $name = $this->input->post('name');
           // $this->test_model->insert($email, $name);
		   //echo "insert";
      }
}