<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {
	
	public function __construct() {
		// echo '<pre>';
		// print_r($_SESSION);
		// exit;
	}


    public function index(){
		$data['title'] = "Login";
		$this->load_page('index',$data);
	}

    public function checkLogin() {

        $respond = array();

        if (isset($_POST)) {
			$ctr = 0;

			foreach ($_POST as $key => $value) {
				$name = ucfirst(str_replace('_', ' ', $key));
				$this->form_validation->set_rules($key, $name, 'trim|required', array('required' => '{field} is required'));
				if (!$this->form_validation->run()) {
					if ($key == 'image' && $value == '') {
						$respond[$key] = form_error($key);
						$ctr += 1;
					}
				}
			}

			if ($ctr == 0) {
				$username	= trim($this->input->post('username'));
				$password	= trim($this->input->post('password'));

                $options = array(
                    'select'	=> "id,password,is_verified",
                    'where'		=> array("email" => $username)
                );

				$fetchData = $this->MY_Model->getRows('users',$options,'obj');
				if($fetchData) {
                    if(password_verify($password,$fetchData[0]->password)) {
						if(!$fetchData[0]->is_verified) {
							$respond['status'] = "error";
							$respond['key']['name'] = "username";
							$respond['key']['msg'] = "Email Not Verified!";
						} else {
							$arr_session = array(
								'user_id'		=> $fetchData[0]->id,
								'is_verified'	=> $fetchData[0]->is_verified,
								'is_logged'		=> 1,
							);
							$this->session->set_userdata($arr_session);
							
							$respond['status'] = "success";
							$respond['msg'] = "Login Successfully!";
						}
                    } else {
                        $respond['status'] = "error";
						$respond['key']['name'] = "password";
					    $respond['key']['msg'] = "Invalid Password";
                    }
				} else {
					$respond['status'] = "error";
					$respond['key']['name'] = "username";
					$respond['key']['msg'] = "Invalid Username";
				}

			} // End of ctr
			json($respond);
		}

    }

	public function registration() {
		$data['title'] = "Registration Page";
		$this->load_page('registration',$data);
	}

	public function addUser() {
		$respond = array();
        if (isset($_POST)) {
			$ctr = 0;


			foreach ($_POST as $key => $value) {
				$name = ucfirst(str_replace('_', ' ', $key));
				$this->form_validation->set_rules($key, $name, 'trim|required', array('required' => '{field} is required'));
				if (!$this->form_validation->run()) {
					if ($value == '') {
						$respond[$key] = form_error($key);
						$ctr += 1;
					}
				}
			}

			if ($ctr == 0) {
				$firstname		= trim($this->input->post('firstname'));
				$lastname		= trim($this->input->post('lastname'));
				$email			= trim($this->input->post('email'));
				$password		= trim($this->input->post('password'));
				$confirmpass	= trim($this->input->post('c_password'));
				
				if($password != $confirmpass) {
					$respond['status'] = "error_confirm_pass";
					$respond['msg'] = "Password does not match!";
					json($respond);
					exit;
				}

				$token = bin2hex(random_bytes(16));

				$saveUserData = array(
					'firstname'				=> $firstname,
					'lastname'				=> $lastname,
					'email' 				=> $email,
					'password' 				=> password_hash($password,PASSWORD_DEFAULT),
					'verification_token'	=> $token
				);

				$insertUser = insert('users',$saveUserData);
				if ($insertUser) {
					$this->sendEmail($email,$token);
					$respond['status'] = "success";
					$respond['msg'] = "Registration Success";
				} else {
					$respond['status'] = "error";
					$respond['msg'] = "Something went wrong";
				}

			} // End of ctr
			json($respond);
		}
	}

	public function thankyou() {
		$data['title'] = "Thank You Page";
		$this->load_page('thankyou',$data);
	}

	public function verifyToken($token) {
		$data['title'] = "Verify Email";
		$updateData = array(
			'set'	=> array(
				'is_verified' => 1,
			),
			'where' => array('verification_token' => $token),
		);
		$updateUser = $this->MY_Model->update('users',$updateData['set'],$updateData['where']);

		if ($updateUser) {
			$data['status'] = "success";
			$data['msg'] = "Verified Successfully!";
		} else {
			$data['status'] = "error";
			$data['msg'] = "Something went wrong with the verification";
		}

		$this->load_page('verify_token',$data);
	}

	public function testing() {
		$email = 'chrisnilavila@gmail.com';
		$token = 'c71df9fa5be32ef89165e23ab839020d';
		$test = $this->sendEmail($email,$token);
		echo '<pre>';
		print_r($test);
		exit;
	}

} // end of class