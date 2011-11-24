<?php

class Myads extends Controller {
	
	var $per_page = 5;
	
	var $current_page = 1;

	var $result = '';
	var $resultCount = 0;
	
	var $page_about = 0;	
	/*
		1 - manage ads
		2 - shortlisted ads
		3 - matching ads 	
	*/
	

	function Myads()
	{
		parent::Controller();	
	}
	
	function index()
	{
		//$this->load->view('welcome_message');
		
		$this->load->view('header');
		$this->load->view('welcome_message');
		$this->load->view('footer');		
		
	}
	

	// manage
	function manage($page=1,$total=0)
	{	if(!empty($_REQUEST['per_page'])){$offset=$_REQUEST['per_page'];
		$this->offset=$offset;
	}else{$this->offset=0;}
	
		//if(empty($_SESSION['user_id']))
		if(!$this->session->userdata('user_id'))
		{
			// redirect to login page
			//$msg = "You must loggedin to access your account.";
			$this->session->set_flashdata('alert',"<p id='notify_alert_signin_managead' class='alert_notify'>You must be signed in to access your account.</p>");
			//$_SESSION['request_page'] = '/myads/manage/';
			$this->session->set_userdata('request_page', '/myads/manage/');
			redirect('/user/signin/', 'refresh');
		}		

		
		$this->page_about = 1;
		$this->current_page = $page;
		$this->resultCount = $total;
		
		
		
		
		
		$this->result();
		$this->display();		
	}
	
	

	// shortlisted
	function shortlisted($page=1,$total=0)
	{	if(!empty($_REQUEST['per_page'])){$offset=$_REQUEST['per_page'];
		$this->offset=$offset;
	}else{$this->offset=0;}
			
		$this->page_about = 2;
		$this->current_page = $page;
		$this->resultCount = $total;
		
		$this->result();
		$this->display();		
	}

	// matching
/*	function matching($page=1,$total=0)
	{	if(!empty($_REQUEST['per_page'])){$offset=$_REQUEST['per_page'];
		$this->offset=$offset;
	}else{$this->offset=0;}
		
		
		$this->page_about = 3;
		$this->current_page = $page;
		$this->resultCount = $total;
	
		
		$this->result();
		$this->display();		
	}	
*/	
	
	// result
	function result($offset=0)
	{
		$offset=$this->offset;
		
		$this->load->library('pagination');
		
		$result_per_page = 10;
	
		$this->load->model('ads_model');	
		
		$filters = array();
	
		$filters['page_about'] = $this->page_about;
		$filters['per_page'] = $this->per_page;
		$filters['current_page'] = $this->current_page;
		
		$filters['per_page'] =$result_per_page; 
		$filters['offset'] =$offset;
		
		
		// first find total records
		
		$total_rows = $this->ads_model->filter_myadsCount($filters);
		if(!empty($total_rows)){
		$baseurl = site_url() . '/';
		$config['base_url'] = $baseurl.'myads/manage/?';
		$config['per_page'] = $result_per_page;
		$config['total_rows']=$total_rows;
		$config['num_links'] = 2;
		$config['prev_link'] = 'Prev';
		$config['next_link'] = 'Next';
		$config['first_link'] = False;
		$config['last_link'] = False;
		
		$this->pagination->initialize($config);
		}
		
		
		// now find current page records data
		$this->result = $this->ads_model->filter_myads($filters);
		$data['result'] = $this->result;
		//print_r($data);exit;
		
		 
		/*//adsviewcount ----not working
		$ads_id=$data['result'][0]['ads_id'];
		$this->vcount=$this->ads_model->adsviewscount($ads_id);
		$data['result'] = $this->vcount;
		*/
		}
		
	
	
