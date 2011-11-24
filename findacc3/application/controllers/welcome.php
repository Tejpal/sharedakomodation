<?php

class Welcome extends Controller {

	function Welcome()
	{
		parent::Controller();	
	}
	
	function index()
	{
		$this->load->helper(array('url'));	
		$data = array();
		
		// get 4 provider and 4 finder
		$this->load->model('ads_model');	
		$adslist	=	$this->ads_model->ads_home_list(4);
		
		
		if(isset($_COOKIE['username'])){
		$cookie1=$_COOKIE['username'];
		$this->load->model('user_model');
		$usercookie	=$this->user_model->cookie_check($cookie1);
		if($usercookie){
		$cookie2=$_COOKIE['userid'];
		$usercookieData	=$this->user_model->cookie2_check($cookie2);
		
				$this->session->set_userdata($usercookieData);
				redirect('/user/profile/', 'refresh');
			// get session request page				
				
				
		
		}
		}
		else
		{
			//	redirect('/user/profile/', 'refresh');
		
			$data['adslist'] = $adslist;
			//print_r($adslist);
			$this->load->view('header',$data);
			$this->load->view('welcome_message');
			$this->load->view('footer');
		}
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */