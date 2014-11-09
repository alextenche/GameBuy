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
		$this->load->view('layouts/main', $data);
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
	
	
	// update cart
	public function update($in_cart = null){
		$data = $_POST;
		$this->cart->update($data);
		
		// show cart page
		redirect('cart', 'refresh');
	}
	
	
	// process form
	public function process(){
		if($_POST){
			print_r($this->input->post('item_name'));die();
			foreach($this->input->post('item_name') as $key => $value){
				// get tax & shipping from config
				$this->tax = $this->config->item('tax');
				$this->shipping = $this->config->item('shipping');
			
				$item_id = $this->input->post('item code')[$key];
				$product = $this->product_model->get_product_details($item_id);
				
				// assign data to paypal
				                       
				$this->paypal_data .= '&L_PAYMENTREQUEST_0_NAME'.$key.'='.urlencode($product->title);
				$this->paypal_data .= '&L_PAYMENTREQUEST_0_NUMBER'.$key.'='.urlencode($item_id);
				$this->paypal_data .= '&L_PAYMENTREQUEST_0_AMT'.$key.'='.urlencode($product->price);
				$this->paypal_data .= '&L_PAYMENTREQUEST_0_QTY'.$key.'='.urlencode($this->input->post('item_qty')[$key]);
				
				// price x quantity
				$subtotal = ($product->price * $this->input->post('item_qty')[$key]);
				$this->total = $this->total + $subtotal;
				
				$paypal_product['items'][] = array(
					'itm_name'   => $product->title,
					'itm_price'  => $product->price,
					'itm_code'   => $item_id,
					'itm_qty'    => $this->input->post('item_qty')[$key]
				);
				
				// create order array
				$order_data = array(
					'product_id'      => $item_id,
					'user_id'         => $this->session->userdata('user_id'),
					'transaction_id'  => 0,
					'qty'             => $this->input->post('item_qty')[$key],
					'price'           => $subtotal,
					'address'         => $this->input->post('address'),
					'address2'        => $this->input->post('address2'),
					'city'            => $this->input->post('city'),
					'state'           => $this->input->post('state'),
					'zipcode'         => $this->input->post('zipcode')
				);
				
				// add order data
				$this->product_model->add_order($order_data);
			}
			
			// get the grand total
			$this->grand_total = $this->total + $this->tax + $this->shipping;
			
			// create array of costs
			$paypal_product['assets'] = array(
				'tax_total'      => $this->tax,
				'shipping_cost'  => $this->shipping,
				'grand_total'    => $this->total
			);
			
			// session array for later
			$_SESSION["paypal_products"] = $paypal_product;
			
			// send paypal params
			$padata = '&METHOD=SetExpressCheckout'.
				'&RETURNURL='.urlencode($this->config->item('paypal_return_url')).
				'&CANCELURL='.urlencode($this->config->item('paypal_cancel_url')).
				'&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE").$this->paypal_data.
				'*NOSHIPPING=0'.
				'&PAYMENTREQUEST_0_ITEMAMT='.urlencode($this->total).
				'&PAYMENTREQUEST_0_TAXAMT='.urlencode($this->tax).
				'&PAYMENTREQUEST_0_SHIPPINGAMT='.urlencode($this->shipping).
				'&PAYMENTREQUEST_0_AMT='.urlencode($this->grand_total).
				'&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($this->config->item('paypal_currency_code')).
				'&LOCALECODE=GB'. // paypal pages to match the language on your website.
				'&LOGOIMG=http://www.techguystaging.com/demofiles/logo.png'. // custom logo
				'&CARTBORDERCOLOR=FFFFFF'.
				'&ALLOWNOTE=1';
			
			// execute "SetExpressCheckout"
			$httpParsedResponseAr = $this->paypal->PPHttpPost('SetExpressCheckout', $padata, $this->config->item('paypal_api_username'), $this->config->item('paypal_api_password'), $this->config->item('paypal_api_signature'));
			
			// respond according to message we receive from paypal
			if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])){
				// redirect user to PayPal store with token received
				$paypal_url = 'https://www.paypal.com/cgi-bin/websrc?cmd=_express-ceheckout&token'.$httpParsedResponseAr["TOKEN"].'';
				header('Location: '.$paypal_url);
			} else {
				// show error message
				print_r($httpParsedResponseAr);
				die(urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]));
			}
			
		}
		
		// PayPal redirects back to this page using ReturnURL, we should receive TOKEN Payer ID
		if(!empty($this->input->get('token'))&& !empty($this->input->get('PayerID'))){
			// we will be using these two variables to execute the "DoExpressCheckoutPayement"
			// Note: we haven't receive any apyment yet
			
			$token = $this->input->get('token');
			$payer_id = $this->input->get('PayerID');
			
			// get session info
			$paypal_product = $SESSION["paypal_products"];
			$this->paypal_data = '';
			$total_price = 0;
			
			// loop through session array
			foreach($paypal_product['items'] as $key => $item){
				$this->paypal_data .= '&L_PAYMENTREQUEST_0_QTY'.$key.'='.urlencode($item['itm_qty']);
				$this->paypal_data .= '&L_PAYMENTREQUEST_0_ATM'.$key.'='.urlencode($item['itm_price']);
				$this->paypal_data .= '&L_PAYMENTREQUEST_0_NAME'.$key.'='.urlencode($item['itm_name']);
				$this->paypal_data .= '&L_PAYMENTREQUEST_0_NUMBER'.$key.'='.urlencode($item['itm_code']);
				
				// get subtotal
				$subtotal = ($item['itm_price']*$item['itm_qty']);
				
				// get total
				$total_price = ($total_price + $subtotal);
			}
			
			$padata = '&TOKEN='.urlencode($token).'&PAYERID='.urlencode($payer_id);
		}
		
	}
	
	
	
	
	
	
	
}