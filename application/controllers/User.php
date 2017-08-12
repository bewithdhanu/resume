<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function index(){
		$this->settemplate->user("home");
	}
	public function login(){
		$this->settemplate->user("login");
	}
	public function register(){
		$this->settemplate->user("register");
	}
	public function forget(){
		$this->settemplate->user("forget");
	}
	public function reset(){
		$this->settemplate->user("reset");
	}
	
}