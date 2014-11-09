<?php

class Users extends CI_Controller{


	public function register(){
		// validation rules
		$this->form_validation->set_rules('first_name','First Name', 'trim|required');
		$this->form_validation->set_rules('last_name','Last Name', 'trim|required');
		$this->form_validation->set_rules('email','Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('username','Username', 'trim|required|min_lenght[4]|max_length[16]');
		$this->form_validation->set_rules('password','Password', 'trim|required|min_lenght[4]|max_length[50]');
		$this->form_validation->set_rules('password2','Confirm Password', 'trim|required|matches[password]');
		
		if($this->form_validation->run() == FALSE){
			//show view
			$data['main_content'] = 'register';
			$this->load->view('layouts/main', $data);
		} else {
			if($this->user_model->register()){
				$this->session->set_flashdata('registered', 'You are now registered and can login.');
				redirect('products');
			}
		}
	}
}