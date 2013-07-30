<?php

#Template.php Library

class Template {
	
    public function load($view, $title = 'Untitled')
    {
		//get load
		$CI =& get_instance();
		
		//set data title
		$data['title'] = $title;

		//load header view
		$CI->load->view('_template/header', $data); 

		//load dynamic view
		$CI->load->view($view); 

		//load footer view
		$CI->load->view('_template/footer');
    }
}

// ---------------------------------------

#Controller

class Home extends CI_Controller {
	
	public function index()
	{
		$this->load->library('template');
		$this->template->load('view');
	}
}