	// display
	function display()
	{
		//$this->output->enable_profiler(TRUE);
		$data = array();
		if($this->page_about==1){
			$this->assetlibpro->add_css('css/signin.css');
			$this->assetlibpro->add_css('css/switchAccount.css');
			$this->assetlibpro->add_css('css/accountSettings.css');
			$this->assetlibpro->add_css('css/myPostedAds.css');
			//$this->assetlibpro->add_css('css/pagination.css');
			
			$data['tabon'] = 5;
		} else if($this->page_about==2){
			$this->assetlibpro->add_css('css/shortlistedAds.css');
			$this->assetlibpro->add_css('css/listing.css');
			$this->assetlibpro->add_css('css/accountSettings.css');
			//$this->assetlibpro->add_css('css/myPostedAds.css');
			//$this->assetlibpro->add_css('css/pagination.css');	
			$data['tabon'] = 6;			
		}
		else
		{
			$this->assetlibpro->add_css('css/signin.css');
			$this->assetlibpro->add_css('css/switchAccount.css');
			$this->assetlibpro->add_css('css/accountSettings.css');
			$this->assetlibpro->add_css('css/myPostedAds.css');
			//$this->assetlibpro->add_css('css/pagination.css');		
		}
		
		$this->assetlibpro->add_css('css/pagination.css');	
		
		
	
		//if(isset($_SESSION['user_id'])){
		if($this->session->userdata('user_id')){
	    //$uid=$_SESSION['user_id'];
	    $uid=$this->session->userdata('user_id');
		$this->load->model('user_model');
		$this->result1=$this->user_model->myinboxcount($uid);
		$data1['result1']=$this->result1;
		//$this->load->view('header',$data1);
		}
		
		
		
		$data['page_about'] = $this->page_about;
		$data['result'] = $this->result;
		$count=count($data['result']);
		
		//adsviewcount 
		for ($i=0;$i<$count;$i++)
		{
			if(isset($data['result'][$i]['ads_id']))
			{
			$ads_id=$data['result'][$i]['ads_id'];
			$this->vcount=$this->ads_model->adsviewscount($ads_id);
			$data['result'][$i]['views'] = $this->vcount;
			}
		}
		
		//adsviewcount 
		for ($i=0;$i<$count;$i++)
		{
			if(isset($data['result'][$i]['ads_id']))
			{
			$ads_id=$data['result'][$i]['ads_id'];
			$this->ccount=$this->ads_model->adscontactcount($ads_id);
			$data['result'][$i]['contact'] = $this->ccount;
			}
		}
		
		
		$newData = array_merge($data, $data1);
		
		//if(!isset($_SESSION['user_id'])){
		$this->load->view('header',$newData);
		if ($this->page_about==1)
		{	$this->load->view('myads_manage_display');}
		else if ($this->page_about==2)
			{$this->load->view('myads_shortlisted_display');}
		else if ($this->page_about==3)
			{$this->load->view('myads_matching_display');}
			
		else
			{$this->load->view('myads_manage_display');			}
		$this->load->view('footer');		
		
	}	
	
	
	// extend ad
	function extendad($adsid='',$c)
	{
		$this->load->helper('url');
		
		$data = array();
		$data['id']=$adsid;
		$data['c']=$c;
		
		$this->load->model('user_model');
		
		$extendradio=$this->input->post('extendradio');
		if($extendradio==1)
		{
		
		$this->user_model->activatead($adsid);
		$this->user_model->extendad($adsid);
		}
		
		$this->result21=$this->user_model->get_title($adsid);
		$data['title']=$this->result21;
		$this->session->set_flashdata('success','You have successfully extended your ad');
	$this->load->view('extend_ad',$data);
	}
	
	//delete ad
	function deletead($adsid='',$userid='')
	{
	$this->load->model('user_model');
	$this->user_model->delete_ad($adsid);
	$this->user_model->delete_ad_images($adsid);
	$this->load->helper('url');
	redirect('myads/manage');
	}
	
	// activate ad
	function activatead($id='',$c='',$days)
	{
		$ads_id=$id;
		$data=array();
		$data['days']=$days;
		$data['id']=$id;
		$data['c']=$c;
		$this->load->helper('url');
		$this->load->model('user_model');
		if(isset($_POST['activatead']))
		{
		$this->user_model->activatead($ads_id);
		}
		$this->result21=$this->user_model->get_title($ads_id);
		$data['title']=$this->result21;
	 	$this->session->set_flashdata('success','You have successfully activated your ad');
		$this->load->view('activatead',$data);
	}
	
	// De-activate ad
	function deactivatead($id='',$c='',$days='')
	{
		$ads_id=$id;
		$data=array();
		$data['days']=$days;
		$data['id']=$id;
		$data['c']=$c;
		$this->load->helper('url');
		$this->load->model('user_model');
		if(isset($_POST['deactivatead']))
			{
		$this->user_model->deactivatead($ads_id);
			}
		$this->result21=$this->user_model->get_title($ads_id);
		$data['title']=$this->result21;
		$this->session->set_flashdata('success','You have successfully de-activated your ad');
	$this->load->view('deactivatead',$data);
	}
	
	
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */