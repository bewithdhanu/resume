<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH.'libraries/REST_Controller.php');

class Api extends REST_Controller {

	public function index_get()
	{
    	$this->response(array("message"=>"Welcome to ".COM_NAME),200);
	}
	public function index_post()
	{
    	$this->response(array("message"=>"Welcome to ".COM_NAME),200);
	}
	public function login_post(){
		$data = $this->security->xss_clean($this->post());
		if(count($data)>0){
			
			$res=$this->user_model->login($data["email"],$data["password"]);
			if($res!=false){
				$this->response(array("data"=>$res,"status"=>1),200);
			}else{
				$this->response(array("data"=>"Invalid Credintials","status"=>0),400);
			}
		}else{
			$this->response(array("data"=>"Invalid Input"),400);
		}
	}
	public function register_post(){
		$data = $this->security->xss_clean($this->post());
		if(count($data)>0){
			
			if($data["password"]!=$data["confirm_password"]){
				$this->response(array("data"=>"Password mismatch","status"=>0),400);
			}else if(!$this->is_valid_email($data["email"])){
				$this->response(array("data"=>"Invalid email or email already exists","status"=>0),400);
			}else if(!$this->is_valid_mobile($data["mobile"])){
				$this->response(array("data"=>"Invalid mobile or mobile already exists","status"=>0),400);
			}else if(!$data["username"]!=""){
				$this->response(array("data"=>"User name cannot be empty","status"=>0),400);				
			}else{
				$data["activation_code"]=rand(100000, 999999);
				unset($data["confirm_password"]);
				$data["password"]=$this->encryption->encrypt($data["password"]);
				$res=$this->user_model->register($data);
				if($res!=false){
					$this->sendActivationCode($res);
					$this->response(array("data"=>"Registration completed,confirmation mail has been sent to your mail!","status"=>1),200);
				}else{
					$this->response(array("data"=>"Registration failed!","status"=>0),400);
				}
			}
		}else{
			$this->response(array("data"=>"Invalid Input","status"=>0),400);
		}
	}
	public function sendActivationCode($user){
		//print_r($user);
		$data["link"]=genarateLink(array($user->id,$user->activation_code));
		$data["code"]=$user->activation_code;
		$this->load->library('email');

		$this->email->from(COM_EMAIL, COM_NAME);
		$this->email->to($user->email);
		/*$this->email->cc('another@another-example.com');
		$this->email->bcc('them@their-example.com');*/

		$this->email->subject('Account Activation Code - '.COM_NAME);
		$content=$this->load->view("mails/activate",$data,TRUE);
		$this->email->message($content);

		@$this->email->send();
	}
	public function activate($text){
		$data=decode_arr($text);
		
		$res=$this->user_model->activate($data);
		if($res!=false){
			$this->response(array("data"=>$res,"status"=>1),200);
		}else{
			$this->response(array("data"=>"Invalid Activation Code!","status"=>0),400);
		}
	}
	function is_valid_email($email){
		if(valid_email($email)){
			
			return !$this->user_model->is_record_exists($email,"email","tbl_users");
		}else return false;
	}
	function is_valid_mobile($mobile){
		if(strlen($mobile)>9){
			
			return !$this->user_model->is_record_exists($mobile,"mobile","tbl_users");
		}else return false;
	}
}
