<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Characters extends MY_Controller {

	public function __construct() {
		if(!$_SESSION['is_logged'] && !$_SESSION['is_verified']){
			$this->session->set_flashdata('error','A valid user account is required to see the landing page.');
			redirect(base_url('login'));
		}
	}

	public function index(){
		$data['title'] = "Character Listing Page";
		$this->load_page('index',$data);
	}

	public function listingPeople() {
		$respond = array();
		$itemsPerPage = 10;
		$currentPage = $this->input->post('page');
		$list = json_decode($this->getPeople(array('page' => $currentPage)), true);
		$totalPages = ceil( ($list ? $list['count'] : 10) / $itemsPerPage);
		$currentPage = max(1, min($currentPage, $totalPages));
		$cards = '';
		$pagination = '';

		$next = ($currentPage != 1) ? preg_replace('/https:\/\/swapi\.dev\/api\/people\/\?page=(\d+)/','$1',$list['next']) : "";
		$prev = ($currentPage != $totalPages) ? preg_replace('/https:\/\/swapi\.dev\/api\/people\/\?page=(\d+)/','$1',$list['previous']) : "";

		if($list && is_array($list['results'])) {
			foreach( $list['results'] as $key => $value ){
				$id = preg_replace('/https:\/\/swapi\.dev\/api\/people\/(\d+)\/$/','$1',$value['url']);
				$cards .= "
					<div class='col-md-3 col-sm-6 mb-4'>
						<div class='card text-center'>
							<div class='card-body'>
								<p>".$id."</p>
								<p>".ucwords($value['name'])."</p>
								<p>".ucwords($value['gender'])."</p>
								<a href='".base_url('characters/'.$id)."' class='btn btn-outline-secondary'>View More</a>
							</div>
						</div>
					</div>
				";
			}
		}

		if($currentPage != 1) {
			$pagination .= "
			<li class='page-item'>
				<a class='page-link' data-page='{$prev}' href='javascript:void(0);' aria-label='Previous'>
					<span aria-hidden='true'>&laquo;</span>
				</a>
			</li>";
		}
		
		for ($i = 1; $i <= $totalPages; $i++) {
			$pagination .= "<li class='page-item'><a class='page-link' data-page='".$i."' href='javascript:void(0)'".($i == $currentPage ? ' class="active"' : '').">".$i."</a></li>";
		}

		if($currentPage != $totalPages) {
			$pagination .= "<li class='page-item'>
				<a class='page-link' data-page='{$next}' href='javascript:void(0);' aria-label='Next'>
					<span aria-hidden='true'>&raquo;</span>
				</a>
			</li>";
		}

		$respond['cards'] 		= $cards;
		$respond['pagination']	= $pagination;

		json($respond);
		
	}

	public function listSavedCharacter() {
		$respond = array();
		$limit = 10;
		$currentPage = $this->input->post('page');
		$offset = ($currentPage - 1) * $limit;

		$options = array(
			'select'	=> "id,character_id,json_data,created",
			'where'		=> array("user_id" => $_SESSION['user_id'], "status" => 1),
			'order'		=> 'character_id DESC'
		);
		$getCount = $this->MY_Model->getRows('save_characters',$options,'count');
		$options['limit'] = array($limit,$offset);
		$fetchData = $this->MY_Model->getRows('save_characters',$options,'obj');

		$totalPages = ceil( ($getCount ? $getCount : 10) / $limit);
		$currentPage = max(1, min($currentPage, $totalPages));
		$cards = '';
		$pagination = '';

		$hasNextPage = $currentPage < $totalPages;
		$hasPreviousPage = $currentPage > 1;
		$nextPage = $hasNextPage ? $currentPage + 1 : null;
		$previousPage = $hasPreviousPage ? $currentPage - 1 : null;

		if($fetchData) {
			foreach( $fetchData as $key => $value ){
				$json_data = json_decode($value->json_data,true);
				$cards .= "
					<div class='col-md-3 col-sm-6 mb-4'>
						<div class='card text-center'>
							<div class='card-body'>
								<p>".$value->character_id."</p>
								<p>".ucwords($json_data['name'])."</p>
								<p>".ucwords($json_data['gender'])."</p>
								<a href='".base_url('characters/'.$value->character_id)."' class='btn btn-outline-secondary'>View More</a>
							</div>
						</div>
					</div>
				";
			}

			if($currentPage != 1) {
				$pagination .= "
				<li class='page-item'>
					<a class='page-link' data-page='{$previousPage}' href='javascript:void(0);' aria-label='Previous'>
						<span aria-hidden='true'>&laquo;</span>
					</a>
				</li>";
			}
			
			for ($i = 1; $i <= $totalPages; $i++) {
				$pagination .= "<li class='page-item'><a class='page-link' data-page='".$i."' href='javascript:void(0)'".($i == $currentPage ? ' class="active"' : '').">".$i."</a></li>";
			}

			if($currentPage != $totalPages) {
				$pagination .= "<li class='page-item'>
					<a class='page-link' data-page='{$nextPage}' href='javascript:void(0);' aria-label='Next'>
						<span aria-hidden='true'>&raquo;</span>
					</a>
				</li>";
			}
		} else {
			$cards .= "
			<p class='text-center'>No Saved Character(s)</p>
			";
		}

		$respond['cards'] 		= $cards;
		$respond['pagination']	= $pagination;

		json($respond);
	}

	public function viewCharacter($id) {
		$data['title'] = "View Character Page";
		$data['character'] = json_decode($this->getPeople(array('view_character' => $id)), true);
		$data['character_id'] = $id;
		$_SESSION['temp_character'] = json_encode($data['character']);

		$options = array(
			'select'	=> "id",
			'where'		=> array("user_id" => $_SESSION['user_id'], "character_id" => $id, "status" => 1)
		);
		$fetchData = $this->MY_Model->getRows('save_characters',$options,'obj');
		$data['is_saved'] = $fetchData ? $fetchData[0] : 0;
		$this->load_page('view_character',$data);
	}

	public function savedCharacters() {
		$data['title'] = "Saved Characters Page";

		$this->load_page('saved_character',$data);
	}

	public function saveUserCharacter() {
		$respond = array();
        if (isset($_POST)) {

			$user_id		= $_SESSION['user_id'];
			$json_data		= $_SESSION['temp_character'];
			$character_id	= trim($this->input->post('character_id'));
			

			$saveCharacterData = array(
				'user_id'		=> $user_id,
				'character_id'	=> $character_id,
				'json_data' 	=> $json_data
			);

			$saveCharacter = insert('save_characters',$saveCharacterData);
			if ($saveCharacter) {
				$this->session->set_flashdata('update_flash', 'Character saved for later use');
				$respond['status'] = "success";
				$respond['msg'] = "Saved Character Success";
			} else {
				$respond['status'] = "error";
				$respond['msg'] = "Something went wrong";
			}

			json($respond);
		}
	}

	public function removeUserCharacter() {
		$respond = array();
        if (isset($_POST)) {

			$id	= trim($this->input->post('save_id'));
	
			$updateData = array(
				'set'	=> array(
					'status' => 0,
				),
				'where' => array('id' => $id),
			);
			$updateUserCharacter = $this->MY_Model->update('save_characters',$updateData['set'],$updateData['where']);

			if ($updateUserCharacter) {
				$this->session->set_flashdata('update_flash', 'Character deleted from saved list.');
				$respond['status'] = "success";
				$respond['msg'] = "Character saved Removed Successfully";
			} else {
				$respond['status'] = "error";
				$respond['msg'] = "Something went wrong";
			}
			json($respond);
		}
	}

	private function getPeople($params = array()) {
		$data = array();

		$page = isset($params['page']) ? $params['page'] : 1;
		// Fetch People API
		$apiUrl = isset($params['view_character']) ? "https://swapi.dev/api/people/".$params['view_character'] : "https://swapi.dev/api/people/?page=".$page;
		
		$curl = curl_init($apiUrl);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);
		curl_close($curl);
		if($response) {
			$data = $response;
		}

		return $data;
	}
} // End of Class
