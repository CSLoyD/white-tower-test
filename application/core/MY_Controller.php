<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends MX_Controller {

	public $assets_ = array(
		'characters' => array(
			'css' => array('characters.min.css'),
			'js' => array('characters.min.js'),
		),
		'login' => array(
			'css' => array('login.min.css'),
			'js' => array('login.min.js'),
		)
	);

	public $assetVersion = 'v1.0';

	public function __construct(){
		$route = $this->router->fetch_class();
		$method = $this->router->fetch_method();
		 
		$exclusions = array('registration','verifyToken','thankYou');
		if(!in_array($method,$exclusions)) {
			if($route == 'login'){
				if($_SESSION['is_logged'] && $_SESSION['is_verified']){
					redirect(base_url('characters'));
				}
			} else {
				if(!$_SESSION['is_logged'] && !$_SESSION['is_verified']){
					redirect(base_url('login'));
				}
			}
		}
	}

	public function load_page($page, $data = array()){
		$data['route'] = $this->router->fetch_class();
		$data['__assets__'] = $this->assets_;
      	$this->load->view('includes/head',$data);
      	$this->load->view($page,$data);
      	$this->load->view('includes/footer',$data);
    }
	
	protected function sendEmail($email, $token) {

		$subject = 'Verify Your Email';
		$message = 'Click the following link to verify your email address: ';
		$message .= base_url("verify-email/$token");

		try {
			if(EMAILUSERNAME && EMAILPASSWORD) {
				$config['protocol']    	= 'smtp';
				$config['smtp_host']  	= 'ssl://smtp.gmail.com';
				$config['smtp_port']   	= 465;
				$config['auth']   		= true;
				$config['smtp_user']   	= EMAILUSERNAME;
				$config['smtp_pass']   	= EMAILPASSWORD;
				$config['mailtype']    	= 'html';
				$config['charset']     	= 'utf-8';
				$config['wordwrap']    	= TRUE;
				$config['newline']     	= "\r\n";
		
				$this->email->initialize($config);
	
				$this->email->from('chrisnilavila@gmail.com', 'Loyd');
				$this->email->to($email);
				$this->email->subject($subject);
				$this->email->message($message);
	
				if ($this->email->send()) {
					return true;
				} else {
					return $this->email->print_debugger();
				}
			} else {
				$to = 'chrisnilloyd@gmail.com';
				$subject = 'Subject of the email';
				$headers = 'From: chrisnilloyd@gmail.com' . "\r\n" .
				'Reply-To: chrisnilloyd@gmail.com' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();
	
				if (mail($to, $subject, $message, $headers)) {
					return true;
				} else {
					return false;
				}
			}
		} catch(Exception $e) {
		}
		
		
	}
	

} // end of class
