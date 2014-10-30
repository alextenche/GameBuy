<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends CI_Controller {

	public function index(){
		// get all products
		$data['products'] = $this->product_model->get_products();



		// load view
		$data['main_content'] = 'products';
		$this->load->view('layouts/main', $data );
		
	}
	
}
