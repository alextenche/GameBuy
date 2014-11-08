<?php

class Cart extends CI_Controller{
	public $paypal_data = '';
	public $tax;
	public $shipping;
	public $total = 0;
	public $grand_total;
	
	// cart index
	public function index(){
		// load view
		$data['main_content'] = 'cart';
		$this->load->view('layout/main', $data);
	}
	
	
	// add to cart
	public function add(){
		// item data
		$data = array(
               'id'      =>	$this->input->post('item_number'),
               'qty'     => $this->input->post('qty'),
               'price'   => $this->input->post('price'),
               'name'    => $this->input->post('title'),
		);
		
		//print_r($data);die();

		
		// insert into cart
		$this->cart->insert($data);
		
		redirect('products');
	}
}