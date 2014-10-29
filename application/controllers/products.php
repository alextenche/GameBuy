<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends CI_Controller {

	public function index()
	{
		$data['name'] = 'Mike';
		// load view
		$data['main_content'] = 'products';
		$this->load->view('layouts/main', $data );
		
	}
	
}
