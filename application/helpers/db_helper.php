<?php

// get categories
function get_categories_h(){
	$CI = get_instance();
	$categories = $CI->product_model->get_categories();
	return $categories;
}


// get sidebar most popular
function get_popular_h(){
	$CI = & get_instance();
	$CI->load->model('product_model');
	$popular_products = $CI->product_model->get_popular();
	return $popular_products;
}